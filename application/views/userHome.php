
	<h1>Jobs for <?php //echo $fname ?></h1>
	<!--
	<ul id="jobsList">
	</ul>
	-->
	<button id="checkin">Check In</button>
	<!--
	<script>
		for(var k = 0; k<10 ; k++){
			$("#jobsList").append("<li>Job "+k+"</li>");
		}
	</script>
	-->
	<script>
		$("#checkin").click(function(){
			window.location.href="checkin";
		});
	</script>
</body>
</html>