<?php session_start(); ?>


<?php

if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_SESSION['deo'])||isset($_COOKIE['deo'])){?> <!--if session create then create-->

  <?php include_once('header.php'); ?>
  <?php include_once('navbar.php'); ?>
  <?php include_once('includes/connection.php');

  if(isset($_SESSION['deo'])){
    $deo_id = $_SESSION['deo'];
  }elseif(isset($_COOKIE['deo'])){
    $deo_id = $_COOKIE['deo'];
  }

  if(isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
    $deoQuery = "SELECT * FROM admin WHERE name = '$deo_id'";
    $deoQueryRun = mysqli_query($connection, $deoQuery);
    $deo = mysqli_fetch_assoc($deoQueryRun);
  }?>

  <div class="container-fluid profileHeading">
    <div class="row">
      <div class="col-sm-12">
        <h2 class="sub-header" id="sub-header"><i class="fa fa-home"></i>Dashboard</h2>
      </div>
      <div class="col-sm-12">


        <div class="row">
          <div class="col-lg-3 col-md-6 animated bounceInDown" id="studentDiv">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-users fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <?php
                    if(isset($_SESSION['deo'])||isset($_COOKIE['deo'])){
                    $query_student = mysqli_query($connection, "SELECT * FROM students where dept_id='".$deo['dept_id']."'");
                    }else{
                    $query_student = mysqli_query($connection, "SELECT * FROM students");
                    }
                    ?>
                    <div class="huge student"></div>
                    <div>Total Students</div>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer" id="studentView">
                  <span class="pull-left" >View Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 animated bounceInDown" id="teacherDiv">
            <div class="panel panel-customGrey">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-user fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <?php $query_teachers = mysqli_query($connection, 'SELECT * FROM teachers');  ?>
                    <div class="huge teachers"></div>
                    <div>Total Teachers</div>
                  </div>
                </div>
              </div>
              <a href="javascript:;">
                <div class="panel-footer" id="teacherView">
                  <span class="pull-left">View Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 animated bounceInUp" id="booksDiv">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-book fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <?php $query_books = mysqli_query($connection, 'SELECT * FROM book');  ?>
                    <div class="huge books"></div>
                    <div>Total Books</div>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer" id="bookView">
                  <span class="pull-left">View Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
          <?php if(isset($_SESSION['deo'])){
          echo '<div class="col-lg-3 col-md-6 animated bounceInUp hidden" id="messageDiv">';
          }?>
          <div class="col-lg-3 col-md-6 animated bounceInUp" id="messageDiv">
            <div class="panel panel-customPurple">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">

                <?php       $req1 = mysqli_query($connection, 'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, students.id as userid, students.roll_no from pm as m1, pm as m2,students where ((m1.user1="' . $_SESSION['adminId'] . '" and m1.user1read="no" and students.id=m1.user2) or (m1.user2="' . $_SESSION['adminId'] . '" and m1.user2read="no" and students.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
                ?>


                    <div class="huge message"></div>
                    <div>Unread Messages </div>
                  </div>
                </div>
              </div>
              <a href="feedbackList_pm.php">
                <div class="panel-footer" id="messageView">
                  <span class="pull-left">View Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
        </div>
        <!-- /.row -->

        <?php
        for($i =1 ; $i <=9; $i++ ) {
          $query_depart = mysqli_query($connection, "SELECT dept_id FROM students WHERE dept_id = $i");
          $depart[] = mysqli_num_rows($query_depart);
        }
        ?>


        <div class="row">
          <div class="col-lg-12 col-md-12 col-xs-12 animated bounceInDown" id="studentStats">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-lg-2">
                    <i class="fa fa-users fa-5x"></i>
                  </div>
                  <div class="text-center">
                    <div class="col-lg-1">
                      <p><b>Computer</b></p>
                      <h3><?php echo $depart[0] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Chemical</b></p>
                      <h3><?php echo $depart[1] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Metallurgy</b></p>
                      <h3><?php echo $depart[2] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Industrial</b></p>
                      <h3><?php echo $depart[3] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Petroleum</b></p>
                      <h3><?php echo $depart[4] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Electronics</b></p>
                      <h3><?php echo $depart[5] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Energy</b></p>
                      <h3><?php echo $depart[6] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Telecom</b></p>
                      <h3><?php echo $depart[7] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Architecture</b></p>
                      <h3><?php echo $depart[8] ?></h3>
                    </div>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer" id="hideStudentStats">
                  <span class="pull-left" >Hide Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-left"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
        </div>


        <?php
        for($i =1 ; $i <=9; $i++ ) {
          $query_teacher = mysqli_query($connection, "SELECT dept_id FROM teachers WHERE dept_id = $i");
          $teacher[] = mysqli_num_rows($query_teacher);
        }
        ?>


        <div class="row">
          <div class="col-lg-12 col-md-12 col-xs-12 animated bounceInDown" id="teacherStats">
            <div class="panel panel-customGrey">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-lg-2">
                    <i class="fa fa-user fa-5x"></i>
                  </div>
                  <div class="text-center">
                    <div class="col-lg-1">
                      <p><b>Computer</b></p>
                      <h3><?php echo $teacher[0] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Chemial</b></p>
                      <h3><?php echo $teacher[1] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Metallurgy</b></p>
                      <h3><?php echo $teacher[2] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Industrial</b></p>
                      <h3><?php echo $teacher[3] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Petroleum</b></p>
                      <h3><?php echo $teacher[4] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Electronics</b></p>
                      <h3><?php echo $teacher[5] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Energy</b></p>
                      <h3><?php echo $teacher[6] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Telecom</b></p>
                      <h3><?php echo $teacher[7] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Architecture</b></p>
                      <h3><?php echo $teacher[8] ?></h3>
                    </div>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer" id="hideTeacherStats">
                  <span class="pull-left" >Hide Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-left"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
        </div>


        <?php
        for($i =1 ; $i <=9; $i++ ) {
          $query_book = mysqli_query($connection, "SELECT dept_id FROM book WHERE dept_id = $i");
          $book[] = mysqli_num_rows($query_book);
        }
        ?>


        <div class="row">
          <div class="col-lg-12 col-md-12 col-xs-12 animated bounceInDown" id="bookStats">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-lg-2">
                    <i class="fa fa-book fa-5x"></i>
                  </div>
                  <div class="text-center">
                    <div class="col-lg-1">
                      <p><b>Computer</b></p>
                      <h3><?php echo $book[0] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Chemical</b></p>
                      <h3><?php echo $book[1] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Metallurgy</b></p>
                      <h3><?php echo $book[2] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Industrial</b></p>
                      <h3><?php echo $book[3] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Petroleum</b></p>
                      <h3><?php echo $book[4] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Electronics</b></p>
                      <h3><?php echo $book[5] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Energy</b></p>
                      <h3><?php echo $book[6] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Telecom</b></p>
                      <h3><?php echo $book[7] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Architecture</b></p>
                      <h3><?php echo $book[8] ?></h3>
                    </div>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer" id="hideBookStats">
                  <span class="pull-left" >Hide Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-left"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
        </div>



        <div class="row">
          <div class="col-lg-12 col-md-12 col-xs-12 animated bounceInDown" id="messageStats">
            <div class="panel panel-customPurple">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-lg-2">
                    <i class="fa fa-comment fa-5x"></i>
                  </div>
                  <div class="text-center">
                    <div class="col-lg-5">
                      <p><b>Unread Message(s)</b></p>
                      <?php
                      $msgQueryUnread = mysqli_query($connection, "SELECT * FROM PM WHERE user2 = '".$_SESSION['adminId']."' AND user2read = 'no' ");
                      ?>
                      <h3><?php echo mysqli_num_rows($msgQueryUnread); ?></h3>
                    </div>
                    <div class="col-lg-5">
                      <p><b>Sent Message(s)</b></p>
                      <?php $msgQuerySent = mysqli_query($connection, "SELECT * FROM pm WHERE user1 = '".$_SESSION['adminId']."' AND user1read = 'yes' ");  ?>

                      <h3><?php echo mysqli_num_rows($msgQuerySent); ?></h3>
                    </div>

                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer" id="hideMessageStats">
                  <span class="pull-left" >Hide Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-left"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
        </div>

        <div id="spinner">
        </div>

        <script src="spinnerLoading.js"></script>
        <script>
          $(document).ready(function(){



            $('#studentView').click(function(){
                $('#teacherStats, #bookStats, #messageStats').hide('slow');
                $('#studentStats').show().removeClass('animated bounceOutLeft').addClass('animated bounceInLeft');
              scroll();
            });

            $('#hideStudentStats').click(function(){
                $('#studentStats').removeClass('animated bounceInLeft').addClass('animated bounceOutLeft').hide('slow');
              scroll();

            });

            $('#teacherView').click(function(){
              $('#studentStats, #bookStats, #messageStats').hide('slow');
              $('#teacherStats').show().removeClass('animated bounceOutLeft').addClass('animated bounceInLeft');
              scroll();


            });

            $('#hideTeacherStats').click(function(){
              $('#teacherStats').removeClass('animated bounceInLeft').addClass('animated bounceOutLeft').hide('slow');
              scroll();

            });


            $('#bookView').click(function(){
              $('#studentStats, #teacherStats, #messageStats').hide('slow');
              $('#bookStats').show().removeClass('animated bounceOutLeft').addClass('animated bounceInLeft');
              scroll();
            });

            $('#hideBookStats').click(function(){
              $('#bookStats').removeClass('animated bounceInLeft').addClass('animated bounceOutLeft').hide('slow');
              scroll();
            });


            $('#hideMessageStats').click(function(){
              $('#messageStats').removeClass('animated bounceInLeft').addClass('animated bounceOutLeft').hide('slow');
              scroll();
            });

            setTimeout(function(){
              numberLoop();
            }, 1000);

              function numberLoop(){
                var intervalStudent = setInterval(callbackStudent, 0);
                var i = 0;

                function callbackStudent(){
                  $('.huge.student').text(i);
                  if(i == <?php echo mysqli_num_rows($query_student) ?>){
                    clearInterval(intervalStudent);
                    $('.huge.student').addClass('animated flipInX');
                  }
                  i++;
                }

                var intervalTeacher = setInterval(callbackTeacher, 10);

                var j = 0;

                function callbackTeacher(){
                  $('.huge.teachers').text(j);
                  if(j == <?php echo mysqli_num_rows($query_teachers) ?>){
                    clearInterval(intervalTeacher);
                    $('.huge.teachers').addClass('animated flipInX');
                  }
                  j++;
                }

                var intervalBooks = setInterval(callbackBooks, 0);

                var k = 0;

                function callbackBooks(){
                  $('.huge.books').text(k);
                  if(k == <?php echo mysqli_num_rows($query_books) ?>){
                    clearInterval(intervalBooks);
                    $('.huge.books').addClass('animated flipInX');
                  }
                  k++;
                }
                var intervalMessage = setInterval(callbackMessage, 0);

                var l = 0;

                function callbackMessage(){
                  $('.huge.message').text(l);
                  if(l == <?php echo intval(mysqli_num_rows($req1));  ?>){
                    clearInterval(intervalMessage);
                    $('.huge.message').addClass('animated flipInX');
                  }
                  l++;
                }
              }


          });
        </script>

      </div>
      <!-- /.col-sm-12 -->
      <div class="col-sm-4">
        <table class="table table-responsive table-bordered animated bounceInLeft">
          <h2 class="text-center dashStudentHeading">Student Waiting For Approval</h2>
          <tr>
            <th>S.NO.</th>
            <th>Roll NO.</th>
            <th>View</th>
          </tr>
          <?php
          $counter= 0;
          $query_student = mysqli_query($connection, "select * from students where activated = '0' ORDER by id DESC LIMIT 0,5 ");
          if(!mysqli_num_rows($query_student) > 0){
            echo "<tr>
                  <td colspan='3' class='animated flash text-info'>No pending approvals.</td>
                  </tr>";
          }else {

            while ($row = mysqli_fetch_assoc($query_student)) {
              echo "<tr>";
              $counter = $counter + 1;
              echo "<td>" . $counter . "</td>";
              echo "<td>" . $row['roll_no'] . "</td>";
              echo "<td><a href='waiting.php'><i class='fa fa-eye'></i></a></td>";
              echo "</tr>";
            }
          }
          ?>
        </table>
      </div>
      <div class="col-sm-8">
        <table class="table table-responsive table-bordered animated bounceInLeft">
          <h2 class="text-center dashStudentHeading">Upcoming Events</h2>
          <tr>
            <th>S.NO.</th>
            <th>Event Title</th>
            <th>Event Place</th>
            <th>Event Date</th>
            <th>View</th>
          </tr>
            <?php
            $counter= 0;
            $query_event = mysqli_query($connection, "select * from events ORDER by id DESC LIMIT 0,5 ");
            if(!mysqli_num_rows($query_event) > 0){
              echo "<tr>
                  <td colspan='5' class='animated flash text-info'>No upcoming events.</td>
                  </tr>";
            }else {
              while ($rowEvent = mysqli_fetch_assoc($query_event)) {
                echo "<tr>";
                $counter = $counter + 1;
                echo "<td>" . $counter . "</td>";
                echo "<td>" . $rowEvent['event_title'] . "</td>";
                echo "<td>" . $rowEvent['event_place'] . "</td>";
                echo "<td>" . $rowEvent['event_date'] . "</td>";
                echo "<td><a href='events.php'><i class='fa fa-eye'></i></a></td>";
                echo "</tr>";
              }
            }
            ?>

        </table>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->

    <div class="container ">
      <div class="row stats">

        <!-- /.col-sm-4 -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    <?php include_once('footer.php'); ?>
  <script src="scroll.js"></script>


<?php }else if(isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])) {

  include_once('header.php');
  include_once('includes/connection.php');
  include_once('navbar_teacher.php');
  ?>

  <div class="container-fluid profileHeading">
    <div class="row">
      <div class="col-sm-12">
        <h2 class="sub-header" id="sub-header">Teacher Statistics</h2>
      </div>
      <!-- /.col-sm-12 -->
    </div>
    <!-- /.row -->


      <div class="col-lg-4 col-md-6 animated bounceInDown" id="dashStudentExam">
        <div class="panel panel-customGrey">
          <div class="panel-heading">
            <div class="row animated flash">
              <div class="col-xs-3">
                <i class="fa fa-file-o fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">


                <?php

                $query = mysqli_query($connection, "SELECT * FROM lectures");

                ?>

                <div class="huge dashTotalExam"><?php echo mysqli_num_rows($query); ?></div>
                <div>Total Lectures</div>
              </div>
            </div>
          </div>
          <a href="lectures.php" target="_blank">
            <div class="panel-footer" id="teacherView">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 animated bounceInUp" id="booksDiv">
        <div class="panel panel-info">
          <div class="panel-heading">
            <div class="row animated flash">
              <div class="col-xs-3">
                <i class="fa fa-file-pdf-o fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">

                <?php

                $query = mysqli_query($connection, "SELECT * FROM assignment");

                ?>


                <div class="huge books"><?php echo mysqli_num_rows($query); ?></div>
                <div>Total Assignment</div>
              </div>
            </div>
          </div>
          <a href="assignment.php" target="_blank">
            <div class="panel-footer" id="bookView">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>


    <div class="row">
      <div class="col-lg-4 col-md-6 animated bounceInDown" id="dashStudentAtt">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row animated flash">
              <div class="col-xs-3">
                <i class="fa fa-users fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">


                <?php

                $queryStudentTeacher =  mysqli_query($connection, "SELECT * FROM students where activated = '1' and dept_id = '".$teacher['dept_id']."'");

                ?>

                <div class="huge dashTotalAtt"><?php echo mysqli_num_rows($queryStudentTeacher); ?></div>
                <div>Total Students</div>
              </div>
            </div>
          </div>
          <a href="javascript:;">
            <div class="panel-footer" id="studentView">
              <span class="pull-left" >View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>


    </div>
    <!-- /.row -->



    <div class="row">
      <div class="col-lg-8">
        <h2 class="dashStudentHeading">Upcoming Events</h2>
        <table class="table table-responsive table-bordered">
          <tr>
            <th>S#</th>
            <th>Event Title</th>
            <th>Event Date</th>
            <th>Event Place</th>
            <th>Event Description</th>
          </tr>
          <?php
          $counter= 0;
          $query_event = mysqli_query($connection, "select * from events WHERE event_for = 'teachers' OR event_for ='all'");
          if(!mysqli_num_rows($query_event) > 0){
            echo "<tr>
                  <td colspan='5' class='animated flash text-info'>No upcoming events.</td>
                  </tr>";
          }else {
            while ($rowEvent = mysqli_fetch_assoc($query_event)) {
              echo "<tr>";
              $counter = $counter + 1;
              echo "<td>" . $counter . "</td>";
              echo "<td>" . $rowEvent['event_title'] . "</td>";
              echo "<td>" . $rowEvent['event_date'] . "</td>";
              echo "<td>" . $rowEvent['event_place'] . "</td>";
              echo "<td>" . $rowEvent['event_description'] . "</td>";
              echo "</tr>";
            }
          }
          ?>
        </table>
      </div>

      <div class="col-lg-4">
        <h2 class="dashStudentHeading">Point Timings</h2>
        <table class="table table-responsive table-bordered">
          <tr>
            <th>Point #</th>
            <th>Timing</th>
            <th>Location</th>
          </tr>
          <tr>
            <td>Point No 1</td>
            <td>7AM</td>
            <td>Shahrai Faisal</td>
          </tr>
          <tr>
            <td>Point No 2</td>
            <td>8AM</td>
            <td>Gulshan</td>
          </tr>
          <tr>
            <td>Point No 3</td>
            <td>7AM</td>
            <td>Malir</td>
          </tr>
        </table>
      </div>


    </div>

  </div>
  <!-- /.container-fluid profileHeading -->




  <?php
  include_once('footer_teacher.php');




}
else if(isset($_COOKIE['deo'])||isset($_SESSION['deo'])){?> <!--if session create then create-->

  <?php include_once('header.php'); ?>
  <?php include_once('navbar.php'); ?>
  <?php include_once('includes/connection.php'); ?>

  <div class="container-fluid profileHeading">
    <div class="row">
      <div class="col-sm-12">
        <h2 class="sub-header" id="sub-header"><i class="fa fa-home"></i>Dashboard</h2>
      </div>
      <div class="col-sm-12">


        <div class="row">
          <div class="col-lg-3 col-md-6 animated bounceInDown" id="studentDiv">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-users fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <?php
                    $query_student = mysqli_query($connection, 'SELECT * FROM students');
                    ?>
                    <div class="huge student"></div>
                    <div>Total Students</div>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer" id="studentView">
                  <span class="pull-left" >View Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 animated bounceInDown" id="teacherDiv">
            <div class="panel panel-customGrey">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-user fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <?php $query_teachers = mysqli_query($connection, 'SELECT * FROM teachers');  ?>
                    <div class="huge teachers"></div>
                    <div>Total Teachers</div>
                  </div>
                </div>
              </div>
              <a href="javascript:;">
                <div class="panel-footer" id="teacherView">
                  <span class="pull-left">View Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 animated bounceInUp" id="booksDiv">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-book fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <?php $query_books = mysqli_query($connection, 'SELECT * FROM book');  ?>
                    <div class="huge books"></div>
                    <div>Total Books</div>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer" id="bookView">
                  <span class="pull-left">View Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 animated bounceInUp" id="messageDiv">
            <div class="panel panel-customPurple">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <?php $query_message = mysqli_query($connection, "SELECT * FROM pm WHERE user1 = '".$_SESSION['deoId']."' AND user1read = 'yes' ");  ?>

                    <div class="huge message"></div>
                    <div>Total Messages</div>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer" id="messageView">
                  <span class="pull-left">View Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
        </div>
        <!-- /.row -->

        <?php
        for($i =1 ; $i <=9; $i++ ) {
          $query_depart = mysqli_query($connection, "SELECT dept_id FROM students WHERE dept_id = $i");
          $depart[] = mysqli_num_rows($query_depart);
        }
        ?>


        <div class="row">
          <div class="col-lg-12 col-md-12 col-xs-12 animated bounceInDown" id="studentStats">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-lg-2">
                    <i class="fa fa-users fa-5x"></i>
                  </div>
                  <div class="text-center">
                    <div class="col-lg-1">
                      <p><b>Computer</b></p>
                      <h3><?php echo $depart[0] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Chemical</b></p>
                      <h3><?php echo $depart[1] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Metallurgy</b></p>
                      <h3><?php echo $depart[2] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Industrial</b></p>
                      <h3><?php echo $depart[3] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Petroleum</b></p>
                      <h3><?php echo $depart[4] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Electronics</b></p>
                      <h3><?php echo $depart[5] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Energy</b></p>
                      <h3><?php echo $depart[6] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Telecom</b></p>
                      <h3><?php echo $depart[7] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Architecture</b></p>
                      <h3><?php echo $depart[8] ?></h3>
                    </div>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer" id="hideStudentStats">
                  <span class="pull-left" >Hide Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-left"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
        </div>


        <?php
        for($i =1 ; $i <=9; $i++ ) {
          $query_teacher = mysqli_query($connection, "SELECT dept_id FROM teachers WHERE dept_id = $i");
          $teacher[] = mysqli_num_rows($query_teacher);
        }
        ?>


        <div class="row">
          <div class="col-lg-12 col-md-12 col-xs-12 animated bounceInDown" id="teacherStats">
            <div class="panel panel-customGrey">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-lg-2">
                    <i class="fa fa-user fa-5x"></i>
                  </div>
                  <div class="text-center">
                    <div class="col-lg-1">
                      <p><b>Computer</b></p>
                      <h3><?php echo $teacher[0] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Chemial</b></p>
                      <h3><?php echo $teacher[1] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Metallurgy</b></p>
                      <h3><?php echo $teacher[2] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Industrial</b></p>
                      <h3><?php echo $teacher[3] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Petroleum</b></p>
                      <h3><?php echo $teacher[4] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Electronics</b></p>
                      <h3><?php echo $teacher[5] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Energy</b></p>
                      <h3><?php echo $teacher[6] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Telecom</b></p>
                      <h3><?php echo $teacher[7] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Architecture</b></p>
                      <h3><?php echo $teacher[8] ?></h3>
                    </div>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer" id="hideTeacherStats">
                  <span class="pull-left" >Hide Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-left"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
        </div>


        <?php
        for($i =1 ; $i <=9; $i++ ) {
          $query_book = mysqli_query($connection, "SELECT dept_id FROM book WHERE dept_id = $i");
          $book[] = mysqli_num_rows($query_book);
        }
        ?>


        <div class="row">
          <div class="col-lg-12 col-md-12 col-xs-12 animated bounceInDown" id="bookStats">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-lg-2">
                    <i class="fa fa-book fa-5x"></i>
                  </div>
                  <div class="text-center">
                    <div class="col-lg-1">
                      <p><b>Computer</b></p>
                      <h3><?php echo $book[0] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Chemical</b></p>
                      <h3><?php echo $book[1] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Metallurgy</b></p>
                      <h3><?php echo $book[2] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Industrial</b></p>
                      <h3><?php echo $book[3] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Petroleum</b></p>
                      <h3><?php echo $book[4] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Electronics</b></p>
                      <h3><?php echo $book[5] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Energy</b></p>
                      <h3><?php echo $book[6] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Telecom</b></p>
                      <h3><?php echo $book[7] ?></h3>
                    </div>
                    <div class="col-lg-1">
                      <p><b>Architecture</b></p>
                      <h3><?php echo $book[8] ?></h3>
                    </div>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer" id="hideBookStats">
                  <span class="pull-left" >Hide Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-left"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
        </div>



        <div class="row">
          <div class="col-lg-12 col-md-12 col-xs-12 animated bounceInDown" id="messageStats">
            <div class="panel panel-customPurple">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-lg-2">
                    <i class="fa fa-comment fa-5x"></i>
                  </div>
                  <div class="text-center">
                    <div class="col-lg-5">
                      <p><b>Unread Message(s)</b></p>
                      <?php
                      $msgQueryUnread = mysqli_query($connection, "SELECT * FROM PM WHERE user2 = '".$_SESSION['adminId']."' AND user2read = 'no' ");
                      ?>
                      <h3><?php echo mysqli_num_rows($msgQueryUnread); ?></h3>
                    </div>
                    <div class="col-lg-5">
                      <p><b>Sent Message(s)</b></p>
                      <?php $msgQuerySent = mysqli_query($connection, "SELECT * FROM pm WHERE user1 = '".$_SESSION['adminId']."' AND user1read = 'yes' ");  ?>

                      <h3><?php echo mysqli_num_rows($msgQuerySent); ?></h3>
                    </div>

                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer" id="hideMessageStats">
                  <span class="pull-left" >Hide Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-left"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
        </div>


        <script>
          $(document).ready(function(){



            $('#studentView').click(function(){
              $('#teacherStats, #bookStats, #messageStats').hide('slow');
              $('#studentStats').show().removeClass('animated bounceOutLeft').addClass('animated bounceInLeft');
              scroll();
            });

            $('#hideStudentStats').click(function(){
              $('#studentStats').removeClass('animated bounceInLeft').addClass('animated bounceOutLeft').hide('slow');
              scroll();

            });

            $('#teacherView').click(function(){
              $('#studentStats, #bookStats, #messageStats').hide('slow');
              $('#teacherStats').show().removeClass('animated bounceOutLeft').addClass('animated bounceInLeft');
              scroll();


            });

            $('#hideTeacherStats').click(function(){
              $('#teacherStats').removeClass('animated bounceInLeft').addClass('animated bounceOutLeft').hide('slow');
              scroll();

            });


            $('#bookView').click(function(){
              $('#studentStats, #teacherStats, #messageStats').hide('slow');
              $('#bookStats').show().removeClass('animated bounceOutLeft').addClass('animated bounceInLeft');
              scroll();
            });

            $('#hideBookStats').click(function(){
              $('#bookStats').removeClass('animated bounceInLeft').addClass('animated bounceOutLeft').hide('slow');
              scroll();
            });


            $('#messageView').click(function(){
              $('#studentStats, #teacherStats, #bookStats').hide('slow');
              $('#messageStats').show().removeClass('animated bounceOutLeft').addClass('animated bounceInLeft');
              scroll();
            });

            $('#hideMessageStats').click(function(){
              $('#messageStats').removeClass('animated bounceInLeft').addClass('animated bounceOutLeft').hide('slow');
              scroll();
            });

            setTimeout(function(){
              numberLoop();
            }, 1000);

            function numberLoop(){
              var intervalStudent = setInterval(callbackStudent, 0);
              var i = 0;

              function callbackStudent(){
                $('.huge.student').text(i);
                if(i == <?php echo mysqli_num_rows($query_student) ?>){
                  clearInterval(intervalStudent);
                  $('.huge.student').addClass('animated flipInX');
                }
                i++;
              }

              var intervalTeacher = setInterval(callbackTeacher, 10);

              var j = 0;

              function callbackTeacher(){
                $('.huge.teachers').text(j);
                if(j == <?php echo mysqli_num_rows($query_teachers) ?>){
                  clearInterval(intervalTeacher);
                  $('.huge.teachers').addClass('animated flipInX');
                }
                j++;
              }

              var intervalBooks = setInterval(callbackBooks, 0);

              var k = 0;

              function callbackBooks(){
                $('.huge.books').text(k);
                if(k == <?php echo mysqli_num_rows($query_books) ?>){
                  clearInterval(intervalBooks);
                  $('.huge.books').addClass('animated flipInX');
                }
                k++;
              }
              var intervalMessage = setInterval(callbackMessage, 0);

              var l = 0;

              function callbackMessage(){
                $('.huge.message').text(l);
                if(l == <?php echo mysqli_num_rows($query_message) ?>){
                  clearInterval(intervalMessage);
                  $('.huge.message').addClass('animated flipInX');
                }
                l++;
              }
            }


          });
        </script>

      </div>
      <!-- /.col-sm-12 -->
      <div class="col-sm-12">
        <table class="table table-responsive table-bordered animated bounceInLeft" style="border:1px solid;">
          <h2>Overview</h2>
          <tr>
            <th>S.NO.</th>
            <th>Roll NO.</th>
            <th>Activity</th>
            <th>View</th>
          </tr>
          <?php
          $counter= 0;
          $query_event = mysqli_query($connection, "select * from events WHERE event_for = 'students' OR event_for ='all'");
          if(!mysqli_num_rows($query_event) > 0){
            echo "<tr>
                  <td colspan='5' class='animated flash text-info'>No upcoming events.</td>
                  </tr>";
          }else {
            while ($rowEvent = mysqli_fetch_assoc($query_event)) {
              echo "<tr>";
              $counter = $counter + 1;
              echo "<td>" . $counter . "</td>";
              echo "<td>" . $rowEvent['event_title'] . "</td>";
              echo "<td>" . $rowEvent['event_place'] . "</td>";
              echo "<td>" . $rowEvent['event_date'] . "</td>";
              echo "<td><a href='events.php'><i class='fa fa-eye'></i></a></td>";
              echo "</tr>";
            }
          }
          ?>

        </table>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->

  <div class="container ">
    <div class="row stats">

      <!-- /.col-sm-4 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
  <?php include_once('footer.php'); ?>
  <script src="scroll.js"></script>


<?php }
else if(isset($_COOKIE['librarian'])||isset($_SESSION['librarian'])) {?>

<?php header('Location: library/admin/dashboard.php'); ?>



<?php }else if(isset($_COOKIE['student'])||isset($_SESSION['student'])) {

  include_once('header.php');
  include_once('includes/connection.php');
  include_once('navbar_student.php');
?>

  <div class="container-fluid profileHeading">
    <div class="row">
      <div class="col-sm-12">
        <h2 class="sub-header" id="sub-header">Student Statistics</h2>
      </div>
      <!-- /.col-sm-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
      <div class="col-lg-3 col-md-6 animated bounceInDown" id="dashStudentAtt">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row animated flash">
              <div class="col-xs-3">
                <i class="fa fa-check fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">

                <?php


                if(isset($_SESSION['student'])){
                  $studentId = mysqli_query($connection, "SELECT * FROM students WHERE id = '".$_SESSION['student']."'");
                }elseif(isset($_COOKIE['student'])){
                  $studentId = mysqli_query($connection, "SELECT * FROM students WHERE id = '".$_COOKIE['student']."' ");
                }

                $studentData = mysqli_fetch_assoc($studentId);

                $getSemesterQuery = mysqli_query($connection, "SELECT semester FROM student_attendance WHERE dept_id = '".$studentData['dept_id']."' and student_rollNo = '".$studentData['roll_no']."' ORDER BY semester DESC");
                $getSemester = mysqli_fetch_assoc($getSemesterQuery);



                $allClassesPresentQuery = mysqli_query($connection, "SELECT  date, timing FROM student_attendance WHERE dept_id = '".$studentData['dept_id']."'  AND semester = '".$getSemester['semester']."' AND  student_rollNo = '".$studentData['roll_no']."' AND subject_attendance = 'present'");
                $allClassesQuery = mysqli_query($connection, "SELECT DISTINCT date, timing FROM student_attendance WHERE dept_id = '".$studentData['dept_id']."'   AND semester = '".$getSemester['semester']."'");



                $allClassesPresent = mysqli_num_rows($allClassesPresentQuery);
                $allClasses = mysqli_num_rows($allClassesQuery);

                if($allClasses != 0){

                $attendance = $allClassesPresent  / $allClasses * 100;
                $attendance = number_format($attendance, 2);
                $attendance = $attendance. "%";
                }else{
                  $attendance = 'Pending';
                }

                ?>

                <div class="huge dashTotalAtt"><?php echo $attendance; ?></div>
                <div>Current Attendance</div>
              </div>
            </div>
          </div>
          <a href="sicprofile.php?viewAtt" target="_blank">
            <div class="panel-footer" id="studentView">
              <span class="pull-left" >View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 animated bounceInDown" id="dashStudentExam">
        <div class="panel panel-customGrey">
          <div class="panel-heading">
            <div class="row animated flash">
              <div class="col-xs-3">
                <i class="fa fa-graduation-cap fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">

                <?php

                $getSemesterQuery = mysqli_query($connection, "SELECT semester FROM student_examresult WHERE dept_id = '".$studentData['dept_id']."' AND roll_no = '".$studentData['roll_no']."' ORDER BY semester DESC");
                $getSemester = mysqli_fetch_assoc($getSemesterQuery);


                $examCheckQuery = mysqli_query($connection, "SELECT * FROM student_examresult WHERE roll_no = '".$studentData['roll_no']."' AND dept_id = '".$studentData['dept_id']."' AND semester = '".$getSemester['semester']."' ");
                if(mysqli_num_rows($examCheckQuery) > 0){


                     $totalMarksTheory = 0;
                     $obtainMarksTheory = 0;
                     $totalMarksPractical = 0;
                     $obtainMarksPractical = 0;

           while($row = mysqli_fetch_assoc($examCheckQuery)){


          $getSubjs = mysqli_query($connection, "SELECT subject, theory_ch, practical_ch, course_code FROM subjects WHERE course_code = '".$row['subject_code']."' AND dept_id = '".$studentData['dept_id']."' ");
          $getSubj = mysqli_fetch_assoc($getSubjs);

              if($getSubj['theory_ch']=='3'){
                  $totalMarksTheory = $totalMarksTheory + 100;
                  $obtainMarksTheory = $obtainMarksTheory + $row['subject_theoryMarks'];
              }
              else{
                  $totalMarksTheory = $totalMarksTheory + 50;
                  $obtainMarksTheory = $obtainMarksTheory + $row['subject_theoryMarks'];

              }
              if($getSubj['practical_ch']=='1'){
                  $totalMarksPractical = $totalMarksPractical + 50;
                  $obtainMarksPractical = $obtainMarksPractical + $row['subject_practicalMarks'];

              }
      }
                  $examResult = ($obtainMarksTheory + $obtainMarksPractical) / ($totalMarksTheory+$totalMarksPractical) * 100;
                  $examResult = number_format($examResult, 2);
                  $examResult .= '%';





                } else{
                  $examResult = 'Pending';
                }


                ?>


                <div class="huge dashTotalExam"><?php echo $examResult; ?></div>
                <div>Current Exam Percentage</div>
              </div>
            </div>
          </div>
          <a href="sicprofile.php?viewResult" target="_blank">
            <div class="panel-footer" id="teacherView">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 animated bounceInUp" id="booksDiv">
        <div class="panel panel-info">
          <div class="panel-heading">
            <div class="row animated flash">
              <div class="col-xs-3">
                <i class="fa fa-book fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">

                <?php

                $bookQueryCheck = mysqli_query($connection, "SELECT * FROM borrow WHERE member_id = '".$studentData['id']."' ");
                $result = mysqli_num_rows($bookQueryCheck);



                ?>


                <div class="huge books"><?php echo $result; ?></div>
                <div>Total Borrowed Books</div>
              </div>
            </div>
          </div>
          <a href="javascript:;" target="">
            <div class="panel-footer" id="bookView">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 animated bounceInUp" id="messageDiv">
        <div class="panel panel-customPurple">
          <div class="panel-heading">
            <div class="row animated flash">
              <div class="col-xs-3">
                <i class="fa fa-comments fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">

                <?php       $req1 = mysqli_query($connection, 'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, students.id as userid, students.roll_no from pm as m1, pm as m2,students where ((m1.user1="' . $studentData['id'] . '" and m1.user1read="no" and students.id=m1.user2) or (m1.user2="' . $studentData['id'] . '" and m1.user2read="no" and students.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
                ?>


                <div class="huge message"><?php echo mysqli_num_rows($req1); ?></div>
                <div>Unread Messages</div>
              </div>
            </div>
          </div>
          <a href="feedbackList_pm.php" target="_blank">
            <div class="panel-footer" id="messageView">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <!-- /.row -->



     <div class="row">
       <div class="col-lg-8">
         <h2 class="dashStudentHeading">Upcoming Events</h2>
         <table class="table table-responsive table-bordered">
           <tr>
             <th>S#</th>
             <th>Event Title</th>
             <th>Event Date</th>
             <th>Event Place</th>
             <th>Event Description</th>
           </tr>
           <?php
           $counter= 0;
           $query_event = mysqli_query($connection, "select * from events WHERE event_for = 'students' OR event_for ='all'");
           if(!mysqli_num_rows($query_event) > 0){
             echo "<tr>
                  <td colspan='5' class='animated flash text-info'>No upcoming events.</td>
                  </tr>";
           }else {
             while ($rowEvent = mysqli_fetch_assoc($query_event)) {
               echo "<tr>";
               $counter = $counter + 1;
               echo "<td>" . $counter . "</td>";
               echo "<td>" . $rowEvent['event_title'] . "</td>";
               echo "<td>" . $rowEvent['event_date'] . "</td>";
               echo "<td>" . $rowEvent['event_place'] . "</td>";
               echo "<td>" . $rowEvent['event_description'] . "</td>";
               echo "</tr>";
             }
           }
           ?>
         </table>
       </div>

       <div class="col-lg-4">
         <h2 class="dashStudentHeading">Point Timings</h2>
         <table class="table table-responsive table-bordered">
            <tr>
              <th>Point #</th>
              <th>Timing</th>
              <th>Location</th>
            </tr>
           <tr>
             <td>Point No 1</td>
             <td>9AM</td>
             <td>Shahrai Faisal</td>
           </tr>
           <tr>
             <td>Point No 2</td>
             <td>9AM</td>
             <td>Gulshan</td>
           </tr>
           <tr>
             <td>Point No 3</td>
             <td>9AM</td>
             <td>Malir</td>
           </tr>
         </table>
       </div>


     </div>


  </div>
  <!-- /.container-fluid profileHeading -->




  <?php
  include_once('footer.php');

} else{
  header('Location: index.php');
  }
?>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->


</body>
</html>
