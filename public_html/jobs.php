<?php include_once ('includes/php_header.php');
error_reporting(1);
if (empty($_SESSION['user_id'])) {
    header("Location:/login.php");
}
if (isset($_GET['pageno'])) {
    $page_no = $_GET['pageno'];
} else {
    $page_no = 1;
}

$keyword=$_POST['keyword'];
$no_of_records_per_page = 10;
$offset = ($page_no - 1) * $no_of_records_per_page;
if(!empty($_POST['keyword']) || !empty($_POST['location'])){
 $location = $u->getuniquelocation($_POST) ;
  $designation = $u->getuniquedesignation($_POST) ;
$total_pages = $u->getJobsSearch_pagination_pages($no_of_records_per_page,$_POST);
$page_data = $u->getJobsSearch_pagination_records($no_of_records_per_page, $offset,$_POST);
}else{
 $location = $u->getuniquelocation() ;
  $designation = $u->getuniquedesignation() ;
$total_pages = $u->job_pagination_pages($no_of_records_per_page);
$page_data = $u->job_pagination_records($no_of_records_per_page, $offset);
}

$root = $_SERVER['DOCUMENT_ROOT'];
chmod($root . "/poststored.txt", 0777);
//print_r($page_data);
$jobs = $u->getJobs();
//print_r($page_data);
include_once ('includes/header.php');
?>

<div class="container">
    <div class="single">  
        <div class="col-md-9 single_right">
            <div class="but_list">
                <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Available jobs</a></li>

                    </ul>
                    <div id="myTabContent" class="tab-content">

                        <?php
                        if (empty($page_data)) {
                            echo 'Sorry no data found';
                        }
                        //if (empty($_POST)) {
							$i=1;
                            foreach ($page_data as $job) {
                                $date = $job['posted_on'];
                                $month = date('F', strtotime($date));
                                $date = date('d', strtotime($date));

								$explode=explode("-",$job['posted_on']);  
								$year= $explode[0];                               
								 if (strlen($job['description']) > 180) {
                                    $less_description = substr($job['description'], 0, 180); 
                                    $function_name="myFunction".$i."();";                                   
                                    $less_description = "<p class='description' id='less_desc' variable='".$i."'>".$less_description ." <a href='/user_jobs.php?job_name=". $job['job_name'] ."& location=".$job['location'] . "& role=".$job['designation'] . "'  class='read-more' onClick='".$function_name."'>Read More</a></p><p class='description' id='more_desc' variable='".$i."'>" . $job['description'] . "</p>";
                                    
                                } else {
                                    //$less_description = $job['description'];
                                    $less_description='<p class="description">' . $job['description'] . '</p>';
                                    
                                }
                                $i++;    $userdetails = $u->getUserDetails($job['posted_by']);
                                 $pid= $userdetails[0]['profile_photo'];
                                $id= $userdetails[0]['id'] ;
                              if($userdetails[0]['profile_photo']!=" ") { $img="<img src='../uploads/photos/".$id."/".$pid."' width='100px' height='100px'>";}
                               else {$img="<img src='images/noimages.jpeg' width='100px' height='100px'>"; }
                                echo'<form role="form" id="jobapply"  class="jobapply" method="post" action="apply_jobs.php" enctype="multipart/form-data"><input id="jobid" name="jobid" type="hidden" value=' . $job['id'] . '>
                                    <input id="hideid" name="hideid" type="hidden" value=' . $i . '>
                                    <input id="userid" name="userid" type="hidden" value=' . $_SESSION['user_id'] . '><div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
										<div class="tab_grid">
											<div class="jobs-item with-thumb">
												<div class="thumb"><a href="">'.$img.'</a></div>
												<div class="jobs_right">
													<div class="date">' . $date . ' <span>' . $month. '</span><span>' . $year. '</span></div>
													<div class="date_desc"><h6 class="title"><a href="">' . $job['job_name'] . '</a></h6>
													  <span class="meta">' . $job['location'] . '</span>
													</div>
													<div class="clearfix"> </div>
												   <ul class="top-btns">
														<li><div class="login-btn"><input type="submit" class="fa fa-plus toggle" value="Apply"></div></li>
														
													</ul>'.$less_description.'
												</div>
												<div class="clearfix"> </div>
											</div>
										 </div>
		
                    </div> </form>';
                            }
                        //}
                        ?>




                    </div>
                </div>
            </div>


            <ul class="pagination jobs_pagination">              
                <li><a href="?pageno=1">First <span class="sr-only">(current)</span></a></li>
                <li class='<?php if ($page_no <= 1) echo 'disabled' ?>'><a href="<?php
                        if ($page_no <= 1) {
                            echo "#";
                        } else {
                            echo '?pageno=' . ($page_no - 1);
                        }
                        ?>">Prev</a></li>
                <li class='<?php if ($page_no >= $total_pages) echo 'disabled' ?>'><a href="<?php
                    if ($page_no >= $total_pages) {
                        echo "#";
                    } else {
                        echo '?pageno=' . ($page_no + 1);
                    }
                    ?>">Next</a></li>
                <li><a href="?pageno=<?php echo $total_pages ?>">Last</a></li>

            </ul>


        </div>

        <div class="col-md-3">
            <form role="form" id="jobsearch"  class="jobsearch" method="post" action="user_jobs.php" enctype="multipart/form-data">
                <div class="widget_search">
                    <h5 class="widget-title">Search</h5>
                    <div class="widget-content">
                        <span>I'm looking for a ...</span>
                        <select class="form-control jb_1" name='job_name' id='job_name'>
                            <option value="">Select Job Title</option>
<?php
foreach ($jobs as $job) {
    echo '<option value="' . $job['job_name'] . '">' . $job['job_name'] . '</option>';
}
?>		
                        </select>
                        <span>in</span>
                        <select class="form-control jb_1" name='location' id='location'>
                             <option value="">Select Location</option>
                            <?php
                            foreach ($location as $loc) {
                                echo '<option value="' . $loc['location'] . '">' . $loc['location'] . '</option>';
                            }
                            ?>		
                        </select>
                        <select class="form-control jb_1" name='role' id='role'>
                            <option value="">Select Designation</option>
                            <?php
                            foreach ($designation as $desg) {
                                echo '<option value="' . $desg['designation'] . '">' . $desg['designation'] . '</option>';
                            }
                            ?>		
                        </select>


                        <input type="submit" class="btn btn-default" value="Search">
                    </div>
                </div>
            </form>



        </div>
        <div class="clearfix"> </div>
    </div>
</div>
<script src="/js/jquery.min.js"></script>
<script>
$(document).ready(function() {
$("p#more_desc").hide();
//alert($("p#more_desc").attr("id"));
//var count=$("#hideid").val();

});
/*
function myFunction1()
    {
         alert("hi");
          if ($('p').attr('variable') === '1')
          {
         $(this).hide();
          $(this).$("#more_desc").show();
      }
         //('#more_desc').show();
    }
    */
</script>

<?php include_once ('includes/footer.php'); ?>
