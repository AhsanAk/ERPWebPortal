<?php
session_start();

if(isset($_SESSION['name'])||isset($_COOKIE['name'])||isset($_SESSION['deo'])||isset($_COOKIE['deo'])){
    include_once('includes/connection.php');


    if(isset($_POST['name'])&&isset($_POST['password'])&&isset($_POST['emp_id'])&&isset($_POST['designation'])&&isset($_POST['gender'])&&isset($_POST['phone_no'])&&isset($_POST['email'])&&isset($_POST['department'])&&isset($_POST['cnic'])&&isset($_POST['nationality'])&&isset($_POST['religion'])&&isset($_POST['address'])){
        if(!empty($_POST['name'])&&!empty($_POST['password'])&&!empty($_POST['emp_id'])&&!empty($_POST['designation'])&&!empty($_POST['gender'])&&!empty($_POST['phone_no'])&&!empty($_POST['email'])&&!empty($_POST['department'])&&!empty($_POST['cnic'])&&!empty($_POST['nationality'])&&!empty($_POST['religion'])&&!empty($_POST['address'])) {


            $results = array();
            $emp_id = $_POST['emp_id'];


            $query = "SELECT emp_id FROM teachers WHERE emp_id = '".$emp_id."'";
            $query_run = mysqli_query($connection, $query);
            if(mysqli_num_rows($query_run) > 0){
                $results['emp_id']  = 'Employee ID already exists!';
            }else{

                $name = CheckData($_POST['name']);
                $password = CheckData($_POST['password']);
                $password = md5($password);
                $email = CheckData($_POST['email']);
                $designation = CheckData($_POST['designation']);
                $department_id = CheckData($_POST['department']);
                $emp_id = CheckData($_POST['emp_id']);
                $address = CheckData($_POST['address']);
                $phone = CheckData($_POST['phone_no']);
                $gender = CheckData($_POST['gender']);
                $nationality = CheckData($_POST['nationality']);
                $religion = CheckData($_POST['religion']);
                $cnic = CheckData($_POST['cnic']);
                $pic_name = $_FILES['file']['name'];
                $pic_tmpName = $_FILES['file']['tmp_name'];
                $pic_type = substr($_FILES['file']['type'], 6);
                $pic_size = $_FILES['file']['size'];

                $query = "SELECT picture FROM teachers WHERE picture = '".$emp_id."'";
                $query_run = mysqli_query($connection, $query);
                if(!mysqli_num_rows($query_run) > 0){
                    move_uploaded_file($pic_tmpName, 'teachers_picture/'.$emp_id.'.'.$pic_type);
                }

                $query = "INSERT INTO teachers (name, password, email, dept_id, designation, emp_id, address, phone, gender, nationality, religion, cnic, picture) VALUES ('".mysqli_real_escape_string($connection, $name)."', '".mysqli_real_escape_string($connection, $password)."', '".mysqli_real_escape_string($connection, $email)."', '".mysqli_real_escape_string($connection, $department_id)."', '".mysqli_real_escape_string($connection, $designation)."', '".mysqli_real_escape_string($connection, $emp_id)."', '".mysqli_real_escape_string($connection, $address)."', '".mysqli_real_escape_string($connection, $phone)."', '".mysqli_real_escape_string($connection, $gender)."', '".mysqli_real_escape_string($connection, $nationality)."', '".mysqli_real_escape_string($connection, $religion)."', '".mysqli_real_escape_string($connection, $cnic)."', '".mysqli_real_escape_string($connection, $emp_id. '.'.$pic_type)."')";
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
