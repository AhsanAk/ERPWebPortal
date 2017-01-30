<?php
session_start();


include 'checkData.php';
if(isset($_SESSION['name'])||isset($_COOKIE['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])||isset($_SESSION['student'])||isset($_COOKIE['student'])){


    if(isset($_POST['yesRequestId'])){
        include_once 'includes/connection.php';

        $book_id = (int) checkData($_POST['yesRequestId']);
        if(isset($_SESSION['name'])||isset($_COOKIE['name'])){
            $nameRequest= $_SESSION['name'];
        }
        if(isset($_SESSION['student'])||isset($_COOKIE['student'])){
            $nameRequest= $_SESSION['student'];
        }

        $requestQuery=mysqli_query($connection, "insert into responses (book_id, user_request) VALUES ('$book_id', '$nameRequest')");
        if($requestQuery){
            echo 'inserted';
        }



    }

   else if(isset($_POST['id'])){

        include_once 'includes/connection.php';

        $dept_id = (int) checkData($_POST['id']);

       if(isset($_SESSION['name'])||isset($_COOKIE['name'])||isset($_COOKIE['deo'])||isset($_SESSION['deo'])){
           $nameRequest= $_SESSION['name'];
       } else if(isset($_SESSION['student'])||isset($_COOKIE['student'])){
           $nameRequest= $_SESSION['student'];
       }

        $queryBook = "SELECT * FROM book WHERE dept_id = '$dept_id'";
        $queryRunBook = mysqli_query($connection, $queryBook);
        if(!mysqli_num_rows($queryRunBook)>0){
            echo "<p class='text-danger animated flash lead'>No results found.</p>";
        }else{

            echo "<table class='table table-responsive table-bordered animated flipInX'>";
            echo "<tr>";
            echo "<th>Book Title</th>";
            echo "<th>Author</th>";
            echo "<th>ISBN</th>";
            echo "<th>Book Copies</th>";
            echo "<th>Request</th>";
            echo "</tr>";


            while($row = mysqli_fetch_assoc($queryRunBook)){
                echo "<tr>";
                echo "<td class='hidden'>".$row['book_id']."</td>";
                echo "<td>".$row['book_title']."</td>";
                echo "<td>".$row['author']."</td>";
                echo "<td>".$row['isbn']."</td>";
                echo "<td>".$row['book_copies']."</td>";
                $queryResponseCheck= mysqli_query($connection, "select * from responses");

                $check= 0;
                while($rowResponse=mysqli_fetch_assoc($queryResponseCheck)) {

                    if ($rowResponse['user_request'] == $nameRequest && $rowResponse['book_id'] == $row['book_id']) {
                        echo "<td>Requested</td>";
                        $check=1;
                        break;


                    }

                    }

                if(mysqli_num_rows($queryResponseCheck) == 0 || $check==0){
                    echo "<td><button class='btn btn-primary requestBtn'><i class='fa fa-plus-square' title='Request for this book'></i></button></td>";
                }


                echo "</tr>";
            }
            echo "</table>";

        }


    }



}
else{
    header('Location:index.php');
}





mysqli_close($connection);



?>