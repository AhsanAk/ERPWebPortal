<?php

include_once 'checkData.php';

if(isset($_POST['submitPictureNew'])){
    include_once('includes/connection.php');

    $pic_name =  $_FILES['pictureNew']['name'];
    $pic_tmpName =  $_FILES['pictureNew']['tmp_name'];
    $pic_type = substr($_FILES['pictureNew']['type'], 6);
    $id = checkData($_POST['id']);
    $emp_id = checkData($_POST['emp_id']);
    $emp_id_upload = $emp_id.".".$pic_type;

    move_uploaded_file($pic_tmpName, 'teachers_picture/'. $emp_id.'.'.$pic_type);

    $query = "UPDATE teachers SET picture = '".$emp_id_upload."' WHERE id = $id";
    $query_run = mysqli_query($connection, $query);
    if($query_run){
        header('Location: teacherprofile.php?id='.$id);
    }



}



if(isset($_POST['submit'])) {
    include_once('includes/connection.php');

    $emp_id = checkData($_POST['emp_id']);

    $query = "SELECT emp_id FROM teachers WHERE emp_id = '" . $emp_id . "'";
    $query_run = mysqli_query($connection, $query);
    if (mysqli_num_rows($query_run) > 0) {
        $u_id = $_POST['id'];
        header('Location: teacherprofile.php?id=' . $u_id . '&error=error');
    }

    $u_id = checkData($_POST['id']);
    $u_name = checkData($_POST['name']);
    $u_password = checkData($_POST['password']);
    $u_password = md5($u_password);
    $u_designation = checkData($_POST['designation']);
    $u_emp_id = checkData($_POST['emp_id']);
    $u_gender = checkData($_POST['gender']);
    $u_phone_no = checkData($_POST['phone_no']);
    $u_email = checkData($_POST['email']);
    $u_department = checkData($_POST['department']);
    $u_address = checkData($_POST['address']);
    $u_nationality = checkData($_POST['nationality']);
    $u_religion = checkData($_POST['religion']);
    $u_cnic = checkData($_POST['cnic']);


    $queryCheckPassword = mysqli_query($connection, "SELECT * FROM teachers WHERE password = '" . $_POST['password'] . "' AND id = '$u_id'");
    if (mysqli_num_rows($queryCheckPassword) > 0) {
        $query = "UPDATE teachers SET name='$u_name',email='$u_email',dept_id='$u_department',designation='$u_designation',emp_id='$u_emp_id',address='$u_address',phone='$u_phone_no',gender='$u_gender',nationality='$u_nationality',religion='$u_religion',cnic='$u_cnic' WHERE id=$u_id";
        $query_run = mysqli_query($connection, $query);
        if ($query_run) {
            header('Location: teacherprofile.php?id=' . $u_id . '&update=updated');
        }
    } else {

        $query = "UPDATE teachers SET name='$u_name',password='$u_password',email='$u_email',dept_id='$u_department',designation='$u_designation',emp_id='$u_emp_id',address='$u_address',phone='$u_phone_no',gender='$u_gender',nationality='$u_nationality',religion='$u_religion',cnic='$u_cnic' WHERE id=$u_id";
        $query_run = mysqli_query($connection, $query);
        if ($query_run) {
            header('Location: teacherprofile.php?id=' . $u_id . '&update=updated');
        }
    }
}

if(isset($_POST['delete'])){
    include_once('includes/connection.php');

    $u_id = checkData($_POST['u_id']);
    $query = "DELETE FROM teachers WHERE id= $u_id";
    $query_run = mysqli_query($connection, $query);
    if($query_run){
        header('Location: teachers.php?delete=deleted');
    }
}


mysqli_close($connection);

?>
