<body>
<?php session_start(); ?>

<?php

    if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])){?>

    <?php include('header.php'); ?>

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

?>

            <?php

        $excelFile = $_FILES['excelFile']['name'];
        $excelFile_tmp = $_FILES['excelFile']['tmp_name'];

        move_uploaded_file($excelFile_tmp, 'excel/'.$excelFile);

        $counter = 0;
        include ("PHPExcel/IOFactory.php");
        $objPHPExcel = PHPExcel_IOFactory::load("excel/".$excelFile);
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestRow();
            for ($row=2; $row <= $highestRow; $row++)
            {
                $name = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
                $father_name = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
                $password = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
                $password = md5($password);
                $email = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
                if(isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
                $dept_id = $deo['dept_id'];
                }else{
                $dept_id = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
                }
                $dept_batch = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
                $en_no = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
                $roll_no = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
                $address = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
                $phone = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(9, $row)->getValue());
                $gender = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(10, $row)->getValue());
                $nationality = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(11, $row)->getValue());
                $religion = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(12, $row)->getValue());
                $domicile = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(13, $row)->getValue());
                $cnic = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(14, $row)->getValue());


                $sql = "INSERT INTO students(name ,father_name ,password ,email ,dept_id ,dept_batch ,en_no ,roll_no ,address ,phone ,gender ,nationality ,religion ,domicile ,cnic, activated) VALUES ('".$name."', '".$father_name."', '".$password."', '".$email."', '".$dept_id."', '".$dept_batch."', '".$en_no."', '".$roll_no."', '".$address."', '".$phone."', '".$gender."', '".$nationality."', '".$religion."', '".$domicile."', '".$cnic."','1')";
                mysqli_query($connection, $sql);


            }
        }
        unlink('excel/'.$excelFile);
    }


    ?>


        <?php include('navbar.php'); ?>
    <?php

    if(isset($_GET['delete'])){?>

        <script>
            $(function(){
                $('.deleteMessage').show('slow').delay('2000').fadeOut('2000');
                window.history.pushState("", "project/", 'sic.php');
            });

        </script>

    <?php } ?>

