<?php include('header.php'); ?>
<body>


<?php

if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])){ ?>


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
            $name = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
            $password = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
            $password = md5($password);
            $email = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
            if(isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
                $dept_id = $deo['dept_id'];
            }else {
            $dept_id = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
            }
            $designation = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
            $emp_id = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
            $address = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
            $phone = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
            $gender = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
            $nationality = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(9, $row)->getValue());
            $religion = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(10, $row)->getValue());
            $cnic = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(11, $row)->getValue());

            $sql = "INSERT INTO teachers(name , password ,email ,dept_id ,designation , emp_id, address ,phone ,gender ,nationality , religion, cnic) VALUES ('".$name."', '".$password."', '".$email."', '".$dept_id."', '".$designation."', '".$emp_id."', '".$address."', '".$phone."', '".$gender."', '".$nationality."', '".$religion."', '".$cnic."')";
            mysqli_query($connection, $sql);


        }
    }
    unlink('excel/'.$excelFile);
}


?>


    <?php include('navbar.php') ?>
    <?php

    if(isset($_GET['delete'])){?>

        <script>
            $(function(){
                $('.deleteMessage').show('slow').delay('2000').fadeOut('2000');
                window.history.pushState("", "project/", 'teachers.php');

            });

        </script>

    <?php } ?>

<div class="container-fluid profileHeading">
    <div class="row">
        <div class="col-sm-12">

    <h2 class="sub-header" id="sub-header">Teachers Form <button class="btn btn-danger pull-right deleteMessage" style="display: none">Record has been deleted.</button></h2>
    </div>
    </div>

    <button type="button" class="btn btn-primary" id="new"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add New</button>

    <form action="<?php echo htmlspecialchars('teachers.php'); ?>" id="addExcel" method="post" enctype="multipart/form-data" name="addExcel">

        <label class="btn btn-success btn-file btnFileLabel">
           <span class="fa fa-file-excel-o" aria-hidden="true"> Import from Excel File<span><input id="excelFile" name="excelFile" type="file">
        </label>
        <input type="submit" value="submit" name="submitExcelFile" id="submitExcelFile">
    </form>


    <form class="form-inline" id="perPage" method="get" target="<?php htmlentities('teachers.php') ?>">
        <div class="form-group" >
            <label for="sel1">Per Page:</label>
            <select class="form-control" id="sel1" name="perPage">

                <?php


                if(isset($_GET['perPage'])){
                    $number_of_posts = $_GET['perPage'];
                }else{
                    $number_of_posts = 10;
                }

                ?>

                <option <?php echo ($number_of_posts == 10 ? 'selected' : '') ?>>10</option>
                <option <?php echo ($number_of_posts == 20 ? 'selected' : '') ?>>20</option>
                <option <?php echo ($number_of_posts == 50 ? 'selected' : '') ?>>50</option>
                <option <?php echo ($number_of_posts == 100 ? 'selected' : '') ?>>100</option>
            </select>
        </div>

        <div class="form-group" >
            <label for="sel2">Filter: </label>
            <select class="form-control" id="sel2" name="departmentSearch">
                <?php


                if(isset($_GET['departmentSearch'])){
                    $departmentSearch = $_GET['departmentSearch'];
                }else{
                    $departmentSearch = '';
                }



                $query = 'SELECT * FROM department';
                $query_run = mysqli_query($connection, $query);
                echo "<option value=''>All Departments</option>";


                while($row = mysqli_fetch_assoc($query_run)){

                    $depart_id = $row['dept_id'];
                    $depart_name = $row['dept_name'];

                    if($depart_id == $departmentSearch){
                        echo "<option value='$depart_id' selected>$depart_name</option>";
                        continue;
                    }

                    echo "<option value='$depart_id'>$depart_name</option>";


                }

                ?>
            </select>
        </div>

