<?php
session_start();
/**
 * Created by PhpStorm.
 * User: AHSAN AK
 * Date: 11/17/2016
 * Time: 10:35 PM
 */


if(isset($_SESSION['name'])||isset($_COOKIE['name'])||isset($_SESSION['deo'])||isset($_COOKIE['deo'])) {

    include_once 'checkData.php';


        if (isset($_POST['depart_value']) && !empty($_POST['depart_value']) && isset($_POST['semester_value']) && !empty($_POST['semester_value'])) {

        include_once 'includes/connection.php';
        $depart_value = (int)checkData($_POST['depart_value']);
        $semester_value = checkData($_POST['semester_value']);


        $subjectQuery = "SELECT subject, course_code FROM subjects WHERE dept_id  = '$depart_value'  AND semester = '$semester_value' ";
        $subjectQueryRun = mysqli_query($connection, $subjectQuery);

        if (mysqli_num_rows($subjectQueryRun) > 0) {

            echo "<option value=''>Select Subject</option>";
            while ($row = mysqli_fetch_assoc($subjectQueryRun)) {

                $subject = $row['subject'];
                $subject_code = $row['course_code'];
                echo "<option value='$subject_code'>$subject</option>";

            }
        } else {
            echo "<option value=''>Select Subject</option>";
        }
    } else {
        echo "<option value=''>Select Subject</option>";
    }
}





mysqli_close($connection);


?>