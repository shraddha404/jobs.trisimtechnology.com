<?php session_start();error_reporting(0);
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/User.class.php';
$u = new User($_SESSION['user_id']);
if (isset($_GET["id"])) {
  $id = intval(base64_decode($_GET["id"]));
 
 		 $msg = $u->resgistrationActivation($id);
          $errMsg=$msg;
}
if(!empty($_POST)){ 
        $loginname = $_POST['username'];
        $password = $_POST['password'];
        if(!empty($_POST['username']) && $u->authenticate($loginname,$password)){
		$user_type = $u->getUserType();
		$_SESSION['user_type'] = $user_type;
		  if($_SESSION['user_type']=='Admin'){
			header('location: admin/dashboard.php');
			}else if($_SESSION['user_type']=='User'){
			header('Location:my_profile.php');
			}
			else if($_SESSION['user_type']=='Employer'){
			header('location:employer/search_users.php');
			}
        }
		else {
				$errMsg= $u->getError();
		 }
}
include_once ('includes/header.php'); //echo md5("priyanka");?>
<div class="container">
    <!--div class="single"-->  
		    <div>  

	   <div class="col-md-4">
	   	  <div class="col_3">
	   	  	
	   	  </div>
	   	  <div class="col_3"><img src="images/images.jpeg">
	   	  	
	   	  </div>
	   
    	</div>
	 </div>
	 <div class="col-md-8 single_right">           
	 	   <div class="login-form-section">
                <div class="login-content">
                    <form method="post" style="margin-top:20px;">
                        <div class="section-title">
                            <h3>Login to your Account</h3>
                        </div>
                        
                        <div class="textbox-wrap">            
 <div class="section-title">
                            <h4  style="color: red"><?php echo $errMsg; ?></h4>
                        </div>
                            <div class="input-group">
                                <span class="input-group-addon "><i class="fa fa-user"></i></span>
                                <input type="text" required="required" class="form-control" placeholder="Username"  name="username">
                            </div>
                        </div>
                        <div class="textbox-wrap">
                            <div class="input-group">
                                <span class="input-group-addon "><i class="fa fa-key"></i></span>
                                <input type="password" required="required" class="form-control " placeholder="Password" name="password">
                            </div>
                        </div>

                     <div class="forgot">
						
				 		  <div class="login-para">
				 			<p><a href="forgot_password.php"> Forgot Password? </a></p>
				 		 </div>
			        </div>
					<div class="login-btn">
					   <input type="submit" value="Log in">
					</div>                    

				 </form>
					<div class="login-bottom">
					

						<h4>Don't have an account? <a href="register.php">Sign up here as Candidate</a>&nbsp;|&nbsp;<a href="employers_register.php">Sign up here as Employers</a></h4>


					 </div>
		           </div>
                </div>
         </div>
   </div>
 </div>
</div>
<br/>
<?php include_once ('includes/footer.php'); ?>

