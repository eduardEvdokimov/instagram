<?php	
//Работа с авторизацией

require_once '../config/db.php'; //подключаемся к базе данных
require_once '../models/UsersModel.php'; //работаем с бд
require_once '../config/config.php'; //файл с константами сайта
require_once '../lib/MainFunction.php';//Основные функции для работы сайта

//Загрузка шаблона страницы
function indexAction(Smarty $smarty)
{
	$smarty->assign('login_mail', $_COOKIE['login_mail']);
	$smarty->assign('password', $_COOKIE['password']);
	loadTemplate($smarty, 'login');
}

//Авторизация пользователя
function loginAction()
{ 
	//Делаем запрос к БД, для проверки данных пользователя
	$data = loginUser($GLOBALS['connection'], $_POST['login_mail'], $_POST['password']);

	//Если пользоваетель не найден в БД, в data будет false
	if(!$data){
		$result['error'] = 'Проверте правильность введенных данных';
		echo json_encode($result);
	}else{
		//Если пользователь найден в БД
		$_SESSION['user'] = $data;
		$_SESSION['auth'] = true;
		$data['login_mail'] = $_POST['login_mail'];
		$data['password'] = $_POST['password']; 
		$data['success'] = true;
		echo json_encode($data);
	}
}

//Выполняет авторизацию пользователя через аккаунт Вконтакте
function loginVKAction()
{
	//Проверяем пришел ли код для получения access_token
	if(!$_GET['code'])
		exit('Не удалось войти. Попробуйте позже');

	//Получаем токе и попутно мыло пользователя
	$token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id=' . ID_VK . '&client_secret=' . SECRET . '&redirect_uri=' . URL . '&code=' . $_GET['code']), true);

	if(!$token)
		exit('Не удалось войти. Попробуйте позже');

	//Получаем данные пользователя ВК
	$data = json_decode(file_get_contents('https://api.vk.com/method/users.get?&user_id=' . $token['user_id'] . '&access_token=' . $token['access_token'] . '&v=5.52&fields=uid,photo_max_orig'), true);

	if(!$data)
		exit('Не удалось войти. Попробуйте позже');

	//Если у пользователя ВК нет подтверждения по мылу не идем дальше
	if(!isset($token['email'])){
		 exit('Ошибка. У Вас отсутстует подтверждение аккаунта по электронной почте.');
	}

	$user = $data['response'][0]; //Формируем массив с данными пользователя
	$user['email'] = $token['email']; //Добавляем в массив мыло

	//Добавляем, или извлекаем данные пользоватедя в случаем если такой пользователь уже есть в базе
	$result = registrationVK($GLOBALS['connection'], $user);

	//Если вернулся массив (с данными пользователя) делаем редирект на главную страницу
	if(is_array($result)){
		$_SESSION['auth'] = true;
		header('Location: http://instagram/');
	}
}

//Выход из учетной записи
function logOutAction()
{
	$_SESSION = []; //Обнуляем данные сессии и делаем редирект на главную
	header('Location: http://instagram/');
}

//Делает запрос к БД для проверки есть ли пользователь, который хочет восстановить пароль в БД
function restorePasswordAction()
{
	echo restorePassword($GLOBALS['connection'], $_POST['login_mail']);
}

//Проверяем что пользователь открывает страницу изменения пароля по ссылке
function changePasswordAction()
{
	//Если параметр code отсутствует, делаем редирект на главную
	if(!$_GET['code'])
		header('Location: http://instagram/');

	//Если код не активен, редирект на главную
	if(!checkUserInCode($GLOBALS['connection'], $_GET['code']))
		header('Location: http://instagram/');
	//Если проверки не сработали подгружаем страницу с формой изменения пароля
	loadTemplate(createSmarty(), 'restore_password');
}

//Изменяет пароль пользователя на новый
function saveNewPasswordAction()
{
	echo saveNewPassword($GLOBALS['connection'], $_POST['code'], $_POST['password']);
}