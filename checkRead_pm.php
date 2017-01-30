<?php
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

                //We check if the ID of the discussion is defined
                if(isset($_GET['id'])) {
                    $id = intval($_GET['id']);
//We get the title and the narators of the discussion
                    $req1 = mysqli_query($connection, 'select title, user1, user2 from pm where id="' . $id . '" and id2="1"');
                    $dn1 = mysqli_fetch_array($req1);
//We check if the discussion exists
                    if (mysqli_num_rows($req1) == 1) {
//We check if the user have the right to read this discussion
                        if ($dn1['user1'] == $user_id['id'] or $dn1['user2'] == $user_id['id']) {
//The discussion will be placed in read messages
                            if ($dn1['user1'] == $user_id['id']) {
                                mysqli_query($connection, 'update pm set user1read="yes" where id="' . $id . '" and id2="1"');
                                $user_partic = 2;
                            } else {
                                mysqli_query($connection, 'update pm set user2read="yes" where id="' . $id . '" and id2="1"');
                                $user_partic = 1;
                            }
//We get the list of the messages
//$req2 = mysqli_query($connection, 'select pm.timestamp, pm.message, users.id as userid, users.username, users.avatar from pm, users where pm.id="'.$id.'" and users.id=pm.user1 order by pm.id2');

                            $req2 = mysqli_query($connection, '
											SELECT
										pm.timestamp,
										pm.title,
										pm.message,
										userid.id,
										userid.name
									FROM
										(
											SELECT
												admin.id,
												admin.name
											FROM
												admin
											UNION
											SELECT
												students.id,
												students.roll_no
											FROM
												students
										) AS userid,
										(
											SELECT
												*
											FROM
												PM
										) as pm
									where
										pm.id = "' . $id . '"
										and userid.id = pm.user1
									order by
										pm.id2
			');


//We check if the form has been sent
                            if (isset($_POST['message']) and $_POST['message'] != '') {
                                $message = $_POST['message'];
                                //We remove slashes depending on the configuration
                                $message = stripslashes($message);
                                //We protect the variables
                                $message = mysqli_real_escape_string($connection, nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8')));
                                //We send the message and we change the status of the discussion to unread for the recipient
                                if (mysqli_query($connection, 'insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("' . $id . '", "' . (intval(mysqli_num_rows($req2)) + 1) . '", "", "' . $user_id['id'] . '", "", "' . $message . '", "' . time() . '", "", "")') and mysqli_query($connection, 'update pm set user' . $user_partic . 'read="yes" where id="' . $id . '" and id2="1"')) {
                                    ?>
                                    <div class="message lead text-success animated flash">Your message has successfully been sent.<br/>
                                        <a href="checkRead_pm.php?id=<?php echo $id; ?>" >Go to the discussion</a></div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="message">An error occurred while sending the message.<br/>
                                        <a href="checkRead_pm.php?id=<?php echo $id; ?>">Go to the discussion</a></div>
                                      <?php
                                }
                            } else {
//We display the messages
                                ?>
                                <a class="btn btn-info" href="feedbackList_pm.php">&laquo; Back</a>

                                <div>
                                    <h1 class="feedBackHeading text-center"><?php echo $dn1['title']; ?></h1>
                                    <table class="table table-responsive table-bordered">
                                        <tr>
                                            <th>User</th>
                                            <th>Message</th>
                                        </tr>
                                        <?php
                                        while ($dn2 = mysqli_fetch_array($req2)) {
                                            ?>
                                            <tr>
                                                <td class="author center"><?php
                                                    if (@$dn2['avatar'] != '') {
                                                        echo '<img src="' . htmlentities($dn2['avatar']) . '" alt="Image Perso" style="max-width:100px;max-height:100px;" />';
                                                    }
                                                    ?><br/><a href="javascript:;"
                                                              class="btn btn-primary"><?php echo $dn2['name']; ?></a>
                                                </td>
                                                <td class="text-left">
                                                    <div class="text-right text-bold">
                                                        Sent: <?php echo date('m/d/Y H:i:s', $dn2['timestamp']); ?></div>
                                                    <?php echo $dn2['message']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        //We display the reply form
                                        ?>
                                    </table>
                                    <br/>

                                    <h2 class="text-center feedBackHeading">Reply Message</h2>

                                    <div class="text-center">
                                        <form action="checkRead_pm.php?id=<?php echo $id; ?>" method="post">
                                            <textarea cols="20" rows="5" name="message" class="form-control" required autofocus></textarea><br/>
                                            <input type="submit" value="Send Message!" class="btn btn-info"/>
                                            <br><br>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div class="message">You dont have the rights to access this page.</div>';
                        }
                    } else {
                        echo '<div class="message">This discussion does not exists.</div>';
                    }
                }else
                    {
                        echo '<div class="message">The discussion ID is not defined.</div>';
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



