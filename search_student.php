<?php

if(isset($_POST['value'])){
include_once('includes/connection.php');



    $search = $_POST['value'];

    if(!empty($search)) {

        $query = "SELECT * FROM students WHERE roll_no LIKE '$search'";
        $query_run = mysqli_query($connection, $query);
        if (mysqli_num_rows($query_run) > 0) {
            echo 'has_rollno';
        }
    }
}
?>