<?php session_start(); ?> <!--  create session-->
<?php include_once('includes/connection.php') ?><!--  include connection.php file-->
<!DOCTYPE html>
<html lang="en">
<head>   <!-- start of head -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>SIGN IN</title>

  <!-- Bootstrap -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> <!-- link bootstrap.min file-->
  <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> <!-- font awesome for styling -->
  <link rel="stylesheet" href="font-awesome/animate.css">  <!--font awesome for animations-->
  <script src="jQuery/jQuery.js"></script>  <!--link jquery library of JS-->
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="bootstrap-filestyle/src/bootstrap-filestyle.min.js"> </script>
  <link rel="stylesheet" href="style/style.css">  <!-- link custom style sheet-->
  <link rel="stylesheet" href="style/signin.css"> <!--custom signing style sheet-->
  <link rel="icon" href="images/uni_icon.ico">  <!--link for project image folder-->



</head> <!-- end of head-->
<body> <!--start body-->

<?php if(!isset($_COOKIE['name'])&&!isset($_SESSION['name'])&&!isset($_COOKIE['librarian'])&&!isset($_SESSION['librarian'])&&!isset($_COOKIE['teacher'])&&!isset($_SESSION['teacher'])&&!isset($_COOKIE['student'])&&!isset($_SESSION['student'])){ ?>  <!--if session start-->

  <div class="container siginLogin"> <!--start of container-->


    <a href="index.php"> <img src="images/duet_logo.png" alt="" id="logo" class="animated rollIn"></a> <!--link index page and image-->



    <form class="form-signin" action="<?php echo htmlentities('validate.php'); ?>" method="POST" id="submit"> <!--start of signin foam-->
      <h2 class="form-signin-heading text-center">Please sign in</h2>  <!--signin heading-->
      <label for="inputUsername" class="sr-only">Username</label> <!--heading user name-->
      <input type="text" id="inputUsername"  name="username" class="form-control" placeholder="Username"  autofocus > <!--input user name-->
      <label for="inputPassword" class="sr-only">Password</label> <!--paswword heading-->
      <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" >  <!--input password-->

      <div class="form-group"> <!--start of dropdown selection-->
        <label for="sel1" class="labelForm">SignIn As:</label>   <!--heading of signin as-->
        <select class="form-control" id="sel1" name="choose">
          <option value="admin">Admin</option>
          <option value="deo">DEO</option>
          <option value="teacher">Teacher</option>
          <option value="librarian">Librarian</option>
          <option value="student">Student</option>
        </select>
      </div>   <!--end of dropdown selection-->

      <div class="checkbox">  <!--start of remember me check box-->
        <label>
          <input type="checkbox" value="remember" name="remember"> Remember me
        </label>
      </div>   <!--end of remember me-->
        <div class="checkbox">
        <lable>
        <a href="javascript:;" class="unvisited" id="registerForPortal"><i class="fa fa-user-plus" aria-hidden="true"></i> <b>Register to Portal</b> </a>
        </lable>
        </div>
      <button class="btn btn-lg btn-primary btn-block btnCustom animated zoomInUp" type="submit" name="send">Sign in</button> <!-- signin button-->

      <br>

      <div class="alert alert-danger process signed_in text-center" role="alert"></div> <!--vissible on error-->
    </form>
  </div> <!-- /container -->

           <!-- Modal UPDATE-->
  <div class="modal animated bounceInUp" id="myModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h2 class="modal-title text-center" id="myModalLabel"><img src="images/duet_logo.png" alt="" id="modalLogo" class="animated rollIn"> REGISTER FOR PORTAL</h2>
        </div>
        <div class="modal-body text-center">



              <form action="<?php echo htmlentities('register_student.php'); ?>" method="post" id="register">

                <div class="col-lg-4">
                <div class="form-group">
                  <label for="name" class="control-label"> Name</label>
                  <input type="text" name="name" class="form-control" id="name" size="30" placeholder="Name" autofocus required >
                </div>
                </div>
                <div class="col-lg-4">
                <div class="form-group">
                  <label for="password" class="control-label">Password</label>
                  <input type="password" name="password" class="form-control" size="30" id="password" placeholder="Password" required >
                </div>
                </div>
                <div class="col-lg-4">
                <div class="form-group">
                  <label for="fathername" class="control-label">Father Name</label>
                  <input type="text" name="fathername" class="form-control" id="fathername"  size="30" placeholder="Father Name" required>
                </div>
                </div>

                <div class="col-lg-4">
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

                <div class="col-lg-4">
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


                <div class="col-lg-4">
                  <div class="form-group" id="rono_err">
                    <label for="roll_no" class="control-label">Roll-No</label>
                    <input type="text" name="roll_no_D" class="form-control" id="roll_no_D"  value="D" readonly="readonly" > -
                    <input type="text" name="roll_no_batch" class="form-control" id="roll_no_batch"  readonly="readonly"> -
                    <input type="text" name="roll_no_depart" class="form-control" id="roll_no_depart"  readonly="readonly" > -
                    <input type="number" name="roll_no" class="form-control" id="roll_no"  min="01" max="50" onchange="if(parseInt(this.value,10)<10)this.value='0'+this.value;" required >
                  </div>
                </div>


                <div class="col-lg-3">
                <div class="form-group">
                  <label for="gender" class="control-label">Gender</label>
                  <select class="form-control" id="gender" name="gender" required >
                    <option value="">Please Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
                </div>

                <div class="col-lg-3">
                <div class="form-group">
            <label for="phone_no" class="control-label">Phone No</label>
            <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Phone No" size="30" required >
          </div>
          </div>

                <div class="col-lg-3">
                <div class="form-group">
            <label for="email" class="control-label">Email Address</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" size="30" required>
          </div>
          </div>

                <div class="col-lg-3">
                  <div class="form-group">
                    <label for="en_no" class="control-label">Enrollment No</label>
                    <input type="text" name="en_ro" class="form-control" id="department" placeholder="Enrollment No" size="30" required>
                  </div>
                </div>



                <div class="col-lg-3">
                <div class="form-group">
            <label for="nationality" class="control-label">Nationality</label>
            <input type="text" name="nationality" class="form-control" id="nationality" placeholder="Nationality" size="30" required>
          </div>
          </div>

                <div class="col-lg-3">

                <div class="form-group">
            <label for="religion" class="control-label">Religion</label>
            <input type="text" name="religion" class="form-control" id="religion" placeholder="Religion" size="30" required>
          </div>
          </div>


                <div class="col-lg-3">
                <div class="form-group">
            <label for="domicile" class="control-label">Domicile</label>
            <input type="text" name="domicile" class="form-control" id="domicile" placeholder="Domicile" size="30" required>
          </div>
          </div>


                <div class="col-lg-3">
                <div class="form-group">
            <label for="cnic" class="control-label">CNIC#</label>
            <input type="text" name="cnic" class="form-control" id="cnic" placeholder="CNIC#" size="30" required>
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

            <div class="col-lg-4 inputFileRegister">
              <div class="form-group">
              <input type="file" id="file"  name="file" class="filestyle" data-iconName="glyphicon glyphicon-picture" data-buttonText="&nbsp; Select Picture" data-buttonName="btn-info" required>
              </div>
            </div>

                <div class="col-lg-8">
                <div class="form-group">
            <label for="address" class="control-label">Address</label>
            <textarea name="address" class="form-control" id="address" placeholder="Address" cols="30" rows="3" required></textarea>
          </div>
          </div>

              <div class="col-lg-9">
                <span class="rono_err btn btn-danger pull-left "></span><i class="fa fa-spinner fa-pulse insert_loading"></i>

              </div>

               <button type="submit" name="submit" class="btn btn-primary " id="insert">Register me!</button>
              <button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>


              </form>
        </div>


      </div>
    </div>
  </div>



<?php }else{
  header('Location: dashboard.php'); /*create session if not  creat a session*/
} ?>

