<?php
require_once 'modun_function.php';
if($_REQUEST){
	$return = array('error' => 0);
	$t = $_REQUEST['t'];
	if ($t === 'new_package_group') {
		/*if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Bạn không phải admin.';
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
		$data = array();
		$gP = get_package_nhom($_SESSION['id']);
		$long = count($gP);
		$count = 0;
		if ($gP != 0) {
			for ($i=0; $i < $long; $i++) {
				$data[] = array(
					$count +1,
					$gP[$i]['name'],
					$gP[$i]['description'],
					count_target_group($gP[$i]['id']),
					$gP[$i]['create_time'],
					$gP[$i]['id']
				);
				$count ++;
			}
		}
		$return = array('data' => $data);
		die(json_encode($return));
	}
	if ($t === 'delete_package_nhom') {
		/*if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Bạn không phải admin.';
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
			$return['msg']   = 'Bạn không phải admin.';
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
	if ($t === 'get_name_package_nhom') {
		die(json_encode(get_package_nhom($_SESSION['id'])));
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
// LINK FEED
	if ($t === 'add_link_feed') {
		$link = _p($_POST['link']);
		$description = _p($_POST['mota']);
		if (Check_Link_Feed($link, $_SESSION['id']) === 0) {
			if (Insert_Link_Feed($link, $description, $_SESSION['id'])) {
				$return['msg'] = 'Thêm trang '.$link.' vào danh sách theo dõi thành công';
				die(json_encode($return));
			} else {
				$return['error'] = 1;
				$return['msg']   = 'Không Thể Thêm trang này. Vui Lòng Kiểm Tra Lại';
				die(json_encode($return));
			}
		} else {
			$return['error'] = 1;
			$return['msg']   = 'Trang này đã có trong hệ thống';
			die(json_encode($return));
		}
	}
	if($t === 'get_link_feed') {
		$data = array();
		$gP = Get_Link_Feed($_SESSION['id']);
		$long = count($gP);
		$count =0;
		if ($gP != 0) {
			for ($i=0; $i < $long; $i++) {
				$data[] = array(
					$count+1,
					$gP[$i]['link'],
					$gP[$i]['description'],
					$gP[$i]['create_time'],
					$gP[$i]['id']
				);
				$count++;
			}
		}
		$return = array('data' => $data);
		die(json_encode($return));
	}
	if ($t === 'update_link_feed') {
		$id = _p($_POST['id']);
		$link = _p($_POST['link']);
		$description = _p($_POST['mota']);
		$update = Update_Link_Feed($link, $description,$id);
		if ($update) {
			$return['msg'] = "Chỉnh Sửa Thành Công";
			die(json_encode($return));
		} else {
			$return['error'] = 1;
			$return['msg'] = "Không Thể Chỉnh Sửa";
			die(json_encode($return));
		}
	}
	if ($t === 'delete_link_feed') {
		$id = _p($_POST['id']);
		if (Delete_Link_Feed($id)) {
			$return['msg'] = 'Xóa Thành Công!';
			die(json_encode($return));
		}
	}
// Manager Target
	if ($t === 'update-target') {
		$id  = _p($_POST['id']);
		$nhom = _p($_POST['nhom']);
		$old_name = _p($_POST['old_name']);
		$group_id_old = get_id_nhom($old_name, $_SESSION['id']);
		$update = updateTarget($id, $nhom, $group_id_old, $_SESSION['id']);
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
		$stt = 0;
		if ($vip !== 0) {
			for ($i=0; $i < $long; $i++) {
				$id_target= $vip[$i]['id'];
				$name_group =  get_name_group_by_target_id($id_target, $_SESSION['id']);
				for($j = 0; $j < count($name_group); $j++){
                    $data[] = array(
						$stt +1,
                        $vip[$i]['fbid'],
                        $vip[$i]['name'],
                        $name_group[$j]['name'],
						$vip[$i]['id'],
                    );
					$stt ++;
				}

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
		$posts = getPostByGroup($tennhom,$user_id,$datefrom,$dateto);
		$sopost = 0;
		$data = array();
		//detele_search_keyword_result($user_id);
		while($row = mysqli_fetch_assoc($posts)){
			$noidung = $row['name'];
			if (preg_match(strtolower($keyword), strtolower($noidung), $match)) :
				$data[] = array(
					$sopost+1,
					$row['id_post'],
					$row['name'],
					$row['time_post'],
					$row['luot_thich'].','.$row['luot_comment'].','.$row['luot_share'],
				);
				//insert_post_to_search_post_keyword($noidung,$post_id,$time_post,$like,$comment, $share, $target_id, $user_id);
				$sopost++;
				endif;
		}
		$return = array('data' => $data);
		die(json_encode($return));
		/*if ($sopost > 0) {
				$return['msg'] = 'Nhóm '.$tennhom.' có '.$sopost.' liên quan đến từ khóa: '.$keyword_goc;
				die(json_encode($return));
			} else {
				$return['error'] = 1;
				$return['msg']   = 'Không có bài viết nào liên quan';
				//$return['msg']   = strtotime($datefrom);
				die(json_encode($return));
			}*/
	}
	if ($t === 'load-post-keyword') {
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
	if ($t === 'load-post') {
		$vip = load_post($_SESSION['id']);
		$data = array();
		$long = count($vip);
		$dong =0;
		if ($vip !== 0) {
			/*if($long >500)
			{
				for($i=$long-1; $i>$long -100; $i--){
					$name_target= getNameTarget($vip[$i]['target_id']);
					$data[] = array(
						$dong+1,
						$name_target,
						str_replace("\n","<br>",$vip[$i]['name']),
						$vip[$i]['time_post'],
						$vip[$i]['luot_thich'].','.$vip[$i]['luot_comment'].','.$vip[$i]['luot_share'],
					);
					$dong++;
				}
			}
			else{*/
				for($i=$long-1; $i>0; $i--){
                    $group = get_name_group_by_target_id($vip[$i]['target_id'], $_SESSION['id']);
                    for($j = 0; $j < count($group); $j++) {
                        $name_target = getNameTarget($vip[$i]['target_id']);

                        //$link = "https://www.facebook.com/" . $vip[$i]['id_post'];
                        $content = str_replace("\n", "<br>", $vip[$i]['name']);
                        $data[] = array(
                            /*$dong+1,*/
                            $name_target,
                            $content,
                            $vip[$i]['time_post'],
                            '<font color="blue">'. $vip[$i]['luot_thich'] .'</font>' . ':' . '<font color="green">'. $vip[$i]['luot_comment'] .'</font>' . ':' . '<font color="red">'. $vip[$i]['luot_share'] .'</font>',
                            $group[$j]['name'],
                            $vip[$i]['id_post']//'<a href="' . $link . '" target="_blank" title="Click để vào bài viết">' . $link . '</a></br>'
                        );
                        $dong++;
                    }
				}
			//}
			
			$return = array('data' => $data);
			die(json_encode($return));
		}
	}
//VipLike
	if ($t === 'get_name_package') {
		die(json_encode(get_package()));
	}
	if ($t === 'get_name_package_cmt') {
		die(json_encode(get_package_cmt()));
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
					$return['msg'] = 'Chúc Mừng Bạn Đã Đăng Ký Thành Công, Liên hệ với admin để được kích hoạt tài khoản.';
					die(json_encode($return));
				}
			} else {
				$return['error'] = 1;
				$return['msg']   = 'Tên Tài Khoản Đã Tồn Tại';
				die(json_encode($return));
			}
		}
	}
	if ($t === 'add-member'){
		$username = _p($_POST['username']);
		$password = base64_encode(_p($_POST['pass']));

        if (!checkUser($username)) {
            $creat = creatUser($fullname, $username, $password, $email);
            if ($creat) {
                $return['msg'] = 'Thêm tài khoản thành công';
                die(json_encode($return));
            }
        } else {
            $return['error'] = 1;
            $return['msg']   = 'Tên Tài Khoản Đã Tồn Tại';
            die(json_encode($return));
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
		$greCaptcha = _p($_POST['greCaptcha']);
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
		$response = json_decode(file_get_contents($api_url));
		if (!isset($response->success)) {
			$return['error'] = 1;
			$return['msg']   = 'Đã Xãy Ra Lỗi Xác Nhận reCaptcha';
			die(json_encode($return));
		} else {
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
	}
	if($t === 'sign-in-noncaptcha') {
		$username = _p($_POST['username']);
		if(!preg_match('/^[A-Za-z0-9_\.]{6,32}$/' ,$username, $matchs)){
			$return['error'] = 1;
			$return['msg']   = 'Tài Khoản Bạn Nhập Không Đúng Định Dạng';
			die(json_encode($return));
		}
		$password = base64_encode(_p($_POST['password']));
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
	if($t === 'change-pass'){
		$old = base64_encode(_p($_POST['old_pass']));
		$new = base64_encode(_p($_POST['new_pass']));
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
			$return['msg']   = 'Bạn không phải admin.';
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
			$return['msg']   = 'Bạn không phải admin.';
			die(json_encode($return));
		}
		die(json_encode($getToken));
	}
	if ($t === 'del-token') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Bạn không phải admin.';
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
	if ($t === 'delete-target') {
		/*if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Bạn không phải admin.';
			die(json_encode($return));
		}*/
		$id_target = _p($_POST['id_target']);
		$name_group= _p($_POST['name_group']);
		$id_group = get_id_group_by_name($name_group, $_SESSION['id']);
		if (delete_target($id_target, $id_group)) {
			$return['msg'] = 'Xóa Thành Công!';
			die(json_encode($return));
		}
	}
	if ($t === 'load-member') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Bạn không phải admin.';
			die(json_encode($return));
		}
		$mem = get_member();
		$data = array();
		$long = count($mem);
		$count =0;
		if ($vip !== 0) {
			for ($i=0; $i < $long; $i++) {
				$target_member = count_target_member($mem[$i]['id']);
				$group_member = count_group_member($mem[$i]['id']);
				$data[] = array(
					$count +1,
					$mem[$i]['user'],
					$target_member,
					$group_member,
					'<div class="switch">
                        <label>
	                        <input type="checkbox" class="btnActionModuleItem" '.$mem[$i]['block'].' value="'.$mem[$i]['id'].'">
	                        <span class="lever switch-col-light-blue"></span>
                        </label>
                    </div>',
					$mem[$i]['id'],
				);
				$count ++;
			}
			$return = array('data' => $data);
			die(json_encode($return));
		}
	}
	if ($t === 'action-member') {
		if (isAdmin() == 0) {
			$return['error'] = 1;
			$return['msg']   = 'Bạn không phải Admin.';
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
			$return['msg']   = 'Bạn không phải admin.';
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
}
?>
