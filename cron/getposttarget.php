<?php
header('Content-Type: text/html; charset=utf-8');
require_once '../2T_config/config_server.php';
get_new_post();
function get_new_post(){
	global $conn;
	$t = time () -60*10;
	$vip = mysqli_query($conn, "SELECT * FROM target WHERE last_get_post <'$t' ORDER BY RAND() LIMIT 5");
	$post = mysqli_query($conn, "SELECT * FROM post_keyword WHERE last_update_like <'$t' ORDER BY RAND() ");
	if ($vip) {
		while ($row = mysqli_fetch_assoc($vip)) {
			$TOKEN = array();
			$now = time();
			$id = $row['id']; // id target
			$fbid= $row['fbid'];
			$last_time = $row['last_get_post'];
			// Kiểm tra có token nào có quan hệ với đối tượng không? nếu có dùng token đó lấy bài
			$tokens = check_token_target($id); 
			echo mysqli_num_rows($tokens).' ';
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
			//echo "Get post cho facebook UID: ".$fbid.'</br>';
			
			if($kt !=0){
				//echo "111 ";
				//echo $ACCESS_TOKEN.'</br>';
				$getPost = get_Post_by_token($fbid, $ACCESS_TOKEN,$last_time,$now);
				echo $fbid;
				echo " Có ".count($getPost['data']).' bài viết mới'.'</br>';
				$count_posts = count($getPost['data']);
				if ($count_posts > 0){
					for ($i = 0; $i < $count_posts; $i++){
						$sttID = $getPost['data'][$i]['id'];
						$id_user_post = $getPost['data'][$i]['from']['id'];
						$name_user_post = $getPost['data'][$i]['from']['name'];
						if(check_post($sttID)==0){
							$noidung = $getPost['data'][$i]['message'];
							if($noidung !=""){
								$privacy = $getPost['data'][$i]['privacy']['value'];
								$datecreate = $getPost['data'][$i]['created_time'];
								$datecreate = date ('Y-m-d H:i:s',strtotime($datecreate));
								$likes = 0; 
								$comments = 0;
								$shares = 0;
								if($getContentPost['likes']['count'] != 0) $likes = $getContentPost['likes']['count'];
								if($getContentPost['comments']['count'] != 0) $comments = $getContentPost['comments']['count'];
								if($getContentPost['shares']['count'] != 0) $shares = $getContentPost['shares']['count'];
								$insert = mysqli_query($conn, "INSERT INTO post_keyword (name, id_post,id_user_post, name_user_post, time_post, luot_thich, luot_comment, luot_share, target_id, privacy) VALUES ('$noidung', '$sttID', '$id_user_post', '$name_user_post', '$datecreate', '$likes', '$comments', '$shares', '$id', '$privacy')");// Chỉnh lại cho đúng bảng
								echo $sttID.' '.$noidung.' '.$privacy.' '.$datecreate.' '.$likes.' '.$comments.' '.$shares.'</br>';
								}
						}
					}
				}
				$update= mysqli_query($conn, "UPDATE target SET last_get_post = '$now' WHERE id = '$id'");
			}
			else {
				echo "Hết Token Live";
			}
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
				//echo "Da Update Like,Comment, Share cho bai viet :".$idpost.'<br>';
			}
			//else echo "Kiem tra token live";
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
function check_token_target($id){
	global $conn; 
	$result = mysqli_query ($conn, "SELECT * FROM access_token WHERE id in (SELECT token_id FROM tbl_token_target WHERE target_id = '$id')");
	if(mysqli_num_rows($result) > 0){
		return $result;
	}
	return 0;
}
function get_Post_by_token($fbid, $accessToken, $datefrom, $dateto){
	$getPost = (file_get_contents('https://graph.facebook.com/'.$fbid.'/feed?&since='.$datefrom.'&until='.$dateto.'&access_token='.$accessToken));
			return json_decode(($getPost),true);
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
