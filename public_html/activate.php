<?php  include_once ('includes/php_header.php');
include_once ('includes/header.php'); 
if (isset($_GET["id"])) {
  $id = intval(base64_decode($_GET["id"]));
 
 		 $msg = $u->resgistrationActivation($id);
                 header("Location:login.php?msg=$msg");
}

//echo $msg;
