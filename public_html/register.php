<?php session_start();error_reporting(0);include_once ('includes/php_header.php');
   $msg="";
   //error_reporting(E_ALL);
   if ($_POST['register-user'] == 'Register') {
       //print_r($_POST);exit;
       $_POST['preferred_job_location'] = implode(",", $_POST['multiple-checkboxes']);
       //echo  $_POST['preferred_job_location'];exit;
       if ($u->createNewUser($_POST, $_FILES)) { //print_r($_FILES);
           $msg = '<font color="green">Added successfully.</font>';
           
           if(!empty($msg)){ 
           $loginname = $_POST['username'];
           $password = $_POST['password'];
   					if(!empty($_POST['username']) && $u->authenticate($loginname,$password)){
   					$user_type = $u->getUserType();
   					$_SESSION['user_type'] = $user_type;
   				
   									header('Location: my_profile.php');
   									/* Make sure that code below does not get executed when we redirect. */
   									exit;
   						  
   					 }
   					else {
   					 $errMsg= $u->getError();
   					}
             }
           
           
           
           
       } else {
           $msg = $u->error;
       }
   }
 if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
       $secret = '6Lf4ypkUAAAAAKglnv7WVDl2a25ljtp-EjnkGYrG';
       $captcha = $_POST['g-recaptcha-response'];
       $ip = $_SERVER['REMOTE_ADDR'];
       $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip' . $ip . '');
       //var_dump($verifyResponse);
       $arr = json_decode($verifyResponse, TRUE);
       if ($arr['success']) {
           $sucessmsg = 'Done';
       } else {
           $errormsg = 'SPam';
       }
   }
   $qualifications = $u->getQualifications();
   foreach ($qualifications as $key => $value) {
               if (in_array("GATE", $value)) {
   
                   unset($qualifications[$key]);
               }
           }
   //$dropdown = $u->getJobTypeDropDown();
   
   
   
   
   
   include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
   ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script><script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js" type="text/javascript"></script>