<!--this script is used to disabled the button for two second and again it will enabled after 2 second when error is disabled
if any error occurs then animation of shakes and error showing are done in the following script-->

<script>


  $(document).ready(function(){


    $('#registerForPortal').click(function(){
        $('#myModalUpdate').modal('show');
        $('#name').focus();



      $("#myModalUpdate").animate({
        scrollTop:  35
      }, 400);

    });


    function enableBtn(){
      setTimeout(function(){
        $('.btnCustom').prop('disabled', false);
      }, 2000);
    }


    $('#submit').submit(function(e){
      var url,values,name,password;
      e.preventDefault();

      $('.btnCustom').prop('disabled', true);
      enableBtn();


      url = $(this).attr('action');
      values = $(this).serialize();
      name = $('#inputUsername').val();
      password = $('#inputPassword').val();




      if(!name  &&  !password){
        $('.process').html('Both fields are empty.').addClass('animated bounceIn').fadeIn('slow').delay('1000').fadeOut('slow');
        $('#inputUsername').focus();
      }else if (!password){
        $('.process').html('Please enter your password.').addClass('animated bounceIn').fadeIn('slow').delay('1000').fadeOut('slow');
        $('#inputPassword').addClass('animated shake').focus();
      }else if(!name) {
        $('.process').html('Please enter your username.').addClass('animated bounceIn').fadeIn('slow').delay('1000').fadeOut('slow');
        $('#inputUsername').addClass('animated shake').focus();

      }else{
        $('.process').hide();
      }



      $.ajax({
        type: 'POST',
        url: url,
        data: values,
        dataType: 'json',
        success:function(data) {
          if(data.activate=='inactive'){
            $('.process').text('Your user is not Activated! Contact DEO of your Department').removeClass('alert-danger').addClass('alert-danger animated bounceIn').fadeIn('slow');

          }
          else if (data.result == 'success') {
            $('.process').text('Welcome ' + data.name.toUpperCase()).removeClass('alert-danger').addClass('alert-success animated flip').fadeIn('slow');
            setTimeout(function () {
              if (data.name=="librarian"){
                window.location.href = 'library/admin';
              }
              else{
              window.location.href = 'dashboard.php';}
            }, 2000);
          } else if (data.ipassword == 'ipassword') {
            $('.process').html('Password is incorrect.').addClass('animated bounceIn').fadeIn('slow').delay('1000').fadeOut('slow');
            $('#inputPassword').focus();
          } else if (data.iuser == 'iuser') {
            $('.process').html('Username is incorrect.').addClass('animated bounceIn').fadeIn('slow').delay('1000').fadeOut('slow');
            $('#inputUsername').focus();
          } else if (data.bic == 'bic') {
            $('.process').html('Username or password is incorrect.').addClass('animated bounceIn').fadeIn('slow').delay('1000').fadeOut('slow');
            $('#inputUsername').focus();
          }
        }
      });
    });
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




    $('#register').submit(function(e){
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
            $('#insert').prop('disabled', true);
            $('.insert_loading').hide();
            $('.rono_err').text('Congratulations! You\'re registered!').removeClass('btn-danger').addClass('btn-success animated flip').fadeIn('slow');
            setTimeout(function(){
              window.location.href = 'index.php';
            }, 4000);
          }else if(data.email == 'emailError'){
            $('.insert_loading').hide();
            $('.rono_err').text($('#email').val() + ' is not a valid email address.').addClass('animated bounceIn').fadeIn('slow').delay('3000').fadeOut('slow');
                 }
        else{
          $('.insert_loading').hide();
      $('.rono_err').text(data.rollno).addClass('animated bounceIn').fadeIn('slow').delay('3000').fadeOut('slow');
      $('#rono_err').addClass('has-error');
      $('#roll_no').focus();
    }
        }
      });
});




  });


</script>

<!--end of script-->


</body>
</html>