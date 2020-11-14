<?php session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/User.class.php';
if(empty($_SESSION['user_id'])){
        header("Location:/login.php");
}
//include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Admin.class.php';
$u = new User($_SESSION['user_id']);

$user_id = $_GET['id'];

if($_POST['add-user']=='Add'){
        //if($u->addUser($_POST)){
        if($u->createNewUser($_POST,$_FILES)){
			$_SESSION['succ'] = 'Added successfully.';
                         header("Location:/admin/manage_users.php");
                        //$msg = "Added successfully.";
                }else{
                        $msg = $u->error;
                }
}
if($_POST['update-user']=='Update'){
        if($u->updateUser($_POST,$_FILES)){
			$_SESSION['succ'] = 'Updated successfully.';
                         header("Location:/admin/manage_users.php");
                }else{
                        $msg = $u->error;
                }
}

$userDetails = $u->userDetails($_GET['id']);
$user_types = $u->getUserTypes();
//print_r($userDetails);exit;
$qualifications = $u->getQualifications();
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/header.php';
?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#date_of_birth" ).datepicker();
  } );
  </script>
<div class="container">
    <div class="single">  
	   <div class="col-md-2">
	 </div>
	 <div class="col-md-8 single_right">
	 	   <div class="login-form-section">
                <div class="login-content">
                    <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" >
                        <div class="section-title">
                            <h3>Add User</h3>
                            <h4><?php echo $msg;?></h4>
                        </div>
                        <div class="form-group col-md-12">
				<label for="phone">Name <span class="mandatory">* </span></label>
                                <input type="text" required="required" value="<?php echo $userDetails['first_name']; ?>" class="form-control" placeholder="First Name"  name="first_name"><br/>
                                <input type="text" class="form-control" value="<?php echo $userDetails['middle_name']; ?>" placeholder="Middle Name"  name="middle_name"><br/>
                                <input type="text" required="required" value="<?php echo $userDetails['last_name']; ?>" class="form-control" placeholder="Last Name"  name="last_name">
                        </div>
			<!--div class="form-group col-md-12">
				<label for="phone">Username <span class="mandatory">* </span></label>
                                <input type="text" required="required" value="<?php echo $userDetails['username']; ?>" class="form-control" placeholder="Username"  name="username">
                        </div>
			<?php //if(empty($_GET['id'])){ ?>
                        <div class="form-group col-md-12">
				<label for="phone">Password <span class="mandatory">* </span></label>
                                <input type="password" required="required" value="" class="form-control " placeholder="Password" name="password">
                        </div-->
			<?php  // } ?>
			 <div class="form-group col-md-12">
				<label for="phone">Email <span class="mandatory">* </span></label>
                                <input type="email" required="required" value="<?php echo $userDetails['email']; ?>" class="form-control " placeholder="Email" name="email">
                        </div>
			<!--div class="form-group col-md-12">
				<label for="phone">User Type <span class="mandatory">* </span></label>
				<select name="user_type" class="form-control" required>
					<option value="">Select</option>
					<?php foreach($user_types as $user_typ){ ?>
					<option <?php if($userDetails['user_type']==$user_typ['id']) echo 'selected=selected';?> value="<?php echo $user_typ['id'];?>"><?php echo $user_typ['type'];?></option>					 
					<?php  } ?>
				</select>			
                        </div-->
			<div class="form-group col-md-12">
				<label for="phone">Mobile Number <span class="mandatory">* </span></label>
                                <input type="text" required="required" value="<?php echo $userDetails['mobile_number']; ?>" class="form-control" placeholder="Mobile No."  name="mobile_number">
                        </div>
			<!--div class="form-group col-md-12">
				<label for="phone">DOB</label>
				<?php $dob= NULL; if(!empty($userDetails['date_of_birth'])){
				$dob = date('m-d-Y', strtotime($userDetails['date_of_birth'])); } ?>
                                <input type="text" value="<?php echo $dob; ?>" class="form-control" id='date_of_birth' placeholder="mm-dd-yyyy"  name="date_of_birth">
                        </div>
			<div class="form-group col-md-12">
				<label for="phone">Gender</label>
				<select name="gender" class="form-control">
					<option value="">Select</option>
                                        <option value="Male" <?php if($userDetails['gender']== 'Male') { echo 'selected=selected'; } ?> >Male</option>
                                        <option value="Female" <?php if($userDetails['gender']== 'Female') { echo 'selected=selected'; } ?> >Female</option>
                                </select>
                        </div-->
			<div class="form-group col-md-12">
                                <label for="phone">Profile Name</label>
                                <input type="text" value="<?php echo $userDetails['profile_name']; ?>" class="form-control" placeholder="Profile Name"  name="profile_name">
                        </div>
			<!--div class="form-group col-md-12">
                             <label for="phone">City</label>
                             <input type="text" id="city" name="city" class="form-control" value="<?php echo $userDetails['city']; ?>" >
                        </div-->
			<div class="form-group col-md-12">
                        	<label for="gender">Work Experience years</label>
                                <select name="work_exp_years" id="work_exp_years" class="form-control">
                                	<option value="">Select</option>
                                        <option value="0"  <?php if($userDetails['work_exp_years']== '0') { echo 'selected=selected'; } ?>>0 years</option>
                                        <option value="1" <?php if($userDetails['work_exp_years']== '1') { echo 'selected=selected'; } ?> >1 years</option>
                                        <option value="2" <?php if($userDetails['work_exp_years']== '2') { echo 'selected=selected'; } ?> >2 years</option>
                                        <option value="3" <?php if($userDetails['work_exp_years']== '3') { echo 'selected=selected'; } ?> >3 years</option>
                                        <option value="4" <?php if($userDetails['work_exp_years']== '4') { echo 'selected=selected'; } ?> >4 years</option>
                                        <option value="5" <?php if($userDetails['work_exp_years']== '5') { echo 'selected=selected'; } ?> >5 years</option>
                                        <option value="6" <?php if($userDetails['work_exp_years']== '6') { echo 'selected=selected'; } ?> >6 years</option>
                                        <option value="7" <?php if($userDetails['work_exp_years']== '7') { echo 'selected=selected'; } ?> >7 years</option>
                                        <option value="8" <?php if($userDetails['work_exp_years']== '8') { echo 'selected=selected'; } ?> >8 years</option>
                                        <option value="9" <?php if($userDetails['work_exp_years']== '9') { echo 'selected=selected'; } ?> >9 years</option>
                                        <option value="10" <?php if($userDetails['work_exp_years']== '10') { echo 'selected=selected'; } ?> >10 years</option>
                                        <option value="11" <?php if($userDetails['work_exp_years']== '11') { echo 'selected=selected'; } ?> >11 years</option>
                                        <option value="12" <?php if($userDetails['work_exp_years']== '12') { echo 'selected=selected'; } ?> >12 years</option>
                                        <option value="13" <?php if($userDetails['work_exp_years']== '13') { echo 'selected=selected'; } ?> >13 years</option>
                                        <option value="14" <?php if($userDetails['work_exp_years']== '14') { echo 'selected=selected'; } ?> >14 years</option>
                                        <option value="15" <?php if($userDetails['work_exp_years']== '15') { echo 'selected=selected'; } ?> >15 years</option>
                                </select>
                         </div>
			<!--div class="form-group col-md-12">
                        	<label for="gender">Work Experience  Months</label>
                                <select name="work_exp_months" id="work_exp_months" class="form-control">
                                	<option value="">Select</option>
                                        <option value="0" <?php if($userDetails['work_exp_months']== '0') { echo 'selected=selected'; } ?> >0 months</option>
                                        <option value="1" <?php if($userDetails['work_exp_months']== '1') { echo 'selected=selected'; } ?> >1 months</option>
                                        <option value="2" <?php if($userDetails['work_exp_months']== '2') { echo 'selected=selected'; } ?> >2 months</option>
                                        <option value="3" <?php if($userDetails['work_exp_months']== '3') { echo 'selected=selected'; } ?> >3 months</option>
                                        <option value="4" <?php if($userDetails['work_exp_months']== '4') { echo 'selected=selected'; } ?> >4 months</option>
                                        <option value="5" <?php if($userDetails['work_exp_months']== '5') { echo 'selected=selected'; } ?> >5 months</option>
                                        <option value="6" <?php if($userDetails['work_exp_months']== '6') { echo 'selected=selected'; } ?> >6 months</option>
                                        <option value="7" <?php if($userDetails['work_exp_months']== '7') { echo 'selected=selected'; } ?> >7 months</option>
                                        <option value="8" <?php if($userDetails['work_exp_months']== '8') { echo 'selected=selected'; } ?> >8 months</option>
                                        <option value="9" <?php if($userDetails['work_exp_months']== '9') { echo 'selected=selected'; } ?> >9 months</option>
                                        <option value="10" <?php if($userDetails['work_exp_months']== '10') { echo 'selected=selected'; } ?> >10 months</option>
                                        <option value="11" <?php if($userDetails['work_exp_months']== '11') { echo 'selected=selected'; } ?> >11 months</option>
                                        <option value="12" <?php if($userDetails['work_exp_months']== '12') { echo 'selected=selected'; } ?> >12 months</option>
                                </select>
                        </div-->
			<div class="form-group col-md-12">
                        	<label for="gender">Education</label>
                                <select name="education" id="education" class="form-control">
                                	<option value="">Select</option>
                                        <?php foreach($qualifications as $qualification){ ?>
                                        <option value="<?php echo $qualification['id'];?>" <?php if($userDetails['education']==$qualification['id']) echo 'selected=selected';?> ><?php echo $qualification['qualification'];?></option>
                                        <?php  } ?>
                                </select>
                        </div>                                <!--input type="hidden"  id="resumefile" name="resumefile" value="<?php //echo $pdfdata;?>"-->

			<!--div class="form-group col-md-12">
                        	<label for="phone">Upload Resume </label>
                                <input type="file" path="resume_file" id="resume_file" name="resume_file" ><?php //$pdfdata= $userDetails['resume_file_data'];?>
