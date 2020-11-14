<?php session_start(); include_once ('includes/php_header.php');

if($_POST["user_id"] != '')  {

//Insert basic details
    //print_r($_POST);

$user_id = $u->addPersonal($_POST);

echo $user_id;
}
exit;

