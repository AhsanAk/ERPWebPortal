<?php


include_once("includes/connection.php");


$emp_id = $_POST['emp_id'];


    $query = "SELECT * FROM teachers WHERE emp_id = '$emp_id'";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_num_rows($query_run) > 0){
        echo 'error';
    }



?>