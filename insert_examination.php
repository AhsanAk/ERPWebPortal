<?php
session_start();

if(isset($_POST['updateExam'])&&!empty($_POST['updateExam'])&&isset($_POST['updateExamIds'])&&!empty($_POST['updateExamIds'])){
        include_once 'includes/connection.php';
        include_once 'checkData.php';

        $updateExamValues = $_POST['updateExam'];
        $updateExamIds = $_POST['updateExamIds'];

        $query = '';
        $i = 0;


        foreach($updateExamValues as $updateValue){


                if($i % 2 ==0){
       $query .= "UPDATE student_examresult SET
                       subject_theoryMarks = '$updateValue',";
                }else{
            $query .= " subject_practicalMarks = '$updateValue'
                       WHERE id = '$updateExamIds[$i]';";
}
            $i++;
        }

        $query = substr($query, 0, -1);

        $queryRun = mysqli_multi_query($connection, $query);
        if($queryRun){
                echo 'updated';
        }

}


else if(isset($_POST['semesterResultShow'])&&!empty($_POST['semesterResultShow'])&&isset($_POST['idResultShow'])){

    include_once 'includes/connection.php';
    include_once 'checkData.php';

    $idResult= checkData($_POST['idResultShow']);
    $semesterResult= checkData($_POST['semesterResultShow']);

    $query_result = mysqli_query($connection, "select * from students where id='".$idResult."'");
    $departResult = mysqli_fetch_assoc($query_result);

    $dept =$departResult['dept_id'];
    $batch =$departResult['dept_id'];
    $rollNo =$departResult['roll_no'];

    $queryCheck = mysqli_query($connection, "SELECT * FROM student_examresult WHERE roll_no = '$rollNo' AND dept_id = '$dept' AND semester = '$semesterResult' ");
    if(!mysqli_num_rows($queryCheck) > 0){
        echo "<p class='animated flash btn btn-danger'>No results found.</p>";
    }else{

        echo "<form method='post' action='insert_examination.php' id='updateExamForm'>";

        echo "<table class='table table-responsive table-bordered animated bounceInLeft'>";
        echo "<tr>";
        echo "<th>Subject Name</th>";
        echo "<th>Total Theory Marks</th>";
        echo "<th>Obtained Theory Marks</th>";
        echo "<th>Total Practical Marks</th>";
        echo "<th>Obtained Practical Marks</th>";
        echo "</tr>";


        $totalMarksTheory = 0;
        $obtainMarksTheory = 0;
        $totalMarksPractical = 0;
        $obtainMarksPractical = 0;

         while($row = mysqli_fetch_assoc($queryCheck)){


        $getSubjs = mysqli_query($connection, "SELECT subject, theory_ch, practical_ch, course_code FROM subjects WHERE course_code = '".$row['subject_code']."' AND dept_id = '$dept' ");
        $getSubj = mysqli_fetch_assoc($getSubjs);

            echo "<tr>";
            echo "<td>";
            echo $getSubj['subject'] . ' (' . $getSubj['course_code'] . ')';
            echo "</td>";
            if($getSubj['theory_ch']=='3'){
                $totalMarksTheory = $totalMarksTheory + 100;
                $obtainMarksTheory = $obtainMarksTheory + $row['subject_theoryMarks'];
                echo "<input type='hidden' name='updateExamIds[]' value='".$row['id']."'>";
                echo "<td>100</td>";
                echo "<td>";
                echo "<input name='updateExam[]' type='number' class='form-control text-center' min='0' max='100' value='".$row['subject_theoryMarks']."' disabled required />";
                echo "</td>";
            }
            else{
                echo "<input type='hidden' name='updateExamIds[]' value='".$row['id']."'>";
                echo "<td>50</td>";
                $totalMarksTheory = $totalMarksTheory + 50;
                $obtainMarksTheory = $obtainMarksTheory + $row['subject_theoryMarks'];
                echo "<td>";
                 echo "<input name='updateExam[]' type='number' class='form-control text-center' min='0' max='50' value='".$row['subject_theoryMarks']."' disabled required />";
                echo "</td>";

            }
            if($getSubj['practical_ch']=='1'){
                 echo "<input type='hidden' name='updateExamIds[]' value='".$row['id']."'>";
                $totalMarksPractical = $totalMarksPractical + 50;
                $obtainMarksPractical = $obtainMarksPractical + $row['subject_practicalMarks'];
                echo "<td>50</td>";
                echo "<td>";
                 echo "<input name='updateExam[]' type='number' class='form-control text-center' min='0' max='50' value='".$row['subject_practicalMarks']."' disabled required />";
                echo "</td>";
            }
            else{
                   echo "<input type='hidden' name='updateExamIds[]' value='".$row['id']."'>";
                   echo "<input name='updateExam[]' type='hidden'  value='0'>";

                echo "<td>-</td>";
                echo "<td>-</td>";
            }
    }?>
    </tr>
    <?php $percentage = ($obtainMarksTheory + $obtainMarksPractical) / ($totalMarksTheory+$totalMarksPractical) * 100;
          $percentage = number_format($percentage, 2);
    ?>
   <tr>
   <td  class=""><b>Total Marks:</b></td>
    <td  class=""><b><?php echo $totalMarksTheory; ?></b></td>
    <td><b><?php echo $obtainMarksTheory; ?></b></td>
    <td><b><?php echo $totalMarksPractical; ?></b></td>
    <td><b><?php echo $obtainMarksPractical; ?></b></td>
    </tr>
    <tr>
    <td colspan="5"><h3><b>Percentage: </b><?php echo $percentage. "%"; ?></h3></td>
    </tr>
       </table>

      <?php if(isset($_SESSION['name'])||isset($_SESSION['deo'])){ ?>

       <input type="button" value="UPDATE" class="btn btn-primary" id="updateExamBtn">
       <input type="submit" value="Update results!" class="btn btn-info animated bounceInLeft" id="updateExamGoBtn">
       <span id="updateExamOutput"></span>
       <?php } ?>
    </form>
<?php

    }

} else if(isset($_POST['theoryMarks'])||isset($_POST['practicalMarks'])&&isset($_POST['studentRollNo'])&&isset($_POST['studentBatch'])&&isset($_POST['studentDept'])){

    (isset($_POST['theoryMarks']) ? $theoryMarks = $_POST['theoryMarks'] : '');
    (isset($_POST['theorySubj']) ? $theorySub = $_POST['theorySubj'] : '');
    (isset($_POST['practicalMarks']) ? $practicalMarks = $_POST['practicalMarks'] : '');
    (isset($_POST['practicalSubj']) ? $practicalSubj = $_POST['practicalSubj'] : '');

    include_once 'includes/connection.php';
    include_once 'checkData.php';

    $rollNo = checkData($_POST['studentRollNo']);
    $batch = checkData($_POST['studentBatch']);
    $dept = checkData($_POST['studentDept']);
    $semester = checkData($_POST['studentSemester']);

    $queryCheck = mysqli_query($connection, "SELECT * FROM student_examresult WHERE roll_no = '$rollNo' AND semester = '$semester' AND dept_id = '$dept'");
    if(mysqli_num_rows($queryCheck) > 0){
        echo "<span class='animated btn btn-danger bounceInLeft text-danger'>Results have already been inserted for this semester.</span>";
    }else{


    if(!empty($theoryMarks)&&!empty($theorySub)){


        $query = 'INSERT INTO student_examResult ';
        $query .= '(roll_no, dept_batch, dept_id, semester, subject_code, subject_theoryMarks, subject_practicalMarks) VALUES';

        $i = 0;
        foreach($theoryMarks as $theoryMark){

             (isset($practicalMarks[$i]) ? $practicalMark = $practicalMarks[$i] : $practicalMark = '') ;

            $query .= " ('$rollNo', '$batch', '$dept', $semester, '$theorySub[$i]', '$theoryMark', '$practicalMark'),";
            $i++;
        }

        $query = substr($query, 0, -1);


        $queryRun = mysqli_query($connection, $query);
            if($queryRun){
                echo 'inserted';
            }
    }




    }
}

