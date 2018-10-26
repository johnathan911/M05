
<?php
session_start();
error_reporting(0);
date_default_timezone_set('Asia/Ho_Chi_Minh');
$config_site = array(
	'url' => 'http://localhost/M05',
	'name' => 'M05.org',
	'admin' => array('admin1'),
);
$config_gC = array(
	'api_url' => 'https://www.google.com/recaptcha/api/siteverify',
	'site_key'=> '6LeohG0UAAAAABXakPLhTEaSmxqYm9kQU6rQTNHW',
	'secret_key'=> '6LeohG0UAAAAAOr_afPQFiR1DD11DKJt77ct-O_r'
);
$config_db = array(
	'db_host' => 'localhost',
	'db_user' => 'root',
	'db_name' => 'M05',
	'db_pass' => 'Iloveyou123'
);
$conn = mysqli_connect($config_db['db_host'], $config_db['db_user'], $config_db['db_pass'], $config_db['db_name']);
mysqli_set_charset($conn,"utf8");
?>
