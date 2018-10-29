<?php
require_once 'modun_function.php';
if($_REQUEST){
	$return = array('error' => 0);
	$t = $_REQUEST['t'];
	if ($t === 'new_package_group') {
		/*if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}*/
		$name = _p($_POST['name']);
		$mota = _p($_POST['mota']);
		if (check_package($name, $_SESSION['id']) === 0) {
			if (add_package($name, $mota, $_SESSION['id'])) {
				$return['msg'] = 'Thêm Nhóm '.$name.' Thành Công vào danh sách theo dõi';
				die(json_encode($return));
			} else {
				$return['error'] = 1;
				$return['msg']   = 'Không Thể Thêm Nhóm này. Vui Lòng Kiểm Tra Lại';
				die(json_encode($return));
			}
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Tên Nhóm Đã Tồn Tại Trên Hệ Thống, Vui Lòng Sử Dụng Tên Khác!';
			die(json_encode($return));
		}
	}
	if ($t === 'get_package_nhom') {
		/*if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}*/
		$data = array();
		$gP = get_package_nhom($_SESSION['id']);
		$long = count($gP);
		if ($gP != 0) {
			for ($i=0; $i < $long; $i++) {
				$data[] = array(
					$gP[$i]['id'],
					$gP[$i]['name'],
					$gP[$i]['description'],
					count_target_group($gP[$i]['id']),
					$gP[$i]['create_time']
				);
			}
		}
		$return = array('data' => $data);
		die(json_encode($return));
	}
	if ($t === 'delete_package_nhom') {
		/*if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}*/
		$id = _p($_POST['id']);
		if (delete_package_nhom($id)) {
			$return['msg'] = 'Xóa Thành Công!';
			die(json_encode($return));
		}
	}
	if ($t === 'update_package_nhom') {
		/*if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}*/
		$id = _p($_POST['id']);
		$name = _p($_POST['name']);
		$mota = _p($_POST['mota']);
		if (update_package_nhom($id, $name, $mota)) {
			$return['msg'] = 'Chỉnh nhóm Thành Công!';
			die(json_encode($return));
		}
		else{
            $return['error'] = 1;
            $return['msg']   = 'Nhóm đã tồn tại';
            die(json_encode($return));
		}

	}
// Add target
	if($t === 'add_target'){
		$fbid = _p($_POST['id']);
		if(!preg_match('/[0-9]/' ,$fbid, $matchs)){
			$return['error'] = 1;
			$return['msg']   = 'ID FB Bạn Nhập Không Đúng Định Dạng';
			die(json_encode($return));
		}
		$name = _p($_POST['user']);
		$name_nhom = _p($_POST['nhom']);
		$nhom = getNhom($name_nhom, $_SESSION['id']);
		$id_nhom= $nhom['id'];
		$user = getUser($_SESSION['id']);
		if (checkFacebookId($fbid,$id_nhom)==0) {
			if (insert_target($fbid, $name, $id_nhom, time())) {
				$return['msg'] = 'Thêm đối tượng '.$name.' vào nhóm '.$name_nhom.' thành công';
				die(json_encode($return));
			}
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Đối tượng này đã được thêm vào nhóm '.$name_nhom;
			die(json_encode($return));
		}
	}
	if ($t === 'get_name_package_nhom') {
		die(json_encode(get_package_nhom($_SESSION['id'])));
	}
	
// Manager Target
	if ($t === 'update-target') {
		$id  = _p($_POST['id']);
		$fbid = _p($_POST['fbid']);
		$name = _p($_POST['name']);
		$nhom = _p($_POST['nhom']);
		$update = updateTarget($id, $fbid, $name, $nhom);
		if ($update) {
			$return['msg'] = "Chỉnh Sửa Thành Công";
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg'] = "Không Thể Chỉnh Sửa";
			die(json_encode($return));
		}
	}
	if ($t === 'load-target') {
		$vip = get_target($_SESSION['id']);
		$data = array();
		$long = count($vip);
		if ($vip !== 0) {
			for ($i=0; $i < $long; $i++) {
				$id_target= $vip[$i]['id'];
				$name_group=  get_name_group_by_target_id($id_target, $_SESSION['id']);
				$data[] = array(
					$vip[$i]['id'],
					$vip[$i]['fbid'],
					$vip[$i]['name'],
					$name_group,
				);
			}
			$return = array('data' => $data);
			die(json_encode($return));
		}
	}

    if ($t === 'get-name'){
        $fbid = _p($_POST['fbid']);
        $tokens = get_tokens_random(20);
        $alive_token = 0;
        while ($token = mysqli_fetch_assoc($tokens)) {
            $checkToken = checkToken($token['access_token']);
            if ($checkToken == 1) {
                $ACCESS_TOKEN = $token['access_token'];
                $alive_token = 1;
                break;
            }
        }
        if ($alive_token){
            $name = getName($fbid, $ACCESS_TOKEN);

            if ($name){
            	$return['error'] = 0;
                $return['msg'] = $name;
                die(json_encode($return));
            }else{
                $return['error'] = 1;
                $return['msg'] = 'Không tìm thấy Facebook có id: ' . $fbid;
                die(json_encode($return));
            }
        }
        else {
            $return['error'] = 1;
            $return['msg'] = 'Token died';
            die(json_encode($return));
        }

    }
// Search by Keyword
	if ($t === 'search_keyword') {
        //echo "<script type='text/javascript'>alert('abc');</script>";
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
		$posts = getPostByGroup($tennhom,$user_id);
		while($row = mysqli_fetch_assoc($targets)){
			$id_target = $target['name'];
			$quanly = $target['manager'];
			$ACCESS_TOKEN = getTokenLive(20);
			if($ACCESS_TOKEN !="0"){
				$fbid = $target['fbid'];
				//echo $tendoituong." ".$quanly." ".$ACCESS_TOKEN." ".$fbid." ".$keyword."</br>";
				if($dateto ==$today)
				{
					$t = time();
					//echo $t;
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
					//echo $sttID." ".$noidung." ".$datecreat." ".$like." ".$comment." ".$share."</br>";
						if (preg_match(strtolower($keyword), strtolower($noidung), $match)) :
						  add_to_post_keyword($tendoituong,$quanly,$id_nhom,$sttID,$datecreat, $like,$comment,$share);
						  endif;
					}
				}
			}
			else{
				$return['msg'] = 'Vui lòng thêm Token Live vào hệ thống';
				die(json_encode($return));
				break;
			}
		}
		$sopost = dem_post_theo_tu_khoa($_SESSION['username']);
		if ($sopost > 0) {
				$return['msg'] = 'Nhóm '.$tennhom.' có '.$sopost.' liên quan đến từ khóa: '.$keyword_goc;
				die(json_encode($return));
			} else {
				$return['error'] = 1;
				$return['msg']   = 'Không có bài viết nào liên quan';
				//$return['msg']   = strtotime($datefrom);
				die(json_encode($return));
			}
	}
	if ($t === 'load-post') {
		$vip = load_post($_SESSION['username']);
		$data = array();
		$long = count($vip);
		if ($vip !== 0) {
			for ($i=0; $i < $long; $i++) {
				$data[] = array(
					$i+1,
					$vip[$i]['target_id'],
					$vip[$i]['name'],
					$vip[$i]['time_post'],
					$vip[$i]['luot_thich'].','.$vip[$i]['luot_comment'].','.$vip[$i]['luot_share'],
				);
			}
			$return = array('data' => $data);
			die(json_encode($return));
		}
	}
