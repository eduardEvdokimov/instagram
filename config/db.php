<?php

define('HOST', 'localhost');
define('LOGIN', 'root');
define('PASS', '');
define('DBNAME', 'instagram');
define('CHARSET', 'UTF-8');

$dns = 'mysql:host=' . HOST . ';dbname=' . DBNAME . ';character=' . CHARSET;

try{
	$connection = new PDO($dns, LOGIN, PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
	$GLOBALS['connection'] = $connection;
}catch(PDOException $e){
	echo 'Не удалось подключиться к базе данных:' . $e->getMessage();
}