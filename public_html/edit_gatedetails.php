<?php session_start(); include_once ('includes/php_header.php');

//$_SESSION["drop"] = "down";

if(!empty($_POST)){
//Insert basic details
$row = $u->getEducationDetails($_POST['id']);
$row_subject = $u->getEducationSubjectDetails($_POST['id']);
echo json_encode(array('education'=>'GATE','domain' => $row['GATE'][0]['domain'],'All_India_Rank' => $row['GATE'][0]['all_india_score'],'Year_of_passing' =>$row['GATE'][0]['year_of_passing']));  

//echo json_encode(array('education'=>'GATE','domain' => $row['GATE'][0]['domain'],'All_India_Rank' => $row['GATE'][0]['all_india_score'],'Marks' => $row['GATE'][0]['marks'],'Year_of_passing' =>$row['GATE'][0]['year_of_passing'],'id' => $row['PhD'][0]['id'],'drop_values'=>'drop'));  

        }
exit;

?>
 
