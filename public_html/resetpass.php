<?php 

include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/User.class.php';
$u = new User($_SESSION['user_id']);
 if(empty($_SESSION['user_id']))
{
  //header("Location:index.php");
}

if(!empty($_POST)){ 
//echo 'hi';exit;
if(isset($_GET['id']) && isset($_GET['code']))
{
 $id = base64_decode($_GET['id']);
 $code = $_GET['code'];
 $pass=$_POST['pass'];

 $count = $u->resetPassword($id,$pass);
if($count)
{
     $msg = "<div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      Password Changed.
      </div>";
    header("refresh:5;index.php");
}
 /*if($count == 1)
 {
  if(isset($_POST['btn-reset-pass']))
  {
   $pass = $_POST['pass'];
   $cpass = $_POST['confirm-pass'];
   
   if($cpass!==$pass)
   {
    $msg = "<div class='alert alert-block'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Sorry!</strong>  Password Doesn't match. 
      </div>";
   }
   else
   {
    $stmt =$u->pdo->prepare("UPDATE users SET password=? WHERE id=?");
    $stmt->execute(array($cpass,$rows['id']));
    
    $msg = "<div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      Password Changed.
      </div>";
    header("refresh:5;index.php");
   }
  } */
 }
 else
 {
  exit;
 }
 
 
}
include_once ('includes/header.php');?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

<script>
            var allowsubmit = false;
		$(function(){
			//on keypress 
			$('#confpass').keyup(function(e){
				//get values 
				var pass = $('#pass').val();
				var confpass = $(this).val();
				
				//check the strings
				if(pass == confpass){
					//if both are same remove the error and allow to submit
					$('.error').text('');
					allowsubmit = true;
                                        $("#btnSubmit").attr("disabled", false);
				}else{
					//if not matching show error and not allow to submit
					$('.error').text('Password not matching');
					allowsubmit = false;
                                        $("#btnSubmit").attr("disabled", true);
				}
			});
                });
               
		
            
            </script>
<div class="container">
    <div class="single">  
	   <div class="col-md-4">
	   	  <div class="col_3">
	   
    	</div>
               <div class="col_3"><img src="images/images.jpeg"></div>
	 </div>
	 <div class="col-md-8 single_right">
	 	   <div class="login-form-section">
                <div class="login-content">
                 <form class="form-signin" method="post" id="resetpass">
        <h2 class="form-signin-heading">Reset  Password</h2><hr />
        
         <?php
   if(isset($msg))
   {
    echo $msg;
   }
   else
   {
    ?>
        <div class=''><label>
                Please enter new Password</label>
    </div>  
               
        
        <input type="text" class="input-block-level" placeholder="New Password" name="pass" id="pass" required />
      <hr />
       <div class=''>
           <label> Please Re-enter Password</label>
          
    </div>  
               
        
        <input type="text" class="input-block-level" placeholder="Re-enter Password" name="confirm-pass" id="confpass" required />
       <span class="error" style="color:red"></span><br />
        <hr />
       
        <button class="btn btn-danger btn-primary" type="submit" name="btn-reset-pass" id="btnSubmit">Reset Password</button>
        <?php
   }
   ?>
                 </form></br>
					
		           </div>
                </div>
         </div>
   </div>
  <div class="clearfix"> </div>
 </div>
</div>


<?php include_once ('includes/footer.php'); ?>
</div>
</body>
</html>	
