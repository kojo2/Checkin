<?php if(!$fname){echo("<script>window.location.href='/index.php/logout';</script>");}?>
<?php echo form_open("checkinHistoricalSubmit");?>
<h3>Previous days check-in for <?php echo $fname;?></h3>
<select name="date">
	<?php
		foreach ($dates as $d) {
			//split $d apart and reform in better order (d-m-y) instead of (y-m-d)
			$dIndex = array_search($d,$dates);
			if($dIndex==(count($dates)-1)){$selected = true;}else{$selected=false;}
			$dA = explode("-",$d);
			$dayName = date("D",strtotime($d));
			$d = $dA[2]."-".$dA[1]."-".$dA[0]." - ".$dayName;
			if(!$selected){echo "<option>$d</option>";}else{echo "<option selected='selected'>$d</option>";}
		}
	?>
</select><br><br>
<select id="job" name="job" class="longSelect">
	</select><br>
	<label>From:</label><br>
	<?php timeWidget("from");?><br>
	<label>To:</label><br>
	<?php timeWidget("to");?><br><br>
	<label>Comments:</label><br>
	<textarea name="comments" id="comments"></textarea><br><div id="message"></div><br>
<input type="submit" value="OK"></input>
<?php echo form_close();?>
<input type="submit" value="Back" onclick="back();"></input>
<?php
		function timeWidget($fT){
			echo("<select name='".$fT."hours' class='shortSelect' id='from'>");
				for($i=6 ; $i<10 ; $i++ ){
					echo '<option value="0'.$i.'">0'.$i.'</option>';
				}
				for($i=10 ; $i<19 ; $i++ ){
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
			echo("</select>");
			echo("<span style='color:white ; font-weight:bold'> : </span>");
			echo("<select name='".$fT."minutes' class='shortSelect' id='to'>");
					for($i=0 ; $i<10 ; $i++ ){
						echo '<option value="0'.$i.'">0'.$i.'</option>';
					}
					for($i=10 ; $i<60 ; $i++ ){
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
			echo("</select> ");
		}

		function addedJobsWidget(){
			echo("<ul id='previousJobs'></ul>");
		}
?>
<script>
		var characterCount;
		$.ajax({
		  url: "UserHomev/readJobs",
		  success: function(result){
		  	$("#job").html(result);
		  }
		});
		$("#comments").keyup(function(){
			if($("#comments").val().length>1000){
				$("#message").html("Comments may not exceed 1000 characters");
			}else{
				characterCount = $("#comments").val().length;
				$("#message").html("Characters remaining: "+(1000-characterCount));
			}
		});
		function back(){
			window.location.href="<?php echo base_url('index.php/Checkin');?>";
		}
</script>

</body>
</html>