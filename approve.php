<?php
include_once('includes/connection.php');
if (isset($_GET['id'])){
    $id=$_GET['id'];
    echo "amar";
    $query = mysqli_query($connection, "UPDATE students set activated=1 where id='$id'");
    header('location: waiting.php');
}
