
	<h1><?php echo ucfirst($fname)." ".ucfirst($lname);?></h1>
	<?php 
			if($date){$dateA = explode("-", $date);
			$date = $dateA[1]."/".$dateA[2]."/".$dateA[0];
			$newDate = $dateA[2]."/".$dateA[1]."/".$dateA[0];
		}
		?>
	<p>Date: <?php echo $newDate;?>
	</p>
	<ul id="content"></ul>
	<script>
		var date = "<?php echo $date;?>";
		var uid = <?php echo $uid;?>;
		$.ajax({
				type:"POST",
				url:"../../User",
				data:{date:date,uid:uid},
				success:function(result){
					$("#content").html(result);
					$(".jobSession").click(function() {
						var text = "Comments: "+$(this).find(".comms").html().split("**")[2];
						alert(text);
					});
				}
			});	
		
	</script>
</body>
</html>	