<div class="container-fluid profileHeading">
    <div class="row">
        <div class="col-sm-12">
    <h2 class="sub-header" id="sub-header">Student Form <button class="btn btn-danger pull-right deleteMessage" style="display: none">Record has been deleted.</button></h2>
        </div>
    </div>

    <button type="button" class="btn btn-primary" id="new"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add New</button>

    <form action="<?php echo htmlspecialchars('sic.php'); ?>" id="addExcel" method="post" enctype="multipart/form-data" name="addExcel">

        <label class="btn btn-success btn-file btnFileLabel" style="padding: 10px">
           <span class="fa fa-file-excel-o" aria-hidden="true"> Import from Excel File<span><input id="excelFile" name="excelFile" type="file">
        </label>
        <input type="submit" value="submit" name="submitExcelFile" id="submitExcelFile">
    </form>
    <a href="waiting.php"><button type="button" class="btn btn-primary" id="new"> Waiting</button></a>
    <form class="form-inline" id="perPage" method="get" target="<?php htmlentities('sic.php') ?>">
        <div class="form-group" >
            <label for="sel1">Per Page:</label>
            <select class="form-control" id="sel1" name="perPage">

                    <?php
                    if(isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
                    $queryCount= mysqli_query($connection, "select * from students where dept_id='".$deo['dept_id']."' and activated='1'");
                    }else if(isset($_COOKIE['name'])||isset($_SESSION['name'])){
                    $queryCount= mysqli_query($connection, "select * from students where activated='1'");
                    }
                    if(isset($_GET['perPage'])){
                        $number_of_posts = $_GET['perPage'];
                    }

                    else if(mysqli_num_rows($queryCount) >500 ){
                    $number_of_posts = 100;
                    }
                    else{

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


                if(isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
                $query = "SELECT * FROM department where dept_id='".$deo['dept_id']."'";
                $query_run = mysqli_query($connection, $query);
                }else{
                $query = "SELECT * FROM department";

                    $query_run = mysqli_query($connection, $query);
                echo "<option value=''>All Departments</option>";

}
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


            if(isset($_GET['batchSearch'])){
                $batchSearch = $_GET['batchSearch'];
            }else{
                $batchSearch = '';
            }

            ?>

            <label for="sel3"></label>
            <select class="form-control" id="sel3" name="batchSearch">
                <option value="">All Batchs</option>
                <option <?php echo ($batchSearch == 2013 ? 'selected' : '') ?>>2013</option>
                <option <?php echo ($batchSearch == 2014 ? 'selected' : '') ?>>2014</option>
                <option <?php echo ($batchSearch == 2015 ? 'selected' : '') ?>>2015</option>
                <option <?php echo ($batchSearch == 2016 ? 'selected' : '') ?>>2016</option>

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
            <input id="searchQuery" name="searchQuery" type="text" class="form-control btn-info" placeholder="Search Name or Roll No" value="<?php echo (isset($searchQuery)) ? $searchQuery : '' ?>" <?php echo (isset($_GET['searchQuery'])&&!empty($_GET['searchQuery'])) ? 'autofocus' : '' ?>>
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


if(isset($_SESSION['deo'])||isset($_COOKIE['deo'])){
$all_post_query = "SELECT * FROM students where dept_id='".$deo['dept_id']."'";

if($batchSearch != '' && $searchQuery != ''){
        $all_post_query .= "AND (name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%') AND dept_batch = $batchSearch AND activated = '1'";
    } else if($batchSearch != '' && $searchQuery != ''){
        $all_post_query .= "AND dept_batch = $batchSearch AND (name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%') AND activated = '1'";
    } else if($searchQuery != ''){
        $all_post_query .= "AND (name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%') AND activated = '1'";
    } else   if($batchSearch != ''){
        $all_post_query .= "AND dept_batch = $batchSearch AND activated = '1'";
    }else{
        $all_post_query .= "AND activated = '1'";
    }
}else{
    $all_post_query = "SELECT * FROM students ";

    if($departmentSearch != '' && $batchSearch != '' && $searchQuery != ''){
        $all_post_query .= "WHERE (name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%') AND (dept_id = $departmentSearch AND dept_batch = $batchSearch) AND activated = '1'";
    } else if($departmentSearch != '' && $batchSearch != ''){
        $all_post_query .= "WHERE dept_id = $departmentSearch AND dept_batch = $batchSearch AND activated = '1'";
    } else if($departmentSearch != '' && $searchQuery != ''){
        $all_post_query .= "WHERE dept_id = $departmentSearch AND (name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%') AND activated = '1'";
    } else if($batchSearch != '' && $searchQuery != ''){
        $all_post_query .= "WHERE dept_batch = $batchSearch AND (name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%') AND activated = '1'";
    } else if($searchQuery != ''){
        $all_post_query .= "WHERE (name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%') AND activated = '1'";
    } else if($departmentSearch != ''){
        $all_post_query .= "WHERE dept_id = $departmentSearch AND activated = '1'";
    }else   if($batchSearch != ''){
        $all_post_query .= "WHERE dept_batch = $batchSearch AND activated = '1'";
    }else{
        $all_post_query .= "WHERE activated = '1'";
    }
}
    $all_post_run = mysqli_query($connection, $all_post_query);
    $all_posts = mysqli_num_rows($all_post_run);
    $total_pages = ceil($all_posts / $number_of_posts);
    $posts_start_from = ($page_id - 1) * $number_of_posts;


    /*PAGINATION ENDS*/

    if(isset($_SESSION['deo'])||isset($_COOKIE['deo'])){
    $query = "SELECT * FROM students where dept_id='".$deo['dept_id']."' ";

    if($batchSearch != '' && $searchQuery != ''){
        $query .= "AND (name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%') AND dept_batch = $batchSearch AND activated = '1' LIMIT $posts_start_from, $number_of_posts";
    } else if($batchSearch != '' && $searchQuery != ''){
        $query .= "AND dept_batch = $batchSearch AND (name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%') AND activated = '1' LIMIT $posts_start_from, $number_of_posts";
    }else if($searchQuery != ''){
        $query .= "AND name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%' AND activated = '1' LIMIT $posts_start_from, $number_of_posts ";
    } else if($batchSearch != '') {
        $query .= "AND dept_batch = $batchSearch AND activated = '1' LIMIT $posts_start_from, $number_of_posts ";
    }
    else{
        $query .= "AND activated = '1' LIMIT $posts_start_from, $number_of_posts";
    }
    }else{

    $query = "SELECT * FROM students ";

    if($departmentSearch != '' && $batchSearch != '' && $searchQuery != ''){
        $query .= "WHERE (name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%') AND (dept_id = $departmentSearch AND dept_batch = $batchSearch) AND activated = '1' LIMIT $posts_start_from, $number_of_posts";
    } else if($departmentSearch != '' && $batchSearch != ''){
        $query .= "WHERE dept_id = $departmentSearch AND dept_batch = $batchSearch AND activated = '1' LIMIT $posts_start_from, $number_of_posts";
    } else if($departmentSearch != '' && $searchQuery != ''){
        $query .= "WHERE dept_id = $departmentSearch AND (name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%') AND activated = '1' LIMIT $posts_start_from, $number_of_posts";
    } else if($batchSearch != '' && $searchQuery != ''){
        $query .= "WHERE dept_batch = $batchSearch AND (name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%') AND activated = '1' LIMIT $posts_start_from, $number_of_posts";
    }else if($searchQuery != ''){
        $query .= "WHERE name LIKE '%$searchQuery%' OR roll_no LIKE '%$searchQuery%' AND activated = '1' LIMIT $posts_start_from, $number_of_posts ";
    } else if($departmentSearch != ''){
        $query .= "WHERE dept_id = $departmentSearch AND activated = '1' LIMIT $posts_start_from, $number_of_posts ";
    }else if($batchSearch != '') {
        $query .= "WHERE dept_batch = $batchSearch AND activated = '1' LIMIT $posts_start_from, $number_of_posts ";
    }
    else{
        $query .= "WHERE activated = '1' LIMIT $posts_start_from, $number_of_posts";
    }
}
    $query_run = mysqli_query($connection, $query);


    ?>


    <?php

    if((isset($_GET['departmentSearch'])&&!empty($_GET['departmentSearch'])) || (isset($_GET['batchSearch'])&&!empty($_GET['batchSearch'])) || (isset($_GET['searchQuery'])&&!empty($_GET['searchQuery']))){
        echo "<p id='total'><b>Result(s) found: $all_posts</b></p>";
    }
    ?>
    <span id="errorExcel"></span>
    <form class="form-inline" id="addnew" method="post" action="<?php echo htmlspecialchars('insert_student.php'); ?>" enctype="multipart/form-data">

                 <div class="container addNewStudent">
                     <div class="row">
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <label for="name" class="control-label"> Name</label>
                                 <input type="text" name="name" class="form-control" id="name" maxlength="32" size="30" placeholder="Name" autofocus required >
                             </div>
                         </div>
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <label for="password" class="control-label">Password</label>
                                 <input type="password" name="password" class="form-control" size="30" maxlength="32" id="password" placeholder="Password" required >
                             </div>
                         </div>
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <label for="fathername" class="control-label">Father Name</label>
                                 <input type="text" name="fathername" class="form-control" id="fathername" maxlength="32" size="30" placeholder="Father Name" required>
                             </div>
                         </div>
                     </div>
                     <!-- /.row -->
                     <div class="row">
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
                                 <input type="text" name="phone_no" class="form-control" id="phone_no" maxlength="32" placeholder="Phone No" size="30" required >
                             </div>
                         </div>
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <label for="email" class="control-label">Email Address</label>
                                 <input type="email" name="email" class="form-control" id="email" maxlength="32" placeholder="Email Address" size="30" required>
                             </div>
                         </div>
                     </div>
                     <!-- /.row -->
                     <div class="row">


                         <div class="col-sm-4">
                             <div class="form-group">
                                 <label for="batch" class="control-label">Batch</label>
                                 <select class="form-control" id="batch" name="batch" required >
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
                                     <option value="">Please Select</option>

                                     <?php
if(isset($_SESSION['deo'])||isset($_COOKIE['deo'])){
$query_department = "SELECT * FROM department where dept_id='".$deo['dept_id']."'";
}else{
                                     $query_department = "SELECT * FROM department";}
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
                         <div class="col-sm-4">
                             <div class="form-group" id="rono_err">
                                 <label for="roll_no" class="control-label">Roll-No</label>
                                 <input type="text" name="roll_no_D" class="form-control" id="roll_no_D"  value="D" readonly="readonly" > -
                                 <input type="text" name="roll_no_batch" class="form-control" id="roll_no_batch"  readonly="readonly"> -
                                 <input type="text" name="roll_no_depart" class="form-control" id="roll_no_depart"  readonly="readonly" > -
                                 <input type="number" name="roll_no" class="form-control" id="roll_no"  min="01" max="50" onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;" required >
                             </div>
                         </div>
                     </div>

                     <!-- /.row -->
                     <div class="row">
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <label for="en_no" class="control-label">Enrollment No</label>
                                 <input type="number" name="en_ro" class="form-control" maxlength="8" id="department" placeholder="Enrollment No" size="30" required>
                             </div>
                         </div>
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <label for="nationality" class="control-label">Nationality</label>
                                 <input type="text" name="nationality" class="form-control" maxlength="20" id="nationality" placeholder="Nationality" size="30" required>
                             </div>
                            </div>
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <label for="religion" class="control-label">Religion</label>
                                 <input type="text" name="religion" class="form-control" maxlength="15" id="religion" placeholder="Religion" size="30" required>
                             </div>
                         </div>
                     </div>
                     <!-- /.row -->
                     <div class="row">
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <label for="domicile" class="control-label">Domicile</label>
                                 <input type="text" name="domicile" class="form-control" maxlength="15" id="domicile" placeholder="Domicile" size="30" required>
                             </div>
                         </div>
                         <div class="col-sm-4">
                             <div class="form-group">
                                 <label for="cnic" class="control-label">CNIC#</label>
                                 <input type="text" name="cnic" class="form-control" maxlength="15" id="cnic" placeholder="CNIC#" size="30" required>
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
                                 <textarea name="address" class="form-control" id="address" placeholder="Address" cols="30" rows="2" required></textarea>
                             </div>
                             </div>
                     </div>
                     <div class="row">
                         <div class="col-sm-4">
          <input type="file" id="file"  name="file" class="filestyle" data-iconName="glyphicon glyphicon-picture" data-buttonText="&nbsp; Select Picture" data-buttonName="btn-info" required>
                         </div>
                     </div>

                     <!-- /.row -->
                 </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div>
                                    <button type="submit" name="submit" class="btn btn-primary" id="insert">Insert Record</button>
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


                $i = 1;
                while($row = mysqli_fetch_assoc($query_run)) {


                    $id = $row['id'];
                    $name = $row['name'];
                    $fathername = $row['father_name'];
                    $password = $row['password'];
                    $email = $row['email'];
                    $department = $row['dept_id'];
                    $dept_batch = $row['dept_batch'];
                    $en_no = $row['en_no'];
                    $ro_no = $row['roll_no'];
                    $address = $row['address'];
                    $phone = $row['phone'];
                    $gender = $row['gender'];
                    $nationality = $row['nationality'];
                    $religion = $row['religion'];
                    $domicile = $row['domicile'];
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
                <div class="row sic_profile table">


                    <div class="col-md-6 sic_view" onclick="window.location='<?php echo 'sicprofile.php?id='.$id; ?>';">
                        <div class="col-sm-3 imgContainer">
                            <span class="helper"></span>
                            <?php
                            if($picture!=='')
                            {
                                echo "<img class='picture img-rounded' src='student_picture/$picture' alt=''>";
                            }
                            else{
                                echo "<img class='picture img-rounded' src='images/profile_pic.PNG' alt=''>";
                            }

                            ?></div>
                        <div class="col-sm-9 sic_profile_content">

                            <a href="<?php echo 'sicprofile.php?id='.$id; ?>"><div class="profile_name"><?php echo "<b>".strtoupper($name)."</b>"; ?></div></a>
                            <div class="profile_department"><b>Department:</b> <?php echo $department; ?></div>
                            <div class="profile_rollno"><b>Roll No:</b> <?php echo $ro_no; ?></div>
                            <div class="profile_batch"><b>Batch:</b> <?php echo $dept_batch; ?></div>
                        </div>
                        </div> <?php  }
                    else{?>
                        <div class="col-md-6 sic_view" onclick="window.location='<?php echo 'sicprofile.php?id='.$id; ?>';">
                            <div class="col-sm-3 imgContainer">
                                <span class="helper"></span>

                                <?php
                                if($picture!=='')
                                {
                                    echo "<img class='picture img-rounded' src='student_picture/$picture' alt=''>";
                                }
                                else{
                                    echo "<img class='picture img-rounded' src='images/profile_pic.PNG' alt=''>";
                                }

                                ?></div>
                            <div class="col-sm-9 sic_profile_content">
                                <a href="<?php echo 'sicprofile.php?id='.$id; ?>"><div class="profile_name"><?php echo "<b>".strtoupper($name)."</b>"; ?></div></a>
                                <div class="profile_department"><b>Department:</b> <?php echo $department; ?></div>
                                <div class="profile_rollno"><b>Roll No:</b> <?php echo $ro_no; ?></div>
                                <div class="profile_batch"><b>Batch:</b> <?php echo $dept_batch; ?></div>
                            </div>
                        </div>
                        </div><?php } ?>


<?php $i++; } ?>

