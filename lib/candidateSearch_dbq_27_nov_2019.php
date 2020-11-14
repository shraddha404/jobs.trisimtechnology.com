<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class candidateSearch {

    private $_join;
    private $_condition;
    private $_query;
    private $_sort;
    private $subject_join;
   

    function __construct($id) {
        $this->_query = " SELECT DISTINCT PhD_details.marks as phd_marks,GATE_details.marks as gate_marks,GATE_details.year_of_passing as gate_yop,GATE_details.all_india_score as gate_air,GATE_details.domain as gate_domain,MSc_details.percentage as msc_cgpa,MTech_details.percentage as mtech_cgpa,ME_details.percentage as me_cgpa,BE_details.percentage as be_cgpa,BTech_details.percentage as btech_cgpa,xiith_details.marks as xii_marks,xiith_details.percentage as xii_percentage,(xiith_details.physics_marks+xiith_details.chemistry_marks+xiith_details.maths_marks) as pcm_marks,xiith_details.physics_marks,xiith_details.chemistry_marks,xiith_details.maths_marks,xth_details.marks as x_marks ,users.*,user_profile.*,(user_profile.work_exp_years*365)+(user_profile.work_exp_months*31) , users.id AS id,user_types.type AS userType  from users ";
        $this->_join = "LEFT JOIN user_profile ON users.id = user_profile.user_id LEFT JOIN user_types ON users.user_type = user_types.id LEFT JOIN PhD_details ON users.id=PhD_details.user_id LEFT JOIN GATE_details on users.id=GATE_details.user_id LEFT JOIN MSc_details on users.id=MSc_details.user_id LEFT JOIN MTech_details on users.id=MTech_details.user_id LEFT JOIN ME_details on users.id=ME_details.user_id LEFT JOIN BE_details on users.id=BE_details.user_id LEFT JOIN BTech_details on users.id=BTech_details.user_id LEFT JOIN xiith_details on users.id=xiith_details.user_id LEFT JOIN xth_details on users.id=xth_details.user_id ";
        $this->_condition = " where user_type=".$id;
        $this->_sort = " order by users.id DESC";
    }

    function query() {
        return $this->_query . $this->_join . $this->_condition . $this->_sort;
    }

    function byName($name) {
        $this->_condition .= " AND username LIKE '%" . $name . "%' OR  first_name LIKE '%" . $name . "%'  OR middle_name LIKE '%" . $name . "%' OR last_name LIKE '%" . $name . "%'";
    }

    function byEmail($email) {
        $this->_condition .= " AND email LIKE '%" . $email . "%' ";
    }

    function byLocation($location) {
        $this->_condition .= " AND city LIKE '%" . $location . "%'";
    }
 function byUserId($user_id) {
        $this->_condition .= " AND users.id ='$user_id'";
    }

    function byYearsExperience($data) {
        $this->_condition .= " AND (user_profile.work_exp_years*365)+(user_profile.work_exp_months*31) BETWEEN " . ($data['exp_years'] * 365 + $data['exp_months'] * 31) . " AND " . ($data['to_exp_years'] * 365 + $data['to_exp_months'] * 31 ) . " ";
    }

    function byMonthsExperience($data) {
        $this->_condition .= " AND work_exp_months  BETWEEN '" . $data['exp_months'] . "' AND '" . $data['to_exp_months'] . "' AND work_exp_years  BETWEEN '" . $data['exp_years'] . "' AND '" . $data['to_exp_years'] . "' ";
    }

    function byYMExperience($data) {
        $this->_condition .= " AND (user_profile.work_exp_years*365)+(user_profile.work_exp_months*31) BETWEEN " . ($data['exp_years'] * 365 + $data['exp_months'] * 31) . " AND " . ($data['to_exp_years'] * 365 + $data['to_exp_months'] * 31 ) . " ";
    }
 function byDateWise($data) {
        $this->_condition .= " ORDER BY ASC  users.id";
    }
    function bySubject($data) {
        $this->subject_join=1;
        //$this->_join .= " LEFT JOIN subject_marks ON users.id = subject_marks.user_id ";
        $this->_condition .= " AND (subject_marks.subject1 LIKE '%" . trim($data['subject']) . "%' or subject_marks.subject2 LIKE '%" . trim($data['subject']) . "%'  or subject_marks.subject3 LIKE '%" . trim($data['subject']) . "%'  or subject_marks.subject4 LIKE '%" . trim($data['subject']) . "%'  or subject_marks.subject5 LIKE '%" . $data['subject'] . "%' ) and subject_marks.user_id=user_profile.user_id ";
    }

    function byQualification($education,$qid_10th,$qid_12th,$qid_be) {
        $this->_join .= " LEFT JOIN user_education_details ON users.id = user_education_details.user_id  ";
        $this->_condition .= " AND user_education_details.qualifications_id LIKE '%" . $education . "%' ";
        if ($education == $qid_10th || $education == $qid_12th || $education == $qid_be) {
           
            //$this->_join .= "  LEFT JOIN subject_marks ON users.id = subject_marks.user_id  ";
           
            //$this->_condition .= " AND subject_marks.qualifications_id LIKE '%" . $education . "%'   ";
        }
    }

   /*function byMarks($data, $subject_name) {
        if ($data['subject_marks'] == 'greater') {
            $this->_condition .= " AND subject_marks." . $subject_name . ">=" . trim($data['marks']) . "";
        }
        if ($data['subject_marks'] == 'less') {
            $this->_condition .= " AND subject_marks." . $subject_name . "<=" . trim($data['marks']) . "";
        }
    }*/
    function byMarks($data) {
        if ($data['subject_marks'] == 'greater') {
            if($data['subject']=='physics')
            {
            $this->_condition .= " AND xiith_details.physics_marks >=" . trim($data['marks']) . "";
            }
            if($data['subject']=='chemistry')
            {
            $this->_condition .= " AND xiith_details.chemistry_marks >=" . trim($data['marks']) . "";
            }
            if($data['subject']=='maths')
            {
            $this->_condition .= " AND xiith_details.maths_marks >=" . trim($data['marks']) . "";
            }
        }
        if ($data['subject_marks'] == 'less') {
             if($data['subject']=='physics')
            {
            $this->_condition .= " AND xiith_details.physics_marks <=" . trim($data['marks']) . "";
            }
            if($data['subject']=='chemistry')
            {
            $this->_condition .= " AND xiith_details.chemistry_marks <=" . trim($data['marks']) . "";
            }
            if($data['subject']=='maths')
            {
            $this->_condition .= " AND xiith_details.maths_marks <=" . trim($data['marks']) . "";
            }
            
        }
    }

}

?>
