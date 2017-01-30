<?php

$url = $_SERVER['REQUEST_URI'];
$url = explode('/', $url);
$url = $url[count($url) - 1];
$url = explode('?', $url);
$url = $url[0];

//$url=str_replace("/project14Oct/","",$_SERVER['REQUEST_URI']);
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
            <a class="navbar-brand" href="dashboard.php"><i class="fa fa-university" aria-hidden="true"></i> DAWOOD ERP PORTAL </a>
            <span class="navbar-brand" style="color: black" id="showDateAndTime"></span>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="<?php echo ($url == 'dashboard.php' ? 'active' : ''); ?>"><a href="dashboard.php">Dashboard</a></li>
                <li class="<?php echo ($url == 'sic.php' ? 'active' : '' || $url == 'sicprofile.php' ? 'active' : '' || $url == 'waiting.php' ? 'active' : ''); ?>"><a href="sic.php">SIC</a></li>
                <li class="<?php echo ($url == 'attendance.php' ? 'active' : ''); ?>"><a href="attendance.php">Attendance</a></li>
                <li class="<?php echo ($url == 'subjects.php' ? 'active' : '' || $url == 'subjects.php' ? 'active' : ''); ?>"><a href="subjects.php">Subjects</a></li>
                <li class="<?php echo ($url == 'teachers.php' ? 'active' : '' || $url == 'teacherprofile.php' ? 'active' : ''); ?>"><a href="teachers.php">Teachers</a></li>
                <li class="<?php echo ($url == 'library.php' ? 'active' : ''); ?>"><a href="library.php">Library</a></li>
                <li class="<?php echo ($url == 'feedbackList_pm.php' || $url == 'checkRead_pm.php' || $url == 'checkNew_pm.php' | $url == 'feedback.php' ? 'active' : ''); ?>"><a href="feedback.php">Feedback</a></li>
                <li class="<?php echo ($url == 'change_password.php' ? 'active' : ''); ?>"><a href="change_password.php">Change Password</a></li>
                <li class="<?php echo ($url == 'logout.php' ? 'active' : ''); ?>"><a href="logout.php">Logout </a></li>
            </ul>

        </div>
    </div>
</nav><!--end of navigation bar-->

<div class="col-sm-12  main">
    <h1 class="page-header">ADMIN PANEL</h1>

    <div class="row placeholders">
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-1 placeholder">
            <a href="dashboard.php">
                <?php if ($url=="dashboard.php"){ ?>

                <i class="fa fa-home fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                <i class="fa fa-home fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>HOME</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-1 placeholder">
            <a href="sic.php">
                <?php if ($url=="sic.php" || $url =='sicprofile.php' ){ ?>
                <i class="fa fa-users fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                <i class="fa fa-users fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>SIC</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-12 col-sm-1 col-md-3 col-lg-1 placeholder">
            <a href="attendance.php">
                <?php if ($url=="attendance.php"){ ?>

                    <i class="fa fa-check-square fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-check-square fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>Attendance</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-12 col-sm-1  col-lg-1 placeholder">
            <a href="subjects.php">
                <?php if ($url=="subjects.php"){ ?>

                    <i class="glyphicon glyphicon-book dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="glyphicon glyphicon-book dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>Subjects</h4>
                <span class="text-muted"></span></a>
        </div>

        <div class="col-xs-12 col-sm-1 col-lg-1 placeholder">
            <a href="teachers.php">
                <?php if ($url=="teachers.php" || $url == 'teacherprofile.php'){ ?>
                <i class="fa fa-user fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                <i class="fa fa-user fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>Teachers</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-12 col-sm-1 col-lg-1 placeholder">
            <a href="examination.php">
                <?php if ($url=="examination.php" || $url == 'examination.php'){ ?>
                    <i class="fa fa-graduation-cap fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-graduation-cap fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>Examination</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-12 col-sm-1 col-lg-1 placeholder">
            <a href="library.php">
                <?php if ($url=="library.php"){ ?>
                <i class="fa fa-book fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                <i class="fa fa-book fa-5x dashboardIcons" aria-hidden="true"></i><?php } ?>
                <h4>Library</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-12 col-sm-1 col-lg-1 placeholder">
            <a href="events.php">
                <?php if ($url=="events.php" || $url == 'events.php'){ ?>
                    <i class="fa fa-clock-o fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-clock-o fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>Events</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-12 col-sm-1 col-lg-1 placeholder">
            <a href="feedback.php">
                <?php if ($url=="feedback.php" || $url == 'feedbackList_pm.php' || $url == 'checkRead_pm.php' || $url == 'checkNew_pm.php'){ ?>
                    <i class="fa fa-envelope fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-envelope fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>

                <h4>Feedback</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-12 col-sm-1 col-lg-1 placeholder">
            <a href="about.php">
                <i class="fa fa-info-circle fa-5x dashboardIcons" aria-hidden="true"></i>
                <h4>About</h4>
                <span class="text-muted"></span></a>
        </div>
    </div>
    </div>

