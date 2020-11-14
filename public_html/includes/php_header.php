<?php session_start();
/*if (!isset($_SESSION['EXPIRES']) || $_SESSION['EXPIRES'] < time()+3600) {
    session_destroy();
    $_SESSION = array();
}
$_SESSION['EXPIRES'] = time() + 300;
* */
error_reporting(0); // Disable all errors.

include_once $_SERVER['DOCUMENT_ROOT']."/../lib/User.class.php";
$u = new User($_SESSION['user_id']);
if($u->isAdmin()){
include_once $_SERVER['DOCUMENT_ROOT']."/../lib/Admin.class.php";
$u = new Admin($_SESSION['user_id']);
}
?>
