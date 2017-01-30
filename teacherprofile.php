<?php session_start(); ?>
<?php

if(isset($_SESSION['name'])||isset($_COOKIE['name'])||isset($_SESSION['deo'])||isset($_COOKIE['deo'])){?>

    <?php include('header.php'); ?>

<?php include_once('includes/connection.php');

    if(isset($_SESSION['deo'])){
    $deptQuery= mysqli_query($connection, "select dept_id from admin where id= '".$_SESSION['deoId']."' ");
    $deo_dept= mysqli_fetch_assoc($deptQuery);
    }
    ?>


<?php

if(isset($_GET['error'])){
    echo "<script> alert('Employee ID already Exists!')</script>";
}




?>
    <?php include('navbar.php'); ?>
    <?php

    (isset($_GET['id'])) ? $id = (int) $_GET['id'] : '';



    $query = "SELECT * FROM teachers WHERE id = $id";
    $query_run = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($query_run)){

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
        if($query_run_depart){

            while($row1=mysqli_fetch_assoc($query_run_depart)) {
                $department = $row1['dept_name'];

            }

            ?>


            <?php

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

            <form class="form-inline" id="updateNew" method="post" action="<?php echo htmlspecialchars('update_teacher.php'); ?>" enctype="multipart/form-data">

                <div class="container addNewStudent">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group" id="emp_idError">
                                <label for="emp_id" class="control-label"> Employee ID</label>
                                <input type="number" name="emp_id" class="form-control" id="emp_id" size="30" placeholder="Employee ID"  value="<?php echo $emp_id; ?>" min="1" autofocus required >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name" class="control-label"> Name</label>
                                <input type="text" name="name" class="form-control" id="name" size="30" placeholder="Name"  value="<?php echo $name; ?>"  required >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="password" class="control-label"> Password</label>
                                <input type="password" name="password" class="form-control" id="password" size="30" placeholder="Password"  value="<?php echo $password; ?>"  required >
                            </div>


                    </div></div>
                    <!-- /.row -->

                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="department" class="control-label">Department</label>
                                <select class="form-control" id="department" name="department" required >

                                    <?php

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
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
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
                                <input type="text" name="phone_no" class="form-control" id="phone_no" value="<?php echo $phone; ?>" placeholder="Phone No" size="30" required >
                            </div>
                        </div></div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="email" class="control-label">Email Address</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" size="30" value="<?php echo $email; ?>" required>
                            </div>
                        </div>

                    <!-- /.row -->

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nationality" class="control-label">Nationality</label>
                                <input type="text" name="nationality" class="form-control" value="<?php echo $nationality; ?>" id="nationality" placeholder="Nationality" size="30" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="religion" class="control-label">Religion</label>
                                <input type="text" name="religion" class="form-control" value="<?php echo $religion; ?>" id="religion" placeholder="Religion" size="30" required>
                            </div>
                        </div></div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cnic" class="control-label">CNIC#</label>
                                <input type="text" maxlength="15"  name="cnic" value="<?php echo $cnic; ?>" class="form-control" id="cnic" placeholder="CNIC#" size="30" required>
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
                                <label for="designation" class="control-label">Designation</label>
                                <select class="form-control" id="designation" name="designation" required >
                                    <option value="Chairman" <?php echo ($designation == 'Chairman' ? 'selected' : '') ?>>Chairman</option>
                                    <option value="Assistant Professor" <?php echo ($designation == 'Assistant Professor' ? 'selected' : '') ?>>Assistant Professor</option>
                                    <option value="Lecturer" <?php echo ($designation == 'Lecturer' ? 'selected' : '') ?>>Lecturer</option>
                                    <option value="Lab Engineer" <?php echo ($designation == 'Lab Engineer' ? 'selected' : '') ?>>Lab Engineer</option>
                                    <option value="Data Entry Operator" <?php echo ($designation == 'Data Entry Operator' ? 'selected' : '') ?>>Data Entry Operator</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="address" class="control-label">Address</label>
                                <textarea name="address" class="form-control" id="address" placeholder="Address" cols="30" rows="3" required> <?php echo $address; ?></textarea>
                            </div>
                        </div>
                    </div></div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div>
                                <button type="submit" name="submit" class="btn btn-primary" id="insert">Update Record</button>
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <span class="empid_error btn btn-danger pull-right"></span><i class="fa fa-spinner fa-pulse insert_loading pull-right"></i>
                            </div>
                        </div>

                    </div>
                    <!-- /.col-sm-12 -->
                </div>
                <!-- /.row -->
                <!-- /.container -->

            </form>



            <div class="container-fluid sicProfileContainer">
                <div class="row">
                    <div class="col-sm-3 sicProfileSideBar">
                        <div class="sicPhotoContainer">
                            <?php

                            if($picture == ''){
                                echo "<img src='images/profile_pic.png' alt=''>";
                            }else{
                                echo "<img src='teachers_picture/$picture' alt=''>";
                            }

                            ?>
                            <form action="<?php echo htmlspecialchars('update_teacher.php'); ?>" id="addPicture" method="post" enctype="multipart/form-data" name="addPicture">

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
                                <li><a href="#">Personal Information</a></li>
                                <li><a href="#">Attendance</a></li>
                                <li><a href="#">CV</a></li>
                            </ul>
                        </div>
                        <!-- /.sicProfileLinks -->
                    </div>
                    <!-- /.col-sm-3 profileSideBar -->
                    <div class="col-sm-9 sicProfileMain" >
                        <h2 class="sicPersonalInfoHeading">Personal Information
                            <form action="<?php echo htmlspecialchars('update_teacher.php'); ?>" method="post" id="submitUpdate">
                                <button type="button" class="btn btn-danger pull-right" id="delete"><span class="fa fa-remove" aria-hidden="true"></span>  DELETE</button>
                                <input type="submit" value="submit" name="delete" id="delete_submit" style="display: none;">
                                <input type="hidden" name="u_id" value="<?php echo $id; ?>">
                            </form>
                            <button type="button" class="btn btn-primary pull-right new" id="edit"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>  EDIT</button>
                        </h2>
                        <!-- /.sicPersonalInfoHeading -->
                        <div class="sicPersonalInfo">
                            <div class="row sicPersonalInfoRow">
                                <div class="col-sm-6">
                                    <div ><b>Employee ID: </b><span class="update" id="emp_id"><?php echo $emp_id ?></span></div>
                                    </div>
                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                    <div ><b>Name: </b><span class="update" id="u_name"><?php echo $name; ?></span></div>
                                    </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            <div class="row sicPersonalInfoRow">

                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                    <div><b>Department: </b><?php echo $department; ?></div>
                                    </div>
                                <!-- /.col-sm-6 -->
                            <div class="col-sm-6">
                                    <div><b>Email Address: </b><?php echo $email; ?></div>

                                    </div>
                            </div>
                            <!-- /.row -->
                            <!-- /.row -->
                            <div class="row sicPersonalInfoRow">
                                <div class="col-sm-6">
                                    <div><b>Contact No: </b><?php echo $phone; ?></div>

                                    </div>
                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                <div><b>CNIC: </b><?php echo $cnic; ?></div>
                                </div>
                            </div>

                                <div class="row sicPersonalInfoRow">
                                    <div class="col-sm-6">
                                    <div><b>Nationality: </b><?php echo $nationality; ?></div>
                                        </div>
                                    <!-- /.col-sm-6 -->
                                    <div class="col-sm-6">
                                        <div><b>Religion: </b><?php echo $religion; ?></div>
                                        </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <div class="row sicPersonalInfoRow">
                                <div class="col-sm-6">
                                    <div><b>Designation: </b><?php echo $designation; ?></div>
                                </div>
                                    <div class="col-sm-6">
                                        <div><b>Address: </b><?php echo $address; ?></div>
                                    </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.sicPersonalInfo -->
                    </div>
                    <!-- /.col-sm-9 profileMain -->
                </div>
                <!-- /.row -->

            </div>
            </div>
            <!-- /.container-fluid -->

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

                            <form class="form-inline" id="updateData" method="post" action="<?php echo htmlspecialchars('update_teacher.php'); ?>">



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



                    $('.new').click(function(){
                        $('#updateNew').slideToggle('slow', function(){
                            if($(this).is(':visible')){
                                $('.sicProfileContainer').addClass('animated zoomOut').hide();
                                $('.new').show();
                                scroll();
                        //        window.location.hash = '#insert';
                                $('#emp_id').focus();

                            }else{
                                $('.goBack').hide();
                                $('.sicProfileContainer').show().removeClass('animated zoomOut').addClass('animated zoomIn');
                                scroll();
                        //        window.location.hash = '#sub-header';
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



        <?php }}}else if(isset($_SESSION['teacher']) || isset($_COOKIE['teacher'])){
?>

            <?php include_once('header.php'); ?>
            <?php include_once('navbar_teacher.php'); ?>


<div class="container-fluid profileHeading">
    <div class="row">
        <div class="col-sm-12">

            <h2 class="sub-header" id="sub-header"><?php echo ucfirst($teacher['name']). "'s Profile"; ?>

        </div>
    </div>


         <div class="container-fluid sicProfileContainer">
                <div class="row">
                    <div class="col-sm-3 sicProfileSideBar">
                        <div class="sicPhotoContainer">
                            <?php

                                $picture = $teacher['picture'];

                            if($picture == ''){
                                echo "<img src='images/profile_pic.png' alt=''>";
                            }else{
                                echo "<img src='teachers_picture/$picture' alt=''>";
                            }

                            ?>
                        </div>
                        <!-- /.sicPhotoContainer -->
                        <div class="sicProfileLinks">
                            <ul>
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
                                    <div ><b>Employee ID: </b><span class="update" id="emp_id"><?php echo $teacher['emp_id']; ?></span></div>
                                    </div>
                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                    <div ><b>Name: </b><span class="update" id="u_name"><?php echo $teacher['name']; ?></span></div>
                                    </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            <div class="row sicPersonalInfoRow">

                                <?php

                                $query_depart = "SELECT dept_name FROM department WHERE dept_id='".$teacher['dept_id']."'";
                                $query_run_depart = mysqli_query($connection, $query_depart);
                                if($query_run_depart) {

                                    while ($row1 = mysqli_fetch_assoc($query_run_depart)) {
                                        $department = $row1['dept_name'];

                                    }
                                }

                                ?>

                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                    <div><b>Department: </b><?php echo $department; ?></div>
                                    </div>
                                <!-- /.col-sm-6 -->
                            <div class="col-sm-6">
                                    <div><b>Email Address: </b><?php echo $teacher['email']; ?></div>

                                    </div>
                            </div>
                            <!-- /.row -->
                            <!-- /.row -->
                            <div class="row sicPersonalInfoRow">
                                <div class="col-sm-6">
                                    <div><b>Contact No: </b><?php echo $teacher['phone']; ?></div>

                                    </div>
                                <!-- /.col-sm-6 -->
                                <div class="col-sm-6">
                                <div><b>CNIC: </b><?php echo $teacher['cnic']; ?></div>
                                </div>
                            </div>

                                <div class="row sicPersonalInfoRow">
                                    <div class="col-sm-6">
                                    <div><b>Nationality: </b><?php echo $teacher['nationality']; ?></div>
                                        </div>
                                    <!-- /.col-sm-6 -->
                                    <div class="col-sm-6">
                                        <div><b>Religion: </b><?php echo $teacher['religion']; ?></div>
                                        </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <div class="row sicPersonalInfoRow">
                                <div class="col-sm-6">
                                    <div><b>Designation: </b><?php echo $teacher['designation']; ?></div>
                                </div>
                                    <div class="col-sm-6">
                                        <div><b>Address: </b><?php echo $teacher['address']; ?></div>
                                    </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.sicPersonalInfo -->
                    </div>
                    <!-- /.col-sm-9 profileMain -->
                </div>
                <!-- /.row -->

            </div>
            </div>
            <!-- /.container-fluid -->

         <?php include_once('footer_teacher.php'); ?>


<?php
    }else{
    header('Location: index.php');
}

?>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="scroll.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
