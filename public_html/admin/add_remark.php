<?php session_start(); 
error_reporting(1);
include_once $_SERVER['DOCUMENT_ROOT'] . '/../lib/User.class.php';
$u = new User($_SESSION['user_id']);
if(!empty($_POST)){
$user_id = $u->addResumeRemark($_POST);
echo $user_id;

}
exit;

?>
