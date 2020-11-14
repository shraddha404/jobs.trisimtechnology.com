<?php session_start(); include_once ('includes/php_header.php');
//echo $_POST['drop_values'];
if(!empty($_POST)){
if($_POST['drop_values']=="drop")
{
    $u->updateEducationDetails($_POST);
}
else{
 
$user_id = $u->addEducation($_POST);
 }
}
//echo $user_id;

exit;

?>
