<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('navbar_member.php'); ?>
    <div class="container">
		<div class="margin-top">
			<div class="row">	
			<div class="span12">	
			   <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;Member Table</strong>
                                </div>
                            <table cellpadding="0" cellspacing="0" border="0" class="table  table-bordered" id="example">
                             
								<p><a href="add_member.php" class="btn btn-success"><i class="icon-plus"></i>&nbsp;Add Member</a></p>
							
                                <thead>
                                    <tr>

                                        <th>Name</th>
                                        <th>Roll No/EMP ID</th>
                                        <th>Department</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>Contact</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
								 
                                  <?php  $user_query=mysql_query("SELECT id, name, roll_no, dept_id, phone, gender, address, type, status FROM students
UNION
SELECT id, name, emp_id, dept_id, phone, gender, address, type, status FROM teachers")or die(mysql_error());
									while($row=mysql_fetch_array($user_query)){
									$id=$row['id'];  ?>
									<tr class="del<?php echo $id ?>">

                                        <?php
                                        $department = $row['dept_id'];
                                        $query_depart = "SELECT dept_name FROM department WHERE dept_id=$department";
                                        $query_run_depart = mysql_query($query_depart);
                                        if($query_run_depart){

                                            while($row1=mysql_fetch_assoc($query_run_depart)) {
                                                $department = $row1['dept_name'];

                                            }} ?>


                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['roll_no']; ?></td>
                                        <td><?php echo $department; ?></td>
                                        <td><?php echo $row['gender']; ?> </td>
                                        <td><?php echo $row['address']; ?> </td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td><?php echo $row['type']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <?php include('toolttip_edit_delete.php'); ?>
                                    <td width="100">
                                        <a rel="tooltip"  title="Delete" id="<?php echo $id; ?>" href="#delete_student<?php echo $id; ?>" data-toggle="modal"    class="btn btn-danger"><i class="icon-trash icon-large"></i></a>
                                        <?php include('delete_student_modal.php'); ?>
										<a  rel="tooltip"  title="Edit" id="e<?php echo $id; ?>" href="edit_member.php<?php echo '?id='.$id; ?>" class="btn btn-success"><i class="icon-pencil icon-large"></i></a>
										
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