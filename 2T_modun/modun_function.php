<?php
require_once '../2T_config/config_server.php';
//Theo dõi Facebook

function check_package($name, $user_id) {
	global $conn;
	$result = mysqli_query($conn, "SELECT id FROM package_nhom WHERE name = '$name' AND user_id = $user_id");
	if (mysqli_num_rows($result) > 0)
		return 1;
	return 0;
}
function add_package($name, $desc, $user_id) {
	global $conn;
	$t = time();
	$t = date ('Y-m-d H:i:s',$t);
	$result = mysqli_query($conn, "INSERT INTO package_nhom (name, description, user_id, create_time) VALUES ('$name', '$desc', '$user_id', '$t')");
	if ($result)
		return 1;
	return 0;
}
function get_package_nhom($user_id) {
	global $conn;
	$return = array();
	$result = mysqli_query($conn, "SELECT * FROM package_nhom WHERE user_id = '$user_id' ");
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$return[] = $row;
		}
		return $return;
	}
	return 0;
}
function count_target_group($group_id){
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM tbl_group_target WHERE group_id = '$group_id'");
    return $result->num_rows;
}
function count_target_member($member_id){
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM tbl_group_target WHERE group_id IN (SELECT id FROM package_nhom WHERE user_id = '$member_id')");
	if($result)
		return $result->num_rows;
	else return 0;
}
function count_group_member($member_id){
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM package_nhom WHERE user_id = '$member_id'");
	if($result)
		return $result->num_rows;
	else return 0;
}
function delete_package_nhom($id) {
	global $conn;
	$result0 = mysqli_query($conn, "DELETE FROM post_keyword WHERE target_id in (SELECT target_id FROM tbl_group_target WHERE group_id = '$id')");
	$result1 = mysqli_query($conn, "DELETE FROM target WHERE target_id in (SELECT target_id FROM tbl_group_target WHERE group_id = '$id')");
	$result2 = mysqli_query($conn, "DELETE FROM tbl_group_target WHERE group_id = '$id'");
	$result3 = mysqli_query($conn, "DELETE FROM package_nhom WHERE id = '$id'");
	if ($result0 && $result1 && $result2 && $result3)
		return 1;
	return 0;
}
function update_package_nhom($id, $name, $mota) {
	global $conn;
	$result = mysqli_query($conn, "UPDATE package_nhom SET name = '$name', description = '$mota' WHERE id = '$id'");
	if ($result)
		return 1;
	return 0;
}
// Add Target
function getNhom($name_nhom, $user_id) {
	global $conn;
	$return = array();
	$result = mysqli_query($conn, "SELECT * FROM package_nhom WHERE name = '$name_nhom' AND user_id = '$user_id' LIMIT 1");
	$row    = mysqli_fetch_assoc($result);
	return $row;
}
function get_id_nhom($name_nhom, $user_id) {
	global $conn;
	$return = array();
	$result = mysqli_query($conn, "SELECT * FROM package_nhom WHERE name = '$name_nhom' AND user_id = '$user_id' LIMIT 1");
	$row = mysqli_fetch_assoc($result);
	return $row['id'];
}
function checkFacebookId($fbid, $id_nhom){
	global $conn;
	$kt=0;
	$result = mysqli_query($conn, "SELECT * FROM tbl_group_target WHERE target_id IN (SELECT id FROM target WHERE fbid = '$fbid')");
	while ($row = mysqli_fetch_assoc($result)){
		if($id_nhom == $row['group_id']){
			$kt=1;
			break;
		}
	}
	return $kt;
}
function insert_target($fbid, $name, $id_nhom, $time_add) {
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM target WHERE fbid = '$fbid'");
	if($result->num_rows == 0) { //chưa có trong bảng target
        $result = mysqli_query($conn, "INSERT INTO target (fbid, name, time_add) VALUES ('$fbid', '$name', '$time_add')");
        if (!$result) {
            return 0;
        }
    }
    $result = mysqli_query($conn, "SELECT * FROM target WHERE fbid = '$fbid' LIMIT 1");
    $tmp = mysqli_fetch_assoc($result);
    $target_id = $tmp['id'];
    $result = mysqli_query($conn, "INSERT INTO tbl_group_target (group_id, target_id) VALUES ('$id_nhom', '$target_id')");
    if($result)
        return 1;
    return 0;
}
// Link Feed
function Check_Link_Feed($link,$user_id){
	global $conn; 
	$result = mysqli_query ($conn, "SELECT * FROM link_feed WHERE link = '$link' AND user_id = '$user_id'");
	if (mysqli_num_rows($result) > 0)
		return 1;
	return 0;
}
function Insert_Link_Feed($link,$description,$user_id){
	global $conn; 
	$t = time();
	$t = date ('Y-m-d H:i:s',$t);
	$result = mysqli_query ($conn, "INSERT INTO link_feed (link, description,user_id,create_time) VALUES ('$link', '$description', '$user_id', '$t')");
	if($result)
		return 1;
	return 0;
}
function Get_Link_Feed($user_id) {
	global $conn;
	$return = array();
	$result = mysqli_query($conn, "SELECT * FROM link_feed WHERE user_id = '$user_id' ");
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$return[] = $row;
		}
		return $return;
	}
	return 0;
}
function Update_Link_Feed($link, $description, $id){
	global $conn;
	$result = mysqli_query($conn, "UPDATE link_feed SET link = '$link', description = '$description' WHERE id = '$id'");
	if ($result)
		return 1;
	return 0;
}
function Delete_Link_Feed($id) {
	global $conn;
	$result1 = mysqli_query($conn, "DELETE FROM link_feed WHERE id = '$id'");
	if ($result1)
		return 1;
	return 0;
}
//Manage target
function get_target($user_id) {
	global $conn;
	$return = array();
	/*if ($name_manager == 'admin') {
		$result = mysqli_query($conn, "SELECT * FROM target");
	} else {
		$result = mysqli_query($conn, "SELECT * FROM target WHERE manager = '$name_manager'");
	}*/
	$result = mysqli_query ($conn, "SELECT target.fbid, target.name as targetname, target.acc_is_friend_member, package_nhom.name as groupname  FROM target, package_nhom, tbl_group_target WHERE target.id = tbl_group_target.target_id AND tbl_group_target.group_id = package_nhom.id AND user_id = '$user_id'");
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$return[] = $row;
		}
		return $return;
	}
}
function updateTarget($id, $nhom, $group_id_old, $user_id){
	global $conn;
	$idnhom = get_id_nhom($nhom, $user_id);
	$result2 = mysqli_query($conn, "UPDATE tbl_group_target SET group_id = '$idnhom' WHERE target_id = '$id' AND group_id = '$group_id_old'");
	if ($result2)
		return 1;
	return 0;
}
function get_name_group_by_target_id($id_target, $user_id){
	global $conn;
    $return = array();
	$result = mysqli_query($conn, "SELECT * FROM package_nhom WHERE user_id = '$user_id' AND id IN (SELECT group_id FROM tbl_group_target As a, target As b WHERE a.target_id = b.id AND b.id = '$id_target')");
    while ($row = mysqli_fetch_assoc($result)) {
        $return[] = $row;
    }
    return $return;
}
function getNameTarget($target_id){
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM target WHERE id = '$target_id'");
	$row = mysqli_fetch_assoc($result);
	return $row['name'];
}

