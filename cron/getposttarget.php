<?php
header('Content-Type: text/html; charset=utf-8');
require_once '../2T_config/config_server.php';
get_new_post();
function get_new_post(){
	global $conn;
	$t = time () -60*60;
	$vip = mysqli_query($conn, "SELECT * FROM target WHERE last_get_post <'$t' ORDER BY RAND() ");
	$post = mysqli_query($conn, "SELECT * FROM post_keyword WHERE last_update_like <'$t' ORDER BY RAND() ");
	if ($vip) {
		while ($row = mysqli_fetch_assoc($vip)) {
			$TOKEN = array();
			$now = time();
			$id = $row['id'];
			$fbid= $row['fbid'];
			$last_time = $row['last_get_post'];
			echo "Get post cho facebook UID: ".$row['fbid'].'</br>';
			$tokens = get_tokens_random(20);
			$kt = 0;
			while ($token = mysqli_fetch_assoc($tokens)) {
				$checkToken = checkToken($token['access_token']);
				if ($checkToken == 1) {
					$ACCESS_TOKEN = $token['access_token'];
					$kt= 1;
					break;
				}
			}
			if($kt !=0){
				//echo $ACCESS_TOKEN.'</br>';
				$getPost = getPost($row['fbid'], $ACCESS_TOKEN,$last_time,$now);
				//echo $row['fbid'];
				//echo "co so post".$count($getPost);
				if ($getPost != 0) {
					//echo "11111111111111";
					echo "Các bài viết mới: ".'<br>';
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
							echo "Đã thêm bài viết bài viết ID:".$sttID.' vào danh sách dõi'.'</br>';
							$noidung= $post->message;
							$like = $post -> likes -> count;
							$comment = $post -> comments -> count;
							$share = $post -> shares -> count;
							$datecreate = $post -> created_time;
							$datecreate = date ('Y-m-d H:i:s',strtotime($datecreate));
							$insert = mysqli_query($conn, "INSERT INTO post_keyword (name, id_post, time_post, luot_thich, luot_comment, luot_share, target_id) VALUES ('$noidung', '$sttID', '$datecreate', '$like', '$comment', '$share', '$id')");// Chỉnh lại cho đúng bảng
							//echo $noidung.'<br>';
						}
					}
					$update= mysqli_query($conn, "UPDATE target SET last_get_post = '$now' WHERE id = '$id'");
				}
			}
			else echo "Kiểm tra lại Token";
		}
	}
	if ($post) {
		while ($row = mysqli_fetch_assoc($post)) {
			$TOKEN = array();
			$now = time();
			$idpost = $row['id_post'];
			$tokens = get_tokens_random(20);
			$kt = 0;
			while ($token = mysqli_fetch_assoc($tokens)) {
				$checkToken = checkToken($token['access_token']);
				if ($checkToken == 1) {
					$ACCESS_TOKEN = $token['access_token'];
					$kt= 1;
					break;
				}
			}
			if($kt !=0){
				//echo $ACCESS_TOKEN.'</br>';
				$getcontentpost = getContentPost($idpost, $ACCESS_TOKEN);
				$t = time();
				$like= $getcontentpost['likes']['count'];
				$comment = $getcontentpost['comments']['count'];
				$share = $getcontentpost['shares']['count'];
				if($getcontentpost!=0){
					$result = mysqli_query($conn, "UPDATE post_keyword SET luot_thich = '$like', luot_comment = '$comment', luot_share = '$share', last_update_like ='$t' WHERE id_post = '$idpost'");
				}
				echo "Da Update Like,Comment, Share cho bai viet :".$idpost.'<br>';
			}
			else echo "Kiem tra token live";
		}
	}
	return 1;
}
function check_post($sttID){
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM post_keyword WHERE id_post = '$sttID'");
	if (mysqli_num_rows($result) > 0)
		return 1;
	return 0;
}
function getPost($fbid, $token, $datefrom, $dateto){
	$yesterday  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
	$yesterday = date ("m/d/y",$yesterday);
	$start_day_time = $yesterday;
	$result = [];
	$i =0;
	$getPost = json_decode(file_get_contents('https://graph.facebook.com/' . $fbid . '/feed?fields=id,likes,message,comments,shares&since=' . $datefrom . '&until=' . $dateto . '&access_token=' . $token));
		if ($getPost->data[0]->id) {
			//echo $getPost->data[4]->id.' ';
			return $getPost->data;
		}
		return 0;
}
function getPost2($fbid, $token){
	$yesterday  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
	$yesterday = date ("m/d/y",$yesterday);
	$start_day_time = "01/09/2018";
	$result = [];
	$i =0;
	$getPost = json_decode(file_get_contents('https://graph.facebook.com/' . $fbid . '/feed?fields=id,likes,message&since=' . $start_day_time . '&until=' . time() . '&access_token=' . $token . '&limit=20'));
		if ($getPost->data[0]->id) {
			//echo $getPost->data[4]->id.' ';
			return $getPost->data;
		}
		return 0;
}
function getContentPost($post_id, $accessToken){
	$getPost = (file_get_contents('https://graph.facebook.com/'. $post_id .'/?summary=true&access_token='.$accessToken));
			return json_decode(($getPost),true);
}
function checkToken($token){
	$get = json_decode(file_get_contents('https://graph.facebook.com/me/?access_token='.$token.'&field=id'), true);
	if ($get['id']) {
		return 1;
	}
	return 0;
}
function saveFile($txt){
	$file = @fopen('vipLike.log.txt', 'a+');
	@fwrite($file, $txt."\n");
	@fclose($file);
}
function count_time_to_current_in_day($now){
    $date = DateTime::createFromFormat("d/m/Y", $now);
    $year = $date->format("Y");
    $month = $date->format("m");
    $day = $date->format("d");
    $dt = $day . "-" . $month . "-" . $year . " 00:00:00";
    $d = new DateTime($dt, new DateTimeZone('Asia/Ho_Chi_Minh'));
    return $d->getTimestamp();
}
function get_tokens_random($limit){
    global $conn;
    return mysqli_query($conn, "SELECT access_token FROM access_token ORDER BY RAND() LIMIT ".$limit);
}
function has_used($token){
	global $conn;
    return mysqli_query($conn, "UPDATE access_token SET has_used = 1 WHERE access_token = '$token'");
}
function reset_token(){
	global $conn;
    $result = mysqli_query($conn, "SELECT id FROM access_token WHERE has_used = 0");
    if(mysqli_num_rows($result) < 50 ){
    	return mysqli_query($conn, "UPDATE access_token SET has_used = 0");
    }
}
function count_react($post_id, $token){
    $get_json = json_decode(file_get_contents('https://graph.facebook.com/'.$post_id.'/reactions?summary=true&access_token='.$token),true);
    if($get_json['summary']['total_count']){
        return $get_json['summary']['total_count'];
    } else {
        return 0;
    }
}
?>
