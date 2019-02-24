<?php
/*
	Контроллер регистрации пользователя
*/
require_once '../config/db.php'; //подключаемся к базе данных
require_once '../config/config.php'; //файл с константами сайта
require_once '../models/UsersModel.php'; //работаем с бд

function indexAction(Smarty $smarty)
{
	$smarty->assign('ID', ID_VK);
	$smarty->assign('URL', URL);

	loadTemplate($smarty, 'register');
}

//Проверка введенных данных на верность (валидация)
function validateData($login, $password, $mail, $name)
{
	
	//Проверка длины полей
	if(mb_strlen($login) < 3){
		$result['login'] = 'Слишком короткий логин';
	}

	if(mb_strlen($password) < 3){
		$result['password'] = 'Слишком короткий пароль';
	}
	//Введенные данные являются ли паролем
	if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
		$result['mail'] = 'Введите верный маил';
	}

	if(!empty($result))
		return $result;
	else
		return true;
}


// Добавление пользователя в базу данных
function addUserAction()
{
	$result = [
			'login' => '',
			'password' => '',
			'mail' => '',
			'error' => '',
			'message' => ''
	];

	$connection = $GLOBALS['connection']; //Объект с подключением к БД


	$login = isset($_REQUEST['login']) ? $_REQUEST['login'] : null;
	$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
	$mail = isset($_REQUEST['mail']) ? $_REQUEST['mail'] : null;
	$name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;


	//Проверка заполнены ли обязательные поля
	if(empty($login) || empty($password) || empty($mail)){
		$result['error'] = 'Заполните обязательные поля*'; 
		echo json_encode($result);
		exit();
	}
	

	// Проверка на валидность данных
	$validData = validateData($login, $password, $mail, $name);


	//Если validData - массив, значит есть ошибки
	if(is_array($validData)){
		//Проход по массиву result для обновления элементов 
		foreach ($result as $key => $value) {
			//Проверка на то, существует ли ключ в массиве validData
			if(array_key_exists($key, $validData))
				//Если существует, обновляем значение ключа, т.е. записывает ошибку
				$result[$key] = $validData[$key];
		}
		echo json_encode($result);
		exit();
	}

	//Проверка слуществует ли пользователь с таким логином и электронной почтой
	$data = checkExistLoginMail($connection, $login, $mail);

	//Если вернулся в data - массив, значит есть ошибки 
	if(is_array($data)){
		$result['error'] = $data['error'];
		echo json_encode($result);
		exit();
	}


	//Добавление пользователя в ДБ
	$data = registerUserAction($connection, $login, $mail, $password, $name);
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