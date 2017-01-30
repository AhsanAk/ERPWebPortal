<?php


$servername = 'localhost';
$username = 'root';
$password = '';
$db = 'project';

$connection = mysqli_connect($servername, $username, $password);

/* CREATING DATABASE project  */

$query = "CREATE DATABASE IF NOT EXISTS $db";
$query_run = mysqli_query($connection, $query);

if(!$query_run){
	echo 'Error in creating database: ' . mysqli_error($connection);
}

/* CONNECTING WITH DATABASE project */
ini_set('max_execution_time', 300);
$connection = mysqli_connect($servername, $username, $password, $db);
if(!$connection){
	echo 'Error in connecting Database: ' . mysqli_error($connection);
}

/* CREATING TABLE admin IN DATABASE project */

$query = "CREATE TABLE IF NOT EXISTS admin (
			id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(20) NOT NULL,
			password VARCHAR(32) NOT NULL,
			email VARCHAR(32),
			role VARCHAR(6),
			dept_id INT(1)
)";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table admin: ' . mysqli_error($connection);
}

/* CREATING TABLE librarian IN DATABASE project */

$query = "CREATE TABLE IF NOT EXISTS librarian (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(20) NOT NULL,
			password VARCHAR(32) NOT NULL,
			email VARCHAR(32)
)";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table librarian: ' . mysqli_error($connection);
}
/* CREATING TABLE Events IN DATABASE project */

$query = "CREATE TABLE IF NOT EXISTS events (
			id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			event_title VARCHAR(40) NOT NULL,
			event_place VARCHAR(32) NOT NULL,
			event_for VARCHAR(10),
			event_date VARCHAR (12),
			event_time VARCHAR (12),
			event_description text NOT NULL
)";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table Events: ' . mysqli_error($connection);
}

/* CREATING TABLE Responses IN DATABASE project */

$query = "CREATE TABLE IF NOT EXISTS responses (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			user_request VARCHAR(32) NOT NULL,
			book_id int(3) NOT NULL
)";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table responses: ' . mysqli_error($connection);
}

/* CREATING TABLE department IN DATABASE project */

$query = "CREATE TABLE IF NOT EXISTS department (
			dept_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			dept_name VARCHAR(100) NOT NULL,
			dept_batch INT(6) NOT NULL



)";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table department: ' . mysqli_error($connection);
}


/* CREATING TABLE students IN DATABASE project */

$query = "CREATE TABLE IF NOT EXISTS students (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(32) NOT NULL,
			father_name VARCHAR(32) NOT NULL,
			password VARCHAR(32) NOT NULL,
			email VARCHAR(32) NOT NULL,
			dept_id INT(6) NOT NULL,
			dept_batch INT(6) NOT NULL,
			en_no int(8) NOT NULL ,
			roll_no VARCHAR(32) NOT NULL UNIQUE,
			address text NOT NULL,
			phone VARCHAR(32) NOT NULL,
			gender VARCHAR(15) NOT NULL,
			nationality VARCHAR(20) NOT NULL,
			religion VARCHAR(15) NOT NULL,
			domicile VARCHAR(15) NOT NULL,
			cnic varchar(15) NOT NULL,
			picture VARCHAR(32) NOT NULL,
			type VARCHAR (15) NOT NULL DEFAULT 'Student',
			activated VARCHAR (15) NOT NULL DEFAULT '0',
			status VARCHAR (15) NOT NULL DEFAULT 'Active'


) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table students: ' . mysqli_error($connection);
}


/* CREATING TABLE for Library IN DATABASE project */

$query = "CREATE TABLE IF NOT EXISTS book (
 book_id int(11) NOT NULL AUTO_INCREMENT,
 book_title varchar(100) NOT NULL,
 dept_id int(50) NOT NULL,
 author varchar(50) NOT NULL,
 book_copies int(11) NOT NULL,
 book_pub varchar(100) NOT NULL,
 publisher_name varchar(100) NOT NULL,
 isbn varchar(50) NOT NULL,
 copyright_year int(11) NOT NULL,
 date_receive varchar(20) NOT NULL,
 date_added datetime NOT NULL,
 status varchar(30) NOT NULL,
 PRIMARY KEY (book_id)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table book_lib: ' . mysqli_error($connection);
}

$query = "	CREATE TABLE IF NOT EXISTS batch (
	id int(11) NOT NULL AUTO_INCREMENT,
 	batch_no int(9) NOT NULL,
 	batch_id int(9) NOT NULL,
 	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table batch: ' . mysqli_error($connection);
}

