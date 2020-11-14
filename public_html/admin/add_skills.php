<?php session_start();error_reporting(0);
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/User.class.php';
$u = new User($_SESSION['user_id']);

$skill_id = $_GET['id'];
$skillDetails = $u->getSkillsById($_GET['id']);
//print_r($skillDetails);exit;

if($_POST['add-skill']=='Add'){
        if($u->addSkill($_POST)){
			$_SESSION['succ'] = 'Added successfully.';
                         header("Location:/admin/manage_skills.php");
                }else{
                        $msg = $u->error;
                }
}
if($_POST['update-skill']=='Update'){
        if($u->updateSkill($_POST)){
			$_SESSION['succ'] = 'Updated successfully.';
                         header("Location:/admin/manage_skills.php");
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
                                <input type="hidden" name="id" value="<?php echo $skill_id; ?>" >
                        <div class="section-title">
					<?php		if(empty($_GET['id'])){?>
                            <h3>Add Skill</h3>
                            <?php } else {?>
					
                            <h3>Update Skill</h3>
                            <?php } ?>
				<h4><?php echo $msg;?></h4>
                        </div>
                        <div class="textbox-wrap">
                            <div class="input-group">
				<span class="input-group-addon"></span>
                                <input type="text" required="required" value="<?php echo $skillDetails['name']; ?>" class="form-control" placeholder="Name"  name="name">
                            </div>
                        </div>
					<div class="login-btn">
					   <?php if(empty($_GET['id'])){?>
					        <input type="submit" name="add-skill" value="Add">
                                        <?php } else { ?>
                                                <input type="submit" name="update-skill" value="Update">
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
