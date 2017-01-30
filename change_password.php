<?php session_start(); ?>
<?php if(isset($_COOKIE['name'])||isset($_SESSION['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])||isset($_COOKIE['student'])||isset($_SESSION['student'])||isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])){ ?>

    <?php include_once('header.php'); ?>
    <?php include_once('includes/connection.php');
    if(isset($_COOKIE['name'])||isset($_SESSION['name'])){
        include_once('navbar.php'); }

    else if(isset($_COOKIE['student'])||isset($_SESSION['student'])){
        include_once('navbar_student.php'); }

    else if(isset($_COOKIE['teacher'])||isset($_SESSION['teacher'])){
        include_once('navbar_teacher.php'); }?>




    <div class="container-fluid profileHeading">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="sub-header" id="sub-header">Change Password</h2>
                <form action="<?php echo htmlentities('validate_password.php') ?>" method="post" name="changePassword" id="changePassword" class="form-horizontal">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="oldPassword">Current Password</label>
                            <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Type Your Old Password" autofocus required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="newPassword" class="text-center">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Type Your New Password" autofocus required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Retype Your New Password" autofocus required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <br>
                            <button class="btn btn-primary submitPassword" type="submit">Submit</button>
                            <span class="lead" id="passOutput"></span>
                        </div>
                    </div>
                </form>
           </div>
        </div>
        <div id="spinner">
        </div>

        <script src="spinnerLoading.js"></script>
        <script>

            $(document).ready(function(){

                 $('#changePassword').submit(function(e){

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
                                if(data == 'updated'){
                                    $('#passOutput').html('<span class="btn btn-success animated bounceInLeft">Password has been updated.</span>');
                                     $('.submitPassword').prop('disabled', true);
                                    setTimeout(function(){
                                        window.location.href = 'logout.php';
                                    }, 2500);

                                }else if(data == 'bnm'){
                                    $('#passOutput').html('<span class="btn btn-danger animated bounceInLeft">New password and confirm password doesn\'t match. </span>');
                                    $('#newPassword').focus();
                                }else{
                                    $('#passOutput').html('<span class="btn btn-danger animated bounceInLeft">Current password is incorrect. </span>');
                                    $('#oldPassword').focus();
                                }
                         }



                     });




                 });


            });

        </script>


            <!-- /.col-lg-12 -->
        </div>


    <?php include_once('footer.php'); ?>

    <script src="scroll.js"></script>
    
<?php }else{
    header('Location: index.php');
} ?>
