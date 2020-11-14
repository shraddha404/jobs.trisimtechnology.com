<?php
 session_start(); include_once ('includes/php_header.php');
 
 //echo $_POST['username'];exit;
 
 if(!empty($_POST['username'])){

//fetch basic details
$user_count = $u->checkUsername($_POST['username']); //echo $_POST['id'];
if( $user_count>0)
{
echo 'exist';
}
else
{
echo 'not';
}



      //echo json_encode(array('profile_name' =>$row['profile_name'],'current_ctc_lakhs' => $row['current_ctc_lakhs'],'current_ctc_thousands' => $row['current_ctc_thousands'],'work_exp_years' => $row['work_exp_years'],'work_exp_months' => $row['work_exp_months'],'mobile_number' => $row['mobile_number'],'city' => $row['city'],'email' => urldecode($row['email']),'profile_photo' => $row['profile_photo'],'id' => $row['id']));  
}
exit;




