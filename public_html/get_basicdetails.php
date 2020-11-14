<?php session_start(); include_once ('includes/php_header.php');

if(!empty($_POST)){

//fetch basic details
$row = $u->getUserDetails($_POST['id']); //echo $_POST['id'];
$row=$row[0];

$job_location=explode(',',$row['preferred_job_location']);
//echo $job_location[0];

if(empty($row['profile_name']))
{
    $row['profile_name']=$row['first_name']." ".$row['middle_name']." ".$row['last_name'];
}
if(!empty($row['domain']))
{
    $_SESSION['domain']=$row['domain'];
    
    
}
if(!empty($row['is_experienced']) && $row['is_experienced']=='no')
{
   $row['is_experienced']='Fresher';
}
if(!empty($row['is_experienced']) && $row['is_experienced']=='yes')
{
   $row['is_experienced']='Experienced';
}
      echo json_encode(array('profile_name' =>$row['profile_name'],'current_ctc_lakhs' => urldecode($row['current_ctc_lakhs']),'current_ctc_thousands' => $row['current_ctc_thousands'],'work_exp_years' => urldecode($row['work_exp_years']),'work_exp_months' => $row['work_exp_months'],'mobile_number' => $row['mobile_number'],'city' => $row['city'],'email' => urldecode($row['email']),
          'profile_photo' => $row['profile_photo'],'id' => $row['id'],'expected_salary' =>urldecode($row['expected_salary']),'expected_designation' =>urldecode($row['expected_designation']),'achivements' =>urldecode($row['achivements']),'username' => urldecode($row['username']),'gender' =>$row['gender'],'skills_expertise' => urldecode($row['skills_expertise']),'job_location1' => $job_location[0],'job_location2' => $job_location[1],'job_location3' => $job_location[2],'is_experienced'=> $row['is_experienced'],'domain'=>$row['domain']));  
}
exit;

?>
