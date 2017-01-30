<?php


$url = $_SERVER['REQUEST_URI'];
$url = explode('/', $url);
$url = $url[count($url) - 1];
$url = explode('?', $url);
$url = $url[0];
//$url=str_replace("/project14Oct/","",$_SERVER['REQUEST_URI']);


        if(isset($_SESSION['student'])){
            $student_id = $_SESSION['student'];
        }elseif(isset($_COOKIE['student'])){
            $student_id = $_COOKIE['student'];
        }

        $studentQuery = "SELECT * FROM students WHERE id = '$student_id'";
        $studentQueryRun = mysqli_query($connection, $studentQuery);
        $student = mysqli_fetch_assoc($studentQueryRun);


?>
<script src="moment.js"></script>

<script>

    $(document).ready(function(){
        DateAndTime();

        setInterval(function(){
            DateAndTime();

        }, 1000);

        function DateAndTime(){
            document.getElementById('showDateAndTime').innerHTML = moment().format('MMM Do, h:mm:ss a');
        }
    });

</script>


<nav class="navbar navbar-inverse navbar-fixed-top customNavbar"> <!--navigation bar-->
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="dashboard.php"><i class="fa fa-university" aria-hidden="true"></i> DAWOOD ERP PORTAL</a>
            <span class="navbar-brand" style="color: black" id="showDateAndTime"></span>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="<?php echo ($url == 'dashboard.php' ? 'active' : ''); ?>"><a href="dashboard.php">Dashboard</a></li>
                <li class="<?php echo ($url == 'sic.php' ? 'active' : '' || $url == 'sicprofile.php' ? 'active' : ''); ?>"><a href="sicprofile.php">SIC</a></li>
                <li class="<?php echo ($url == 'library.php' ? 'active' : ''); ?>"><a href="library.php">Library</a></li>
                <li class="<?php echo ($url == 'feedbackList_pm.php' || $url == 'checkRead_pm.php' || $url == 'checkNew_pm.php' | $url == 'feedback.php' ? 'active' : ''); ?>"><a href="feedback.php">Feedback</a></li>
                <li class="<?php echo ($url == 'change_password.php' ? 'active' : ''); ?>"><a href="change_password.php">Change Password</a></li>
                <li class="<?php echo ($url == 'logout.php' ? 'active' : ''); ?>"><a href="logout.php">Logout </a></li>
            </ul>

        </div>
    </div>
</nav><!--end of navigation bar-->

<div class="col-sm-12  main">
    <h1 class="page-header">Welcome <?php echo $student['name']; ?><small> (<?php echo $student['roll_no']; ?>)</small></h1>

    <div class="row placeholders">
        <div class="col-xs-6 col-sm-2 col-lg-1 placeholder">
            <a href="dashboard.php">
                <?php if ($url=="dashboard.php"){ ?>

                <i class="fa fa-home fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                <i class="fa fa-home fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>Home</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-6 col-sm-2 col-lg-1 placeholder">
            <a href="sicprofile.php">
                <?php if ($url=="sic.php" || $url =='sicprofile.php' ){ ?>
                <i class="fa fa-users fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                <i class="fa fa-users fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>SIC</h4>
                <span class="text-muted"></span></a>
        </div>

        <div class="col-xs-1 col-sm-1 col-lg-1 placeholder">
            <a href="lectures.php">
                <?php if ($url=="lectures.php"){ ?>
                    <i class="fa fa-file-o fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-file-o fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>

                <h4>Lectures</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-1 col-sm-1 col-lg-1 placeholder">
            <a href="assignment.php">
                <?php if ($url=="assignment.php"){ ?>
                    <i class="fa fa-file-pdf-o fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-file-pdf-o fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>

                <h4>Assignment</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-6 col-sm-2 col-lg-1 placeholder">
            <a href="library.php">
                <?php if ($url=="library.php"){ ?>
                <i class="fa fa-book fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                <i class="fa fa-book fa-5x dashboardIcons" aria-hidden="true"></i><?php } ?>
                <h4>Library</h4>
                <span class="text-muted"></span></a>
        </div>



        <div class="col-xs-1 col-sm-1 col-lg-1 placeholder">
            <a href="events.php">
                <?php if ($url=="events.php"){ ?>
                    <i class="fa fa-clock-o fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-clock-o fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>

                <h4>Events</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-1 col-sm-1 col-lg-1 placeholder">
            <a href="feedback.php">
                <?php if ($url=="feedback.php" || $url == 'feedbackList_pm.php' || $url == 'checkRead_pm.php' || $url == 'checkNew_pm.php'){ ?>
                    <i class="fa fa-envelope fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-envelope fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>

                <h4>Feedback</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-6 col-sm-2 col-lg-1 placeholder">
            <a href="about.php">
                <?php if ($url=="about.php"){ ?>
                    <i class="fa fa-info-circle fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-info-circle fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>About</h4>
                <span class="text-muted"></span></a>
        </div>
    </div>
    </div>