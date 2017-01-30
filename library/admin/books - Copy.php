<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar_books.php'); ?>
<?php include('../../includes/connection.php'); ?>
<?php


if(isset($_POST['submitExcelFile'])){


	$excelFile = $_FILES['excelFile']['name'];
	$excelFile_tmp = $_FILES['excelFile']['tmp_name'];

	move_uploaded_file($excelFile_tmp, 'excel/'.$excelFile);

	include ("../../PHPExcel/IOFactory.php");
	$objPHPExcel = PHPExcel_IOFactory::load("excel/".$excelFile);
	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
	{
		$highestRow = $worksheet->getHighestRow();
		for ($row=2; $row<=$highestRow; $row++)
		{
			$book_title = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
			$dept_id = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
			$author = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
			$book_copies = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
			$book_pub = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
			$publisher_name = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
			$isbn = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
			$copyright_year = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
			$date_receive = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
			$date_added = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(9, $row)->getValue());
			$status = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(10, $row)->getValue());

			$sql = "INSERT INTO book(book_title ,dept_id ,author ,book_copies ,book_pub ,publisher_name ,isbn ,copyright__year ,date_receive ,date_added ,status) VALUES ('".$book_title."', '".$dept_id."', '".$author."', '".$book_copies."', '".$book_pub."', '".$publisher_name."', '".$isbn."', '".$copyright_year."', '".$date_receive."', '".$date_added."', '".$status."')";
			mysqli_query($connection, $sql);


		}
	}
	unlink('excel/'.$excelFile);
}


?>
	<style>
		/* sic.php  Excel Image Input Form*/

		#addExcel{
			display: inline-block;
		}

		#submitExcelFile{
			display: none;
		}

		#excelFile, #file{
			display: none;
		}

		.btnFileLabel{
			margin-top: -20px;
		}

		#errorExcel{
			color: red;
			display: none;
		}

	</style>
	<div class="container">
		<div class="margin-top">
			<div class="row">	
			<div class="span12">
			   <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;Books Table</strong>
                                </div>
						<!--  -->
								    <ul class="nav nav-pills">
										<li   class="active"><a href="books.php">All</a></li>
										<li><a href="new_books.php">New Books</a></li>
										<li><a href="old_books.php">Old Books</a></li>
										<li><a href="lost.php">Lost Books</a></li>
										<li><a href="damage.php">Damage Books</a></li>
										<li><a href="sub_rep.php">Subject for Replacement</a></li>
									</ul>
						<!--  -->
						<center class="title">
						<h1>Books List</h1>
						</center>
                            <table cellpadding="0" cellspacing="0" border="0" class="table  table-bordered" id="example">
								<div class="pull-right">
								<a href="" onclick="window.print()" class="btn btn-info"><i class="icon-print icon-large"></i> Print</a>
								</div>
								<p><a href="add_books.php" class="btn btn-success"><i class="icon-plus"></i>&nbsp;Add Books</a></p>

							
                                <thead>
                                    <tr>
									    <th>Acc No.</th>                                 
                                        <th>Book Title</th>                                 
                                        <th>Category</th>
										<th>Author</th>
										<th class="action">copies</th>
										<th>Book Pub</th>
										<th>Publisher Name</th>
										<th>ISBN</th>
										<th>Copyright Year</th>
										<th>Date Added</th>
										<th>Status</th>
										<th class="action">Action</th>		
                                    </tr>
                                </thead>
                                <tbody>
								<span id="errorExcel"></span>
                                  <?php 

							
							
									

								  $user_query=mysql_query("select * from book where status != 'Archive'")or die(mysql_error());
									while($row=mysql_fetch_array($user_query)){
									$id=$row['book_id'];  
									$cat_id=$row['category_id'];
									$book_copies = $row['book_copies'];
									
									$borrow_details = mysql_query("select * from borrowdetails where book_id = '$id' and borrow_status = 'pending'");
									$row11 = mysql_fetch_array($borrow_details);
									$count = mysql_num_rows($borrow_details);
									
									$total =  $book_copies  -  $count; 
									/* $t4otal =  $book_copies  - $borrow_details;
									
									echo $total; */
											$cat_query = mysql_query("select * from category where category_id = '$cat_id'")or die(mysql_error());
											$cat_row = mysql_fetch_array($cat_query);
									?>
									<tr class="del<?php echo $id ?>">
                                    <td><?php echo $row['book_id']; ?></td>
                                    <td><?php echo $row['book_title']; ?></td>
									<td><?php echo $cat_row ['classname']; ?> </td>
                                    <td><?php echo $row['author']; ?> </td> 
                                    <td class="action"><?php echo /* $row['book_copies']; */   $total;   ?> </td>
                                     <td><?php echo $row['book_pub']; ?></td>
									 <td><?php echo $row['publisher_name']; ?></td>
									 <td><?php echo $row['isbn']; ?></td>
									 <td><?php echo $row['copyright_year']; ?></td>		
									 <td><?php echo $row['date_added']; ?></td>
									 <td><?php echo $row['status']; ?></td>
									<?php include('toolttip_edit_delete.php'); ?>
                                    <td class="action">
                                        <a rel="tooltip"  title="Delete" id="<?php echo $id; ?>" href="#delete_book<?php echo $id; ?>" data-toggle="modal"    class="btn btn-danger"><i class="icon-trash icon-large"></i></a>
                                        <?php include('delete_book_modal.php'); ?>
										<a  rel="tooltip"  title="Edit" id="e<?php echo $id; ?>" href="edit_book.php<?php echo '?id='.$id; ?>" class="btn btn-success"><i class="icon-pencil icon-large"></i></a>
										
                                    </td>
									
                                    </tr>
									<?php  }  ?>
                           
                                </tbody>
                            </table>
							
			
			</div>
				<form action="<?php echo htmlspecialchars('books.php'); ?>" id="addExcel" method="post" enctype="multipart/form-data" name="addExcel">

					<label class="btn btn-success btn-file btnFileLabel">
           <span class="fa fa-file-excel-o" aria-hidden="true"> Import from Excel File<span><input id="excelFile" name="excelFile" type="file">
					</label>
					<input type="submit" value="submit" name="submitExcelFile" id="submitExcelFile">
				</form>
			</div>
		</div>
    </div>
	<script>

		$(document).ready(function(){


			$('#excelFile').change(function(){
				var file = this.files[0];
				var imagefile = file.type;
				if(imagefile === 'application/vnd.ms-excel'){
					$('#submitExcelFile').click();
				}else{
					$(this).val('');
					$('#errorExcel').text('Excel file is accepted only.').fadeIn('slow').delay('2000').fadeOut('slow');
				}
			});



		});

	</script>
<?php include('footer.php') ?>