<?php session_start(); include_once ('includes/php_header.php');
 //print_r($_POST);
if($_POST["tooledit_id"] == '')  {

//Insert basic details
    
//echo "inside";
$user_id = $u->addTools($_POST);

//echo $user_id;
}
else{
    //echo "update";
    $user_id = $u->UpdateTools($_POST);
}
exit;

?>

