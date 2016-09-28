<?php echo "
	<div class='messageContainer'>
		<h2 class='message'>$message</h2>
	</div>
";?>
<script>
	$("#menu").hide();
	$("#backButton").hide();
	setTimeout(function(){window.location.href="<?php echo $source;?>"},1000);
</script>
</body>
</html>