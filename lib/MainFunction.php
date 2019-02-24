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
param array array
	Функция формирования удобного массива для шаблонизатора
*/

function createArraySmarty($array)
{
	$result = array();
	foreach($array as $key => $value){
		$result[$key] = $value;
	}
	return $result;
}