function get_id_group_by_name($name_group, $user_id){
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM package_nhom WHERE name = '$name_group' AND user_id = '$user_id'");
    if (mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        return $row['id'];
    }
    return 0;
}
// Search Keyword
function xoa_post_by_user($user){
	global $conn;
	$result = mysqli_query($conn, "DELETE FROM post_keyword WHERE manager = '$user' ");
}
function getTarget($idnhom){
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM target WHERE id in (SELECT target_id FROM tbl_group_target WHERE group_id = '$idnhom')");
	return $result;
}
function getPostByGroup($tennhom,$userid,$datefrom,$dateto){
	global $conn;
	if($tennhom == "all"){
		$result = mysqli_query($conn, "SELECT * FROM post_keyword WHERE target_id in (SELECT target_id FROM tbl_group_target WHERE group_id in (SELECT id FROM package_nhom WHERE user_id = '$userid')) AND time_post > '$datefrom' AND time_post <'$dateto'");
	}
	else{
		$result = mysqli_query($conn, "SELECT * FROM post_keyword WHERE target_id in (SELECT target_id FROM tbl_group_target, package_nhom WHERE user_id = '$userid' AND name = '$tennhom') AND time_post > '$datefrom' AND time_post <'$dateto'");
	}
	return $result;
}
/*function insert_post_to_search_post_keyword($noidung,$post_id,$time_post,$like,$comment, $share, $target_id, $user_id){
	global $conn; 
	$result = mysqli_query($conn, "INSERT INTO search_keyword_result (name,id_post,time_post, luot_thich,luot_comment,luot_share, target_id, $user_id) VALUES ('$noidung', '$post_id', '$time_post', '$like', '$comment', '$share', '$target_id', '$user_id')");
	return $result;
}
function detele_search_keyword_result($user_id){
	global $conn;
	$result = "DELETE FROM search_keyword_result WHERE user_id = '$user_id'");
	return $result;
}*/
function getTokenLive($sl){
	$tokens = getTokenBySL($sl);
	$kt=0;
	$ACCESS_TOKEN = "1";
	for($i=0; $i<= count($tokens); $i++){
		if(_checkToken($tokens[$i]) == 1){
			$ACCESS_TOKEN = $tokens[$i];
			$kt=1;
			break;
		}
	}
	if($ACCESS_TOKEN != "1") return $ACCESS_TOKEN;
	else getTokenLive($sl);
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

function getName($fbid, $token){
    $getName = json_decode(file_get_contents('https://graph.facebook.com/'. $fbid . '?access_token=' . $token));
    if($getName->id){
        return $getName->name;
    }
    return 0;
}

function checkToken($token){
    $get = json_decode(file_get_contents('https://graph.facebook.com/me/?access_token='.$token.'&field=id'), true);
    if ($get['id']) {
        return 1;
    }
    return 0;
}

function get_tokens_random($limit){
    global $conn;
    return mysqli_query($conn, "SELECT access_token FROM access_token ORDER BY RAND() LIMIT ".$limit);
}
function add_to_post_keyword($tendoituong,$quanly, $sttID, $datecreat,$like,$comment,$share){
	global $conn;
	$tmp = $like.",".$comment.",".$share;
	$result = mysqli_query($conn, "INSERT INTO post_keyword (name, manager, id_post,time_post, luot_thich,luot_comment,luot_share) VALUES ('$tendoituong', '$quanly', '$sttID', '$datecreat', '$like', '$comment', '$share')");
	if ($result)
		return 1;
	return 0;
}
function dem_post_theo_tu_khoa($user){
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM post_keyword WHERE manager = '$user'");
	if(mysqli_num_rows($result) >0){
		return mysqli_num_rows($result);
	}
	return 0;
}
function load_post($user_id) {
	global $conn;
	$return = array();
	$result = mysqli_query($conn, "SELECT target.name as targetname, post_keyword.name as content, post_keyword.luot_thich, post_keyword.luot_comment, post_keyword.luot_share, post_keyword.time_post, package_nhom.name as groupname, post_keyword.id_post FROM post_keyword, target, package_nhom, tbl_group_target  WHERE post_keyword.target_id = target.id AND target.id = tbl_group_target.target_id AND tbl_group_target.group_id = package_nhom.id AND package_nhom.user_id = '$user_id' ORDER BY time_post");
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$return[] = $row;
		}
		return $return;
	}
}
// Thêm Mới Các Gói VIP

