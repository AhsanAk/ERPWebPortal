<?php

function checkData($data){

    global $connection;

    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripcslashes($data);
    $data = mysqli_real_escape_string($connection, $data);
    return $data;
}
?>