<?php  include_once ('includes/php_header.php');
include_once ('includes/header.php'); 

if(!empty($_POST)){
	$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];


$from = 'Resume Contact Form'; 
$to = 'info@resumes.carvingit.com'; 
$subject = 'Message from Contact Resume ';
 
$body = "From: $name\n E-Mail: $email\n Message:\n $message";
// Check if name has been entered
if (!$_POST['name']) {
	$errName = 'Please enter your name';
}
 
// Check if email has been entered and is valid
if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	$errEmail = 'Please enter a valid email address';
}
 
//Check if message has been entered
if (!$_POST['message']) {
	$errMessage = 'Please enter your message';
}
/*Check if simple anti-bot test is correct
if ($human !== 5) {
	$errHuman = 'Your anti-spam is incorrect';
}*/

// If there are no errors, send the email
if (!$errName && !$errEmail && !$errMessage) {
//
	if ($u->sendEmail($to, $subject, $body)) {
		$result='<div class="alert alert-success">Thank You! I will be in touch</div>';
	} else {
		$result='<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later</div>';
	}
}



}?>

<div class="container">
    <div class="single">  
	   <div class="form-container">
        <h2>Contact Us</h2>
	  <form class="form-horizontal" role="form" method="post" action="">
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Name <span class="mandatory">* </span></label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" value="">
			<?php echo "<p class='text-danger'>$errName</p>";?>
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label">Email <span class="mandatory">* </span></label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="">
			<?php echo "<p class='text-danger'>$errEmail</p>";?>
				</div>
			</div>
			<div class="form-group">
				<label for="message" class="col-sm-2 control-label">Message <span class="mandatory">* </span></label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="4" name="message"></textarea>
			<?php echo "<p class='text-danger'>$errMessage</p>";?>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<! Will be used to display an alert to the user>
				</div>
			</div>
		</form>
    </div>
 </div>
</div>
<?php include_once ('includes/footer.php'); ?>
