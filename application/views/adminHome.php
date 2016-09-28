	<h1>Admin home</h1>
	<!--<div id="editUsersButton" onclick="editUsers();">
		<img class="glyphPic" src="<?php echo base_url('/static/images/userGlyph.png');?>"></img>
		<p>Edit Users</p>
	</div>-->
	<div id="adminHomeButtons">
		<button onclick="editUsers();">Edit users</button>
		<button onclick="editJobs();">Edit jobs</button>
		<button onclick="viewReports();">View reports</button>
		<button onclick="logOut();">Log Out</button>
	</div>
	<!--<a href='<?php echo base_url("index.php/logout");?>'>Logout</a>-->
	<script>
		function editUsers(){
			window.location.href="<?php echo base_url('index.php/adminEditUsers');?>";
		}
		function editJobs(){
			window.location.href="<?php echo base_url('index.php/adminEditJobs');?>";
		}
		function viewReports(){
			window.location.href="<?php echo base_url('index.php/adminViewReports');?>";
		}
		function logOut(){
			window.location.href="<?php echo base_url('index.php/logout');?>";
		}
	</script>
</body>
</html>