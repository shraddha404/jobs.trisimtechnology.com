<?php session_start();error_reporting(0); // Disable all errors.

include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/User.class.php';
if(empty($_SESSION['user_id'])){
	header('Location:/login.php');
}
$u = new User($_SESSION['user_id']);

if($_GET['oper'] == 'delete'){
        if($u->deleteJob($_GET['id'])){
                        $msg = "Deleted successfully.";
                }else{
                        $msg = $u->error;
                }
}
if($_GET['oper'] == 'disable'){
        if($u->disableJob($_GET['id'])){  
                        $msg = "Disabled job successfully.";
                }else{
                        $msg = $u->error;
                }
}
if($_GET['oper'] == 'enable'){
        if($u->enableJob($_GET['id'])){
                        $msg = "Enabled job successfully.";
                }else{
                        $msg = $u->error;
                }
}
if($_GET['oper'] == 'refresh'){
        if($u->refreshJob($_GET['id'])){
                        $msg = "Refreshed job successfully.";
                }else{
                        $msg = $u->error;
                }
}
$jobs = $u->getJobs($_GET['id']);

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/header.php';
?>
<div class="container">
	<br/><h2 align="center">Manage Jobs</h2>
		
	<div class="col-md-12">
			 <a href="add_jobs.php"><label class="btn2 btn-2 btn2-1b">Add New</label></a>     <br> <br/>
			 <!-- use the filter_reset : '.reset' option or include data-filter="" using the filter button demo code to reset the filters -->
        <div class="bootstrap_buttons">
            <button type="button" class="reset btn btn-primary" data-column="0" data-filter=""><i class="bootstrap-icon-white glyphicon glyphicon-refresh"></i> Reset filters</button>           
           
          <a href="export_jobs_details.php" class="btn btn-primary" role="button"><i class="bootstrap-icon-white glyphicon glyphicon-export"></i> <span>Export</span></a>
        </div>
        <br><?php if(!empty($_SESSION['succ'])){?><h4><?php echo $_SESSION['succ']; $_SESSION['succ']=''; ?></h4><?php } ?>
		<h4><?php echo $msg; ?></h4>
		<div class="col-md-12 single_right">
			<div class="row" >

<div class="table-responsive">
<br/>
<table class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
  <thead>
    <tr style="background-color:#337ab7 !important;">
      <th scope="col">ID</th>
      <th scope="col">Job Name</th>
      <th scope="col">Location</th>
      <th scope="col">Company Name</th>
      <th scope="col">Designation</th>
      <th scope="col">Description</th>
      <th scope="col">Posted On</th>
      <!--th scope="col">Valid Till</th-->
      <th scope="col">Posted By</th>
      <th class="col">Responses Received</th>
      <th scope="col" data-filter="false">Action</th>
    </tr>
    
      <tfoot>

                    <tr>
                        <th colspan="13" class="ts-pager form-inline">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-default first"><span class="glyphicon glyphicon-step-backward"></span></button>
                                <button type="button" class="btn btn-default prev"><span class="glyphicon glyphicon-backward"></span></button>
                            </div>
                            <!--<span class="pagedisplay"></span>-->
                            <span class = "label label-info">Page No:</span>
                            <select class="form-control input-sm pagenum" title="Select page number"></select>
                           
                             <span class = "label label-info">Number of rows:</span>
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
	<?php $k=1; foreach($jobs as $job){
	$posted_by = $u->userDetails($job['posted_by']);
	?>
    <tr>
      <td class="lablewhite" align="center"><?php echo $job['id'];?></td>
      <td class="lablewhite" align="center"><?php echo $job['job_name'];?></td>
      <td class="lablewhite" align="center"><?php echo $job['location'];?></td>
      <td class="lablewhite" align="center"><?php echo $job['company_name'];?></td>
      <td class="lablewhite" align="center"><?php echo $job['designation'];?></td>
      <td class="lablewhite" ><?php echo $job['description'];?></td>
      <td class="lablewhite" align="center"><?php echo $job['posted_on'];?></td>
      <!--td class="lablewhite" align="center"><?php //echo $job['valid_till'];?></td-->
      <td class="lablewhite" align="center"><?php echo $posted_by['first_name'];?></td>
      <td class="lablewhite" align="center"><a href="candidate_list.php?id=<?php echo $job['id'];?>"><?php echo $job['count']; ?></a></td>

      <td class="lablewhite" align="center">
	  <a href="add_jobs.php?id=<?php echo $job['id'];?>" rel="#overlay" title="Edit"><img src="/images/edit.png" width="17"></a> <?php if($job['active']=='1'){?>|
	  <a class="fa fa-arrow-circle-down custom-color" style="color: green;" href="?id=<?php echo $job['id'];?>&oper=disable" rel="#overlay" title="Disable" onclick="return confirm('Are you sure you want to Disable?');">
</a><?php } ?><?php if($job['active']=='0'){?>|
	  <a class="fa fa-arrow-circle-up custom-color" style="color: red;" href="?id=<?php echo $job['id'];?>&oper=enable" rel="#overlay" title="Enable" onclick="return confirm('Are you sure you want to Enable?');">
</a><?php } ?>
	|
	  <a href="?id=<?php echo $job['id'];?>&oper=refresh" rel="#overlay" title="Refresh" onclick="return confirm('Are you sure you want to Refresh?');"><i class="bootstrap-icon-white glyphicon glyphicon-refresh"></i></a>
      </td>
    </tr>
	<?php $k++ ; } ?>
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
    </div>
 </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'; ?>
