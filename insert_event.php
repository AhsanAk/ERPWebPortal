<?php
session_start();
if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])) {
    include_once('includes/connection.php');
    include_once 'checkData.php';

    if(isset($_POST['eventTime'])&&!empty($_POST['eventTime'])&&isset($_POST['eventTitle'])&&!empty($_POST['eventTitle'])&&isset($_POST['eventPlace'])&&!empty($_POST['eventPlace'])&&isset($_POST['eventDate'])&&!empty($_POST['eventDate'])&&isset($_POST['eventFor'])&&!empty($_POST['eventFor'])&&isset($_POST['eventDesp'])&&!empty($_POST['eventDesp'])){


    $event_title = $_POST['eventTitle'];
    $event_place = $_POST['eventPlace'];
    $event_date = $_POST['eventDate'];
    $event_for = $_POST['eventFor'];
    $event_time = $_POST['eventTime'];
    $event_description = $_POST['eventDesp'];

    $query = mysqli_query($connection, "INSERT INTO events (event_title, event_place, event_for, event_date, event_time, event_description) VALUES ('$event_title', '$event_place', '$event_for', '$event_date', '$event_time', '$event_description')");

        if($query){
            echo 'inserted';
        }


    }


}else{
    header('Location:index.php');
}



mysqli_close($connection);


?>