<div class="form-group" >

            <?php


            if(isset($_GET['desigSearch'])){
                $desigSearch = $_GET['desigSearch'];
            }else{
                $desigSearch = '';
            }

            ?>

            <label for="sel3"></label>
            <select class="form-control" id="sel3" name="desigSearch">
            <option value="">All Designations</option>
            <option value="Chairman" <?php echo ($desigSearch == 'Chairman' ? 'selected' : '') ?>>Chairman</option>
            <option value="Assistant Professor" <?php echo ($desigSearch == 'Assistant Professor' ? 'selected' : '') ?>>Assistant Professor</option>
            <option value="Lecturer" <?php echo ($desigSearch == 'Lecturer' ? 'selected' : '') ?>>Lecturer</option>
            <option value="Lab Engineer" <?php echo ($desigSearch == 'Lab Engineer' ? 'selected' : '') ?>>Lab Engineer</option>
            <option value="Data Entry Operator" <?php echo ($desigSearch == 'Data Entry Operator' ? 'selected' : '') ?>>Data Entry Operator</option>
            </select>
        </div>

        <?php

        if(isset($_GET['searchQuery'])){
            $searchQuery = $_GET['searchQuery'];
        }else{
            $searchQuery = '';
        }


        ?>
        <div class="form-group">
            <input id="searchQuery" name="searchQuery" type="text" class="form-control btn-info" placeholder="Search Name or Emp ID" value="<?php echo (isset($searchQuery)) ? $searchQuery : '' ?>" <?php echo (isset($_GET['searchQuery'])&&!empty($_GET['searchQuery'])) ? 'autofocus' : '' ?>>
        </div>

    </form>

    <br>


    <?php


    /*PAGINATION*/


    if(isset($_GET['page'])){
        $page_id =  $_GET['page'];
    }else{
        $page_id = 1;
    }



  $all_post_query = 'SELECT * FROM teachers ';

    if($departmentSearch != '' && $desigSearch != '' && $searchQuery != ''){
        $all_post_query .= "WHERE dept_id = $departmentSearch AND designation = '$desigSearch' AND name LIKE '%$searchQuery%' OR emp_id LIKE '%$searchQuery%'";
    } else if($departmentSearch != '' && $desigSearch != ''){
        $all_post_query .= "WHERE dept_id = $departmentSearch AND designation = '$desigSearch'";
    } else if($departmentSearch != '' && $searchQuery != ''){
        $all_post_query .= "WHERE dept_id = $departmentSearch AND name LIKE '%$searchQuery%' OR emp_id LIKE '%$searchQuery%'";
    } else if($desigSearch != '' && $searchQuery != ''){
        $all_post_query .= "WHERE designation = '$desigSearch' AND name LIKE '%$searchQuery%' OR emp_id LIKE '%$searchQuery%'";
    } else if($searchQuery != ''){
        $all_post_query .= "WHERE name LIKE '%$searchQuery%' OR emp_id LIKE '%$searchQuery%'";
    } else if($departmentSearch != ''){
        $all_post_query .= "WHERE dept_id = $departmentSearch";
    }else   if($desigSearch != ''){
        $all_post_query .= "WHERE designation = '$desigSearch'";
    }

    $all_post_run = mysqli_query($connection, $all_post_query);
    $all_posts = mysqli_num_rows($all_post_run);
    $total_pages = ceil($all_posts / $number_of_posts);
    $posts_start_from = ($page_id - 1) * $number_of_posts;


    /*PAGINATION ENDS*/


    $query = "SELECT * FROM teachers ";

    if($departmentSearch != '' && $desigSearch != '' && $searchQuery != ''){
        $query .= "WHERE dept_id = $departmentSearch AND designation = '$desigSearch' AND name LIKE '%$searchQuery%' OR emp_id LIKE '%$searchQuery%' LIMIT $posts_start_from, $number_of_posts";
    } else if($departmentSearch != '' && $desigSearch != ''){
        $query .= "WHERE dept_id = $departmentSearch AND designation = '$desigSearch' LIMIT $posts_start_from, $number_of_posts";
    } else if($departmentSearch != '' && $searchQuery != ''){
        $query .= "WHERE dept_id = $departmentSearch AND name LIKE '%$searchQuery%' OR emp_id LIKE '%$searchQuery%' LIMIT $posts_start_from, $number_of_posts";
    } else if($desigSearch != '' && $searchQuery != ''){
        $query .= "WHERE designation = '$desigSearch' AND name LIKE '%$searchQuery%' OR emp_id LIKE '%$searchQuery%' LIMIT $posts_start_from, $number_of_posts";
    }else if($searchQuery != ''){
        $query .= "WHERE name LIKE '%$searchQuery%' OR emp_id LIKE '%$searchQuery%' LIMIT $posts_start_from, $number_of_posts ";
    } else if($departmentSearch != ''){
        $query .= "WHERE dept_id = $departmentSearch LIMIT $posts_start_from, $number_of_posts ";
    }else if($desigSearch != '') {
        $query .= "WHERE designation = '$desigSearch' LIMIT $posts_start_from, $number_of_posts ";
    }
    else{
        $query .= "LIMIT $posts_start_from, $number_of_posts";
    }

    $query_run = mysqli_query($connection, $query);


    ?>


    <?php

    if((isset($_GET['departmentSearch'])&&!empty($_GET['departmentSearch'])) || (isset($_GET['desigSearch'])&&!empty($_GET['desigSearch'])) || (isset($_GET['searchQuery'])&&!empty($_GET['searchQuery']))){
        echo "<p id='total'><b>Result(s) found: $all_posts</b></p>";
    }
    ?>

    <span id="errorExcel"></span>

    <form class="form-inline" id="addnew" method="post" action="<?php echo htmlspecialchars('insert_teacher.php'); ?>" enctype="multipart/form-data">

        <div class="container addNewStudent">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group" id="emp_idError">
                        <label for="emp_id" class="control-label">Employee ID</label>
                        <input type="number" name="emp_id" class="form-control" id="emp_id" placeholder="Employee ID" size="30" min="1" max="1000" autofocus required>
                    </div></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name" class="control-label"> Name</label>
                        <input type="text" name="name" class="form-control" id="name" size="30" placeholder="Name"  required >
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" name="password" class="form-control" size="30" id="password" placeholder="Password" required >
                    </div>
                </div>
            </div>
            <!-- /.row -->


            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                      <label for="designation" class="control-label">Designation</label>
                        <select class="form-control" id="designation" name="designation" required >
                            <option value="">Please Select</option>
                            <option value="Chairman">Chairman</option>
                            <option value="Assistant Professor">Assistant Professor</option>
                            <option value="Lecturer">Lecturer</option>
                            <option value="Lab Engineer">Lab Engineer</option>
                            <option value="Data Entry Operator">Data Entry Operator</option>
                        </select>
                 </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="gender" class="control-label">Gender</label>
                        <select class="form-control" id="gender" name="gender" required >
                            <option value="">Please Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="phone_no" class="control-label">Phone No</label>
                        <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Phone No" size="30" required >
                    </div>
                </div>

            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="email" class="control-label">Email Address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" size="30" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="department" class="control-label">Department</label>
                        <select class="form-control" id="department" name="department" required >
                            <option value="">Please Select</option>

                            <?php

                            $query_department = "SELECT * FROM department";
                            $query_run_department = mysqli_query($connection, $query_department);

                            while($row = mysqli_fetch_assoc($query_run_department)){

                                $depart_id = $row['dept_id'];
                                $depart_name = $row['dept_name'];

                                echo "<option value='".$depart_id."'>$depart_name</option>";
                            }


                            ?>

                        </select>
                    </div>
                </div>


                <!-- /.row -->
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="nationality" class="control-label">Nationality</label>
                        <input type="text" name="nationality" class="form-control" id="nationality" placeholder="Nationality" size="30" required>
                    </div>
                </div></div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="religion" class="control-label">Religion</label>
                        <input type="text" name="religion" class="form-control" id="religion" placeholder="Religion" size="30" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="cnic" class="control-label">CNIC#</label>
                        <input type="text" name="cnic" maxlength="15"  class="form-control" id="cnic" placeholder="CNIC#" size="30" required>
                    </div>
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
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <textarea name="address" class="form-control" id="address" placeholder="Address" cols="30" rows="3" required></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label class="btn btn-info btn-file btnFileLabel">
                        <span class="fa fa-file-picture-o" aria-hidden="true"> Select Picture</span><input id="file" name="file" type="file" required>
                    </label>



                </div>
            </div>

            <!-- /.row -->
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <div>
                        <button type="submit" name="submit" class="btn btn-primary" id="insert">Insert Record</button>
                        <span class="empid_error btn btn-danger pull-right"></span><i class="fa fa-spinner fa-pulse insert_loading pull-right"></i>
                    </div>
                </div>

            </div>
            <!-- /.col-sm-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container -->

    </form>

    <?php



    $i = 1;
    while($row = mysqli_fetch_assoc($query_run)) {


        $id = $row['id'];
        $name = $row['name'];
        $password = $row['password'];
        $email = $row['email'];
        $department = $row['dept_id'];
        $designation = $row['designation'];
        $emp_id = $row['emp_id'];
        $address = $row['address'];
        $phone = $row['phone'];
        $gender = $row['gender'];
        $nationality = $row['nationality'];
        $religion = $row['religion'];
        $cnic = $row['cnic'];
        $picture = $row['picture'];

        $query_depart = "SELECT dept_name FROM department WHERE dept_id=$department";
        $query_run_depart = mysqli_query($connection, $query_depart);
        if ($query_run_depart) {

            while ($row1 = mysqli_fetch_assoc($query_run_depart)) {
                $department = $row1['dept_name'];

            }

        }

        ?>
        <?php  if($i%2!==0){?>
            <div class="row teacher_profile table">


            <div class="col-md-6 teacher_view" onclick="window.location='<?php echo 'teacherprofile.php?id='.$id; ?>';">
                <div class="col-sm-3 imgContainer">
                    <span class="helper"></span>
                    <?php
                    if($picture!=='')
                    {
                        echo "<img class='picture img-rounded' src='teachers_picture/$picture' alt=''>";
                    }
                    else{
                        echo "<img class='picture img-rounded' src='images/profile_pic.PNG' alt=''>";
                    }

                    ?></div>
                <div class="col-sm-9 teacher_profile_content">

                    <a href="<?php echo 'teacherprofile.php?id='.$id; ?>"><div class="profile_name"><?php echo "<b>".strtoupper($name)."</b>"; ?></div></a>
                    <div class="profile_department"><b>Department:</b> <?php echo $department; ?></div>
                    <div class="profile_designation"><b>Designation:</b> <?php echo $designation; ?></div>
                    <div class="profile_empid"><b>Employee ID:</b> <?php echo $emp_id; ?></div>
                </div>
            </div> <?php  }
        else{?>
            <div class="col-md-6 teacher_view" onclick="window.location='<?php echo 'teacherprofile.php?id='.$id; ?>';">
                <div class="col-sm-3 imgContainer">
                    <span class="helper"></span>

                    <?php
                    if($picture!=='')
                    {
                        echo "<img class='picture img-rounded' src='teachers_picture/$picture' alt=''>";
                    }
                    else{
                        echo "<img class='picture img-rounded' src='images/profile_pic.PNG' alt=''>";
                    }

                    ?></div>
                <div class="col-sm-9 teacher_profile_content">
                    <a href="<?php echo 'teacherprofile.php?id='.$id; ?>"><div class="profile_name"><?php echo "<b>".strtoupper($name)."</b>"; ?></div></a>
                    <div class="profile_department"><b>Department:</b> <?php echo $department; ?></div>
                    <div class="profile_designation"><b>Designation:</b> <?php echo $designation; ?></div>
                    <div class="profile_empid"><b>Employee ID:</b> <?php echo $emp_id; ?></div>
                </div>
            </div>
            </div><?php } ?>


        <?php $i++; } ?>
