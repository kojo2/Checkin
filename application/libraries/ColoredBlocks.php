<?php 

	class ColoredBlocks {

		public function shoot($perc98,$jobcode,$location,$timeIn,$timeOut,$comments,$id,$showDate,$date,$name){
			$visibility = "";
			$oldComments = $comments;
				$hours = $timeOut-$timeIn;
				$timeInA = explode(":",$timeIn);
				$timeIn = $timeInA[0].":".$timeInA[1];
				$timeOutA = explode(":",$timeOut);
				$timeOut = $timeOutA[0].":".$timeOutA[1];
				$perc = (($perc98/12)*($hours));
				$colorPart1 = mt_rand( 0, 255 );
				$colorPart2 = mt_rand( 0, 255 );
				$colorPart3 = mt_rand( 0, 255 );
				if(!$showDate){
					$date="";
				}else{
					$date=$date."<br>";
				}
				$color = $colorPart1.",".$colorPart2.",".$colorPart3.","."0.1";
				if($perc<1){$perc=($perc98/12);}
				if(strlen($comments)){
					if($perc<strlen($comments)){
						$comments=mb_substr($comments,0,$perc)."...<br>";
					}else{
						$comments = $comments."<br>";
					}
				}else{
					$comments="";
				}
				if($perc<5){
					$visibility = "invisible";
				}
				
				echo("<a href='#' class='aJobs'><li class='jobSession' style='text-transform:capitalize; width:".$perc."% ; background-color:rgba(".$color.")'><span class='darker'>".$date.$name."<br>".$jobcode."</span> <br>".$location."<br>".$timeIn." - ".$timeOut."<br><span class='".$visibility."'>".$comments.$hours." hours</span><br><span class='invisible comms'>**".$id."**".$oldComments."</span></li></a>"
				);
		
		}

		function test(){
			echo "hello";
		}

	}