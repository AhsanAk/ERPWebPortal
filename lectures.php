<?php session_start(); ?>

<?php if(isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])||isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['student'])||isset($_SESSION['student'])){ ?>

    <?php include_once('includes/connection.php') ?>
    <?php include_once('header.php');

    if(isset($_COOKIE['name'])||isset($_SESSION['name'])){
        include_once('navbar.php'); }

    else if(isset($_COOKIE['student'])||isset($_SESSION['student'])){
        include_once('navbar_student.php'); }

    else if(isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])){
        include_once('navbar_teacher.php'); }?>



    <div class="container-fluid profileHeading">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="sub-header" id="sub-header">Lectures</h2>
                <?php if(isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])){ ?>
                    <button class="btn btn-primary" id="addAssignment">Add New</button>

                    <form action="<?php echo htmlentities('insert_lectures.php') ?>" id="insertAssignment" name="insertAssignment" method="post" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="assignmentTitle">Lecture Title</label>
                                    <input type="text"  name="assignmentTitle" id="assignmentTitle" maxlength="40" class="form-control" autofocus required>
                                </div>
                            </div>
                            <?php
                            $query_depart = mysqli_query($connection, "select * from teachers where id ='".$_SESSION['teacher']."' ");
                            while($rowDept=mysqli_fetch_assoc($query_depart)){
                                echo "<input type='hidden' name='assignmentDepart' id='assignmentDepart' value='".$rowDept['dept_id']."'>";
                            }?>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="assignmentSubject">Subject</label>
                                    <input type="text" name="assignmentSubject" id="assignmentSubject"  maxlength="32" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="assignmentDeadline">Date</label>
                                    <input type="text" class="form-control" id="assignmentDeadline" name="assignmentDeadline" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="assignmentSemester">Semester</label>
                                    <select name="assignmentSemester" id="assignmentSemester" class="form-control">
                                        <option value="">Please Select</option>
                                        <?php $query_semester = mysqli_query($connection, "select * from semester");
                                        while($rowSemester = mysqli_fetch_assoc($query_semester)){?>
                                            <option value="<?php echo $rowSemester['semester_id']; ?>"><?php echo $rowSemester['semester_name']; ?></option>
                                        <?php }?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="assignmentBatch">Batch</label>
                                    <select name="assignmentBatch" id="assignmentBatch" class="form-control">
                                        <option value="">Please Select</option>
                                        <?php $query_batch = mysqli_query($connection, "select * from batch");
                                        while($rowBatch = mysqli_fetch_assoc($query_batch)){?>
                                            <option value="<?php echo $rowBatch['batch_id']; ?>"><?php echo $rowBatch['batch_no']; ?></option>
                                        <?php }?>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="assignmentFile">Assignment File</label>
                                    <input type="file" name="assignmentFile" id="assignmentFile" accept="image/*, .pdf" required>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="assignmentDesp">Assignment Description</label>
                                    <textarea name="assignmentDesp" id="assignmentDesp" cols="30" rows="3" class="form-control" required></textarea>
                                </div>
                            </div>

                        </div>
                        <div id="submitAssignment">
                            <button class="btn btn-primary" id="assignmentInsert" type="submit">Submit</button>
                            <span class="rono_err btn btn-danger pull-right"></span><i class="fa fa-spinner fa-pulse insert_loading pull-right"></i>
                        </div>

                        <div id="outputAssignment"></div>

                    </form>
                <?php } ?>
                <!-- Modal View -->
                <div class="modal fade" id="myModalView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h2 class="modal-title text-primary text-center" id="myModalLabelView"></h2>
                            </div>

                            <div class="modal-body">

                                <h3>Semester</h3>
                                <p class="lead" id="viewAssignmentSemester"></p>

                                <h3>Batch</h3>
                                <p class="lead" id="viewAssigmentBatch"></p>

                                <h3>Deadline</h3>
                                <p class="lead" id="viewAssignmentDeadline"></p>

                                <h3>Description</h3>
                                <p class="lead" id="viewAssignmentDesp"></p>

                                <h3>File</h3>
                                <p class="lead" id="viewAssignmentFile"></p>



                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])){ ?>
                    <!-- Modal Edit -->
                    <div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h2 class="modal-title text-primary text-center" id="myModalLabelEdit">EDIT Lecture</h2>
                                </div>
                                <div class="modal-body">

                                    <form action="<?php echo htmlentities('update_lectures.php') ?>" id="updateAssignment" name="updateAssignment" method="post">
                                        <div class="row">

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="updateAssignmentTitle">Title</label>
                                                    <input type="text"  name="updateAssignmentTitle" id="updateAssignmentTitle"  maxlength="40" class="form-control" autofocus required>
                                                </div></div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="updateAssignmentDeadline">Date</label>
                                                    <input type="text" class="form-control" id="updateAssignmentDeadline" name="updateAssignmentDeadline" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="updateAssignmentSemester">Semester</label>
                                                    <select name="updateAssignmentSemester" id="updateAssignmentSemester" class="form-control" required>

                                                        <?php $query_UpdateSemester = mysqli_query($connection, "select * from semester");
                                                        while($rowUpdateSemester = mysqli_fetch_assoc($query_UpdateSemester)){?>
                                                            <option value="<?php echo $rowUpdateSemester['semester_id']; ?>"><?php echo $rowUpdateSemester['semester_name']; ?></option>
                                                        <?php }?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="updateAssignmentBatch">Batch</label>
                                                    <select name="updateAssignmentBatch" id="updateAssignmentBatch" class="form-control" required>

                                                        <?php $query_UpdateBatch = mysqli_query($connection, "select * from batch");
                                                        while($rowUpdateBatch = mysqli_fetch_assoc($query_UpdateBatch)){?>
                                                            <option value="<?php echo $rowUpdateBatch['batch_id']; ?>"><?php echo $rowUpdateBatch['batch_no']; ?></option>
                                                        <?php }?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="assignmentFile">Lecture File</label>
                                                    <input type="file" name="assignmentFileUpdate" id="assignmentFileUpdate" accept="image/*, .pdf" required>
                                                </div>

                                            </div>

                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label for="updateAssignmentDesp">Description</label>
                                                    <textarea name="updateAssignmentDesp" id="updateAssignmentDesp" cols="30" rows="3" class="form-control" required></textarea>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-12">
                                        </div>

                                        <input type="hidden" name="updateId" id="updateId">
                                        <div id="submitAssignment" style="visibility: hidden;">

                                            <div style="margin-bottom:2px">a</div>
                                        </div>

                                </div>
                                <div class="modal-footer">

                                    <span class="pull-left" id="outputAssignmentUpdate"></span><button type="submit" class="btn btn-success" id="updateAssignmentBtn" >Update</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                                </div>

                                <?php
                                $query_depart = mysqli_query($connection, "select * from teachers where id ='".$_SESSION['teacher']."' ");
                                while($rowDept=mysqli_fetch_assoc($query_depart)){
                                    echo "<input type='hidden' name='depart_id' id='depart_id' value='".$rowDept['dept_id']."'>";
                                }
                                ?>
                                </form></div>
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

                                    <form action="<?php echo htmlentities('update_lectures.php'); ?>" method="post" id="submitDeleteAssignmentForm">
                                        <input type="hidden" name="submitDeleteAssignment" id="submitDeleteAssignment">
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

                                    <h1 class="text-danger">Assignment has been deleted successfully.</h1>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="deletedModalClose">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>



                <table class="table table-responsive table-bordered eventTable">
                    <tr>
                        <th>S.NO</th>
                        <th>Lecture title</th>
                        <th>Lecture Description</th>
                        <th>Semester</th>
                        <th>Batch</th>
                        <th>Lecture Date</th>
                        <th>Operations</th>

                    </tr>
                    <?php
                    $counter=0;
                    if(isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])) {
                        $assignmentquery = mysqli_query($connection, "Select * from lectures where dept_id='".$teacher['dept_id']."'");
                    }
                    else if(isset($_COOKIE['student'])||isset($_SESSION['student'])) {
                        $assignmentquery = mysqli_query($connection, "Select * from lectures where dept_batch='".$student['dept_batch']."' AND dept_id='".$student['dept_id']."'");
                    }
                    if(!mysqli_num_rows($assignmentquery) > 0){
                        echo "<tr>
                  <td colspan='8' class='animated flash text-info'>No Assignments.</td>
                  </tr>";
                    }else {
                    while($row=mysqli_fetch_assoc($assignmentquery)){
                    $counter=$counter+1;
                    $id = $row['id'];
                    $title = $row['title'];
                    $desp = $row['description'];
                    $semester = $row['semester'];
                    $batch = $row['dept_batch'];
                    $deadline = $row['date'];
                    $file = $row['lecture_file'];
                    $dept_id = $row['dept_id'];
                    ?>    <tbody>
                    <?php      echo "<tr class='trID_$id'>"; ?>
                    <td><?php echo $counter; ?></td>
                    <?php
                    echo "<td class='td_title'>$title</td>";
                    echo "<td class='td_desp'>".substr($desp, 0, 10)." ...</td>";
                    echo "<td class='td_despHidden'>$desp</td>";
                    echo "<td class='td_semester'>$semester</td>";
                    echo "<td class='td_batch'>$batch</td>";
                    echo "<td class='td_deadline'>$deadline</td>";
                    echo "<td class='td_file hidden'>$file</td>";
                    echo "<td class='td_dept hidden'>$dept_id</td>";
                    ?>
                    <td><button  class="btn btn-primary btn-flat td_btnView" data-toggle="modal" title="view"><i class="fa fa-eye"></i></button>
                        <?php if(isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])){ ?>
                            <button class="btn btn-info btn-flat td_btnEdit"  data-toggle="modal" title="edit"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btn-flat td_btnDelete" title="remove"><i class="fa fa-trash-o"></i></button>
                        <?php } ?>
                    </td>
                    <?php
                    echo "</tr>";

                    }} ?>

                    </tbody>
                </table>

            </div>

        </div>
    </div>

    <div id="spinner">
    </div>

    <script src="spinnerLoading.js"></script>
    <script>

        $(document).ready(function(){

            $('#updateAssignment').submit(function(){


                var url,values;

                url = $(this).attr('action');
                values = new FormData(this);


                $('#outputAssignmentUpdate').html('<i class="fa fa-2x fa-spinner fa-pulse animated flip"></i>');
                $('#updateAssignmentBtn').prop('disabled', true);

                $.ajax({

                    type: 'POST',
                    url: url,
                    data: values,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success:function(data){
                        if(data.trim() == 'updated'){
                            $('#outputAssignmentUpdate').html('<p class="animated bounceInLeft text-success lead">Updated successfully.</p>');
                            setTimeout(function(){
                                window.location.href = 'lectures.php';
                            }, 2500);
                        }
                    }

                });


                return false;

            });



            $('.td_btnView').click(function(){

                var row = $(this).closest('tr');
                var title =  row.find('.td_title').text();
                var semester =  row.find('.td_semester').text();
                var batch =  row.find('.td_batch').text();
                var deadline =  row.find('.td_deadline').text();
                var desp =  row.find('.td_despHidden').text();
                var file =  row.find('.td_file').text();
                var dept =  row.find('.td_dept').text();


                $('#myModalLabelView').text(title.toUpperCase());
                $('#viewAssignmentSemester').text(semester);
                $('#viewAssigmentBatch').text(batch);
                $('#viewAssignmentDeadline').text(deadline);
                $('#viewAssignmentDesp').text(desp);
                $('#viewAssignmentFile').html("<a href='lectures/"+dept+"/"+semester+"/"+title+"/"+file+"' download>"+file+"</a>");

                $('#myModalView').modal('show');
                $('#closeFooter').focus();

            });
            $('.td_btnEdit').click(function(){

                var row = $(this).closest('tr');
                var rowID = row.attr('class').split('_')[1];
                var title =  row.find('.td_title').text();
                var semester =  row.find('.td_semester').text();
                var batch =  row.find('.td_batch').text();
                var deadline =  row.find('.td_deadline').text();
                var desp =  row.find('.td_despHidden').text();


                $('#updateId').val(rowID);
                $('#updateAssignmentTitle').val(title);
                $('#updateAssignmentSemester').val(semester);
                $('#updateAssignmentBatch').val(batch);
                $('#updateAssignmentDeadline').val(deadline);
                $('#updateAssignmentDesp').val(desp);

                $('#myModalEdit').modal('show');


            });



            $('.td_btnDelete').click(function(){
                var btnDelete = $(this);
                var deleteYes = $('#deleteYes');
                $('#myModalDelete').modal('show');
                deleteYes.focus();
                deleteYes.click(function(){
                    var row = btnDelete.closest('tr');
                    var rowID = row.attr('class').split('_')[1];
                    $('#submitDeleteAssignment').val(rowID);
                    $('#submitDeleteAssignmentForm').submit();
                });
            });

            $('#submitDeleteAssignmentForm').submit(function(){

                var url, values;

                url = $(this).attr('action');
                values = $(this).serialize();

                $.ajax({

                    type: 'POST',
                    url: url,
                    data: values,
                    success:function(data) {
                        if (data.trim() == 'deleted') {
                            $('#myModalDelete').modal('hide');
                            $('#myModalDeleted').modal('show');
                            $('#deletedModalClose').focus();
                        }
                    }

                });

                return false;

            });


            $('#myModalDeleted').on('hidden.bs.modal', function () {
                window.location.href = 'lectures.php';
            });

            $('#assignmentDeadline').datepicker();
            $('#updateAssignmentDeadline').datepicker();


            $("#assignmentFile, #assignmentFileUpdate").change(function() {
                var file = this.files[0];
                var imagefile = file.type;


                var match= ["image/jpeg","image/png","image/jpg", "application/pdf"];
                if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[3]  )))
                {
                    $('#outputAssignment').text('File should be image/PDF.').addClass('animated flash');
                    $(this).val('');
                    return false;
                }
            });


            $('#insertAssignment').submit(function(){

                var url, values;

                url = $(this).attr('action');
                values = new FormData(this);

                $('#outputAssignment').html('<i class="fa fa-2x fa-spinner fa-pulse animated flip"></i>');
                $('#assignmentInsert').prop('disabled', true);

                $.ajax({

                    type: 'POST',
                    url: url,
                    data: values,
                    contentType: false,
                    processData:false,
                    success:function(data){
                        data = data.trim();
                        if(data == 'inserted'){
                            $('#outputAssignment').html('<h2 class="animated bounceInLeft text-success lead">Assignment has been inserted successfully.</h2>');
                            setTimeout(function(){
                                window.location.href = 'lectures.php';
                            }, 2000);
                        }else if(data == 'error'){
                            $('#outputAssignment').html("<p class='animated flash btn btn-danger'>PDF, Jpeg, Jpg are accepted only.</p>");
                        }

                    }


                });


                return false;


            });




            $('#addAssignment').click(function(){
                var link = $(this);
                $('#insertAssignment').slideToggle('slow', function(){
                    if($(this).is(':visible')){
                        $('.eventTable').addClass('animated zoomOut').hide(200);
                        link.html("<span>&laquo; Back</span>");
                        scroll();
                        //           window.location.hash = '#insert';
                        $('#eventTitle').focus();

                    }else{
                        scroll();
                        //   window.location.hash = '';
                        $('.eventTable').show().removeClass('animated zoomOut').addClass('animated zoomIn');
                        link.html("<span class='glyphicon glyphicon-plus'></span> Add New");
                    }
                });
            });



        });

    </script>


    <?php include_once('footer_teacher.php'); ?>
<?php }else if(isset($_SESSION['student']) || isset($_COOKIE['student'])){

    include_once('header.php');
    include_once('includes/connection.php');
    include_once('navbar_student.php');


    include_once('footer.php');



}else{
    header('Location: index.php');

} ?>


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="scroll.js"></script>

