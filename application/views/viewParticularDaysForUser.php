<h1><?php echo ucfirst($fname)." ".ucfirst($lname);?></h1>
<h2 style="color:#DE5E60;"><?php echo ucfirst($results[0]->jobcode)." - ".$results[0]->location." - ".$results[0]->description;?></h2>
<?php foreach ($results as $r) {
	//put slashes back in dates and re-arrange
	$dateA = explode("-",$r->date);
	$date = $dateA[2]."/".$dateA[1]."/".$dateA[0];
	echo "<a href='".base_url("index.php/JobSessionsC/apage/$r->userId/$r->date")."' style='color:white'>$date - ".ucfirst($r->comments)."</a><br>";
}?>
</body>
</html>