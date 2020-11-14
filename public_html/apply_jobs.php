<?php include_once ('includes/php_header.php');
if (empty($_SESSION['user_id'])) {
    header("Location:/login.php");
}//error_reporting(E_ALL);

//print_r($_POST);
$jobs = $u->addUserJobs($_POST);
//$jobs = $u->appliedJobs($_POST);
if($jobs['msg']=="suc")
{
	$sucess="You have sucessfully applied to this job";
}else
{
		$sucess="You have already applied to this job";

}
include_once ('includes/header.php');
?>
<div class="container">
    <div class="single">  
        <div class="col-md-9 single_right">
            <h6 class="title"><?php echo $sucess; ?></h6>
            <div class="but_list">
                <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Applied jobs</a></li>

                    </ul>
                    <div id="myTabContent" class="tab-content">

                        <?php
                        foreach ($jobs as $jb) {
                            foreach ($jb as $job) {
                                $date = $job['posted_on'];
                                $month = date('F', strtotime($date));
                                $date = date('d', strtotime($date));

                                echo'<input id="jobid" name="jobid" type="hidden" value=' . $job['id'] . '>
                                    <input id="userid" name="userid" type="hidden" value=' . $_SESSION['user_id'] . '><div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
		    <div class="tab_grid">
			    <div class="jobs-item with-thumb">
				    <div class="thumb"><a href=""><img src="images/a2.jpg" class="img-responsive" alt=""/></a></div>
				    <div class="jobs_right">
						<div class="date">' . $date . ' <span>' . $month . '</span></div>
						<div class="date_desc"><h6 class="title"><a href="">' . $job['job_name'] . '</a></h6>
						  <span class="meta">' . $job['location'] . '</span>
						</div>
						<div class="clearfix"> </div>
                      
						<p class="description">' . $job['description'] . ' </p>
                    </div>
					<div class="clearfix"> </div>
				</div>
			 </div>
			
			
			
			 
			
                    </div> ';
                            }
                        }
                        ?>




                    </div>
                </div>
            
                </div>
            </div>
        </div>
    </div>
 <div class="clearfix"> </div>
   


<?php include_once ('includes/footer.php'); ?>
