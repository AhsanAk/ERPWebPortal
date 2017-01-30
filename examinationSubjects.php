<?php
session_start();


    if(isset($_POST['examinationDepartment'])&&!empty($_POST['examinationDepartment'])&&isset($_POST['examinationSemester'])&&!empty($_POST['examinationSemester'])){
header('Location:index.php');
        include_once 'includes/connection.php';

        $examDepartment = checkData($_POST['examinationDepartment']);
        $examSemester = checkData($_POST['examinationSemester']);
        $examBatch = checkData($_POST['examinationBatch']);

        $queryShowSubject = mysqli_query($connection, "SELECT * FROM subjects WHERE dept_id = '$subjectDepart' AND semester = '$subjectSemester' ");

        if(!mysqli_num_rows($queryShowSubject) > 0){
            echo "<p class='lead animated bounceInLeft text-danger'>No results found.<p>";
        }else{

            echo "<table class='table table-responsive table-bordered animated bounceInLeft'>";
            echo "<tr>";
            echo "<th>Subject Name</th>";
            echo "<th>Subject Code</th>";
            echo "<th>Operations</th>";
            echo "</tr>";


            while($row = mysqli_fetch_assoc($queryShowSubject)){


                echo "<tr class='trID_".$row['id']."'>";
                echo "<td class='subject'>".$row['subject']."</td>";
                echo "<td class='course_code'>".$row['course_code']."</td>";
                echo "<td class='semester hidden'>".$row['semester']."</td>";
                echo "<td class='dept_id hidden'>".$row['dept_id']."</td>";
                echo "<td><button class='btn btn-success td_btnEdit' data-toggle='modal'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> Edit</button>
                    <button class='btn btn-danger td_btnDelete' data-toggle='modal' '> <i class='fa fa-times' aria-hidden='true'></i> Delete</button>
                         </td>";
                echo "</tr>";

            }
            echo "</table>";
        }
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