<?php

include_once 'includes/connection.php';
include_once 'checkData.php';

if(isset($_POST['updatePresentRollNo'])||(isset($_POST['updateAbsentRollNos']))&&isset($_POST['updateAllRollNos'])&&isset($_POST['updateTiming'])&&isset($_POST['updateBatch'])&&isset($_POST['updateSemester'])&&isset($_POST['updateDepartment'])&&isset($_POST['updateSubject'])&&isset($_POST['updateDate'])){

    (isset($_POST['updatePresentRollNo']) ? $presentRollNos = $_POST['updatePresentRollNo'] : $presentRollNos = '');
    (isset($_POST['updateAbsentRollNos']) ? $absentRollNos = $_POST['updateAbsentRollNos'] : $absentRollNos = '');

    $allRollNos = checkData($_POST['updateAllRollNos']);
    $timing = checkData($_POST['updateTiming']);
    $batch = checkData($_POST['updateBatch']);
    $semester = checkData($_POST['updateSemester']);
    $department = checkData($_POST['updateDepartment']);
    $subject = checkData($_POST['updateSubject']);
    $date = checkData($_POST['updateDate']);


    $attendance = array();
    $query = '';


    for($i=0; $i < $allRollNos; $i++) {

        if (isset($presentRollNos[$i]) ? $presentRoll = checkData($presentRollNos[$i]) : $presentRoll = '') ;
        if (isset($absentRollNos[$i]) ? $absentRoll = checkData($absentRollNos[$i]) : $absentRoll = '') ;


        if (!empty($presentRoll)) {
            $present = explode('_', $presentRoll);
            $attendance[] = $present;
        }

        if (!empty($absentRoll)) {
            $absent = explode('_', $absentRoll);
            $attendance[] = $absent;
        }

        $query .= "
                        UPDATE student_attendance SET

                                    dept_id = '$department', dept_batch = '$batch', semester = '$semester', subject_code = '$subject',
                                    subject_attendance = '".$attendance[$i][1]."', student_rollNo = '".$attendance[$i][0]."',
                                    timing = '$timing', date = '$date' WHERE id = '".$attendance[$i][2]."';

            ";

    }

    $query = substr($query, 0, -1);

    $queryRunFinal = mysqli_multi_query($connection, $query);

    if($queryRunFinal){
        echo 'updated';
    }






} elseif(isset($_POST['presentRollNo'])||(isset($_POST['absentRollNos']))&&isset($_POST['allRollNos'])&&isset($_POST['timing'])&&isset($_POST['batch'])&&isset($_POST['semester'])&&isset($_POST['department'])&&isset($_POST['subject'])&&isset($_POST['date'])){

        (isset($_POST['presentRollNo']) ? $presentRollNos = $_POST['presentRollNo'] : $presentRollNos = '');
        (isset($_POST['absentRollNos']) ? $absentRollNos = $_POST['absentRollNos'] : $absentRollNos = '');

        $allRollNos = checkData($_POST['allRollNos']);
        $timing = checkData($_POST['timing']);
        $batch = checkData($_POST['batch']);
        $semester = checkData($_POST['semester']);
        $department = checkData($_POST['department']);
        $subject = checkData($_POST['subject']);
        $date = checkData($_POST['date']);


        $attendance = array();
        $query = '';


        for($i=0; $i < $allRollNos; $i++){

            if(isset($presentRollNos[$i]) ? $presentRoll = checkData($presentRollNos[$i]) :  $presentRoll = '');
            if(isset($absentRollNos[$i]) ? $absentRoll = checkData($absentRollNos[$i]) :  $absentRoll = '');

            if(!empty($presentRoll)){

                $present = explode('_', $presentRoll);
                $attendance[] = $present;
            }

            if(!empty($absentRoll)){
                $absent = explode('_', $absentRoll);
                $attendance[] = $absent;
            }



            $query .= "
                        INSERT INTO student_attendance (
                                    dept_id, dept_batch, semester, subject_code,
                                    subject_attendance, student_rollNo,
                                    timing, date
                                )
                         VALUES
                                (
                                    '$department', '$batch', '$semester',
                                    '$subject', '".$attendance[$i][1]."', '".$attendance[$i][0]."',
                                    '$timing', '$date'
                                );
            ";
        }

        $queryRunFinal = mysqli_multi_query($connection, $query);
        $query = substr($query, 0, -1);


        if($queryRunFinal){
            echo 'inserted';
        }



    }else{
    header('Location:index.php');
}







mysqli_close($connection);


?>