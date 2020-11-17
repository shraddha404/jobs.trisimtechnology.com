<?php session_start();error_reporting(0);
include_once $_SERVER['DOCUMENT_ROOT'] . '/../lib/User.class.php';
if (empty($_SESSION['user_id'])) {
    header('Location:/login.php');
}
$u = new User($_SESSION['user_id']);

if ($_GET['oper'] == 'delete') {
   
    if ($u->deleteUser($_GET['id'])) {
       $_SESSION['succ']= "Deleted successfully.";
    } else {
        $msg = $u->error;
    }
}
if (isset($_POST['clear'])) {
    unset($_GET);
}

$users = $u->getUsers($_GET);


//print_r($u->getmarks('hindi',1));
//print_r($_GET);
$qualifications = $u->getQualifications();
//print_r($u->getQualificationidbyNames('10th'));
//print_r($users);exit;

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<script> 
function setUserId(UserId){
    $("#user_id").val(UserId);
    $('#modaladdRemark').modal('show');
   
}

function submitRemark() {
jQuery.ajax({
  type: "POST",
  url: "add_remark.php",
  data: jQuery('form#addRemark').serialize(),
  cache: false,
  success: function (data) {
            jQuery.noConflict();
            jQuery("#modaladdRemark").modal('hide');
            location.reload();
        },
        error: function () {
            alert("Error");
        }
});
}
function getRemark(id) { 
        $.ajax({
            url: "get_remark.php",
            method: "POST",
            data: {id: id},
            dataType: "json",
            success: function (data) {
                $('#remark').val(data.remark);
                $('#user_id').val(data.user_id);
                $('.headline').text("Edit Remark");
                $('#modaladdRemark').modal('show');
            }
        });
}
$(document).ready(function(){
     $("#addRemark").submit(function (event) {
        jQuery.noConflict();
        submitRemark();
        event.preventDefault();
        return false;
    });
});



    </script>
<style>
.tooltip1 {
  position: relative;
  display: inline-block;
}

