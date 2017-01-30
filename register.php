<?php include('header.php'); ?>

<?php include_once('includes/connection.php');?>
<!DOCTYPE html>
<html lang="en">
<head>   <!-- start of head -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style/signin.css"> <!--custom signing style sheet-->
    <title>
        REGISTER TO PORTAL
    </title>
</head> <!-- end of head-->


<form class="form-inline" id="register" method="post" action="<?php echo htmlspecialchars('register_student.php'); ?>" enctype="multipart/form-data">

    <div class="container siginLogin">
    <div class="container addNewStudent">
        <div class="row">
            <h1>REGISTER TO PORTAL</h1>

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="name" class="control-label"> Name</label>
                    <input type="text" name="name" class="form-control" id="name" maxlength="32" size="30" placeholder="Name" autofocus required >
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input type="password" name="password" class="form-control" maxlength="32" size="30" id="password" placeholder="Password" required >
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
            <div class="col-sm-4">
                <div class="form-group" id="rono_err">
                    <label for="roll_no" class="control-label">Roll-No</label>
                    <input type="text" name="roll_no_D" class="form-control" id="roll_no_D"  value="D" readonly="readonly" > -
                    <input type="text" name="roll_no_batch" class="form-control" id="roll_no_batch"  readonly="readonly"> -
                    <input type="text" name="roll_no_depart" class="form-control" id="roll_no_depart"  readonly="readonly" > -
                    <input type="number" name="roll_no" class="form-control" id="roll_no"  min="01" max="50" required >
                </div>
            </div>
        </div>

        <!-- /.row -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="en_no" class="control-label">Enrollment No</label>
                    <input type="number" name="en_ro" class="form-control" id="department" maxlength="8" placeholder="Enrollment No" size="30" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="nationality" class="control-label">Nationality</label>
                    <input type="text" name="nationality" class="form-control" id="nationality" maxlength="20" placeholder="Nationality" size="30" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="religion" class="control-label">Religion</label>
                    <input type="text" name="religion" class="form-control" id="religion" maxlength="15" placeholder="Religion" size="30" required>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="domicile" class="control-label">Domicile</label>
                    <input type="text" name="domicile" class="form-control" id="domicile" placeholder="Domicile" maxlength="15" size="30" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="cnic" class="control-label">CNIC#</label>
                    <input type="text" name="cnic" class="form-control" id="cnic" placeholder="CNIC#" maxlength="15" size="30" required>
                </div>
            </div>
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
                    <button type="submit" name="submit" class="btn btn-primary" id="insert">SUBMIT</button>
                    <span class="rono_err btn btn-danger pull-right"></span><i class="fa fa-spinner fa-pulse insert_loading pull-right"></i>
                </div>
            </div>

        </div>
        <!-- /.col-sm-12 -->
    </div>
    </div>
    <!-- /.row -->
    <!-- /.container -->

</form>

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
                        $('.insert_loading').hide();
                        $('.rono_err').text('Congratulations! You\'re registered!').removeClass('btn-danger').addClass('btn-success animated flip').fadeIn('slow');
                        setTimeout(function(){
                            window.location.href = 'index.php';
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
