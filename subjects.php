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
    }
if(isset($_POST['submitExcelFile'])){


    $excelFile = $_FILES['excelFile']['name'];
    $excelFile_tmp = $_FILES['excelFile']['tmp_name'];

    move_uploaded_file($excelFile_tmp, 'excel/'.$excelFile);

    include ("PHPExcel/IOFactory.php");
    $objPHPExcel = PHPExcel_IOFactory::load("excel/".$excelFile);
    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
    {
        $highestRow = $worksheet->getHighestRow();
        for ($row=2; $row<=$highestRow; $row++)
        {
            $subname = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
            $sub_code = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
            if(isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
                $dept_id = $deo['dept_id'];
            }else {
                $dept_id = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
            }
            $semester = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
            $theorych = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
            $practicalch = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(5, $row)->getValue());

            $sql = "INSERT INTO subjects(dept_id, semester, subject, course_code, theory_ch, practical_ch) VALUES ('".$dept_id."', '".$semester."', '".$subname."', '".$sub_code."', '".$theorych."', '".$practicalch."')";
            mysqli_query($connection, $sql);


        }
    }
    unlink('excel/'.$excelFile);
}


    ?>
    <div class="container-fluid profileHeading">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="sub-header" id="sub-header">Subjects</h2>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-primary btn-large showSubjects buttonSize">Show Subjects</button>
            <button class="btn btn-success btn-large addSubjects buttonSize">Add Subjects</button>
            <br>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->



    <div class="row">
        <div class="col-lg-12 subjectShow">

            <form action="<?php echo htmlentities('insert_subjects.php') ?>" method="post" name="showSubject" id="showSubject" class="form-inline">



                <select name="subjectDepart" id="subjectDepart" class="form-control" required>
                    <option value="">Select Department</option>
                    <?php
                    if(isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
                        $queryDepart = mysqli_query($connection, "SELECT * FROM department where dept_id='".$deo['dept_id']."'");
                    }else {
                        $queryDepart = mysqli_query($connection, 'SELECT * FROM department');
                    }
                    while($row = mysqli_fetch_assoc($queryDepart)){
                        echo "<option value='".$row['dept_id']."'>".$row['dept_name']."</option>";
                    }

                    ?>
                </select>

                <select name="subjectSemester" id="subjectSemester" class="form-control" required>
                    <option value="">Select Semester</option>
                    <?php
                    $querySemester = mysqli_query($connection, 'SELECT * FROM semester');

                    while($row = mysqli_fetch_assoc($querySemester)){
                        echo "<option value='".$row['semester_id']."'>".$row['semester_name']."</option>";
                    }

                    ?>
                </select>
                <button class="btn btn-info" type="submit" id="subjectSubmit" name="subjectSubmit">GO!</button>
            </form>


                <div id="subjectOutput"></div>

        </div>
        <!-- /.col-lg-12 subjectShow -->
    </div>
    <!-- /.row -->






        <div class="row">


        <div class="col-sm-12 subjects">

            <br>

            <script>

                $(function(){

                    $('#checkSubType').change(function(){

                        $('#subjectInsert').show('slow');

                        val = $( "#checkSubType option:selected" ).val();
                        if(val == 'theory'){
                         $('#practicalCH').val(0);
                        }else{
                            $('#practicalCH').val(1);
                        }
                    });
                });


            </script>
            <form action="<?php echo htmlspecialchars('subjects.php'); ?>" id="addExcelSubject" method="post" enctype="multipart/form-data" name="addExcelSubject">

                <label class="btn btn-success btn-file btnFileLabel">
           <span class="fa fa-file-excel-o" aria-hidden="true"> Import from Excel File<span><input id="excelFile" name="excelFile" type="file">
                </label>
                <input type="submit" value="submit" name="submitExcelFile"  id="submitExcelFile">
            </form>
            <span id="errorExcel"></span>
          <div class="form-group">
              <label for="checkSubType">Select Subject Type</label>
              <select name="checkSubType" id="checkSubType" class="form-control">
                  <option value="">Please Select</option>
                  <option value="theory">Theory</option>
                  <option value="both">Theory & Practical</option>
              </select>
          </div>

            <form action="<?php echo htmlentities('insert_subjects.php') ?>" method="post" id="subjectInsert">



                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="subjectName">Subject Name</label>
                            <input type="text" class="form-control" id="subjectName" name="subjectName" placeholder="" autofocus required>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="subjectCH">Credit Hours</label>
                            <select name="subjectCH" id="subjectCH" class="form-control" required>
                                <option value="">Select</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="subjectCode">Subject Code</label>
                            <input type="text" class="form-control" id="subjectCode" name="subjectCode" placeholder="" required>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="subjectDepartment">Department</label>
                            <select name="subjectDepartment" id="subjectDepartment" class="form-control" required>
                                <?php
                                if(isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
                                    $query = mysqli_query($connection, "SELECT * FROM department where dept_id='".$deo['dept_id']."'");
                                }else {
                                    $query = mysqli_query($connection, 'SELECT * FROM department');
                                }
                                    while($row = mysqli_fetch_assoc($query)):
                                        echo "<option value='".$row['dept_id']."'>".$row['dept_name']."</option>";
                                    endwhile;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="subjectSemester">Semester</label>
                            <select name="subjectSemester" id="subjectSemester" class="form-control" required>
                                <?php
                                $query = mysqli_query($connection, 'SELECT * FROM semester');
                                while($row = mysqli_fetch_assoc($query)):
                                    echo "<option value='".$row['semester_id']."'>".$row['semester_name']."</option>";
                                endwhile;
                                ?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-1">
                        <button class="btn btn-primary insertSubjectBtn" type="submit">Insert Subject!</button>
                    </div>
                    <span class="error_msg"></span>

                </div>
                <input type="hidden" name="practicalCH" id="practicalCH" >
            </form>

        </div>
    </div>
