<?php session_start(); include_once ('includes/php_header.php'); 
//echo 'hi';exit;
//$user_id = $u->addEducation($_POST);

if(!empty($_POST)){
    if($_POST['update']=='update'){

    $u->updateEducationDetails($_POST);
}
else{
 
$user_id = $u->addEducation($_POST);
 }
}
exit;

?>