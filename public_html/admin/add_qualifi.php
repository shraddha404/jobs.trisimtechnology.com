<?php session_start();
//include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/User.class.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/Admin.class.php';
if(empty($_SESSION['user_id'])){
                header("Location:/login.php");
}
$u = new User($_SESSION['user_id']);

$qualif_id = $_GET['id'];
$qualifDetails = $u->getQualificationById($_GET['id']);
//print_r($userDetails);exit;

if($_POST['add-qua']=='Add'){
        if($u->addQualification($_POST)){
                        //$msg = "Added successfully.";
			 $_SESSION['succ'] = 'Add successfully.';
			 header("Location:/admin/manage_qualifi.php");
                }else{
                        $msg = $u->error;
                }
}
if($_POST['update-qua']=='Update'){
        if($u->updateQualification($_POST)){
                        //$msg = "Updated successfully.";
			 $_SESSION['succ'] = 'Updated successfully.';
			 header("Location:/admin/manage_qualifi.php");
                }else{
                        $msg = $u->error;
                }
}

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/header.php';
?>
<div class="container">
    <div class="single">
	   <div class="col-md-2">
           </div> 
	 <div class="col-md-8 single_right">
	 	   <div class="login-form-section">
                <div class="login-content">
                    <form method="post">
			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" >
                        <div class="section-title">
							 <?php if(empty($_GET['id'])){?>
                            <h3>Add Qualification</h3>
                            <?php } else { ?>
                            <h3>Update Qualification</h3>
                                        <?php } ?>
				<h4><?php echo $msg;?></h4>
                        </div>
                        <div class="textbox-wrap">
                            <div class="input-group">
				<span class="input-group-addon"></span>
                                <input type="text" required="required" class="form-control" placeholder="Qualification"  name="qualification" value="<?php echo $qualifDetails['qualification']; ?>">
                            </div>
                        </div>
					<div class="login-btn">
					   <?php if(empty($_GET['id'])){?>
                                                <input type="submit" name="add-qua" value="Add">
                                        <?php } else { ?>
                                                <input type="submit" name="update-qua" value="Update">
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
