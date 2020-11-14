<?php include_once ('includes/php_header.php');
if (empty($_SESSION['user_id'])) {
    header('Location:/login.php');
}
//echo $_SESSION['sub_domain'];
/*
  else if($_SESSION['user_type'] == 'Admin'){
  header("Location:/admin/dashboard.php");
  }
 */
//unset($_SESSION["drop"]);
$qualifications = $u->getQualifications();
$qualification_names = $u->getQualificationNames();
$qualification_names_edit = $u->getQualificationNames();
foreach ($qualification_names as $key => $value) {
            if (in_array("GATE", $value)) {

                unset($qualification_names[$key]);
            }
        }
$user_id = $_SESSION['user_id'];


if (isset($_POST)) {
//Update basic details
    $user_id = $u->UpdateResume($_POST, $_FILES);
}
if (isset($_SESSION['user_id'])) {
    $userdetails = $u->getUserDetails($_SESSION['user_id']);
    $employmentdetails = $u->getUserEmploymentDetails($_SESSION['user_id']);
    $educationdetails = $u->getUserEducationDetails($_SESSION['user_id']);
    $education = $u->getEducationDetails($_SESSION['user_id']);
    $education_subject = $u->getEducationSubjectDetails($_SESSION['user_id']);

    //$userskills = $u->getUserSkillsDetails($_SESSION['user_id']);
     $userskills = $u->getUserSkillsDetails($_SESSION['user_id']);
    $usertools = $u->getUserToolsDetails($_SESSION['user_id']);
    $resumeheadline = $u->getUserResumeHeadlineDetails($_SESSION['user_id']);
    $user_education = $u->getEducationDetails($_SESSION['user_id']);

    //print_r($education);


    $user_education_count = $u->countEducationDetails($_SESSION['user_id']);
}



//print_r($qualification_names);
$skills = $u->getSkills();
$tools = $u->getTools();
if (isset($_SESSION['user_id'])) {
    $qualifications = $u->getQualifications();
}
if ($_SESSION['user_type'] == 'Admin' && (!empty($_GET['id']))) {
    $userdetails = $u->getUserDetails($_GET['id']);

    $employmentdetails = $u->getUserEmploymentDetails($_GET['id']);
    $educationdetails = $u->getUserEducationDetails($_GET['id']);
    $education = $u->getEducationDetails($_GET['id']);
    $education_subject = $u->getEducationSubjectDetails($_GET['id']);
    $skills = $u->getSkills();
    //$userskills = $u->getUserSkillsDetails($_GET['id']);
     $userskills = $u->getUserSkillsDetails($_GET['id']);
    $usertools = $u->getUserToolsDetails($_GET['id']);
    $resumeheadline = $u->getUserResumeHeadlineDetails($_GET['id']);
    $user_education = $u->getEducationDetails($_GET['id']);
    $user_education_count = $u->countEducationDetails($_GET['id']);
}
if ($_SESSION['user_type'] == 'Employer' && (!empty($_GET['id']))) {
    $userdetails = $u->getUserDetails($_GET['id']);

    $employmentdetails = $u->getUserEmploymentDetails($_GET['id']);
    $educationdetails = $u->getUserEducationDetails($_GET['id']);
    $education = $u->getEducationDetails($_GET['id']);
    $education_subject = $u->getEducationSubjectDetails($_GET['id']);
    $skills = $u->getSkills();
    //$userskills = $u->getUserSkillsDetails($_GET['id']);
      $userskills = $u->getUserSkillsDetails($_GET['id']);
    $usertools = $u->getUserToolsDetails($_GET['id']);
    $resumeheadline = $u->getUserResumeHeadlineDetails($_GET['id']);
    $user_education = $u->getEducationDetails($_GET['id']);
    $user_education_count = $u->countEducationDetails($_GET['id']);
}
//print_r($user_education_count);
$ssc = (($user_education_count['10th'] <= 0) ? 'show' : 'hide');
$hsc = (($user_education_count['12th'] <= 0) ? 'show' : 'hide');
$be_edit = (($user_education_count['BE'] <= 0) ? 'show' : 'hide');
$me_edit = (($user_education_count['ME'] <= 0) ? 'show' : 'hide');
$mtech_edit = (($user_education_count['M.Tech'] <= 0) ? 'show' : 'hide');
$btech_edit = (($user_education_count['B.Tech'] <= 0) ? 'show' : 'hide');
$msc_edit = (($user_education_count['M.Sc'] <= 0) ? 'show' : 'hide');
$phd_edit = (($user_education_count['PhD'] <= 0) ? 'show' : 'hide');
$gate_edit = (($user_education_count['GATE'] <= 0) ? 'show' : 'hide');

//echo $phd_edit;
$count = sizeof($user_education_count);
for ($i = 0; $i <= $count; $i++) {
    if (($key_name = array_search('1', $user_education_count)) !== false) {

        unset($user_education_count[$key_name]);
        foreach ($qualification_names as $key => $value) {
            if (in_array($key_name, $value)) {

                unset($qualification_names[$key]);
            }
        }
    }
}

$show_education = array();

//print_r($education_subject);


