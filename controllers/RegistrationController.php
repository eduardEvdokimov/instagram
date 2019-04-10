<?php
/*
	Контроллер регистрации пользователя
*/
require_once '../config/db.php'; //подключаемся к базе данных
require_once '../config/config.php'; //файл с константами сайта
require_once '../models/UsersModel.php'; //работаем с бд

function indexAction(Smarty $smarty)
{
	$smarty->assign('ID', ID_VK); //ID приложения ВК
	$smarty->assign('URL', URL);//Адрес обработки запроса авторизации через ВК

	loadTemplate($smarty, 'register');
}

// Добавление пользователя в базу данных
function addUserAction()
{
	$connection = $GLOBALS['connection']; //Объект с подключением к БД

	//Введенные данные являются ли эл. почтой
	if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
		$result['error'] = 'Введите верный маил';
		exit(json_encode($result));
	}

	//Проверка слуществует ли пользователь с таким логином и электронной почтой
	$data = checkExistLoginMail($connection, $_POST['login'], $_POST['mail']);

	//Если вернулся в data - массив, значит есть ошибки 
	if(is_array($data)){
		$result['error'] = $data['error'];
		exit(json_encode($result));
	}

	//Добавление пользователя в ДБ
	$data = registerUserAction($connection, $_POST['login'], $_POST['mail'], $_POST['password'], $_POST['name']);

	if($data){
		$result['message'] = 'Вы успешно зарегистрировались';
		echo json_encode($result);
	}else{
		$result['error'] = 'Не удалось зарегистрироваться';
		echo json_encode($result);
	}
}

//Подтверждение регистрации
function confirmAction()
{
	if(confirmedAccaunt($GLOBALS['connection'], $_GET['key']))
		header('Location: http://instagram/login/index/');
}