$query = "SELECT * FROM batch WHERE batch_no = '2013' OR batch_no ='2014' OR batch_no ='2015' OR batch_no ='2016'";
$query_run = mysqli_query($connection, $query);
if(!mysqli_num_rows($query_run)> 0){
	$query = "INSERT INTO batch (batch_id, batch_no) VALUES ('2013', '2013'), ('2014', '2014'), ('2015', '2015'), ('2016', '2016')";
	$query_run = mysqli_query($connection, $query);
}

$query = "	CREATE TABLE IF NOT EXISTS semester (
	 semester_id int(4) NOT NULL AUTO_INCREMENT,
 	semester_name varchar(10) NOT NULL,
	PRIMARY KEY (semester_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table semester: ' . mysqli_error($connection);
}

$query = "SELECT * FROM semester WHERE semester_name = '1st' OR semester_name = '2nd' OR semester_name = '3rd' OR semester_name = '4th' OR semester_name = '5th' OR semester_name = '6th' OR semester_name = '7th' OR semester_name = '8th'";
$query_run = mysqli_query($connection, $query);
if(!mysqli_num_rows($query_run)> 0){
	$query = "INSERT INTO semester (semester_name) VALUES ('1st'),('2nd'),('3rd'),('4th'),('5th'),('6th'),('7th'),('8th')";
	$query_run = mysqli_query($connection, $query);
}

$query = "	CREATE TABLE IF NOT EXISTS borrow (
 borrow_id int(11) NOT NULL AUTO_INCREMENT,
 member_id bigint(50) NOT NULL,
 date_borrow varchar(100) NOT NULL,
 due_date varchar(100) DEFAULT NULL,
 PRIMARY KEY (borrow_id),
 KEY borrowerid (member_id),
 KEY borrowid (borrow_id)
) ENGINE=InnoDB AUTO_INCREMENT=487 DEFAULT CHARSET=utf8";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table borrow_lib: ' . mysqli_error($connection);
}


$query = "CREATE TABLE IF NOT EXISTS borrowdetails (
 borrow_details_id int(11) NOT NULL AUTO_INCREMENT,
 book_id int(11) NOT NULL,
 borrow_id int(11) NOT NULL,
 borrow_status varchar(50) NOT NULL,
 date_return varchar(100) NOT NULL,
 PRIMARY KEY (borrow_details_id)
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=latin1";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table borrowdetails_lib: ' . mysqli_error($connection);
}

$query = "CREATE TABLE IF NOT EXISTS lost_book (
 Book_ID int(11) NOT NULL AUTO_INCREMENT,
 ISBN int(11) NOT NULL,
 Member_No varchar(50) NOT NULL,
 `Date Lost` date NOT NULL,
 PRIMARY KEY (Book_ID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table lost_book_lib: ' . mysqli_error($connection);
}


$query = "CREATE TABLE IF NOT EXISTS type (
 id int(11) NOT NULL AUTO_INCREMENT,
 borrowertype varchar(50) DEFAULT NULL,
 PRIMARY KEY (id),
 KEY borrowertype (borrowertype),
 KEY id (id)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table type_lib: ' . mysqli_error($connection);
}


/* CREATING TABLE teachers IN DATABASE project */

$query = "CREATE TABLE IF NOT EXISTS teachers (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(32) NOT NULL,
			password VARCHAR(32) NOT NULL,
			emp_id VARCHAR(32) NOT NULL UNIQUE,
			email VARCHAR(32) NOT NULL,
			designation VARCHAR (32) NOT NULL,
			dept_id INT(6) NOT NULL,
			address VARCHAR(255) NOT NULL,
			phone VARCHAR(255) NOT NULL,
			gender VARCHAR(15) NOT NULL,
			nationality VARCHAR(20) NOT NULL,
			religion VARCHAR(15) NOT NULL,
			cnic varchar(32) NOT NULL,
			picture VARCHAR(32) NOT NULL,
			type VARCHAR (15) NOT NULL DEFAULT 'Teacher',
			status VARCHAR (15) NOT NULL DEFAULT 'Active'


) ENGINE=InnoDB AUTO_INCREMENT=5000 DEFAULT CHARSET=latin1";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table teachers: ' . mysqli_error($connection);
}


/* INSERTING username and password 'admin' to admin's table */


$query = "SELECT * FROM admin WHERE name = 'admin' OR role = 'admin'";
$query_run = mysqli_query($connection, $query);

$deoArray = ['cs-duet', 'ch-duet', 'me-duet', 'in-duet', 'pg-duet', 'es-duet', 'ee-duet', 'te-duet', 'ar-duet'];