function check_package_cmt($name) {
	global $conn;
	$result = mysqli_query($conn, "SELECT id FROM package_vip_cmt WHERE name = '$name'");
	if (mysqli_num_rows($result) > 0)
		return 1;
	return 0;
}

function add_package_cmt($name, $vnd, $limitLike, $limitPost) {
	global $conn;
	$result = mysqli_query($conn, "INSERT INTO package_vip_cmt (name, price, limit_cmt, limit_post) VALUES ('$name', '$vnd', '$limitLike', $limitPost)");
	if ($result)
		return 1;
	return 0;
}
function get_package_cmt() {
	global $conn;
	$return = array();
	$result = mysqli_query($conn, "SELECT * FROM package_vip_cmt");
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$return[] = $row;
		}
		return $return;
	}
	return 0;
}
function get_package_vip_bot() {
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM package_vip_bot WHERE id = 1");
	$row    = mysqli_fetch_assoc($result);
	return $row;
}

function update_package_vip_cmt($id, $name, $vnd, $limitLike, $limitPost) {
	global $conn;
	$result = mysqli_query($conn, "UPDATE package_vip_cmt SET name = '$name', price = '$vnd', limit_cmt = '$limitLike', limit_post ='$limitPost' WHERE id = '$id'");
	if ($result)
		return 1;
	return 0;
}