include_once ('includes/header.php');
?>
<div class="container">
    <div class="single">
        <div class="form-container">
            <h2>My Profile</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-md-12">
                        <h3 align="center"><?php echo $msg; ?></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-4">
                            <div class="profile-box-white">
                                <ul class="collection">
                                    <h2>Quick Links</h2>
                                    <li class="collection-item"><span class="text"><a href="#ResumeHeadline" >Resume Headline</a></span></li>
                                    
                                    <li class="collection-item"><span class="text"><a href="#Employment" >Employment</a></span></li>
                                    <li class="collection-item"><span class="text"><a href="#Education" >Education</a></span></li>
                                    <li class="collection-item"><span class="text"><a href="#GATEdetails" >GATE</a></span></li>
                                    <li class="collection-item"><span class="text"><a href="#Skill" >Skills and Tools</a></span></li>
                                    <!--<li class="collection-item"><span class="text"><a href="#Tools" >Tools</a></span></li>-->
                                    <!--<li class="collection-item"><span class="text"><a href="#Projects" >Projects</a></span></li>-->
                                    <li class="collection-item"><span class="text"><a href="#Personal" >Personal Details</a></span></li>
                                    <li class="collection-item"><span class="text"><a href="#Resume" >Attach Resume</a></span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="form-group col-md-8">

                            <!------------------------------------------------------------------------------------------ User Basic Details  Header------------------------------------------------------------------------------------------>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="profile-box">
                                        <div class="row">
                                            <div class="form-group col-md-12">

                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <?php
                                                            if (empty($_GET['id'])) {
                                                                $id = $_SESSION['user_id'];
                                                            } else {
                                                                $id = $_GET['id'];
                                                            }
                                                            ?>

                                                            <div class="col-md-2"><?php if (empty($userdetails[0]['profile_photo'])) { ?>	<img src="images/noimages.jpeg" width="100px" height="100px"><?php } else { ?>
                                                                    <img src="../uploads/photos/<?php echo $id; ?>/<?php echo $userdetails[0]['profile_photo']; ?>" width="100px" height="100px"><?php } ?><br />
                                                                <?php echo $employmentdetails['current_company']; ?>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <b><?php
                                                                    if (empty($userdetails[0]['profile_name'])) {
                                                                        echo $userdetails[0]['first_name'] . " " . $userdetails[0]['middle_name'] . " " . $userdetails[0]['last_name'];
                                                                    } else {
                                                                        ?><?php
                                                                        echo ($userdetails[0]['profile_name']);
                                                                    }
                                                                    ?></b>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <img src="images/exp2.png" width="15px" height="15px">&nbsp;&nbsp;<?php if( $userdetails[0]['is_experienced']=='yes'){echo 'Experienced';}else{echo 'Fresher';} ?>
                                                                <br /><br />

                                                                <img src="images/phone-outline.png" width="15px" height="15px">&nbsp;&nbsp;<?php echo $userdetails[0]['mobile_number']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <img src="images/exp.png" width="15px" height="15px">&nbsp;&nbsp;<?php echo urldecode($userdetails[0]['work_exp_years']) . "  years  " ?><br /><br />
                                                                <img src="images/rupee.png" width="15px" height="15px">&nbsp;&nbsp;<?php echo urldecode($userdetails[0]['current_ctc_lakhs']) . "lakh" ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <img src="images/email.png" width="15px" height="15px">&nbsp;&nbsp;<?php echo $userdetails[0]['email']; ?><br />
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!------------------------------------------------------------------------------------------End User Basic Details Header------------------------------------------------------------------------------------------>


                            <!------------------------------------------------------------------------------------------ Resume Headline Details------------------------------------------------------------------------------------------>
                            <div class="row" id="ResumeHeadline">
                                <div class="form-group col-md-12">
                                    <div class="profile-box-white">
                                        <div class="row">
                                            <div class="form-group col-md-12">


                                                <div class="col-md-6"><h3><b>Resume Headline</b>&nbsp;&nbsp;<?php if (!empty($resumeheadline[0]['resume_headline'])) { ?><input type="button" name="edit" value="Edit" id="<?php echo $resumeheadline[0]['user_id']; ?>" class="btn btn-info btn-xs edit_headline" /><?php } ?>    <br/><br/></h3>


                                                    <?php echo $resumeheadline[0]['resume_headline']; ?>


                                                </div>
                                                <div class="col-md-6" align="right">
                                                     
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!------------------------------------------------------------------------------------------End User Employment Details------------------------------------------------------------------------------------------>




                            <!------------------------------------------------------------------------------------------ User Employment Details------------------------------------------------------------------------------------------>
                            <div class="row" id="Employment">
                                <div class="form-group col-md-12">




                                    <div class="profile-box-white">
                                        <div class="row">
                                            <div class="form-group col-md-12">

                                                <div class="col-md-6"><h3><b>Employment</b></h3></div>
                                                <div class="col-md-6" align="right">
                                                   

                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php foreach ($employmentdetails as $employmentdetail) { ?>
                                                <div class="form-group col-md-10">
                                                    <table class="table table-bordered" style="border: none;">

                                                        <tr><th  width="40%"  style="border: none;">Designation</th>        <td    style="border: none;"><?php echo $employmentdetail['designation']; ?></td>      </tr>
                                                        <tr> <th  width="40%"  style="border: none;">Organization</th>        <td    style="border: none;"><?php echo $employmentdetail['organization']; ?></td></tr>
                                                        <tr> <th  width="40%"  style="border: none;">Current Company</th>        <td    style="border: none;"><?php echo $employmentdetail['current_company']; ?></td></tr>
                                                        <tr> <th  width="40%"  style="border: none;">Started working year</th>        <td    style="border: none;"><?php echo $employmentdetail['started_working_year']; ?></td></tr>
                                                        <tr> <th  width="40%"  style="border: none;">Started working month</th>        <td    style="border: none;"><?php echo $employmentdetail['started_working_month']; ?></td></tr>
                                                        <tr>  <th  width="40%"  style="border: none;">Worked till year</th>        <td    style="border: none;"><?php echo $employmentdetail['worked_till_year']; ?></td></tr>
                                                        <tr>  <th  width="40%"  style="border: none;">Worked till month</th>        <td    style="border: none;"><?php echo $employmentdetail['worked_till_month']; ?></td></tr>
                                                        <tr>  <th  width="40%"  style="border: none;">Description</th>        <td    style="border: none;word-wrap: break-word;max-width:5px"><?php echo $employmentdetail['description']; ?></td></tr><?php if (!empty($employmentdetail['noticeperiod'])) { ?>
                                                            <tr>  <th  width="40%"  style="border: none;">Notice Period</th>        <td    style="border: none;"><?php echo $employmentdetail['noticeperiod']; ?></td></tr>
                                                        <?php } ?>
                                                        <?php if (!empty($employmentdetail['current_ctc'])) { ?>
                                                            <tr>  <th  width="40%"  style="border: none;">Current CTC</th>        <td    style="border: none;"><?php echo $employmentdetail['current_ctc']; ?></td></tr><?php } ?>



                                                    </table></div>	
                                            <?php } ?>

                                        </div>													
                                    </div>
                                </div>
                            </div>



                            <!------------------------------------------------------------------------------------------End User Employment Details------------------------------------------------------------------------------------------>



                            <!------------------------------------------------------------------------------------------ User Education Details------------------------------------------------------------------------------------------>

                            <div class="row" id="Education">
                                <div class="form-group col-md-12">
                                    <div class="profile-box-white">
                                        <div class="row">
                                            <div class="form-group col-md-12">

                                                <div class="col-md-6"><h3><b>Education</b></h3></div>
                                                <div class="col-md-6" align="right">
                                                    
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">

                                            <?php
                                            if ($ssc == 'hide') {
                                                $name = '10th(SSC)';
                                                $u->displayEducationDetails($education['10th'], $name, '10th');
                                            }
                                            ?>



                                            <?php
                                            if ($hsc == 'hide') {
                                                $name = '12th(HSC)';
                                                $u->display12thDetails($education['12th'], $name, '12th');
                                            }
                                            ?>


                                            <?php
                                            if ($be_edit == 'hide') {
                                                $name = 'BE';
                                                $u->displayEducationDetails($education['BE'], $name, 'be');
                                            }
                                            ?>


                                            <?php
                                            if ($me_edit == 'hide') {
                                                $name = 'ME';
                                                $u->displayEducationDetails($education['ME'], $name, 'me');
                                            }
                                            ?>
                                            <?php
                                            if ($mtech_edit == 'hide') {
                                                $name = 'MTech';
                                                $u->displayEducationDetails($education['M.Tech'], $name, 'mtech');
                                            }
                                            ?>



                                            <?php
                                            if ($btech_edit == 'hide') {
                                                $name = 'BTech';
                                                $u->displayEducationDetails($education['B.Tech'], $name, 'btech');
                                            }
                                            ?>


                                            <?php
                                            if ($msc_edit == 'hide') {
                                                $name = 'MSc';
                                                $u->displayEducationDetails($education['M.Sc'], $name, 'msc');
                                            }
                                            ?>



                                            <?php
                                            if ($phd_edit == 'hide') {
                                                $name = 'PhD';
                                                $u->displayEducationDetails($education['PhD'], $name, 'phd');
                                            }
                                            ?>
                                            <?php
                                            /*if ($gate_edit == 'hide') {
                                                $name = 'GATE';
                                                $u->displayGateDetails($education['GATE'], $name, 'gate');
                                            }*/
                                            ?>


                                        </div>													
                                    </div>
                                </div>
                            </div>

                            <!------------------------------------------------------------------------------------------End User Education Details------------------------------------------------------------------------------------------>

                            
                            
                            
                            
                            
                            <!------------------------------------------------------------------------------------------ User GATE Details------------------------------------------------------------------------------------------>
                            <div class="row" id="GATEdetails">
                                <div class="form-group col-md-12">
                                    <div class="profile-box-white">
                                        <div class="row">
                                            <div class="form-group col-md-12">


                                                <div class="col-md-6"><h3><b>GATE</b>&nbsp;&nbsp;</h3></div><?php
                                                
                                                if ($gate_edit == 'hide') {
                                                $name = 'GATE';                                                
                                            }                                                
                                                 ?>
                                                        
 <div class="col-md-6" align="right">
                                                    <!-- Button to trigger modal --><?php if ($gate_edit == 'show') { ?>
                                                        <button class="btn2 btn-2 btn2-1b" data-toggle="modal"  id="btnShowGateDetails"
                                                                data-target="#modalFormGATEdetails">GATE Details</button>
                                                            <?php } ?>    
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                                <div class="row">
                                            			<?php if ($gate_edit == 'hide') {
                                            $name = 'GATE';
                                        $u->displayGateDetails($education['GATE'], $name, 'gate');}?>										
                                               <!--<div class="form-group col-md-10">
                                                    <table class="table table-bordered" style="border: none;">

                                                        <tr><th  width="40%"  style="border: none;">Domain</th>        <td    style="border: none;"></td>      </tr>
                                                        <tr> <th  width="40%"  style="border: none;">All India Rank</th>        <td    style="border: none;"></td></tr>
                                                        <tr> <th  width="40%"  style="border: none;">Marks</th>        <td    style="border: none;"></td></tr>

                                                        <tr>  <th  width="40%"  style="border: none;">Year Of Passing</th>        <td    style="border: none;"></td></tr>
                                                        
                                                    </table>	</div>
                                                <div class="col-md-2">	<input type="button" name="edit" value="Edit" id="edit_gatedetails" user_id="<?php echo $_SESSION['user_id']; ?>" class="btn btn-info btn-xs edit_skill" /><br/></div>                                               
