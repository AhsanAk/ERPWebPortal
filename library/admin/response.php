<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar_books.php'); ?>

<?php include_once('../../includes/connection.php');?>

    <div class="container">
		<div class="margin-top">
			<div class="row">	
			<div class="span12">	
			   <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;Books Requests</strong>
                                </div>
						<!--  -->

						<!--  -->
						<center class="title">
						<h1>Books List</h1>
						</center>
                            <table cellpadding="0" cellspacing="0" border="0" class="table  table-bordered" id="example">
								<div class="pull-right">
								<a href="" onclick="window.print()" class="btn btn-info"><i class="icon-print icon-large"></i> Print</a>
								</div>




								<thead>
                                    <tr>
									    <th>Roll No.</th>
                                        <th>Name</th>
                                        <th>Department</th>
										<th>Batch</th>
										<th>Book Name</th>
                                    </tr>
                                </thead>
                                <tbody>
								<tr>

								<?php
								$queryResponse = mysqli_query($connection, "select * from responses ");
								while($rowResponse= mysqli_fetch_assoc($queryResponse)){

									if($rowResponse['user_request']>='100' && $rowResponse['user_request']<'5000'){

										$queryStudent= mysqli_query($connection, "select * from students where id='".$rowResponse['user_request']."'");
										while($rowStudent=mysqli_fetch_assoc($queryStudent)){
											echo "<td>".$rowStudent['roll_no']."</td>";
											echo "<td>".$rowStudent['name']."</td>";
											echo "<td>".$rowStudent['dept_id']."</td>";
											echo "<td>".$rowStudent['dept_batch']."</td>";
											$queryBook= mysqli_query($connection, "select * from book where book_id='".$rowResponse['book_id']."'");
											while($rowBook=mysqli_fetch_assoc($queryBook)){
												echo "<td>".$rowBook['book_title']."</td>";
											}
											echo "</tr>";
										}

									}
								}
								?>

                                </tbody>
                            </table>
							
			
			</div>		
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