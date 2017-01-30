<?php
session_start();
if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])) {
    include_once('includes/connection.php');

        if(isset($_POST['submitDeleteAssignment'])&&!empty($_POST['submitDeleteAssignment'])){
          $id = (int) checkData($_POST['submitDeleteAssignment']);

            $query = mysqli_query($connection, "DELETE FROM assignment WHERE id = '$id'");
            if($query){
                echo 'deleted';
            }

        } if(isset($_POST['updateAssignmentTitle'])&&!empty($_POST['updateAssignmentTitle'])&&isset($_POST['updateId'])&&!empty($_POST['updateId'])&&isset($_POST['updateAssignmentDeadline'])&&!empty($_POST['updateAssignmentDeadline'])&&isset($_POST['updateAssignmentSemester'])&&!empty($_POST['updateAssignmentSemester'])&&isset($_POST['updateAssignmentBatch'])&&!empty($_POST['updateAssignmentBatch'])&&isset($_POST['updateAssignmentDesp'])&&!empty($_POST['updateAssignmentDesp'])){


        $update_id=$_POST['updateId'];
        $title = $_POST['updateAssignmentTitle'];
        $deadline = $_POST['updateAssignmentDeadline'];
        $semester = $_POST['updateAssignmentSemester'];
        $batch = $_POST['updateAssignmentBatch'];
        $desp = $_POST['updateAssignmentDesp'];
        $depart = $_POST['depart_id'];

        $file_name = $_FILES['assignmentFileUpdate']['name'];
        $file_tmpName = $_FILES['assignmentFileUpdate']['tmp_name'];
        $file_type = $_FILES['assignmentFileUpdate']['type'];

        $file_type = explode('/', $file_type);
        $file_type = $file_type[1];
        $file_type = trim($file_type);

        $folder = "assignment/{$depart}/{$semester}/{$title}";
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $fileUpload = move_uploaded_file($file_tmpName, "$folder/" . $title . "." . $file_type);
        $uploaded = false;

        if ($fileUpload) {
            $uploaded = true;
        }



        $query = mysqli_query($connection, "update assignment set title='$title', deadline='$deadline', semester='$semester', dept_batch='$batch', description='$desp', assignment_file = '$title" . '.' . "$file_type' where id='$update_id'");

        if($query && $fileUpload == true){
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