</div>

    <!-- Modal Edit -->
    <div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="myModalLabel">EDIT SUBJECT</h3>
                </div>
                <div class="modal-body">

                    <form action="<?php echo htmlentities('insert_subjects.php'); ?>" method="post" id="editSubjectForm">

                        <div class="row">
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label for="editSubName">Subject Name</label>
                                    <input type="text" name="editSubName" id="editSubName" class="form-control">
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="editSubCode">Subject Code</label>
                                    <input type="text" name="editSubCode" id="editSubCode" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="editSubDepart">Department</label>
                                    <select name="editSubDepart" id="editSubDepart" class="form-control">
                                        <?php
                                        $queryDepart = mysqli_query($connection, 'SELECT * FROM department');

                                        while($row = mysqli_fetch_assoc($queryDepart)){
                                            echo "<option value='".$row['dept_id']."'>".$row['dept_name']."</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="editSubSemester">Semester</label>
                                    <select name="editSubSemester" id="editSubSemester" class="form-control">
                                        <?php
                                        $querySemester = mysqli_query($connection, 'SELECT * FROM semester');

                                        while($row = mysqli_fetch_assoc($querySemester)){
                                            echo "<option value='".$row['semester_id']."'>".$row['semester_name']."</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="editSubjectCH">Credit Hours</label>
                                    <select name="editSubjectCH" id="editSubjectCH" class="form-control" required>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div id="editSubMsg"></div>
                            </div>
                        </div>
                        <input type="hidden" name="editSubId" id="editSubId">
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="editBtnSubject">Update changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal CONFIRM DELETE-->
    <div class="modal animated flipInX" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-danger" id="myModalLabel">ALERT</h4>
                </div>
                <div class="modal-body  text-center">

                    <form action="<?php echo htmlentities('insert_subjects.php'); ?>" method="post" id="submitDeleteSubForm">
                        <input type="hidden" name="submitDeleteSub" id="submitDeleteSub">
                    </form>

                    <h2 id="sureText">Are you sure?</h2>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="deleteYes">DELETE</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal  DELETED-->
    <div class="modal animated flipInX" id="myModalDeleted" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-danger" id="myModalLabel">ALERT</h4>
                </div>
                <div class="modal-body  text-center">

                    <h1 class="text-danger">Subject has been deleted successfully.</h1>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="deletedModalClose">Close</button>
                </div>
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


            $('#editBtnSubject').click(function(){
                $(this).prop('disabled', true);
                $('#editSubjectForm').submit();
                scroll();

            });


            $('#deleteYes').click(function(){
                    $("#submitDeleteSubForm").submit();
            });

            $('#submitDeleteSubForm').submit(function(){

                var url, values;


                url = $(this).attr('action');
                values = $(this).serialize();



                $.ajax({

                    type: 'POST',
                    url: url,
                    data: values,
                    success:function(data){
                        data = data.trim();
                        if(data == 'deleted'){
                            $('#myModalDelete').modal('hide');
                            $('#myModalDeleted').modal('show');
                            $('#deletedModalClose').focus();
                        }
                    }

                });
                return false;
            });


            $('#myModalDeleted').on('hidden.bs.modal', function () {
                $('#subjectSubmit').click();
            });

            $('#editSubjectForm').submit(function(){

                var url, values;

                url = $(this).attr('action');
                values = $(this).serialize();

                $('#editSubMsg').html('<i class="fa fa-2x fa-spinner fa-pulse animated flip"></i>');

                var dept, semester;
                dept = $('#editSubDepart').val();
                semester = $('#editSubSemester').val();


                $.ajax({

                    type: 'POST',
                    url: url,
                    data: values,
                    success:function(data){
                        data = data.trim();
                        if(data == 'updated'){
                            $('#editSubMsg').show().addClass('btn btn-success animated bounceInLeft').text('Data has been updated successfully.');
                                setTimeout(function(){
                                $('#myModalEdit').modal('hide');
                                $('#subjectDepart').val(dept);
                                $('#subjectSemester').val(semester);
                                $('#subjectSubmit').click();
                                $('#editSubMsg').hide();
                                $('#editBtnSubject').prop('disabled', false);
                                scroll();
                                }, 2500);
                        }

                    }

                });

                return false;

            });


            $('#showSubject').submit(function(){


                var url, values;

                url = $(this).attr('action');
                values = $(this).serialize();

                $.ajax({

                    type: 'POST',
                    url: url,
                    data: values,
                    success: function(data){
                        $('#subjectOutput').html(data);
                        $('#subjectDepart').focus();
                        scroll();


                        $('.td_btnEdit').click(function(){

                            var row = $(this).closest('tr');
                            var rowID = row.attr('class').split('_')[1];
                            var subject =  row.find('.subject').text();
                            var course_code =  row.find('.course_code').text();
                            var semester =  row.find('.semester').text();
                            var theoryCH =  row.find('.theoryCH').text();
                            var dept_id =  row.find('.dept_id').text();


                            $('#editSubName').val(subject);
                            $('#editSubCode').val(course_code);
                            $('#editSubDepart').val(dept_id);
                            $('#editSubSemester').val(semester);
                            $('#editSubjectCH').val(theoryCH);
                            $('#editSubId').val(rowID);

                            $('#myModalEdit').modal('show');
                            $('#myModalEdit #editSubName').focus();

                        });

                        $('.td_btnDelete').click(function(){

                            var row = $(this).closest('tr');
                            var rowID = row.attr('class').split('_')[1];
                            $('#submitDeleteSub').val(rowID);
                            $('#myModalDelete').modal('show');
                            $('#deleteYes').focus();
                        });

                    }

                });


                return false;

            });


            $('.showSubjects').click(function(){
                $(this).hide('slow');
                $('.addSubjects').hide('slow');
                $('.subjects').hide('slow');
                $('.subjectShow').show('slow');
                $('#subjectDepart').focus();
            });


            $('.addSubjects').click(function(){
                $(this).hide('slow');
                $('.showSubjects').hide('slow');
                $('#subjectName').focus();
                $('.subjectShow').hide('slow');
               $('.subjects').show('slow');
            });


            $('#excelFile').change(function(){
                var file = this.files[0];
                var imagefile = file.type;
                if(imagefile === 'application/vnd.ms-excel'){
                    $('#spinner').show();
                    $('#submitExcelFile').click();
                }else{
                    $(this).val('');
                    $('#errorExcel').text('Excel file is accepted only.').fadeIn('slow').delay('2000').fadeOut('slow');
                }
            });

                $('#subjectInsert').submit(function(){

                    var values = $(this).serialize();
                    var url = $(this).attr('action');

                    $('.insertSubjectBtn').prop('disabled', true);

                    function insertBtnEnable(){
                        setTimeout(function(){
                            $('.insertSubjectBtn').prop('disabled', false);
                        }, 3000);
                    }

                    insertBtnEnable();


                    $('.error_msg').html('<i class="fa fa-2x fa-spinner fa-pulse animated flip"></i>');

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: values,
                        success:function(data){
                            if(data.trim() == 'exists'){
                                $('.error_msg').html('<a class="btn btn-danger animated flash">Subject already exists.</a>');
                                $('#subjectCode').focus();
                            }else if(data.trim() == 'inserted'){
                                $('.error_msg').html('<a class="btn btn-success animated bounceInLeft">Subject has been inserted successfully.</a>');
                                $('#subjectName').focus();
                                hideOut();
                            }
                        }
                    });

                    return false;

                });

                function hideOut(){
                    if($('.error_msg a').hasClass('bounceInLeft')){
                        setTimeout(function(){
                            $('.error_msg a').addClass('bounceOutRight');
                            $('#subjectInsert')[0].reset();
                        }, 3000);
                    }
                }


        });
    </script>
<?php }else{
    header('Location: index.php');
} ?>