</div>
</div>


        <!--PAGINATION-->
    <div class="text-center" id="pagination">
    <nav aria-label="Page navigation">
            <ul class="pagination pagination-lg">
                <?php
                for($i = 1; $i <= $total_pages; $i++){
                        echo "<li class='".($page_id == $i ? 'active' : '')."'><a href='sic.php?perPage=".$number_of_posts."&page=".$i."&departmentSearch=".$departmentSearch."&batchSearch=".$batchSearch."&searchQuery=".$searchQuery."'>$i</a></li>";
                    }
                ?>
            </ul>
            </nav>
        </div>
<!--PAGINATION ENDS-->


<?php include('footer.php') ?>

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





                        var department, depart_short, val;

                        department = [1, 2, 3, 4, 5, 6, 7, 8, 9];
                        depart_short = ['CS', 'CH', 'ME', 'IN', 'PG', 'ES', 'EE', 'TE', 'AR'];

                        $('#department').change(function(){
                            val = $(this).val();

                            $('#roll_no_depart').val('');
                            $(department).each(function(i){
                                if(department[i] == val){
                                    $('#roll_no_depart').val(depart_short[i]);
                                }
                            });
                        });

                            $('#batch').change(function(){
                                val = $(this).val();
                                $('#roll_no_batch').val(val);
                            });


                        $('#roll_no_D').focus(function(){
                            $('#roll_no').focus();
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


                        $('#new').click(function(){
                            var link = $(this);
                            $('#addnew').slideToggle('slow', function(){
                               if($(this).is(':visible')){
                                   $('.table').addClass('animated zoomOut');
                                   $('#pagination, #perPage, .sic_profile, #total').hide('slow');
                                   link.html("<span>&laquo; Back</span>");
                                    scroll();
                        //           window.location.hash = '#insert';
                                   $('#name').focus();

                               }else{
                                    scroll();
                                   //   window.location.hash = '';
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
                                $('.rono_err').text('Picture should be in "JPEG | PNG | JPG" format.').addClass('animated bounceIn').fadeIn('slow').delay('2000').fadeOut('slow');
                                $(this).val('');
                                return false;
                            }else if(imagesize > 2000000){
                                $('.rono_err').text('Picture should be less than 2MB.').fadeIn('slow').addClass('animated bounceIn').fadeIn('slow').delay('2000').fadeOut('slow');;
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
                                        $('.rono_err').text('Data has been inserted!').removeClass('btn-danger').addClass('btn-success animated flip').fadeIn('slow');
                                        setTimeout(function(){
                                            window.location.href = 'sicprofile.php?id='+data.row;
                                        }, 3000);
                                    }else{
                                        $('.insert_loading').hide();
                                        $('.rono_err').text(data.rollno).addClass('animated bounceIn').fadeIn('slow').delay('2000').fadeOut('slow');
                                        $('#rono_err').addClass('has-error');
                                        $('#roll_no').focus();
                                    }
                                }
                            });

                            $('#myModal').on('hidden.bs.modal', function(){
                               window.location.href = 'sic.php';
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


<?php


}else{
    header('Location: index.php');

} ?>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="scroll.js"></script>

<script type="text/javascript" src="jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
