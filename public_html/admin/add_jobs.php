<?php  
//include_once ('includes/php_header.php');
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/php_header.php';
//include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Admin.class.php';
if(empty($_SESSION['user_id'])){
                header("Location:/login.php");
}
$user_id = $_GET['id'];
$jobDetails = $u->getJobById($_GET['id']);

if(empty($_GET['id'])){
$userDetails = $u->userdetails($_SESSION['user_id']);
}else{ 
$userDetails = $u->userdetails($jobDetails['posted_by']);	

}

if(!empty($_POST)){
if($_POST['add-job']=='Post Job'){
        if($u->createJobs($_POST)){
                        $_SESSION['succ'] = 'Added successfully.';
                         header("Location:/admin/manage_jobs.php");
                }else{
                        $msg = $u->error;
                }
}

if($_POST['update-job']=='Update'){
        if($u->updateJob($_POST)){
                        $_SESSION['succ'] = 'Updated successfully.';
                         header("Location:/admin/manage_jobs.php");
                }else{
                        $msg = $u->error;
                }
}

	if($_POST['Register']=='Register'){ 
		 $job = $u->createJobs($_POST);
		 if(empty($job)){
			$msg = '<font color="red" >User Already Exist.</font>';
		   }else{
			$msg = '<font color="green" >Job Added Successfully.</font>';
		   }
	}

}
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/header.php';
?>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#valid_till" ).datepicker();
  } );

		function isNumber(evt)
		{
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
		}
		return true; }
  </script>

