<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/index.php" style="font-family: futura-pt;color:#fff;
    font-weight: 400;
    font-style: normal;
    font-size: 34px;
    line-height: 1em;
    letter-spacing: .01em;
    text-transform: uppercase;"><!--img src="/images/logo.png" alt=""/-->TRISIM Technologies</a>
        </div>
        <!--/.navbar-header-->
        <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1" style="height: 1px;color:#fff;">
            <ul class="nav navbar-nav" style="float: right;">


                <!--<li><a href="../index.php">Home</a></li>-->

                <?php if ($_SESSION['user_type'] == 'Admin') { ?>
					<li><a href="/admin/dashboard.php">Dashboard</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Jobs<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/admin/manage_jobs.php">Manage Jobs</a></li>
                            <li><a href="/admin/add_jobs.php">Add Job</a></li>
                        </ul>
                    </li>
                <?php } ?>


                <li><?php if (!empty($_SESSION['user_id'])) { ?><?php if ($_SESSION['user_type'] == 'User') { ?><a href="/my_profile.php">My Profile</a><?php }
                } ?></li>
                
                <li><?php if (!empty($_SESSION['user_id'])) { ?><?php if ($_SESSION['user_type'] == 'User') { ?><a href="/jobs.php">Jobs</a><?php }
                } ?></li>
                <li><?php if (!empty($_SESSION['user_id'])) { ?><?php if ($_SESSION['user_type'] == 'Employer') { ?><a href="/employer/search_users.php">Search Candidate</a><?php }
                } ?></li>
                <li><?php if (!empty($_SESSION['user_id'])) { ?><?php if ($_SESSION['user_type'] == 'Employer') { ?><a href="/employer/employer_profile.php">My Profile</a><?php }
                } ?></li>
               <?php if ($_SESSION['user_type'] == 'Employer') { ?><li><a href="/admin/add_jobs.php">Add Job</a></li>    <?php } ?>
                <li><?php if (empty($_SESSION['user_id'])) { ?> <li><a href="../contact_us.php">Contact Us</a></li><?php } ?></li>

<?php if (empty($_SESSION['user_id'])) { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign up<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/employers_register.php">Employer</a></li>
                            <li><a href="/register.php">Candidate</a></li>
                        </ul>
                    </li>	
<?php } ?>

                <li><?php if (empty($_SESSION['user_id'])) { ?><a href="/login.php">Login</a><?php } else { ?><a class="nav-link" href="/logout.php">Logout</a><?php } ?></li>
            </ul>
        </div>
        <div class="clearfix"> </div>
    </div>
    <!--/.navbar-collapse-->
</nav>
