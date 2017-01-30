<?php
/**
 * Created by PhpStorm.
 * User: AHSAN AK
 * Date: 11/19/2016
 * Time: 9:55 PM
 */
session_start();
if(isset($_SESSION['name'])||isset($_SESSION['student'])||isset($_COOKIE['name'])||isset($_COOKIE['student'])) {

    include_once 'feedbackConfig.php';

    if(isset($_SESSION['name'])||isset($_COOKIE['name'])){
        include_once 'header.php';
        include_once 'navbar.php';
    }else if(isset($_SESSION['student'])||isset($_COOKIE['student'])){
        include_once 'header.php';
        include_once 'navbar_student.php';
    }


    if (isset($_SESSION['name'])||isset($_COOKIE['name'])) {

        $req1 = mysqli_query($connection, 'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, students.id as userid, students.roll_no from pm as m1, pm as m2,students where ((m1.user1="' . $user_id['id'] . '" and m1.user1read="no" and students.id=m1.user2) or (m1.user2="' . $user_id['id'] . '" and m1.user2read="no" and students.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
        $req2 = mysqli_query($connection, 'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, students.id as userid, students.roll_no from pm as m1, pm as m2,students where ((m1.user1="' . $user_id['id'] . '" and m1.user1read="yes" and students.id=m1.user2) or (m1.user2="' . $user_id['id'] . '" and m1.user2read="yes" and students.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
    } else if (isset($_SESSION['student'])||isset($_COOKIE['student'])) {
        $req1 = mysqli_query($connection, 'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, admin.id as userid, admin.name from pm as m1, pm as m2,admin where ((m1.user1="' . $user_id['id'] . '" and m1.user1read="no" and admin.id=m1.user2) or (m1.user2="' . $user_id['id'] . '" and m1.user2read="no" and admin.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
        $req2 = mysqli_query($connection, 'select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, admin.id as userid, admin.name from pm as m1, pm as m2,admin where ((m1.user1="' . $user_id['id'] . '" and m1.user1read="yes" and admin.id=m1.user2) or (m1.user2="' . $user_id['id'] . '" and m1.user2read="yes" and admin.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
    }
    ?>

    <div class="container-fluid profileHeading">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="sub-header" id="sub-header">Feedback</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-info" href="feedback.php" >&laquo; Back</a>
                <a href="checkNew_pm.php" class="btn btn-primary">New PM</a>

                <h3>List of messages:</h3>

                <h3 class="feedBackHeading text-center">Unread Messages(<?php echo intval(mysqli_num_rows($req1)); ?>):</h3>

                <table class="table table-responsive table-bordered">
                    <tr>
                        <th>Title</th>
                        <th>Nb. Replies</th>
                        <th>Participant</th>
                        <th>Date of creation</th>
                    </tr>
                    <?php
                    //We display the list of unread messages
                    while ($dn1 = mysqli_fetch_array($req1)) { ?>

                        <tr>
                            <td>
                                <a href="checkRead_pm.php?id=<?php echo $dn1['id']; ?>"><?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?></a>
                            </td>
                            <td><?php echo $dn1['reps'] - 1; ?></td>
                            <td><a target="<?php echo(isset($_SESSION['name'])||isset($_COOKIE['name']) ? '_blank' : '') ?>"
                                   href="<?php echo(isset($_SESSION['name'])||isset($_COOKIE['name'])  ? '../sicprofile.php?id= ' . $dn1['userid'] . '' : 'javascript:;'); ?>"><?php echo htmlentities((isset($_SESSION['name']) ? $dn1['roll_no'] : $dn1['name']), ENT_QUOTES, 'UTF-8'); ?></a>
                            </td>
                            <td><?php echo date('Y/m/d H:i:s', $dn1['timestamp']); ?></td>
                        </tr>

                    <?php }
                    //If there is no unread message we notice it
                    if (intval(mysqli_num_rows($req1)) == 0) {
                        ?>
                        <tr>
                            <td colspan="4" class="center lead text-danger">You have no unread message.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>

                <h3 class="feedBackHeading text-center">Read Messages(<?php echo intval(mysqli_num_rows($req2)); ?>):</h3>
                <table class="table table-responsive table-bordered">
                    <tr>
                        <th>Title</th>
                        <th>Nb. Replies</th>
                        <th>Participant</th>
                        <th>Date of creation</th>
                    </tr>
                    <?php
                    //We display the list of read messages
                    while ($dn2 = mysqli_fetch_array($req2)) { ?>
                        <tr>
                            <td>
                                <a href="checkRead_pm.php?id=<?php echo $dn2['id']; ?>"><?php echo htmlentities($dn2['title'], ENT_QUOTES, 'UTF-8'); ?></a>
                            </td>
                            <td><?php echo $dn2['reps'] - 1; ?></td>
                            <td><a target="<?php echo(isset($_SESSION['name'])||isset($_COOKIE['name']) ? '_blank' : '') ?>"
                                   href="<?php echo(isset($_SESSION['name'])||isset($_COOKIE['name']) ? 'sicprofile.php?id=' . $dn2['userid'] . '' : 'javascript:;'); ?>"><?php echo htmlentities((isset($_SESSION['name'])||isset($_COOKIE['name']) ? $dn2['roll_no'] : $dn2['name']), ENT_QUOTES, 'UTF-8'); ?></a>
                            </td>
                            <td><?php echo date('Y/m/d H:i:s', $dn2['timestamp']); ?></td>
                        </tr>

                    <?php }

                    //If there is no read message we notice it
                    if (intval(mysqli_num_rows($req2)) == 0) {
                        ?>
                        <tr>
                            <td colspan="4" class="center lead text-danger">You have no read message.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <br><br>

            </div>
        </div>


    </div>
    <div id="spinner">
    </div>

    <script src="spinnerLoading.js"></script>
    <script src="scroll.js"></script>

    <?php  if(isset($_SESSION['name'])||isset($_COOKIE['name'])){
        include_once 'footer.php';
    }else if(isset($_SESSION['student'])||isset($_COOKIE['student'])){
        include_once 'footer_student.php';
    }
}
else{
    header('Location:index.php');
}

 ?>



