<form class="form-horizontal" method="post">
			<div class="control-group">
				<label class="control-label" for="inputEmail">Member_name</label>
				<div class="controls">
				<select name="returnee_name">
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
					<input type="text"  class="w8em format-d-m-y highlight-days-67 range-low-today" name="date" id="sd" maxlength="10" style="border: 3px double #CCCCCC;" required/>
					</div>
				</div>
				<div class="control-group"> 
					<label class="control-label" for="inputEmail">Return Date</label>
					<div class="controls">
					<input type="text"  class="w8em format-d-m-y highlight-days-67 range-low-today" name="date" id="sd" maxlength="10" style="border: 3px double #CCCCCC;" required/>
					</div>
				</div>
    </form>