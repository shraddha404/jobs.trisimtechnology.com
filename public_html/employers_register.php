<?php
//include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Admin.class.php';
include_once ('includes/php_header.php');
$msg="";

if ($_POST['register-user'] == 'Register') {
      if ($u->createNewEmployers($_POST, $_FILES)) { //print_r($_FILES);
        $msg = '<font color="green">Added successfully.</font>';
         if(!empty($msg)){ 
				$loginname = $_POST['username'];
				$password = $_POST['password'];
					if(!empty($_POST['username']) && $u->authenticate($loginname,$password)){
					$user_type = $u->getUserType();
					$_SESSION['user_type'] = $user_type;
				
		        	header('location:employer/employer_profile.php');
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


include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

<script>
    $(function () {
        $("#date_of_birth").datepicker();
    });
    $(document).ready(function () {
        $("#fresher_yes").on("click", function () {

            if (this.checked) {
                //$("#work_exp_years").val(0);
                //$("#work_exp_months").val(0);
                $("#experience_div").hide();
                $("#fresher_div").show();
                $("#is_experienced").val('no');
            }

        });
        $("#fresher_no").on("click", function () {
            if (this.checked) {
                $("#fresher_div").hide();
                $("#experience_div").show();
                $("#is_experienced").val('yes');

            }

        });
        $('#resume_file').on('change', function () {
            var numb = $(this)[0].files[0].size / 1024 / 1024;
            var type = $(this)[0].files[0].type;
            //alert(type);
            numb = numb.toFixed(2);
            if (numb > 2) {
                alert('Please upload resume of size <=2MB');
                return false;
            } else if (type != 'application/pdf') {
                alert('Sorry, invalid File Type of Resume.');
                return false;
            } else {

                return true;
            }

        });
        $('#multiple-checkboxes').multiselect(
        {
        buttonWidth: '100%', 
       
        onChange: function (element, checked) {
            var brands = $('#multiple-checkboxes option:selected');
            var selected = [];
            $(brands).each(function (index, brand) {
                selected.push([$(this).val()]);
                
            });
            
            if(selected.length>3)
            {
                var lastEl = $(selected).last()[0];
                $('#multiple-checkboxes').multiselect('deselect', [lastEl]);
                selected.pop();
                alert('Select upto 3 locations only');                
            }
           
        }
    });


    /* $("#register_user").on("click", function () {
     
     if (('#agree_terms').checked){
     return true;
     }
     else if(!('#agree_terms').checked){
     return false;
     }
     });*/
    });
</script>

<div class="container">
    <div class="single">  
        <div class="form-container">
            <h4 align="center"><?php echo $msg; ?></h4>
            <div class="row">
                            <div class="col-md-8 col-sm-8 col-lg-8 col-md-offset-2">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Sign up
                        </div>
                        <div class="panel-body">
                            <form action="" method="post" enctype="multipart/form-data" id="form_register">
                                <input type="hidden" name="is_experienced" value="" id="is_experienced">
                                
                           <h4 style="border-bottom:1px solid #CCC;padding:5px 0px;color:red;">Personal Information</h4>
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
                                    <label for="lastname">Middle Name</label>
                                
                                </div>
                                 <div class="form-group col-md-10">
                                    <input id="middle_name" name="middle_name" class="form-control" type="text"  >
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
             <h4 style="border-bottom:1px solid #CCC;padding:5px 0px;color:red;">Professional Status</h4>
 
                                <div class="form-group col-md-12">
                                 <div class="form-group col-md-2">
                                                <label for="phone">Telephone/contact number <span class="mandatory">* </span></label>
                                               
                                            </div>
                                            <div class="form-group col-md-10">
                                                <input type="text" id="mobile_number" name="mobile_number" class="form-control" required="">
                                                <span id="error_phone" class="text-danger"></span>
                                            </div>
                                     </div>          
                                                             <div class="form-group col-md-12">
                               <div class="form-group col-md-2">
                                    <label for="age">Name of company<span class="mandatory">* </span></label>
                         
                                </div>
                                <div class="form-group col-md-10">
                                    <input id="company" name="company" class="form-control" type="text" data-validation="required" required=""> 
                                    <span id="error_company" class="text-danger"></span>
                                </div>
                                 </div>
                                                             <div class="form-group col-md-12">
        			  <div class="form-group col-md-2">
                                    <label for="age">Designation<span class="mandatory">* </span></label>
                                   
                                </div>
                                 <div class="form-group col-md-10">
                                    <input id="desgination" name="desgination" class="form-control" type="text" data-validation="required" required=""> 
                                    <span id="error_desgination" class="text-danger"></span>
                                </div>
                                 </div>
                                                             <div class="form-group col-md-12">
				<div class="form-group col-md-2">
                                    <label for="p_address">Registered Office address: <span class="mandatory">* </span></label>
                               
                                </div>
                            <div class="form-group col-md-10">
                                    <input type="text" id="address" name="address" class="form-control" required="">
                                    <span id="error_address" class="text-danger"></span>
                                </div>
                                 </div>
                                                             <div class="form-group col-md-12">
				<div class="form-group col-md-2">
                                    <label for="p_address">Website: <span class="mandatory">* </span></label>
                                    
                                </div>
                                <div class="form-group col-md-10">
                                    <input type="text" id="website" name="website" class="form-control" required="">
                                    <span id="error_website" class="text-danger"></span>
                                </div>
                                 </div>
                                                             <div class="form-group col-md-12">
 				<div class="form-group col-md-2">
                                    <label for="exampleInputEmail1">Company's email address: <span class="mandatory">* </span></label>
                                  
                                </div>
                                <div class="form-group col-md-10">
                                    <input id="exampleInputEmail1" class="form-control" required="" name="cemail" type="email" placeholder="email@example.com">

                                    <span id="error_email" class="text-danger"></span>
                                </div>
                                 </div>
                                  <div class="form-group col-md-12">
                                <div class="form-group col-md-2">
                                    <label for="exampleInputEmail1">Contact Person: <span class="mandatory">* </span></label>
                                    
                                </div>
                                   <div class="form-group col-md-10">
                                    <textarea id="contact_person" required="" class="form-control" rows="3" name="contact_person"  placeholder="Contact person name"></textarea>

                                    <span id="error_email" class="text-danger"></span>
                                </div>
                                 </div>
                                     <div class="form-group col-md-12">
                                <div class="form-group col-md-2">
                                    <label for="exampleInputEmail1">Company profile: <span class="mandatory">* </span></label>
                                    
                                </div>
                                   <div class="form-group col-md-10">
                                    <textarea id="company_profile" required="" class="form-control" rows="3" name="company_profile"  placeholder="Describe company profile in short"></textarea>

                                    <span id="error_email" class="text-danger"></span>
                                </div>
                                 </div>
                                                             
									<div class="form-group col-md-12">
                                            <div class="form-group col-md-2">
                                                <label for="phone">Upload Your Logo <span class="mandatory">* </span></label>
                                                
                                            </div>
                                            <div class="form-group col-md-10">
                                                <input type="file" path="uploadphoto" id="uploadphoto" name="uploadphoto" accept="image/*" required="">

                                                <span id="error_city" class="text-danger"></span>
                                            </div>
                                            </div> 
                                <div class="form-group col-md-12">
                                    <!--div class="g-recaptcha" data-sitekey="6Lf4ypkUAAAAAG2DtIAViPuiYKjFTCgb2j8zY0gF" id="g-recaptcha-response"></div-->
                                    
                                    <div class="form-group col-md-2">
                                    
                                </div>
                                   <div class="form-group col-md-10">
                                                            <div class="g-recaptcha" data-sitekey="6LfT8aUUAAAAAD-Jlf6EDV-ta6S_6Ckiktc5LS7I" id="g-recaptcha-response"></div>

                                </div>
                                    
                                    
                                    
                                </div>
                                                             <div class="form-group col-md-12">

                                <button  type="submit"  value="Register" name="register-user" id="register_user" class="btn btn-primary center">Register</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>


<?php include_once ('includes/footer.php'); ?>
