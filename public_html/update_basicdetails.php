<?php session_start(); include_once ('includes/php_header.php');
//print_r($_FILES);
$posts= (explode("&",$_POST['post']));
 //console.log($_POST);
$arr=array();
$result=array();
foreach($posts as $post){
$a= explode("=",$post);

foreach($a as $key => $value) {// echo $key;
        $keyval = array($a[0] => $a[1] );


    }
        array_push($arr,$keyval);
}
//$arr = array_values($arr);
array_walk_recursive($arr, function($v, $k) use (&$result){ $i = ""; for (; isset($result[$k."$i"]); $i++); $result[$k."$i"] = $v; });


//print_r($result);
if(!empty($_POST)){

//Insert basic details
    //echo 'hi';

$user_id = $u->updateBasicDetails($result,$_FILES['file']);

//echo $user_id;
}
exit;

?>
