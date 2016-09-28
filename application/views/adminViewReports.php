	<h1>View Reports</h1>
	<button onclick="viewDate();">View by date</button>
	<button onclick="viewProject();">View by project</button>
	<button onclick="viewUser();">View by user</button>
	<script>
		function viewDate(){
			window.location.href="adminViewReports/viewDate";
		}
		function viewProject(){
			window.location.href="adminViewReports/viewProject";
		}
		function viewUser(){
			window.location.href="adminViewReports/viewUser";
		}
	</script>
</body>
</html>