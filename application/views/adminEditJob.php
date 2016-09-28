	<?php echo form_open("adminEditJobs/editJobSubmit/$id");?>
		<h1>Editing job <?php echo ucfirst($jobname)." - ".ucfirst($jobcode)." - ".ucfirst($location);?></h1>
		<label>Job Code: </label><br>
		<input type="text" name="jobcode" placeholder="<?php echo ucfirst($jobcode);?>"></input><br>
		<label>Job Name: </label><br>
		<input type="text" name="jobname" placeholder="<?php echo ucfirst($jobname);?>"></input><br>
		<label>Location: </label><br>
		<input type="text" name="location" placeholder="<?php echo ucfirst($location);?>"></input><br>
		<label>Description: </label><br>
		<input type="text" name="description" placeholder="<?php echo ucfirst($description);?>"></input><br><br>
		<input type="submit" value="Apply changes"></input><br>
	<?php echo form_close();?>
	<button id="delete">Delete job</button><br>
	<script>
		$("input[type='text']").click(function(){
			var val = $(this).attr("placeholder");
			$(this).val(val);
		});

		$("#delete").click(function(){
			window.location.href='<?php echo base_url("index.php/adminEditJobs/deleteJob/$id");?>';
		});
	</script>
</body>
</html>