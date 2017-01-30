<?php


include_once("includes/connection.php");


$roll_no = $_POST['rollno'];


$query = "SELECT * FROM students WHERE roll_no = '$roll_no'";
$query_run = mysqli_query($connection, $query);

if(mysqli_num_rows($query_run) > 0){
    echo 'error';
}



?>