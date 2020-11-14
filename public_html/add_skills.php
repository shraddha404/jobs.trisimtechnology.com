<?php session_start(); include_once ('includes/php_header.php');
 //print_r($_POST);exit;
if($_POST["us_id"] == '')  {

//Insert basic details
    

//$user_id = $u->addSkills($_POST);
   
   // echo $_POST['skill_id'];exit;
$user_id = $u->addSkillsTools($_POST);

//echo $user_id;
}
else{
    $user_id = $u->UpdateSkillsTools($_POST);
}
exit;

?>
