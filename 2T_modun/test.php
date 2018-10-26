<?php
	require_once 'modun_function.php';
		$today= date("y-m-d");
		$today = "20".$today;
		//echo $today;
		xoa_post_by_user("developer");
		$tennhom = "Đối tượng khác";
		$keyword = "An Ninh Mạng";
		if($keyword[0] !=" ") $keyword = "/\b".$keyword;
		if($keyword[strlen($keyword)-1] !=" ") $keyword=$keyword."\b/i";
		$keyword= str_replace(" ","\s",$keyword);
		$datefrom = "2018-10-17";
		$dateto = "2018-10-18";
		$nhom = getNhom($tennhom);
		$idnhom = $nhom['id'];
		echo "Id nhóm ".$tennhom." là ".$idnhom.'</br>';
		$targets = getTarget($idnhom);
		//$fbid_arr = array();
		while($target = mysqli_fetch_assoc($targets)){
			$tendoituong = $target['name'];
			$quanly = $target['manager'];
			$ACCESS_TOKEN = getTokenLive(20);
			$fbid = $target['fbid'];
			echo $tendoituong." ".$quanly." ".$ACCESS_TOKEN." ".$fbid." ".$keyword."</br>";
			if($dateto ==$today)
			{
				$t = time();
				echo $t;
				$getPost= getPost($fbid, $ACCESS_TOKEN,strtotime($datefrom),$t);
			}
			else{
				$getPost = getPost($fbid, $ACCESS_TOKEN,strtotime($datefrom), strtotime($dateto));
			}
			if ($getPost != 0) {
			$posts = array();
	        $count_posts = count($getPost);
				for($i = 0 ; $i < $count_posts; $i++){
					 array_push($posts, $getPost[$i]);
				}
            foreach ($posts as $key => $post) {
				$like = $post -> likes -> count;
				$comment = $post -> comments -> count;
				$share = $post -> shares -> count;
				$noidung = $post -> message;
				$sttID = $post -> id;
				$datecreat = $post -> created_time;
				$datecreat = date ('Y-m-d H:i:s',strtotime($datecreat));
				echo $sttID." ".$noidung." ".$datecreat." ".$like." ".$comment." ".$share."</br>";
					if (preg_match($keyword, $noidung, $match)) :
					  add_to_post_keyword($tendoituong,$quanly,$sttID,$datecreat, $like,$comment,$share);
					  endif;
					//echo $noidung;
					//$insert = mysqli_query($conn, "INSERT INTO post (fbid, group_id, id_post, time_post) VALUES ('$name', '$vnd', '$limitLike', $limitPost)");
				}
	        }
		}
?>
