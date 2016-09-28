<html>
<head>
</head>
<body>
	Welcome please login:
	<?php echo form_open("login");?>
		<label for="creds">Firstname and Lastname (eg John Smith)</label><br>
		<input type="text" name="creds"></input><br>
		<label for="password">Password:</label><br>
		<input type="password" name="password"></input><br>
		<input type="submit" value="Login"></input>
	<?php echo form_close();?>
</body>
</html>