<?php
header('Content-Type: text/html; charset=utf-8');
//require_once '../2T_config/config_server.php';
require_once '/var/sentora/hostdata/zadmin/public_html/m05system_tk/2T_config/config_server.php';
get_new_post();
function get_new_post(){
	global $conn;
	$t = time () -60*60*3;
	$vip = mysqli_query($conn, "SELECT * FROM target WHERE last_get_post <'$t' ORDER BY RAND() LIMIT 20");
	//echo mysqli_num_rows($vip).' ';
	if ($vip) {
		while ($row = mysqli_fetch_assoc($vip)) {
			$kt = 0;
			$TOKEN = array();
			$now = time();
			$id = $row['id']; // id target
			$fbid= $row['fbid'];
			$last_time = $row['last_get_post'];
			//echo $id;
			// Kiểm tra có token nào có quan hệ với đối tượng không? nếu có dùng token đó lấy bài
			$tokens = check_token_target($id); 
			echo mysqli_num_rows($tokens).' ';
			if($tokens != 0){
				echo "có token có liên quan đến đối tượng id: ";
				while ($token = mysqli_fetch_assoc($tokens)) {
					$t = $token['access_token'];
					$fb_id_get_post = $token['fbid'];
					$checkToken = checkToken($token['access_token']);
					if ($checkToken == 1) {
						$ACCESS_TOKEN = $token['access_token'];
						$now = time();
						mysqli_query ($conn, "UPDATE access_token SET last_use = '$now' WHERE access_token = '$t'");
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
						mysqli_query ($conn, "UPDATE access_token SET last_use = '$now' WHERE access_token = '$t'");
						$kt= 1;
						break;
					}
					else{
						mysqli_query ($conn, "UPDATE access_token SET live = '0' WHERE access_token = '$t'");
					}
				}
				$fb_id_get_post="";
			}
			//echo "Get post cho facebook UID: ".$fbid.'</br>';
			//echo $kt;
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
							$story = $getPost['data'][$i]['story']; // Kiểm tra trong chuỗi story có shared a post hoặc shared a video không?
							//echo 'STORY is '.$story.' '.strpos($story, 'shared').' '. substr($story,8, strlen($story) -7).' ';
							$noidung = $getPost['data'][$i]['message'];
							$type = $getPost['data'][$i]['type'];
							if (strpos($story, 'shared') > 0) $type = substr($story,strpos($story, 'shared'), strlen($story) - strpos($story, 'shared') -1);
							//echo "TYPPE is ".$type.' ';
							$description = $getPost['data'][$i]['description'];
							if($noidung !="" || $description !="" ){
								$privacy = $getPost['data'][$i]['privacy']['value'];
								$datecreate = $getPost['data'][$i]['created_time'];
								$datecreate = date ('Y-m-d H:i:s',strtotime($datecreate));
								$likes = 0; 
								$comments = 0;
								$shares = 0;
								// Get Ảnh và video trong bài viết
								$count_attachments= count($getPost['data'][$i]['attachments']['data']['subattachments']['data']);
								if($count_attachments>0){
									$link= $getPost['data'][$i]['link'];
									$title= $getPost['data'][$i]['attachments']['data']['subattachments']['data']['title'];
									$caption=$getPost['data'][$i]['caption'];
									$description= $getPost['data'][$i]['attachments']['data']['subattachments']['data']['description'];
									$picture_arr= array();
									$video_arr= array();
									for($j = 0; $j < $count_attachments; $j++){
										if($getPost['data'][$i]['attachments']['data']['subattachments']['data'][$j]['type'] == "photo"){
											$tmppt = $getPost['data'][$i]['attachments']['data']['subattachments']['data'][$j]['media']['image']['src'].'|'.$getPost['data'][$i]['attachments']['data']['subattachments']['data'][$j]['media']['image']['height'].'|'.$getPost['data'][$i]['attachments']['data']['subattachments']['data'][$j]['media']['image']['width'];
											array_push($picture_arr,$tmppt);
										}
										if($getPost['data'][$i]['attachments']['data']['subattachments']['data'][$j]['type'] == "video"){
											$tmppt = $getPost['data'][$i]['attachments']['data']['subattachments']['data'][$j]['url'].'|'.$getPost['data'][$i]['attachments']['data']['subattachments']['data'][$j]['media']['image']['height'].'|'.$getPost['data'][$i]['attachments']['data']['subattachments']['data'][$j]['media']['image']['width'];
											array_push($video_arr,$tmppt);
										}
									}
									$picture = implode("\n",$picture_arr);
									$video = implode("\n",$video_arr);
									//echo $sttID.' '.$picture.' '.$video.' '.$link.' '.$title.' '.$caption.' '.$description.'</br>';
									$insert = mysqli_query($conn, "INSERT INTO post_detail (id_post, picture,link, video, title, caption, description) VALUES ('$sttID', '$picture', '$link', '$video', '$title', '$caption', '$description')");// Chỉnh lại cho đúng bảng
								}
								else{
									$count_attachments = count($getPost['data'][$i]['attachments']['data']);
									$picture_arr= array();
									$video_arr= array();
									$link= $getPost['data'][$i]['link'];
									$caption=$getPost['data'][$i]['caption'];
									echo $count_attachments.' ';
									for($j = 0; $j < $count_attachments; $j++){
										$description= $getPost['data'][$i]['attachments']['data'][$j]['description'];
										$title= $getPost['data'][$i]['attachments']['data'][$j]['title'];
										if($getPost['data'][$i]['attachments']['data'][$j]['type'] == "photo" || $getPost['data'][$i]['attachments']['data'][$j]['type'] == "share"){
											$tmppt = $getPost['data'][$i]['attachments']['data'][$j]['media']['image']['src'].'|'.$getPost['data'][$i]['attachments']['data'][$j]['media']['image']['height'].'|'.$getPost['data'][$i]['attachments']['data'][$j]['media']['image']['width'];
											array_push($picture_arr,$tmppt);
										}
										if($getPost['data'][$i]['attachments']['data'][$j]['type'] == "video" || $getPost['data'][$i]['attachments']['data'][$j]['type'] == "share"){
											$tmppt = $getPost['data'][$i]['attachments']['data'][$j]['url'].'|'.$getPost['data'][$i]['attachments']['data'][$j]['media']['image']['height'].'|'.$getPost['data'][$i]['attachments']['data'][$j]['media']['image']['width'];
											array_push($video_arr,$tmppt);
										}
									}
									$picture = implode("\n",$picture_arr);
									$video = implode("\n",$video_arr);
									//echo $sttID.' '.$picture.' '.$video.' '.$link.' '.$title.' '.$caption.' '.$description.'</br>';
									$insert = mysqli_query($conn, "INSERT INTO post_detail (id_post, picture,link, video, title, caption, description) VALUES ('$sttID', '$picture', '$link', '$video', '$title', '$caption', '$description')");// Chỉnh lại cho đúng bảng
								}
								if($getContentPost['likes']['count'] != 0) $likes = $getContentPost['likes']['count'];
								if($getContentPost['comments']['count'] != 0) $comments = $getContentPost['comments']['count'];
								if($getContentPost['shares']['count'] != 0) $shares = $getContentPost['shares']['count'];
								$insert = mysqli_query($conn, "INSERT INTO post_keyword (name, id_post,id_user_post, name_user_post, time_post, luot_thich, luot_comment, luot_share, target_id, privacy, type, fb_id_get_post) VALUES ('$noidung', '$sttID', '$id_user_post', '$name_user_post', '$datecreate', '$likes', '$comments', '$shares', '$id', '$privacy', '$type', '$fb_id_get_post')");// Chỉnh lại cho đúng bảng
								echo $sttID.'</br>';
								$update= mysqli_query($conn, "UPDATE target SET last_get_post = '$now' WHERE id = '$id'");
							}
							$count_tags = count ($getPost['data'][$i]['with_tags']['data']);
							if($count_tags > 0){
								for ($j = 0; $j < $count_tags; $j ++){
									$id_tag = $getPost['data'][$i]['with_tags']['data'][$j]['id'];
									$name_tag= $getPost['data'][$i]['with_tags']['data'][$j]['name'];
									$datecreate = $getPost['data'][$i]['created_time'];
									$datecreate = date ('Y-m-d H:i:s',strtotime($datecreate));
									if(check_target($id_tag) == 0 && check_target_new($id_tag) ==0){
										$insert = mysqli_query($conn, "INSERT INTO target_new (fbid, name,fbid_target_lien_quan,id_post, time_post) VALUES ('$id_tag', '$name_tag', '$fbid', '$sttID', '$datecreate')");// Chỉnh lại cho đúng bảng
										//echo "Thêm đối tượng ".$id_tag." vào danh sách đối tượng mới".'</br>';
									}
								}
							}
							if($id_user_post != $fbid){
								if(check_target($id_user_post) == 0 && check_target_new($id_user_post) ==0){
										$datecreate = $getPost['data'][$i]['created_time'];
										$datecreate = date ('Y-m-d H:i:s',strtotime($datecreate));
										$insert = mysqli_query($conn, "INSERT INTO target_new (fbid, name,fbid_target_lien_quan,id_post, time_post) VALUES ('$id_user_post', '$name_user_post', '$fbid', '$sttID', '$datecreate')");// Chỉnh lại cho đúng bảng
										//echo "Thêm đối tượng ".$id_tag." vào danh sách đối tượng mới".'</br>';
								}
							}
						}
					}
				}
			}
			else{
				echo "Token is die";
			}
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
function check_target($fbid){
	global $conn; 
	$result = mysqli_query ($conn, "SELECT * FROM target WHERE fbid ='$fbid'");
	if(mysqli_num_rows($result)>0)
		return 1;
	return 0;
}
function check_target_new($fbid){
	global $conn; 
	$result = mysqli_query ($conn, "SELECT * FROM target_new WHERE fbid ='$fbid'");
	if(mysqli_num_rows($result)>0)
		return 1;
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
	$t = time() - 60*5;
	$result = mysqli_query ($conn, "SELECT * FROM access_token WHERE id in (SELECT token_id FROM tbl_token_target WHERE target_id = '$id') AND last_use < '$t'");
	if(mysqli_num_rows($result) > 0){
		return $result;
	}
	return 0;
}
function get_Post_by_token($fbid, $accessToken, $datefrom, $dateto){
	$yesterday  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
	$yesterday = date ("m/d/y",$yesterday);
	$datefrom = $yesterday;
	$dateto = time();
	$getPost = (file_get_contents('https://graph.facebook.com/v2.1/'.$fbid.'/feed?fields=from,id,likes,message,attachments,comments,shares,privacy,type,story,story_tags,description,link,name,caption&since='.$datefrom.'&until='.$dateto.'&access_token='.$accessToken));
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
	$t = time() - 60*5;
    return mysqli_query($conn, "SELECT access_token FROM access_token WHERE last_use < '$t' ORDER BY RAND() LIMIT ".$limit);
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
