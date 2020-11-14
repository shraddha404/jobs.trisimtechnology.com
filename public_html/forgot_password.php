<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/../lib/User.class.php';
$u = new User($_SESSION['user_id']);


if (!empty($_POST)) {
    if (isset($_POST['btn-submit'])) {
        //echo 'hi';exit;
        //$email = $_POST['txtemail'];
        $username = $_POST['user_name'];
        $email=$u->getUserEmail($username);
        //echo $email;exit;
        if ($u->forgotpassword($username,$email)) {

            $msg = "<div class='alert alert-success'>
		     <button class='close' data-dismiss='alert'>&times;</button>
		     We've sent an email to $email.
		       Please click on the password reset link in the email to generate new password. 
		      </div>";
        } else {
            $msg = "<div class='alert alert-danger'>
		     <button class='close' data-dismiss='alert'>&times;</button>
		     <strong>Sorry!</strong>  Please Enter correct Username. 
		       </div>";
        }
    }
}include_once ('includes/header.php');
?>
<div class="container">
    <div class="single">  
        <div class="form-container">
            <div class="col-md-4">
                <div class="col_3">
                    <!--h3>Jobs</h3>
                    <ul class="list_1">
                            <li><a href="#">Department of Health - Western Australia</a></li>
                            <li><a href="#">Australian Nursing Agency currently require experiences</a></li>		
                            <li><a href="#">Russia Nursing Agency currently require experiences</a></li>
                            <li><a href="#">The Government of Western Saudi Arbia</a></li>		
                            <li><a href="#">Department of Health - Western Australia</a></li>
                            <li><a href="#">Australian Nursing Agency currently require experiences</a></li>		
                            <li><a href="#">Russia Nursing Agency currently require experiences</a></li>
                            <li><a href="#">The Scientific Publishing Services in Saudi Arbia</a></li>	
                            <li><a href="#">BPO Private Limited in Canada</a></li>		
                            <li><a href="#">Executive Tracks Associates in Pakistan</a></li>
                            <li><a href="#">Pyramid IT Consulting Pvt. Ltd. in Pakistan</a></li>						
                    </ul-->
                </div>
                <div class="col_3"><img src="images/images.jpeg">
                    <!--h3>Jobs by Category</h3>
                    <ul class="list_2">
                            <li><a href="#">Railway Recruitment</a></li>
                            <li><a href="#">Air Force Jobs</a></li>		
                            <li><a href="#">Police Jobs</a></li>
                            <li><a href="#">Intelligence Bureau Jobs</a></li>		
                            <li><a href="#">Army Jobs</a></li>
                            <li><a href="#">Navy Jobs</a></li>		
                            <li><a href="#">BSNL Jobs</a></li>
                            <li><a href="#">Software Jobs</a></li>	
                            <li><a href="#">Research Jobs</a></li>								
                    </ul-->
                </div>
                <!--div class="widget">
              <h3>Take The Seeking Poll!</h3>
              <div class="widget-content"> 
               <div class="seeking-answer">
                              <span class="seeking-answer-group">
                                      <span class="seeking-answer-input">
                                         <input class="seeking-radiobutton" type="radio">
                                      </span>
                                      <label for="" class="seeking-input-label">
                                              <span class="seeking-answer-span">Frequently</span>
                                      </label>
                              </span>
                              <span class="seeking-answer-group">
                                      <span class="seeking-answer-input">
                                         <input class="seeking-radiobutton" type="radio">
                                      </span>
                                      <label for="" class="seeking-input-label">
                                              <span class="seeking-answer-span">Interviewing</span>
                                      </label>
                              </span>
                              <span class="seeking-answer-group">
                                      <span class="seeking-answer-input">
                                         <input class="seeking-radiobutton" type="radio">
                                      </span>
                                      <label for="" class="seeking-input-label">
                                              <span class="seeking-answer-span">Leaving a familiar workplace</span>
                                      </label>
                              </span>
                              <div class="seeking_vote">
                                <a class="seeking-vote-button">Vote</a>
                              </div>
                           </div>
             </div-->
            </div>
        </div>

        <div class="col-md-8 single_right">
            <div class="login-form-section">
                <div class="login-content">
                    <form class="form-signin" method="post">
                        <h2 class="form-signin-heading">Forgot Password</h2><hr />

<?php
if (isset($msg)) {
    echo $msg;
} ?>
                           <!-- <div class="form-group col-md-12">
                                <label for="myName">Enter Email Address<span class="mandatory">* </span></label>
                                <input type="email" class="form-control" placeholder="Email Email address" name="txtemail" required />
                            </div>  -->
                           


                        <div class="form-group col-md-12">
                            <label for="myName">Enter UserName <span class="mandatory">* </span></label>
                            <input id="user_name" name="user_name" class="form-control" type="text" data-validation="required" required="" placeholder="Email UserName">
                           
                        </div>
                        <div class="form-group col-md-12">
                        <button class="btn  btn-primary center" type="submit" name="btn-submit">Generate new Password</button>
                        </div>
                    
                    </form><br>
                    <!---div class="login-bottom">
                     <p>With your social media account</p>
                     <div class="social-icons">
                            <div class="button">
                                    <a class="tw" href="#"> <i class="fa fa-twitter tw2"> </i><span>Twitter</span>
                                    <div class="clearfix"> </div></a>
                                    <a class="fa" href="#"> <i class="fa fa-facebook tw2"> </i><span>Facebook</span>
                                    <div class="clearfix"> </div></a>
                                    <a class="go" href="#"><i class="fa fa-google-plus tw2"> </i><span>Google+</span>
                                    <div class="clearfix"> </div></a>
                                    <div class="clearfix"> </div>
                            </div>
                            <h4>Don,t have an Account? <a href="register.php"> Registration/Sign up!</a></h4>
                     </div-->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"> </div>
</div>
</div>

<?php include_once ('includes/footer.php'); ?>
</body>
</html>	
