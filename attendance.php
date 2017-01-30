<?php session_start(); ?>

<?php if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])){ ?>

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


<!-- Button trigger modal -->
    <div class="container-fluid profileHeading">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="sub-header" id="sub-header">Attendance</h2>
            </div>
        </div>


        <button class="btn btn-info btn-large buttonSize" id="viewAttAll">View Attendance</button>
        <button class="btn btn-success btn-large buttonSize" id="insertAtt"  >Insert Attendance</button>
        <button class="btn btn-primary btn-large buttonSize" id="viewAtt">Update Attendance</button>
        <div class="attendance">
            <div class="row">

                    <form action="<?php echo htmlentities('attendance_validate.php'); ?>" method="post" id="attendanceFormView">

                                <div class="col-lg-1 attendanceInfo">
                                    <input class="form-control" type="text" name="date" id="date" placeholder="Date" title="Please Select Date" readonly>
                                </div>
                                <div class="col-lg-2 attendanceInfo">
                                    <select name="timing" id="timing" class="form-control" required>
                                        <option value="">Select Timing</option>
                                        <option value="9to10">9:00 to 10:00</option>
                                        <option value="10to11">10:00 to 11:00</option>
                                        <option value="11to12">11:00 to 12:00</option>
                                        <option value="12to13">12:00 to 13:00</option>
                                        <option value="13to14">13:00 to 14:00</option>
                                        <option value="14to15">14:00 to 15:00</option>
                                        <option value="15to16">15:00 to 16:00</option>
                                    </select>
                                </div>

                                  <div class="col-lg-3 attendanceInfo">
                                    <select name="department" id="department" class="form-control" required>
                                        <option value="">Select Department</option>

                                        <?php
if(isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
$queryDepartment = mysqli_query($connection, "SELECT * FROM department where dept_id='".$deo['dept_id']."'");
}else{

                                        $queryDepartment = mysqli_query($connection, "SELECT * FROM department");}

                                        $allDepart = array();
                                        while($row = mysqli_fetch_assoc($queryDepartment)){
                                            $dept = array(
                                                'dept_id' => $row['dept_id'],
                                                'dept_name' => $row['dept_name']
                                            );
                                                    echo "<option value='".$row['dept_id']."'>".$row['dept_name']."</option>";

                                            $allDepart[] = $dept;

                                        }
                                         ?>

                                    </select>

                                     </div>
                                <div class="col-lg-1 attendanceInfo">
                                    <select name="batch" id="batch" class="form-control" required>
                                        <option value="">Batch</option>

                                        <?php


                                        $batchQuery = 'SELECT * FROM batch';
                                        $batchQueryRun = mysqli_query($connection, $batchQuery);

                                        while($row = mysqli_fetch_assoc($batchQueryRun)) {
                                            $batchName = $row['batch_no'];

                                            echo "<option value='$batchName'>$batchName</option>";

                                        }



                                        ?>
                                    </select>

                                </div>

                                <div class="col-lg-2 attendanceInfo">
                                    <select class="form-control" name="semester" id="semester" required>
                                        <option value="">Select Semester</option>

                                        <?php

                                $semesterQuery = 'SELECT * FROM semester';
                                $semesterQueryRun = mysqli_query($connection, $semesterQuery);

                                while($row = mysqli_fetch_assoc($semesterQueryRun)) {

                                    $semesterName = $row['semester_name'];
                                    $semesterId = $row['semester_id'];
                                    echo "<option value='$semesterId'>$semesterName</option>";

                                }



                                ?>
                                    </select>
                                </div>

                                <div class="col-lg-2 attendanceInfo">
                                    <select class="form-control" name="subject" id="subject" title="Please select subject" required>
                                          <option value=''>Select Subject</option>

                                      </select>
                                </div>
                                <div class="col-lg-1 attendanceInfo">
                                    <input type="submit" value="GO!" name="attViewSubmitBtn" id="attViewSubmitBtn" class="btn btn-primary">
                                </div>
                    </form>




        </div>

            <div class="row">
                <div class="col-lg-12">
                    <div id="outputView"></div>
                    <div id="attOutputView"></div>
                    <div id="submitAttView">
                        <button class="btn btn-primary" id="attInsertView">Update Attendance</button>
                        <span id="submitAttMsgView"></span>
                    </div>
                </div>
            </div>


        </div>


        <div class="insertAttendance">
            <div class="row">

                    <form action="<?php echo htmlentities('attendance_validate.php'); ?>" method="post" id="attendanceForm">

                                <div class="col-lg-1 attendanceInfo">
                                    <input class="form-control" type="text" name="insertDate" id="datepicker" placeholder="Date" title="Please Select Date" readonly>
                                </div>
                                <div class="col-lg-2 attendanceInfo">
                                    <select name="insertTiming" id="insertTiming" class="form-control" required>
                                        <option value="">Select Timing</option>
                                        <option value="9to10">9:00 to 10:00</option>
                                        <option value="10to11">10:00 to 11:00</option>
                                        <option value="11to12">11:00 to 12:00</option>
                                        <option value="12to13">12:00 to 13:00</option>
                                        <option value="13to14">13:00 to 14:00</option>
                                        <option value="14to15">14:00 to 15:00</option>
                                        <option value="15to16">15:00 to 16:00</option>
                                    </select>
                                </div>

                                  <div class="col-lg-3 attendanceInfo">
                                    <select name="insertDepartment" id="insertDepartment" class="form-control" required>
                                        <option value="">Select Department</option>

                                        <?php

                                            foreach($allDepart as $depart){
                                                    echo "<option value='".$depart['dept_id']."'>".$depart['dept_name']."</option>";
                                            }


                                         ?>

                                    </select>

                                     </div>
                                <div class="col-lg-1 attendanceInfo">
                                    <select name="insertBatch" id="insertBatch" class="form-control" required>
                                        <option value="">Batch</option>

                                        <?php


                                        $batchQuery = 'SELECT * FROM batch';
                                        $batchQueryRun = mysqli_query($connection, $batchQuery);

                                        while($row = mysqli_fetch_assoc($batchQueryRun)) {
                                            $batchName = $row['batch_no'];

                                            echo "<option value='$batchName'>$batchName</option>";

                                        }



                                        ?>
                                    </select>

                                </div>

                                <div class="col-lg-2 attendanceInfo">
                                    <select class="form-control" name="insertSemester" id="insertSemester" required>
                                        <option value="">Select Semester</option>

                                        <?php

                                $semesterQuery = 'SELECT * FROM semester';
                                $semesterQueryRun = mysqli_query($connection, $semesterQuery);

                                while($row = mysqli_fetch_assoc($semesterQueryRun)) {

                                    $semesterName = $row['semester_name'];
                                    $semesterId = $row['semester_id'];
                                    echo "<option value='$semesterId'>$semesterName</option>";

                                }



                                ?>
                                    </select>
                                </div>

                                <div class="col-lg-2 attendanceInfo">
                                    <select class="form-control" name="insertSubject" id="insertSubject" title="Please select subject" required>
                                          <option value=''>Select Subject</option>

                                      </select>
                                </div>
                                <div class="col-lg-1 attendanceInfo">
                                    <input type="submit" value="GO!" name="attSubmitBtn" id="attSubmitBtn" class="btn btn-primary">
                                </div>
                    </form>

                </div>

                    <div id="output"></div>
                    <div id="attOutput"></div>
                    <div id="submitAtt">
                        <button class="btn btn-primary" id="attInsert">Submit Attendance</button>
                        <span id="submitAttMsg"></span>
                    </div>

        </div>


        <div class="viewAttendance">
            <div class="row">

                <form action="<?php echo htmlentities('attendance_validate.php'); ?>" method="post" id="viewAttendanceAll">


                    <div class="col-lg-3 attendanceInfo">
                        <select name="viewDepartmentAll" id="viewDepartmentAll" class="form-control" required>
                            <option value="">Select Department</option>

                            <?php

                            foreach($allDepart as $depart){
                                echo "<option value='".$depart['dept_id']."'>".$depart['dept_name']."</option>";
                            }


                            ?>

                        </select>

                    </div>
                    <div class="col-lg-2 attendanceInfo">
                        <select name="viewBatchAll" id="viewBatchAll" class="form-control" required>
                            <option value="">Batch</option>

                            <?php


                            $batchQuery = 'SELECT * FROM batch';
                            $batchQueryRun = mysqli_query($connection, $batchQuery);

                            while($row = mysqli_fetch_assoc($batchQueryRun)) {
                                $batchName = $row['batch_no'];

                                echo "<option value='$batchName'>$batchName</option>";

                            }



                            ?>
                        </select>

                    </div>

                    <div class="col-lg-2 attendanceInfo">
                        <select class="form-control" name="viewSemesterAll" id="viewSemesterAll" required>
                            <option value="">Select Semester</option>

                            <?php

                            $semesterQuery = 'SELECT * FROM semester';
                            $semesterQueryRun = mysqli_query($connection, $semesterQuery);

                            while($row = mysqli_fetch_assoc($semesterQueryRun)) {

                                $semesterName = $row['semester_name'];
                                $semesterId = $row['semester_id'];
                                echo "<option value='$semesterId'>$semesterName</option>";

                            }



                            ?>
                        </select>
                    </div>

                    <div class="col-lg-1 attendanceInfo">
                        <input type="submit" value="GO!" name="attSubmitBtn" id="attSubmitBtn" class="btn btn-primary">
                    </div>
                </form>

            </div>

                <div id="submitAttMsgViewAll"></div>
            </div>

        </div>



    </div>







    <?php include_once('footer.php'); ?>

<div id="spinner">
            </div>

                <script src="spinnerLoading.js"></script>
    <script src="scroll.js"></script>

    <script>

        $(document).ready(function(){


            /* VIEW ALL ATTENDANCE */


            $('#viewAttAll').click(function(){
                $(this).addClass('animated bounceOut').hide('slow');
                $('#insertAtt, #viewAtt').addClass('animated bounceOut').hide('slow');
                $('.viewAttendance').addClass('animated bounceIn').show('slow');
                $('#sub-header').text('View Attendance');
                $('#viewDepartmentAll').focus();
                scroll();
            });


            $('#viewAttendanceAll').submit(function(e){

                e.preventDefault();


                var url, values;

                url = $(this).attr('action');
                values = $(this).serialize();
                 $('#submitAttMsgViewAll').show().html('<i class="fa fa-2x fa-spinner fa-pulse animated flip"></i>');


                $.post(url, values, function(data){
                data = data.trim();
                    $('#submitAttMsgViewAll').html(data);


                });




            });






            /*VIEW ATTENDANCE CODE*/

            $('#date').datepicker({ minDate: -6, maxDate: 0 });


            $('#viewAtt').click(function(){
                $(this).addClass('animated bounceOut').hide('slow');
                $('#insertAtt, #viewAttAll').addClass('animated bounceOut').hide('slow');
                $('.attendance').addClass('animated bounceIn').show('slow');
                $('#sub-header').text('Update Attendance');
                scroll();
            });


            $('#department').change(function(){
                var semester_value, depart_value;
                depart_value = $(this).val();
                semester_value = $('#semester').val();
                getSubjectsView(depart_value, semester_value);

            });

            $('#semester').change(function(){
                var semester_value, depart_value;
                semester_value = $(this).val();
                depart_value = $('#department').val();
                getSubjectsView(depart_value, semester_value);

            });


            function getSubjectsView(depart_value, semester_value){
                $.ajax({
                    type: 'POST',
                    url: 'attendance_getSubjects.php',
                    data: {
                        'depart_value' : depart_value,
                        'semester_value' : semester_value
                    },
                    success:function(data){
                        data = data.trim();
                        $('#subject').html(data);
                    }
                });
            }


            $('#attendanceFormView').submit(function(e){

                scroll();
                e.preventDefault();

                $('#submitAttMsgView, #attInsertView').hide('slow');

                var values, url;

                url = $(this).attr('action');
                values = $(this).serialize();

                $.ajax({

                    type: 'POST',
                    url: url,
                    data: values,
                    success: function(data){
                        data = data.trim();
                        if(data != 'noResult'){
                        $('#outputView').html(data).show();
                            totalCheck();
                        }else{
                            $('#outputView').html('<h2 class="animated flash text-danger">Attendance has not been inserted for this class yet.</h2>').show();
                        }

                        $('.btnUpdate').click(function(){
                                $(this).addClass('animated bounceOutLeft').hide('slow');
                                $('.btnUpdatePresent, .btnUpdateAbsent, .insertButton').prop('disabled', false);
                                $('#attInsertView').addClass('animated bounceInRight').show('slow').prop('disabled', false);

                                   $('.insertButton').each(function(){
                                       if($(this).hasClass('student_absent')){
                                           $(this).css('background-color', '#fff');
                                       }
                                   });

                                totalCheck();
                        });


                        $('.allPresent').click(function(){
                            $('.insertButton').removeClass('student_absent').addClass('student_present').css('background-color', '#1fd20f');
                            $('#submitAttView').addClass('animated lightSpeedIn').show();
                            totalCheck();
                        });

                        $('.allAbsent').click(function(){
                            $('.insertButton').removeClass('student_present').addClass('student_absent').css('background-color', '#fff');
                            $('#submitAttView').addClass('animated lightSpeedIn').show();
                            totalCheck();
                        });



                        $('.insertButton').click(function(){
                            $(this).css('background-color', '#1fd20f').addClass('student_present').removeClass('student_absent');
                            totalCheck();
                            $('#submitAttView').addClass('animated lightSpeedIn').show();
                        });

                        $('.insertButton').dblclick(function(){
                            $(this).css('background-color', '#fff').removeClass('student_present');
                            totalCheck();
                        });


                        function totalCheck(){
                            var total;
                            total = $('.insertButton').length;

                            var student_present = $('.student_present');
                            $('#attOutputView').show().html("<h3 class='animated flipInX'>Total Present: " + student_present.length  + " / " + total + "</h3>");
                        }


                    }
                });
            });

            $('#attInsertView').click(function(){

                scroll();

                $('#attViewSubmitBtn').prop('disabled', true);

                var insertButton = $('.insertButton');


                insertButton.each(function(){

                    if(!$(this).hasClass('student_present')){
                        $(this).css('background-color', '#ff5234').addClass('student_absent');
                    }

                });

                var presentRollNo = [];


                $('.student_present').each(function(){
                    presentRollNo.push($(this).text()+"_present"+"_"+$(this).attr('row-id'));
                });


                var absentRollNos = [];

                $('.student_absent').each(function(){
                    absentRollNos.push($(this).text()+"_absent"+"_"+$(this).attr('row-id'));
                });

                $('button#attInsertView').prop('disabled', true);
                $('#submitAttMsgView').show().html('<i class="fa fa-2x fa-spinner fa-pulse animated flip"></i>');
                insertButton.prop('disabled', true);
                $('.allPresent, .allAbsent').prop('disabled', true);


                $.ajax({
                    type: 'POST',
                    url: 'insert_attendance.php',
                    data: {
                        'updatePresentRollNo' : presentRollNo,
                        'updateAllRollNos' : insertButton.length,
                        'updateAbsentRollNos' : absentRollNos,
                        'updateDate': $('#date').val(),
                        'updateTiming': $('#timing').val(),
                        'updateDepartment': $('#department').val(),
                        'updateBatch': $('#batch').val(),
                        'updateSemester': $('#semester').val(),
                        'updateSubject': $('#subject').val()
                    },
                    success:function(result){
                        if(result.trim() == 'updated'){
                            $('#submitAttMsgView').show().html('<button class="animated bounceInLeft btn btn-success">Attendance has been updated successfully.</button>');
                            $('#date, #timing, #batch, #semester, #submitAtt, #department').change(function(){
                                $('#outputView, #attOutputView, #submitAttView, #submitAttMsgView').hide('slow');
                            });
                            setTimeout(function(){
                                $('#attViewSubmitBtn').prop('disabled', false);
                            }, 2000);
                        }
                    }
                });
            });





            /* INSERT ATTENDANCE CODE*/

            $('#datepicker').datepicker({ minDate: -6, maxDate: 0});




            $('#insertDepartment').change(function(){
                var semester_value, depart_value;
                depart_value = $(this).val();
                semester_value = $('#insertSemester').val();
                getSubjects(depart_value, semester_value);

            });

            $('#insertSemester').change(function(){
                var semester_value, depart_value;
                semester_value = $(this).val();
                depart_value = $('#insertDepartment').val();
                getSubjects(depart_value, semester_value);

            });


            function getSubjects(depart_value, semester_value){
                $.ajax({
                    type: 'POST',
                    url: 'attendance_getSubjects.php',
                    data: {
                        'depart_value' : depart_value,
                        'semester_value' : semester_value
                    },
                    success:function(data){
                        data = data.trim();
                        $('#insertSubject').html(data);
                    }
                });
            }



        $('#attendanceForm').submit(function(e){

            scroll();
            e.preventDefault();


            var values, url;

            url = $(this).attr('action');
            values = $(this).serialize();

            $('button#attInsert').prop('disabled', false);


            $.ajax({

                type: 'POST',
                url: url,
                data: values,
                success: function(data){

                    data = data.trim();
                    if(data == 'alreadyInserted'){
                        $('#output').show().html('<h2 class="text-danger animated flash">Attendance has already been inserted for this class.</h2>');
                        $('#attOutput, #submitAtt').hide('slow');
                    }else{
                        $('#output').show().html(data)
                    }
;



                    $('.allPresent').click(function(){
                        $('.insertButton').removeClass('student_absent').addClass('student_present').css('background-color', '#1fd20f');
                        $('#submitAtt').addClass('animated lightSpeedIn').show();
                        totalCheck();
                    });

                    $('.allAbsent').click(function(){
                        $('.insertButton').removeClass('student_present').addClass('student_absent').css('background-color', '#fff');
                        $('#submitAtt').addClass('animated lightSpeedIn').show();
                        totalCheck();
                    });

                    var total;
                    total = $('.insertButton').length;



                    $('.insertButton').click(function(){
                        $(this).css('background-color', '#1fd20f').addClass('student_present').removeClass('student_absent');
                        totalCheck();
                        $('#submitAtt').addClass('animated lightSpeedIn').show();
                    });

                    $('.insertButton').dblclick(function(){
                        $(this).css('background-color', '#fff').removeClass('student_present');
                        totalCheck();
                    });


                    function totalCheck(){
                        var student_present = $('.student_present');
                        $('#attOutput').show().html("<h3 class='animated flipInX'>Total Present: " + student_present.length  + " / " + total + "</h3>");
                    }
                }
        });
        });





            $('#attInsert').click(function(){

                scroll();

                var insertButton = $('.insertButton');


                insertButton.each(function(){

                    if(!$(this).hasClass('student_present')){
                        $(this).css('background-color', '#ff5234').addClass('student_absent');
                    }

                });


                var presentRollNo = [];


                $('.student_present').each(function(){
                    presentRollNo.push($(this).text()+"_present");
                });


                var absentRollNos = [];

                $('.student_absent').each(function(){
                    absentRollNos.push($(this).text()+"_absent");
                });

                $('button#attInsert').prop('disabled', true);
                $('#submitAttMsg').show().html('<i class="fa fa-2x fa-spinner fa-pulse animated flip"></i>');
                insertButton.prop('disabled', true);
                $('.allPresent, .allAbsent').prop('disabled', true);


                $.ajax({
                    type: 'POST',
                    url: 'insert_attendance.php',
                    data: {
                        'presentRollNo' : presentRollNo,
                        'allRollNos' : insertButton.length,
                        'absentRollNos' : absentRollNos,
                        'date': $('#datepicker').val(),
                        'timing': $('#insertTiming').val(),
                        'department': $('#insertDepartment').val(),
                        'batch': $('#insertBatch').val(),
                        'semester': $('#insertSemester').val(),
                        'subject': $('#insertSubject').val()
                    },
                    success:function(result){
                        if(result.trim() == 'inserted'){
                        $('#submitAttMsg').show().html('<button class="animated bounceInLeft btn btn-success">Attendance has been inserted successfully.</button>');
                            $('#datepicker, #insertTiming, #insertBatch, #insertSemester, #insertSubject, #insertDepartment').change(function(){
                                $('#output, #attOutput, #submitAtt, #submitAttMsg').hide('slow');
                            });
                        }
                    }
                });
            });




            $('#insertAtt').click(function(){
                $(this).addClass('animated bounceOut').hide('slow');
                $('#viewAtt, #viewAttAll').addClass('animated bounceOut').hide('slow');
                $('.insertAttendance').addClass('animated bounceIn').show('slow');
                $('#sub-header').text('Insert Attendance');

                scroll();
            });

        });


</script>

<?php }else{
    header('Location: index.php');
} ?>