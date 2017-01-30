<?php
session_start();
/**
 * Created by PhpStorm.
 * User: AHSAN AK
 * Date: 11/22/2016
 * Time: 12:16 AM
 */
if(isset($_SESSION['name'])||isset($_COOKIE['name'])||isset($_SESSION['deo'])||isset($_COOKIE['deo'])||isset($_SESSION['student'])||isset($_COOKIE['student'])) {

    include_once('includes/connection.php');
    include_once 'checkData.php';

    if(isset($_POST['semesterResultAtt'])&&isset($_POST['sicAttId'])&&!empty($_POST['semesterResultAtt'])&&!empty($_POST['sicAttId'])) {

        $student_id = checkData($_POST['sicAttId']);
        $semester = checkData($_POST['semesterResultAtt']);

        $getStudentData = mysqli_query($connection, "SELECT * FROM students WHERE id = '$student_id'");
        $studentData = mysqli_fetch_assoc($getStudentData);


        $attCheckAtt = mysqli_query($connection, "SELECT * FROM student_attendance WHERE student_rollNo = '".$studentData['roll_no'] ."' AND semester = '$semester' AND dept_id = '" . $studentData['dept_id'] . "' ");
        if (mysqli_num_rows($attCheckAtt) > 0) {


            $attQuery = mysqli_query($connection, "SELECT subject, course_code FROM subjects WHERE semester = '$semester' AND dept_id = '" . $studentData['dept_id'] . "' ");

            if (mysqli_num_rows($attQuery) > 0) {


                echo "<table class='table table-responsive table-bordered animated bounceInLeft'>";
                echo "<tr>";
                echo "<th>Subject Name</th>";
                echo "<th>Total Classes</th>";
                echo "<th>Total Classes Attended</th>";
                echo "</tr>";

                $countClassesTotal = 0;
                $countAttTotal = 0;
                while ($attQueryResult = mysqli_fetch_assoc($attQuery)) {

                    $allClassesQuery = mysqli_query($connection, "SELECT DISTINCT date, timing FROM student_attendance WHERE dept_id = '" . $studentData['dept_id'] . "'  AND subject_code = '" . $attQueryResult['course_code'] . "'  AND semester = '$semester'");
                    $allClassesPresentQuery = mysqli_query($connection, "SELECT  date, timing FROM student_attendance WHERE dept_id = '" . $studentData['dept_id'] . "'  AND subject_code = '" . $attQueryResult['course_code'] . "'  AND semester = '$semester' AND  student_rollNo = '" . $studentData['roll_no'] . "' AND subject_attendance = 'present'");

                    $allClasses = mysqli_num_rows($allClassesQuery);
                    $allPresentClasses = mysqli_num_rows($allClassesPresentQuery);

                    $countClassesTotal = $countClassesTotal + $allClasses;
                    $countAttTotal = $countAttTotal + $allPresentClasses;

                    echo "<tr>";
                    echo "<td>" . $attQueryResult['subject'] . "</td>";
                    echo "<td>" . $allClasses . "</td>";
                    echo "<td>" . $allPresentClasses . "</td>";
                    echo "</tr>";

                }


                $percentage = ($countAttTotal / $countClassesTotal) * 100;
                $percentage = number_format($percentage, 2);
                $percentage .= '%';

                echo "<tr>";
                echo "<td><b>Total:</b></td>";
                echo "<td><b>$countClassesTotal</b></td>";
                echo "<td><b>$countAttTotal</b></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th colspan='3'><h3>Percentage: $percentage</h3></th>";
                echo "</tr>";


            } else {
                echo "<p class='animated flash btn btn-danger'>No subjects found.</p>";
            }

        }else{
            echo "<p class='animated flash btn btn-danger'>No results found.</p>";
        }
    }

}else{
    header('Location: index.php');
}




mysqli_close($connection);





?>