//VipLike
	if ($t === 'new_package_vip_like') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$name = _p($_POST['name']);
		$vnd = _p($_POST['vnd']);
		$limitLike = _p($_POST['limitLike']);
		$limitPost = _p($_POST['limitPost']);
		if (check_package($name) === 0) {
			if (add_package($name, $vnd, $limitLike, $limitPost)) {
				$return['msg'] = 'Thêm Mới Gói VIP '.$name.' Thành Công!';
				die(json_encode($return));
			} else {
				$return['error'] = 1;
				$return['msg']   = 'Không Thể Thêm Gói Mới. Vui Lòng Kiểm Tra Lại';
				die(json_encode($return));
			}
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Tên Gói VIP Đã Tồn Tại Trên Hệ Thống, Vui Lòng Sử Dụng Tên Khác!';
			die(json_encode($return));
		}
	}
	if ($t === 'new_package_vip_cmt') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$name = _p($_POST['name']);
		$vnd = _p($_POST['vnd']);
		$limitLike = _p($_POST['limitLike']);
		$limitPost = _p($_POST['limitPost']);
		if (check_package_cmt($name) === 0) {
			if (add_package_cmt($name, $vnd, $limitLike, $limitPost)) {
				$return['msg'] = 'Thêm Mới Gói VIP '.$name.' Thành Công!';
				die(json_encode($return));
			} else {
				$return['error'] = 1;
				$return['msg']   = 'Không Thể Thêm Gói Mới. Vui Lòng Kiểm Tra Lại';
				die(json_encode($return));
			}
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Tên Gói VIP Đã Tồn Tại Trên Hệ Thống, Vui Lòng Sử Dụng Tên Khác!';
			die(json_encode($return));
		}
	}
	if ($t === 'get_package_cmt') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$data = array();
		$gP = get_package_cmt();
		$long = count($gP);
		if ($gP != 0) {
			for ($i=0; $i < $long; $i++) {
				$data[] = array(
					$gP[$i]['id'],
					$gP[$i]['name'],
					$gP[$i]['price'],
					$gP[$i]['limit_cmt'],
					$gP[$i]['limit_post']
				);
			}
		}
		$return = array('data' => $data);
		die(json_encode($return));
	}
	if ($t === 'update_package_vip_cmt') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$id = _p($_POST['id']);
		$name = _p($_POST['name']);
		$vnd = _p($_POST['vnd']);
		$limitLike = _p($_POST['limitLike']);
		$limitPost = _p($_POST['limitPost']);
		if (update_package_vip_cmt($id, $name, $vnd, $limitLike, $limitPost)) {
			$return['msg'] = 'Chỉnh Sửa Gói VIP '.$name.' Thành Công!';
			die(json_encode($return));
		}
	}
	if ($t === 'delete_package_cmt') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$id = _p($_POST['id']);
		if (delete_package_cmt($id)) {
			$return['msg'] = 'Xóa Thành Công!';
			die(json_encode($return));
		}
	}
	if ($t === 'get_name_package') {
		die(json_encode(get_package()));
	}
	if ($t === 'get_name_package_cmt') {
		die(json_encode(get_package_cmt()));
	}
	if($t === 'buy-vip'){
		$fbid = _p($_POST['id']);
		if(!preg_match('/[0-9]/' ,$fbid, $matchs)){
			$return['error'] = 1;
			$return['msg']   = 'ID FB Bạn Nhập Không Đúng Định Dạng';
			die(json_encode($return));
		}
		$name = _p($_POST['user']);
		$name_package = _p($_POST['package']);
		$speed = _p($_POST['speed']);
		$limit_time = _p($_POST['time']);
		$camxuc = _p($_POST['camxuc']);
		$sex = _p($_POST['sex']);
		$package = getPackage($name_package);
		if($limit_time < 1 || $limit_time > 6 || $speed < 0 || $speed > 100 || !$package['name']){
			$return['error'] = 1;
			$return['msg']   = 'Phát Hiện Hành Vi Cheat Hệ Thống. Tài Khoản Sẽ Có Thể Bị Khóa';
			die(json_encode($return));
		}
		$user = getUser($_SESSION['id']);
		$price = $package['price']*$limit_time;
		if ($user['vnd'] >= $price) {
			$truVND = updateVNDUser($user['vnd'] - $price);
			if (insert_vip($fbid, $name, $_SESSION['username'], $name_package, $limit_time, time(), $speed, $camxuc, $sex) && $truVND) {
				$return['msg'] = 'Mua VIP Thành Công Cho Người Dùng '.$name.' ('.$fbid.')';
				$txt = 'Vip Like||'.$_SESSION['username'].'||'.$fbid.'||'.$name.'||'.$name_package.'||'.$limit_time.'||'.date("H:i d-m-Y");
				_saveVip($txt);
				die(json_encode($return));
			}
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Không Đủ Số Dư Để Thực Hiện Mua VIP. Vui Lòng Nạp Thêm';
			die(json_encode($return));
		}
	}
	if ($t === 'sign-up') {
		$fullname = _p($_POST['fullname']);
		$username = _p($_POST['username']);
		if(!preg_match('/^[A-Za-z0-9_\.]{6,32}$/' ,$username, $matchs)){
			$return['error'] = 1;
			$return['msg']   = 'Tài Khoản Bạn Nhập Không Đúng Định Dạng';
			die(json_encode($return));
		}
        $email = _p($_POST['email']);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        	$return['error'] = 1;
			$return['msg']   = 'Email Bạn Nhập Không  Đúng Định Dạng';
			die(json_encode($return));
        }
        $password = _p($_POST['password']);
        /*$greCaptcha = _p($_POST['greCaptcha']);
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        	$remoteip = $_SERVER['HTTP_CLIENT_IP'];
	    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	        $remoteip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    } else {
	        $remoteip = $_SERVER['REMOTE_ADDR'];
	    }
        $api_url = $config_gC['api_url'];
		$site_key = $config_gC['site_key'];
		$secret_key = $config_gC['secret_key'];
		$api_url = $api_url . '?secret=' . $secret_key . '&response=' . $greCaptcha . '&remoteip=' . $_SERVER['REMOTE_ADDR'];;
		$response = json_decode(file_get_contents($api_url));*/
		//if (!isset($response->success)) {
		if (false){
			$return['error'] = 1;
			$return['msg']   = 'Đã Xãy Ra Lỗi Xác Nhận reCaptcha';
			die(json_encode($return));
		} else {
			if (!checkUser($username)) {
				$creat = creatUser($fullname, $username, $password, $email);
				if ($creat) {
					$return['msg'] = 'Chúc Mừng Bạn Đã Đăng Ký Thành Công, Bây Giờ Vui Lòng Quay Lại Để Đăng Nhập.';
					die(json_encode($return));
				}
			} else {
				$return['error'] = 1;
				$return['msg']   = 'Tên Tài Khoản Đã Tồn Tại';
				die(json_encode($return));
			}
		}
	}
	if($t === 'sign-in') {
		$username = _p($_POST['username']);
		if(!preg_match('/^[A-Za-z0-9_\.]{6,32}$/' ,$username, $matchs)){
			$return['error'] = 1;
			$return['msg']   = 'Tài Khoản Bạn Nhập Không Đúng Định Dạng';
			die(json_encode($return));
		}
		$password = _p($_POST['password']);
		if (!checkUser($username)) {
			$return['error'] = 1;
			$return['msg']   = 'Người Dùng Không Tồn Tại';
			die(json_encode($return));
		} else {
			$user = getUserbyName($username);
			if ($user['block'] == 'checked') {
				$return['error'] = 1;
				$return['msg']   = 'Tài Khoản Của Bạn Đang Tạm Khóa';
				die(json_encode($return));
			}
			if ($user['pass'] === $password) {
				setSession($user, $config_site['admin']);
				$return['msg'] = 'Đăng Nhập Thành Công. Vui Lòng Chờ Chuyển Hướng';
				die(json_encode($return));
			} else {
				$return['error'] = 1;
				$return['msg']   = 'Mật Khẩu Bạn Nhập Không Đúng Cho Người Dùng Này';
				die(json_encode($return));
			}
		}
	}
	if ($t === 'load-vip-like') {
		$vip = get_vip_like($_SESSION['username']);
		$data = array();
		$long = count($vip);
		if ($vip !== 0) {
			for ($i=0; $i < $long; $i++) {
				$data[] = array(
					$vip[$i]['id'],
					$vip[$i]['fbid'],
					$vip[$i]['name'],
					$vip[$i]['name_package'],
					$vip[$i]['camxuc'],
					date('H:i d/m/Y', $vip[$i]['time_buy']+($vip[$i]['limit_time']*30*86400)),
					$vip[$i]['speed'],
					$vip[$i]['sex'],
					'<div class="switch">
                        <label>
	                        <input type="checkbox" class="btnActionModuleItem" '.$vip[$i]['action'].' value="'.$vip[$i]['id'].'">
	                        <span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>'
				);
			}
			$return = array('data' => $data);
			die(json_encode($return));
		}
	}
	if ($t === 'action-vip-like') {
		$checked = _p($_POST['checked']);
		$value = _p($_POST['value']);
		if (action_vip_like($checked, $value)) {
			if ($checked == 'checked') {
				$return['msg'] = 'Đã Kích Hoạt Trở Lại VIP LIKE Cho Người Dùng Này';
			} else {
				$return['error'] = 1;
				$return['msg'] = 'Đã Tạm Dừng VIP LIKE Cho Người Dùng Này';
			}
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Đã Xảy Ra Lỗi';
			die(json_encode($return));
		}
	}
	if ($t === 'action-vip-bot') {
		$checked = _p($_POST['checked']);
		$value = _p($_POST['value']);
		if (action_vip_bot($checked, $value)) {
			if ($checked == 'checked') {
				$return['msg'] = 'Đã Kích Hoạt Trở Lại VIP BOT Cho Người Dùng Này';
			} else {
				$return['error'] = 1;
				$return['msg'] = 'Đã Tạm Dừng VIP BOT Cho Người Dùng Này';
			}
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Đã Xảy Ra Lỗi';
			die(json_encode($return));
		}
	}
	if ($t === 'get-name-by-cookie') {
		$cookie = _p($_POST['cookie']);
		$data = __c('https://mbasic.facebook.com/profile.php', $cookie);
		if(preg_match('#<title>(.+?)</title>#is',$data, $match)){
	    	$nameUser = $match[1];
	    }
	    if(preg_match('#name="fb_dtsg" value="(.+?)"#is',$data, $match)){
	    	$fb_dtsg = $match[1];
	    }
	    if(preg_match('#name="target" value="(.+?)"#is',$data, $match)){
	    	$idUser = $match[1];
	    } else {
	    	$return['error'] = 1;
			$return['msg']   = 'Mã Access Cookie Không Hợp Lệ';
			die(json_encode($return));
	    }
		$return['name'] = $nameUser;
		$return['id'] = $idUser;
		$return['fb_dtsg'] = $fb_dtsg;
		die(json_encode($return));
	}
	if ($t === 'buy-vip-bot') {
		$id = _p($_POST['id']);
		if(!preg_match('/[0-9]/' ,$id, $matchs)){
			$return['error'] = 1;
			$return['msg']   = 'ID FB Bạn Nhập Không Đúng Định Dạng';
			die(json_encode($return));
		}
        $name = _p($_POST['name']);
        $access = _p($_POST['access']);
        $fb_dtsg = _p($_POST['fb_dtsg']);
        $limit_time = _p($_POST['limit_time']);
        $reaction = _p($_POST['reaction']);
        if($limit_time < 1 || $limit_time > 6){
			$return['error'] = 1;
			$return['msg']   = 'Phát Hiện Hành Vi Cheat Hệ Thống. Tài Khoản Sẽ Có Thể Bị Khóa';
			die(json_encode($return));
		}
		$package = get_package_vip_bot();
        $user = getUser($_SESSION['id']);
		$price = $package['vnd']*$limit_time;
		if ($user['vnd'] >= $price) {
			$truVND = updateVNDUser($user['vnd'] - $price);
			$txt = 'Vip Bot||'.$_SESSION['username'].'||'.$id.'||'.$name.'||'.$package['name'].'||'.$limit_time.'||'.date("H:i d-m-Y");
			_saveVip($txt);
			if ($fb_dtsg) {
	        	if (insert_vip_bot_cookie($id, $name, $_SESSION['username'], $reaction ,$access, $limit_time, $fb_dtsg)) {
					$return['msg'] = 'Cài VIP BOT Thành Công';
					die(json_encode($return));
	        	}
	        } else {
	        	if (insert_vip_bot_token($id, $name, $_SESSION['username'], $reaction ,$access, $limit_time)) {
					$return['msg'] = 'Cài VIP BOT Thành Công';
					die(json_encode($return));
	        	}
	        }
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Không Đủ Số Dư Để Thực Hiện Mua VIP. Vui Lòng Nạp Thêm';
			die(json_encode($return));
		}
	}
	if ($t === 'load-vip-bot') {
		$vip = get_vip_bot($_SESSION['username']);
		$data = array();
		$long = count($vip);
		if ($vip !== 0) {
			for ($i=0; $i < $long; $i++) {
				if ($vip[$i]['type_access'] == 'ACCESS_TOKEN') {
					if (_checkToken($vip[$i]['access_token'])) {
						$live_die = '<font color="green">LIVE</font>';
					} else {
						$live_die = '<font color="red">DIE</font>';
					}
				} else {
					$live_die = '<font color="red">Ko Thể K.Tra</font>';
				}
				$data[] = array(
					$vip[$i]['id'],
					'<img src="https://graph.facebook.com/'.$vip[$i]['fbid'].'/picture?width=30&height=30" /><a target="_blank" href="https://fb.com/'.$vip[$i]['fbid'].'"> '.$vip[$i]['fbname'].'</a>',
					$vip[$i]['type_react'],
					$vip[$i]['type_access'],
					date('H:i d/m/Y', $vip[$i]['time_buy']+($vip[$i]['limit_time']*30*86400)),
					'<div class="switch">
                        <label>
	                        <input type="checkbox" class="btnActionModuleItem" '.$vip[$i]['action'].' value="'.$vip[$i]['id'].'">
	                        <span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>',
                    $live_die
				);
			}
			$return = array('data' => $data);
			die(json_encode($return));
		}
	}
	if($t === 'update-vip-bot'){
		$id = _p($_POST['id']);
		$access = _p($_POST['access']);
        $type_access = _p($_POST['type_access']);
        $type_react = _p($_POST['type_react']);
        $fb_dtsg = _p($_POST['fb_dtsg']);
        if (update_vip_bot($id, $access, $type_access, $type_react, $fb_dtsg)) {
        	$return['msg'] = 'Cập Nhật Thành Công';
			die(json_encode($return));
        }
	}
	if ($t === 'edit-package-bot') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$name = _p($_POST['name']);
		$vnd = _p($_POST['vnd']);
		if (edit_package_vip_bot($name, $vnd)) {
			$return['msg'] = 'Chỉnh Sửa Thành Công';
			die(json_encode($return));
		}
	}
	if($t === 'create-gift'){
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$number = _p($_POST['number']);
		$vnd = _p($_POST['vnd']);
		$gift = array();
		for ($i=0; $i < $number ; $i++) {
			$creat = create_gift($vnd);
			if ($creat) {
				$gift[] = $creat;
			}
		}
		if (count($gift) > 0) {
			die(json_encode($gift));
		}
	}
	if ($t === 'load-gift-code') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$gift = get_gift_code();
		$data = array();
		$long = count($gift);
		for ($i=0; $i < $long; $i++) {
			$data[] = array(
				$gift[$i]['id'],
				$gift[$i]['gift'],
				number_format($gift[$i]['vnd']). 'Cash',
				date('H:i d/m/Y', $gift[$i]['time']+(10*24*60*60)),
			);
		}
		$return = array('data' => $data);
		die(json_encode($return));
	}
	if ($t === 'gift') {
		$gift = _p($_POST['gift']);
		$vnd = gift($gift);
		if ($vnd) {
			$return['msg'] = 'Bạn Đã Nhận Được '.number_format($vnd).' Cash từ mã gift '.$gift;
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Mã Gift Không Tồn Tại Hoặc Đã Được Sử Dụng.';
			die(json_encode($return));
		}
	}
	if($t === 'buy-vip-cmt'){
		$fbid = _p($_POST['id']);
		if(!preg_match('/[0-9]/' ,$fbid, $matchs)){
			$return['error'] = 1;
			$return['msg']   = 'ID FB Bạn Nhập Không Đúng Định Dạng';
			die(json_encode($return));
		}
		$name = _p($_POST['user']);
		$name_package = _p($_POST['package']);
		$speed = _p($_POST['speed']);
		$limit_time = _p($_POST['time']);
		$cmt = _p($_POST['cmt']);
		$sex = _p($_POST['sex']);
		$package = getPackage_cmt($name_package);
		if($limit_time < 1 || $limit_time > 6 || $speed < 5 || $speed > 100 || !$package['name']){
			$return['error'] = 1;
			$return['msg']   = 'Phát Hiện Hành Vi Cheat Hệ Thống. Tài Khoản Sẽ Có Thể Bị Khóa';
			die(json_encode($return));
		}
		$user = getUser($_SESSION['id']);
		$price = $package['price']*$limit_time;
		if ($user['vnd'] >= $price) {
			$truVND = updateVNDUser($user['vnd'] - $price);
			if (insert_vip_cmt($fbid, $name, $_SESSION['username'], $name_package, $limit_time, time(), $speed, $cmt, $sex) && $truVND) {
				$return['msg'] = 'Mua VIP Thành Công Cho Người Dùng '.$name.' ('.$fbid.')';
				$txt = 'Vip Comment||'.$_SESSION['username'].'||'.$fbid.'||'.$name.'||'.$name_package.'||'.$limit_time.'||'.date("H:i d-m-Y");
				_saveVip($txt);
				die(json_encode($return));
			}
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Không Đủ Số Dư Để Thực Hiện Mua VIP. Vui Lòng Nạp Thêm';
			die(json_encode($return));
		}
	}
	if ($t === 'load-vip-cmt') {
		$vip = get_vip_cmt($_SESSION['username']);
		$data = array();
		$long = count($vip);
		if ($vip !== 0) {
			for ($i=0; $i < $long; $i++) {
				//$cmt = str_replace("\n", "<br>----<br>", $vip[$i]['cmt']);
				$data[] = array(
					$vip[$i]['id'],
					$vip[$i]['fbid'],
					$vip[$i]['name'],
					$vip[$i]['name_package'].' Comment',
					date('H:i d/m/Y', $vip[$i]['time_buy']+($vip[$i]['limit_time']*30*86400)),
					$vip[$i]['speed'],
					$vip[$i]['sex'],
					'<div class="switch">
                        <label>
	                        <input type="checkbox" class="btnActionModuleItem" '.$vip[$i]['action'].' value="'.$vip[$i]['id'].'">
	                        <span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>',
                    '<textarea disabled class="form-control" rows="3">'.$vip[$i]['cmt'].'</textarea>'
				);
			}
			$return = array('data' => $data);
			die(json_encode($return));
		}
	}
	if ($t === 'action-vip-cmt') {
		$checked = _p($_POST['checked']);
		$value = _p($_POST['value']);
		if (action_vip_cmt($checked, $value)) {
			if ($checked == 'checked') {
				$return['msg'] = 'Đã Kích Hoạt Trở Lại VIP Comment Cho Người Dùng Này';
			} else {
				$return['error'] = 1;
				$return['msg'] = 'Đã Tạm Dừng VIP Comment Cho Người Dùng Này';
			}
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Đã Xảy Ra Lỗi';
			die(json_encode($return));
		}
	}
	if($t === 'notify'){
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$notify = _p($_POST['notify']);
		_saveNotify($notify.'||'.date("H:i d/m/Y")."\n");
		$return['msg'] = 'Đã Tạo Thông Báo Thành Công';
		die(json_encode($return));
	}
	if($t === 'change-pass'){
		$old = _p($_POST['old_pass']);
		$new = _p($_POST['new_pass']);
		$user = getUser($_SESSION['id']);
		if ($user['pass'] !== $old) {
			$return['error'] = 1;
			$return['msg']   = 'Mật Khẩu Cũ Không Chính Xác';
			die(json_encode($return));
		}
		if (updatePassUser($new)) {
			$return['msg']   = 'Mật Khẩu Của Bạn Đã Được Đổi Thành Công';
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Không Thể Đổi Mật Khẩu';
			die(json_encode($return));
		}
	}
	if ($t === 'add-token') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$arrToken = $_POST['arr_access'];
		$arrID = $_POST['arr_id'];
		$arrGender = $_POST['arr_gender'];
		if(count($arrToken) == 0){
			$return['error'] = 1;
			$return['msg']   = 'Bạn Không Có Token Mới Nào';
			die(json_encode($return));
		}
		if(addMultiToken($arrToken, $arrID, $arrGender)){
			$return['msg']   = 'Đã Thêm Thành Công '.count($arrToken).' Access Token Vào CSDL';
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Đã Xảy Ra Lỗi';
			die(json_encode($return));
		}
		/*$return['error'] = 1;
		$return['msg'] = addMultiToken($arrToken, $arrID, $arrGender);
		die(json_encode($return));*/


	}
	if($t === 'load-log-vip-like'){
		$idUser = $_GET['idUser'];
		$data = file_get_contents('../crons/vipLike.log.txt');
		$data = explode("\n", $data);
		$json = array();
		for($i=count($data)-2; $i >= 0; $i--){
			$value = explode("||", $data[$i]);
			if ($value[0] === $_SESSION['username'] && $idUser === $value[1]) {
				$json[] = array(
					$value[1],
					'<img src="https://graph.facebook.com/' . $value[1] . '/picture?width=30&height=30" /> <a target="_blank" href="https://fb.com/' . $value[1] . '"> ' . $value[2] . '</a>',
					$value[3],
					$value[4],
					$value[5]
				);
			}
		}
		$response = array();
		$response['data'] = $json;
		echo json_encode($response);
	}
	if($t === 'load-log-vip-cmt'){
		$idUser = $_GET['idUser'];
		$data = file_get_contents('../crons/vipCmt.log.txt');
		$data = explode("\n", $data);
		$json = array();
		for($i=count($data)-2; $i >= 0; $i--){
			$value = explode("||", $data[$i]);
			if ($value[0] === $_SESSION['username'] && $idUser === $value[1]) {
				$json[] = array(
					$value[1],
					'<img src="https://graph.facebook.com/' . $value[1] . '/picture?width=30&height=30" /> <a target="_blank" href="https://fb.com/' . $value[1] . '"> ' . $value[2] . '</a>',
					$value[3],
					$value[4],
					$value[5]
				);
			}
		}
		$response = array();
		$response['data'] = $json;
		echo json_encode($response);
	}
	if($t === 'load-log-vip-bot'){
		$idUser = $_GET['idUser'];
		$data = file_get_contents('../crons/vipBot.log.txt');
		$data = explode("\n", $data);
		$json = array();
		for($i=count($data)-2; $i >= 0; $i--){
			$value = explode("||", $data[$i]);
			if ($value[0] === $_SESSION['username'] && $idUser === $value[1]) {
				if ($value[5] === 'Cookie Post') {
					$a = '<img src="https://www.fordservicepricepromise.com/img/ford_lodding.gif" width = "30" height="30" /> <a target="_blank" href="https://fb.com/"> ' . $value[6] . '</a>';
				} else {
					$a = '<img src="https://graph.facebook.com/' . $value[5] . '/picture?width=30&height=30" /> <a target="_blank" href="https://fb.com/' . $value[5] . '"> ' . $value[6] . '</a>';
				}
				$json[] = array(
					$value[1],
					'<img src="https://graph.facebook.com/' . $value[1] . '/picture?width=30&height=30" /> <a target="_blank" href="https://fb.com/' . $value[1] . '"> ' . $value[2] . '</a>',
					$value[3],
					$value[4],
					$a,
					$value[7]
				);
			}
		}
		$response = array();
		$response['data'] = $json;
		echo json_encode($response);
	}
	if ($t === 'nap-the-baokim') {
		define('CORE_API_HTTP_USR', 'merchant_19002');
		define('CORE_API_HTTP_PWD', '19002mQ2L8ifR11axUuCN9PMqJrlAHFS04o');
		$bk = 'https://www.baokim.vn/the-cao/restFul/send';
		$nhamang = _p($_POST['nhamang']);
		$mathe = _p($_POST['mathe']);
		$seri = _p($_POST['seri']);
		if($nhamang=='MOBI'){
			$ten = "Mobifone";
		}
		else if($nhamang=='VIETEL'){
			$ten = "Viettel";
		}
		else if($nhamang=='GATE'){
			$ten = "Gate";
		} else if($nhamang=='VTC'){
			$ten = "VTC";
		} else {
			$ten ="Vinaphone";
		}
		$merchant_id = $config_BK['merchant_id'];
		$api_username = $config_BK['api_username'];
		$api_password = $config_BK['api_password'];
		$transaction_id = time();
		$secure_code = $config_BK['secure_code'];
		$arrayPost = array(
			'merchant_id'=>$merchant_id,
			'api_username'=>$api_username,
			'api_password'=>$api_password,
			'transaction_id'=>$transaction_id,
			'card_id'=>$nhamang,
			'pin_field'=>$mathe,
			'seri_field'=>$seri,
			'algo_mode'=>'hmac'
		);
		ksort($arrayPost);
		$data_sign = hash_hmac('SHA1',implode('',$arrayPost),$secure_code);
		$arrayPost['data_sign'] = $data_sign;
		$curl = curl_init($bk);
		curl_setopt_array($curl, array(
			CURLOPT_POST=>true,
			CURLOPT_HEADER=>false,
			CURLINFO_HEADER_OUT=>true,
			CURLOPT_TIMEOUT=>30,
			CURLOPT_RETURNTRANSFER=>true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_HTTPAUTH=>CURLAUTH_DIGEST|CURLAUTH_BASIC,
			CURLOPT_USERPWD=>CORE_API_HTTP_USR.':'.CORE_API_HTTP_PWD,
			CURLOPT_POSTFIELDS=>http_build_query($arrayPost)
		));
		$data = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$result = json_decode($data,true);
		if($status==200){
		    $amount = $result['amount'];
		    $xu = 0;
			switch($amount) {
				case 10000: $xu = 10000; break;
				case 20000: $xu = 20000; break;
				case 30000: $xu = 30000; break;
				case 50000: $xu= 50000; break;
				case 100000: $xu = 100000; break;
				case 200000: $xu = 200000; break;
				case 300000: $xu = 300000; break;
				case 500000: $xu = 500000; break;
				case 1000000: $xu = 1000000; break;
			}
			$user = getUser($_SESSION['id']);
			$vnd = updateVNDUser($user['vnd']+$xu);
			$txt = 'true||'.$_SESSION['username'].'||'.$ten.'||'.$amount.'||'.$mathe.'||'.$seri.'||'.date("H:i d-m-Y").'||Nạp thẻ thành công!';
			$return['msg']   = 'Nạp Thành Công Thẻ: '.$ten.' Với Mệnh Giá: '.$amount;
			die(json_encode($return));
		} else {
			$error = $result['errorMessage'];
			$txt = 'false||'.$_SESSION['username'].'||'.$ten.'||0||'.$mathe.'||'.$seri.'||'.date("H:i d-m-Y").'||'.$error;
			$return['error'] = 1;
			$return['msg']   = 'Đã Xảy Ra Lỗi';
			die(json_encode($return));
		}
		_saveCard($txt);
	}
	if ($t === 'nap-the-banthe247') {
		$nhamang = _p($_POST['nhamang']);
		$mathe = _p($_POST['mathe']);
		$seri = _p($_POST['seri']);
		if($nhamang=='VMS'){
			$ten = "Mobifone";
		}else if($nhamang=='VTT'){
			$ten = "Viettel";
		}else if($nhamang=='FPT'){
			$ten = "Gate";
		} else if($nhamang=='VNP'){
			$ten = "Vinaphone";
		}else if($nhamang=='VNM'){
			$ten = "Vietnammobile";
		}else if($nhamang=='MGC'){
			$ten = "Megacard";
		} else if($nhamang == 'ONC') {
			$ten ="OnCash";
		}
		$transid = rand().'_'.$config_BanThe247['partnerId'];
		$sig = md5($config_BanThe247['partnerId'].'-'.$config_BanThe247['secreckey'].'-'.$nhamang.'-'.$seri.'-'.$mathe.'-'.$transid);
		$url = 'http://api.banthe247.com/CardCharge.ashx';
		$url .= '?partnerId='.$config_BanThe247['partnerId'];
		$url .= '&telco='.$nhamang;
		$url .= '&serial='.$seri;
		$url .= '&cardcode='.$mathe;
		$url .= '&transId='.$transid;
		$url .= '&key='.$sig;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
		$str = curl_exec($curl);
		curl_close($curl);
		$result = json_decode($str,true);
		if($result['ResCode']==1){
		    $amount = $result['Amount'];
		    $xu = $amount*1000;
			$user = getUser($_SESSION['id']);
			$vnd = updateVNDUser($user['vnd']+$xu);
			$txt = 'true||'.$_SESSION['username'].'||'.$ten.'||'.$amount.'||'.$mathe.'||'.$seri.'||'.date("H:i d-m-Y").'||Nạp thẻ thành công!';
			$return['msg']   = 'Nạp Thành Công Thẻ: '.$ten.' Với Mệnh Giá: '.$amount;
		} else {
			$error = $result['Message'];
			$txt = 'false||'.$_SESSION['username'].'||'.$ten.'||0||'.$mathe.'||'.$seri.'||'.date("H:i d-m-Y").'||'.$error;
			$return['error'] = 1;
			$return['msg']   = 'Đã Xảy Ra Lỗi';
		}
		_saveCard($txt);
		die(json_encode($return));
	}
	if ($t === 'set-vnd') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$username = _p($_POST['user']);
		$vnd = _p($_POST['vnd']);
		$user = getUserbyName($username);
		if ($user['user']) {
			updateVNDUser($vnd+$user['vnd'], 1, $user['id']);
			$return['msg']   = 'Đã Cộng Thành Công '.$vnd.' Cash Cho: '.$username.'('.$user['fullname'].')';
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Không Tìm Thấy Người Dùng';
			die(json_encode($return));
		}
	}
	if ($t === 'load-ls-nap-tien') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$src = file_get_contents('card.log.txt');
		$arr_src = explode("\n", $src);
		$data = array();
		for ($i=count($arr_src)-2; $i >= 0; $i--) {
		    $value = explode("||", $arr_src[$i]);
		    $ch = 'Thành công';
		    if($value[0] == 'false') $ch = 'Thất bại';
		    $data[] = array(
		    	$ch,
		    	$value[1],
		    	$value[2],
		    	number_format($value[3]),
		    	$value[4],
		    	$value[5],
		    	$value[6],
		    	$value[7]
		    );
		}
		$return = array('data' => $data);
		die(json_encode($return));
	}
	if ($t === 'load-mua-vip') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$src = file_get_contents('buyvip.log.txt');
		$arr_src = explode("\n", $src);
		$data = array();
		for ($i=count($arr_src)-2; $i >= 0; $i--) {
		    $value = explode("||", $arr_src[$i]);
		    $data[] = array(
		    	$value[0],
		    	$value[1],
		    	$value[2],
		    	$value[3],
		    	$value[4],
		    	$value[5].' Tháng',
		    	$value[6]
		    );
		}
		$return = array('data' => $data);
		die(json_encode($return));
	}
	if ($t === 'get-token') {
		$typeget = _p($_POST['typeget']);
		/*if($typeget == "access_token"){
			$getToken = getTokenToServer('access_token');
		}
		if($typeget == 'gender'){
			$getToken = getTokenToServer('gender');
		}
		else {*/
			$getToken = getTokenToServer('access_token');
			//$getToken = getTokenToServer('fbid');
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		die(json_encode($getToken));
	}
	if ($t === 'del-token') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$tokenDIE = $_POST['token_die'];
		if(count($tokenDIE) == 0){
			$return['msg']   = 'Bạn Không Có Token DIE Nào';
			die(json_encode($return));
		}
		if(delMultiToken($tokenDIE)){
			$return['msg']   = 'Đã Xóa Thành Công '.count($tokenDIE).' Access Token DIE';
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Đã Xảy Ra Lỗi';
			die(json_encode($return));
		}
	}
	if ($t === 'load-manage-vip-like-admin') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$vip = get_vip_like('admin');
		$data = array();
		$long = count($vip);
		if ($vip !== 0) {
			for ($i=0; $i < $long; $i++) {
				$data[] = array(
					$vip[$i]['id'],
					$vip[$i]['fbid'],
					$vip[$i]['name'],
					$vip[$i]['name_package'],
					$vip[$i]['camxuc'],
					date('H:i d/m/Y', $vip[$i]['time_buy']+($vip[$i]['limit_time']*30*86400)),
					$vip[$i]['speed'],
					$vip[$i]['sex'],
					'<div class="switch">
                        <label>
	                        <input type="checkbox" class="btnActionModuleItem" '.$vip[$i]['action'].' value="'.$vip[$i]['id'].'">
	                        <span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>'
				);
			}
			$return = array('data' => $data);
			die(json_encode($return));
		}
	}
	if ($t === 'update-vip-like-admin') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$id  = _p($_POST['id']);
		$fbid = _p($_POST['fbid']);
		$name = _p($_POST['name']);
		$package = _p($_POST['package']);
		$speed = _p($_POST['speed']);
		$camxuc = _p($_POST['camxuc']);
		$sex = _p($_POST['sex']);
		$update = updateVipLikeByAdmin($id, $fbid, $name, $package, $speed, $camxuc, $sex);
		if ($update) {
			$return['msg'] = "Chỉnh Sửa Thành Công";
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg'] = "Không Thể Chỉnh Sửa";
			die(json_encode($return));
		}
	}
	if ($t === 'update-vip-like') {
		$id  = _p($_POST['id']);
		$fbid = _p($_POST['fbid']);
		$speed = _p($_POST['speed']);
		$name = _p($_POST['name']);
		$camxuc = _p($_POST['camxuc']);
		$sex = _p($_POST['sex']);
		$update = updateVipLikeByUser($id, $fbid, $name, $speed, $camxuc, $sex);
		if ($update) {
			$return['msg'] = "Chỉnh Sửa Thành Công";
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg'] = "Không Thể Chỉnh Sửa";
			die(json_encode($return));
		}
	}
	if ($t === 'update-vip-cmt') {
		$id  = _p($_POST['id']);
		$cmt = _p($_POST['cmt']);
		$fbid  = _p($_POST['fbid']);
		$name = _p($_POST['name']);
		$sex = _p($_POST['sex']);
		$speed = _p($_POST['speed']);
		$update = updateVipCmt($id, $cmt, $fbid, $name, $sex, $speed);
		if ($update) {
			$return['msg'] = "Chỉnh Sửa Thành Công";
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg'] = "Không Thể Chỉnh Sửa";
			die(json_encode($return));
		}
	}
	if ($t === 'load-manage-vip-cmt-admin') {
		$vip = get_vip_cmt('admin');
		$data = array();
		$long = count($vip);
		if ($vip !== 0) {
			for ($i=0; $i < $long; $i++) {
				//$cmt = str_replace("\n", "<br>----<br>", $vip[$i]['cmt']);
				$data[] = array(
					$vip[$i]['id'],
					$vip[$i]['fbid'],
					$vip[$i]['name'],
					$vip[$i]['name_package'].' Comment',
					date('H:i d/m/Y', $vip[$i]['time_buy']+($vip[$i]['limit_time']*30*86400)),
					$vip[$i]['speed'],
					$vip[$i]['sex'],
					'<div class="switch">
                        <label>
	                        <input type="checkbox" class="btnActionModuleItem" '.$vip[$i]['action'].' value="'.$vip[$i]['id'].'">
	                        <span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>',
                    '<textarea disabled class="form-control" rows="3">'.$vip[$i]['cmt'].'</textarea>'
				);
			}
			$return = array('data' => $data);
			die(json_encode($return));
		}
	}
	if ($t === 'update-vip-cmt-admin') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$id  = _p($_POST['id']);
		$fbid = _p($_POST['fbid']);
		$name = _p($_POST['name']);
		$speed = _p($_POST['speed']);
		$cmt = _p($_POST['cmt']);
		$package = _p($_POST['package']);
		$update = updateVipCmtByAdmin($id, $fbid, $name, $package, $cmt, $speed);
		if ($update) {
			$return['msg'] = "Chỉnh Sửa Thành Công";
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg'] = "Không Thể Chỉnh Sửa";
			die(json_encode($return));
		}
	}
	if ($t === 'delete-vip') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$id = _p($_POST['id']);
		$type= _p($_POST['type']);
		if (delete_vip($id,$type)) {
			$return['msg'] = 'Xóa Thành Công!';
			die(json_encode($return));
		}
	}
	if ($t === 'load-vip-bot-admin') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$vip = get_vip_bot('admin');
		$data = array();
		$long = count($vip);
		if ($vip !== 0) {
			for ($i=0; $i < $long; $i++) {
				if ($vip[$i]['type_access'] == 'ACCESS_TOKEN') {
					if (_checkToken($vip[$i]['access_token'])) {
						$live_die = '<font color="green">LIVE</font>';
					} else {
						$live_die = '<font color="red">DIE</font>';
					}
				} else {
					$live_die = '<font color="red">Ko Thể K.Tra</font>';
				}
				$data[] = array(
					$vip[$i]['id'],
					'<img src="https://graph.facebook.com/'.$vip[$i]['fbid'].'/picture?width=30&height=30" /><a target="_blank" href="https://fb.com/'.$vip[$i]['fbid'].'"> '.$vip[$i]['fbname'].'</a>',
					$vip[$i]['type_react'],
					$vip[$i]['type_access'],
					date('H:i d/m/Y', $vip[$i]['time_buy']+($vip[$i]['limit_time']*30*86400)),
					'<div class="switch">
                        <label>
	                        <input type="checkbox" class="btnActionModuleItem" '.$vip[$i]['action'].' value="'.$vip[$i]['id'].'">
	                        <span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>',
                    $live_die
				);
			}
			$return = array('data' => $data);
			die(json_encode($return));
		}
	}
	if ($t === 'load-member') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$mem = get_member();
		$data = array();
		$long = count($mem);
		if ($vip !== 0) {
			for ($i=0; $i < $long; $i++) {
				$data[] = array(
					$mem[$i]['id'],
					$mem[$i]['fullname'],
					$mem[$i]['user'],
					$mem[$i]['email'],
					$mem[$i]['vnd'],
					'<div class="switch">
                        <label>
	                        <input type="checkbox" class="btnActionModuleItem" '.$mem[$i]['block'].' value="'.$mem[$i]['id'].'">
	                        <span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>'
				);
			}
			$return = array('data' => $data);
			die(json_encode($return));
		}
	}
	if ($t === 'action-member') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$checked = _p($_POST['checked']);
		$value = _p($_POST['value']);
		if (action_member($checked, $value)) {
			if ($checked == 'checked') {
				$return['error'] = 1;
				$return['msg'] = 'Tài Khoản Người Dùng Này Đã Bị Tạm Khóa';
			} else {
				$return['msg'] = 'Đã Mở Khóa Cho Tài Khoản Người Dùng Này';
			}
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Đã Xảy Ra Lỗi';
			die(json_encode($return));
		}
	}
	if ($t === 'update-member') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$id  = _p($_POST['id']);
		$fullname = _p($_POST['fullname']);
		$user = _p($_POST['user']);
		$email = _p($_POST['email']);
		$vnd = _p($_POST['vnd']);
		$update = updateMember($id, $fullname, $user, $email, $vnd);
		if ($update) {
			$return['msg'] = "Chỉnh Sửa Thành Công";
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg'] = "Không Thể Chỉnh Sửa";
			die(json_encode($return));
		}
	}
	if ($t === 'buff-like') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$sl = _p($_POST['sl']);
		$getToken = getTokenBySL($sl);
		if ($getToken) {
			$return['msg'] = "GET Token Thành Công";
			$return['access_token'] = $getToken;
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Đã Xãy Ra Lỗi';
			die(json_encode($return));
		}
	}
	if ($t === 'buff-cmt') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Không Được Đâu Sói Ạ.';
			die(json_encode($return));
		}
		$sl = _p($_POST['sl']);
		$sex = _p($_POST['sex']);
		$getToken = getTokenBySL($sl+50);
		$result_token = array();
		if($getToken) {
			foreach ($getToken as $value) {
				$me = _me($value);
				if (count($result_token) == $sl) {
					break;
				}
				if ($me != 0) {
					if ($me->gender == $sex) {
						array_push($result_token, $value);
					}
					if($sex == 'all'){
						array_push($result_token, $value);
					}
				}
			}
			$return['access_token'] = $result_token;
			die(json_encode($return));
		}
	}
}
?>
