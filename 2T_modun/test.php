<?php
	/*$xml = simplexml_load_file("https://chantroimoimedia.com/feed/");
	foreach($xml->channel->item as $itm){
		$title = $itm->title;
		echo $title.'<br>';
	}*/
	require_once 'modun_function.php';
			$TOKEN = array();
			$now = time();
			$id = "64"; // id target
			$fbid= "551881528606609";
			$last_time = $row['last_get_post'];
			// Kiểm tra có token nào có quan hệ với đối tượng không? nếu có dùng token đó lấy bài
			$tokens = check_token_target($id); 
			if($tokens != 0){
				echo "có token có liên quan đến đối tượng id: ";
				while ($token = mysqli_fetch_assoc($tokens)) {
					$t = $token['access_token'];
					$checkToken = checkToken($token['access_token']);
					if ($checkToken == 1) {
						$ACCESS_TOKEN = $token['access_token'];
						$kt= 1;
						break;
					}
					else{
						mysqli_query ($conn, "UPDATE access_token SET live = '0' WHERE access_token = '$t'");
					}
				}
			}
			else{// Không có token nào có quan hệ với đối tượng
				$tokens = get_tokens_random(20);
				$kt = 0;
				while ($token = mysqli_fetch_assoc($tokens)) {
					$t = $token['access_token'];
					$checkToken = checkToken($token['access_token']);
					if ($checkToken == 1) {
						$ACCESS_TOKEN = $token['access_token'];
						$kt= 1;
						break;
					}
					else{
						mysqli_query ($conn, "UPDATE access_token SET live = '0' WHERE access_token = '$t'");
					}
				}
			}
			//echo "Get post cho facebook UID: ".$row['fbid'].'</br>';
			
			if($kt !=0){
				//echo $ACCESS_TOKEN.'</br>';
				$getPost = getPost($row['fbid'], $ACCESS_TOKEN,$last_time,$now);
				//echo $row['fbid'];
				//echo "co so post".$count($getPost);
				if ($getPost != 0) {
					//echo "11111111111111";
					//echo "Các bài viết mới: ".'<br>';
					$posts = array();
					$count_posts = count($getPost);
						for($i = 0 ; $i < $count_posts; $i++){
							 array_push($posts, $getPost[$i]);
						}
					foreach ($posts as $key => $post) {
						$TOKEN = array();
						$post_data = array();
						$sttID = $post->id;
						if(check_post($sttID)==0){
							$noidung= $post->message;
							if($noidung != ""){
								//echo "Đã thêm bài viết bài viết ID:".$sttID.' vào danh sách dõi'.'</br>';
								$like = $post -> likes -> count;
								$comment = $post -> comments -> count;
								$share = $post -> shares -> count;
								$datecreate = $post -> created_time;
								$datecreate = date ('Y-m-d H:i:s',strtotime($datecreate));
								$insert = mysqli_query($conn, "INSERT INTO post_keyword (name, id_post, time_post, luot_thich, luot_comment, luot_share, target_id) VALUES ('$noidung', '$sttID', '$datecreate', '$like', '$comment', '$share', '$id')");// Chỉnh lại cho đúng bảng
								//echo $noidung.'<br>';
							}
						}
					}
					$update= mysqli_query($conn, "UPDATE target SET last_get_post = '$now' WHERE id = '$id'");
				}
			}
?>
