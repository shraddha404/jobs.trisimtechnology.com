<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/../lib/User.class.php';
if (empty($_SESSION['user_id'])) {
    header('Location:/login.php');
}

//echo $_SESSION['user_id'];exit;
$u = new User($_SESSION['user_id']);
if (!empty($_POST)) {  
//Update basic details
    $user_id = $u->updateEmployee($_POST, $_FILES);
}
$id=$_SESSION['user_id'];
if (!empty($_GET['id'])) {  
//Update basic details
    $id=$_GET['id'];
    $employerdetails = $u->getEmployerDetails($_GET['id']);
}else{
$employerdetails = $u->getEmployerDetails($_SESSION['user_id']);
}
//print_r($employerdetails);exit;


include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<div class="container">
    <div class="single">  
        <div class="form-container">
            <h4 align="center"><?php echo $msg; ?></h4>
            <div class="row">
                <div class="col-md-6 col-sm-12 col-lg-6 col-md-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <?php if (empty($_GET['id'])){?>
                                   My Profile
                                    <?php } else{?>
                                     Employer Profile
                                      <?php } ?>
                        </div>
                        <div class="panel-body">
                            <form action="" method="post" enctype="multipart/form-data" id="form_employer_edit">
                                <?php foreach($employerdetails as $emp_details){ ?>
                                <input id="user_id" name="user_id"  type="hidden"  value="<?php echo $emp_details['id'] ?>">
                                <div class="form-group col-md-12">
                                    <label for="myName">First Name <span class="mandatory">* </span></label>
                                    <input id="first_name" name="first_name" class="form-control" type="text" data-validation="required" required="" value="<?php echo $emp_details['first_name'] ?>">
                                    <span id="error_name" class="text-danger"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="lastname">Middle Name </label>
                                    <input id="middle_name" name="middle_name" class="form-control" type="text"  required="" value="<?php echo $emp_details['middle_name'] ?>">
                                    <span id="error_middle" class="text-danger"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="lastname">Last Name <span class="mandatory">* </span></label>
                                    <input id="lastname" name="lastname" class="form-control" type="text" data-validation="required" required="" value="<?php echo $emp_details['last_name'] ?>">
                                    <span id="error_lastname" class="text-danger"></span>
                                </div>                                
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">Email <span class="mandatory">* </span></label>
                                    <input id="exampleInputEmail1" class="form-control" required="" name="email" type="email" placeholder="email@example.com" value="<?php echo $emp_details['email'] ?>">

                                    <span id="error_email" class="text-danger"></span>
                                </div>
                                <div class="form-group col-md-12">
                                                <label for="phone">Telephone/contact number <span class="mandatory">* </span></label>
                                                <input type="text" id="mobile_number" name="mobile_number" class="form-control" required="" value="<?php echo $emp_details['mobile_number'] ?>">
                                                <span id="error_phone" class="text-danger"></span>
                                            </div>
                               <div class="form-group col-md-12">
                                    <label for="age">Name of company<span class="mandatory">* </span></label>
                                    <input id="company" name="company" class="form-control" type="text" data-validation="required" required="" value="<?php echo $emp_details['name_of_company'] ?>"> 
                                    <span id="error_company" class="text-danger"></span>
                                </div>
                               
        			  <div class="form-group col-md-12">
                                    <label for="age">Designation<span class="mandatory">* </span></label>
                                    <input id="desgination" name="desgination" class="form-control" type="text" data-validation="required" required="" value="<?php echo $emp_details['desgination'] ?>"> 
                                    <span id="error_desgination" class="text-danger"></span>
                                </div>
				<div class="form-group col-md-12">
                                    <label for="p_address">Registered Office Address: <span class="mandatory">* </span></label>
                                    <input type="text" id="address" name="address" class="form-control" required="" value="<?php echo $emp_details['firm_address'] ?>">
                                    <span id="error_address" class="text-danger"></span>
                                </div>
				<div class="form-group col-md-12">
                                    <label for="p_address">Website: <span class="mandatory">* </span></label>
                                    <input type="text" id="website" name="website" class="form-control" required="" value="<?php echo $emp_details['website'] ?>">
                                    <span id="error_website" class="text-danger"></span>
                                </div>
 				<div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">Company's email address: <span class="mandatory">* </span></label>
                                    <input id="exampleInputEmailcompany" class="form-control" required="" name="cemail" type="email" placeholder="email@example.com" value="<?php echo $emp_details['company_email'] ?>">

                                    <span id="error_email" class="text-danger"></span>
                                </div>
    				<!--div class="form-group col-md-12">
                                    <?php if (empty($_GET['id'])){?>
                                    <label for="phone">Upload Your Photo </label>
                                    <?php } else{?>
                                     <label for="phone">Employer Photo</label>
                                      <?php } ?>
                                    <?php if (empty($emp_details['profile_photo'])) { ?>	<img src="/images/noimages.jpeg" width="100px" height="100px"><?php } else { ?>
                                    <img src="/uploads/photos/<?php echo $id; ?>/<?php echo urldecode($emp_details['profile_photo']); ?>" width="100px" height="100px"><?php } ?><br />
                                    <?php if (empty($_GET['id'])){?>
                                    <input type="file" path="uploadphoto" id="uploadphoto" name="uploadphoto" accept="image/*" >
                                    <?php }?>
                                    <span id="error_city" class="text-danger"></span>
                                </div-->
                                <?php }
                                 if (empty($_GET['id'])){?>
                                <button  type="submit"  value="Update" name="update_employer" id="update_employer" class="btn btn-primary center">Update</button>
 <?php } ?>
                            </form>

                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>


<?php include_once $_SERVER['DOCUMENT_ROOT'] .'/includes/footer.php'; ?>
