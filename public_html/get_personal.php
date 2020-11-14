<?php session_start(); include_once ('includes/php_header.php');

if(!empty($_POST)){
    //print_r($_POST);
//fetch basic details
$row = $u->getUserDetails($_POST['id']);
$row=$row[0];
      echo json_encode(array('date_of_birth' => $row['date_of_birth'],'permanent_address' => $row['permanent_address'],'current_address' => $row['current_address'],'pin_code' => $row['pin_code'],'passport_number' => $row['passport_number'],'user_id' => $row['user_id']));  
}
exit;

?>


