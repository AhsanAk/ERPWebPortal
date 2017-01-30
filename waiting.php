<body>
<?php session_start(); ?>

<?php

    if(isset($_COOKIE['name'])||isset($_SESSION['name'])){?>

    <?php include('header.php'); ?>

    <?php include_once('includes/connection.php');



        include('navbar.php'); ?>
    <?php

    if(isset($_GET['id'])||isset($_GET['approve'])){?>

        <script>
            $(function(){
                window.history.pushState("", "<?php echo $_SERVER['PHP_SELF'] ?>", 'waiting.php');
            });

        </script>

    <?php } ?>



    <?php

    if (isset($_GET['id'])){
        $id=$_GET['id'];
        $query = mysqli_query($connection, "UPDATE students set activated=1 where id='$id'");

    }

    ?>


                   <?php

                        if(isset($_GET['approve'])){
                    $query = 'UPDATE students SET activated = 1 WHERE activated = 0';
                    $query_run = mysqli_query($connection, $query);
                        }
                    ?>


<div class="container-fluid profileHeading">
    <div class="row">
        <div class="col-sm-12">
    <h2 class="sub-header" id="sub-header">Waiting for Approval
        <?php if(isset($_GET['id'])){ ?>
        <a class="btn btn-info pull-right animated bounceInLeft" href="sicprofile.php?id=<?php echo $_GET['id']; ?>" target="_blank">User <?php echo $_GET['rollno']; ?> has been activated.</a>
        <?php }elseif(isset($_GET['approve'])){ ?>
            <a class="btn btn-info pull-right animated bounceInLeft">All users have been approved successfully.</a>
        <?php } ?>
    </h2>
        </div>

        <div class="col-lg-12">
            <a href="sic.php"><button type="button" class="btn btn-primary" id="new"> Back</button></a>

            <?php

            $query = "SELECT * FROM students where activated=0";
            $query_run = mysqli_query($connection, $query);
                if(mysqli_num_rows($query_run) > 0){
            ?>
            <a class="btn btn-success pull-right" id="approveAll" href="waiting.php?approve=all"> <i class="fa fa-check-square-o"></i> Approve All </a>

            <table class="table table-responsive">
       <thead>

       <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="waiting" id="waiting" method="get">
                                    <tr>
									    <th>Roll NO.</th>
                                        <th>Name</th>
                                        <th>Department</th>
										<th>Batch</th>
										<th>Approve</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                    $activated=$row['activated'];

                                    $query_depart = "SELECT dept_name FROM department WHERE dept_id=$department";
                                    $query_run_depart = mysqli_query($connection, $query_depart);
                                    if ($query_run_depart) {

                                        while ($row1 = mysqli_fetch_assoc($query_run_depart)) {
                                            $department = $row1['dept_name'];

                                        }

                                    }

                                    ?>


                                    <?php $i++; ?>

                                <tr>
                                <td><a href="sicprofile.php?id=<?php echo $id ?>" target="_blank"> <?php echo $ro_no;?> </a></td>
                                <td><?php echo $name;?></td>
                                <td><?php echo $department;?></td>
                                <td><?php echo $dept_batch;?></td>
                                    <td>
                                        <a  rel="tooltip"  title="Approve" id="e<?php echo $id; ?>" href="waiting.php<?php echo '?id='.$id.'&rollno='.$ro_no; ?>" class="btn btn-success"><i class="fa fa-check-square-o"></i></a>
                                </tr>
                                <?php }?>
                                </tbody>
           </form>

</table>
                <?php }else{
                    echo '<p class="lead text-primary">No pending approvals.</p>';
                } ?>

        </div>
    </div></div>

    <?php          include_once 'footer.php'; ?>

    <?php }else if(isset($_SESSION['deo']) || isset($_COOKIE['deo'])){?>
    <?php include('header.php'); ?>

    <?php include_once('includes/connection.php');
    $deptQuery= mysqli_query($connection, "select dept_id from admin where id= '".$_SESSION['deoId']."' ");
    $deo_dept= mysqli_fetch_assoc($deptQuery);


    include('navbar.php'); ?>
    <?php

    if(isset($_GET['id'])||isset($_GET['approve'])){?>

        <script>
            $(function(){
                window.history.pushState("", "<?php echo $_SERVER['PHP_SELF'] ?>", 'waiting.php');
            });

        </script>

    <?php } ?>



    <?php

    if (isset($_GET['id'])){
        $id=$_GET['id'];
        $query = mysqli_query($connection, "UPDATE students set activated=1 where id='$id'");

    }

    ?>


    <?php

    if(isset($_GET['approve'])){
        $query = 'UPDATE students SET activated = 1 WHERE activated = 0';
        $query_run = mysqli_query($connection, $query);
    }
    ?>


        <div class="container-fluid profileHeading">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="sub-header" id="sub-header">Waiting for Approval
                        <?php if(isset($_GET['id'])){ ?>
                            <a class="btn btn-info pull-right animated bounceInLeft" href="sicprofile.php?id=<?php echo $_GET['id']; ?>" target="_blank">User <?php echo $_GET['rollno']; ?> has been activated.</a>
                        <?php }elseif(isset($_GET['approve'])){ ?>
                            <a class="btn btn-info pull-right animated bounceInLeft">All users have been approved successfully.</a>
                        <?php } ?>
                    </h2>
                </div>

                <div class="col-lg-12">
                    <a href="sic.php"><button type="button" class="btn btn-primary" id="new"> Back</button></a>

                    <?php

                    $query = "SELECT * FROM students where dept_id= '".$deo_dept['dept_id']."' AND activated=0";
                    $query_run = mysqli_query($connection, $query);
                    if(mysqli_num_rows($query_run) > 0){
                        ?>
                        <a class="btn btn-success pull-right" id="approveAll" href="waiting.php?approve=all"> <i class="fa fa-check-square-o"></i> Approve All </a>

                        <table class="table table-responsive">
                            <thead>

                            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="waiting" id="waiting" method="get">
                                <tr>
                                    <th>Roll NO.</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Batch</th>
                                    <th>Approve</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                $activated=$row['activated'];

                                $query_depart = "SELECT dept_name FROM department WHERE dept_id=$department";
                                $query_run_depart = mysqli_query($connection, $query_depart);
                                if ($query_run_depart) {

                                    while ($row1 = mysqli_fetch_assoc($query_run_depart)) {
                                        $department = $row1['dept_name'];

                                    }

                                }

                                ?>


                                <?php $i++; ?>

                                <tr>
                                    <td><a href="sicprofile.php?id=<?php echo $id ?>" target="_blank"> <?php echo $ro_no;?> </a></td>
                                    <td><?php echo $name;?></td>
                                    <td><?php echo $department;?></td>
                                    <td><?php echo $dept_batch;?></td>
                                    <td>
                                        <a  rel="tooltip"  title="Approve" id="e<?php echo $id; ?>" href="waiting.php<?php echo '?id='.$id.'&rollno='.$ro_no; ?>" class="btn btn-success"><i class="fa fa-check-square-o"></i></a>
                                </tr>
                            <?php }?>
                            </tbody>
                            </form>

                        </table>
                    <?php }else{
                        echo '<p class="lead text-primary">No pending approvals.</p>';
                    }
                    ?>

                </div>
            </div></div>
        <?php          include_once 'footer.php'; ?>
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

<script type="text/javascript" src="jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
