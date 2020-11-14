<?php session_start(); include_once ('includes/php_header.php');

if(!empty($_POST)){

//Insert basic details

$row = $u->getUserResumeHeadlineDetails($_POST['id']);

$row=$row[0];
      echo json_encode(array('resume_headline' => $row['resume_headline'],'user_id' => $row['user_id']));  
}
exit;

?>
