<?php
	echo form_open('changePasswordCheckinSubmit');?>
		<label>New password:</label><br><input type="password" name="password"/><br>
		<label>Confirm new password:</label><br><input type="password" name="cpassword"/><br>
		<input type="submit" value="OK"/>
	<?php echo form_close();?>
	<input type="submit" value="Cancel" onclick="window.location.href='/login';">