<a href="getpdf.php?id_no=<?php echo $userDetails['user_id']; ?>">View Resume Pdf</a-->

<BR>

<!--object data="data:application/pdf;base64,<?php //echo base64_encode($userDetails['resume_file_data']) ?>" type="application/pdf">
    <iframe src="data:application/pdf;base64,<?php //echo base64_encode($userDetails['resume_file_data']) ?>"></iframe>
</object>

                        </div>
			<div class="form-group col-md-12">
                        	<label for="phone">Upload Your Photo </label>
                                <input type="file" path="uploadphoto" id="uploadphoto" name="uploadphoto" value="<?php echo $userDetails['profile_photo']; ?>" ><?php if(empty($userDetails['profile_photo'])){ ?>	
															<img src="../images/noimages.jpeg" width="100px" height="100px">
															<?php }else{?>
														<img src="../../uploads/photos/<?php echo $userDetails['id'];?>/<?php echo $userDetails['profile_photo'];?>" width="100px" height="100px"><?php }?>
                        </div-->
			<div class="form-group col-md-12">
                        	<label for="disc">Domain</label>
                                <textarea class="form-control" rows="3"  name="subject"><?php echo $userDetails['subject']; ?></textarea>
                        </div>
					<div class="login-btn">
					   <?php if(empty($_GET['id'])){?>
					   	<input type="submit" name="add-user" value="Add">
                			<?php } else { ?>
                        			<input type="submit" name="update-user" value="Update">
                			<?php } ?>
					</div>                    

				 </form>
		           </div>
                </div>
         </div>
   </div>
  <div class="clearfix"> </div>
 </div>
</div>
<br/>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'; ?>
