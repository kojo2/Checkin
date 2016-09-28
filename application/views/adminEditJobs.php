
	<ul id="joblist"></ul>
	<?php echo form_open("adminEditJobs/Submit");?>
		<label>Job Name:</label><br>
		<input type="text" name="jobname"></input><br>
		<label>Job code:</label><br>
		<input type="text" name="jobcode"></input><br>
		<label>Location:</label><br>
		<input type="text" name="location"></input><br>
		<label>Description</label><br>
		<textarea name="description"></textarea><br>
		<input type="submit" value="Add Job"></input>
	<?php echo form_close();?>
	<div id="content"></div>
	<script>
		$.ajax({
			type:"POST",
			url:"adminEditJobs/viewAll",
			success:function(result){
				$("#content").html(result);
			}

		});
		$("#joblist").html(result)
	</script>
</body>
</html>