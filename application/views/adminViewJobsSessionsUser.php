<h2><?php echo ucfirst($fname)." ".ucfirst($lname);?></h2><br>
		<label>Date from: </label>
		<input type="text" id="datepickerFrom" name="from" class="datePicker"></input>
		<label> to: </label>
		<input type="text" id="datepickerTo" name="to" class="datePicker"></input><br><br>
		<button id="go">Go</button><br><br>
		<div id="results"></div>
		<!--<a href='#' id="exportToExcel">Export to excel</a>-->
	<script>
		var dateFrom;
		var dateTo;

		/** THIS IS JUST FOR TESTING DELETE ME LATER**/

		/*$.ajax({
				type:"POST",
				url:"viewDateSubmit",
				data:{"from":"03_01_2016","to":"03_31_2016"},
				success:function(result){
					$("#results").html(result);
				}
			});*/


		/** END OF DELETE ME **/



		$("#datepickerFrom").datepicker({onSelect:function(){
			dateFrom = $("#datepickerFrom").val();
			if(dateFrom>dateTo){
				alert("From date is earlier than To date!");
			}
		},dateFormat: "dd-mm-yy"});
		$("#datepickerTo").datepicker({onSelect:function(){
			dateTo = $("#datepickerTo").val();
			if(dateTo<dateFrom){
				alert("To date is earlier than From date!");
			}
		},dateFormat: "dd-mm-yy"});
		$("#go").click(function(){
			if(dateFrom && dateTo && (dateFrom<=dateTo)){
				dateFromA = dateFrom.split("-");
				dateFrom = dateFromA[1]+"_"+dateFromA[0]+"_"+dateFromA[2];
				dateToA = dateTo.split("-");
				dateTo = dateToA[1]+"_"+dateToA[0]+"_"+dateToA[2];
				$.ajax({
					type:"POST",
					url:"../forUser",
					data:{"from":dateFrom,"to":dateTo,"uid":<?php echo $uid;?>},
					success:function(result){
						$("#results").html(result);
					}
				});
			}else{
				if(dateTo<dateFrom){
					alert("Dates are wrong way around!");
				}else if(!dateFrom || !dateTo){
					alert("You must select To and From dates!");
				}
			}
		})
	</script>
</body>
</html>
