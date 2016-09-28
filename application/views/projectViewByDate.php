<div class="projectDate">
	<h2><?php echo $Title;?></h2>
	<?php 
		foreach ($user as $u) {
			echo $u['fname']." ".$u['lname']." - ";
			echo $u['comments']." - ";
			echo($u['timeIn']." - ".$u['timeOut']);
			echo("<br>");
		}
	?>
</div>