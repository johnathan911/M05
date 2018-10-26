<?php
require_once '2T_config/config_server.php';
if (!$_SESSION['login']) {
	session_destroy();
	header("Location: sign-in.php");
}
/************************************/
$result = mysqli_query($conn, "SELECT * FROM package_vip_bot LIMIT 1");
if ($result) {
	$package_vip_bot = mysqli_fetch_assoc($result);
}
/************************************/
require_once '2T_tpl/tpl_head.php';
function count_sys($table){
	global $conn;
	$result = mysqli_query($conn, "SELECT id FROM $table");
	return mysqli_num_rows($result);
}
function count_target($table){
	global $conn;
	$result= 0; 
	$groups = mysqli_query($conn, "SELECT * FROM package_nhom");
	while($row = mysqli_fetch_assoc($groups)){
		$result += $row['so_tv'];
	}
	return $result;
}
?>
<?php
if ($_GET['act']) {
	//Modun moi
	if ($_GET['act'] == 'add-group') {
		require_once '2T_view/add_group.php';
	}
	if ($_GET['act'] == 'add-target') {
		require_once '2T_view/add_target.php';
	}
	if ($_GET['act'] == 'manage-target') {
		require_once '2T_view/manage_target.php';
	}
	if ($_GET['act'] == 'search-keyword') {
		require_once '2T_view/search_post.php';
	}
	// Modun cu
	if ($_GET['act'] == 'package-vip-like' && $_SESSION['admin']) {
		require_once '2T_view/view_package_vip_like.php';
	}
	if ($_GET['act'] == 'package-vip-cmt' && $_SESSION['admin']) {
		require_once '2T_view/view_package_vip_cmt.php';
	}
	if ($_GET['act'] == 'buy-vip-like') {
		require_once '2T_view/view_buy_vip_like.php';
	}
	if ($_GET['act'] == 'buy-vip-bot') {
		require_once '2T_view/view_buy_vip_bot.php';
	}
	if ($_GET['act'] == 'manage-vip-like') {
		require_once '2T_view/view_manage_vip_like.php';
	}
	if ($_GET['act'] == 'manage-vip-cmt') {
		require_once '2T_view/view_manage_vip_cmt.php';
	}
	if ($_GET['act'] == 'buy-vip-cmt') {
		require_once '2T_view/view_buy_vip_cmt.php';
	}
	if ($_GET['act'] == 'manage-vip-bot') {
		require_once '2T_view/view_manage_vip_bot.php';
	}
	if ($_GET['act'] == 'package-vip-bot' && $_SESSION['admin']) {
		require_once '2T_view/view_package_vip_bot.php';
	}
	if ($_GET['act'] == 'gift') {
		require_once '2T_view/view_gift.php';
	}
	if ($_GET['act'] == 'change-pass') {
		require_once '2T_view/view_change_pass.php';
	}
	if ($_GET['act'] == 'create-gift' && $_SESSION['admin']) {
		require_once '2T_view/view_create_gift.php';
	}
	if ($_GET['act'] == 'create-notify' && $_SESSION['admin']) {
		require_once '2T_view/view_create_notify.php';
	}
	if ($_GET['act'] == 'access-token' && $_SESSION['admin']) {
		require_once '2T_view/view_access_token.php';
	}
	if ($_GET['act'] == 'log-vip-like' && $_GET['id']) {
		$logID = $_GET['id'];
		if ($_GET['admin']) {
			$admin = $_GET['admin'];
		}
		require_once '2T_view/view_log_vip_like.php';
	}
	if ($_GET['act'] == 'log-vip-cmt' && $_GET['id']) {
		$logID = $_GET['id'];
		if ($_GET['admin']) {
			$admin = $_GET['admin'];
		}
		require_once '2T_view/view_log_vip_cmt.php';
	}
	if ($_GET['act'] == 'log-vip-bot' && $_GET['id']) {
		$logID = $_GET['id'];
		if ($_GET['admin']) {
			$admin = $_GET['admin'];
		}
		require_once '2T_view/view_log_vip_bot.php';
	}
	if ($_GET['act'] == 'nap-tien') {
		$logID = $_GET['id'];
		require_once '2T_view/view_nap_tien.php';
	}
	if ($_GET['act'] == 'set-vnd' && $_SESSION['admin']) {
		$logID = $_GET['id'];
		require_once '2T_view/view_set_vnd.php';
	}
	if ($_GET['act'] == 'access-token' && $_SESSION['admin']) {
		$logID = $_GET['id'];
		require_once '2T_view/view_access_token.php';
	}
	if ($_GET['act'] == 'del-access-token' && $_SESSION['admin']) {
		$logID = $_GET['id'];
		require_once '2T_view/view_del_access_token.php';
	}
	if ($_GET['act'] == 'history' && $_SESSION['admin']) {
		$logID = $_GET['id'];
		require_once '2T_view/view_history.php';
	}
	if ($_GET['act'] == 'manage-vip-like-admin' && $_SESSION['admin']) {
		$logID = $_GET['id'];
		require_once '2T_view/view_manage_vip_like_admin.php';
	}
	if ($_GET['act'] == 'manage-vip-cmt-admin' && $_SESSION['admin']) {
		$logID = $_GET['id'];
		require_once '2T_view/view_manage_vip_cmt_admin.php';
	}
	if ($_GET['act'] == 'manage-vip-bot-admin' && $_SESSION['admin']) {
		$logID = $_GET['id'];
		require_once '2T_view/view_manage_vip_bot_admin.php';
	}
	if ($_GET['act'] == 'manage-member' && $_SESSION['admin']) {
		$logID = $_GET['id'];
		require_once '2T_view/view_manage_member.php';
	}
	if ($_GET['act'] == 'buff-react' && $_SESSION['admin']) {
		require_once '2T_view/view_buff_react.php';
	}
	if ($_GET['act'] == 'buff-sub' && $_SESSION['admin']) {
		require_once '2T_view/view_buff_sub.php';
	}
	if ($_GET['act'] == 'buff-cmt' && $_SESSION['admin']) {
		require_once '2T_view/view_buff_cmt.php';
	}
	if ($_GET['act'] == 'viplike' && $_SESSION['admin']) {
		require_once 'cron/viplike.php';
	}
} else {
	require_once '2T_view/view_home.php';
}
?>
<?php
require_once '2T_tpl/tpl_footer.php';
?>