<?php
session_start();
if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])) {
    include_once('includes/connection.php');

        if(isset($_POST['submitDeleteEvent'])&&!empty($_POST['submitDeleteEvent'])){
          $id = (int) checkData($_POST['submitDeleteEvent']);

            $query = mysqli_query($connection, "DELETE FROM events WHERE id = '$id'");
            if($query){
                echo 'deleted';
            }

        } if(isset($_POST['updateEventTime'])&&!empty($_POST['updateEventTime'])&&isset($_POST['updateId'])&&!empty($_POST['updateId'])&&isset($_POST['updateEventTitle'])&&!empty($_POST['updateEventTitle'])&&isset($_POST['updateEventPlace'])&&!empty($_POST['updateEventPlace'])&&isset($_POST['updateEventDate'])&&!empty($_POST['updateEventDate'])&&isset($_POST['updateEventFor'])&&!empty($_POST['updateEventFor'])&&isset($_POST['updateEventDesp'])&&!empty($_POST['updateEventDesp'])){



       $update_id=$_POST['updateId'];
        $event_title = $_POST['updateEventTitle'];
        $event_place = $_POST['updateEventPlace'];
        $event_date = $_POST['updateEventDate'];
        $event_for = $_POST['updateEventFor'];
        $event_time = $_POST['updateEventTime'];
        $event_description = $_POST['updateEventDesp'];

        $query = mysqli_query($connection, "update events set event_title='$event_title', event_place='$event_place', event_for='$event_for', event_date='$event_date', event_time='$event_time', event_description='$event_description' where id='$update_id'");

        if($query){
            echo 'updated';
        }


    }


}else{
    header('Location:index.php');
}

function checkData($data){

    global $connection;

    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripcslashes($data);
    $data = mysqli_real_escape_string($connection, $data);
    return $data;
}


mysqli_close($connection);


?>