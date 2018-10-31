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
	if ($_GET['act'] == 'add-feed-site') {
		require_once '2T_view/add_feed_site.php';
	}
	// Modun cu
	if ($_GET['act'] == 'change-pass') {
		require_once '2T_view/view_change_pass.php';
	}
	if ($_GET['act'] == 'create-notify' && $_SESSION['admin']) {
		require_once '2T_view/view_create_notify.php';
	}
	if ($_GET['act'] == 'access-token' && $_SESSION['admin']) {
		require_once '2T_view/view_access_token.php';
	}
	if ($_GET['act'] == 'access-token' && $_SESSION['admin']) {
		$logID = $_GET['id'];
		require_once '2T_view/view_access_token.php';
	}
	if ($_GET['act'] == 'del-access-token' && $_SESSION['admin']) {
		$logID = $_GET['id'];
		require_once '2T_view/view_del_access_token.php';
	}
	if ($_GET['act'] == 'manage-member' && $_SESSION['admin']) {
		$logID = $_GET['id'];
		require_once '2T_view/view_manage_member.php';
	}
} else {
	require_once '2T_view/view_home.php';
}
?>
<?php
require_once '2T_tpl/tpl_footer.php';
?>