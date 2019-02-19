<?php
header('Content-Type: text/html; charset=utf-8');
require_once '../2T_config/config_server.php';
$url = 'https://www.facebook.com/QuatTv/videos/2483981641642232/';
$token = 'EAAAAUaZA8jlABAEMFuPziV6j3ARQSk36Wqn3OfjI4Sa2KZAeBEgldq3Sj45nWcSHMb5mRoZA6FlqTQC9eoc55X0lTPf1HEEVaUiCc1ngTcnngwvsJaOSw9BSspRZB3j1AtCX4VZAZCVZAbanL8ZCUZCrxO8XBYFV5cxl1lOWRuCH3tAZDZD';
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
