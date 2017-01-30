<?php
/**
 * Created by PhpStorm.
 * User: AHSAN AK
 * Date: 10/18/2016
 * Time: 10:49 PM
 */

$url = $_SERVER['REQUEST_URI'];
$url = explode('/', $url);
$url = $url[count($url) - 1];
$url = explode('?', $url);
$url = $url[0];
//$url=str_replace("/project14Oct/","",$_SERVER['REQUEST_URI']);


include_once('includes/connection.php');

if(isset($_SESSION['teacher'])){
    $teacher_id = $_SESSION['teacher'];
}elseif(isset($_COOKIE['teacher'])){
    $teacher_id = $_COOKIE['teacher'];
}

$teacherQuery = "SELECT * FROM teachers WHERE id = '$teacher_id'";
$teacherQueryRun = mysqli_query($connection, $teacherQuery);
$teacher = mysqli_fetch_assoc($teacherQueryRun);



?>

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
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="<?php echo ($url == 'dashboard.php' ? 'active' : ''); ?>"><a href="dashboard.php">Dashboard</a></li>
                <li class="<?php echo ($url == 'teachers.php' ? 'active' : '' || $url == 'teacherprofile.php' ? 'active' : ''); ?>"><a href="teacherprofile.php">My Profile</a></li>
                <li class="<?php echo ($url == 'lectures.php' ? 'active' : ''); ?>"><a href="lectures.php">Lectures</a></li>
                <li class="<?php echo ($url == 'assignment.php' ? 'active' : ''); ?>"><a href="assignment.php">Assignment</a></li>
                <li class="<?php echo ($url == 'events.php' ? 'active' : ''); ?>"><a href="events.php">Events</a></li>
                <li class="<?php echo ($url == 'about.php' ? 'active' : ''); ?>"><a href="about.php">About</a></li>
                <li class="<?php echo ($url == 'change_password.php' ? 'active' : ''); ?>"><a href="change_password.php">Change Password</a></li>
                <li class="<?php echo ($url == 'logout.php' ? 'active' : ''); ?>"><a href="logout.php">Logout </a></li>
            </ul>

        </div>
    </div>
</nav><!--end of navigation bar-->

<div class="col-sm-12  main">
    <h1 class="page-header">Welcome <?php echo $teacher['name']; ?><small> (Emp Id: <?php echo $teacher['emp_id']; ?>)</small></h1>

    <div class="row placeholders">
        <div class="col-xs-6 col-sm-2 placeholder">
            <a href="dashboard.php">
                <?php if ($url=="dashboard.php"){ ?>

                    <i class="fa fa-home fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-home fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>Home</h4>
                <span class="text-muted"></span></a>
        </div>

        <div class="col-xs-6 col-sm-2 placeholder">
            <a href="teacherprofile.php">
                <?php if ($url=="teachers.php" || $url == 'teacherprofile.php'){ ?>
                    <i class="fa fa-user fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-user fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>My Profile</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-6 col-sm-2 placeholder">
            <a href="lectures.php">
                <?php if ($url=="lectures.php" || $url == 'lectures.php'){ ?>
                    <i class="fa fa-file-o fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-file-o fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>Lectures</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-6 col-sm-2 placeholder">
            <a href="assignment.php">
                <?php if ($url=="assignment.php" || $url == 'assignment.php'){ ?>
                    <i class="fa fa-file-pdf-o fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-file-pdf-o fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>Assignments</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-6 col-sm-2 placeholder">
            <a href="events.php">
                <?php if ($url=="events.php" || $url == 'events.php'){ ?>
                    <i class="fa fa-clock-o fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-clock-o fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>Events</h4>
                <span class="text-muted"></span></a>
        </div>
        <div class="col-xs-6 col-sm-2 placeholder">
            <a href="about.php">
                <?php if ($url=="about.php" ){ ?>
                    <i class="fa fa-info-circle fa-5x dashboardIcons activeLink" aria-hidden="true"></i><?php }
                else {?>
                    <i class="fa fa-info-circle fa-5x dashboardIcons" aria-hidden="true"></i>
                <?php } ?>
                <h4>About</h4>
                <span class="text-muted"></span></a>
        </div>
    </div>
</div>