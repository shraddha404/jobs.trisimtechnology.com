<?php session_start(); include_once ('includes/php_header.php');
if($_POST["idheadline"] != '')  
 { 
//Update basic details
$user_id = $u->UpdateResumeHeadline($_POST);

echo $user_id;

}else {

//Insert basic details


$user_id = $u->addResumeHeadline($_POST);

echo $user_id;

}
exit;

?>
