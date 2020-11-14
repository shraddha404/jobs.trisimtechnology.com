<?php session_start(); include_once ('includes/php_header.php');

if(!empty($_POST)){

//Insert basic details

//$row = $u->getEmploymentById($_POST['id']);
	$select ="SELECT * FROM user_employment WHERE id=?";
	$select = $u->pdo->prepare($select);
	$select->execute(array($_POST['id']));
		$row = $select->fetch(PDO::FETCH_ASSOC);
                if($row['current_company']=='yes'){
      echo json_encode(array('designation' => $row['designation'],'organization' => $row['organization'],'started_working_year' => $row['started_working_year'],'started_working_month' => $row['started_working_month'],'worked_till_year' => $row['worked_till_year'],'worked_till_month' => $row['worked_till_month'],'current_company_yes' => 'yes','current_company_no' =>'no','description' => $row['description'],'noticeperiod' => $row['noticeperiod'],'current_ctc' => $row['current_ctc'],'id' => $row['id']));  
                }
                if($row['current_company']=='no'){
      echo json_encode(array('designation' => $row['designation'],'organization' => $row['organization'],'started_working_year' => $row['started_working_year'],'started_working_month' => $row['started_working_month'],'worked_till_year' => $row['worked_till_year'],'worked_till_month' => $row['worked_till_month'],'current_company_no' =>'yes','current_company_yes' =>'no','description' => $row['description'],'noticeperiod' => $row['noticeperiod'],'current_ctc' => $row['current_ctc'],'id' => $row['id']));  
                }
}
exit;

?>