<script>
   function isNumber(evt)
   {
   evt = (evt) ? evt : window.event;
   var charCode = (evt.which) ? evt.which : evt.keyCode;
   if (charCode > 31 && (charCode < 48 || charCode > 57)) {
   return false;
   }
   return true; }
   
   $(function () {
   $("#date_of_birth").datepicker(
   {    dateFormat: 'd M, yy',
   
   changeMonth: true,
   changeYear: true,
   yearRange: "c-70:c+0"
   });
   });
   
           
     $(document).ready(function () {
         $("#experience_div").hide();
         $("#fresher_div").show();
         $("#is_experienced").val('no');
         $('#is_gate').val('yes');
         $('#divfresher input, #divfresher select,#divfresher textarea').each(
     function(){  
         var input = $(this);
          $(input).prop("required", true);
        
     }
   );
    
     
     
   //end of fresher_yes option checked
     $("#fresher_yes").on("click", function () { 
     
     //alert('yes');
     $("#experience_div").hide();
     $("#divfresher").show();
     $("#is_experienced").val('no');
         
        $('#divfresher input, #divfresher select,#divfresher textarea').each(
     function(){  
         var input = $(this);
         console.log(input);
          $(input).prop("required", true);
        
     }
   );
     $('#experience_div input, #experience_div select, #experience_div textarea').each(
     function(){  
         var input = $(this);
          console.log(input);
          $(input).prop("required", false);
        
     }
   ); 
   
   
     });
     $("#fresher_no").on("click", function () {
     
     $("#divfresher").hide();
     $("#experience_div").show();
     $("#is_experienced").val('yes');
     
     
      $('#divfresher input, #divfresher select,#divfresher textarea').each(
     function(){  
         var input = $(this);
          $(input).prop("required", false);
        
     });
     
               
        $('#experience_div input, #experience_div select, #experience_div textarea').each(
     function(){  
         var input = $(this);
          $(input).prop("required", true);
        
     }
   ); 
     
     });
     
     
     
     $('#gate_no').on("click",function(){
         
         $('#gate_rank').hide();
          $('#gate_domain').hide();
         $('#is_gate').val('no');
          $('#domain').prop("required", false);
         $('#gate_rank').prop("required", false);
         $('#gate_score').prop("required", false);
       
         
     });
      $('#gate_yes').on("click",function(){
         $('#is_gate').val('yes');
         $('#gate_rank').show();
         $('#gate_domain').show();
          $('#domain').prop("required", true);
         $('#gate_rank').prop("required", true);
         $('#gate_score').prop("required", true);
         
     });
     
   
     
     
      $('#multiple-checkboxes').multiselect(
         {
             
             buttonWidth: '100%',
                 nonSelectedText: 'Select upto 3',
                 templates: {button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown" style="background:#fff;color: #000;"><span class="multiselect-selected-text" style="float:left"></span> <span style="float:right"><b class="caret"></b></span></button>'},
         onChange: function (element, checked) {
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
         
         }
         
         
         
         });
     
     
     
     });
   
   
   
           
</script>
<div class="container">
   <div class= "single">
      <div class="form-container">
         <h4 align="center"><?php echo $msg; ?></h4>
         <div class="row">
            <div class="col-md-8 col-sm-8 col-lg-8 col-md-offset-2">
               <div class="panel panel-primary">
                  <div class="panel-heading">Sign up
                  </div>
                  <div class="panel-body">
                     <form action="" method="post" enctype="multipart/form-data" id="form_register">
                        <h4 style="border-bottom:1px solid #CCC;padding:5px 0px;color:red;">Personal Information</h4>
                        <input type="hidden" name="is_experienced" value="" id="is_experienced">
                        <input type="hidden" name="is_gate" value="" id="is_gate">
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="myName">First Name <span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <input id="first_name" name="first_name" class="form-control" type="text" data-validation="required" required="">
                              <span id="error_name" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="lastname">Middle Name </label>
                           </div>
                           <div class="form-group col-md-10">
                              <input id="middle_name" name="middle_name" class="form-control" type="text" >
                              <span id="error_middle" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="lastname">Last Name <span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <input id="lastname" name="lastname" class="form-control" type="text" data-validation="required" required="">
                              <span id="error_lastname" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="age">User Name <span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <input id="username" name="username" class="form-control" type="text" data-validation="required" required=""> 
                              <span id="error_username" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="age">Password <span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <input id="password" name="password" class="form-control" type="password" data-validation="required" required="">
                              <span id="error_username" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="exampleInputEmail1">Email <span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <input id="exampleInputEmail1" class="form-control" required="" name="email" type="email" placeholder="email@example.com">
                              <span id="error_email" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="dob">Date Of Birth <span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <input type='text' class="form-control"  id='date_of_birth' name="date_of_birth"/>
                           </div>
                        </div>
                        <!--div class="form-group col-md-12">
                           <label for="gender">Gender</label>
                           <select name="gender" id="gender" class="form-control">
                               <option selected value="Male">Male</option>
                               <option value="Female">Female</option>
                           
                           </select>
                           <span id="error_gender" class="text-danger"></span>
                           </div-->
                        <h4 style="border-bottom:1px solid #CCC;padding:5px 0px;color:red;">Professional Status</h4>
                          <div class="form-group col-md-12">
							  <div class="form-group col-md-2">
                           <label>Are you a Fresher?:<span class="mandatory">* </span></label>
                           </div>
                              <div class="form-group col-md-10">
                           <label>Yes:&nbsp;<input type="radio"  id="fresher_yes" name="fresher" value="yes" required="" checked></label>
                           <label>No:&nbsp;<input type="radio"  id="fresher_no" name="fresher" value="no" required=""></label>
                        </div>
                       </div>
                        <div id="divfresher">
                           <div class="form-group col-md-12">
                              <div class="form-group col-md-2">
                                 <label for="gender">Select type of job required:<span class="mandatory">* </span></label>
                              </div>
                              <div class="form-group col-md-10">
                                 <select name="job_type" id="job_type" class="form-control">
                                    <option value="">Choose categories</option>
                                    <?php $u->getJobTypeDropDown();?>
                                 </select>
                                 <span id="error_job_type" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <div class="form-group col-md-2">
                                 <label for="phone">Expected Designation <span class="mandatory">* </span></label>
                              </div>
                              <div class="form-group col-md-10">
                                 <input type="text" id="e_designation" name="e_designation" class="form-control">
                                 <span id="error_e_designation" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <div class="form-group col-md-2">
                                 <label for="gender">Expected Annual CTC<span class="mandatory">* </span></label>
                              </div>
                              <div class="form-group col-md-10">
                                 <select name="fresher_exp_annual_ctc" id="fresher_exp_annual_ctc" class="form-control">
                                    <option value="0">Select</option>
                                    <option value="Upto 2L">Upto 2L</option>
                                    <option value="2L-4L">2L-4L</option>
                                    <option value="4L-8L">4L-8L</option>
                                    <option value="Above 10 L">Above 10 L</option>
                                 </select>
                                 <span id="error_fresher_exp_annual_ctc" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <div class="form-group col-md-2">
                                 <label for="phone">Achievements<span class="mandatory">* </span></label>
                              </div>
                              <div class="form-group col-md-10">
                                 <textarea type="text" id="fresher_achievements" name="fresher_achievements" class="form-control textarea_count_achi" rows="5"></textarea>
                                 <input type="text" class="smalltextBoxAchi" id="subLimit" value="500" disabled="disabled" style="width: 70px;margin-top: 10px;">
                                 <label>(Enter Several Coma Separated Keywords or Short Sentences.) </label>
                                 <span id="error_fresher_achievements" class="text-danger"></span>
                              </div>
                           </div>
                        </div>
                        <div id="experience_div">
                           <div class="form-group col-md-12">
                              <div class="form-group col-md-2">
                                 <label for="gender">Select type of job required:<span class="mandatory">* </span></label>
                              </div>
                              <div class="form-group col-md-10">
                                 <select name="job_type_experience" id="job_type_experience" class="form-control">
                                    <option value="">Choose categories</option>
                                    <?php $u->getJobTypeDropDown();
                                       ?>
                                 </select>
                                 <span id="error_job_type" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <div class="form-group col-md-2">
                                 <label for="phone">Current Designation<span class="mandatory">* </span> </label>
                              </div>
                              <div class="form-group col-md-10">
                                 <input type="text" id="curr_designation" name="curr_designation" class="form-control">
                                 <span id="error_curr_designation" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <div class="form-group col-md-2">
                                 <label for="phone">Work  Experience Description<span class="mandatory">* </span></label>
                              </div>
                              <div class="form-group col-md-10">
                                 <textarea type="text" id="exp_description" name="exp_description" class="form-control textarea_count"  rows="5"></textarea>
                                 <input type="text" class="smalltextBox"  value="500" disabled="disabled" style="width: 70px;margin-top: 10px;">
                                 <label>(Enter Several Coma Separated Keywords or Short Sentences.) </label>
                                 <span id="error_exp_description" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <div class="form-group col-md-2">
                                 <label for="gender">Work Experience years<span class="mandatory">* </span></label>
                              </div>
                              <div class="form-group col-md-10">
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
                                 <span id="error_work_exp_years" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <div class="form-group col-md-2">
                                 <label for="phone">Expected Designation <span class="mandatory">* </span></label>
                              </div>
                              <div class="form-group col-md-10">
                                 <input type="text" id="expected_designation" name="expected_designation" class="form-control">
                                 <span id="error_expected_designation" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <div class="form-group col-md-2">
                                 <label for="phone">Current CTC(In lakhs)<span class="mandatory">* </span></label>
                              </div>
                              <div class="form-group col-md-10">
                                 <input type="text" id="curr_ctc" name="curr_ctc" class="form-control" maxlength="5" placeholder="please enter number only" onkeypress=" return isNumber(event)" title="please enter number only" >
                                 <span id="error_curr_ctc" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <div class="form-group col-md-2">
                                 <label for="gender">Expected Annual CTC<span class="mandatory">* </span></label>
                              </div>
                              <div class="form-group col-md-10">
                                 <select name="exp_exp_annual_ctc" id="exp_exp_annual_ctc" class="form-control">
                                    <option value="0">Select</option>
                                    <option value="Upto 2L">Upto 2L</option>
                                    <option value="2L-4L">2L-4L</option>
                                    <option value="4L-8L">4L-8L</option>
                                    <option value="Above 10 L">Above 10 L</option>
                                 </select>
                                 <span id="error_exp_exp_annual_ctc" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <div class="form-group col-md-2">
                                 <label for="phone">Notice Period <span class="mandatory">* </span></label>
                              </div>
                              <div class="form-group col-md-10">
                                 <input type="text" id="notice_period" name="notice_period" class="form-control">
                                 <span id="error_notice_period" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <div class="form-group col-md-2">
                                 <label for="phone">Achievements<span class="mandatory">* </span></label>
                              </div>
                              <div class="form-group col-md-10">
                                 <textarea type="text" id="exp_achievements" name="exp_achievements" class="form-control textarea_count" rows="5"></textarea>
                                 <input type="text" class="smalltextBox"  value="500" disabled="disabled" style="width: 70px;margin-top: 10px;">
                                 <label>(Enter Several Coma Separated Keywords or Short Sentences.) </label>
                                 <span id="error_exp_achievements" class="text-danger"></span>
                              </div>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="phone">Preferred Job Location<span class="mandatory">* </span></label></br>             
                           </div>
                           <div class="form-group col-md-10">
                              <select id="multiple-checkboxes" multiple="multiple"  name="multiple-checkboxes[]" >
                                 <option value="Pune">Pune</option>
                                 <option value="Mumbai">Mumbai</option>
                                 <option value="Bengaluru">Bengaluru</option>
                                 <option value="Nagpur">Nagpur</option>
                                 <option value="Chennai">Chennai</option>
                                 <option value="Aurangabad">Aurangabad</option>
                              </select>
                              <span id="error_preferred_job_location" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="gender">Highest Education<span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <select name="education" id="education" class="form-control" required="">
                                 <option value="">Select</option>
                                 <?php foreach ($qualifications as $qualification) { ?>
                                 <option value="<?php echo $qualification['id']; ?>"><?php echo $qualification['qualification']; ?></option>
                                 <?php } ?>
                              </select>
                              <span id="error_work_exp_months" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="disc">Subjects</label>
                           </div>
                           <div class="form-group col-md-10">
                              <textarea class="form-control" rows="3"  name="subject" id='subject_count'></textarea>
                              <!--input type="text" class="subject_count_text" value="40" disabled="disabled" style="width: 70px;margin-top: 10px;"-->
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="age">University / Board or College/Institute <span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <input id="university" name="university" class="form-control" type="text"  required=""> 
                              <span id="error_university" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="age">Percentage/CGPA <span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <input id="percentage" name="percentage" class="form-control" type="text" required=""> 
                              <span id="error_percentage" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-12">
                              <label>GATE Given?:<span class="mandatory">* </span></label>
                              <label>Yes:&nbsp;<input type="radio"  id="gate_yes" name="gate_exam" value="yes" required="" checked></label>
                              <label>No:&nbsp;<input type="radio"  id="gate_no" name="gate_exam" value="no" required=""></label>
                           </div>
                        </div>
                          <div class="form-group col-md-12" id="gate_rank">

                           <div class="form-group col-md-2" >
                              <label for="school">All India Rank<span class="mandatory">*
                              </span></label> 
                           </div>
                           <div class="form-group col-md-10" >
                              <input type="text" class="form-control"
                                 id="gate_score" name="gate_score"  required=""/>
                           </div>
                        </div>
                        <div class="form-group col-md-12" id="gate_domain">
                           <div class="form-group col-md-2" >
                              <label for="school">Domain<span class="mandatory">*
                              </span></label>
                           </div>
                           <div class="form-group col-md-10" >
                              <select name="domain" id="domain" size='1' class="form-control" required="">
                                 <option value="">Select Domain</option>
                                 <option value="Mechanical">Mechanical</option>
                                 <option value="Electronics">Electronics</option>
                                 <option value="Electrical">Electrical</option>
                                 <option value="Aerospace">Aerospace</option>
                                 <option value="Chemical">Chemical</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="age">Key words related to your <b class="section-title">Skills</b> and <b class="section-title">Expertise</b> <span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <textarea id="key_words" name="key_words" class="form-control textarea_count_key_words" required="" rows="5"></textarea>
                              <input type="text" class="smalltextBox_key_words"  value="500" disabled="disabled" style="width: 70px;margin-top: 10px;">
                              <label>(Enter Several Coma Separated Keywords or Short Sentences.) </label>
                              <span id="key_words" class="text-danger"></span>
                           </div>
                        </div>
                        <!-- <div class="form-group col-md-12">
                           <label for="phone">Upload Resume(File size should not exceed 2MB and Pdf File only) <span class="mandatory">* </span> </label>
                           <input type="file" path="resume_file" id="resume_file" name="resume_file" accept=".pdf" required="">
                           <span id="error_city" class="text-danger"></span>
                           </div>-->
                        <h4 style="border-bottom:1px solid #CCC;padding:5px 0px;color:red;">Contact Subscription</h4>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="phone">Mobile Number <span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <input type="text" id="mobile_number" name="mobile_number" class="form-control" required="">
                              <span id="error_phone" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="p_address">Permanent Address: <span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <input type="text" id="address" name="address" class="form-control" required="">
                              <span id="error_address" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="phone">City/Town <span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <input type="text" id="city" name="city" class="form-control" required="">
                              <span id="error_city" class="text-danger"></span>
                           </div>
                        </div>
                      
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <label for="phone">Upload Your Photo <span class="mandatory">* </span></label>
                           </div>
                           <div class="form-group col-md-10">
                              <input type="file" path="uploadphoto" id="uploadphoto" name="uploadphoto" accept="image/*" required="">
                              <span id="error_city" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <div class="form-group col-md-2">
                              <input type="checkbox" id="agree_terms" name="agree_terms"  oninvalid="this.setCustomValidity('Please agree to terms')"
                                 oninput="setCustomValidity('')" required>
                           </div>
                           <div class="form-group col-md-10">
                              <label for="phone">All the information provided above is true to the best of my knowledge.<span class="mandatory">* </span> </label>
                              <span id="error_city" class="text-danger"></span>
                           </div>
                        </div>
                        <div class="form-group col-md-12">					<div class="login-btn">

                           <!--div class="g-recaptcha" data-sitekey="6Lf4ypkUAAAAAG2DtIAViPuiYKjFTCgb2j8zY0gF" id="g-recaptcha-response"></div-->
                           <!--div class="g-recaptcha" data-sitekey="6LcF8goTAAAAANwS0UN4l5JHqnuRb4bTha-TDusM" id="g-recaptcha-response"></div-->
                           <div class="g-recaptcha" data-sitekey="6LfT8aUUAAAAAD-Jlf6EDV-ta6S_6Ckiktc5LS7I" id="g-recaptcha-response"></div>
                           <button  type="submit"  value="Register" name="register-user" id="register_user" class="btn btn-primary center">Register</button>
                        </div></div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php include_once ('includes/footer.php'); ?>