<div class="container">
    <div class="single">  
	   <div class="form-container">
		<div class="row">
			<h4><?php echo $msg; ?></h4>
		    <div class="col-md-8 col-sm-12 col-lg-8 col-md-offset-2">
			<div class="panel panel-primary">
				<div class="panel-heading">Post a Job Here</div>
				<div class="panel-body">
        			<form action="" method="post" enctype="multipart/form-data">
						<h4 style="border-bottom:1px solid #CCC;padding:5px 0px;color:red;">Job Details:</h4>
				<div class="form-group col-md-4">
					<label for="myName"> Title/Designation <span class="mandatory">* </span></label>
					
				</div>
				<div class="form-group col-md-8">
					<input id="job_name" name="job_name" value="<?php echo $jobDetails['job_name']; ?>" class="form-control" type="text" data-validation="required" required="">
					<span id="error_name" class="text-danger"></span>
				</div>
				<div class="form-group col-md-4">
					<label for="last_name">No of Vacancies <span class="mandatory">* </span></label>
					
				</div>
				<div class="form-group col-md-8">
					<input id="no_of_vaccencies" name="no_of_vaccencies" value="<?php echo $jobDetails['no_of_vaccencies']; ?>" class="form-control" type="text" data-validation="required" required="">
					<span id="error_middle" class="text-danger"></span>
				</div>
				<div class="form-group col-md-4">
					<label for="disc">Description <span class="mandatory">* </span></label>
					
				</div>
				<div class="form-group col-md-8">
					<label for="disc">Describe the responsibilities of this job, required work experience, skills, or education.</label>
					<textarea data-validation="required" required="" class="form-control" rows="3"  name="description"><?php echo $jobDetails['description']; ?></textarea>
				</div>
				<div class="form-group col-md-4">
					<label for="last_name">Experience <span class="mandatory">* </span></label>
					
				</div>
				<div class="form-group col-md-8">
					<!--input id="experience_min" name="experience_min" value="<?php echo $jobDetails['experience_min']; ?>" class="form-control" type="text" data-validation="required" required=""-->
					
					
					<select id="experience_min" name="experience_min" class="form-control" required="">
							  <option selected="" value="">Minimum</option>
								<option value="Fresher" <?php if($jobDetails['experience_min']=="Fresher"){ echo "selected=selected"; }?>>Fresher</option>
								<option value="1" label="1" <?php if($jobDetails['experience_min']=="1"){ echo "selected=selected"; }?>>1</option>
								<option value="2" label="2" <?php if($jobDetails['experience_min']=="2"){ echo "selected=selected"; }?>>2</option>
								<option value="3" label="3" <?php if($jobDetails['experience_min']=="3"){ echo "selected=selected"; }?>>3</option>
								<option value="4" label="4" <?php if($jobDetails['experience_min']=="4"){ echo "selected=selected"; }?>>4</option>
								<option value="5" label="5" <?php if($jobDetails['experience_min']=="5"){ echo "selected=selected"; }?>>5</option>
								<option value="6" label="6" <?php if($jobDetails['experience_min']=="6"){ echo "selected=selected"; }?>>6</option>
								<option value="7" label="7" <?php if($jobDetails['experience_min']=="7"){ echo "selected=selected"; }?>>7</option>
								<option value="8" label="8" <?php if($jobDetails['experience_min']=="8"){ echo "selected=selected"; }?>>8</option>
								<option value="9" label="9" <?php if($jobDetails['experience_min']=="9"){ echo "selected=selected"; }?>>9</option>
								<option value="10" label="10" <?php if($jobDetails['experience_min']=="10"){ echo "selected=selected"; }?>>10</option>
								<option value="11" label="11" <?php if($jobDetails['experience_min']=="11"){ echo "selected=selected"; }?>>11</option>
								<option value="12" label="12" <?php if($jobDetails['experience_min']=="12"){ echo "selected=selected"; }?>>12</option>
								<option value="13" label="13" <?php if($jobDetails['experience_min']=="13"){ echo "selected=selected"; }?>>13</option>
								<option value="14" label="14" <?php if($jobDetails['experience_min']=="14"){ echo "selected=selected"; }?>>14</option>
								<option value="15" label="15" <?php if($jobDetails['experience_min']=="15"){ echo "selected=selected"; }?>>15</option>
								<option value="16" label="16" <?php if($jobDetails['experience_min']=="16"){ echo "selected=selected"; }?>>16</option>
								<option value="17" label="17" <?php if($jobDetails['experience_min']=="17"){ echo "selected=selected"; }?>>17</option>
								<option value="18" label="18" <?php if($jobDetails['experience_min']=="18"){ echo "selected=selected"; }?>>18</option>
								<option value="19" label="19" <?php if($jobDetails['experience_min']=="19"){ echo "selected=selected"; }?>>19</option>
								<option value="20" label="20" <?php if($jobDetails['experience_min']=="20"){ echo "selected=selected"; }?>>20</option>
							 </select>
					&nbsp;&nbsp;To&nbsp;&nbsp;
					<!--input id="experience_max" name="experience_max" value="<?php echo $jobDetails['experience_max']; ?>" class="form-control" type="text" data-validation="required" required=""-->
					<select id="experience_max" name="experience_max" class="form-control">
							  <option selected="" value="">Maximum</option>
								<option value="1" label="1" <?php if($jobDetails['experience_max']=="1"){ echo "selected=selected"; }?>>1</option>
								<option value="2" label="2" <?php if($jobDetails['experience_max']=="2"){ echo "selected=selected"; }?>>2</option>
								<option value="3" label="3" <?php if($jobDetails['experience_max']=="3"){ echo "selected=selected"; }?>>3</option>
								<option value="4" label="4" <?php if($jobDetails['experience_max']=="4"){ echo "selected=selected"; }?>>4</option>
								<option value="5" label="5" <?php if($jobDetails['experience_max']=="5"){ echo "selected=selected"; }?>>5</option>
								<option value="6" label="6" <?php if($jobDetails['experience_max']=="6"){ echo "selected=selected"; }?>>6</option>
								<option value="7" label="7" <?php if($jobDetails['experience_max']=="7"){ echo "selected=selected"; }?>>7</option>
								<option value="8" label="8" <?php if($jobDetails['experience_max']=="8"){ echo "selected=selected"; }?>>8</option>
								<option value="9" label="9" <?php if($jobDetails['experience_max']=="9"){ echo "selected=selected"; }?>>9</option>
								<option value="10" label="10" <?php if($jobDetails['experience_max']=="10"){ echo "selected=selected"; }?>>10</option>
								<option value="11" label="11" <?php if($jobDetails['experience_max']=="11"){ echo "selected=selected"; }?>>11</option>
								<option value="12" label="12" <?php if($jobDetails['experience_max']=="12"){ echo "selected=selected"; }?>>12</option>
								<option value="13" label="13" <?php if($jobDetails['experience_max']=="13"){ echo "selected=selected"; }?>>13</option>
								<option value="14" label="14" <?php if($jobDetails['experience_max']=="14"){ echo "selected=selected"; }?>>14</option>
								<option value="15" label="15" <?php if($jobDetails['experience_max']=="15"){ echo "selected=selected"; }?>>15</option>
								<option value="16" label="16" <?php if($jobDetails['experience_max']=="16"){ echo "selected=selected"; }?>>16</option>
								<option value="17" label="17" <?php if($jobDetails['experience_max']=="17"){ echo "selected=selected"; }?>>17</option>
								<option value="18" label="18" <?php if($jobDetails['experience_max']=="18"){ echo "selected=selected"; }?>>18</option>
								<option value="19" label="19" <?php if($jobDetails['experience_max']=="19"){ echo "selected=selected"; }?>>19</option>
								<option value="20" label="20" <?php if($jobDetails['experience_max']=="20"){ echo "selected=selected"; }?>>20</option>
							 </select>
					<span id="error_middle" class="text-danger"></span>
				</div>
				<div class="form-group col-md-4">
					<label for="last_name">CTC <span class="mandatory">* </span></label>
					
				</div>
				<div class="form-group col-md-8">
					<input id="ctc" name="ctc" value="<?php echo $jobDetails['ctc']; ?>" class="form-control" type="text" data-validation="required" required=""placeholder="please enter number only" onkeypress=" return isNumber(event)" title="please enter number only" >
					<span id="error_middle" class="text-danger"></span>
				</div>
				<div class="form-group col-md-4">
					<label for="last_name">Location <span class="mandatory">* </span></label>
					
				</div>
				<div class="form-group col-md-8">
					<input id="location" name="location" value="<?php echo $jobDetails['location']; ?>" class="form-control" type="text" data-validation="required" required="">
					<span id="error_middle" class="text-danger"></span>
				</div>
			<h4 style="border-bottom:1px solid #CCC;padding:5px 0px;color:red;">Candidate Profile:</h4>

			<div class="form-group col-md-4">
					<label for="lastname">Specify UG Qualification <span class="mandatory">* </span></label>
					
				</div>
				<div class="form-group col-md-8">
					<input id="ug_qualification" name="ug_qualification" value="<?php echo $jobDetails['ug_qualification']; ?>" class="form-control" type="text" data-validation="required" required="">
					<span id="error_lastname" class="text-danger"></span>
				</div>
			<div class="form-group col-md-4">
					<label for="lastname">Specify PG Qualification </label>
					
				</div>
				<div class="form-group col-md-8">
					<input id="pg_qualification" name="pg_qualification" value="<?php echo $jobDetails['pg_qualification']; ?>" class="form-control" type="text" >
					<span id="error_lastname" class="text-danger"></span>
				</div>		
				

				<h4 style="border-bottom:1px solid #CCC;padding:5px 0px;color:red;">Employer Details:</h4>
				
				<div class="form-group col-md-4">
					<label for="lastname">Company Name <span class="mandatory">* </span></label>
					
				</div>
				<div class="form-group col-md-8">
					<input id="company_name" name="company_name" value="<?php echo $userDetails['name_of_company']; ?>" class="form-control" type="text" data-validation="required" required="">
					<span id="error_lastname" class="text-danger"></span>
				</div>
				<div class="form-group col-md-4">
					<label for="age">Company profile <span class="mandatory">* </span></label>
					
				</div>
				<div class="form-group col-md-8"><label for="age">Describe company profile in short.</label>
				<textarea data-validation="required" id="company_profile" name="company_profile" required="" class="form-control" rows="3"   value="<?php echo $userDetails['company_profile']; ?>" > <?php echo $userDetails['company_profile']; ?></textarea>
					<span id="error_username" class="text-danger"></span>
				</div>
				<div class="form-group col-md-4">
					<label for="age">Website <span class="mandatory">* </span></label>
					
				</div>
				<div class="form-group col-md-8">
					<input id="website" name="website" value="<?php echo $userDetails['website']; ?>" class="form-control" type="text" data-validation="required" required=""> 
					<span id="error_username" class="text-danger"></span>
				</div>
				<div class="form-group col-md-4">
					<label for="age">Contact person<span class="mandatory">* </span></label>
					
				</div>
				<div class="form-group col-md-8">
					<input id="contact_person" name="contact_person" value="<?php echo $userDetails['contact_person']; ?>" class="form-control" type="text" data-validation="required" required=""> 
					<span id="error_username" class="text-danger"></span>
				</div>
				<div class="form-group col-md-4">
					<label for="age">Mobile number <span class="mandatory">* </span></label>
					
				</div>
				<div class="form-group col-md-8">
					<input id="company_number" name="company_number" value="<?php echo $userDetails['mobile_number']; ?>" class="form-control" type="text" data-validation="required" required=""> 
					<span id="error_username" class="text-danger"></span>
				</div>
				
		
					<div class="form-group col-md-12">
						<!--label for="dob">Valid Till <span class="mandatory">* </span></label>
						<?php $valid_till= NULL; if(!empty($jobDetails['valid_till'])){
										$valid_till = date('m/d/Y', strtotime($jobDetails['valid_till'])); } ?>
						<input type='text' class="form-control" value="<?php echo $valid_till; ?>" id='valid_till' name="valid_till"/>
					</div-->
						<input type="hidden" name="posted_by" value="<?php echo $_SESSION['user_id'];?>">
						<input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
					<div class="login-btn">
					
						<?php if(empty($_GET['id'])){?>
													<input type="submit" name="add-job" value="Post Job" class="btn btn-primary center">
											<?php } else { ?>
													<input type="submit" name="update-job" value="Update" class="btn btn-primary center">
											<?php } ?>
						<!--button  type="submit"  value="Register" Name="Register" class="btn btn-primary center">Post Job</button--></div>
					</div>
				</form>
			</div>
		</div>
						</div>
					</div>

        <!--form action="" method="post" enctype="multipart/form-data">
          <div class="row"><h3 align="center"><?php echo $msg; ?></h3>
            <div class="form-group col-md-12">	
                <label class="col-md-2 control-lable" for="firstName"><span class="mandatory">* </span>First Name</label>
                <div class="col-md-10">
                    <input type="text" path="first_name" id="first_name" name="first_name" class="form-control input-sm" required/>
                </div>
            </div>
         </div>
 	 <div class="row">
            <div class="form-group col-md-12">
                <label class="col-md-2 control-lable" for="lastName"><span class="mandatory">* </span>Middle Name</label>
                <div class="col-md-10">
                    <input type="text" path="middle_name" id="middle_name" name="middle_name"  class="form-control input-sm" required/>
                </div>
            </div>
        </div>
         <div class="row">
            <div class="form-group col-md-12">
                <label class="col-md-3 control-lable" for="lastName"><span class="mandatory">* </span>Last Name</label>
                <div class="col-md-9">
                    <input type="text" path="last_name" id="last_name"  name="last_name" class="form-control input-sm" required/>
                </div>
            </div>
        </div>
  	<div class="row">
            <div class="form-group col-md-12">
                <label class="col-md-3 control-lable" for="lastName"><span class="mandatory">* </span>User Name</label>
                <div class="col-md-9">
                    <input type="text" path="username" id="username"  name="username" class="form-control input-sm" required/>
                </div>
            </div>
        </div>
