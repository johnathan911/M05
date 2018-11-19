<?php
header('Content-Type: text/html; charset=utf-8');
require_once '../2T_config/config_server.php';

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
?>
