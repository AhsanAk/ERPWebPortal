<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

<form action="importexcel.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file" id="file">
    <input type="submit" value="submit" name="submitExcelFile">
</form>

</body>
</html>


 <?php

        if(isset($_POST['submitExcelFile'])){


            $excelFile = $_FILES['excelFile']['name'];
            $excelFile_tmp = $_FILES['excelFile']['tmp_name'];

                move_uploaded_file($excelFile_tmp, 'excel/'.$excelFile);

 $connect = mysqli_connect("localhost", "root", "", "project");
 include ("PHPExcel/IOFactory.php");
 $html="<table border='1'>";  
 $objPHPExcel = PHPExcel_IOFactory::load("excel/".$excelFile);
 foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)   
 {  
      $highestRow = $worksheet->getHighestRow();  
      for ($row=2; $row<=$highestRow; $row++)
      {  
           $html.="<tr>";  
           $name = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
          $father_name = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
          $password = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
          $email = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
          $dept_id = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
          $dept_batch = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
          $en_no = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
          $roll_no = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
          $address = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
          $phone = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(9, $row)->getValue());
           $gender = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(10, $row)->getValue());
          $nationality = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(11, $row)->getValue());
          $religion = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(12, $row)->getValue());
          $domicile = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(13, $row)->getValue());
          $cnic = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(14, $row)->getValue());

          $sql = "INSERT INTO students(name ,father_name ,password ,email ,dept_id ,dept_batch ,en_no ,roll_no ,address ,phone ,gender ,nationality ,religion ,domicile ,cnic) VALUES ('".$name."', '".$father_name."', '".$password."', '".$email."', '".$dept_id."', '".$dept_batch."', '".$en_no."', '".$roll_no."', '".$address."', '".$phone."', '".$gender."', '".$nationality."', '".$religion."', '".$domicile."', '".$cnic."')";
           mysqli_query($connect, $sql);  
           }
 }
        }
 ?>