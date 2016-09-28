	<h1>Add New User</h1>
	<?php echo form_open("adminEditUsers/addUserSubmit");?>
		<label>First Name: </label><br>
		<input type="text" name="fname"></input><br>
		<label>Last Name: </label><br>
		<input type="text" name="lname"></input><br>
		<label>Password:</label><br>
		<input type="password" name="password"></input><br>
		<label>Confirm password: </label><br>
		<input type="password" name="cPassword"></input><br>
		<label>Admin? </label><input type="checkbox" name="bAdmin"></input><br>
		<label>Daily Rate: (£)</label><br>
		<input type="number" min="0.01" step="0.01" name="dailyRate" id="dailyRate"></input><br>
		<input type="submit" value="Add User"></input>
	<?php echo form_close();?>
</body>
</html>