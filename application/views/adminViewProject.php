	<h1>View By Project</h1>
	<select id="projects">
	</select>
	<div id="content"></div>
	<script>
		var text;
		$.ajax({url:"../projects/getProjects",success:function(result){
			$("#projects").html(result);
		}});
		$("#projects").change(function(){
			text = $(this).val();
			// $.ajax({
			// 	type:"POST",
			// 	url:"../jobSessionsC/findJobSessionsByCode",
			// 	data:{"text":text},
			// 	success:function(result){
			// 		$("#content").html(result);
			// 	}
			// });
			$.ajax({
				type:"POST",
				url:"../jobSessionsC/viewByProject",
				data:{"text":text},
				success:function(result){
					$("#content").html(result);
				}
			});
		})
	</script>
</body>
</html>