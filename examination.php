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




    <div class="container-fluid profileHeading">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="sub-header" id="sub-header">Examination</h2>
            </div>
        </div>
        
        <!-- /.row -->



        <div class="row">
            <div class="col-lg-12 examinationShow">

                <form action="<?php echo htmlentities('show_examination.php') ?>" method="post" name="showExamination" id="showExamination" class="form-inline">



                    <select name="examinationDepart" id="examinationDepart" class="form-control" autofocus required>
                        <option value="">Select Department</option>
                        <?php
                        if(isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
                        $queryDepart = mysqli_query($connection, "SELECT * FROM department where dept_id='".$deo['dept_id']."'");
                        }
                        else{
                            $queryDepart = mysqli_query($connection, 'SELECT * FROM department');
                        }
                        while($row = mysqli_fetch_assoc($queryDepart)){
                            echo "<option value='".$row['dept_id']."'>".$row['dept_name']."</option>";
                        }

                        ?>
                    </select>

                    <select name="examinationSemester" id="examinationSemester" class="form-control" required>
                        <option value="">Select Semester</option>
                        <?php
                        $querySemester = mysqli_query($connection, 'SELECT * FROM semester');

                        while($row = mysqli_fetch_assoc($querySemester)){
                            echo "<option value='".$row['semester_id']."'>".$row['semester_name']."</option>";
                        }

                        ?>
                    </select>
                    <select name="examinationBatch" id="examinationBatch" class="form-control" required>
                        <option value="">Select Batch</option>
                        <?php
                        $queryBatch = mysqli_query($connection, 'SELECT * FROM batch');

                        while($row = mysqli_fetch_assoc($queryBatch)){
                            echo "<option value='".$row['batch_no']."'>".$row['batch_no']."</option>";
                        }

                        ?>
                    </select>
                    <button class="btn btn-info" type="submit" id="examinationSubmit" name="examinationSubmit">GO!</button>
                </form>


                <div id="examinationOutput"></div>

            </div>
            <!-- /.col-lg-12 subjectShow -->
        </div>
        <!-- /.row -->







    </div>

    <?php include_once('footer.php'); ?>

    <script src="scroll.js"></script>
    <script>
        $(document).ready(function(){





            $('#showExamination').submit(function(){

                var url, values;

                url = $(this).attr('action');
                values = $(this).serialize();

                $.ajax({

                    type: 'POST',
                    url: url,
                    data: values,
                    success: function(data){
                        data = data.trim();
                        if(data == 'NoUpdate'){
                        $('#examinationOutput').html("<p class='lead animated flash btn btn-danger'>Result is not updated yet for this semester.<p>");
                        }
                        else{
                        $('#examinationOutput').html(data);
                        $('#subjectDepart').focus();
                        scroll();

                        }

                }
                });


                return false;

            });

        });
    </script>
<?php }else{
    header('Location: index.php');
} ?>