-->
                                          

                                        </div>											
                                    
                                                        
                                                            
                                                            
                                                            
                                                            
  </div>
                                               
                                            </div>
                                        </div>
                                   

                            <!------------------------------------------------------------------------------------------End User GATE Details------------------------------------------------------------------------------------------>
                            <!------------------------------------------------------------------------------------------ User SKILL Details------------------------------------------------------------------------------------------>
                            <div class="row"  id="Skill">
                                <div class="form-group col-md-12">

                                    <div class="profile-box-white">
                                        <div class="row">
                                            <div class="form-group col-md-12">

                                                <div class="col-md-6"><h3><b>ADD SKILLS and TOOLS</b></h3></div>
                                                <div class="col-md-6" align="right">
                                                    

                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">


                                            <?php foreach ($userskills as $userskill) { 
                                                   $userskills1= explode(":" ,$userskill['skill_id']) ;
                                                   
                                                   $skills_names=implode("," ,$userskills1) ;
                                                ?>	
                                           
                                                <div class="form-group col-md-10">
                                                    <table class="table table-bordered" style="border: none;">

                                                        <tr><th  width="40%"  style="border: none;">Programming Languages
</th>        <td    style="border: none;"><?php echo $skills_names; ?></td>      </tr>
                                                         <tr><th  width="40%"  style="border: none;">Softwares</th>        <td    style="border: none;"><?php echo $userskill['tool_id']; ?></td>      </tr>
                                                        <!--tr> <th  width="40%"  style="border: none;">Tool Version</th>        <td    style="border: none;"><?php echo $userskill['version']; ?></td></tr>
                                                        <tr> <th  width="40%"  style="border: none;">Tool Last Used</th>        <td    style="border: none;"><?php echo $userskill['last_used']; ?></td></tr-->

                                                        <tr>  <th  width="40%"  style="border: none;">Tool Source of learning</th>        <td    style="border: none;"><?php echo $userskill['source_of_learning'] ?></td></tr>
                                                        <tr>  <th  width="40%"  style="border: none;">Proficiency Level</th>        <td    style="border: none;"><?php echo $userskill['proficiency_level']; ?></td></tr>
                                                         <tr>  <th  width="40%"  style="border: none;">Operating Systems</th>        <td    style="border: none;"><?php echo $userskill['operating_systems']; ?></td></tr>

                                                        
                                                    </table></div>	

                                            <?php } ?>

                                        </div>													
                                    </div>

                                </div>
                            </div>
                            <!------------------------------------------------------------------------------------------End User SKILL Details------------------------------------------------------------------------------------------>
                           
                            <!------------------------------------------------------------------------------------------ User PERSOnal Details------------------------------------------------------------------------------------------>

                            <div class="row" id="Personal">
                                <div class="form-group col-md-12">
                                    <div class="profile-box-white">
                                        <div class="row">
                                            <div class="form-group col-md-12">

                                                <div class="col-md-6"><h3><b>Personal Details</b></h3></div>
                                                <div class="col-md-6" align="right">
                                                    <!-- Button to trigger modal -->
                                                    <?php foreach ($userdetails as $userdetail) { ?>
                                                        <?php if (empty($userdetail['date_of_birth'])) { ?>
                                                            <button class="btn2 btn-2 btn2-1b" data-toggle="modal"  id="btnShowPersonal"
                                                                    data-target="#modalFormAddPersonal" >Add Personal Details</button><?php
                                                                }
                                                            }
                                                            ?>


                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">


                                            <?php foreach ($userdetails as $userdetail) { ?>
                                                <div class="form-group col-md-10">
                                                    <table class="table table-bordered" style="border: none;">

                                                        <tr><th  width="40%"  style="border: none;">Date of Birth</th>        <td    style="border: none;"><?php echo $userdetail['date_of_birth']; ?></td>      </tr>
                                                        <tr> <th  width="40%"  style="border: none;">Permanent Address</th>        <td    style="border: none;"><?php echo $userdetail['permanent_address']; ?></td></tr>
                                                        <!--<tr> <th  width="40%"  style="border: none;">Pin code</th>        <td    style="border: none;"><?php echo $userdetail['pin_code']; ?></td></tr>-->

                                                        <tr>  <th  width="40%"  style="border: none;">Passport Number</th>        <td    style="border: none;"><?php echo $userdetail['passport_number']; ?></td></tr>
                                                    </table></div>
                                                <?php if (!empty($userdetail['date_of_birth'])) { ?>
                                                    <!--div class="col-md-2">	<input type="button" name="edit" value="Edit" id="<?php echo $userdetail['id']; ?>" class="btn btn-info btn-xs edit_personal" /><br/></div-->
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </div>													
                                    </div>


                                </div>
                            </div>
                            <!------------------------------------------------------------------------------------------end User PERSOnal Details------------------------------------------------------------------------------------------>


                            <!------------------------------------------------------------------------------------------ User Resume Details------------------------------------------------------------------------------------------>
                            <div class="row"  id="Resume">
                                <div class="form-group col-md-12">

                                    <div class="profile-box-white">
                                        <div class="row">                           
                                            <form role="form" id="addResume"  class="addResume" method="post" action="my_profile.php">
                                                <div class="form-group col-md-12">

                                                    <div class="col-md-6"><h3><b>Upload Resume</b></h3></div>


                                                </div>
                                        </div>
                                        <div class="row">
                                            <input type="hidden" name="id" value="<?php echo $_SESSION['user_id']; ?>">

                                            <!--input type="file" path="resume_file" id="resume_file" name="resume_file" -->
                                                       <!--input type="hidden"  id="resumefile" name="resumefile" value="<?php echo $userdetail['resume_file_data']; ?>"-->
                                            <a href="admin/getpdf.php?id_no=<?php echo $userdetail['user_id']; ?>">View Resume Pdf</a>

                                        </div>	
                                        
                                        </form>												
                                    </div>

                                </div>
                            </div>
                            <!------------------------------------------------------------------------------------------End User Resume Details------------------------------------------------------------------------------------------>

                        </div>
                    </div>

            </form>




            <!------------------------------------------------------------------------------------------ Modal Add Basic Details------------------------------------------------------------------------------------------>
            <!-- Modal -->
            <div class="modal fade" id="modalFormBasicDetails" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span>
                            </button>
                            <h3 class="modal-title basic" id="myModalLabel">Basic Details</h3>
                            <?php
                            if (empty($_GET['id'])) {
                                $id = $_SESSION['user_id'];
                            } else {
                                $id = $_GET['id'];
                            }
//  echo $id;
                            ?>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <p class="statusMsg"></p>  
                            <form role="form" id="addBasicDetails"  class="addBasicDetails" method="post" action="my_profile.php" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" path="profile_name" id="profile_name" name="profile_name" class="form-control" required=""/>
                                    <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">


                                </div>

                                <div class="form-group">
                                    <label for="inputName">UserName<span class="mandatory">* </span></label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text"  id="username" name="username" class="form-control" required=""/>
                                           
                                        </div></div>
                                </div>
                                <div class="form-group">
                                    <div class="input-field col s12">
                                        <label for="gender">Gender<span class="mandatory">* </span></label>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <select name="gender" id="gender" class="form-control" required="">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>

                                            </select>
                                        </div>
                                        <span id="error_gender" class="text-danger"></span>
                                    </div></div>
                                <div class="form-group">
                                    <div class="input-field col s12">
                                        <label for="gender">Preffered Job Location</label>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <select id="multiple-checkboxes" multiple="multiple"  name="multiple-checkboxes" onchange="myFunction(this, event)">                                        
                                                <option value="Pune">Pune</option>
                                                <option value="Mumbai">Mumbai</option>
                                                <option value="Banglore">Banglore</option>
                                                <option value="Nagpur">Nagpur</option>
                                                <option value="Chennai">Chennai</option>
                                                <option value="Aurangabad">Aurangabad</option>
                                            </select>
                                        </div>
                                        <span id="error_gender" class="text-danger"></span>
                                    </div></div>
                                <div class="form-group">
                                    <div class="input-field col s12">
                                        <label for="gender">Type of job required</label>
                                    </div>
                                    <input type="hidden" id="hidden_domain">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <select name="job_type" id="job_type" class="form-control">
                                                <option value="">Choose categories</option>
                                                <?php
                                                if (empty($_SESSION['domain'])) {
                                                    $u->getJobTypeDropDown();
                                                } else {
                                                    $u->getJobTypeDropDownSelected($_SESSION['domain']);
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <span id="error_gender" class="text-danger"></span>
                                    </div></div>
                                <div class="form-group">
                                    <div class="input-field col s12">
                                        <label for="gender">Key words related to your <b class="section-title">Skills</b> and <b class="section-title">Expertise</b></label>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <textarea id="key_words" name="key_words" class="form-control textarea_count"  rows="5"></textarea>
                                        </div>
                                    </div>
                                    <span id="error_gender" class="text-danger"></span>
                                </div>
                                <div class="form-group">

                                    <div class="input-field col s12">
                                        <label for="inputMessage">Total Experience</label>
                                    </div> <div class="row">

                                        <div class="col-md-4">
                                            <select name="work_exp_years" id="work_exp_years" class="form-control">      

                                                <option value="0">Select One</option>
                                                <option value="1-2">1-2</option>
                                                <option value="2-5">2-5</option>
                                                <option value="5-8">5-8</option>
                                                <option value="8-12">8-12</option>
                                                <option value="12-15">12-15</option>
                                                <option value="15-20">15-20  </option>
                                                <option value="above 20">above 20</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">



                                    <div class="input-field col s12">
                                        <label for="inputMessage">Total Salary</label>
                                    </div>	<div class="row">							
                                        <div class="col-md-4">

                                            <input type="text"  id="current_ctc_lakhs" name="current_ctc_lakhs" class="form-control"/>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="input-field col s12">
                                        <label for="inputMessage">City<span
                                                class="mandatory">* </span></label>
                                    </div><div class="row">
                                        <div class="col-md-4">
                                            <input type="text" path="city" id="city" name="city" class="form-control" required=""/>
                                        </div>

                                    </div>
                                </div>			
                                <div class="form-group">

                                    <div class="input-field col s12">
                                        <label for="inputMessage">Mobile Number<span
                                                class="mandatory">* </span></label>
                                    </div><div class="row">
                                        <div class="col-md-4">
                                            <input type="text" path="mobile_number" id="mobile_number"  name="mobile_number" class="form-control input-sm" required/>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="input-field col s12">
                                        <label for="inputMessage">Profile Photo</label>
                                    </div><div class="row">
                                        <div class="col-md-4">
                                            <input type="file" path="uploadphoto" id="uploadphoto" name="uploadphoto"  >				
                                            <?php if (empty($userdetails[0]['profile_photo'])) { ?>	
                                                <img src="images/noimages.jpeg" width="100px" height="100px">
                                                <?php
                                            } else {
                                                if (empty($_GET['id'])) {
                                                    $id = $_SESSION['user_id'];
                                                } else {
                                                    $id = $_GET['id'];
                                                }
                                                //echo $id; 
                                                ?>
                                                <img src="../uploads/photos/<?php echo $id; ?>/<?php echo $userdetails[0]['profile_photo']; ?>" width="100px" height="100px"><?php } ?>

                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="input-field col s12">
                                        <label for="inputMessage">Email<span
                                                class="mandatory">* </span></label>
                                    </div> <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" path="email" id="email" name="email" class="form-control input-sm" required/>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="input-field col s12">
                                        <label for="inputMessage">Expected Designation<span
                                                class="mandatory">* </span></label>
                                    </div><div class="row">
                                        <div class="col-md-4">
                                            <input type="text"  id="expected_designation" name="expected_designation" class="form-control input-sm" required/>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="input-field col s12">
                                        <label for="inputMessage">Expected Annual CTC<span
                                                class="mandatory">* </span></label>
                                    </div><div class="row">
                                        <div class="col-md-4">
                                            <select name="expected_annual_ctc" id="expected_annual_ctc" class="form-control" required>      

                                                <option value="0">Select</option>
                                                <option value="Upto 2L">Upto 2L</option>
                                                <option value="2L-4L">2L-4L</option>
                                                <option value="4L-8L">4L-8L</option>
                                                <option value="Above 10 L">Above 10 L</option> 
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="input-field col s12">
                                        <label for="inputMessage">Achievements</label>
                                    </div><div class="row">
                                        <div class="col-md-4">
                                            <textarea type="text" id="achievements" name="achievements" class="form-control textarea_count" rows="5"></textarea>

                                        </div>

                                    </div>
                                </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>

                            <input type="submit" value="SUBMIT" id="submitbasicdetails" name="submitbasicdetails" class="btn btn-primary submitBtn" >

                            </form>
                        </div>
                    </div>				
                </div>
            </div>

            <!-------------------------------------------------------------------------End  Modal Add USER Basic Details----------------------------------------------------------------------->











            <!------------------------------------------------------------------------------------------ Modal Add Employment------------------------------------------------------------------------------------------>
            <!-- Modal -->
            <div class="modal fade" id="modalFormAddEmployment" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title employment" id="myModalLabel">Add Employment</h4>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <p class="statusMsg"></p>
                            <form role="form" id="addEmployment"  class="addEmployment" method="post" action="my_profile.php">
                                <div class="form-group">
                                    <label for="inputName">Designation<span class="mandatory">* </span></label>
                                    <input type="text" class="form-control" id="designation" name="designation"
                                           placeholder="Type Your Designation" required /><input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">Organization<span class="mandatory">*
                                        </span></label> <input type="text" class="form-control"
                                                           id="organization" name="organization" placeholder="Type Your Organization" required />
                                </div>
                                <div class="form-group" id="company_radio">
                                    <label for="inputMessage">Is this your current company?<span class="mandatory">*
                                        </span></label> 
                                    <input  class="with-gap" id="current_company_yes"  name="current_company"
                                            type="radio" checked_yes="yes" required="required"><label for="yes">Yes</label>
                                    <input class="with-gap" id="current_company_no"  name="current_company" type="radio" checked_yes="no">
                                    <label for="no">No</label>
                                </div>
                               <!-- <div class="form-group">-->
                                   <!-- <div class="row">-->
                                        <!--<div class="input-field col s12">-->
                                         <div class="form-group">
                                            <label for="inputMessage">Started Working From<span
                                                    class="mandatory">* </span></label>
                                       <!-- </div>-->
                                       <div class="row">
                                        <div class="col-md-4 ">
                                            <select name="started_working_year" id="started_working_year" class="form-control" required>      
                                                <?php
                                                if ($_POST['year'] != '') {
                                                    $year = $_POST['year'];
                                                } else {
                                                    // $year = date('Y');
                                                }
                                                for ($i = 1965; $i <= date('Y-m-d', strtotime('+10 years')); $i ++) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"
                                                    <?php
                                                    if ($year == $i) {
                                                        echo "selected=selected";
                                                    }
                                                    ?>><?php echo $i; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 ">
                                            <select name="started_working_month" size='1' id="started_working_month" class="form-control" required>
                                                <option value="">Select Month</option>
                                                <?php
                                                for ($i = 0; $i < 12; $i ++) {
                                                    $time = strtotime(sprintf('%d months', $i));
                                                    $label = date('F', $time);
                                                    $value = date('F', $time);
                                                    ?>

                                                    <option value="<?php echo $label; ?>"
                                                    <?php
                                                    if ($month == $label) {
                                                        echo "selected=selected";
                                                    }
                                                    ?>><?php echo $label; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                            </select>
                                        </div>
                                         </div>
                                         </div>
                                   <!-- </div>-->
                                <!--</div>-->
                                <div class="form-group">
                                    
                                        <div class="input-field col s12">
                                            <label for="inputMessage">Worked Till<span class="mandatory">* </span></label>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select name="worked_till_year" id="worked_till_year" class="form-control" required>      
                                                <?php
                                                if ($_POST['year'] != '') {
                                                    $year = $_POST['year'];
                                                } else {
                                                    // $year = date('Y');
                                                }
                                                for ($i = 1965; $i <= date('Y-m-d', strtotime('+10 years')); $i ++) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="worked_till_month"  id="worked_till_month" size='1' class="form-control" required>
                                                <option value="">Select Month</option>
                                                <?php
                                                for ($i = 0; $i < 12; $i ++) {
                                                    $time = strtotime(sprintf('%d months', $i));
                                                    $label = date('F', $time);
                                                    $value = date('F', $time);
                                                    ?>

                                                    <option value="<?php echo $label; ?>"><?php echo $label; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">Describe your Job Profile<span class="mandatory">* </span></label> 
                                    <!--<input  type="text" class="form-control" id="description" name="description"
                                        placeholder="Type Your job description" required=""/>-->
                                    
                                    <textarea type="text" id="description" name="description" class="form-control textarea_count" rows="5" required=""></textarea>
                                                    <input type="text" class="smalltextBox" id="subLimit" value="500" disabled="disabled" style="width: 70px;margin-top: 10px;">
                                                    <label>(Enter Several Coma Separated Keywords or Short Sentences.) </label>
                                                    <span id="error_fresher_achievements" class="text-danger"></span>
                                </div>

                                <div class="form-group" id="notice_class">
                                    <label for="inputEmail">Notice Period</label> <input type="text"
                                                                                         class="form-control" id="noticeperiod" name="noticeperiod"
                                                                                         placeholder="Type Your NoticePeriod" />
                                </div>
                                <div class="form-group" id="ctc_class">
                                    <label for="inputEmail">Current CTC</label> <input type="text"
                                                                                       class="form-control" id="current_ctc" name="current_ctc"
                                                                                       placeholder="Type Your Current CTC" />
                                </div>
                                <input type="hidden" name="id" id="id">

                                </div>

                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>

                                    <input type="submit" value="SUBMIT" id="submitEmployment" name="submit" class="btn btn-primary submitBtn" >

                                    <div id="success_message" style="width:100%; height:100%; display:none; ">
                                        <h3>Sent your message successfully!</h3>
                                    </div>
                                    <div id="error_message"
                                         style="width:100%; height:100%; display:none; ">
                                        <h3>Error</h3>
                                        Sorry there was an error sending your form.

                                    </div></form>
                        </div>
                    </div>				
                </div>
            </div>

            <!-------------------------------------------------------------------------End Modal Add Employment------------------------------------------------------------------------->

            <!------------------------------------------------------------------------------------------ Modal Add Education------------------------------------------------------------------------------------------>
            <!-- Modal -->
            <div class="modal fade" id="modalFormAddEducation" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title education" id="myModalLabel" heading="education">Add Education</h4>
                        </div>

                        <form role="form" id="addEducation"  class="addEducation" method="post" action="my_profile.php">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="drop_values" id="drop_values">
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <p class="statusMsg"></p>
                                <div id="select_edu_div" name="select_edu_div">

                                    <select name="education_select" id="education_select" class="form-control" required>      
                                        <option value="">Select Education</option>


                                        <?php
                                        foreach ($qualification_names as $qn) {
                                            foreach ($qn as $q)
                                                echo"<option value=" . $q . ">";

                                            echo $q;
                                            echo " </option>";
                                        }
                                        ?>
                                    </select>
                                </div>


                                <div id="10th_add" name="10th_add" details="edu"> 
                                    <div id="10th" name="10th" value="<?php echo $ssc ?>" >			
                                        <div class="form-group" id="hidelabel">
                                            <label for="inputEmail"><strong>10th(SSC)</strong></label> 
                                        </div>
                                        <div class="form-group">
                                            <label for="school">Specialization<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="10th_spcl" name="10th_spcl" placeholder="Type Specialization" />
                                        </div>
                                        <div class="form-group">
                                            <label for="school">School/Institute<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="10th_school" name="10th_school" placeholder="Type School/Institute attended" />
                                        </div>
                                        <div class="form-group">
                                            <label for="school">University/Board<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="10th_university" name="10th_university" placeholder="Type University/Board attended" />
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail">10th(SSC) Percentage/CGPA<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="10th_percentage" name="10th_percentage" placeholder="Type 10th Percentage/CGPA" />
                                        </div>     
                                        <div class="form-group">
                                            <label for="inputEmail">Marks Obtained<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="10th_marks" name="10th_marks" placeholder="Type 10th Marks" />
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail">Year of Passing<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="10th_Pyear" name="10th_Pyear" placeholder="Type 10th Year of Passing"/>
                                        </div>
                                    </div>
                                </div>
                                <div id="12th_add" name="12th_add" details="edu">
                                    <div id="12th" name="12th" value="<?php echo $hsc ?>" >


                                        <div class="form-group" id="hidelabel">
                                            <label for="inputEmail"><strong>12th(HCS) </strong></label> 
                                        </div>
                                        <div class="form-group">
                                            <label for="school">Specialization<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="12th_spcl" name="12th_spcl" placeholder="Type Specialization" />
                                        </div>

                                        <div class="form-group">
                                            <label for="school">School/Institute<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="12th_school" name="12th_school" placeholder="Type School/Institute attended" />
                                        </div> 
                                        <div class="form-group">
                                            <label for="school">University/Board<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="12th_university" name="12th_university" placeholder="Type University/Board attended"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputMessage">12th(HCS) Percentage/CGPA<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="12th_percentage" name="12th_percentage" placeholder="Type 12th Percentage/CGPA" />
                                        </div>
                                        <div class="form-group">
                                            <label for="inputMarks">Marks Obtained<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="12th_marks" name="12th_marks" placeholder="Type 12th Marks" />
                                        </div>	

                                        <div class="form-group">
                                            <label for="inputEmail">Physics Marks<span class="mandatory">
                                                </span></label> <input type="text" class="form-control"
                                                                   id="12th_physics_marks" name="12th_physics_marks" placeholder="Type 12th Physics Marks"/>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail">Chemistry Marks<span class="mandatory">
                                                </span></label> <input type="text" class="form-control"
                                                                   id="12th_chemistry_marks" name="12th_chemistry_marks" placeholder="Type 12th Chemistry Marks" subject="subject"/>
                                        </div>                                       
                                        <div class="form-group">
                                            <label for="inputEmail">Maths Marks<span class="mandatory">
                                                </span></label> <input type="text" class="form-control"
                                                                   id="12th_maths_marks" name="12th_maths_marks" placeholder="Type 12th Maths Marks" subject="subject"/>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail">Year of Passing<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="12th_Pyear" name="12th_Pyear" placeholder="Type 12th Year of Passing"/>
                                        </div>
                                    </div>
                                </div>
                                <div id="be_add" name="be_add"  details="edu">
                                    <div class="form-group" id="hidelabel">
                                        <label for="inputEmail"><strong>BE</strong></label>  
                                    </div>
                                    <div id="be" name="be">
                                        <div class="form-group">
                                            <label for="school">Specialization<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="be_spcl" name="be_spcl" placeholder="Type Specialization"  />
                                        </div>

                                        <div class="form-group">
                                            <label for="school">School/Institute<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="be_school" name="be_school" placeholder="Type School/Institute attended"  />
                                        </div>
                                        <div class="form-group">
                                            <label for="school">University/Board<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="be_university" name="be_university" placeholder="Type University/Board attended" />
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail">BE Percentage/CGPA<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="be_percentage" name="be_percentage" placeholder="Type BE Percentage/CGPA"  />
                                        </div>     
                                        <div class="form-group">
                                            <label for="inputEmail">Marks Obtained<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="be_marks" name="be_marks" placeholder="Type BE Marks" />
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail">Year of Passing<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="be_Pyear" name="be_Pyear" placeholder="Type BE Year of Passing" />
                                        </div>
                                    </div>
                                </div>
                                <div id="btech_add" name="btech_add" details="edu">        

                                    <div class="form-group" id="hidelabel">
                                        <label for="inputEmail"><strong>B.Tech</strong></label> 
                                    </div>
                                    <div id="btech" name="btech">
                                        <div class="form-group">
                                            <label for="school">Specialization<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="btech_spcl" name="btech_spcl" placeholder="Type Specialization" />
                                        </div>
                                        <div class="form-group">
                                            <label for="school">School/Institute<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="btech_school" name="btech_school" placeholder="Type School/Institute attended"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="school">University/Board<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="btech_university" name="btech_university" placeholder="Type University/Board attended"  />
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail">B.Tech Percentage/CGPA<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="btech_percentage" name="btech_percentage" placeholder="Type B.Tech Percentage/CGPA"  />
                                        </div>     
                                        <div class="form-group">
                                            <label for="inputEmail">Marks Obtained<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="btech_marks" name="btech_marks" placeholder="Type B.Tech Marks" />
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail">Year of Passing<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="btech_Pyear" name="btech_Pyear" placeholder="Type B.Tech Year of Passing" />
                                        </div></div></div>

                                <div id="me_add" name="me_add" details="edu">                           
                                    <div class="form-group" id="hidelabel">
                                        <label for="inputEmail" ><strong>ME</strong></label>                                    </div>
                                    <div id="me" name="me">   
                                        <div class="form-group">
                                            <label for="school">Specialization<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="me_spcl" name="me_spcl" placeholder="Type Specialization"  />
                                        </div>
                                        <div class="form-group">
                                            <label for="school">School/Institute<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="me_school" name="me_school" placeholder="Type School/Institute attended" />
                                        </div>
                                        <div class="form-group">
                                            <label for="school">University/Board<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="me_university" name="me_university" placeholder="Type University/Board attended" />
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail">ME Percentage/CGPA<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="me_percentage" name="me_percentage" placeholder="Type ME Percentage/CGPA" />
                                        </div>     
                                        <div class="form-group">
                                            <label for="inputEmail">Marks Obtained<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="me_marks" name="me_marks" placeholder="Type ME Marks" />
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail">Year of Passing<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="me_Pyear" name="me_Pyear" placeholder="Type ME Year of Passing" />
                                        </div></div></div>
                                <div id="mtech_add" name="mtech_add" details="edu">
                                    <div class="form-group" id="hidelabel">
                                        <label for="inputEmail" ><strong>M.Tech</strong></label>
                                    </div>
                                    <div id="mtech" name="mtech">
                                        <div class="form-group">
                                            <label for="school">Specialization<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="mtech_spcl" name="mtech_spcl" placeholder="Type Specialization"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="school">School/Institute<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="mtech_school" name="mtech_school" placeholder="Type School/Institute attended" />
                                        </div>
                                        <div class="form-group">
                                            <label for="school">University/Board<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="mtech_university" name="mtech_university" placeholder="Type University/Board attended" />
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail">M.Tech Percentage/CGPA<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="mtech_percentage" name="mtech_percentage" placeholder="Type M.Tech Percentage/CGPA" />
                                        </div>     
                                        <div class="form-group">
                                            <label for="inputEmail">Marks Obtained<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="mtech_marks" name="mtech_marks" placeholder="Type M.Tech Marks" />
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail">Year of Passing<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="mtech_Pyear" name="mtech_Pyear" placeholder="Type M.Tech Year of Passing"  />
                                        </div>
                                    </div>
                                </div>
                                <div id="msc_add" name="msc_add" details="edu">
                                    <div class="form-group" id="hidelabel">
                                        <label for="inputEmail" ><strong>MSc</strong></label> 
                                    </div>
                                    <div id="msc" name="msc"> 

                                        <div class="form-group">
                                            <label for="school">Specialization<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="msc_spcl" name="msc_spcl" placeholder="Type Specialization" />
                                        </div>
                                        <div class="form-group">
                                            <label for="school">School/Institute<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="msc_school" name="msc_school" placeholder="Type School/Institute attended" />
                                        </div>
                                        <div class="form-group">
                                            <label for="school">University/Board<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="msc_university" name="msc_university" placeholder="Type University/Board attended"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail">MSc Percentage/CGPA<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="msc_percentage" name="msc_percentage" placeholder="Type MSc Percentage/CGPA"/>
                                        </div>     
                                        <div class="form-group">
                                            <label for="inputEmail">Marks Obtained<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="msc_marks" name="msc_marks" placeholder="Type MSc Marks" />
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail">Year of Passing<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="msc_Pyear" name="msc_Pyear" placeholder="Type MSc Year of Passing"/>
                                        </div>
                                    </div>
                                </div>
                                <div id="phd_add" name="phd_add" details="edu">
                                    <div class="form-group" id="hidelabel">
                                        <label for="inputEmail" ><strong>PHD</strong></label> 
                                    </div>
                                    <div id="phd" name="phd">
                                        <div class="form-group">
                                            <label for="school">Specialization<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="phd_spcl" name="phd_spcl" placeholder="Type Specialization" />
                                        </div>
                                        <div class="form-group">
                                            <label for="school">School/Institute<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="phd_school" name="phd_school" placeholder="Type School/Institute attended" />
                                        </div>
                                        <div class="form-group">
                                            <label for="school">University/Board<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="phd_university" name="phd_university" placeholder="Type University/Board attended" />
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail">PhD Percentage/CGPA<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="phd_percentage" name="phd_percentage" placeholder="Type PhD Percentage/CGPA" />
                                        </div>     
                                        <div class="form-group">
                                            <label for="inputEmail">Marks Obtained<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="phd_marks" name="phd_marks" placeholder="Type PhD Marks" />
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail">Year of Passing<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="phd_Pyear" name="phd_Pyear" placeholder="Type PhD Year of Passing" />
                                        </div>
                                    </div></div>
                                <!--<div id="gate_add" name="gate_add" details="edu">

                                    <div class="form-group" id="hidelabel">
                                        <label for="inputEmail" ><strong>GATE Score</strong></label> 
                                    </div>
                                    <div id="gate" name="gate">
                                        <div class="form-group">
                                            <label for="school">Domain<span class="mandatory">*
                                                </span></label>
                                            <select name="domain" id="domain" size='1' class="form-control">
                                                <option value="">Select Domain</option> 
                                                <option value="Mechanical">Mechanical</option>
                                                <option value="Electronics">Electronics</option>
                                                <option value="Electrical">Electrical</option>
                                                <option value="Aerospace">Aerospace</option> 
                                                <option value="Chemical">Chemical</option> 
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="school">All India Rank<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="gate_score" name="gate_score" placeholder="Type All India Rank" />
                                        </div>
                                        <div class="form-group">
                                            <label for="school">Marks<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="gate_marks" name="gate_marks" placeholder="Type Marks" />
                                        </div>
                                        <div class="form-group">
                                            <label for="school">Year Of Passing<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                                   id="gate_Pyear" name="gate_Pyear" placeholder="Type Year of Passing" />
                                        </div>                                 
                                    </div></div>-->

                            </div>		<div class="modal-footer">

                                <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>


                                <input type="submit" value="SUBMIT" id="submiteducation" name="submiteducation" class="btn btn-primary submitBtn" >


                            </div>
                        </form>

                    </div>
                  
                </div>
            </div>				
        </div>
    </div>

    <!--------------------------------------------------------------------------------------------End Modal Add Employment------------------------------------------------------------------------->


    <!------------------------------------------------------------------------------------------ Modal Add USER skills------------------------------------------------------------------------------------------>
    <!-- Modal -->
    <div class="modal fade" id="modalFormAddSkill" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="location.reload();">
                        <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title skill" id="myModalLabel">Add Skills And Tools</h4>
                    <label>Specify details about programming languages (such as Java, Python, C/C++, Oracle, SQL etc), softwares (Microsoft Word, Excel, Tally etc) or any other software related knowledge.Specify details about Tools used (ANSYS,Matlab,OpenFOAM) or any other tools related knowledge.</label>
                </div>

                <!-- Modal Body -->
                  <form role="form" id="addSkill"  class="addSkill" method="post" action="my_profile.php">
                <div class="modal-body">
                    <p class="statusMsg"></p>
                  
                        <input type="hidden" name="us_id" id="us_id" >
                        <div class="form-group">
                            <label for="inputName">Programming Languages<span class="mandatory">* </span></label>

                            <select name="skill_id[]" id="skill_id" class="form-control" required multiple="multiple"><?php foreach ($skills as $skill) { ?>
                                    <option value="<?php echo $skill['name']; ?>"><?php echo $skill['name']; ?></option>
                                <?php }
                                ?></select>
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>"><input type="hidden" name="id" id="id">
                        </div>
                             <input type="hidden" name="tooledit_id" id="tooledit_id" >
                    <div class="form-group">
                        <label for="inputName">Softwares Name<span class="mandatory">* </span></label>
                        
                        <select name="tool_id[]" id="tool_id" class="form-control" required multiple><?php foreach ($tools as $tool) { ?>
                                <option value="<?php echo $tool['name']; ?>"><?php echo $tool['name']; ?></option>
                            <?php }
                            ?></select>
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>"><input type="hidden" name="id" id="id">
                    </div>
                    <!--div class="form-group">
                        <label for="inputEmail">Tool Version
                        </label> <input type="text" class="form-control"
                                        id="tool_version" name="tool_version" placeholder="Version"/>
                    </div>
                    <div class="form-group">
                        <label for="inputMessage">Tool Last Used<span class="mandatory">*
                            </span></label>	<select name="last_used" id="tool_last_used" class="form-control" required>      
                            <?php /*
                            if ($_POST['year'] != '') {
                                $year = $_POST['year'];
                            } else {
                                // $year = date('Y');
                            }
                            for ($i = 2000; $i <= date('Y'); $i ++) {
                                ?>
                                <option value="<?php echo $i; ?>"
                                <?php
                                if ($year == $i) {
                                    echo "selected=selected";
                                }
                                ?>><?php echo $i; ?></option>
                                        <?php
                                    } */
                                    ?>
                        </select>
                    </div-->

                    <div class="form-group">
                        
                            <div class="input-field col s12">
                                <label for="inputMessage">Tool Source of Learning<span
                                        class="mandatory">* </span></label>
                            </div><div class="row">
                            <div class="col-md-12">
                                <select name="source" id="source" class="form-control" required>      
                                    <option value="">Select Source of Learning</option>
                                    <option value="Taken Course">Taken Course</option>
                                    <option value="Acquired on job">Acquired on job</option>

                                </select>
                            </div>

                        </div></div>
                    <div class="form-group">
                        
                            <div class="input-field col s12">
                                <label for="inputMessage">Operating Systems<span
                                        class="mandatory">* </span></label>
                            </div><div class="row">
                            <div class="col-md-12">
                                <select name="operating_systems" id="operating_systems"  class="form-control" required>
                                    <option value="">Select Operating Systems</option> 
                                    <option value="Linux">Linux</option>
                                    <option value="Windows XP/7/8/10">Windows XP/7/8/10</option>
                                 
                                </select>
                            </div>
                        </div>
                    </div>
          
                        
                    

                       
                    			


          
 </div>


            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.reload();">CLOSE</button>
                <input type="submit" value="SUBMIT" id="submitskills" name="submitskills" class="btn btn-primary submitBtn" >
            </div>
            </form>
                      </div>
                     
        </div>
    </div>				


<!-------------------------------------------------------------------------End  Modal Add USER skills------------------------------------------------------------------------>




<!------------------------------------------------------------------------------------------ Modal Add USER Personal------------------------------------------------------------------------------------------>
<!-- Modal -->
<div class="modal fade" id="modalFormAddPersonal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span>
                </button>
                <h3 class="modal-title personal" id="myModalLabel">Personal Details</h3>

            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                <form role="form" id="addPersonal"  class="addPersonal" method="post" action="my_profile.php">
                    <?php foreach ($userdetails as $userdetail) { ?>
                        <div class="form-group">
                            <label for="inputName">Date of Birth<span class="mandatory">* </span></label>
                            <input type='text' class="form-control  datepicker"  id='date_of_birth' name="date_of_birth" value="<?php echo $userdetail['date_of_birth']; ?>" required=""/>
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <input type="hidden" name="get_id" value="<?php echo $userdetail['user_id']; ?>">
                        </div>                   
                        <div class="form-group">
                            <label for="inputMessage">Permanent Address<span class="mandatory">* </span></label>
                            <input type='text' class="form-control"  id='permanent_address' name="permanent_address" value="<?php echo $userdetail['permanent_address']; ?>" required=""/>
                        </div>
                        <div class="form-group">
                            <label for="inputMessage">Current Address<span class="mandatory">* </span></label> <input type="checkbox" id="filladdress" name="filladdress" />Same as above
                            <input type='text' class="form-control"  id='current_address' name="current_address" value="<?php echo $userdetail['current_address']; ?>" required=""/>
                        </div>

                        <!--<div class="form-group">
                            <label for="inputMessage">Pin Code</label><input type='text' class="form-control"  id='pin_code' name="pin_code"  value="<?php echo $userdetail['pin_code']; ?>"/>

                        </div>-->
                        <div class="form-group">
                            <label for="inputMessage">Passport Number</label><input type='text' class="form-control"  id='passport_number' name="passport_number"  value="<?php echo $userdetail['passport_number']; ?>"/>

                        </div>
                    <?php } ?>


                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>

                        <input type="submit" value="SUBMIT" id="submitpersonal" name="submitpersonal" class="btn btn-primary submitBtn" >
                    </div>
                </form>
            </div>
        </div>				
    </div>
</div>

<!-------------------------------------------------------------------------End  Modal Add USER Personal------------------------------------------------------------------------>


<!------------------------------------------------------------------------------------------ Modal Resume Headline------------------------------------------------------------------------------------------>
<!-- Modal -->
<div class="modal fade" id="modalFormResumeHeadline" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title headline" id="myModalLabel">Add Resume Headline</h4>
                <label>It is the first thing recruiters notice in your profile. Write concisely what makes you unique and right person for the job you are looking for.</label>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                <form role="form" id="addResumeHeadline"  class="addResumeHeadline" method="post" action="my_profile.php">
                    <div class="form-group">
                        <label for="inputName">Resume Headline<span class="mandatory">* </span></label>

                        <textarea class="form-control"
                                  id="resume_headline" name="resume_headline"  required /></textarea>
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                        <input type="hidden" name="idheadline" id="idheadline">
                    </div>


                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>

                        <input type="submit" value="SUBMIT" id="submitresumeheadline" name="submitresumeheadline" class="btn btn-primary submitBtn" >

                        <div id="success_message" style="width:100%; height:100%; display:none; ">
                            <h3>Sent your message successfully!</h3>
                        </div>
                        <div id="error_message" style="width:100%; height:100%; display:none; ">
                            <h3>Error</h3>
                            Sorry there was an error sending your form.
                        </div></form>
            </div>
        </div>				
    </div>
</div>
</div>
<!-------------------------------------------------------------------------End  Modal Resume Headline------------------------------------------------------------------------>

<!------------------------------------------------------------------------------------------ Modal Resume Headline------------------------------------------------------------------------------------------>
<!-- Modal -->
<div class="modal fade" id="modalFormGATEdetails" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span>
                </button>
                <h3 class="modal-title gate_details" id="myModalLabel">Add GATE Details</h3>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                <form role="form" id="addGateDetails"  class="addGateDetails" method="post" action="my_profile.php">
                    
  <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
  <input type="hidden" name="update" id="update">

                                    <div class="form-group" id="hidelabel">
                                        <label for="inputEmail" ><strong>GATE Score</strong></label> 
                                    </div>
                                    <div id="gate" name="gate">
                                        <div class="form-group">
                                            <label for="school">Domain<span class="mandatory">*
                                                </span></label>
                                            <select name="domain" id="domain" size='1' class="form-control" required="">
                                                <option value="">Select Domain</option> 
                                                <option value="Mechanical">Mechanical</option>
                                                <option value="Electronics">Electronics</option>
                                                <option value="Electrical">Electrical</option>
                                                <option value="Aerospace">Aerospace</option> 
                                                <option value="Chemical">Chemical</option> 
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="school">All India Rank<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                       id="gate_score" name="gate_score" placeholder="Type All India Rank" required=""/>
                                        </div>
                                        <div class="form-group">
                                            <label for="school">Marks<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                       id="gate_marks" name="gate_marks" placeholder="Type Marks" required=""/>
                                        </div>
                                        <div class="form-group">
                                            <label for="school">Year Of Passing<span class="mandatory">*
                                                </span></label> <input type="text" class="form-control"
                                                       id="gate_Pyear" name="gate_Pyear" placeholder="Type Year of Passing" required=""/>
                                        </div>                                 
                                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>

                        <input type="submit" value="SUBMIT" id="submigatedetails" name="submitgatedetails" class="btn btn-primary submitBtn" >

                        <div id="success_message" style="width:100%; height:100%; display:none; ">
                            <h3>Sent your message successfully!</h3>
                        </div>
                        <div id="error_message" style="width:100%; height:100%; display:none; ">
                            <h3>Error</h3>
                            Sorry there was an error sending your form.
                        </div>
            </div>
                    </form>
        </div>				
    </div>
</div>
</div>
<!---------------------------------------End GATE Details Modal---------------------------------------------------------->

</div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>


<script>
   
    
    $('#date_of_birth').datepicker({
    dateFormat: 'dd-mm-yy'
});
    
    
function myFunction(element, event)
{
    //alert('hi');
var brands = $('#multiple-checkboxes option:selected');
                var selected = [];
                $(brands).each(function (index, brand) {
                selected.push([$(this).val()]);
        });
        
        if(selected.length>3)
        {
                 var lastEl = $(selected).last()[0];
                $(' #multiple-checkboxes').multiselect('deselect', [lastEl]);
                selected.pop();
                alert('Select upto 3 locations only');
        }
 
};
</script>
<script>
    function select_education(edu_name) {


        $("form#addEducation").find('div').each(function () {
            $("div#hidelabel").hide();
            if ($(this).attr('details') === 'edu')
            {
                var name = ($(this).attr('id'));
                if (name === (edu_name + "_add"))
                {
                    $(this).show();
                    $("#" + name + " input[type='text']").each(function () {
                        $(this).attr("required", true);
                        if ($(this).attr("subject") === 'subject')
                        {
                            $(this).attr("required", false);
                        }
                    });
                } else
                {
                    $(this).hide();
                    $("#" + name + " input[type='text']").each(function () {
                        $(this).attr("required", false);
                    });
                }

            }

        });
    }
    function edit_education(edu_name) {


        $(".edit_education" + edu_name).click(function () {
            $("#education_select").prop("disabled", true);
            //alert('editeducation');
            var name1 = $(this).attr('edu_find');
            //alert(name1);
            $("form#addEducation").find('div').each(function () {
                $("div#hidelabel").show();
                if ($(this).attr('details') === 'edu')
                {
                    var name = ($(this).attr('id'));
                    //alert(name);
                    if (name === (name1 + "_add"))
                    {
                        $(this).show();
                        $("#" + name + " input[type='text']").each(function () {
                            $(this).attr("required", true);
                            if ($(this).attr("subject") === 'subject')
                            {
                                $(this).attr("required", false);
                            }
                        });
                    } else
                    {
                        $(this).hide();
                        $("#" + name + " input[type='text']").each(function () {
                            $(this).attr("required", false);
                        });
                    }
                }

            });


        });


    }




    $(document).ready(function () {
       $('#skill_id').multiselect('destroy');
         $('#tool_id').multiselect('destroy');
       $('#btnShowSkills').click(function () {
           //$("addSkill")[0].reset();
        $('#skill_id').multiselect(
        {            
            buttonWidth: '100%',
                nonSelectedText: 'Select Skills',
                 templates: {button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown" style="background:#fff;color: #000;"><span class="multiselect-selected-text" style="float:left"></span> <span style="float:right"><b class="caret"></b></span></button>'},
            });
              $('#tool_id').multiselect(
        {            
            buttonWidth: '100%',
                nonSelectedText: 'Select Tools', 
                templates: {button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown" style="background:#fff;color: #000;"><span class="multiselect-selected-text" style="float:left"></span> <span style="float:right"><b class="caret"></b></span></button>'},
            });
       });
         
        $val = "";

        $("#notice_class").hide();
        $("#ctc_class").hide();
        $("#10th_add").hide();
        $("#12th_add").hide();
        $("#be_add").hide();
        $("#phd_add").hide();
        $("#me_add").hide();
        $("#btech_add").hide();
        $("#mtech_add").hide();
        $("#msc_add").hide();
        $("#gate_add").hide();

        $("#btnShowEducation").click(function () {
            $("#education_select").prop("disabled", false);
            $("#10th_add").hide();
            $("#12th_add").hide();
            $("#be_add").hide();
            $("#phd_add").hide();
            $("#me_add").hide();
            $("#btech_add").hide();
            $("#mtech_add").hide();
            $("#msc_add").hide();
            $("#gate_add").hide();
            $('.education').text("Add Education");
            $('#submiteducation').val("SUBMIT");


        });





        $('#company_radio input[type="radio"]').click(function () {
            if ($('input[name="current_company"]:checked').attr('checked_yes') === 'yes')
                    ///alert($val);

                    {
                        const monthNames = ["January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December"
                        ];
                        $('input[name="current_company"]:checked').val('yes');
                        $("#notice_class").show();
                        $("#ctc_class").show();
                        var currentTime = new Date();
                        $("#worked_till_year").val(currentTime.getFullYear());
                        //alert(monthNames[currentTime.getMonth() + 1]);
                        $("#worked_till_month").val(monthNames[currentTime.getMonth()]);

                    }

            if ($('input[name="current_company"]:checked').attr('checked_yes') === 'no')
            {
                $('input[name="current_company"]:checked').val('no');
                $("#notice_class").hide();

                $("#ctc_class").hide();
            }



        });

        edit_education('10th');
        edit_education('12th');
        edit_education('be');
        edit_education('me');
        edit_education('btech');
        edit_education('mtech');
        edit_education('msc');
        edit_education('phd');
        edit_education('gate');

        $("#education_select").on("change", function () {
            $("#10th_add").hide();
            $("#12th_add").hide();
            $("#be_add").hide();
            $("#phd_add").hide();
            $("#me_add").hide();
            $("#btech_add").hide();
            $("#mtech_add").hide();
            $("#msc_add").hide();
            $("#gate_add").hide();
            var selectedVal = $(this).find(':selected').val();
            if (selectedVal === '10th') {
                select_education('10th');
            }
            if (selectedVal === '12th') {
                select_education('12th');
            }
            if (selectedVal === 'BE') {
                select_education('be');
            }
            if (selectedVal === 'B.Tech') {
                select_education('btech');
            }
            if (selectedVal === 'ME') {
                select_education('me');
            }
            if (selectedVal === 'M.Tech') {
                select_education('mtech');
            }
            if (selectedVal === 'M.Sc') {
                select_education('msc');
            }
            if (selectedVal === 'PhD') {
                select_education('phd');
            }
            if (selectedVal === 'GATE') {
                select_education('gate');
            }


        });

        $("#filladdress").on("click", function () {

            if (this.checked) {
                $("#current_address").val($("#permanent_address").val());
            } else {
                $("#current_address").val('');
            }

        });

        
            
          $(document).ready(function () { 
            /*$('#multiple-checkboxes').multiselect(
                    {
                        buttonWidth: '100%',
                        nonSelectedText: 'Select upto 3',
                        templates: {button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown" style="background:#fff;color: #000;"><span class="multiselect-selected-text" style="float:left"></span> <span style="float:right"><b class="caret"></b></span></button>'},
                        onChange: function (element, checked) {
                            var selectedOptions = $('#multiple-checkboxes option:selected');
 
                if (selectedOptions.length >= 3) {
                    // Disable all other checkboxes.
                    var nonSelectedOptions = $('#multiple-checkboxes option').filter(function() {
                        return !$(this).is(':selected');
                    });
 
                    nonSelectedOptions.each(function() {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', true);
                        input.parent('li').addClass('disabled');
                    });
                }
                else {
                    // Enable all checkboxes.
                    $('#multiple-checkboxes option').each(function() {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', false);
                        input.parent('li').addClass('disabled');
                    });
                }
  //$('#multiple-checkboxes').multiselect('select', ['Pune']).trigger("chosen:updated");

                        },
                                



                    });*/

        });




    });
</script>


<?php include_once ('includes/footer.php'); ?>
