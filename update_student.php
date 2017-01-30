<?php

include_once 'checkData.php';

if(isset($_POST['submitPictureNew'])){
    include_once('includes/connection.php');

    $pic_name =  $_FILES['pictureNew']['name'];
    $pic_tmpName =  $_FILES['pictureNew']['tmp_name'];
    $pic_type = substr($_FILES['pictureNew']['type'], 6);
    $id = checkData($_POST['id']);
    $roll_no = checkData($_POST['ro_no']);
    $roll_no_upload = $roll_no.".".$pic_type;

    move_uploaded_file($pic_tmpName, 'student_picture/'. $roll_no.'.'.$pic_type);

    $query = "UPDATE students SET picture = '".$roll_no_upload."' WHERE id = $id";
    $query_run = mysqli_query($connection, $query);
    if($query_run){
        header('Location: sicprofile.php?id='.$id);
    }



}



if(isset($_POST['submit'])){
    include_once('includes/connection.php');

    $ro_no_batch =  $_POST['roll_no_batch'];
    $ro_no_depart =  $_POST['roll_no_depart'];
    $ro_no_id =  $_POST['roll_no'];

    $ro_no = "D-".$ro_no_batch. "-".$ro_no_depart. "-".$ro_no_id;

    $ro_no = checkData($ro_no);

    $query = "SELECT roll_no FROM students WHERE roll_no = '".$ro_no."'";
    $query_run = mysqli_query($connection, $query);
    if(mysqli_num_rows($query_run) > 0){
        $u_id = checkData($_POST['id']);
        header('Location: sicprofile.php?id='.$u_id.'&error=error');

    }


    $u_id = checkData($_POST['id']);
    $u_name = checkData($_POST['name']);
    $u_password = checkData($_POST['password']);
    $u_password = md5($u_password);
    $u_fathername= checkData($_POST['fathername']);
    $u_gender= checkData($_POST['gender']);
    $u_phone_no= checkData($_POST['phone_no']);
    $u_email= checkData($_POST['email']);
    $u_department= checkData($_POST['department']);
    $batch = checkData($_POST['batch']) + 2000;
    $u_address= checkData($_POST['address']);
    $u_en_no= checkData($_POST['en_ro']);
    $u_nationality= checkData($_POST['nationality']);
    $u_religion= checkData($_POST['religion']);
    $u_cnic= checkData($_POST['cnic']);
    $u_domicile= checkData($_POST['domicile']);


    $queryPasswordCheck = mysqli_query($connection, "SELECT * FROM students WHERE password = '".$_POST['password']."' AND id = '$u_id'");
    if(mysqli_num_rows($queryPasswordCheck) > 0){
        $query="UPDATE students SET name='$u_name',father_name='$u_fathername',email='$u_email',dept_id='$u_department',dept_batch='$batch',en_no='$u_en_no',roll_no='$ro_no',address='$u_address',phone='$u_phone_no',gender='$u_gender',nationality='$u_nationality',religion='$u_religion',domicile='$u_domicile',cnic='$u_cnic' WHERE id=$u_id";
        $query_run= mysqli_query($connection, $query);
        if($query_run){
            header('Location: sicprofile.php?id='.$u_id.'&update=updated');
        }
    }else {

        $query = "UPDATE students SET name='$u_name',father_name='$u_fathername',password='$u_password',email='$u_email',dept_id='$u_department',dept_batch='$batch',en_no='$u_en_no',roll_no='$ro_no',address='$u_address',phone='$u_phone_no',gender='$u_gender',nationality='$u_nationality',religion='$u_religion',domicile='$u_domicile',cnic='$u_cnic' WHERE id=$u_id";
        $query_run = mysqli_query($connection, $query);
        if ($query_run) {
            header('Location: sicprofile.php?id=' . $u_id . '&update=updated');
        }
    }

}

if(isset($_POST['delete'])){
    include_once('includes/connection.php');

    $u_id = checkData($_POST['u_id']);
    $query = "DELETE FROM students WHERE id= $u_id";
    $query_run = mysqli_query($connection, $query);
    if($query_run){
        header('Location: sic.php?delete=deleted');
    }
}


mysqli_close($connection);
?>
