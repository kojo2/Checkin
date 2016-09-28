
	<h1>Users</h1>
	<ul id="users"></ul><br>
	<button onclick="addUser();">Add User</button>
<script>
	$.ajax({
	  url: "adminEditUsers/getAllUsers",
	  success: function(result){
	  	$("#users").html(result);
	  }
	});
	function addUser(){
		window.location.href="adminEditUsers/addUser";
	}
</script>
</body>
</html>