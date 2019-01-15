<?php
$yesterday  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
		$yesterday = date ("m/d/y",$yesterday);
		$yesterdaytime = strtotime($yesterday);
		//$date = getdate();
		echo $yesterdaytime.' '.time().' '.strtotime('1/14/19');
?>
