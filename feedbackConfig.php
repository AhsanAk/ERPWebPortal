<?php
//We start sessions
@session_start();

/******************************************************
------------------Required Configuration---------------
Please edit the following variables so the members area
can work correctly.
******************************************************/

//We log to the DataBase
$connection = mysqli_connect('localhost','root', '', 'project');


$query = "CREATE TABLE IF NOT EXISTS pm (
          id bigint(20) NOT NULL,
          id2 int(11) NOT NULL,
          title varchar(256) NOT NULL,
          user1 bigint(20) NOT NULL,
          user2 bigint(20) NOT NULL,
          message text NOT NULL,
          timestamp int(10) NOT NULL,
          user1read varchar(3) NOT NULL,
          user2read varchar(3) NOT NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
    echo 'ERROR in creating table pm: ';
}

$query="CREATE TABLE IF NOT EXISTS users (
  id bigint(20) NOT NULL,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  avatar text NOT NULL,
  signup_date int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8";


$query_run = mysqli_query($connection, $query);
if(!$query_run){
    echo 'ERROR in creating table pm: ';
}



//Webmaster Email
$mail_webmaster = 'example@example.com';

//Top site root URL
$url_root = 'http://www.example.com/';

/******************************************************
-----------------Optional Configuration----------------
******************************************************/

//Home page file name
$url_home = 'index.php';

//Design Name
$design = 'default';


if(isset($_SESSION['name'])){
$adminId= "SELECT * from admin WHERE name = '".$_SESSION['name']."'";
$adminQuery = mysqli_query($connection, $adminId);
$user_id = mysqli_fetch_assoc($adminQuery);

}else if(isset($_SESSION['student'])){

    $studentID= "SELECT * from students WHERE id = '".$_SESSION['student']."'";
    $studentQuery = mysqli_query($connection, $studentID);
    $user_id = mysqli_fetch_assoc($studentQuery);


}else if(isset($_COOKIE['name'])){

    $adminId= "SELECT * from admin WHERE id = '".$_COOKIE['name']."'";
    $adminQuery = mysqli_query($connection, $adminId);
    $user_id = mysqli_fetch_assoc($adminQuery);

}else if(isset($_COOKIE['student'])){
    $studentID= "SELECT * from students WHERE id = '".$_COOKIE['student']."'";
    $studentQuery = mysqli_query($connection, $studentID);
    $user_id = mysqli_fetch_assoc($studentQuery);

}



?>