<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/../lib/User.class.php';
if (empty($_SESSION['user_id'])) {
    header('Location:/login.php');
}
$u = new User($_SESSION['user_id']);

$jobs = $u->getJobsExport();

if(empty($jobs)){
echo "<script type=\"text/javascript\"> alert ('No data found'); window.history.go(-1);</script>";
}else{
$filename=date('Y-m-d')."jobs_details.xls";
# output headers so that the file is downloaded rather than displayed
        header("Content-Type: application/xls");
        //header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        # Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        # Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        # Disable caching - Proxies
        header("Expires: 0");
        
         
# Start the ouput


$content = '';
$title = '';

foreach($jobs as $user){
 $posted_by = $u->userDetails($user['posted_by']);
$content .= stripslashes($user['id']). "\t";
$content .= stripslashes($user['job_name']). "\t";
$content .= stripslashes($user['location'])."\t";
$content .= stripslashes($user['company_name']). "\t";
$content .= stripslashes(urldecode($user['designation'])). " years \t";
$content .= stripslashes(urldecode($user['description'])). " \t";
$content .= stripslashes($user['posted_on']). "\t";
$content .= stripslashes($posted_by['first_name']). "  \t";
$content .= stripslashes($user['count']). " \t";
$content .= "\n";
    }



$title .= "User Id \t Job Name \t Location \t Company Name \t Designation \t Description \t Posted On  \t Posted By  \t Responses Received"."\n";
echo $title;
echo $content;


}

?>
