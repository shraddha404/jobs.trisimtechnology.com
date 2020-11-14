<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/User.class.php';
$u = new User($_SESSION['user_id']);

if($_GET['id_no']) 
{

$userDetails = $u->userfileDetails($_GET['id_no']);


$id=$_GET['id_no'];
//$name=$userDetails['first_name']."_".$userDetails['last_name'];
$name=$userDetails['resume_file_name'];
//echo $name;exit;
//echo $id;exit;
$pdf = $userDetails['resume_file_data'];

header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=".$name."");
echo $pdf;




}

?>
