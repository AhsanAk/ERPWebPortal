<?php
session_start();



      if(isset($_SESSION['name'])||isset($_COOKIE['name'])||isset($_SESSION['deo'])||isset($_COOKIE['deo'])){

          include_once 'checkData.php';

          if(isset($_POST['submitDeleteSub'])&&!empty($_POST['submitDeleteSub'])){

              include_once 'includes/connection.php';

            $id = (int) checkData($_POST['submitDeleteSub']);

              $query = mysqli_query($connection, "DELETE FROM subjects WHERE id = '$id'");
              if($query){
                  echo 'deleted';
              }

          }

          else if(isset($_POST['editSubjectCH'])&&!empty($_POST['editSubjectCH'])&&isset($_POST['editSubName'])&&!empty($_POST['editSubName'])&&isset($_POST['editSubCode'])&&!empty($_POST['editSubCode'])&&isset($_POST['editSubDepart'])&&!empty($_POST['editSubDepart'])&&isset($_POST['editSubSemester'])&&!empty($_POST['editSubSemester'])){

                include_once 'includes/connection.php';
                $id = (int) checkData($_POST['editSubId']);
                $subject = checkData($_POST['editSubName']);
                $course_code = checkData($_POST['editSubCode']);
                $depart = checkData($_POST['editSubDepart']);
                $semester = checkData($_POST['editSubSemester']);
                $subjectCH = checkData($_POST['editSubjectCH']);

                $query = mysqli_query($connection, "UPDATE subjects SET subject = '$subject', semester = '$semester', course_code = '$course_code', theory_ch = '$subjectCH', dept_id = '$depart' WHERE id = $id");
                if($query){
                    echo 'updated';
                }


            }


            else if(isset($_POST['subjectDepart'])&&!empty($_POST['subjectDepart'])&&isset($_POST['subjectSemester'])&&!empty($_POST['subjectSemester'])){


              include_once 'includes/connection.php';

              $subjectDepart = checkData($_POST['subjectDepart']);
              $subjectSemester = checkData($_POST['subjectSemester']);

              $queryShowSubject = mysqli_query($connection, "SELECT * FROM subjects WHERE dept_id = '$subjectDepart' AND semester = '$subjectSemester' ");

              if(!mysqli_num_rows($queryShowSubject) > 0){
                  echo "<p class='lead animated bounceInLeft text-danger'>No results found.<p>";
              }else{

                  echo "<table class='table table-responsive table-bordered animated bounceInLeft'>";
                  echo "<tr>";
                  echo "<th>Subject Name</th>";
                  echo "<th>Subject Code</th>";
                  echo "<th>Theory Credit Hours</th>";
                  echo "<th>Practical Credit Hours</th>";
                  echo "<th>Operations</th>";
                  echo "</tr>";


                  while($row = mysqli_fetch_assoc($queryShowSubject)){


                      echo "<tr class='trID_".$row['id']."'>";
                      echo "<td class='subject'>".$row['subject']."</td>";
                      echo "<td class='course_code'>".$row['course_code']."</td>";
                      echo "<td class='semester hidden'>".$row['semester']."</td>";
                      echo "<td class='theoryCH'>".$row['theory_ch']."</td>";
                      echo "<td class='practicalCH'>".$row['practical_ch']."</td>";
                      echo "<td class='dept_id hidden'>".$row['dept_id']."</td>";
                      echo "<td><button class='btn btn-success td_btnEdit' data-toggle='modal'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> Edit</button>
                    <button class='btn btn-danger td_btnDelete' data-toggle='modal' '> <i class='fa fa-times' aria-hidden='true'></i> Delete</button>
                         </td>";
                      echo "</tr>";

                  }
                  echo "</table>";
              }

          } else if(isset($_POST['subjectCH'])&&!empty($_POST['subjectCH'])&&isset($_POST['subjectName'])&&!empty($_POST['subjectName'])&&isset($_POST['subjectCode'])&&!empty($_POST['subjectCode'])&&isset($_POST['subjectDepartment'])&&!empty($_POST['subjectDepartment'])&&isset($_POST['subjectSemester'])&&!empty($_POST['subjectSemester'])){

              include_once 'includes/connection.php';

              $subName = checkData($_POST['subjectName']);
              $subCode = checkData($_POST['subjectCode']);
              $subDepartment = checkData($_POST['subjectDepartment']);
              $subSemester = checkData($_POST['subjectSemester']);
              $subCH = (int) checkData($_POST['subjectCH']);
              $subPracticalCH = (int) checkData($_POST['practicalCH']);


              $query = "
                                    SELECT
                            *
                        FROM
                            subjects
                        WHERE
                            dept_id = '$subDepartment'
                            AND course_code = '$subCode'
            ";

              $query_run = mysqli_query($connection, $query);

              if(mysqli_num_rows($query_run) > 0){
                  echo 'exists';
              } else{

                  $query = "INSERT INTO subjects (
                        dept_id, semester, subject,
                        course_code, theory_ch, practical_ch
                    )
                    VALUES
                        (
                            '$subDepartment','$subSemester',
                            '$subName', '$subCode', '$subCH', '$subPracticalCH'
                        )
              ";

                  $query_run = mysqli_query($connection, $query);
                  if($query_run){
                      echo 'inserted';
                  }

              }
          }




      }else{
          header('Location:index.php');
      }




mysqli_close($connection);
?>