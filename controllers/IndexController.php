<?php
/*
	Файл загрузки главной станицы
*/
require_once '../config/db.php'; //подключаемся к базе данных
require_once '../lib/MainFunction.php';
require_once '../models/UsersModel.php';
require_once '../models/PublicationModel.php';

function indexAction(Smarty $smarty)
{
	$user = $_SESSION['user'];
	$userAvatarPath = '/img/users_avatar/' . $user['avatar']; //путь к аватарке пользователя
	$userProfileUrl = 'http://instagram/user/' . $user['login'] . '/'; //url на персональную страницу пользователя

	$template = 'default'; // Название папки с файлами веб пространства для дефолтного шаблона

	$user_action = getDataUserInLogin($GLOBALS['connection'], $user['login']);
	

	$smarty->assign('title', 'Instagram'); 
	$smarty->assign('TemplateWebPath', $template);
	$smarty->assign('userLogin', $user['login']);
	$smarty->assign('userAvatarPath', $userAvatarPath);

	$smarty->assign('urlProfile', $userProfileUrl);

	if($user_action['count_subscriptions'] <= 0){
		$users_subscribe = getPopularUsers($GLOBALS['connection'], $user_action['id']);

		if(!$users_subscribe)
			exit('Ошибка. Попробуйте позже');

		$smarty->assign('users', $users_subscribe);
		$smarty->assign('user_id', $user['id']);

		loadTemplate($smarty, 'header');
		loadTemplate($smarty, 'list_add_subscribers');
		exit();
	}

	$publications = getNewPublications($GLOBALS['connection'], $user['id']);

	$smarty->assign('publications', $publications);
	loadTemplate($smarty, 'header');
	loadTemplate($smarty, 'index');
	loadTemplate($smarty, 'footer');
}