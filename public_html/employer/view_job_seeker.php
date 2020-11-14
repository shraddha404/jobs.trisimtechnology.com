<?php
session_start();
//include_once ('includes/php_header.php');
include_once $_SERVER['DOCUMENT_ROOT'] . '/../lib/User.class.php';
$u = new User($_GET['id']);
if (empty($_SESSION['user_id'])) {
    header("Location:/login.php");
}


if ($_SESSION['user_type'] == 'Employer' && (!empty($_GET['id']))) {
    $userdetails = $u->getUserDetails($_GET['id']);
    $employmentdetails = $u->getUserEmploymentDetails($_GET['id']);
    $educationdetails = $u->getUserEducationDetails($_GET['id']);
    $education = $u->getEducationDetails($_GET['id']);
    $education_subject = $u->getEducationSubjectDetails($_GET['id']);
    $skills = $u->getSkills();
    $userskills = $u->getUserSkillsDetails($_GET['id']);
    $usertools = $u->getUserToolsDetails($_GET['id']);
    $resumeheadline = $u->getUserResumeHeadlineDetails($_GET['id']);
    $user_education = $u->getEducationDetails($_GET['id']);
    $user_education_count = $u->countEducationDetails($_GET['id']);
}


$ssc = (($user_education_count['10th'] <= 0) ? 'show' : 'hide');
$hsc = (($user_education_count['12th'] <= 0) ? 'show' : 'hide');
$be_edit = (($user_education_count['BE'] <= 0) ? 'show' : 'hide');
$me_edit = (($user_education_count['ME'] <= 0) ? 'show' : 'hide');
$mtech_edit = (($user_education_count['M.Tech'] <= 0) ? 'show' : 'hide');
$btech_edit = (($user_education_count['B.Tech'] <= 0) ? 'show' : 'hide');
$msc_edit = (($user_education_count['M.Sc'] <= 0) ? 'show' : 'hide');
$phd_edit = (($user_education_count['PhD'] <= 0) ? 'show' : 'hide');
$gate_edit = (($user_education_count['GATE'] <= 0) ? 'show' : 'hide');


include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<script>
   $(document).ready(function () {
    $('.btnShowBasic').click(function (e){
        var id = $(this).attr("id");
        var root = document.location.hostname;
        $.ajax({
            url: "/get_basicdetails.php",
            method: "POST",
            data: {id: id},
            dataType: "json",
            success: function (data) {
                //alert(data.profile_name);
                //jQuery.noConflict();

               $('#profile_name').val(data.profile_name);
                 $('#username').val(data.username);
                  $('#gender').val(data.gender);
                  $('#key_words').val(data.skills_expertise);
                $('#mobile_number').val(data.mobile_number);
                $('#current_ctc_lakhs').val(data.current_ctc_lakhs);
                $('#current_ctc_thousands').val(data.current_ctc_thousands); 
                //$('#multiple-checkboxes').val( [data.job_location1, data.job_location2,data.job_location3]).trigger('chosen:updated');
 //$("#multiple-checkboxes").multiselect("widget").find(":checkbox[value='"+data.job_location1+"']").attr("checked","checked");
  //$("#multiple-checkboxes option[value='" + data.job_location1 + "']").attr("selected", 1);
  //$("#multiple-checkboxes").multiselect("refresh");
                $('#work_exp_years').val(data.work_exp_years);
                $('#work_exp_months').val(data.work_exp_months);
                $('#city').val(data.city);
                $('#email').val(data.email);
                $('#profile_photo').val(data.profile_photo);
                $('#id').val(data.user_id);
                $('#expected_annual_ctc').val(data.expected_salary);
                $('#expected_designation').val(data.expected_designation);
                $('#achievements').val(data.achivements);            
                      $('#multiple-checkboxes').multiselect(
                              'select', [data.job_location1, data.job_location2,data.job_location3]
                              ).trigger("chosen:updated");
                      


                $('.basic').text("Update Basic Details");
                $('#modalFormBasicDetails').modal('show');
            }
        });
           
        });
    });


    </script>
