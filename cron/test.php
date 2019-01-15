<?php
header('Content-Type: text/html; charset=utf-8');
require_once '../2T_config/config_server.php';
$url = 'https://www.facebook.com/100008289978359/videos/2359527447666898/';
$token = 'EAAAAUaZA8jlABAHjBUzZBLUrB8WqDXAZCoG92zyZAk2hzGiz1iNaNRwrZCpRprrG7BQI4HATCnFHrZBwK06VptuoLff877LE2nYEAqP9mc72MlTZCGjVj1SuoqRMHx7LOsQff2hc6dNYJwRwhiyqewo4xN3Ub37mSNuqvJYH3qRnTcZApbaZBBm7W';
$scoure = GetScoureVideo($url,$token);
echo $scoure;

function GetScoureVideo($url, $token){
	$tmp = array();
	$tmp = explode('/',$url);
	$video_id = $tmp[5];
    $getName = json_decode(file_get_contents('https://graph.facebook.com/'. $video_id . '?access_token=' . $token));
    if($getName->source){
        return $getName->source;
    }
    return 0;
}
?>
