	<h1>View By User</h1>
	<ul id="users">
	</ul>
	<script>
		$.ajax({url:"../user/getUsers",success:function(result){
			$("#users").html(result);
		}});
	</script>
</body>
</html>