function delete_package_cmt($id) {
	global $conn;
	$result = mysqli_query($conn, "DELETE FROM package_vip_cmt WHERE id = '$id'");
	if ($result)
		return 1;
	return 0;
}
function get_name_package() {
	global $conn;
	$result = mysqli_query($conn, "SELECT name FROM package_vip");
	$row    = mysqli_fetch_assoc($result);
	return $row;
}
function getPackage($name_package) {
	global $conn;
	$return = array();
	$result = mysqli_query($conn, "SELECT * FROM package_vip WHERE name = '$name_package' LIMIT 1");
	$row    = mysqli_fetch_assoc($result);
	return $row;
}
function getPackage_cmt($name_package) {
	global $conn;
	$return = array();
	$result = mysqli_query($conn, "SELECT * FROM package_vip_cmt WHERE name = '$name_package' LIMIT 1");
	$row    = mysqli_fetch_assoc($result);
	return $row;
}
function insert_vip($fbid, $name, $name_buy, $name_package, $limit_time, $time_buy, $speed, $camxuc, $sex) {
	global $conn;
	$result = mysqli_query($conn, "INSERT INTO vip_like (fbid, name, name_buy, name_package, limit_time, time_buy, speed, action, camxuc, sex) VALUES ('$fbid', '$name', '$name_buy', '$name_package', '$limit_time', '$time_buy', '$speed', 'checked', '$camxuc', '$sex')");
	if ($result)
		return 1;
	return 0;
}
//
function getUser($id) {
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM member WHERE id = '$id' LIMIT 1");
	$row    = mysqli_fetch_assoc($result);
	return $row;
}
function getUserbyName($username) {
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM member WHERE user = '$username' LIMIT 1");
	$row    = mysqli_fetch_assoc($result);
	return $row;
}
function updateVNDUser($newVND, $_c = 0, $id = 0) {
	if ($id == 0) {
		$id = $_SESSION['id'];
	}
	if ($_c == 0) {
		$_SESSION['vnd'] = $newVND;
	}
	global $conn;
	$result = mysqli_query($conn, "UPDATE member SET vnd = '$newVND' WHERE id = '" . $id . "'");
	if ($result) {
		return 1;
	}
	return 0;
}
function updatePassUser($newPass) {
	global $conn;
	$result = mysqli_query($conn, "UPDATE member SET pass = '$newPass' WHERE id = '" . $_SESSION['id'] . "'");
	if ($result)
		return 1;
	return 0;
}
function checkUser($username) {
	global $conn;
	$result = mysqli_query($conn, "SELECT id FROM member WHERE user = '$username'");
	if (mysqli_num_rows($result) > 0)
		return 1;
	return 0;
}
function creatUser($fullname, $user, $pass, $email) {
	global $conn;
	$result = mysqli_query($conn, "INSERT INTO member (fullname, user, pass, email, block) VALUES ('$fullname', '$user', '$pass', '$email', 'checked')");
	if ($result)
		return 1;
	return 0;
}
function setSession($userA, $admin) {
	$_SESSION['login']    = 1;
	$_SESSION['fullname'] = $userA['fullname'];
	$_SESSION['id']       = $userA['id'];
	$_SESSION['username'] = $userA['user'];
	$_SESSION['email']    = $userA['email'];
	$_SESSION['vnd']      = $userA['vnd'];
	if (in_array($userA['user'], $admin)) {
		$_SESSION['admin'] = 1;
	}
}
function get_vip_like($name_buy) {
	global $conn;
	$return = array();
	if ($name_buy == 'admin') {
		$result = mysqli_query($conn, "SELECT * FROM vip_like");
	} else {
		$result = mysqli_query($conn, "SELECT * FROM vip_like WHERE name_buy = '$name_buy'");
	}
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$return[] = $row;
		}
		return $return;
	}
}
function get_member() {
	global $conn;
	$return = array();
	$result = mysqli_query($conn, "SELECT * FROM member");
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$return[] = $row;
		}
		return $return;
	}
}
function get_vip_cmt($name_buy) {
	global $conn;
	$return = array();
	if ($name_buy == 'admin') {
		$result = mysqli_query($conn, "SELECT * FROM vip_cmt");
	} else {
		$result = mysqli_query($conn, "SELECT * FROM vip_cmt WHERE name_buy = '$name_buy'");
	}
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$return[] = $row;
		}
		return $return;
	}
}
function get_vip_bot($name_buy) {
	global $conn;
	$return = array();
	if ($name_buy == 'admin') {
		$result = mysqli_query($conn, "SELECT * FROM vip_bot");
	} else {
		$result = mysqli_query($conn, "SELECT * FROM vip_bot WHERE name_buy = '$name_buy'");
	}
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$return[] = $row;
		}
		return $return;
	}
}
function action_vip_like($checked, $value) {
	global $conn;
	$result = mysqli_query($conn, "UPDATE vip_like SET action = '$checked' WHERE id = '$value'");
	if ($result)
		return 1;
	return 0;
}
function action_vip_cmt($checked, $value) {
	global $conn;
	$result = mysqli_query($conn, "UPDATE vip_cmt SET action = '$checked' WHERE id = '$value'");
	if ($result)
		return 1;
	return 0;
}
function action_member($checked, $value) {
	global $conn;
	$result = mysqli_query($conn, "UPDATE member SET block = '$checked' WHERE id = '$value'");
	if ($result)
		return 1;
	return 0;
}
function action_vip_bot($checked, $value) {
	global $conn;
	$result = mysqli_query($conn, "UPDATE vip_bot SET action = '$checked' WHERE id = '$value'");
	if ($result)
		return 1;
	return 0;
}
function insert_vip_bot_cookie($id, $name, $name_buy, $reaction, $access, $limit_time, $fb_dtsg) {
	global $conn;
	$result = mysqli_query($conn, "INSERT INTO vip_bot (fbid, fbname, name_buy, type_react, type_access, access_token, access_cookie, limit_time, time_buy, action, fb_dtsg) VALUES ('$id', '$name', '$name_buy', '$reaction', 'ACCESS_COOKIE', 'NULL', '$access', '$limit_time', '" . time() . "', 'checked', '$fb_dtsg')");
	if ($result)
		return 1;
	return 0;
}
function insert_vip_bot_token($id, $name, $name_buy, $reaction, $access, $limit_time) {
	global $conn;
	$result = mysqli_query($conn, "INSERT INTO vip_bot (fbid, fbname, name_buy, type_react, type_access, access_token, access_cookie, limit_time, time_buy, action) VALUES ('$id', '$name', '$name_buy', '$reaction', 'ACCESS_TOKEN','$access', 'NULL',  '$limit_time', '" . time() . "', 'checked')");
	if ($result)
		return 1;
	return 0;
}
function update_vip_bot($id, $access, $type_access, $type_react, $fb_dtsg = '') {
	global $conn;
	if ($type_access === 'TOKEN') {
		$result = mysqli_query($conn, "UPDATE vip_bot SET type_react = '$type_react', access_token = '$access', type_access = 'ACCESS_TOKEN' WHERE id = '$id'");
	}
	if ($type_access === 'COOKIE') {
		$result = mysqli_query($conn, "UPDATE vip_bot SET type_react = '$type_react', type_access = 'ACCESS_COOKIE', access_cookie = '$access', fb_dtsg = '$fb_dtsg' WHERE id = '$id'");
	}
	if ($result)
		return 1;
	return 0;
}
function edit_package_vip_bot($name, $vnd) {
	global $conn;
	$result = mysqli_query($conn, "UPDATE package_vip_bot SET name = '$name', vnd = '$vnd'");
	if ($result)
		return 1;
	return 0;
}
function create_gift($vnd) {
	global $conn;
	$gift   = generateRandomString();
	$result = mysqli_query($conn, "INSERT INTO gift_code (gift, vnd, `time`) VALUES ('$gift', '$vnd', '" . time() . "')");
	if ($result)
		return $gift;
	return 0;
}
function get_gift_code() {
	global $conn;
	$return = array();
	$result = mysqli_query($conn, "SELECT * FROM gift_code");
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$return[] = $row;
		}
		return $return;
	}
}
function insert_vip_cmt($fbid, $name, $name_buy, $name_package, $limit_time, $time_buy, $speed, $cmt, $sex) {
	global $conn;
	$result = mysqli_query($conn, "INSERT INTO vip_cmt (fbid, name, name_buy, name_package, limit_time, time_buy, speed, action, cmt, sex) VALUES ('$fbid', '$name', '$name_buy', '$name_package', '$limit_time', '$time_buy', '$speed', 'checked', '$cmt', '$sex')");
	if ($result)
		return 1;
	return 0;
}
function gift($gift) {
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM gift_code WHERE gift = '$gift' LIMIT 1");
	if (mysqli_num_rows($result) > 0) {
		$gift    = mysqli_fetch_assoc($result);
		$getUser = getUser($_SESSION['id']);
		updateVNDUser($getUser['vnd'] + $gift['vnd']);
		$del_gift = mysqli_query($conn, "DELETE FROM gift_code WHERE id = '" . $gift['id'] . "'");
		return $gift['vnd'];
	}
	return 0;
}
function addMultiToken($arrToken, $arrID, $arrGender) {
	global $conn;
	$sql = array();
	for ($i = 0; $i < count($arrToken); $i++) {
		$sql[] = '(' . ($arrID[$i]) . ', "' . $arrToken[$i] . '", "' . $arrGender[$i] . '")';
		//showNotification($arrGender[$i]);
	}
	$insert = mysqli_query($conn, 'INSERT INTO access_token (fbid, access_token,gender) VALUES ' . implode(',', $sql));
	if ($insert)
		return 1;
	return 0;
	/*try{
	    $query = 'INSERT INTO access_token (fbid, access_token,gender) VALUES ' . implode(',', $sql);
        $result = mysqli_query($conn, $query);
        return $query. $result;
    }catch(Exception $e){
	    return $e->getMessage();
    }*/
}
function generateRandomString($length = 10) {
	$characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString     = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return strtoupper($randomString);
}
function isAdmin() {
	if ($_SESSION['admin'] == 1)
		return 1;
	return 0;
}
function getTokenToServer($type) {
	global $conn;
	$token  = array();
	$result = mysqli_query($conn, "SELECT * FROM access_token");
	if ($result) {
		while ($row = mysqli_fetch_assoc($result)) {
			$token[] = $row[$type];
		}
	}
	return $token;
}
function delMultiToken($tokendie) {
	global $conn;
	foreach ($tokendie as $key => $value) {
		mysqli_query($conn, "DELETE FROM access_token WHERE access_token = '$value'");
	}
	return 1;
}
function updateVipLikeByAdmin($id, $fbid, $name, $package, $speed, $camxuc, $sex) {
	global $conn;
	$update = mysqli_query($conn, "UPDATE vip_like SET fbid = '$fbid', name = '$name', name_package = '$package', speed = '$speed', camxuc = '$camxuc', sex = '$sex' WHERE id = '$id'");
	if ($update) {
		return 1;
	}
	return 0;
}
function updateMember($id, $fullname, $user, $email, $vnd) {
	global $conn;
	$update = mysqli_query($conn, "UPDATE member SET fullname = '$fullname', user = '$user', email = '$email', vnd = '$vnd' WHERE id = '$id'");
	if ($update) {
		return 1;
	}
	return 0;
}
function updateVipLikeByUser($id, $fbid, $name, $speed, $camxuc, $sex) {
	global $conn;
	$update = mysqli_query($conn, "UPDATE vip_like SET fbid = '$fbid', name = '$name', speed = '$speed', camxuc = '$camxuc', sex = '$sex' WHERE id = '$id'");
	if ($update) {
		return 1;
	}
	return 0;
}
function updateVipCmt($id, $cmt, $fbid, $name, $sex, $speed) {
	global $conn;
	$update = mysqli_query($conn, "UPDATE vip_cmt SET cmt = '$cmt', fbid = '$fbid', name = '$name', sex = '$sex', speed = '$speed' WHERE id = '$id'");
	if ($update) {
		return 1;
	}
	return 0;
}
function updateVipCmtByAdmin($id, $fbid, $name, $package, $cmt, $speed) {
	global $conn;
	$update = mysqli_query($conn, "UPDATE vip_cmt SET fbid = '$fbid', name = '$name', speed = '$speed', name_package = '$package', cmt = '$cmt' WHERE id = '$id'");
	if ($update) {
		return 1;
	}
	return 0;
}
function delete_target($id_target, $id_group) {
	global $conn;
	$result1 = mysqli_query($conn, "DELETE FROM tbl_group_target WHERE target_id = '$id_target' AND group_id = '$id_group'");
	$result2 = mysqli_query($conn, "DELETE FROM post_keyword WHERE target_id = '$id_target' ");
	$result3 = mysqli_query($conn, "DELETE FROM target WHERE id = '$id_target'");
	if ($result1 || $result2 || $result3)
		return 1;
	return 0;
}
function getTokenBySL($sl) {
	global $conn;
	$token  = array();
	$result = mysqli_query($conn, "SELECT access_token FROM access_token ORDER BY RAND() LIMIT $sl");
	if ($result) {
		while ($row = mysqli_fetch_assoc($result)) {
			$token[] = $row['access_token'];
		}
	}
	return $token;
}
function _p($t) {
	$t = addslashes($t);
	$t = stripslashes($t);
	return $t;
}
function _i($t) {
	global $conn;
	return mysql_real_escape_string($conn, $t);
}
function _c($url) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json'
	));
	return curl_exec($ch);
}
function _saveNotify($txt) {
	$file = @fopen('notify.txt', 'a+');
	@fwrite($file, $txt);
	@fclose($file);
}
function _saveCard($txt) {
	$file = @fopen('card.log.txt', 'a+');
	@fwrite($file, $txt . "\n");
	@fclose($file);
}
function _saveVip($txt) {
	$file = @fopen('buyvip.log.txt', 'a+');
	@fwrite($file, $txt . "\n");
	@fclose($file);
}
function __c($url, $cookie) {
	$ch = @curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	$head[] = "Connection: keep-alive";
	$head[] = "Keep-Alive: 300";
	$head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$head[] = "Accept-Language: en-us,en;q=0.5";
	curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14');
	curl_setopt($ch, CURLOPT_ENCODING, '');
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Expect:'
	));
	$page = curl_exec($ch);
	curl_close($ch);
	return $page;
}
function _checkToken($token){
	$url = 'https://graph.fb.me/me/?access_token='.$token;
	$json = json_decode(file_get_contents($url));
	if ($json->id) return 1;
	return 0;
}
function _me($token){
	$url = 'https://graph.fb.me/me/?access_token='.$token;
	$json = json_decode(file_get_contents($url));
	if ($json->id) return $json;
	return 0;
}
?>