<?php session_start();error_reporting(0);
include_once $_SERVER['DOCUMENT_ROOT'] . '/../lib/User.class.php';
if (empty($_SESSION['user_id'])) {
    header('Location:/login.php');
}
$u = new User($_SESSION['user_id']);

if ($_GET['oper'] == 'delete') {
    // echo $_GET['id'];exit;
    if ($u->deleteEmployer($_GET['id'])) {
        
        $msg = 'Employer Deleted successfully.';
    } else {
        $msg = $u->error;
    }
}
if (isset($_POST['clear'])) {
    unset($_GET);
}

$users = $u->getallEmployerDetails();



include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<div class="container">
    <br/><h2 align="center">Manage Employer</h2>
    
    <div class="col-md-12">
       
        <br/>
        <!-- use the filter_reset : '.reset' option or include data-filter="" using the filter button demo code to reset the filters -->
       <div class="bootstrap_buttons">
            <button type="button" class="reset btn btn-primary" data-column="0" data-filter=""><i class="bootstrap-icon-white glyphicon glyphicon-refresh"></i> Reset filters</button>           
           
           <a href="export_employer_details.php" class="btn btn-primary" role="button"><i class="bootstrap-icon-white glyphicon glyphicon-export"></i> <span>Export</span></a>
        </div>
        <br>




        <div id="demo"><h4 ><?php echo $msg; ?></h4><table id="waypointsTable" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%"> <!-- bootstrap classes added by the uitheme widget -->
                <thead>
                       <tr style="background-color:#337ab7 !important;">
                        <th class="text-center whitetheadtr" >ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Company name</th>
                        <th class="text-center">Website</th>
                        <th class="text-center" data-filter="false">Action</th>
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
                    <?php
                    if (!empty($users)) {
                        foreach ($users as $user) {
                            //echo $user['id'];exit;
                            ?>
                            <tr>
                                <td class="lablewhite" align="center"><?php echo $user['id']; ?></td>
                                <td class="lablewhite" align="center"> <?php echo $user['first_name'] . " " . $user['middle_name'] . " " . $user['last_name']; ?>
                                </td>

                                <td class="lablewhite" align="center"> <?php echo $user['email']; ?>
                                </td>
                                <td class="lablewhite" align="center"> <?php echo $user['name_of_company']; ?>
                                </td>
                                 <td class="lablewhite" align="center"><?php echo $user['website']; ?>
                                </td>
                           
 <td>
                                    <a  align="center" href="/employer/employer_profile.php?id=<?php echo $user['id']; ?>" rel="#overlay" title="View"><img src="/images/download.png" width="17"></a> 
                                    <a align="center" href="?id=<?php echo $user['id']; ?>&oper=delete" rel="#overlay" title="Delete" onclick="return confirm('Are you sure you want to Delete?');"><img src="/images/rubbish-bin.png" width="17"></a>
                                </td>


                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
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

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
