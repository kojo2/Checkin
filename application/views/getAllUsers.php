<?php 
	foreach ($result as $r) {
		if(!$r->admin){
			echo("<li><a href='adminEditUsers/editUser/".$r->id."'>".ucfirst($r->fname)." ".ucfirst($r->lname)." - Daily rate: £$r->dailyRate</a></li>");
		}
	}
?>