<div class="container">
    <div class="single">
        <div class="form-container">
            <h2>Profile</h2>
           
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
                                    <li class="collection-item"><span class="text"><a href="#Headline" >Resume Headline</a></span></li>
                                    <li class="collection-item"><span class="text"><a href="#Skill" >Skills</a></span></li>
                                    <li class="collection-item"><span class="text"><a href="#Employment" >Employment</a></span></li>
                                    <li class="collection-item"><span class="text"><a href="#Education" >Education</a></span></li>
                                    <li class="collection-item"><span class="text"><a href="#Projects" >Projects</a></span></li>
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

                                                            <div class="col-md-2"><?php if (empty($userdetails[0]['profile_photo'])) { ?>	<img src="/images/noimages.jpeg" width="100px" height="100px"><?php } else { ?>
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
                                                                    ?></b><br /><br />

                                                                <img src="/images/phone-outline.png" width="15px" height="15px">&nbsp;&nbsp;<?php echo $userdetails[0]['mobile_number']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <img src="/images/exp.png" width="15px" height="15px">&nbsp;&nbsp;<?php echo $userdetails[0]['work_exp_years'] . "  years  " ?><br /><br />
                                                                <img src="/images/rupee.png" width="15px" height="15px">&nbsp;&nbsp;<?php echo urldecode($userdetails[0]['current_ctc_lakhs'] )."lakh"?>&nbsp;&nbsp;
                                                                <img src="/images/email.png" width="15px" height="15px">&nbsp;&nbsp;<?php echo $userdetails[0]['email']; ?><br />
                                                            </div>
                                                            <div class="col-md-1"><?php if ($_SESSION['user_type']== 'Admin'){?><input type="button" class="btn btn-info btn-xs btnShowBasic" data-toggle="modal"  value="view" id="<?php echo $userdetails[0]['id']; ?>"
                                                                                         data-target="#modalFormBasicDetails"><?php } ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!------------------------------------------------------------------------------------------End User Basic Details Header------------------------------------------------------------------------------------------>
                        
                        
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
                           
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" path="profile_name" id="profile_name" name="profile_name" class="form-control" value=""/>
                                    <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">


                                </div> <div class="form-group">
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
                                            <?php if (empty($userdetails[0]['profile_photo'])) { ?>	
                                                <img src="/images/noimages.jpeg" width="100px" height="100px">
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

                        </div>

                        <!-- Modal Footer -->
                       
                    </div>				
                </div>
          
                 
                            
                                     <div class="row" id="ResumeHeadline">
                                <div class="form-group col-md-12">
                                    <div class="profile-box-white">
                                        <div class="row">
                                            <div class="form-group col-md-12">

                                                <div class="col-md-6"><h3><b>Resume Headline</b>
                                                        &nbsp;&nbsp;
                                                            <br/><br/></h3>

                                                    <?php echo $resumeheadline[0]['resume_headline']; ?>


                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                              <div class="row" id="Employment">
                                <div class="form-group col-md-12">




                                    <div class="profile-box-white">
                                        <div class="row">
                                            <div class="form-group col-md-12">

                                                <div class="col-md-6"><h3><b>Employment</b></h3></div>
                                               

                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php if(!empty($employmentdetails)){foreach ($employmentdetails as $employmentdetail) { ?>
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
                                            <?php }} ?>

                                        </div>													
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            <div class="row" id="Education">
                                <div class="form-group col-md-12">
                                    <div class="profile-box-white">
                                        <div class="row">
                                            <div class="form-group col-md-12">

                                                <div class="col-md-6"><h3><b>Education</b></h3></div>
                                               

                                            </div>
                                        </div>
                                        <div class="row">

                                            <?php
                                            if ($ssc == 'hide') {
                                                $name = '10th(SSC)';
                                                $u->displayEducationDetailstoEmployer($education['10th'], $name, '10th');
                                            }
                                            ?>



                                            <?php
                                            if ($hsc == 'hide') {
                                                $name = '12th(HSC)';
                                                $u->display12thDetailstoEmployer($education['12th'], $name, '12th');
                                            }
                                            ?>


                                            <?php
                                            if ($be_edit == 'hide') {
                                                $name = 'BE';
                                                $u->displayEducationDetailstoEmployer($education['BE'], $name, 'be');
                                            }
                                            ?>


                                            <?php
                                            if ($me_edit == 'hide') {
                                                $name = 'ME';
                                                $u->displayEducationDetailstoEmployer($education['ME'], $name, 'me');
                                            }
                                            ?>
                                            <?php
                                            if ($mtech_edit == 'hide') {
                                                $name = 'MTech';
                                                $u->displayEducationDetailstoEmployer($education['M.Tech'], $name, 'mtech');
                                            }
                                            ?>



                                            <?php
                                            if ($btech_edit == 'hide') {
                                                $name = 'BTech';
                                                $u->displayEducationDetailstoEmployer($education['B.Tech'], $name, 'btech');
                                            }
                                            ?>


                                            <?php
                                            if ($msc_edit == 'hide') {
                                                $name = 'MSc';
                                                $u->displayEducationDetailstoEmployer($education['M.Sc'], $name, 'msc');
                                            }
                                            ?>



                                            <?php
                                            if ($phd_edit == 'hide') {
                                                $name = 'PhD';
                                                $u->displayEducationDetailstoEmployer($education['PhD'], $name, 'phd');
                                            }
                                            ?>
                                            <?php
                                            if ($gate_edit == 'hide') {
                                                $name = 'GATE';
                                                $u->displayGateDetailstoEmployer($education['GATE'], $name, 'gate');
                                            }
                                            ?>


                                        </div>													
                                    </div>
                                </div>
                            </div>
                        
                        <div class="row"  id="Skill">
                                <div class="form-group col-md-12">

                                    <div class="profile-box-white">
                                        <div class="row">
                                            <div class="form-group col-md-12">

                                                <div class="col-md-6"><h3><b>Skills</b></h3></div>
                                               

                                            </div>
                                        </div>
                                        <div class="row">


                                            <?php foreach ($userskills as $userskill) { 
                                                   $userskills= explode(":" ,$userskill['skill_id']) ;
                                                   
                                                   $skills_names=implode("," ,$userskills) ;
                                                ?>	
                                           
                                                <div class="form-group col-md-10">
                                                    <table class="table table-bordered" style="border: none;">

                                                        <tr><th  width="40%"  style="border: none;">Skills</th>        <td    style="border: none;"><?php echo $skills_names; ?></td>      </tr>
                                                         <tr><th  width="40%"  style="border: none;">Tools</th>        <td    style="border: none;"><?php echo $userskill['tool_id']; ?></td>      </tr>
                                                        <tr> <th  width="40%"  style="border: none;">Tool Version</th>        <td    style="border: none;"><?php echo $userskill['version']; ?></td></tr>
                                                        <tr> <th  width="40%"  style="border: none;">Tool Last Used</th>        <td    style="border: none;"><?php echo $userskill['last_used']; ?></td></tr>

                                                        <tr>  <th  width="40%"  style="border: none;">Tool Source of learning</th>        <td    style="border: none;"><?php echo $userskill['source_of_learning'] ?></td></tr>
                                                        <tr>  <th  width="40%"  style="border: none;">Proficiency Level</th>        <td    style="border: none;"><?php echo $userskill['proficiency_level']; ?></td></tr>
                                                    </table></div>	

                                            <?php } ?>

                                        </div>													
                                    </div>

                                </div>
                            </div>
                        
                        <div class="row"  id="Tools">
                                <div class="form-group col-md-12">

                                    <div class="profile-box-white">
                                        <div class="row">
                                            <div class="form-group col-md-12">

                                                <div class="col-md-6"><h3><b>Tools</b></h3></div>
                                               

                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php if(!empty($usertools)){foreach ($usertools as $usertool) { ?>
                                                <div class="form-group col-md-10">
                                                    <table class="table table-bordered" style="border: none;">
                                                        <tr><th  width="40%"  style="border: none;">Tool</th><td style="border: none;"><?php echo $usertool['name']; ?></td></tr>
                                                        <tr><th  width="40%"  style="border: none;">Version</th><td style="border: none;"><?php echo $usertool['version']; ?></td> </tr>
                                                        <tr><th  width="40%"  style="border: none;">Last Used</th><td style="border: none;"><?php echo $usertool['last_used']; ?></td></tr>
                                                        <tr><th  width="40%"  style="border: none;">Source of Learning</th><td style="border: none;"><?php echo $usertool['knowledge_source']; ?></td></tr>
                                                        <tr><th  width="40%"  style="border: none;">Proficiency Level</th><td style="border: none;"><?php echo $usertool['proficiency_level']; ?></td></tr>
                                                    </table></div>

                                            <?php }} ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="row" id="Personal">
                                <div class="form-group col-md-12">
                                    <div class="profile-box-white">
                                        <div class="row">
                                            <div class="form-group col-md-12">

                                                <div class="col-md-6"><h3><b>Personal Details</b></h3></div>
                                              

                                            </div>
                                        </div>
                                        <div class="row">


                                            <?php foreach ($userdetails as $userdetail) { ?>
                                                <div class="form-group col-md-10">
                                                    <table class="table table-bordered" style="border: none;">

                                                        <tr><th  width="40%"  style="border: none;">Date of Birth</th>        <td    style="border: none;"><?php echo $userdetail['date_of_birth']; ?></td>      </tr>
                                                        <tr> <th  width="40%"  style="border: none;">Permanent Address</th>        <td    style="border: none;"><?php echo $userdetail['permanent_address']; ?></td></tr>
                                                        <tr> <th  width="40%"  style="border: none;">Pin code</th>        <td    style="border: none;"><?php echo $userdetail['pin_code']; ?></td></tr>

                                                        <tr>  <th  width="40%"  style="border: none;">Passport Number</th>        <td    style="border: none;"><?php echo $userdetail['passport_number']; ?></td></tr>
                                                    </table></div>
                                                <?php
                                            }
                                            ?>

                                        </div>													
                                    </div>


                                </div>
                            </div>
                            
                            
                            
                               <div class="row"  id="Resume">
                                <div class="form-group col-md-12">

                                    <div class="profile-box-white">
                                        
                                        <div class="row">
                                            <input type="hidden" name="id" value="<?php echo $_SESSION['user_id']; ?>">
<?php if($userdetails[0]['resume_file_size']==''){ echo 'No Resume Uploaded';} else{?>
                                         
                                            <a href="/admin/getpdf.php?id_no=<?php echo $userdetail['user_id']; ?>">View Resume Pdf</a>
<?php }?>
                                        </div>	
                                        											
                                    </div>

                                </div>
                            </div>
                        
                        
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>




