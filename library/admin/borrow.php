<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar_borrow.php'); ?>
    <div class="container">
		<div class="margin-top">
			<div class="row">	
								<div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;Borrow Table</strong>
                                </div>

		<div class="span12">		

		<form method="post" action="borrow_save.php">
<div class="span3">

											<div class="control-group">
				<label class="control-label" for="inputEmail">Borrower Name</label>
				<div class="controls">
				<select name="member_id" class="chzn-select"required/>
				<option></option>
				<?php $result =  mysql_query("select * from students")or die(mysql_error());
				while ($row=mysql_fetch_array($result)){ ?>
				<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
				<?php } ?>
				</select>
				</div>
			</div>
				<div class="control-group"> 
					<label class="control-label" for="inputEmail">Due Date</label>
					<div class="controls">
					<input type="text"  class="w8em format-d-m-y highlight-days-67 range-low-today" name="due_date" id="sd" maxlength="10" style="border: 3px double #CCCCCC;" required/>
					</div>
				</div>
				<div class="control-group"> 
					<div class="controls">

								<button name="delete_student" class="btn btn-success"><i class="icon-plus-sign icon-large"></i> Borrow</button>
					</div>
				</div>
				</div>
				<div class="span8">
						<div class="alert alert-info"><strong>Select Book</strong></div>
                            <table cellpadding="0" cellspacing="0" border="0" class="table  table-bordered dataTable" id="example">

                                <thead>
                                    <tr>
                       
                                        <th>Acc No.</th>                                 
                                        <th>Book title</th>                                 
                                        <th>Department</th>
										<th>Author</th>
										<th>Publisher name</th>
										<th>status</th>
										<th>Add</th>
										
                                    </tr>
                                </thead>
                                <tbody>
								 
                                  <?php  $user_query=mysql_query("select * from book where status != 'Archive' ")or die(mysql_error());
									while($row=mysql_fetch_array($user_query)){
									$id=$row['book_id'];  
									$dept_id=$row['dept_id'];

											$dept_query = mysql_query("select * from department where dept_id = '$dept_id'")or die(mysql_error());
											$dept_row = mysql_fetch_array($dept_query);
									?>
									<tr class="del<?php echo $id ?>">
									
									                              
                                    <td><?php echo $row['book_id']; ?></td>
                                    <td><?php echo $row['book_title']; ?></td>
									<td><?php echo $dept_row ['dept_name']; ?> </td>
                                    <td><?php echo $row['author']; ?> </td> 
									 <td><?php echo $row['publisher_name']; ?></td>
									  <td width=""><?php echo $row['status']; ?></td> 
									<?php include('toolttip_edit_delete.php'); ?>
                                    <td width="20">
												<input id="" class="uniform_on" name="selector[]" type="checkbox" value="<?php echo $id; ?>" >
												
                                    </td>
									
                                    </tr>
									<?php  }  ?>
                                </tbody>
                            </table>
							
			    </form>
			</div>		
			</div>		
<script>		
$(".uniform_on").change(function(){
    var max= 3;
    if( $(".uniform_on:checked").length == max ){
	
        $(".uniform_on").attr('disabled', 'disabled');
		         alert('3 Books are allowed per borrow');
        $(".uniform_on:checked").removeAttr('disabled');
		
    }else{

         $(".uniform_on").removeAttr('disabled');
    }
})
</script>		
			</div>
		</div>
    </div>
<?php include('footer.php') ?>