<div class="row">
            <div class="form-group col-md-12">
                <label class="col-md-3 control-lable" for="lastName"><span class="mandatory">* </span>Password</label>
                <div class="col-md-9">
                    <input type="password" path="password" id="password"  name="password" class="form-control input-sm" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label class="col-md-3 control-lable" for="lastName"><span class="mandatory">* </span>Mobile Number</label>
                <div class="col-md-9">
                    <input type="text" path="mobile_number" id="mobile_number"  name="mobile_number" class="form-control input-sm" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label class="col-md-3 control-lable" for="sex">Gender</label>
                <div class="col-md-9" class="form-control input-sm">
                    <div class="radios">
				        <label for="radio-01" class="label_radio">
				            <input type="radio" checked="" name="gender" value="Male"> Male
				        </label>
				        <label for="radio-02" class="label_radio">
				            <input type="radio" name="gender" value="Female"> Female
				        </label>
	                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">                 <label class="col-md-3 control-lable" for="resume">Date of Birth</label>             
		 <div class="controls input-append date date_of_birth" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                
                    <input  class="form-control input-sm"  type="text"  style="width:40%;"  name="date_of_birth" id="date_of_birth" >
                    <span class="add-on" style="height:35px;"><i class="icon-remove" st></i></span>
					<span class="add-on" style="height:35px;"><i class="icon-th"></i></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label class="col-md-3 control-lable" for="email"><span class="mandatory">* </span>Email</label>
                <div class="col-md-9">
                    <input type="text" path="email" id="email" name="email" class="form-control input-sm" required/>
                </div>
            </div>
        </div>
 <div class="row">
            <div class="form-group col-md-12">
                <label class="col-md-3 control-lable" for="city"><span class="mandatory">* </span>City</label>
                <div class="col-md-9">
                    <input type="text" path="city" id="city" name="city"class="form-control input-sm" required/>
                </div>
            </div>
        </div>
 <div class="row">
            <div class="form-group col-md-12">
                <label class="col-md-3 control-lable" for="resume">Upload Your Photo</label>
                <div class="col-md-9">
                    <input type="file" path="uploadphoto" id="uploadphoto" name="uploadphoto" />
                </div>
            </div>
 </div>
 <div class="row">
            <div class="form-group col-md-12">
                <label class="col-md-3 control-lable" for="resume">Upload Resume</label>
                <div class="col-md-9">
                    <input type="file" path="resume_file" id="resume_file" name="resume_file" />
                </div>
            </div>
 </div-->
        <!--div class="row">
            <div class="form-group col-md-12">
                <label class="col-md-3 control-lable" for="country">Country</label>
                <div class="col-md-9">
                    <select path="country" id="country" class="form-control input-sm">
                        <option value="">Select Country</option>
                        <option value="">Japan</option>
                        <option value="">Kenya</option>
                        <option value="">Dubai</option>
                        <option value="">Italy</option>
                        <option value="">Greece</option> 
                        <option value="">Iceland</option> 
                        <option value="">China</option> 
                        <option value="">Doha</option> 
                        <option value="">Irland</option> 
                        <option value="">Srilanka</option> 
                        <option value="">Russia</option> 
                        <option value="">Hong Kong</option> 
                        <option value="">Germany</option>
                        <option value="">Canada</option>  
                        <option value="">Mexico</option> 
                        <option value="">Nepal</option>
                        <option value="">Norway</option> 
                        <option value="">Oman</option>
                        <option value="">Pakistan</option>  
                        <option value="">Kuwait</option> 
                        <option value="">Indonesia</option>  
                        <option value="">Spain</option>
                        <option value="">Thailand</option>  
                        <option value="">Saudi Arabia</option> 
                        <option value="">Poland</option> 
                    </select>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="col-md-3 control-lable" for="country">Work Experience years</label>
                <div class="col-md-9">
                    <select path="work_exp_years" id="work_exp_years" name="work_exp_years" class="form-control input-sm">
                        <option value="">Select</option>
                        <option value="0">0 years</option>
                        <option value="1">1 years</option>
                        <option value="2">2 years</option>
                        <option value="3">3 years</option> 
                        <option value="4">4 years</option> 
                        <option value="5">5 years</option> 
                        <option value="6">6 years</option> 
                        <option value="7">7 years</option> 
                        <option value="8">8 years</option> 
                        <option value="9">9 years</option> 
                        <option value="10">10 years</option> 
                        <option value="11">11 years</option> 
                        <option value="12">12 years</option> 
                        <option value="13">13 years</option> 
                        <option value="14">14 years</option> 
                        <option value="15">15 years</option>       
                    </select>
                    
                </div>
            </div>
		 <div class="form-group col-md-6">
                <label class="col-md-3 control-lable" for="country">Work Experience  Months</label>
                <div class="col-md-9">
                    <select path="work_exp_months" id="work_exp_months" name="work_exp_months" class="form-control input-sm">
                        <option value="">Select</option>
                        <option value="0">0 months</option>
                        <option value="1">1 months</option>
                        <option value="2">2 months</option>
                        <option value="3">3 months</option> 
                        <option value="4">4 months</option> 
                        <option value="5">5 months</option> 
                        <option value="6">6 months</option> 
                        <option value="7">7 months</option> 
                        <option value="8">8 months</option> 
                        <option value="9">9 months</option> 
                        <option value="10">10 months</option> 
                        <option value="11">11 months</option> 
                        <option value="12">12 months</option> 
                      
                    </select>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label class="col-md-3 control-lable" for="country"><span class="mandatory">* </span>Education</label>
                <div class="col-md-9">


  <select path="education" id="education" name="education" class="form-control input-sm" required>
                                                        <?php foreach($qualifications as $qualification){ ?>

                                <option value="<?php echo $qualification['id'];?>"><?php echo $qualification['qualification'];?></option>

                                                        <?php  } ?>
                                                  </select>
                  
               </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label class="col-md-3 control-lable" for="subjects"><span class="mandatory">* </span>Subjects</label>
                <div class="col-md-9 sm_1">
                   <textarea cols="77" rows="6" value=" " name="subject" onfocus="this.value='';" onblur="if (this.value == '') {this.value = '';}" required> </textarea>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-actions floatRight">
                <input type="submit" value="Register" Name="Register" class="btn btn-primary btn-sm">
            </div>
        </div>
    </form-->
    </div>
 </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'; ?>
