	<?php echo form_open("adminEditUsers/editUserSubmit/$id");?>
		<h1>Editing <?php echo $fname." ".$lname;?></h1>
		<label>Change user's password:</label><br>
		<input type="text" name="password"></input><br>
		<label>Confirm new password: </label><br>
		<input type="text" name="cPassword"></input><br>
		<label>Daily Rate: </label><br>
		<input type="number" min="0.01" step="0.01" name="dailyRate"></input><br>
		<input type="submit" value="Apply changes"></input><br><br>
	<?php echo form_close();?>
	<button id="delete">Delete user</button><br>
<script>
	$("#delete").click(function(){
		window.location.href='<?php echo base_url("index.php/adminEditUsers/deleteUserConfirm/$id");?>';
	});
</script>
</body>
</html>