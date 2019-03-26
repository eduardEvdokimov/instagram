<?php
/*
	Файл загрузки главной станицы
*/
require_once '../config/db.php'; //подключаемся к базе данных
require_once '../lib/MainFunction.php';//Основные функции для работы проекта
require_once '../models/UsersModel.php';//Функции для работы с данными пользователя
require_once '../models/PublicationModel.php';//Функции для работы с публикациями

function indexAction(Smarty $smarty)
{
	$user = $_SESSION['user'];
	$userAvatarPath = '/img/users_avatar/' . $user['avatar']; //путь к аватарке пользователя
	$userProfileUrl = 'http://instagram/user/' . $user['login'] . '/'; //url на персональную страницу пользователя

	$template = 'default'; // Название папки с файлами веб пространства для дефолтного шаблона

	//Получаем данные пользователя из БД который вошел на сайт
	$user_action = getDataUserInLogin($GLOBALS['connection'], $user['login']);
	
	$smarty->assign('title', 'Instagram'); 
	$smarty->assign('TemplateWebPath', $template);
	$smarty->assign('myLogin', $user['login']);
	$smarty->assign('myAvatarPath', $userAvatarPath);
	$smarty->assign('myUrlProfile', $userProfileUrl); 

	//Проверяем есть ли у пользователя подписки
	if($user_action['count_subscriptions'] <= 0){
		//Если их нет, извлекаем из БД самых популярных
		$users_subscribe = getPopularUsers($GLOBALS['connection'], $user_action['id']);
		//Проверяем упешность работы с БД
		if(!$users_subscribe)
			exit('Ошибка. Попробуйте позже');
		//Формируем переменную-массив с популярмыми пользователями
		$smarty->assign('users', $users_subscribe);
		//Подгружаем страницу со списком популярных пользователей
		loadTemplate($smarty, 'header');
		loadTemplate($smarty, 'list_add_subscribers');
		exit();
	}

	//Получаем последние публикации пользователей на которых подписаны
	$publications = getNewPublications($GLOBALS['connection'], $user['id']);
	//Получаем самых популярных пользователей на которых еще не подписаны
	$recomendateUsers = getRecomendateUsers($GLOBALS['connection'], $user['id']);

	$smarty->assign('publications', $publications);
	$smarty->assign('recomendateUsers', $recomendateUsers);
	loadTemplate($smarty, 'header');
	loadTemplate($smarty, 'index');
	loadTemplate($smarty, 'footer');
}


//Подгрузка комментариев
function loadCommentsAction()
{
	echo json_encode(loadComments($GLOBALS['connection'], $_POST['publication_id'], $_POST['start']));
}