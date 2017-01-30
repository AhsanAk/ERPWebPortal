<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar_books.php'); ?>
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
										<li><a href="books.php">All</a></li>
										<li><a href="new_books.php">New Books</a></li>
										<li><a href="old_books.php">Old Books</a></li>
										<li><a href="lost.php">Lost Books</a></li>
										<li><a href="damage.php">Damage Books</a></li>
										<li class="active"><a href="sub_rep.php">Subject for Replacement</a></li>
									</ul>
						<!--  -->
						<center class="title">
						<h1>Subject for Replacement</h1>
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
                                        <th>Department</th>
										<th>Author</th>
										<th class="action">copies</th>
										<th>Book Pub</th>
										<th>Publisher Name</th>
										<th>ISBN</th>
										<th>Copyright Year</th>
										<th>Date Added</th>
										<th class="action">Action</th>		
                                    </tr>
                                </thead>
                                <tbody>
								 
                                  <?php  $user_query=mysql_query("select * from book where status = 'Subject for Replacement'")or die(mysql_error());
									while($row=mysql_fetch_array($user_query)){
									$id=$row['book_id'];  
									$dept_id=$row['dept_id'];

											$dept_query = mysql_query("select * from department where dept_id = '$cat_id'")or die(mysql_error());
											$dept_row = mysql_fetch_array($dept_query);
									?>
									<tr class="del<?php echo $id ?>">
									
									                              
                                    <td><?php echo $row['book_id']; ?></td>
                                    <td><?php echo $row['book_title']; ?></td>
									<td><?php echo $dept_row ['dept_name']; ?> </td>
                                    <td><?php echo $row['author']; ?> </td> 
                                    <td class="action"><?php echo $row['book_copies']; ?> </td>
                                     <td><?php echo $row['book_pub']; ?></td>
									 <td><?php echo $row['publisher_name']; ?></td>
									 <td><?php echo $row['isbn']; ?></td>
									 <td><?php echo $row['copyright_year']; ?></td>		
									 <td><?php echo $row['date_added']; ?></td>
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
			</div>
		</div>
    </div>
<?php include('footer.php') ?>