if(!mysqli_num_rows($query_run)> 0){
	$query = "INSERT INTO admin (name, password, role) VALUES ('admin', '".md5('admin')."', 'admin')";
	$query_run = mysqli_query($connection, $query);

	$dept_id = 1;

	foreach($deoArray as $deo){
		$query = "INSERT INTO admin (name, password, role, dept_id) VALUES ('$deo', '".md5('duet')."','deo',$dept_id)";
		$query_run = mysqli_query($connection, $query);
		$dept_id++;
	}
}

/* INSERTING username and password 'librarian' to librarian table */


$query = "SELECT * FROM librarian WHERE name = 'librarian' AND password= '".md5('librarian')."'";
$query_run = mysqli_query($connection, $query);
if(!mysqli_num_rows($query_run)> 0){
	$query = "INSERT INTO librarian (name, password) VALUES ('librarian', '".md5('librarian')."')";
	$query_run = mysqli_query($connection, $query);
}

/* INSERTING dept_id and dept_name and batch 'department' to department's table */

$deptname=['Computer System Engineering','Chemical Engineering','Metallurgy Engineering','Industrial Engineering','Petroleum & Gas Engineering','Electronics Engineering','Energy & Environment Engineering','Telecommunication Engineering','Architecture'];
$query = "SELECT * FROM department";
$query_run = mysqli_query($connection, $query);
if(!mysqli_num_rows($query_run)> 0){
	foreach($deptname as $deparments){
		$query = "INSERT INTO department (dept_name) VALUES ('".$deparments."')";
		$query_run = mysqli_query($connection, $query);
	}

}


/* CREATING table student_attendance */

$query = "CREATE TABLE IF NOT EXISTS student_attendance (
 id int(11) NOT NULL AUTO_INCREMENT,
 dept_id int(11) NOT NULL,
 dept_batch int(11) NOT NULL,
 semester varchar(50) NOT NULL,
 subject_code varchar(50) NOT NULL,
 subject_attendance varchar(100) NOT NULL,
 student_rollNo varchar(100) NOT NULL,
 timing varchar(20) NOT NULL,
 date varchar(10) NOT NULL,
 PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=latin1";


$query_run = mysqli_query($connection, $query);
if(!$query_run){
	die(mysqli_error($connection));
}


$query = "CREATE TABLE IF NOT EXISTS subjects (
 id int(11) NOT NULL AUTO_INCREMENT,
 dept_id int(11) NOT NULL,
 semester varchar(20) NOT NULL,
 subject varchar(60) NOT NULL,
 course_code varchar(30) NOT NULL,
 theory_ch int(3) NOT NULL,
 practical_ch int(3) NOT NULL,
 PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";


$query_run = mysqli_query($connection, $query);
if(!$query_run){
	die(mysqli_error($connection));
}


/* Feedback */

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
)ENGINE=InnoDB DEFAULT CHARSET=utf8";

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8";


$query_run = mysqli_query($connection, $query);
if(!$query_run){
    echo 'ERROR in creating table pm: ';
}



/*  CREATING exam result  table */

$query = "	CREATE TABLE IF NOT EXISTS student_examresult (
id int(11) NOT NULL AUTO_INCREMENT,
 roll_no varchar(15),
 dept_batch int(4),
 dept_id int(1),
 semester varchar(5),
 subject_code varchar(12),
 subject_theoryMarks int(3),
 subject_practicalMarks int(3),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";


$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table result: ' . mysqli_error($connection);
}

/* CREATING TABLE Assignment IN DATABASE project */

$query = "CREATE TABLE IF NOT EXISTS assignment (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			title VARCHAR(32) NOT NULL,
			dept_id VARCHAR(32) NOT NULL,
			dept_batch VARCHAR(32),
			semester VARCHAR (12),
			deadline varchar (12),
			subject varchar (12),
			assignment_file VARCHAR(32),
			description text NOT NULL
)";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table assignment: ' . mysqli_error($connection);
}

/* CREATING TABLE lectures IN DATABASE project */

$query = "CREATE TABLE IF NOT EXISTS lectures (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			title VARCHAR(32) NOT NULL,
			dept_id VARCHAR(32) NOT NULL,
			dept_batch VARCHAR(32),
			semester VARCHAR (12),
			date varchar (12),
			subject varchar (12),
			lecture_file VARCHAR(32),
			description text NOT NULL
)";

$query_run = mysqli_query($connection, $query);
if(!$query_run){
	echo 'ERROR in creating table lectures: ' . mysqli_error($connection);
}
?>