.tooltip1 .tooltiptext1 {
  visibility: hidden;
  width: 120px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  margin-left: -60px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip1 .tooltiptext1::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip1:hover .tooltiptext1 {
  visibility: visible;
  opacity: 1;
}
</style>
<div class="container">
    <br/><h2 align="center">Manage Candidate</h2>
   
    <div class="col-md-12">
        <a href="add_user.php"><label class="btn2 btn-2 btn2-1b">Add New</label></a> <br/> 
        <form method="GET" action="" id="configform">
            <div id="search_wrapper1">
                <div id="search_form" class="clearfix">
                    <!--h3>Search Users</h3-->
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="phone">Name</label>
                            <input type="text" value="<?php echo $_GET['name']; ?>" class="form-control" name="name">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="phone">Email</label>
                            <input type="text" value="<?php echo $_GET['email']; ?>" class="form-control" name="email" id="email">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="phone">Location </label>
                            <input type="text" value="<?php echo $_GET['location']; ?>" class="form-control" name="location">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="phone" style="margin-bottom: 15px;">Education </label>
                            <select name="education" id="education" class="form-control">
                                <option value="">Select</option>
                                <?php foreach ($qualifications as $qualification) { ?>
                                    <option value="<?php echo $qualification['id']; ?>" <?php if ($_GET['education'] == $qualification['id']) echo 'selected=selected'; ?> ><?php echo $qualification['qualification']; ?></option>
<?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4" id="user_subject">
                            <label for="phone" style="margin-bottom: 15px;">Subject</label>
                            <select name="subject" id="subject" class="form-control">
                                <option value="">Select</option>
                                <option value="physics">Physics</option>
                                <option value="chemistry">Chemistry</option>
                                <option value="maths">Maths</option>  
                            </select>
                        </div>
                        <div class="form-group col-md-4" id="user_marks" >
                            <label for="phone">Marks</label>  
                            <div class="form-inline">
                                <select name="subject_marks" id="subject_marks" class="form-control">
                                    <option value="">Select</option>
                                    <option value="greater"> >= </option>
                                    <option value="less"> <= </option>
                                </select>&nbsp;&nbsp;<input type="text" value="<?php echo $_GET['marks']; ?>"  name="marks" style="width:255px">      
                            </div>
                        </div>
              

                    <div class="form-group col-md-4">
                            &nbsp;&nbsp;&nbsp;&nbsp;<label for="phone" style="margin-bottom: 15px;">Experience </label>

                             
                              <div class="form-inline">
                                 <select name="exp_years" id="exp_years" class="form-control">
                                    <option value="0">Select One</option>
                                    <option value="1-2">1-2</option>
                                    <option value="2-5">2-5</option>
                                    <option value="5-8">5-8</option>
                                    <option value="8-12">8-12</option>
                                    <option value="12-15">12-15</option>
                                    <option value="15-20">15-20  </option>
                                    <option value="above 20">above 20</option>
                                 </select>
                                 <span id="error_work_exp_years" class="text-danger"></span>
                              </div>
                           </div>      </div>
                            <!--select name="exp_years" class="form-control">
                                <option value="">Select</option>
                                <?php for ($i = 0; $i <= 15; $i++) { ?>
                                    <option value="<?php echo $i; ?>" ><?php echo $i . " Year"; ?></option>
<?php } ?>
                            </select>
                            <select name="exp_months" class="form-control">
                                <option value="">Select</option>
                                <?php for ($i = 0; $i <= 12; $i++) { ?>
                                    <option value="<?php echo $i; ?>" ><?php echo $i . " Month"; ?></option>
<?php } ?>
                            </select>

                            <label for="phone">To </label>

                            <select name="to_exp_years" class="form-control ">
                                <option value="">Select</option>
                                <?php for ($i = 0; $i <= 15; $i++) { ?>
                                    <option value="<?php echo $i; ?>" ><?php echo $i . " Year"; ?></option>
<?php } ?>
                            </select>


                            <select name="to_exp_months" class="form-control">
                                <option value="">Select</option>
                                <?php for ($i = 0; $i <= 12; $i++) { ?>
                                    <option value="<?php echo $i; ?>" ><?php echo $i . " Month"; ?></option>
<?php } ?>
                            </select-->
                 

   <div class="row">
                    <div class="form-group col-md-4">
                        <label class="btn2 btn-2 btn2-1b"><input type="submit" name="submit" value="Search"></label>
                        <label class="btn2 btn-2 btn2-1b"><input type="submit" name="clear" value="Clear Search" id="clear" ></label></label>

                    </div>
</div>
                </div>
            </div>
        </form><br/>
        <!-- use the filter_reset : '.reset' option or include data-filter="" using the filter button demo code to reset the filters -->
        <div class="bootstrap_buttons">
           <button type="button" class="reset btn btn-primary" data-column="0" data-filter=""><i class="bootstrap-icon-white glyphicon glyphicon-refresh"></i> Reset filters</button>           
           
         <a href="export_user_details.php" class="btn btn-primary" role="button"><i class="bootstrap-icon-white glyphicon glyphicon-export"></i> <span>Export</span></a>
        </div>
        <br>
 <?php if (!empty($_SESSION['succ'])) { ?><h4><?php
            echo $_SESSION['succ'];
            $_SESSION['succ'] = '';
            ?></h4><?php } ?>



        <div id="demo"><table id="waypointsTable" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%"> <!-- bootstrap classes added by the uitheme widget -->
                <thead>
                    <tr style="background-color:#337ab7 !important;">
                        <th class="text-center whitetheadtr" >ID</th>
                        <th class="text-center whitetheadtr" >Name</th>
                        <th class="text-center whitetheadtr" >Email</th>
                        <th class="text-center whitetheadtr" >Contact</th>
                        <th class="text-center whitetheadtr" >Location</th>
                        <th class="text-center whitetheadtr" >Experience</th>
                        <th class="text-center whitetheadtr" >PhD Score</th>
                        <th class="text-center whitetheadtr" >Master's CGPA</th>
                        <th class="text-center">GATE</th>
                        <!--th class="text-center">GATE Domain/Score/AIR/YOP</th>-->
                        <th class="text-center whitetheadtr" >Domain</th>
                        <th class="text-center whitetheadtr" >Bachelor's CGPA</th>                                      <!--th class="text-center"> 12th Marks/Percentage/PCM Group Marks</th>-->
                        <th class="text-center">12th</th>
                        <!--th class="text-center">10th Marks</th-->
                       <!--th class="text-center whitetheadtr"  data-filter="false">Action</th>-->
                       <th class="text-center">Remarks</th>
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
                    <?php
                    if (!empty($users)) {
                        foreach ($users as $user) { //print_r($user);
                            ?>
                            <tr class="lablewhite">
                                <td class="lablewhite" align="center"><?php echo $user['id']; ?></td>
                                <td class="lablewhite" align="center"> <div class="tooltip1"><a href="#"><?php echo $user['first_name'] . " " . $user['middle_name'] . " " . $user['last_name']; ?></a>
  <span class="tooltiptext1"><a href="/my_profile.php?id=<?php echo $user['id']; ?>" rel="#overlay" title="View"><img src="/images/download.png" width="17"></a>  
                                    <a href="?id=<?php echo $user['id']; ?>&oper=delete" rel="#overlay" title="Delete" onclick="return confirm('Are you sure you want to Delete?');"><img src="/images/rubbish-bin.png" width="17"></a></span>
</div>
                                </td>

                                <td class="lablewhite" align="center" ><a href="#" data-toggle="tooltip"  title="<?php echo $user['email']; ?>">
                                        <img align="center" id ="email" src="/images/email.png" width="20"></a>
                                </td>
                                <td class="lablewhite" align="center" ><a href="#" data-toggle="tooltip"  title="<?php echo $user['mobile_number']; ?>">
                                        <img  align="center"  id ="email" src="/images/phone-outline.png" width="20"></a>
                                </td>
                            <!--<td><div class="hide_show"><img id ="email" src="/images/phone-outline.png" width="20" class="image">
                                    <div class="text_email"><?php echo $user['mobile_number']; ?></div>
                                </div></td>-->



                                <td class="lablewhite" align="center"><?php echo $user['city']; ?></td>

                                <td class="lablewhite" align="center"><?php echo $user['work_exp_years'] . " Years "; ?></td>
                                <td class="lablewhite" align="center"><?php
                                    if ($user['phd_marks']) {
                                        echo $user['phd_marks'];
                                    } else {
                                        echo "--";
                                    }
                                    ?></td>
                                <td class="lablewhite" align="center"><?php
                                    if ($user['me_cgpa']) {
                                        echo $user['me_cgpa'];
                                    }
                                    if ($user['msc_cgpa']) {
                                        echo $user['msc_cgpa'];
                                    }
                                    if ($user['mtech_cgpa']) {
                                        echo $user['mtech_cgpa'];
                                    }
                                    if (!$user['me_cgpa'] && !$user['msc_cgpa'] && !$user['mtech_cgpa']) {
                                        echo "--";
                                    }
                                    ?></td>
                                <td class="lablewhite" align="center"><?php
                                    if ($user['gate_domain']) {
                                        echo $user['gate_domain']." ";
                                    }
                                    if ($user['gate_yop']) {
                                        echo "GATE Score:" . $user['gate_marks'] . " " . "AIR:" . $user['gate_air'] . " " . "YOP:" . $user['gate_yop'];
                                    } else {
                                        echo "--";
                                    }
                                    ?></td>
                                <td class="lablewhite" align="center"><?php
                                    if ($user['be_cgpa']) {
                                        echo $user['be_cgpa'];
                                    }
                                    if ($user['btech_cgpa']) {
                                        echo $user['btech_cgpa'];
                                    }
                                    if (!$user['btech_cgpa'] && !$user['be_cgpa']) {
                                        echo "--";
                                    }
                                    ?></td>
                                <td align="center"><?php
                                    if ($user['xii_marks']) {
                                        echo "Marks:" . $user['xii_marks'] . " ";
                                    }
                                    if ($user['xii_percentage']) {
                                        echo "Percentage:" . $user['xii_percentage'] . " ";
                                    }
                                    if ($user['pcm_marks']) {
                                        echo $user['pcm_marks'];
                                    }
                                    if (!$user['xii_marks'] && !$user['xii_percentage'] && !$user['pcm_marks']) {
                                        echo "--";
                                    }
                                    ?></td>
                                <td align="center"><?php
                            echo $user['x_marks'];
                            if (!$user['x_marks']) {
                                echo "--";
                            }
                            ?></td-->

                               <!-- <td class="lablewhite" align="center">
                                    <a href="/my_profile.php?id=<?php echo $user['id']; ?>" rel="#overlay" title="View"><img src="/images/download.png" width="17"></a> 
                                    <a href="add_user.php?id=<?php echo $user['id']; ?>" rel="#overlay" title="Edit"><img src="/images/edit.png" width="17"></a> 
                                    <a href="?id=<?php echo $user['id']; ?>&oper=delete" rel="#overlay" title="Delete" onclick="return confirm('Are you sure you want to Delete?');"><img src="/images/rubbish-bin.png" width="17"></a>
                                </td>-->
                                <td class="lablewhite" align="center"><?php $remark=$u->getUserResumeRemark($user['id']); If(!empty($remark)){?> 
                                    <a href="#" class="classeditRemark" id="btneditRemark"  onclick="getRemark(<?php echo $user['id']; ?>);"><?php echo $remark[0]['remark']; ?></a>
                                <?php } else {?>
                                    <a href="#" class="classAddRemark"   id="btnaddRemark"  onclick="setUserId(<?php echo $user['id']; ?>);">Add Remark</a>
                                     <?php }?>
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
<div class="modal fade" id="modaladdRemark" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title headline" id="myModalLabel">Add Remark</h4>
                
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                <form role="form" id="addRemark"  class="classaddRemark" method="post" action="">
                    <div class="form-group">
                        <label for="inputName" name="resume_remark">Remark<span class="mandatory">* </span></label>

                        <textarea class="form-control"
                                  id="remark" name="remark"  required /></textarea>
                                  <input type="hidden" name="user_id" id="user_id">
                       
                    </div>


                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>

                        <input type="submit" value="SUBMIT" id="submitremark" name="submitremark" class="btn btn-primary submitBtn" >

            </div>
                    </form>
        </div>				
    </div>
</div>
</div>

</div>

<div class="clearfix"> </div>

<br/>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