</div>
</div>

<div class="text-center" id="pagination">
    <nav aria-label="Page navigation">
            <ul class="pagination pagination-lg">
  <?php
                for($i = 1; $i <= $total_pages; $i++){
                        echo "<li class='".($page_id == $i ? 'active' : '')."'><a href='teachers.php?perPage=".$number_of_posts."&page=".$i."&departmentSearch=".$departmentSearch."&desigSearch=".$desigSearch."&searchQuery=".$searchQuery."'>$i</a></li>";
                    }
                ?>
            </ul>
            </nav>
        </div>
<!--PAGINATION ENDS-->


    <!-- Modal -->
    <div class="modal animated rotateIn" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">STATUS</h4>
                </div>
                <div class="modal-body  text-center">

                    <button class="btn btn-default btn-lg"><i class="fa fa-check fa-5x animated flash animateInsert"></i></button>
                    <h2 class="animated fadeInDown animateInsert">DATA INSERTED!</h2>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

           <div id="spinner">
            </div>

                <script src="spinnerLoading.js"></script>

    <script>

        $(document).ready(function(){

            var empId = $('#emp_id').val();
            $('#emp_id').change(function(){

                var value = '';
                value = $(this).val();

                if(empId != value){
                    $.post('check_emp_id.php',
                        {emp_id: value},
                        function(data){
                            if(data.trim() == 'error'){
                                $('.empid_error').text('Employee ID already exists!').addClass('animated bounceIn').fadeIn('slow');
                                $('#emp_idError').addClass('has-error');
                                $('#emp_id').focus();
                                $('#insert').prop('disabled', true);
                            }else{
                                $('#emp_idError').removeClass('has-error');
                                $('.empid_error').hide();
                                $('#insert').prop('disabled', false);
                            }
                        });
                }else{
                    $('#emp_idError').removeClass('has-error');
                    $('.empid_error').hide();
                    $('#insert').prop('disabled', false);
                }
            });

            $('#excelFile').change(function(){
                var file = this.files[0];
                var imagefile = file.type;
                if(imagefile === 'application/vnd.ms-excel'){
                    $('#submitExcelFile').click();
                       $('#spinner').show();

                }else{
                    $(this).val('');
                    $('#errorExcel').text('Excel file is accepted only.').fadeIn('slow').delay('2000').fadeOut('slow');
                }
            });


            $('#new').click(function(){
                var link = $(this);
                $('#addnew').slideToggle('slow', function(){
                    if($(this).is(':visible')){
                        $('.table').addClass('animated zoomOut').hide();
                        $('#pagination, #perPage, .sic_profile, #total').hide('slow');

                        link.html("<span>&laquo; Back</span>");
                        scroll();
                //        window.location.hash = '#insert';
                        $('#emp_id').focus();

                    }else{
                        scroll();
                 //       window.location.hash = '';
                        $('.table').show().removeClass('animated zoomOut').addClass('animated zoomIn');
                                    $('#pagination, #perPage, #total').show('slow');

                        link.html("<span class='glyphicon glyphicon-plus'></span> Add New");
                    }
                });
            });

            $("#file").change(function() {
                var file = this.files[0];
                var imagefile = file.type;
                var imagesize = file.size;

                var match= ["image/jpeg","image/png","image/jpg"];
                if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
                {
                    $('.empid_error').text('Picture should be in "JPEG | PNG | JPG" format.').addClass('animated bounceIn').fadeIn('slow').delay('2000').fadeOut('slow');
                    $(this).val('');
                    return false;
                }else if(imagesize > 2000000){
                    $('.empid_error').text('Picture should be less than 2MB.').fadeIn('slow').addClass('animated bounceIn').fadeIn('slow').delay('2000').fadeOut('slow');;
                    $(this).val('');
                    return false;
                }
            });

            function enableBtn(){
                setTimeout(function(){
                    $('#insert').prop('disabled', false);
                }, 3000);
            }



            $('#addnew').submit(function(e){
                e.preventDefault();


                $('#insert').prop('disabled', true);
                enableBtn();

                $('.insert_loading').show();
                var url, values;
                url = $(this).attr('action');
                values = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: values,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData:false,
                    success:function(data){
                        if(data.insert == 'Data Inserted'){
                            $('.insert_loading').hide();
                            $('.empid_error').text('Data has been inserted!').removeClass('btn-danger').addClass('btn-success animated flip').fadeIn('slow');
                            setTimeout(function(){
                                window.location.href = 'teacherprofile.php?id='+data.row;
                            }, 3000);
                        }else{
                            $('.insert_loading').hide();
                            $('.empid_error').text(data.emp_id).addClass('animated bounceIn').fadeIn('slow').delay('2000').fadeOut('slow');
                            $('#empid_error').addClass('has-error');
                            $('#emp_id').focus();
                        }
                    }
                });

                $('#myModal').on('hidden.bs.modal', function(){
                    window.location.href = 'teachers.php';
                });
            });


                        $('#sel2').change(function(){
                            $('#perPage').submit();
                        });

                        $('#sel1').change(function(){
                            $('#perPage').submit();
                        });

                        $('#sel3').change(function(){
                            $('#perPage').submit();
                        });
        });

    </script>




    <?php }else{
        header('Location: index.php');
    } ?>

<?php include('footer.php') ?>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="scroll.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
