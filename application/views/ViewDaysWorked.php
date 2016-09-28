
		<h3>View days I worked between:</h3>
		<label>Date from: </label>
		<input type="text" id="datepickerFrom" name="from" class="datePicker"></input>
		<label> to: </label>
		<input type="text" id="datepickerTo" name="to" class="datePicker"></input><br><br>
		<button id="go">Go</button><br><br>
		<input type="submit" value="Back" onclick="back();"></input><br>
		<br><a href='#' id="exportToExcel">Export to excel</a><br><br>
		<div id="results"></div>
	<script>
		var dateFrom;
		var dateTo;
		$("#exportToExcel").hide();

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
			if(dateFrom && dateTo && dateFrom<dateTo){
				dateFromA = dateFrom.split("-");
				dateFrom = dateFromA[1]+"_"+dateFromA[0]+"_"+dateFromA[2];
				console.log(dateFrom);
				dateToA = dateTo.split("-");
				dateTo = dateToA[1]+"_"+dateToA[0]+"_"+dateToA[2];
				$.ajax({
					type:"POST",
					url:"viewDaysWorked/viewDateSubmit",
					data:{"from":dateFrom,"to":dateTo},
					success:function(result){
						$("#results").html(result);
						//quickly take the slashes out of the dates so they can be sent in a link
						dateFrom = dateFrom.split("/").join("_");
						dateTo = dateTo.split("/").join("_");
						$("#exportToExcel").attr("href","viewDaysWorked/exportToExcel/"+dateFrom+"/"+dateTo);
						$("#exportToExcel").show();
					}
				});
			}else{
				if(dateTo<dateFrom){
					alert("Dates are wrong way around!");
				}else{
					alert("You must select To and From dates!");
				}
			}
		})
		function back(){
			window.location.href="<?php echo base_url('index.php/Checkin');?>";
		}
	</script>
</body>
</html>
