<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/../lib/User.class.php';
if (empty($_SESSION['user_id'])) {
    header('Location:/login.php');
}
$u = new User($_SESSION['user_id']);
$users = $u->getUsersExport();
//var_dump($users);exit;

if(empty($users)){
echo "<script type=\"text/javascript\"> alert ('No data found'); window.history.go(-1);</script>";
}else{
$filename=date('Y-m-d')."user_details.xls";
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

foreach($users as $user){
   if(empty($user['current_ctc']))
   {
       $user['current_ctc']=0;
       
   }
   if(empty($user['work_exp_years']))
   {
      $user['work_exp_years']=0;
       
   }
$content .= stripslashes($user['id']). "\t";
$content .= stripslashes($user['first_name']." ".$user['middle_name']." ".$user['last_name']). "\t";
$content .= stripslashes($user['email'])."\t";
$content .= stripslashes($user['mobile_number']). "\t";
$content .= stripslashes(urldecode($user['work_exp_years'])). " years \t";
$content .= stripslashes(urldecode($user['expected_salary'])). " \t";
$content .= stripslashes($user['organization']). "\t";
$content .= stripslashes($user['current_ctc']). " L \t";
$content .= "\n";
    }



$title .= "User Id \t Name \t Email \t Mobile Number \t Work Experience Year \t Expected Salary \t Current Company  \t Current CTC"."\n";
echo $title;
echo $content;


}

?>
