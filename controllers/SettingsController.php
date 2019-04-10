<?php
//Работа с настройками данных пользователя

require_once '../models/NotificationModel.php';//Работа с уведомлениями
require_once '../config/db.php';//Подключение к БД
require_once '../models/SettingsModel.php';//Работа с данными пользователя


function indexAction(Smarty $smarty)
{	
	//Формируем массив с данными пользователя 
	$user = getDataUserInLogin($GLOBALS['connection'], $_SESSION['user']['login']);

	$userAvatarPath = '/img/users_avatar/' . $user['avatar']; //Путь к аватарке пользователя
	$template = '/default'; // Название папки с файлами веб пространства для дефолтного шаблона
	$userProfileUrl = 'http://instagram/user/' . $user['login'] . '/'; //url на персональную страницу пользователя

	//Получаем количество уведомлений
	$count_notification = getCountNotification($GLOBALS['connection'], $user['id']);
	$html_count_notification = '<span>' . $count_notification . '</span>';

	if($count_notification > 0)
		$smarty->assign('count_notification',  $html_count_notification);

	$smarty->assign('TemplateWebPath', $template);
	$smarty->assign('user', $user);
	$smarty->assign('myUrlProfile', $userProfileUrl);
	$smarty->assign('myAvatarPath', $userAvatarPath);
	$smarty->assign('myLogin', $user['login']);

	loadTemplate($smarty, 'settings');
}

//Проверка существует ли пользователь с данным логином
function loginCheckAction()
{
	echo checkLogin($GLOBALS['connection'], $_POST['login']);
}

//Проверка правильно ли пользователь ввел пароль
function passwordCheckAction()
{
	echo checkPassword($GLOBALS['connection'], $_SESSION['user']['login'], $_POST['password']);
}

//Изменение аватарки пользователя
function changeAvatarAction()
{
	$photo = $_FILES['file'];

	//Проверка, пользователь загрузил картинку или другой файл
	if($photo['type'] != 'image/jpeg' && 
		$photo['type'] != 'image/jpg' && 
		$photo['type'] != 'image/png' && 
		$photo['type'] && 'image/gif'){
		// Если тип файла не подходит ни к одному из типов картинок, возвращаем ошибку
		exit(false);
	}
	//Загружаем картинку во временные файлы, чтобы сразу показать изменения
	if(!move_uploaded_file($_FILES['file']['tmp_name'], 'img/tmp/' . $_FILES['file']['name']))
		exit('Ошибка сервера. Попробуйте позже');

	//Формируем	путь для вставки в тег img
	$result = '/img/tmp/' . $_FILES['file']['name'];
	echo $result;
}

//Сохранение изменений 
function saveChangeAction()
{
	echo saveChangeUserData(
							$GLOBALS['connection'], 
							$_POST['login'], 
							$_POST['name'], 
							$_POST['new_pass'], 
							$_FILES, 
							$_POST['web_cyte'], 
							$_POST['about']); 
}