<?php session_start(); include_once ('includes/php_header.php');
//echo $_POST['id'],$_POST['name'];
//$_SESSION["drop"] = "down";

if(!empty($_POST)){
//Insert basic details
$row = $u->getEducationDetails($_POST['id']);
$row_subject = $u->getEducationSubjectDetails($_POST['id']);
//echo $row['10th'][0]['specialisation'];
    //print_r($row['12th']);
//print_r($row_subject);
	if($_POST['name']=='10th(SSC)'){
      echo json_encode(array('education'=>'10th','Specialization' => $row['10th'][0]['specialisation'],'School_Institute' => $row['10th'][0]['school'],'University_Board' =>$row['10th'][0]['board'],'Percentage_CGPA' => $row['10th'][0]['percentage'],'Marks_Obtained' => $row['10th'][0]['marks'],'Year_of_Passing' =>$row['10th'][0]['passing_year'],'id' => $row['10th'][0]['id'],'drop_values'=>'drop'));  
}
if($_POST['name']=='12th(HSC)'){
            //echo 'hi';
        
      echo json_encode(array('education'=>'12th','Specialization' => $row['12th'][0]['specialisation'],'School_Institute' => $row['12th'][0]['school'],'University_Board' =>$row['12th'][0]['board'],'Percentage_CGPA' => $row['12th'][0]['percentage'],'Marks_Obtained' => $row['12th'][0]['marks'],'Year_of_Passing' =>$row['12th'][0]['passing_year'],'id' => $row['12th'][0]['id'],'drop_values'=>'drop','subject1'=>$row['12th'][0]['physics_marks'],'subject2'=>$row['12th'][0]['chemistry_marks'],'subject3'=>$row['12th'][0]['maths_marks']));  
}
if($_POST['name']=='BE'){
            //echo 'hi';
       
      echo json_encode(array('education'=>'BE','Specialization' => $row['BE'][0]['specialisation'],'School_Institute' => $row['BE'][0]['school'],'University_Board' =>$row['BE'][0]['board'],'Percentage_CGPA' => $row['BE'][0]['percentage'],'Marks_Obtained' => $row['BE'][0]['marks'],'Year_of_Passing' =>$row['BE'][0]['passing_year'],'id' => $row['BE'][0]['id'],'drop_values'=>'drop'));  
}
if($_POST['name']=='ME'){
            //echo 'hi';
           
      echo json_encode(array('education'=>'ME','Specialization' => $row['ME'][0]['specialisation'],'School_Institute' => $row['ME'][0]['school'],'University_Board' =>$row['ME'][0]['board'],'Percentage_CGPA' => $row['ME'][0]['percentage'],'Marks_Obtained' => $row['ME'][0]['marks'],'Year_of_Passing' =>$row['ME'][0]['passing_year'],'id' => $row['ME'][0]['id'],'drop_values'=>'drop'));  
}
if($_POST['name']=='BTech'){
            //echo 'hi';
          
      echo json_encode(array('education'=>'B.Tech','Specialization' => $row['B.Tech'][0]['specialisation'],'School_Institute' => $row['B.Tech'][0]['school'],'University_Board' =>$row['B.Tech'][0]['board'],'Percentage_CGPA' => $row['B.Tech'][0]['percentage'],'Marks_Obtained' => $row['B.Tech'][0]['marks'],'Year_of_Passing' =>$row['B.Tech'][0]['passing_year'],'id' => $row['B.Tech'][0]['id'],'drop_values'=>'drop'));  
}
if($_POST['name']=='MTech'){
          
      echo json_encode(array('education'=>'M.Tech','Specialization' => $row['M.Tech'][0]['specialisation'],'School_Institute' => $row['M.Tech'][0]['school'],'University_Board' =>$row['M.Tech'][0]['board'],'Percentage_CGPA' => $row['M.Tech'][0]['percentage'],'Marks_Obtained' => $row['M.Tech'][0]['marks'],'Year_of_Passing' =>$row['M.Tech'][0]['passing_year'],'id' => $row['M.Tech'][0]['id'],'drop_values'=>'drop'));  
}
if($_POST['name']=='MSc'){
            //echo 'hi';
         
      echo json_encode(array('education'=>'M.Sc','Specialization' => $row['M.Sc'][0]['specialisation'],'School_Institute' => $row['M.Sc'][0]['school'],'University_Board' =>$row['M.Sc'][0]['board'],'Percentage_CGPA' => $row['M.Sc'][0]['percentage'],'Marks_Obtained' => $row['M.Sc'][0]['marks'],'Year_of_Passing' =>$row['M.Sc'][0]['passing_year'],'id' => $row['M.Sc'][0]['id'],'drop_values'=>'drop'));  
}
if($_POST['name']=='PhD'){
            //echo 'hi';
         
      echo json_encode(array('education'=>'PhD','Specialization' => $row['PhD'][0]['specialisation'],'School_Institute' => $row['PhD'][0]['school'],'University_Board' =>$row['PhD'][0]['board'],'Percentage_CGPA' => $row['PhD'][0]['percentage'],'Marks_Obtained' => $row['PhD'][0]['marks'],'Year_of_Passing' =>$row['PhD'][0]['passing_year'],'id' => $row['PhD'][0]['id'],'drop_values'=>'drop'));  
}
if($_POST['name']=='GATE'){
            //echo 'hi';
         
      echo json_encode(array('education'=>'GATE','domain' => $row['GATE'][0]['domain'],'All_India_Rank' => $row['GATE'][0]['all_india_score'],'Marks' => $row['GATE'][0]['marks'],'Year_of_passing' =>$row['GATE'][0]['year_of_passing'],'id' => $row['PhD'][0]['id'],'drop_values'=>'drop'));  
}

        }
exit;

?>
 