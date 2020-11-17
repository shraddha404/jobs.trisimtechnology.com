<?php session_start(); 
error_reporting(1);
include_once $_SERVER['DOCUMENT_ROOT'] . '/../lib/User.class.php';
$u = new User($_SESSION['user_id']);
if(!empty($_POST)){
$row = $u->getUserResumeRemark($_POST['id']);
$row=$row[0];
echo json_encode(array('remark' => $row['remark'],'user_id' => $row['user_id'])); 
}
exit;

?>
