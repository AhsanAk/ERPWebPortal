<?php
session_start();


    if(isset($_POST['examinationDepart'])&&!empty($_POST['examinationDepart'])&&isset($_POST['examinationSemester'])&&!empty($_POST['examinationSemester'])&&isset($_POST['examinationBatch'])&&!empty($_POST['examinationBatch'])){
    include_once 'includes/connection.php';
    include_once 'checkData.php';

    $examinationDepart= checkData($_POST['examinationDepart']);
    $examinationSemester= checkData($_POST['examinationSemester']);
    $examinationBatch= checkData($_POST['examinationBatch']);

    $query_student = mysqli_query($connection, "select * from students where dept_id='".$examinationDepart."' AND dept_batch='".$examinationBatch."' AND activated='1'");

    $queryResultCheck= mysqli_query($connection, "select * from student_examresult where dept_id='".$examinationDepart."' AND semester='".$examinationSemester."' AND dept_batch='".$examinationBatch."'");
    if(!mysqli_num_rows($queryResultCheck) > 0){
    echo "NoUpdate";
    }
    else{
    if(!mysqli_num_rows($query_student) > 0){
        echo "noResult";
    }else {?>

        <?php
        echo "<table class='table table-responsive table-bordered animated bounceInLeft'>";
        echo "<tr>";
        echo "<th>Student Roll No.</th>";
        echo "<th>Total Marks</th>";
        echo "<th>Marks Obtained</th>";
        echo "<th>Percentage</th>";
        echo "<th>CGPA</th>";
        echo "<th>View</th>";
        echo "</tr>";

        echo "<tr>";
        while($rowStudents= mysqli_fetch_assoc($query_student)){
        $studentId= $rowStudents['id'];
        echo "<td>".$rowStudents['roll_no']."</td>";
        $query_totalMarks = mysqli_query($connection, "select * from subjects where dept_id ='".$examinationDepart."' AND semester ='".$examinationSemester."' ");

        $totalMarks=0;
        while($rowTotalMarks= mysqli_fetch_assoc($query_totalMarks)){

        if($rowTotalMarks['practical_ch']=='0'){
        if($rowTotalMarks['theory_ch']=='3'){
            $totalMarks= 100 + $totalMarks;
        }
        else{
            $totalMarks= 50 + $totalMarks;
        }}
        else{
            if($rowTotalMarks['theory_ch']=='3'){
                $totalMarks= 150 + $totalMarks;
            }
            else{
                $totalMarks= 100 + $totalMarks;
            }
        }}
        echo "<td>".$totalMarks."</td>";

        $query_result= mysqli_query($connection, "select * from student_examresult where roll_no='".$rowStudents['roll_no']."' AND dept_id ='".$examinationDepart."' AND semester ='".$examinationSemester."'");
        $obtainedMarks= 0;
         while($rowExam= mysqli_fetch_assoc($query_result)){
         $obtainedMarks= $rowExam['subject_theoryMarks'] + $obtainedMarks;
         $obtainedMarks= $rowExam['subject_practicalMarks'] + $obtainedMarks;
            }
            echo "<td>".$obtainedMarks."</td>";
            $percentage = $obtainedMarks*100/$totalMarks;
            echo "<td>".number_format((float)$percentage, 2, '.', '')."%</td>";
            echo "<td>-</td>";
            echo "<td><a href='sicprofile.php?id=$studentId&viewResult' target='_blank'><span class='fa fa-eye' aria-hidden='true'></span></a></td>";
            echo "</tr>";
        }?>
    </table><?php
}


}
}



mysqli_close($connection);
?>