<?php
/*
	Основные функции нужные по всему сайту
*/
require_once '../config/config.php';

//Загружает страницу по заданному контроллеру и заданной функции
function loadPage($controllerName, $actionName)
{
	require_once PREFIX_CONTROLLER . $controllerName . POSTFIX_CONTROLLER;
	$actionName(createSmarty());
}

//Функция для создания объекта Smarty
function createSmarty()
{
	require_once '../lib/Smarty/libs/Smarty.class.php';

	$smarty = new Smarty;

	$template = 'default/'; // Имя шаблона сайта

	$smarty->template_dir = PREFIX_TEMPLATE . $template;
	$smarty->cache_dir = '/instagram/tmp/smarty/cache/';
	$smarty->compile_dir = '/instagram/tmp/smarty/compile_c/';
	$smarty->config_dir = '/instagram/lib/Smarty/config/';
	
	return $smarty;
}

//функция отображения шаблона
function loadTemplate($smarty, $templateName)
{
	$smarty->display($templateName . POSTFIX_TEMPLATE);
}


/*
param connection PDO object
param login string
	Извлекает и БД данные пользователя по логину.
	Если не удалось извлечь, или пользователь не найден возвращает false, иначе ассоциативный массив с данными пользователя
*/
function getDataUserInLogin(PDO $connection, $login){
	//Извлекаем пользователя по логину, чтобы узнать его id
	$sql = $connection->prepare($GLOBALS['SQL']->select_user_from_login);

	if(!$sql->execute([$login]))
		return false;// Если не удалось извлечь пользователя 

	$user = $sql->fetch(PDO::FETCH_ASSOC);

	if(empty($user)) return false; //Если пользователь не найден в БД

	return $user;
}