else if(isset($_POST['idResult'])&&!empty($_POST['idResult'])&&isset($_POST['semesterResult'])&&!empty($_POST['semesterResult'])){
    include_once 'includes/connection.php';
      include_once 'checkData.php';


    $idResult= checkData($_POST['idResult']);
    $semesterResult= checkData($_POST['semesterResult']);

    $query_result = mysqli_query($connection, "select * from students where id='".$idResult."'");
    $departResult = mysqli_fetch_assoc($query_result);


        $queryCheck = mysqli_query($connection, "SELECT * FROM student_examresult WHERE roll_no = '".$departResult['roll_no']."' AND dept_id = '".$departResult['dept_id']."' AND semester = '$semesterResult' ");
    if(mysqli_num_rows($queryCheck) > 0){
        echo "<p class='animated flash btn btn-danger'>Results have already been submitted for this semester.</p>";
    }else{

    $deptResult=$departResult['dept_id'];

    $query_subject = mysqli_query($connection, "select * from subjects where dept_id='".$deptResult."' AND semester= '".$semesterResult."'");
    if(!mysqli_num_rows($query_subject) > 0){
        echo "noResult";
    }else {?>
    <form action="<?php echo htmlspecialchars('insert_examination.php'); ?>" method="post" id="insertExamAgain">

        

        <?php echo "<table class='table table-responsive table-bordered animated bounceInLeft'>";
        echo "<tr>";
        echo "<th>Subject Name</th>";
        echo "<th>Total Theory Marks</th>";
        echo "<th>Obtained Theory Marks</th>";
        echo "<th>Total Practical Marks</th>";
        echo "<th>Obtained Practical Marks</th>";
        echo "</tr>";


        while($row = mysqli_fetch_assoc($query_subject)){

            echo "<tr>";
            echo "<td>";
            echo $row['subject'] . ' (' . $row['course_code'] . ')';
            echo "</td>";
            if($row['theory_ch']=='3'){
                echo "<td>100</td>";
                echo "<td>";
                echo "<input type='number' class='form-control' name='theoryMarks[]' id='theoryMarks'  min='0' max='100' required>";
                echo "<input type='hidden' name='theorySubj[]' value='".$row['course_code']."'>";
                echo "</td>";

            }
            else{
                echo "<td>50</td>";
                echo "<td>";
                echo "<input type='number' class='form-control' name='theoryMarks[]' id='theoryMarks'  min='0' max='50' required>";
                echo "<input type='hidden' name='theorySubj[]' value='".$row['course_code']."'>";
                echo "</td>";

            }
            if($row['practical_ch']=='1'){
                echo "<td>50</td>";
                echo "<td>";
                echo "<input type='number' class='form-control' name='practicalMarks[]' id='practicalMarks' min='0' max='50' required>";
                echo "<input type='hidden' name='practicalSubj[]' value='".$row['course_code']."'>";
                echo "</td>";
            }
            else{
                echo "<input type='hidden' name='practicalMarks[]' value='0' required>";
                echo "<td>-</td>";
                echo "<td>-</td>";
            }
    }?>
       </table>
        <div class="col-sm-12">
            <button class="btn btn-primary" name="submitMarks" id="submitMarks">Submit</button>
            <span id="sicExamOutput"></span>
        </div>
        <?php  $queryStudentQuery = mysqli_query($connection, "SELECT * FROM students WHERE id = '$idResult'");
               $queryStudent = mysqli_fetch_assoc($queryStudentQuery);
        ?>

        <input type="hidden" name="studentRollNo" value="<?php echo $queryStudent['roll_no']; ?>">
        <input type="hidden" name="studentBatch" value="<?php echo $queryStudent['dept_batch']; ?>">
        <input type="hidden" name="studentDept" value="<?php echo $queryStudent['dept_id']; ?>">
        <input type="hidden" name="studentSemester" value="<?php echo $semesterResult; ?>">
    </form><?php

    }


}
}
?>