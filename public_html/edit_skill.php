<?php session_start(); include_once ('includes/php_header.php');

if(!empty($_POST)){

//Insert basic details
//echo $_POST['id'],$_POST['user_id'];
//$row = $u->getUserSkillsById($_POST['id']);
  
    $row = $u->getUserSkillsToolsById($_POST['id']);
      //$skill_id=explode(',',$row['skill_id']);
      //echo count($skill_id);exit;
    //$tool_id=explode(',',$row['tool_id']);

//echo $row['skill_id']
     // echo json_encode(array('skill_id'=>$row['skill_id'],'skill_name'=>$row['name'],'version' => $row['version'],'last_used' => $row['last_used'],'experience_year' => $row['experience_year'],'experience_month'=> $row['experience_month'],'proficiency_level' => $row['proficiency_level'],'id' => $row['id'],'us_id'=>$row['us_id']));    
             echo json_encode(array('skill_id'=>$row['skill_id'],'tool_id'=>$row['tool_id'],'version' => $row['version'],'last_used' => $row['last_used'],'source_of_learning' => $row['source_of_learning'],'proficiency_level' => $row['proficiency_level'],'operating_systems' => $row['operating_systems'],'id' => $row['id'],'us_id'=>$row['id']));    
        
}
exit;

?>