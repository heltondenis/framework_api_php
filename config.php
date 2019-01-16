<?php
require 'environment.php';

global $config;
$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/agendamob_api/");
	$config['dbname'] = '';
	$config['host'] = '';
	$config['dbuser'] = '';
	$config['dbpass'] = '';
	$config['jwt_secret_key'] = 'abC123';
} else {
	define("BASE_URL", "http://localhost/agendamob_api/");
	$config['dbname'] = '';
	$config['host'] = '';
	$config['dbuser'] = '';
	$config['dbpass'] = '';
    $config['jwt_secret_key'] = 'abC123';
}

global $db;
try {
	//$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
	$db = new PDO("mysql:dbname=".$config['dbname'].";charset=utf8".";host=".$config['host'], $config['dbuser'], $config['dbpass']);
} catch(PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}