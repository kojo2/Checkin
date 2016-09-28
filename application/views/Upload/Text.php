<html>
<head>
</head>
<body>
	<?php echo form_open('UploadText');?>
		<h1>Enter text to upload:</h1>
	 	<textarea rows="30" cols="50" name="text">
		</textarea>
		<input type="submit" value="save"/>
	<?php echo form_close();?>
</body>
</html>