<?php session_start(); ?>


<?php

if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])){?>

    <?php include('header.php') ?>

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
}
        if(isset($_GET['error'])){
            echo "<script> alert('Roll No. already Exist!')</script>";
        }




?>


<?php include_once('navbar.php'); ?>



    <?php

            (isset($_GET['id'])) ? $id = (int)$_GET['id'] : '';


            $query = "SELECT * FROM students WHERE id = $id";
            $query_run = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($query_run)){

                $id = $row['id'];
                $name = $row['name'];
                $fathername = $row['father_name'];
                $password = $row['password'];
                $email = $row['email'];
                $department = $row['dept_id'];
                $checker=0;
                if(isset($_SESSION['deo'])||isset($_COOKIE['deo'])){
                if($department==$deo['dept_id']){
                    $checker=1;
                }
                }
                if(isset($_SESSION['name'])||(isset($_COOKIE['name']))){
                    $checker=1;
                }
                if($checker=='1'){
                $en_no = $row['en_no'];
                $ro_no = $row['roll_no'];
                $address = $row['address'];
                $batch = $row['dept_batch'];
                $phone = $row['phone'];
                $gender = $row['gender'];
                $nationality = $row['nationality'];
                $religion = $row['religion'];
                $domicile = $row['domicile'];
                $cnic = $row['cnic'];
                $picture = $row['picture'];
    $query_depart = "SELECT dept_name FROM department WHERE dept_id=$department";
    $query_run_depart = mysqli_query($connection, $query_depart);
    if($query_run_depart){

        while($row1=mysqli_fetch_assoc($query_run_depart)) {
            $department = $row1['dept_name'];

        }


    if(isset($_GET['update'])){?>

        <script>
            $(function(){
                var url;
                url = window.location.href;
                $('.updateMessage').show('slow').delay('2500').fadeOut('2000');
                window.history.pushState("", "", url.split("&")[0]);
            });

        </script>

    <?php } ?>



     <div class="container-fluid profileHeading">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="sub-header" id="sub-header"><?php echo ucfirst($name). "'s Profile"; ?> <button class="btn btn-success pull-right updateMessage" style="display: none">Record has been updated.</button></h2>
                <button class="btn btn-primary new goBack" style="display: none">&laquo; Back</button>


            </div>
        </div>


        <form class="form-inline" id="updateNew" method="post" action="<?php echo htmlspecialchars('update_student.php'); ?>" enctype="multipart/form-data">

            <div class="container addNewStudent">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name" class="control-label"> Name</label>
                            <input type="text" name="name" class="form-control" id="name" maxlength="32" size="30" placeholder="Name"  value="<?php echo $name; ?>" autofocus required >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" name="password" class="form-control" size="30" maxlength="32" id="password" placeholder="Password" value="<?php echo $password; ?>" required >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="fathername" class="control-label">Father Name</label>
                            <input type="text" name="fathername" class="form-control" id="fathername" maxlength="32" size="30" value="<?php echo $fathername; ?>" placeholder="Father Name" required>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="gender" class="control-label">Gender</label>
                            <select class="form-control" id="gender" name="gender" required >
                                <option value="<?php echo ($gender == 'Male' ? $gender : 'Female'); ?>"><?php echo ($gender == 'Male' ? $gender : 'Female'); ?></option>
                                <option value="<?php echo ($gender == 'Male' ? 'Female' : 'Male'); ?>"><?php echo ($gender == 'Male' ? 'Female' : 'Male'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="phone_no" class="control-label">Phone No</label>
                            <input type="text" name="phone_no" class="form-control" id="phone_no" maxlength="32" value="<?php echo $phone; ?>" placeholder="Phone No" size="30" required >
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="email" class="control-label">Email Address</label>
                            <input type="email" name="email" class="form-control" id="email" maxlength="32" placeholder="Email Address" size="30" value="<?php echo $email; ?>" required>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="batch" class="control-label">Batch</label>
                            <select class="form-control" id="batch" name="batch" required>
                                <option value="">Please Select</option>
                                <option value="13">2013</option>
                                <option value="14">2014</option>
                                <option value="15">2015</option>
                                <option value="16">2016</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="department" class="control-label">Department</label>
                            <select class="form-control" id="department" name="department" required >

                                <?php
                            if(isset($_SESSION['deo'])||isset($_COOKIE['deo'])){
                                $query = "SELECT * FROM department where dept_id='".$deo['dept_id']."'";
                                $query_run = mysqli_query($connection, $query);

                                while($row = mysqli_fetch_assoc($query_run)){

                                    $depart_id = $row['dept_id'];
                                    $depart_name = $row['dept_name'];

                                    if($department == $depart_name){
                                        echo "<option value='".$depart_id."' selected>$depart_name</option>";
                                        continue;
                                    }
                                    echo "<option value='".$depart_id."'>$depart_name</option>";
                                }
                            }else{
                                $query = "SELECT * FROM department";
                                $query_run = mysqli_query($connection, $query);

                                while($row = mysqli_fetch_assoc($query_run)){

                                    $depart_id = $row['dept_id'];
                                    $depart_name = $row['dept_name'];

                                    if($department == $depart_name){
                                        echo "<option value='".$depart_id."' selected>$depart_name</option>";
                                        continue;
                                    }
                                    echo "<option value='".$depart_id."'>$depart_name</option>";
                                }}
                                ?>
                            </select>
                        </div>
                    </div>

                    <script>

                        $(function(){
                            var value;
                            $('#batch option').each(function(i){
                                value = $(this).text();
                                if(value == <?php echo $batch; ?>){
                                    $('#batch option')[i].setAttribute('selected', 'selected');
                                }
                            });

                        });

                    </script>



                    <div class="col-sm-4">
                        <div class="form-group" id="rono_err">
                            <label for="roll_no" class="control-label">Roll-No</label>
                            <input type="text" name="roll_no_D" class="form-control" id="roll_no_D"  value="D" readonly="readonly" > -
                            <input type="text" name="roll_no_batch" class="form-control " id="roll_no_batch"  readonly="readonly"> -
                            <input type="text" name="roll_no_depart" class="form-control " id="roll_no_depart"  readonly="readonly" > -
                            <input type="number" name="roll_no" class="form-control " id="roll_no"  min="01" max="50" onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;" value="<?php echo explode("-",$ro_no)[3];  ?>" required >
                        </div>
                    </div>
                </div>

                <!-- /.row -->
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="en_no" class="control-label">Enrollment No</label>
                            <input type="number" name="en_ro" class="form-control" maxlength="8" id="department" value="<?php echo $en_no; ?>" placeholder="Enrollment No" size="30" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="nationality" class="control-label">Nationality</label>
                            <input type="text" name="nationality" class="form-control" maxlength="20" value="<?php echo $nationality; ?>" id="nationality" placeholder="Nationality" size="30" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="religion" class="control-label">Religion</label>
                            <input type="text" name="religion" class="form-control" maxlength="15" value="<?php echo $religion; ?>" id="religion" placeholder="Religion" size="30" required>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="domicile" class="control-label">Domicile</label>
                            <input type="text" name="domicile" value="<?php echo $domicile; ?>" maxlength="15" class="form-control" id="domicile" placeholder="Domicile" size="30" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="cnic" class="control-label">CNIC#</label>
                            <input type="text" name="cnic" value="<?php echo $cnic; ?>" maxlength="15" class="form-control" id="cnic" placeholder="CNIC#" size="30" required>
                        </div>
                        <script>
                            /*CHECKING CNIC PATTERN*/

                            $(function(){
                                $('#cnic').keydown(function(e){
                                    var textLength = $(this).val().length;
                                    if((textLength == 5 && e.keyCode !=8)  ||  (textLength == 13 && e.keyCode !=8)){
                                        $(this).val($(this).val() + '-');
                                    }
                                });
                            });
                        </script>

                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="address" class="control-label">Address</label>
                            <textarea name="address" class="form-control" id="address" placeholder="Address" cols="30" rows="3" required> <?php echo $address; ?></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div>
                            <button type="submit" name="submit" class="btn btn-primary" id="insert">Update Record</button>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <span class="rono_err btn btn-danger pull-right"></span><i class="fa fa-spinner fa-pulse insert_loading pull-right"></i>
                        </div>
                    </div>

                </div>
                <!-- /.col-sm-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container -->

        </form>

        <?php

            if(isset($_GET['viewResult'])){
            ?>
            <script>

                $(document).ready(function(){
                    $(window).load(function() {
                        $('#sicShowExam').click();
                    });
                });

            </script>

            <?php  } ?>



         <script>
             $(function(){



                 $('#sicShowExam').click(function(){
                        $('#viewExamBtn').click();
                            $('#sicHeadingForm, .sicResultAtt').hide('slow');
                            $('#sicHeadExamButton').css('display', 'inline').show('slow');
                            $('.changeSicText').addClass('animated flipInX').text('Academics Information');
                            $('.sicPersonalInfo').addClass('animated bounceInRight').hide('slow');
                            $('#semesterResult').focus();
                    });





                 $('#insertExamBtn').click(function(){
                        $('.sicResult').show('slow');
                        $('.sicResultShow').hide('slow');
                        $('#semesterResult').focus();
                 });

                 $('#viewExamBtn').click(function(){
                     $('.sicResult').hide('slow');
                     $('.sicResultShow').show('slow');
                     $('#semesterResultShow').focus();
                 });


                 $('#sicShowProfile').click(function(){

                 $('#sicHeadExamButton, .sicResultAtt, .sicResultShow').hide('slow');
                     $('#sicHeadingForm').css('display', 'inline').show('slow');
                     $('.sicResult').hide('slow');
                     $('.changeSicText').addClass('animated flipInX').text('Personal Information');
                     $('.sicPersonalInfo').addClass('animated bounceInRight').show('slow');
                 });


                 $('#semesterResultShow').change(function(){
                     $('#insertExamShow').submit();
                 });


                 $('#semesterResult').change(function(){
                        $('#insertExam').submit();
                 });

                /* SHOW ATTENDANCE */

                 $('#sicShowAttendance').click(function(){
                     $('#sicHeadingForm, #sicHeadExamButton, .sicResult, .sicResultShow').hide('slow');
                     $('.sicPersonalInfo').addClass('animated bounceInRight').hide('slow');
                     $('.changeSicText').addClass('animated flipInX').text('Attendance Information');
                     $('.sicResultAtt').show('slow');
                     $('#semesterResultAtt').focus();
                 });


                 $('#semesterResultAtt').change(function(){
                    $('#showSicAtt').submit();
                 });

                 $('#showSicAtt').submit(function(){

                     var url, values;
                     url = $(this).attr('action');
                     values = $(this).serialize();

                     $.post(url, values, function(data){

                            data = data.trim();
                            $('#sicAttOutput').html(data);

                     });


                     return false;
                 });






             });
         </script>



        <div class="container-fluid sicProfileContainer">
                <div class="row">
                    <div class="col-sm-3 sicProfileSideBar">
                        <div class="sicPhotoContainer">
                            <?php

                            if($picture == ''){
                                echo "<img src='images/profile_pic.png' alt=''>";
                            }else{
                                echo "<img src='student_picture/$picture' alt=''>";
                            }

                            ?>
                            <form action="<?php echo htmlspecialchars('update_student.php'); ?>" id="addPicture" method="post" enctype="multipart/form-data" name="addPicture">

                                <label class="btn btn-primary btn-file">
           <span class="fa fa-picture-o" aria-hidden="true"> Upload New </span><input id="pictureNew" name="pictureNew" type="file">
                                </label>
                                <input type="hidden" name="ro_no" value="<?php echo $ro_no; ?>">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" value="submit" name="submitPictureNew" id="submitPictureNew">
                            </form>


                        </div>
                        <!-- /.sicPhotoContainer -->
                        <div class="sicProfileLinks">
                            <ul>
                                <li><a  href="javascript:;" id="sicShowProfile" class="activeLink" >Personal Information</a></li>
                                <li><a href="javascript:;" id="sicShowAttendance"> Attendance</a></li>
                                <li><a href="javascript:;" id="sicShowExam">Academics Information</a></li>
                            </ul>
                        </div>
                        <!-- /.sicProfileLinks -->
                    </div>
                    <!-- /.col-sm-3 profileSideBar -->
                    <div class="col-sm-9 sicProfileMain" >
                        <h2 class="sicPersonalInfoHeading"><span class="changeSicText">Personal Information</span>
                        <span id="sicHeadingForm">
                                      <form action="<?php echo htmlspecialchars('update_student.php'); ?>" method="post" id="submitUpdate">
                                          <button type="button" class="btn btn-danger pull-right" id="delete"><span class="fa fa-remove" aria-hidden="true"></span>  DELETE</button>
                                          <input type="submit" value="submit" name="delete" id="delete_submit" style="display: none;">
                                          <input type="hidden" name="u_id" value="<?php echo $id; ?>">
                                      </form>
                            <button type="button" class="btn btn-primary pull-right new" id="edit"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>  EDIT</button>
                        </span>
                            <span id="sicHeadExamButton">
                                 <button type="button" class="btn btn-info pull-right" id="viewExamBtn"><span class="fa fa-eye" aria-hidden="true"></span>  VIEW</button>
                                 <button type="button" class="btn btn-primary pull-right" id="insertExamBtn"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>  INSERT</button>
                            </span>

                        </h2>
                       <!-- /.sicPersonalInfoHeading -->
                        <div class="sicPersonalInfo">
                            <div class="row sicPersonalInfoRow">
                                <div class="col-sm-6">
                                    <div ><b>Name: </b><span class="update" id="u_name"><?php echo $name; ?></span></div>
                                    <div ><b>Gender: </b><span class="update" id="u_gender"><?php echo $gender ?></span></div>
                                </div>
                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                    <div><b>Father's Name: </b><?php echo $fathername; ?></div>
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            <div class="row sicPersonalInfoRow">
                                <div class="col-sm-6">
                                    <div><b>Department: </b><?php echo $department; ?></div>
                                    <div><b>Batch: </b><?php echo $batch; ?></div>
                                </div>
                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                    <div><b>Roll No: </b><?php echo $ro_no; ?></div>
                                    <div><b>Enrollment No: </b><?php echo $en_no; ?></div>
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            <div class="row sicPersonalInfoRow">
                                <div class="col-sm-6">
                                    <div><b>Nationality: </b><?php echo $nationality; ?></div>
                                    <div><b>Religion: </b><?php echo $religion; ?></div>
                                </div>
                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                    <div><b>Domicile: </b><?php echo $domicile; ?></div>
                                    <div><b>CNIC: </b><?php echo $cnic; ?></div>
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            <div class="row sicPersonalInfoRow">
                                <div class="col-sm-6">
                                    <div><b>Email Address: </b><?php echo $email; ?></div>
                                    <div><b>Contact No: </b><?php echo $phone; ?></div>
                                </div>
                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                    <p><b>Address: </b><?php echo $address; ?></p>
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.sicPersonalInfo -->




                        <!--show attendance result-->
                        <div class="sicResultAtt">
                            <div class="row sicPersonalInfoRow">
                                <form action="<?php echo htmlspecialchars('show_attendance.php'); ?>" method="post" id="showSicAtt">
                                    <div class="row">

                                        <input type="hidden" name="sicAttId" id="sicAttId" value="<?php echo $_GET['id']; ?>"/>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="semesterResultAtt" class="control-label">Select Semester To View Attendance</label>
                                                <select class="form-control" id="semesterResultAtt" name="semesterResultAtt" required >
                                                    <option value="">Please Select</option>

                                                    <?php

                                                    $query_semester = "SELECT * FROM semester";
                                                    $query_run_semester = mysqli_query($connection, $query_semester);

                                                    while($row = mysqli_fetch_assoc($query_run_semester)){

                                                        $semester_id = $row['semester_id'];
                                                        $semester_name = $row['semester_name'];

                                                        echo "<option value='".$semester_id."'>$semester_name</option>";
                                                    }


                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row sicPersonalInfoRow sicAttOutput">
                                <div class="col-lg-12">
                                    <div id="sicAttOutput"></div>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>

                        <!--end show attendance result-->


                        <!--show exam result-->

                        <div class=" sicResultShow">
                            <div class="row sicPersonalInfoRow">
                                <form action="<?php echo htmlspecialchars('insert_examination.php'); ?>" method="post" id="insertExamShow">
                                    <div class="row">

                                        <input type="hidden" name="idResultShow" id="idResultShow" value="<?php echo $_GET['id']; ?>"/>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="SemesterResult" class="control-label">Select Semester To View Result</label>
                                                <select class="form-control" id="semesterResultShow" name="semesterResultShow" required >
                                                    <option value="">Please Select</option>

                                                    <?php

                                                    $query_semester = "SELECT * FROM semester";
                                                    $query_run_semester = mysqli_query($connection, $query_semester);

                                                    while($row = mysqli_fetch_assoc($query_run_semester)){

                                                        $semester_id = $row['semester_id'];
                                                        $semester_name = $row['semester_name'];

                                                        echo "<option value='".$semester_id."'>$semester_name</option>";
                                                    }


                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row sicPersonalInfoRow examOutputShow">
                                <div class="col-lg-12">
                                    <div id="examOutputShow"></div>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>


                        <!--end show exam result-->


                        <!--insert exam result-->
                        <div class=" sicResult">
                            <div class="row sicPersonalInfoRow">
                                <form action="<?php echo htmlspecialchars('insert_examination.php'); ?>" method="post" id="insertExam">
                                <div class="row">

                                    <input type="hidden" name="idResult" id="idResult" value="<?php echo $_GET['id']; ?>"/>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="SemesterResult" class="control-label">Select Semester To Insert Result</label>
                                        <select class="form-control" id="semesterResult" name="semesterResult" required >
                                            <option value="">Please Select</option>
                                            <?php

                                            $query_semester = "SELECT * FROM semester";
                                            $query_run_semester = mysqli_query($connection, $query_semester);

                                            while($row = mysqli_fetch_assoc($query_run_semester)){

                                                $semester_id = $row['semester_id'];
                                                $semester_name = $row['semester_name'];
                                                echo "<option value='".$semester_id."'>$semester_name</option>";
                                            }


                                            ?>

                                        </select>
                                    </div>
                                 </div>
                                    </div>
                                    </form>
                            </div>
                            <div class="row sicPersonalInfoRow examOutput">
                                <div class="col-lg-12">
                                    <div id="examOutput"></div>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <!--end insert exam result-->




                    </div>
                    <!-- /.col-sm-9 profileMain -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
     </div>

        <?php include('footer.php') ?>


            <!-- Modal DELETE-->
        <div class="modal animated flipInX" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-danger" id="myModalLabel">ALERT</h4>
                    </div>
                    <div class="modal-body  text-center">

                        <h2 id="sureText">Are you sure?</h2>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="deleteYes">DELETE</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal UPDATE-->
        <div class="modal animated flipInX" id="myModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">UPDATE</h4>
                    </div>
                    <div class="modal-body  text-center">

                        <form class="form-inline" id="updateData" method="post" action="<?php echo htmlspecialchars('update_student.php'); ?>">



                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal" id="updateYes">UPDATE</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>

                $(document).ready(function(){


                    $('#insertExamShow').submit(function(e){

                        e.preventDefault();
                        var values, url;
                        values = $(this).serialize();
                        url = $(this).attr('action');

                        $.ajax({

                            type: 'POST',
                            url: url,
                            data: values,
                            success:function(data){
                                data = data.trim();
                                $('#examOutputShow').html(data);

                                /* UPDATE EXAM*/

                                $('#updateExamBtn').click(function(){

                                    $('#updateExamForm input').prop('disabled', false);
                                    $(this).hide('slow');
                                    $('#updateExamGoBtn').show('slow');
                      //              $("[name='updateExam[]']").attr('value', '');

                                });



                                $('#updateExamForm').submit(function(){



                                var url, values;

                                    url = $(this).attr('action');
                                    values = $(this).serialize();

                                    $('#updateExamOutput').show().html('<i class="fa fa-2x fa-spinner fa-pulse animated flip"></i>');


                                    $.ajax({

                                        type: 'POST',
                                        url: url,
                                        data: values,
                                        success:function(data){
                                            data = data.trim();
                                            if(data == 'updated'){
                                                $('#updateExamOutput').show().html('<span class="btn btn-success animated bounceInLeft">Result has been updated.</span>');
                                            setTimeout(function(){
                                                $('#insertExamShow').submit();
                                            }, 1500)

                                            }

                                        }

                                    });


                                    return false;

                                });



                            }
                    });
                });




                    $('#insertExam').submit(function(){

                        var values, url;
                        values = $(this).serialize();
                        url = $(this).attr('action');

                        $('#insertExamAgain input, #submitMarks').prop('disabled', false);


                        $.ajax({

                           type: 'POST',
                           url: url,
                           data: values,
                            success:function(data){
                                data = data.trim();
                                if(data == 'noResult'){
                                    $('#examOutput, .examOutput').show().html("<p class='lead animated flash btn btn-danger'>No Subjects found for this semester.<p>");
                                }else {
                                    $('#examOutput, .examOutput').show('slow').html(data);
                                    $('#theoryMarks').focus();
                                }

                                $('#insertExamAgain').submit(function(e){

                                    e.preventDefault();


                                    var values = $(this).serialize();
                                    var url = $(this).attr('action');


                                    $.ajax({

                                        type: 'POST',
                                        url: url,
                                        data: values,
                                        success:function(data){
                                            data = data.trim();
                                            if(data == 'inserted'){
                                                $('#sicExamOutput').html('<a href="javascript:;" class="btn btn-success animated bounceInLeft">Marks has been inserted successfully.</a>');
                                                $('#insertExamAgain input, #submitMarks').prop('disabled', true);
                                                setTimeout(function(){
                                                    $('#sicExamOutput > a').addClass('bounceOutRight');
                                                    $('#semesterResult').focus();
                                                }, 2000);
                                            }else{
                                                $('#sicExamOutput').html(data);
                                                $('#insertExamAgain input, #submitMarks').prop('disabled', true);

                                            }
                                        }

                                    });



                                });



                            }

                        });
                        return false;
                    });


                    $('#department').change(function(){
                        val = $(this).val();

                        $('#roll_no_depart').val('');
                        $(department).each(function(i){
                            if(department[i] == val){
                                $('#roll_no_depart').val(depart_short[i]);
                                //      console.log(depart_short[i]);
                            }
                        });
                    });

                    var rollnoCheck = '';
                   rollnoCheck  = '<?php echo $ro_no; ?>';

                    $('#roll_no, #department, #batch').change(function(){

                        var batch, depart, no, rollno;

                        batch = $('#batch').val();
                        depart = $('#roll_no_depart').val();
                        no = $('#roll_no').val();
                    //    console.log(depart);

                    rollno = "D-"+batch+"-"+depart+"-"+no;
                        console.log(rollno);

                        if(rollnoCheck != rollno){

                        $.post('check_student_id.php',
                        {rollno: rollno},
                            function(data){
                                if(data.trim() == 'error'){
                                    $('.rono_err').text('Roll no already exists.').addClass('animated bounceIn').fadeIn('slow');
                                    $('#rono_err').addClass('has-error');
                                    $('#insert').prop('disabled', true);
                                }else{
                                    $('#rono_err').removeClass('has-error');
                                    $('.rono_err').hide();
                                    $('#insert').prop('disabled', false);
                                }
                            }
                        )
                            }else{
                            $('#rono_err').removeClass('has-error');
                            $('.rono_err').hide();
                            $('#insert').prop('disabled', false);
                        }
                    });





                    var department, depart_short, val;

                    department = [1, 2, 3, 4, 5, 6, 7, 8, 9];
                    depart_short = ['CS', 'CH', 'ME', 'IN', 'PG', 'ES', 'EE', 'TE', 'AR'];

                    val = $('#department').val();

                    $('#roll_no_depart').val('');
                    $(department).each(function(i){
                        if(department[i] == val){
                            $('#roll_no_depart').val(depart_short[i]);
                        }
                    });

                    val = $('#batch').val();
                    $('#roll_no_batch').val(val);



                    $('#batch').change(function(){
                        val = $(this).val();
                        $('#roll_no_batch').val(val);
                    });


                    $('#roll_no_D').focus(function(){
                        $('#roll_no').focus();
                    });



                    $('.new').click(function(){
                        $('#updateNew').slideToggle('slow', function(){
                            if($(this).is(':visible')){
                                $('.sicProfileContainer').addClass('animated zoomOut').hide();
                                $('.new').show();
                                scroll();
                           //     window.location.hash = '#insert';
                                $('#name').focus();

                            }else{
                                $('.goBack').hide();
                                $('.sicProfileContainer').show().removeClass('animated zoomOut').addClass('animated zoomIn');
                                scroll();
                            //    window.location.hash = '#sub-header';

                            }
                        });
                    });



                    $('#pictureNew').change(function(){
                        var file = this.files[0];
                        var imagefile = file.type;
                        var imagesize = file.size;

                        var match= ["image/jpeg","image/png","image/jpg"];
                        if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
                        {
                            alert('Image should be in "JPEG | PNG | JPG" format.');
                            $(this).val('');
                            return false;
                        }else if(imagesize > 2000000){
                            alert('Image size should be less than 2MB.');
                            $(this).val('');
                            return false;
                        }else{
                            $('#submitPictureNew').click();
                        }
                    });



                    $('#delete').click(function(){
                        $('#myModal').modal('show');
                        $('#deleteYes').focus();
                        $('#deleteYes').click(function(){
                            $('#delete_submit').click();

                        });
                    });
                });






            </script>

            <?php }}else{
                    echo "<h1>Page Not Found</h1>";
                    include 'footer.php';
                }}}else if(isset($_SESSION['student']) || isset($_COOKIE['student'])){



    include_once('header.php');
    include_once('includes/connection.php');
    include_once('navbar_student.php');


?>


<div class="container-fluid profileHeading">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="sub-header" id="sub-header"><?php echo ucfirst($student['name']). "'s Profile"; ?> <button class="btn btn-success pull-right updateMessage" style="display: none">Record has been updated.</button></h2>
            <button class="btn btn-primary new goBack" style="display: none">&laquo; Back</button>


        </div>
    </div>

    <div class="container-fluid sicProfileContainer">
                <div class="row">
                    <div class="col-sm-3 sicProfileSideBar">
                        <div class="sicPhotoContainer">
                            <?php

                            $picture = $student['picture'];

                            if($picture == ''){
                                echo "<img src='images/profile_pic.png' alt=''>";
                            }else{
                                echo "<img src='student_picture/$picture' alt=''>";
                            }

                            ?>

                        </div>
                        <!-- /.sicPhotoContainer -->
                        <div class="sicProfileLinks">
                            <ul>
                                <li><a  href="javascript:;" id="sicShowProfile" class="activeLink" >Personal Information</a></li>
                                <li><a href="javascript:;" id="sicShowAttendance"> Attendance</a></li>
                                <li><a href="javascript:;" id="sicShowExam">Academics Information</a></li>
                            </ul>
                        </div>
                        <!-- /.sicProfileLinks -->
                    </div>
                    <!-- /.col-sm-3 profileSideBar -->
                    <div class="col-sm-9 sicProfileMain" >
                        <h2 class="sicPersonalInfoHeading">Personal Information</h2>
                       <!-- /.sicPersonalInfoHeading -->
                        <div class="sicPersonalInfo">
                            <div class="row sicPersonalInfoRow">
                                <div class="col-sm-6">
                                    <div ><b>Name: </b><span class="update" id="u_name"><?php echo $student['name']; ?></span></div>
                                    <div ><b>Gender: </b><span class="update" id="u_gender"><?php echo $student['gender'] ?></span></div>
                                </div>
                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                    <div><b>Father's Name: </b><?php echo $student['father_name']; ?></div>
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->

                            <?php

                            $query_depart = "SELECT dept_name FROM department WHERE dept_id= '".$student['dept_id']."'";
                            $query_run_depart = mysqli_query($connection, $query_depart);
                            if($query_run_depart) {

                                while ($row1 = mysqli_fetch_assoc($query_run_depart)) {
                                    $department = $row1['dept_name'];
                                }
                            }
                            ?>

                            <div class="row sicPersonalInfoRow">
                                <div class="col-sm-6">
                                    <div><b>Department: </b><?php echo $department; ?></div>
                                    <div><b>Batch: </b><?php echo $student['dept_batch']; ?></div>
                                </div>
                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                    <div><b>Roll No: </b><?php echo $student['roll_no']; ?></div>
                                    <div><b>Enrollment No: </b><?php echo $student['en_no']; ?></div>
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            <div class="row sicPersonalInfoRow">
                                <div class="col-sm-6">
                                    <div><b>Nationality: </b><?php echo $student['nationality']; ?></div>
                                    <div><b>Religion: </b><?php echo $student['religion']; ?></div>
                                </div>
                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                    <div><b>Domicile: </b><?php echo $student['domicile']; ?></div>
                                    <div><b>CNIC: </b><?php echo $student['cnic']; ?></div>
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            <div class="row sicPersonalInfoRow">
                                <div class="col-sm-6">
                                    <div><b>Email Address: </b><?php echo $student['email']; ?></div>
                                    <div><b>Contact No: </b><?php echo $student['phone']; ?></div>
                                </div>
                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                    <p><b>Address: </b><?php echo $student['address']; ?></p>
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.sicPersonalInfo -->

                        <!--show attendance result-->
                        <div class="sicResultAtt">
                            <div class="row sicPersonalInfoRow">
                                <form action="<?php echo htmlspecialchars('show_attendance.php'); ?>" method="post" id="showSicAtt">
                                    <div class="row">

                                        <input type="hidden" name="sicAttId" id="sicAttId" value="<?php echo $student['id']; ?>"/>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="semesterResultAtt" class="control-label">Select Semester To View Attendance</label>
                                                <select class="form-control" id="semesterResultAtt" name="semesterResultAtt" required >
                                                    <option value="">Please Select</option>

                                                    <?php

                                                    $query_semester = "SELECT * FROM semester";
                                                    $query_run_semester = mysqli_query($connection, $query_semester);

                                                    while($row = mysqli_fetch_assoc($query_run_semester)){

                                                        $semester_id = $row['semester_id'];
                                                        $semester_name = $row['semester_name'];

                                                        echo "<option value='".$semester_id."'>$semester_name</option>";
                                                    }


                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row sicPersonalInfoRow sicAttOutput">
                                <div class="col-lg-12">
                                    <div id="sicAttOutput"></div>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>

                        <!--end show attendance result-->


                        <!--show exam result-->

                        <div class="sicResultShow">
                            <div class="row sicPersonalInfoRow">
                                <form action="<?php echo htmlspecialchars('insert_examination.php'); ?>" method="post" id="insertExamShow">
                                    <div class="row">

                                        <input type="hidden" name="idResultShow" id="idResultShow" value="<?php echo $student['id']; ?>"/>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="SemesterResult" class="control-label">Select Semester To View Result</label>
                                                <select class="form-control" id="semesterResultShow" name="semesterResultShow" required >
                                                    <option value="">Please Select</option>

                                                    <?php

                                                    $query_semester = "SELECT * FROM semester";
                                                    $query_run_semester = mysqli_query($connection, $query_semester);

                                                    while($row = mysqli_fetch_assoc($query_run_semester)){

                                                        $semester_id = $row['semester_id'];
                                                        $semester_name = $row['semester_name'];

                                                        echo "<option value='".$semester_id."'>$semester_name</option>";
                                                    }


                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row sicPersonalInfoRow examOutputShow">
                                <div class="col-lg-12">
                                    <div id="examOutputShow"></div>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>


                        <!--end show exam result-->

                    </div>
                    <!-- /.col-sm-9 profileMain -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>



    <?php

    if(isset($_GET['viewResult'])){
        ?>
        <script>

            $(document).ready(function(){
                $(window).load(function() {
                    $('#sicShowExam').click();
                });
            });

        </script>

    <?php  }else if(isset($_GET['viewAtt'])){

        ?>
        <script>

            $(document).ready(function(){
                $(window).load(function() {
                    $('#sicShowAttendance').click();
                });
            });

        </script>
        <?php } ?>


    <script>
        $(document).ready(function(){

            $('#sicShowExam').click(function(){
                $('#sicHeadingForm, .sicResultAtt').hide('slow');
                $('.sicResultShow').show('slow');
                $('.sicPersonalInfoHeading').addClass('animated flipInX').text('Academics Information');
                $('.sicPersonalInfo').addClass('animated bounceInRight').hide('slow');
                $('#semesterResultShow').focus();
            });

            $('#sicShowProfile').click(function(){
                $('.sicResultShow, .sicResultAtt').hide('slow');
                $('#sicHeadExamButton').hide('slow');
                $('.sicPersonalInfoHeading').addClass('animated flipInX').text('Personal Information');
                $('.sicPersonalInfo').addClass('animated bounceInRight').show('slow');
            });

            $('#semesterResultShow').change(function(){
                $('#insertExamShow').submit();
            });



            $('#insertExamShow').submit(function(e){

                e.preventDefault();
                var values, url;
                values = $(this).serialize();
                url = $(this).attr('action');

                $.ajax({

                    type: 'POST',
                    url: url,
                    data: values,
                    success:function(data){
                        data = data.trim();
                        $('#examOutputShow').html(data);

                    }
                });
            });


            /* SHOW ATTENDANCE */

            $('#sicShowAttendance').click(function(){
                $('#sicHeadingForm, #sicHeadExamButton, .sicResult, .sicResultShow').hide('slow');
                $('.sicPersonalInfo').addClass('animated bounceInRight').hide('slow');
                $('.sicPersonalInfoHeading').addClass('animated flipInX').text('Attendance Information');
                $('.sicResultAtt').show('slow');
                $('#semesterResultAtt').focus();
            });


            $('#semesterResultAtt').change(function(){
                $('#showSicAtt').submit();
            });

            $('#showSicAtt').submit(function(){

                var url, values;
                url = $(this).attr('action');
                values = $(this).serialize();

                $.post(url, values, function(data){
                    data = data.trim();
                    $('#sicAttOutput').html(data);

                });


                return false;
            });


        });
    </script>



<?php
    include_once('footer.php');




            }else{
    header('Location: index.php');

} ?>
<?php mysqli_close($connection); ?>
            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="scroll.js"></script>
        <script type="text/javascript" src="jquery.js"></script>
            <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
