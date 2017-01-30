<?php
session_start();


// For Admin
if(isset($_SESSION['name'])||isset($_COOKIE['name'])) {
    if(isset($_POST['oldPassword'])&&!empty($_POST['oldPassword'])&&isset($_POST['newPassword'])&&!empty($_POST['newPassword'])&&isset($_POST['confirmPassword'])&&!empty($_POST['confirmPassword'])){
        include_once 'includes/connection.php';

        $oldPassword = ($_POST['oldPassword']);
        $oldPasswordHash= md5($oldPassword);
        $newPassword = ($_POST['newPassword']);
        $newPasswordHash = md5($newPassword);
        $confirmPassword = ($_POST['confirmPassword']);
        $confirmPasswordHash = md5($confirmPassword);

        $queryPassword= mysqli_query($connection, "select * from admin where role = 'admin'");
        $row = mysqli_fetch_assoc($queryPassword);
        $oldSavePassword= $row['password'];
        if($oldSavePassword==$oldPasswordHash){
        if($newPasswordHash==$confirmPasswordHash){
            $queryChange = mysqli_query($connection, "UPDATE admin SET password= '".$newPasswordHash."' where name='admin' AND role='admin'");
            if($queryChange){
                echo 'updated';
            }
        }else{
            echo 'bnm';
        }
        }
    }
}

//For DEO
else if(isset($_SESSION['deo'])||isset($_COOKIE['deo'])) {
    if(isset($_POST['oldPassword'])&&!empty($_POST['oldPassword'])&&isset($_POST['newPassword'])&&!empty($_POST['newPassword'])&&isset($_POST['confirmPassword'])&&!empty($_POST['confirmPassword'])){
        include_once 'includes/connection.php';

        $oldPassword = ($_POST['oldPassword']);
        $oldPasswordHash= md5($oldPassword);
        $newPassword = ($_POST['newPassword']);
        $newPasswordHash = md5($newPassword);
        $confirmPassword = ($_POST['confirmPassword']);
        $confirmPasswordHash = md5($confirmPassword);


        $queryPassword= mysqli_query($connection, "select * from admin where name='".$_SESSION['deo']."' AND role = 'deo'");
        $row = mysqli_fetch_assoc($queryPassword);
        $oldSavePassword= $row['password'];
        if($oldSavePassword==$oldPasswordHash){
            if($newPasswordHash==$confirmPasswordHash){
                $queryChange = mysqli_query($connection, "UPDATE admin SET password= '".$newPasswordHash."' where name='".$_SESSION['deo']."' AND role='deo'");
                if($queryChange){
                    echo 'updated';
                }
            }else{
                echo 'bnm';
            }
        }
    }
}

//For Students
else if(isset($_SESSION['student'])||isset($_COOKIE['student'])) {
    if(isset($_POST['oldPassword'])&&!empty($_POST['oldPassword'])&&isset($_POST['newPassword'])&&!empty($_POST['newPassword'])&&isset($_POST['confirmPassword'])&&!empty($_POST['confirmPassword'])){
        include_once 'includes/connection.php';

        $oldPassword = ($_POST['oldPassword']);
        $oldPasswordHash= md5($oldPassword);
        $newPassword = ($_POST['newPassword']);
        $newPasswordHash = md5($newPassword);
        $confirmPassword = ($_POST['confirmPassword']);
        $confirmPasswordHash = md5($confirmPassword);


        $queryPassword= mysqli_query($connection, "select * from students where id='".$_SESSION['student']."'");
        $row = mysqli_fetch_assoc($queryPassword);
        $oldSavePassword= $row['password'];
        if($oldSavePassword==$oldPasswordHash){
            if($newPasswordHash==$confirmPasswordHash){
                $queryChange = mysqli_query($connection, "UPDATE students SET password= '".$newPasswordHash."' where id='".$_SESSION['student']."'");
                if($queryChange){
                    echo 'updated';
                }
            }else{
                echo 'bnm';
            }
        }
    }
}

//For Teachers
else if(isset($_SESSION['teacher'])||isset($_COOKIE['teacher'])) {
    if(isset($_POST['oldPassword'])&&!empty($_POST['oldPassword'])&&isset($_POST['newPassword'])&&!empty($_POST['newPassword'])&&isset($_POST['confirmPassword'])&&!empty($_POST['confirmPassword'])){
        include_once 'includes/connection.php';

        $oldPassword = ($_POST['oldPassword']);
        $oldPasswordHash= md5($oldPassword);
        $newPassword = ($_POST['newPassword']);
        $newPasswordHash = md5($newPassword);
        $confirmPassword = ($_POST['confirmPassword']);
        $confirmPasswordHash = md5($confirmPassword);


        $queryPassword= mysqli_query($connection, "select * from teachers where id='".$_SESSION['teacher']."'");
        $row = mysqli_fetch_assoc($queryPassword);
        $oldSavePassword= $row['password'];
        if($oldSavePassword==$oldPasswordHash){
            if($newPasswordHash==$confirmPasswordHash){
                $queryChange = mysqli_query($connection, "UPDATE teachers SET password= '".$newPasswordHash."' where id='".$_SESSION['teacher']."'");
                if($queryChange){
                    echo 'updated';
                }
            }else{
                echo 'bnm';
            }
        }
    }
}else{
    header('Location:index.php');
}

?>