<?php session_start(); include_once ('includes/php_header.php');
if(!empty($_POST)){
//Insert basic details
//echo $_POST['id'],$_POST['user_id'];
$row = $u->getUserToolsById($_POST['id']);
//print_r($row);
      echo json_encode(array('tool_id'=>$row['tool_id'],'tool_name'=>$row['name'],'version' => $row['version'],'last_used' => $row['last_used'],'knowledge_source' => $row['knowledge_source'],'proficiency_level' => $row['proficiency_level'],'id' => $row['id'],'us_id'=>$row['us_id']));    
               
}
exit;

?>