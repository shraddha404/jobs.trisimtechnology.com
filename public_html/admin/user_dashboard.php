<?php session_start();
//include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/User.class.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Admin.class.php';

if(empty($_SESSION['user_id'])){
        header("Location:/login.php");
}
$u = new User($_SESSION['user_id']);
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/header.php';
//include_once ('includes/header.php');
?>

<div class="container">
	<br/><h2 align="center">Users</h2><br/>
		<div class="col-md-12 single_right">
			<div class="row" >
				<div class="form-group col-md-1"></div>
                        	<div class="form-group col-md-5">
                                	<div class="profile-box-white">
                                                	<div class="row grid_3" align="center">
							<h3>Employer</h3>
							<a href="manage_employer.php"><img src="/images/employer.png" alt="" width="100px" height="108px"/></a>
							<!--a href="manage_users.php"><button type="button" class="btn red">Manage</button></a-->
                                                        </div>
                                         </div>
                                 </div>
                                <div class="form-group col-md-5">
                                        <div class="profile-box-white">
                                                         <div class="row grid_3" align="center">
                                                         <h3 align="center">Candidate</h3>
							<a href="manage_users.php"><img src="/images/job_seeker.png" alt=""  width="100px" height="108px"/></a>
							 </div>
                                         </div>
                                 </div>
                         </div>
                       
                 </div>
</div>
  <div class="clearfix"> </div>
 </div>
</div>
<br/>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'; ?>

