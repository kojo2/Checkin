	<?php if(!$fname){echo("<script>window.location.href='/index.php/logout';</script>");}else{
			echo "<h1>Hello ".ucfirst($fname).", where will you be today?</h1>";
		}?>
	<?php echo form_open("CheckinSubmit");?>
	<select id="job" name="job" class="longSelect">
	</select><br>
	<label>From:</label><br>
	<?php timeWidget("from");?><br>
	<label>To:</label><br>
	<?php timeWidget("to");?><br><br>
	<label>Comments:</label><br>
	<textarea name="comments" id="comments"></textarea><br><div id="message"></div><br>
	<input type="submit" id="submit" value="OK"></input>
	<?php echo form_close();?>
	<input type="submit" value="Log Out" onclick="logout();"></input><br><br>
	<input type="submit" value="Checkin for past days" onclick="checkoutHistorical();"></input>
	<input type="submit" value="View days worked" onclick="viewDaysWorked();"></input><br><br>
	<input type="submit" value="Change password" onclick="changePassword();"></input><br><br>
	<p id="hint"></p>
	<?php addedJobsWidget();?>
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
		$.ajax({
		  url: "checkin/getJobsForUserId",
		  data: {<?php $userId;?>},
		  success: function(result){
		  	$("#previousJobs").html(result);
		  	if(result.length){$("#hint").html("Click a coloured block to delete it");}
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
			setTimeout(function(){
				$(".aJobs").click(function(){
					if(confirm("Do you want to delete this job?")){
						var jobcode = $(this).text().split("**")[1];
						window.location.href="Checkin/deleteJob/"+jobcode;
					}
				});
			},1000);
		function logout(){
			window.location.href="<?php echo base_url('index.php/logout');?>";
		}
		function changePassword() {
			var pword = prompt("Please enter your new password");
			var cpword = prompt("Please confirm your new password by entering it again");
			if(pword && pword===cpword){
				$.ajax({type:"post", url:"ChangePasswordCheckinSubmit/index/<?php echo $userId;?>",data:{'pword':pword}, success: function(result){
						alert("Password successfully changed");
					},error: function(){
						alert("There was an error");
					}
				});
			}else{
				alert("Please ensure the passwords match!");
			}
		}

		function checkoutHistorical(){
			window.location.href="<?php echo base_url('index.php/CheckinHistorical');?>";
		}
		function viewDaysWorked(){
			window.location.href="<?php echo base_url('index.php/ViewDaysWorked');?>";	
		}
	</script>
</body>
</html>