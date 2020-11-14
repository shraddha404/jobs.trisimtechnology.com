<?php session_start(); include_once ('includes/php_header.php');

 //print_r($_POST);
if($_POST["id"] != '')  
 { 
//Update basic details
$user_id = $u->UpdateEmployment($_POST);

echo $user_id;

}else {

//Insert basic details


$user_id = $u->addEmployment($_POST);

echo $user_id;

}
exit;

?>
