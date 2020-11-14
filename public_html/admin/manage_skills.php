<?php session_start();error_reporting(0);
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/User.class.php';
if(empty($_SESSION['user_id'])){
                header("Location:/login.php");
}
$u = new User($_SESSION['user_id']);


if($_GET['oper'] == 'delete'){
        if($u->deleteSkill($_GET['id'])){
                        $_SESSION['succ']= "Deleted successfully.";
                }else{
                        $msg = $u->error;
                }
}
$skills = $u->getSkills();
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/header.php';
?>
<div class="container">
	<br/><h2 align="center">Manage Skills</h2>
			<a href="add_skills.php"><label class="btn2 btn-2 btn2-1b">Add New</label></a>
		<div class="col-md-12 single_right">
			<div class="row" >

<div class="table-responsive">
<br/> <div class="bootstrap_buttons">
           <button type="button" class="reset btn btn-primary" data-column="0" data-filter=""><i class="bootstrap-icon-white glyphicon glyphicon-refresh"></i> Reset filters</button>           
           
         <!--a href="export_skills_details.php" class="btn btn-primary" role="button"><i class="bootstrap-icon-white glyphicon glyphicon-export"></i> <span>Export</span></a-->
        </div>
        <br>			<?php if(!empty($_SESSION['succ'])){?><h4><?php echo $_SESSION['succ']; $_SESSION['succ']=''; ?></h4><?php } ?>

<table class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
  <thead>
    <tr style="background-color:#337ab7 !important;">
      <th scope="col" align="center" class="text-center">ID</th>
      <th scope="col" align="center" class="text-center">Name</th>
      <th scope="col" align="center" class="text-center" data-filter="false">Action</th>
    </tr>
        <tfoot>

                    <tr>
                        <th colspan="13" class="ts-pager form-inline">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-default first"><span class="glyphicon glyphicon-step-backward"></span></button>
                                <button type="button" class="btn btn-default prev"><span class="glyphicon glyphicon-backward"></span></button>
                            </div>
                            <!--<span class="pagedisplay"></span>-->
                            <span class = "label ">Page No:</span>
                            <select class="form-control input-sm pagenum" title="Select page number"></select>
                           
                             <span class = "label ">Number of rows:</span>
                            <select class="form-control input-sm pagesize" title="Select page size">
                                <option selected="selected" value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <!--<option value="all">All Rows</option>-->
                            </select>
                              <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-default next"><span class="glyphicon glyphicon-forward"></span></button>
                                <button type="button" class="btn btn-default last"><span class="glyphicon glyphicon-step-forward"></span></button>
                            </div>
                            
                        </th>
                    </tr>
                </tfoot>
  </thead>
  <tbody>
	<?php foreach($skills as $skill){?>
    <tr>
      <td class="lablewhite" align="center"><?php echo $skill['id'];?></td>
      <td class="lablewhite" align="center"><?php echo $skill['name'];?></td>
      <td class="lablewhite" align="center"style="width:100px"><a href="add_skills.php?id=<?php echo $skill['id'];?>" rel="#overlay" title="Edit"><img src="/images/edit.png" width="17"></a> |
	  <a href="?id=<?php echo $skill['id'];?>&oper=delete" rel="#overlay" title="Delete" onclick="return confirm('Are you sure you want to Delete?');"><img src="/images/rubbish-bin.png" width="17"></a>
      </td>
    </tr>
	<?php }?>
  </tbody>
</table>
</div>

                         </div>
                 </div>
</div>
  <div class="clearfix"> </div>
 </div>
</div>
<br/>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'; ?>
