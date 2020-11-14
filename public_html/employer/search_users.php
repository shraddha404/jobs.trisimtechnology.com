<?php session_start();error_reporting(0);
include_once $_SERVER['DOCUMENT_ROOT'] . '/../lib/User.class.php';
if (empty($_SESSION['user_id'])) {
    header('Location:/login.php');
}
$u = new User($_SESSION['user_id']);

if (isset($_POST['clear'])) {
    unset($_GET);
}

$users = $u->getUsersForEmployer($_GET);


$qualifications = $u->getQualifications();


include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<script>
    $(document).ready(function () {

        $("#experience_year").hide();
        $('#experience').change(function (e) {

            if ($("#experience option:selected").val() === 'yes')
            {
                $("#experience_year").show();
            } else if ($("#experience option:selected").val() === 'no')
            {
                $("#experience_year").hide();
            } else {
                $("#experience_year").hide();
            }
        });

    });

</script>
<div class="container">
    <br/><h2 align="center">Search Candidate</h2>
<?php if (!empty($_SESSION['succ'])) { ?><h4><?php
    echo $_SESSION['succ'];
    $_SESSION['succ'] = '';
    ?></h4><?php } ?>
    <div class="col-md-12">

        <form method="GET" action="" id="search_employer">
            <div id="search_wrapper1" >
                <div id="search_form" class="clearfix" >
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="phone">Select Fresher or Experience</label>
                            <select name="experience" id="experience" class="form-control">
                                <option value="">Select</option>
                                <option value="no" <?php if ($_GET['experience'] == 'fresher') echo 'selected=selected'; ?> >Fresher</option>
                                <option value="yes" <?php if ($_GET['experience'] == 'experience') echo 'selected=selected'; ?>>Experienced</option>                                             

                            </select>
                        </div>                       
                    </div>

                    <div class="row" id="experience_year">
                        <div class="form-group col-md-4">
                            <label for="phone">Experience Years<span class="mandatory">* </span></label>
                            <select name="experience_year" id="experience_year" class="form-control">
                                <option value="0">Select</option>
                                <option value="1-2" <?php if ($_GET['experience_year'] == '1-2') echo 'selected=selected'; ?>>1-2</option>
                                <option value="2-5" <?php if ($_GET['experience_year'] == '2-5') echo 'selected=selected'; ?>>2-5</option>
                                <option value="5-8" <?php if ($_GET['experience_year'] == '5-8') echo 'selected=selected'; ?>>5-8</option>
                                <option value="8-12" <?php if ($_GET['experience_year'] == '8-12') echo 'selected=selected'; ?>>8-12</option>
                                <option value="12-15" <?php if ($_GET['experience_year'] == '12-15') echo 'selected=selected'; ?>>12-15</option>
                                <option value="15-20" <?php if ($_GET['experience_year'] == '15-20') echo 'selected=selected'; ?>>15-20</option>
                                <option value="above 20" <?php if ($_GET['experience_year'] == 'above 20') echo 'selected=selected'; ?>>above 20</option>                 

                            </select>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="phone" style="margin-bottom: 15px;">Qualification</label>
                            <select name="education" id="education" class="form-control">
                                <option value="">Select</option>
