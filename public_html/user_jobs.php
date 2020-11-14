<?php include_once ('includes/php_header.php');error_reporting(1);

if (empty($_SESSION['user_id'])) {
    header("Location:/login.php");
}
if (isset($_GET['job_name'])) {   
    if (isset($_GET['pageno'])) {
    $page_no = $_GET['pageno'];
} else {
    $page_no = 1;
}
    $no_of_records_per_page = 10;
$offset = (1 - 1) * $no_of_records_per_page;
    //$total_search_pages = $u->jobsearch_pagination_pages($no_of_records_per_page, $_GET);
$total_search_pages = "";
$search_page_data = $u->jobsearch_pagination_records($no_of_records_per_page, $offset, $_GET);
//print_r($search_page_data);
} 
else{
    
if (isset($_GET['pageno'])) {
    $page_no = $_GET['pageno'];
} else {
    $page_no = 1;
}


//print_r($_POST);
$root = $_SERVER['DOCUMENT_ROOT'];
$array = array("job_name" => $_POST['job_name'], "location" => $_POST['location'], "role" => $_POST['role']);
if ($_POST) {
//Encode the array into a JSON string.
    $encodedString = json_encode($array);
//Save the JSON string to a text file.
    file_put_contents($root . "/poststored.txt", $encodedString);
//Retrieve the data from our text file.
    $fileContents = file_get_contents($root . "/poststored.txt");
//Convert the JSON string back into an array.
    $decoded = json_decode($fileContents, true);
//The end result.
}
$fileContents = file_get_contents($root . "/poststored.txt");
$decoded = json_decode($fileContents, true);
chmod($root . "/poststored.txt", 0444);
//print_r($_POST);
//print_r($_GET);
//print_r($decoded);


$no_of_records_per_page = 10;
$offset = ($page_no - 1) * $no_of_records_per_page;
$jobs = $u->getJobs();
$total_search_pages = $u->jobsearch_pagination_pages($no_of_records_per_page, $decoded, $GET);
$search_page_data = $u->jobsearch_pagination_records($no_of_records_per_page, $offset, $decoded, $GET);}

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
                        /* if ($search_page_data && empty($page_data)) {
                          echo 'Sorry no data found';
                          } */

                        if (!empty($search_page_data)) {
                            foreach ($search_page_data as $job) {
                                $date = $job['posted_on'];
                                $month = date('F', strtotime($date));
                                $date = date('d', strtotime($date));

                                echo'<form role="form" id="jobapply"  class="jobapply" method="post" action="apply_jobs.php" enctype="multipart/form-data"><div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab"><input id="jobid" name="jobid" type="hidden" value=' . $job['id'] . '>
                                    <input id="userid" name="userid" type="hidden" value=' . $_SESSION['user_id'] . '>
		    <div class="tab_grid">
			    <div class="jobs-item with-thumb">
				    <div class="thumb"><a href=""><img src="images/a2.jpg" class="img-responsive" alt=""/></a></div>
				    <div class="jobs_right">
						<div class="date">' . $date . ' <span>' . $month . '</span></div>
						<div class="date_desc"><h6 class="title"><a href="">' . $job['job_name'] . '</a></h6>
						  <span class="meta">' . $job['location'] . '</span>
						</div>
						<div class="clearfix"> </div>
                        <ul class="top-btns">
							<li><div class="login-btn"><input type="submit" class="fa fa-plus toggle" value="Apply"></div></li>
						</ul>
						<p class="description">' . $job['description'] . '</p>
                    </div>
					<div class="clearfix"> </div>
				</div>
			 </div>
			
			
			
			 
			
                    </div></form>';
                            }
                        } else {
                            echo 'sorry no record found';
                        }
                        ?>




                    </div>
                </div>
            </div>

            <?php if ($total_search_pages) { ?>
                <ul class="pagination jobs_pagination">

                    <li><a href="?pageno=1">First <span class="sr-only">(current)</span></a></li>
                    <li class='<?php if ($page_no <= 1) echo 'disabled' ?>'><a href="<?php
                        if ($page_no <= 1) {
                            echo "#";
                        } else {
                            echo '?pageno=' . ($page_no - 1);
                        }
                        ?>">Prev</a></li>
                    <li class='<?php if ($page_no >= $total_search_pages) echo 'disabled' ?>'><a href="<?php
                        if ($page_no >= $total_search_pages) {
                            echo "#";
                        } else {
                            echo '?pageno=' . ($page_no + 1);
                        }
                        ?>">Next</a></li>
                    <li><a href="?pageno=<?php echo $total_search_pages ?>">Last</a></li>

                </ul><?php } else { ?>
                <ul class="pagination jobs_pagination">              
                    <!--<li><a href="?pageno=1">First <span class="sr-only">(current)</span></a></li>
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
                    <li><a href="?pageno=<?php echo $total_pages ?>">Last</a></li>-->

                </ul>
            <?php } ?>

        </div>


        <div class="clearfix"> </div>
    </div>
</div>

<?php include_once ('includes/footer.php'); ?>
