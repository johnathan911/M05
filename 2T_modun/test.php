<?php
	require_once 'modun_function.php';
		$tennhom = "all";
		$keyword_goc = "An ninh mạng";
		$keyword = "An ninh mạng";
		$today= date("y-m-d");
		$today = "20".$today;
		$keyword= str_replace(" ","\s",$keyword);
		$keyword = "*".$keyword."*";
		$user_id = "13";
		$posts = getPostByGroup($tennhom,$user_id);
		echo mysqli_num_rows($posts);
?>

