<?php
session_start();
if(isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])) {
    include_once('includes/connection.php');
    include_once 'checkData.php';


    if(isset($_POST['assignmentDepart'])&&!empty($_POST['assignmentDepart'])&&isset($_POST['assignmentTitle'])&&!empty($_POST['assignmentTitle'])&&isset($_POST['assignmentSubject'])&&!empty($_POST['assignmentSubject'])&&isset($_POST['assignmentSemester'])&&!empty($_POST['assignmentSemester'])&&isset($_POST['assignmentDeadline'])&&!empty($_POST['assignmentDeadline'])&&isset($_POST['assignmentBatch'])&&!empty($_POST['assignmentBatch'])&&isset($_POST['assignmentDesp'])&&!empty($_POST['assignmentDesp'])){

        $depart = checkData($_POST['assignmentDepart']);
        $title = checkData($_POST['assignmentTitle']);
        $subject = checkData($_POST['assignmentSubject']);
        $deadline = checkData($_POST['assignmentDeadline']);
        $semester = checkData($_POST['assignmentSemester']);
        $batch = checkData($_POST['assignmentBatch']);
        $desp = checkData($_POST['assignmentDesp']);

        $file_name = $_FILES['assignmentFile']['name'];
        $file_tmpName = $_FILES['assignmentFile']['tmp_name'];
        $file_type = $_FILES['assignmentFile']['type'];



        $file_type = explode('/', $file_type);
        $file_type = $file_type[1];
        $file_type = trim($file_type);

        $folder = "lectures/{$depart}/{$semester}/{$title}";
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $fileUpload = move_uploaded_file($file_tmpName, "$folder/" . $title . "." . $file_type);
        $uploaded = false;

        if ($fileUpload) {
            $uploaded = true;
        }


        $query = mysqli_query($connection, "INSERT INTO lectures (title, dept_id, dept_batch, semester, date, subject, description, lecture_file) VALUES ('$title', '$depart', '$batch', '$semester', '$deadline', '$subject', '$desp', '$title" . '.' . "$file_type' )");

        if ($query && $fileUpload == true) {
            echo 'inserted';
        }


    }


}
else{
    header('Location:index.php');
}


mysqli_close($connection);

?>