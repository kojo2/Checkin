<div class="list">
	<p>
	<?php
		if($jobname){
			$jobname = $jobname." - ";
		}
		echo "<span style='color:rgb(255, 185, 43); text-transform:capitalize'><span name='jobcode'>".$jobcode."</span> - ".$jobname.$location." - ".$description."</span><br>";
	?>
	Staff members that worked on this project during this time:
	<span class='numbers'><?php echo count($staff);?></span><br>
	<?php $i=0;?>
	<?php foreach ($staff as $s) {
		echo $s->fname." ".$s->lname." - ";
		//print_r($arr);
		$singleArr = $arr[$i];
		$i++;
		$days = $singleArr[$s->userId];
		//print_r($singleArr);
		$userId = $s->userId;
		$id = rand();
		if($days>1){echo "<a href='ViewParticularDaysForUser/$jobcode/$userId/$from/$to'><span class='numbers'>".$days." days</span></a><br>";}else{echo "<a href='ViewParticularDaysForUser/$jobcode/$userId/$from/$to'><span class='numbers'>".$days." day</span></a><br>";}
	}?></span>
		<a href=<?php echo "exportToExcel/$jobcode/$from/$to";?>>Export to excel</a>
	</p>
</div>
<div>
</div>
