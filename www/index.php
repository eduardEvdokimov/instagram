<?php
session_start(); // Стартуем сесиию для проверки авторизировался ли пользователь

require_once '../config/db.php'; // Подключаемся к базе данных
require_once '../lib/MainFunction.php'; // Основные функции


//Проверяем авторизовался пользователь или нет
if($_SESSION['auth'] != true){
	$controllerName = isset($_REQUEST['controller']) ? ucfirst($_REQUEST['controller']) : 'Registration';

	$actionName = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';

	$actionName .= 'Action'; 

	//Если пользователь не вошел в систему под своим аккаунтом и пытается 
	//попасть на страницу с публикациями возвращаем ошибку
	if($controllerName != 'Registration' && $controllerName != 'Login'){
		header('HTTP/1.1 404 Not Found');
		exit();
	}
	
	loadPage($controllerName, $actionName);
	exit();
}

$controllerName = isset($_REQUEST['controller']) ? ucfirst($_REQUEST['controller']) : 'Index';

$actionName = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';

$actionName .= 'Action'; 

loadPage($controllerName, $actionName);


