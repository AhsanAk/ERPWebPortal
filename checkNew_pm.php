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

    ?>

    <div class="container-fluid profileHeading">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="sub-header" id="sub-header">Feedback</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
<?php
                $form = true;
                $otitle = '';
                $orecip = '';
                $omessage = '';
                //We check if the form has been sent
                if(isset($_POST['title'], $_POST['recip'], $_POST['message']))
                {
                $otitle = $_POST['title'];
                $orecip = $_POST['recip'];
                $omessage = $_POST['message'];
                //We remove slashes depending on the configuration
                $otitle = stripslashes($otitle);
                $orecip = stripslashes($orecip);
                $omessage = stripslashes($omessage);
                //We check if all the fields are filled
                if($_POST['title']!='' and $_POST['recip']!='' and $_POST['message']!='')
                {
                //We protect the variables
                $title = mysqli_real_escape_string($connection, $otitle);
                $recip = mysqli_real_escape_string($connection, $orecip);
                $message = mysqli_real_escape_string($connection, nl2br(htmlentities($omessage, ENT_QUOTES, 'UTF-8')));
                //We check if the recipient exists

                if(isset($_SESSION['name'])||isset($_COOKIE['name'])){
                $dn1 = mysqli_fetch_array(mysqli_query($connection, 'select count(id) as recip, id as recipid, (select count(*) from pm) as npm from students where roll_no="'.$recip.'"'));
                }elseif(isset($_SESSION['student'])||isset($_COOKIE['student'])){
                $dn1 = mysqli_fetch_array(mysqli_query($connection, 'select count(id) as recip, id as recipid, (select count(*) from pm) as npm from admin where id="'.$recip.'"'));
                }


                if($dn1['recip']==1)
                {
                //We check if the recipient is not the actual user
                if($dn1['recipid']!=$user_id['id'])
                {
                $id = $dn1['npm']+1;
                //We send the message
                if(mysqli_query($connection, 'insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$id.'", "1", "'.$title.'", "'.$user_id['id'].'", "'.$dn1['recipid'].'", "'.$message.'", "'.time().'", "yes", "no")'))
                {
                ?>
                <div class="message lead text-success animated flash">The message has successfully been sent.<br />
                    <a href="feedbackList_pm.php">List of my personnal messages</a></div>
                <?php
                $form = false;
                }
                else
                {
                    //Otherwise, we say that an error occured
                    $error = 'An error occurred while sending the message';
                }
                }
                else
                {
                    //Otherwise, we say the user cannot send a message to himself
                    $error = 'You cannot send a message to yourself.';
                }
                }
                else
                {
                    //Otherwise, we say the recipient does not exists
                    $error = 'The recipient does not exists.';
                }
                }
                else
                {
                    //Otherwise, we say a field is empty
                    $error = 'A field is empty. Please fill of the fields.';
                }
                }
                elseif(isset($_GET['recip']))
{
    //We get the username for the recipient if available
    $orecip = $_GET['recip'];
}
if($form) {
//We display a message if necessary
    if (isset($error)) {
        echo '<div class="message">' . $error . '</div>';
    }
//We display the form
    ?>
    <div class="content">

        <h1 class="feedBackHeading">New Personal Message</h1>
        <a class="btn btn-info" href="feedbackList_pm.php">&laquo; Back</a>

        <form action="checkNew_pm.php" method="post" class="form-horizontal">
            <br>    <p class="text-danger">Please fill the following form to send a personal message.</p>
            <label for="title" class="control-label">Title</label><input required type="text"  value="<?php echo htmlentities($otitle, ENT_QUOTES, 'UTF-8'); ?>"   id="title" name="title" class="form-control" size="40" autofocus/><br/>


            <label for="recip" class="control-label">Recipient<span class="small">(Username)</span></label>
            <?php

            if (isset($_SESSION['name'])||isset($_COOKIE['name'])) {

                $usersQuery = 'SELECT roll_no FROM students';
                $userQueryRun = mysqli_query($connection, $usersQuery);
                echo '<select name="recip" id="recip" class="form-control" required>';
                while ($row = mysqli_fetch_assoc($userQueryRun)) {
                    echo "<option value='" . $row['roll_no'] . "'>" . $row['roll_no'] . "</option>";
                }
                echo '</select>';
            } else if (isset($_SESSION['student'])||isset($_COOKIE['student'])) {
                $usersQuery = "SELECT * FROM admin where role='admin'";
                $userQueryRun = mysqli_query($connection, $usersQuery);
                echo '<select name="recip" id="recip" class="form-control" required> ';
                while ($row = mysqli_fetch_assoc($userQueryRun)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }

                echo '</select>';
            }

            ?>
            <br>


            <label for="message" class="control-label">Message</label><textarea required cols="40" rows="2" id="message" class="form-control" name="message"><?php echo htmlentities($omessage, ENT_QUOTES, 'UTF-8'); ?></textarea><br/>
            <input type="submit" value="Send Message!" class="btn btn-primary" required/> <br><br><br>
        </form>
    </div>
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



