<?php
	/*$xml = simplexml_load_file("https://chantroimoimedia.com/feed/");
	foreach($xml->channel->item as $itm){
		$title = $itm->title;
		echo $title.'<br>';
	}*/
	require_once 'modun_function.php';
		$tennhom = _p($_POST['nhom']);
		$keyword_goc = _p($_POST['keyword']);
		$keyword = _p($_POST['keyword']);
		$today= date("y-m-d");
		$today = "20".$today;
		$keyword= str_replace(" ","\s",$keyword);
		$keyword = "*".$keyword."*";
		$datefrom = (string)_p($_POST['datefrom']);
		$dateto = (string)_p($_POST['dateto']);
		$user_id = ($_SESSION['id']);
		Update_user_show($user_id);
		$posts = getPostByGroup($tennhom,$user_id,$datefrom,$dateto);
		$sopost = 0;
		//detele_search_keyword_result($user_id);
		while($row = mysqli_fetch_assoc($posts)){
			$noidung = $row['name'];
			if (preg_match(strtolower($keyword), strtolower($noidung), $match)) :
				if(Update_post_to_show($row['id_post'], $user_id)){
					$sopost++;
				}
				endif;
		}
		if ($sopost > 0) {
				$return['msg'] = 'Nhóm '.$tennhom.' có '.$sopost.' liên quan đến từ khóa: '.$keyword_goc;
				die(json_encode($return));
			} else {
				$return['error'] = 1;
				$return['msg']   = 'Không có bài viết nào liên quan';
				//$return['msg']   = strtotime($datefrom);
				die(json_encode($return));
		}
	echo time();
?>
