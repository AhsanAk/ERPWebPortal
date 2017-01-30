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
    }else if(isset($_SESSION['student'])||isset($_COOKIE['name'])){
        include_once 'header.php';
        include_once 'navbar_student.php';
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

            <p class="lead">Welcome <?php echo $user_id['name'] ?>,</p>
            <?php
            if(isset($_SESSION['name'])||isset($_SESSION['student'])||isset($_COOKIE['name'])||isset($_COOKIE['student']))
            {

    //We count the number of new messages the user has
                $nb_new_pm = mysqli_fetch_array(mysqli_query($connection, 'select count(*) as nb_new_pm from pm where ((user1="'.$user_id['id'].'" and user1read="no") or (user2="'.$user_id['id'].'" and user2read="no")) and id2="1"'));
    //The number of new messages is in the variable $nb_new_pm
                $nb_new_pm = $nb_new_pm['nb_new_pm'];
    //We display the links
                ?>
                <p><a class="btn btn-primary"  href="feedbackList_pm.php">My messages(<i><?php echo $nb_new_pm; ?> unread</i>)</a><br /><br></p>
                <?php
            }

            ?>


        </div>
    </div>


</div>
    <div id="spinner">
    </div>

    <script src="spinnerLoading.js"></script>
    <script src="scroll.js"></script>


<?php
    if(isset($_SESSION['name'])||isset($_COOKIE['name'])){
        include_once 'footer.php';
    }else if(isset($_SESSION['student'])||isset($_COOKIE['student'])){
        include_once 'footer_student.php';
    }



}else{
    header("Location: index.php");
}
?>