<?php foreach ($qualifications as $qualification) { ?>
                                    <option value="<?php echo $qualification['id']; ?>" <?php if ($_GET['education'] == $qualification['id']) echo 'selected=selected'; ?> ><?php echo $qualification['qualification']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                    <div class="row">
						
						 <!---div class="form-group col-md-4" >
                              <select name="job_type" id="job_type" class="form-control" >
                                 <option value="">Select Domain</option>
                                 <option value="Mechanical">Mechanical</option>
                                 <option value="Electronics">Electronics</option>
                                 <option value="Electrical">Electrical</option>
                                 <option value="Aerospace">Aerospace</option>
                                 <option value="Chemical">Chemical</option>
                              </select>
                           </div-->
                        <!--div class="form-group col-md-4">
                            <label for="phone" style="margin-bottom: 15px;">Domain</label>
                            <select name="job_type" id="job_type" class="form-control">
                                <option value="">Choose categories</option>
                                <?php
                               if( empty($_GET['job_type']))
                               {
                                         $u->getJobTypeDropDown();
                               }
                               else{
                                         $u->getJobTypeDropDownSelected($_GET['job_type']); 
                               }
                                ?>
                            </select>
                        </div-->
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="phone" style="margin-bottom: 15px;">Candidate Location</label>
                            <input type="text" value="<?php echo $_GET['location_search']; ?>" name="location_search" id="location_search" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="btn2 btn-2 btn2-1b"><input type="submit" name="submit" value="Search"></label>
                        <label class="btn2 btn-2 btn2-1b"><input type="submit" name="clear" value="Clear Search" id="clear" ></label></label>

                    </div>

                </div>
            </div>
        </form><br/>
        <!-- use the filter_reset : '.reset' option or include data-filter="" using the filter button demo code to reset the filters -->
         <!-- use the filter_reset : '.reset' option or include data-filter="" using the filter button demo code to reset the filters -->
        <div class="bootstrap_buttons">
           <button type="button" class="reset btn btn-primary" data-column="0" data-filter=""><i class="bootstrap-icon-white glyphicon glyphicon-refresh"></i> Reset filters</button>           
           
          <a href="export_user_details.php" class="btn btn-primary" role="button"><i class="bootstrap-icon-white glyphicon glyphicon-export"></i> <span>Export</span></a>
        </div>
        <br>
        <br>




        <div id="demo"><table id="waypointsTable"> <!-- bootstrap classes added by the uitheme widget -->
                <thead>
                    <tr style="background-color:#337ab7 !important;">
                        <th class="text-center">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Contact</th>
                        <th class="text-center">Location</th>
                        <th class="text-center">Experience</th>
                        <th class="text-center">PhD Score</th>
                        <th class="text-center">Master's CGPA</th>
                        <!--th class="text-center">GATE Domain/Score/AIR/YOP</th-->
                        <th class="text-center whitetheadtr" >Domain</th>
                        <th class="text-center">Bachelor's CGPA</th>
                        <th class="text-center">12th Marks/Percentage/PCM Group Marks</th>
                        <th class="text-center">10th Marks</th>                       
                        <th class="text-center"data-filter="false">Action</th>
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
        ?>
                            <tr>
                                <td align="center"><?php echo $user['id']; ?></td>
                                <td align="center"><?php echo $user['first_name'] . " " . $user['middle_name'] . " " . $user['last_name']; ?>
                                </td>

                                <td align="center"><a href="#" data-toggle="tooltip"  title="<?php echo $user['email']; ?>">
                                        <img align="center" id ="email" src="/images/email.png" width="20"></a>
                                </td>
                                <td align="center"><a href="#" data-toggle="tooltip"  title="<?php echo $user['mobile_number']; ?>">
                                        <img align="center" id ="email" src="/images/phone-outline.png" width="20"></a>
                                </td>
                            <!--<td><div class="hide_show"><img id ="email" src="/images/phone-outline.png" width="20" class="image">
                                    <div class="text_email"><?php echo $user['mobile_number']; ?></div>
                                </div></td>-->



                                <td align="center"><?php echo $user['city']; ?></td>

                                <td align="center"><?php echo $user['work_exp_years'] . " Year"; ?></td>
                                <td align="center"><?php
                    if ($user['phd_marks']) {
                        echo $user['phd_marks'];
                    } else {
                        echo "--";
                    }
        ?></td>
                                <td align="center"><?php
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
                                <td align="center"><?php
                                    if ($user['gate_domain']) {
                                        echo  $user['gate_domain'];
                                    }
                                    if ($user['gate_yop']) {
                                        echo $user['gate_marks'] . " " .  $user['gate_air'] . " " .$user['gate_yop'];
                                    } else {
                                        echo "--";
                                    }
                                    ?></td>
                                <td align="center"><?php
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
                                        echo $user['xii_marks'];
                                    }
                                    if ($user['xii_percentage']) {
                                        echo $user['xii_percentage'];
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
                                    ?></td>
                                <td align="center">
                                    <a href="/employer/view_job_seeker.php?id=<?php echo $user['id']; ?>" rel="#overlay" title="View"><img src="/images/download.png" width="17"></a> 

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
