<?php
session_start(); /*start of session*/
include_once('includes/connection.php');

    if($_POST['choose'] == 'admin'){

        if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['choose'])){
        if(!empty($_POST['username'])&&!empty($_POST['password'])&&!empty(['choose'])){

            $name = CheckData($_POST['username']);
            $password = CheckData($_POST['password']);
            $choose = CheckData($_POST['choose']);
            $password_hash = md5($password);
            (isset($_POST['remember'])) ? $remember = CheckData($_POST['remember']) : $remember = '';


            $query = "SELECT * FROM admin WHERE name='".mysqli_real_escape_string($connection, $name)."' AND password='".mysqli_real_escape_string($connection, $password_hash)."' AND role='admin'";
            $query_run = mysqli_query($connection, $query);

            $adminInfo = mysqli_fetch_assoc($query_run);

            $admin_results = array();


            if(mysqli_num_rows($query_run) > 0){

                $admin_results['result'] = 'success';
                $admin_results['name'] = $name;
                $_SESSION['name']  = $name;
                $_SESSION['adminId']  = $adminInfo['id'];
                if($remember == 'remember'){
                    $expire = time() + 300;
                    setcookie('name', $adminInfo['id'], $expire);
                }
            }else{
                    $admin_results['bic'] = 'bic';
                }
            }
        }
        echo json_encode($admin_results);
    }

    else if($_POST['choose'] == 'deo'){

        if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['choose'])){
            if(!empty($_POST['username'])&&!empty($_POST['password'])&&!empty(['choose'])){

                $name = CheckData($_POST['username']);
                $password = CheckData($_POST['password']);
                $choose = CheckData($_POST['choose']);
                $password_hash = md5($password);
                (isset($_POST['remember'])) ? $remember = CheckData($_POST['remember']) : $remember = '';


                $query = "SELECT * FROM admin WHERE name='".mysqli_real_escape_string($connection, $name)."' AND password='".mysqli_real_escape_string($connection, $password_hash)."' AND role='deo'";
                $query_run = mysqli_query($connection, $query);

                $deoInfo = mysqli_fetch_assoc($query_run);

                $deo_results = array();


                if(mysqli_num_rows($query_run) > 0){

                    $deo_results['result'] = 'success';
                    $deo_results['name'] = $name;
                    $_SESSION['deo']  = $name;
                    $_SESSION['deoId']  = $deoInfo['id'];
                    if($remember == 'remember'){
                        $expire = time() + 30;
                        setcookie('deo', $deoInfo['id'], $expire);
                    }
                }else{
                    $deo_results['bic'] = 'bic';
                }
            }
        }
        echo json_encode($deo_results);
    }

    else if($_POST['choose'] == 'librarian'){

        if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['choose'])){
            if(!empty($_POST['username'])&&!empty($_POST['password'])&&!empty(['choose'])){

                $name = CheckData($_POST['username']);
                $password = CheckData($_POST['password']);
                $choose = CheckData($_POST['choose']);
                $password_hash = md5($password);
                (isset($_POST['remember'])) ? $remember = CheckData($_POST['remember']) : $remember = '';


                $query = "SELECT * FROM librarian WHERE name='".mysqli_real_escape_string($connection, $name)."' AND password='".mysqli_real_escape_string($connection, $password_hash)."'";
                $query_run = mysqli_query($connection, $query);

                $librarian_results = array();


                if(mysqli_num_rows($query_run) > 0){

                    $librarian_results['result'] = 'success';
                    $librarian_results['name'] = $name;
                    $_SESSION['librarian']  = $librarian_results['name'];
                    if($remember == 'remember'){
                        $expire = time() + 30;
                        setcookie('name', $name, $expire);
                    }
                }else{
                        $librarian_results['bic'] = 'bic';
                    }
                }
            }
        echo json_encode($librarian_results);
    }
    else if ($_POST['choose'] == 'teacher'){


        if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['choose'])){
            if(!empty($_POST['username'])&&!empty($_POST['password'])&&!empty(['choose'])){

                $results = array();


                $name = CheckData($_POST['username']);
                $password = CheckData($_POST['password']);
                $choose = CheckData($_POST['choose']);
                $password_hash = md5($password);
                (isset($_POST['remember'])) ? $remember = CheckData($_POST['remember']) : $remember = '';


                $query = "SELECT * FROM teachers WHERE emp_id='".mysqli_real_escape_string($connection, $name)."' AND password='".mysqli_real_escape_string($connection, $password_hash)."'";
                $query_run = mysqli_query($connection, $query);

                $teacher_result = array();

                $query_name ="SELECT * FROM teachers WHERE emp_id='$name'";
                $query_run_name = mysqli_query($connection, $query_name);
                while($row_name = mysqli_fetch_assoc($query_run_name)){
                    $teacher_id = $row_name['id'];
                    $teacher_name = $row_name['name'];
                    $teacher_result['name'] = $teacher_name;
                }

                if(mysqli_num_rows($query_run) > 0){
                    $teacher_result['result'] = 'success';
                    $_SESSION['teacher']  = $teacher_id;
                    if($remember == 'remember'){
                        $expire = time() + 30;
                        setcookie('teacher', $teacher_id, $expire);
                    }
                }else{
                        $teacher_result['bic'] =  'bic';
                    }
                }
            }
        echo json_encode($teacher_result);
    }
 else if ($_POST['choose'] == 'student'){


        if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['choose'])){
            if(!empty($_POST['username'])&&!empty($_POST['password'])&&!empty(['choose'])){

                $results = array();


                $name = CheckData($_POST['username']);
                $password = CheckData($_POST['password']);
                $choose = CheckData($_POST['choose']);
                $password_hash = md5($password);
                (isset($_POST['remember'])) ? $remember = CheckData($_POST['remember']) : $remember = '';

                $student_result = array();

                $query = "SELECT * FROM students WHERE roll_no='".mysqli_real_escape_string($connection, $name)."' AND activated='0'";
                $query_run = mysqli_query($connection, $query);
                if(mysqli_num_rows($query_run) > 0) {
                    $student_result['activate'] = 'inactive';
                    $student_result['name']=$name;
                }
                else{
                $query = "SELECT * FROM students WHERE roll_no='".mysqli_real_escape_string($connection, $name)."' AND password='".mysqli_real_escape_string($connection, $password_hash)."' AND activated='1'";
                $query_run = mysqli_query($connection, $query);


                $query_name ="SELECT * FROM students WHERE roll_no='$name'";
                $query_run_name = mysqli_query($connection, $query_name);
                while($row_name = mysqli_fetch_assoc($query_run_name)){
                    $student_id = $row_name['id'];
                    $student_name = $row_name['name'];
                    $student_result['name'] = $student_name;
                }

                if(mysqli_num_rows($query_run) > 0){
                    $student_result['result'] = 'success';
                    $_SESSION['student']  = $student_id;
                    if($remember == 'remember'){
                        $expire = time() + 30;
                        setcookie('student', $student_id, $expire);
                    }
                }
            else{
                        $student_result['bic'] =  'bic';
                    }
                }
            }}else{
            header('Location:index.php');
        }

     echo json_encode($student_result);
    }


    function CheckData($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripcslashes($data);
    return $data;
}

mysqli_close($connection);

?>