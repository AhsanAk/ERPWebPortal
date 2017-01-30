<?php @session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/uni_icon.ico">

        <?php


        if(isset($_SESSION['student'])){
            echo '<title>STUDENT\'s PANEL</title>';
        }else if(isset($_SESSION['teacher'])){
            echo '<title>TEACHER\'s PANEL</title>';
        }else if(isset($_SESSION['name'])){
            echo '<title>ADMIN\'s PANEL</title>';
        }
        else if(isset($_SESSION['deo'])){
            echo '<title>DEO\'s PANEL</title>';
        }

        ?>



    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="dashboard.css">
    <link rel="stylesheet" href="font-awesome/animate.css">
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css">
    <script type="text/javascript" src="bootstrap-filestyle/src/bootstrap-filestyle.min.js"> </script>
    <link rel="stylesheet" href="jQuery/jquery-ui/jquery-ui.min.css">
    <script src="jQuery/jquery-ui/jquery-ui.min.js"></script>
    <!-- Custom styles for this template -->
    <link href="sb-admin-2.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="html5/html5shiv.min.js"></script>
    <script src="html5/respond.min.js"></script>
    <![endif]-->
</head>
