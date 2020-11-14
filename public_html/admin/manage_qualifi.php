<?php session_start();error_reporting(0);
include_once $_SERVER['DOCUMENT_ROOT'].'/../lib/User.class.php';
if(empty($_SESSION['user_id'])){
                header("Location:/login.php");
}
$u = new User($_SESSION['user_id']);

if($_GET['oper'] == 'delete'){
        if($u->deleteQualification($_GET['id'])){
                        $msg= "Deleted successfully.";
                }else{
                        $msg = $u->error;
                }
}

$qualifications = $u->getQualifications();
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/header.php';
?>

<div class="container">
	<br/><h2 align="center">Manage Qualifications</h2>
		<?php if(!empty($_SESSION['succ'])){?><h4><?php echo $_SESSION['succ']; $_SESSION['succ']=''; ?></h4><?php } ?>
		<!--<a href="add_qualifi.php"><label class="btn2 btn-2 btn2-1b">Add New</label></a>-->
		<div class="col-md-12 single_right">
			<div class="row" >

<div class="table-responsive">
<br/>
<div class="bootstrap_buttons">
           <button type="button" class="reset btn btn-primary" data-column="0" data-filter=""><i class="bootstrap-icon-white glyphicon glyphicon-refresh"></i> Reset filters</button>           
           
         <!--a href="export_skills_details.php" class="btn btn-primary" role="button"><i class="bootstrap-icon-white glyphicon glyphicon-export"></i> <span>Export</span></a-->
        </div>
        <br>
<table class="table table-striped table-bordered" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
  <thead>
    <tr style="background-color:#337ab7 !important;" >
      <th scope="col" class="text-center whitetheadtr" >ID</th>
      <th scope="col" class="text-center whitetheadtr" >Qualification</th>
      <th scope="col" class="text-center whitetheadtr"  data-sorter="false" data-filter="false">Action</th>
    </tr>
  </thead>
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
  <tbody>
	<?php foreach($qualifications as $quali){?>
    <tr>
      <td class="lablewhite" align="center"><?php echo $quali['id'];?></td>
      <td class="lablewhite" align="center"><?php echo $quali['qualification'];?></td>
      <td  class="lablewhite" align="center"><a href="add_qualifi.php?id=<?php echo $quali['id'];?>" rel="#overlay" title="Edit"><img src="/images/edit.png" width="17"></a> 
	  <!--<a href="manage_qualifi.php?id=<?php echo $quali['id'];?>&oper=delete" rel="#overlay" title="Delete" onclick="return confirm('Are you sure you want to Delete?');"><img src="/images/rubbish-bin.png" width="17"></a>-->
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
