<?php
session_start();



    if(isset($_SESSION['name'])||isset($_COOKIE['name'])||isset($_SESSION['deo'])||isset($_COOKIE['deo'])){



        include_once('includes/connection.php');
        include_once 'checkData.php';


        if(isset($_POST['viewDepartmentAll'])&&isset($_POST['viewBatchAll'])&&isset($_POST['viewSemesterAll'])){

            $viewDepart = (int) checkData($_POST['viewDepartmentAll']);
            $viewBatch = (int) checkData($_POST['viewBatchAll']);
            $viewSemester = (int) checkData($_POST['viewSemesterAll']);

            $allClassesCheck = mysqli_query($connection, "SELECT DISTINCT date, timing FROM student_attendance WHERE dept_id = '$viewDepart'  AND semester = '$viewSemester' AND dept_batch = '$viewBatch'");
            if(mysqli_num_rows($allClassesCheck) != 0) {

            echo "<table class='table table-responsive table-bordered animated bounceInLeft'>";
            echo "<tr>";

            $subjectQuery = mysqli_query($connection, "SELECT * FROM subjects WHERE dept_id = '$viewDepart' AND semester = '$viewSemester'");

            $subjects = array();

            echo "<th>Roll No</th>";
            while($row = mysqli_fetch_assoc($subjectQuery)){
            echo "<th>".$row['subject']."</th>";
            $subjects[] = $row['course_code'];
            }
                echo "<th>Overall %</th>";
                  echo "</tr>";

            $studentQuery = mysqli_query($connection, "SELECT * FROM students WHERE dept_id = '$viewDepart'  AND dept_batch = '$viewBatch' ");



                while ($row = mysqli_fetch_assoc($studentQuery)) {


                    echo "<tr>";
                    echo "<td><a href='sicprofile.php?id=". $row['id'] . "' target='_blank'>". $row['roll_no'] . "</a></td>";

                    foreach ($subjects as $subject) {

                        $allClassesPresentQuery = mysqli_query($connection, "SELECT  date, timing FROM student_attendance WHERE dept_id = '$viewDepart'  AND subject_code = '$subject'  AND semester = '$viewSemester' AND  student_rollNo = '" . $row['roll_no'] . "' AND subject_attendance = 'present'");
                        $allClassesQuery = mysqli_query($connection, "SELECT DISTINCT date, timing FROM student_attendance WHERE dept_id = '$viewDepart'  AND subject_code = '$subject'  AND semester = '$viewSemester'");

                        $allClassesPresent = mysqli_num_rows($allClassesPresentQuery);
                        $allClasses = mysqli_num_rows($allClassesQuery);

                        $totalClassesPresentQuery = mysqli_query($connection, "SELECT  date, timing FROM student_attendance WHERE dept_id = '$viewDepart' AND semester = '$viewSemester' AND  student_rollNo = '" . $row['roll_no'] . "' AND subject_attendance = 'present'");
                        $totalClassesQuery = mysqli_query($connection, "SELECT DISTINCT date, timing FROM student_attendance WHERE dept_id = '$viewDepart'  AND semester = '$viewSemester'");


                        if($allClasses != 0){

                        $result = $allClassesPresent *100 / $allClasses;

                        $result = number_format($result, 2);
                        $result .= '%';

                        echo "<td>$result &nbsp;(" .$allClassesPresent." / ".$allClasses. ")</td>";
                        }else{
                            echo "<td>Attendance not inserted yet.</td>";
                        }
                    }

                    $totalPresentClasses = mysqli_num_rows($totalClassesPresentQuery) . " ";
                    $totalClasses = mysqli_num_rows($totalClassesQuery) ."<br>";
                    $grandTotal = $totalPresentClasses * 100 / $totalClasses;
                    $grandTotal = number_format($grandTotal, 2);
                    $grandTotal .= '%';
                    echo "<td><b>$grandTotal</b></td>";

                    echo "</tr>";

                }
            }else{
                echo "<p class='btn btn-danger animated flash'>No results found.</p>";
            }
        }



       else if(isset($_POST['date'])&&!empty($_POST['date'])&&isset($_POST['timing'])&&!empty($_POST['timing'])&&isset($_POST['department'])&&!empty($_POST['department'])&&isset($_POST['batch'])&&!empty($_POST['batch'])&&isset($_POST['semester'])&&!empty($_POST['semester'])&&isset($_POST['subject'])&&!empty($_POST['subject'])) {

            $date = checkData($_POST['date']);
            $timing = checkData($_POST['timing']);
            $batch = (int) checkData($_POST['batch']);
            $department = (int) checkData($_POST['department']);
            $semester = checkData($_POST['semester']);
            $subject = checkData($_POST['subject']);

            $timeSelect  = strtotime($_POST['date']);
            $currentTime =  time();

            if($timeSelect > $currentTime){
                echo  '<button class="btn btn-danger animated flash">Future date is not allowed.</button>';
            } else{


            $queryCheck = mysqli_query($connection, "SELECT * FROM student_attendance
                                            WHERE dept_id = '$department'
                                            AND   dept_batch = '$batch'
                                            AND   semester = '$semester'
                                            AND   timing = '$timing'
                                            AND   date = '$date'
                                            ORDER BY student_rollNo ASC
");

            $numRows = mysqli_num_rows($queryCheck);
            if($numRows > 0){

                $result = '<br> <button class="btn btn-success allPresent btnUpdatePresent" disabled>All Present</button>';
                $result .= '<button class="btn btn-danger allAbsent btnUpdateAbsent" disabled>All Absent</button> <br>';
                while($row = mysqli_fetch_assoc($queryCheck)){

                    if($row['subject_attendance'] == 'present'){
                        $result .= "<button row-id='".$row['id']."' class='btn btn-default student_present insertButton animated flip ' disabled>".$row['student_rollNo']."</button>";
                    }else{
                        $result .= "<button row-id='".$row['id']."' class='btn btn-default student_absent insertButton animated flip ' disabled>".$row['student_rollNo']."</button>";
                    }

                }
                if ($timeSelect >= ($currentTime - 604800)) {
                    $result .= '<br><button class="btn btn-primary btnUpdate">UPDATE ATTENDANCE!</button>';

                }
                else{
                $result .= '<br><br><button class="btn btn-danger animated flash">Update is allowed for previous 6 days only.</button>';
                }
                echo $result;
            }else{
                echo 'noResult';
            }
            }

        }else if(isset($_POST['insertDate'])&&!empty($_POST['insertDate'])&&isset($_POST['insertTiming'])&&!empty($_POST['insertTiming'])&&isset($_POST['insertDepartment'])&&!empty($_POST['insertDepartment'])&&isset($_POST['insertBatch'])&&!empty($_POST['insertBatch'])&&isset($_POST['insertSemester'])&&!empty($_POST['insertSemester'])&&isset($_POST['insertSubject'])&&!empty($_POST['insertSubject'])) {

            $date = checkData($_POST['insertDate']);
            $timing = checkData($_POST['insertTiming']);
            $batch = (int)checkData($_POST['insertBatch']);
            $department = (int)checkData($_POST['insertDepartment']);
            $semester = checkData($_POST['insertSemester']);
            $subject = checkData($_POST['insertSubject']);

            $timeSelect = strtotime($_POST['insertDate']);
            $currentTime = time();

            if ($timeSelect > $currentTime) {
                echo '<button class="btn btn-danger animated flash">Future date is not allowed.</button>';

            } else if ($timeSelect <= ($currentTime - 604800)) {
                echo '<button class="btn btn-danger animated flash">Insertion is allowed for previous 6 days only.</button>';
            } else {


                $queryCheck = mysqli_query($connection, "SELECT * FROM student_attendance
                                            WHERE dept_id = '$department'
                                            AND   dept_batch = '$batch'
                                            AND   semester = '$semester'
                                            AND   timing = '$timing'
                                            AND   date = '$date'
");

                if (mysqli_num_rows($queryCheck) > 0) {
                    echo 'alreadyInserted';
                } else {

                    $query = "SELECT * FROM students WHERE dept_id = '$department' and dept_batch = '$batch'";

                    $queryRun = mysqli_query($connection, $query);
                    $numRows = mysqli_num_rows($queryRun);

                    if ($numRows > 0) {

                        $result = '<p><b>Total Results found: ' . $numRows . '</b></p>';
                        $result .= '<button class="btn btn-success allPresent">All Present</button>';
                        $result .= '<button class="btn btn-danger allAbsent">All Absent</button> <br>';


                        while ($row = mysqli_fetch_assoc($queryRun)) {

                            $result .= "<button class='btn btn-default insertButton animated flip'>" . $row['roll_no'] . "</button>";


                        }
                        echo $result;
                    } else {
                        echo '<h2 class="text-danger animated flash">No results.</h2>';
                    }
                }
            }
        }
    }


mysqli_close($connection);



?>