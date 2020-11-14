<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class candidateSearchforEmployer {

    private $_join;
    private $_condition;
    private $_query;
    private $_sort;
   

    function __construct($id) {
        $this->_query = " SELECT DISTINCT PhD_details.marks as phd_marks,GATE_details.marks as gate_marks,GATE_details.year_of_passing as gate_yop,GATE_details.all_india_score as gate_air,GATE_details.domain as gate_domain,MSc_details.percentage as msc_cgpa,MTech_details.percentage as mtech_cgpa,ME_details.percentage as me_cgpa,BE_details.percentage as be_cgpa,BTech_details.percentage as btech_cgpa,xiith_details.marks as xii_marks,xiith_details.percentage as xii_percentage,(xiith_details.physics_marks+xiith_details.chemistry_marks+xiith_details.maths_marks) as pcm_marks,xiith_details.physics_marks,xiith_details.chemistry_marks,xiith_details.maths_marks,xth_details.marks as x_marks ,users.*,user_profile.*,(user_profile.work_exp_years*365)+(user_profile.work_exp_months*31) , users.id AS id,user_types.type AS userType  from users ";
        $this->_join = "LEFT JOIN user_profile ON users.id = user_profile.user_id LEFT JOIN user_types ON users.user_type = user_types.id LEFT JOIN PhD_details ON users.id=PhD_details.user_id LEFT JOIN GATE_details on users.id=GATE_details.user_id LEFT JOIN MSc_details on users.id=MSc_details.user_id LEFT JOIN MTech_details on users.id=MTech_details.user_id LEFT JOIN ME_details on users.id=ME_details.user_id LEFT JOIN BE_details on users.id=BE_details.user_id LEFT JOIN BTech_details on users.id=BTech_details.user_id LEFT JOIN xiith_details on users.id=xiith_details.user_id LEFT JOIN xth_details on users.id=xth_details.user_id ";
        $this->_condition = " where user_type=".$id;
        $this->_sort = " order by users.id DESC";
    }

    function query() {
        return $this->_query . $this->_join . $this->_condition . $this->_sort;
    }

    function byLocation($location) {
        $this->_condition .= " AND city LIKE '%" . $location . "%'";
    }

    function byExperience($experience,$years) {
        $this->_condition .= " AND is_experienced='".$experience."'";
        if($years!=0)
        {
           //  $this->_condition .= " AND work_exp_years='".$years."'";
             
                $this->_condition .= " AND user_profile.work_exp_years LIKE '%".$years."%'";

        }

    }
    function byDomain($domain) {
        $this->_condition .= " AND user_profile.domain LIKE '%".$domain."%'";
    }


    function byQualification($education) {
        $this->_join .= " LEFT JOIN user_education_details ON users.id = user_education_details.user_id  ";
        $this->_condition .= " AND user_education_details.qualifications_id LIKE '%" . $education . "%' ";
       
    }

   
        

}

?>
