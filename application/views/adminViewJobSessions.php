
	<h1><?php echo ucfirst($fname)." ".ucfirst($lname);?></h1>
	<p>Date:
	<input type="text" id="datepicker"></input><br><br>
	</p>
	<ul id="content"></ul>
	<?php 
			if($date){$dateA = explode("-", $date);
			$date = $dateA[1]."/".$dateA[2]."/".$dateA[0];}
		?>
	<script>
		$("#datepicker").datepicker({onSelect: function(){
			var date = $("#datepicker").val();
			console.log("DAte: "+date);
			$.ajax({
				type:"POST",
				url:"../User",

				data:{date:date,uid:<?php echo $uid;?>},
				success:function(result){
					$("#content").html(result);
					$(".jobSession").click(function() {
						var text = "Comments: "+$(this).find(".comms").html().split("**")[2];
						alert(text);
					});
				}
			});	
		}});
		
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