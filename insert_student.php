<?php
session_start();

    if(isset($_SESSION['name'])||isset($_COOKIE['name'])||isset($_SESSION['deo'])||isset($_COOKIE['deo'])){
        include_once('includes/connection.php');


        if(isset($_POST['name'])&&isset($_POST['password'])&&isset($_POST['fathername'])&&isset($_POST['gender'])&&isset($_POST['phone_no'])&&isset($_POST['email'])&&isset($_POST['department'])&&isset($_POST['roll_no'])&&isset($_POST['cnic'])&&isset($_POST['en_ro'])&&isset($_POST['nationality'])&&isset($_POST['religion'])&&isset($_POST['address'])&&isset($_POST['domicile'])){
    if(!empty($_POST['name'])&&!empty($_POST['password'])&&!empty($_POST['fathername'])&&!empty($_POST['gender'])&&!empty($_POST['phone_no'])&&!empty($_POST['email'])&&!empty($_POST['department'])&&!empty($_POST['roll_no'])&&!empty($_POST['cnic'])&&!empty($_POST['en_ro'])&&!empty($_POST['nationality'])&&!empty($_POST['religion'])&&!empty($_POST['address'])&&!empty($_POST['domicile'])) {

        $results = array();
        $ro_no_batch =  $_POST['roll_no_batch'];
        $ro_no_depart =  $_POST['roll_no_depart'];
         $ro_no_id =  $_POST['roll_no'];

         $ro_no = "D-".$ro_no_batch. "-".$ro_no_depart. "-".$ro_no_id;



        $query = "SELECT roll_no FROM students WHERE roll_no = '".$ro_no."'";
        $query_run = mysqli_query($connection, $query);
        if(mysqli_num_rows($query_run) > 0){
            $results['rollno']  = 'Roll number already exists!';
        }else{

        $name = CheckData($_POST['name']);
        $fathername = CheckData($_POST['fathername']);
        $password = CheckData($_POST['password']);
        $password = md5($password);
        $email = CheckData($_POST['email']);
        $department_id = CheckData($_POST['department']);
        $en_no = CheckData($_POST['en_ro']);
        $address = CheckData($_POST['address']);
        $phone = CheckData($_POST['phone_no']);
        $gender = CheckData($_POST['gender']);
        $batch = CheckData($_POST['batch'] + 2000);
        $nationality = CheckData($_POST['nationality']);
        $religion = CheckData($_POST['religion']);
        $domicile = CheckData($_POST['domicile']);
        $cnic = CheckData($_POST['cnic']);
        $pic_name = $_FILES['file']['name'];
        $pic_tmpName = $_FILES['file']['tmp_name'];
        $pic_type = substr($_FILES['file']['type'], 6);
        $pic_size = $_FILES['file']['size'];

            $query = "SELECT picture FROM students WHERE picture = '".$ro_no."'";
            $query_run = mysqli_query($connection, $query);
            if(!mysqli_num_rows($query_run) > 0){
                move_uploaded_file($pic_tmpName, 'student_picture/'.$ro_no.'.'.$pic_type);
            }

        $query = "INSERT INTO students (name, father_name, password, email, dept_id, dept_batch, en_no, roll_no, address, phone, gender, nationality, religion, domicile, cnic, picture, activated) VALUES ('".mysqli_real_escape_string($connection, $name)."', '".mysqli_real_escape_string($connection, $fathername)."', '".mysqli_real_escape_string($connection, $password)."', '".mysqli_real_escape_string($connection, $email)."', '".mysqli_real_escape_string($connection, $department_id)."', '".mysqli_real_escape_string($connection, $batch)."', '".mysqli_real_escape_string($connection, $en_no)."', '".mysqli_real_escape_string($connection, $ro_no)."', '".mysqli_real_escape_string($connection, $address)."', '".mysqli_real_escape_string($connection, $phone)."', '".mysqli_real_escape_string($connection, $gender)."', '".mysqli_real_escape_string($connection, $nationality)."', '".mysqli_real_escape_string($connection, $religion)."', '".mysqli_real_escape_string($connection,$domicile)."', '".mysqli_real_escape_string($connection, $cnic)."', '".mysqli_real_escape_string($connection, $ro_no. '.'.$pic_type)."','1')";
        $query_run = mysqli_query($connection, $query);
        if($query_run){
            $last_id = mysqli_insert_id($connection);
            $results['row'] = $last_id;
            $results['insert'] = 'Data Inserted';
        }
        }
    }
}else{
            header('Location:index.php');
        }

        echo json_encode($results);
    }


function CheckData($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripcslashes($data);
    return $data;
}



mysqli_close($connection);
?>
