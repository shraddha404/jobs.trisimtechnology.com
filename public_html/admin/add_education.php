<?php session_start(); include_once ('includes/php_header.php');

if(!empty($_POST)){

//Insert basic details

$user_id = $u->addEducation($_POST);

echo $user_id;
}
exit;

?>
