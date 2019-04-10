<?php
//Работает с поиском

require_once '../config/db.php'; //подключаемся к базе данных
require_once '../models/PublicationModel.php';//Функции для работы с публикациями
require_once '../lib/MainFunction.php';//Основные функции для работы проекта
require_once '../models/NotificationModel.php';//Работа с БД уведомлений

function indexAction(Smarty $smarty)
{
	//Получаем данные авторизованного пользователя
	$user = getDataUserInLogin($GLOBALS['connection'], $_SESSION['user']['login']);

	$userAvatarPath = '/img/users_avatar/' . $user['avatar']; //путь к аватарке пользователя
	$userProfileUrl = 'http://instagram/user/' . $user['login'] . '/'; //url на персональную страницу 
	
	$template = '/default'; //Шаблон стилей

	$smarty->assign('title', 'Instagram'); 
	$smarty->assign('TemplateWebPath', $template);
	$smarty->assign('myLogin', $user['login']);
	$smarty->assign('myAvatarPath', $userAvatarPath);
	$smarty->assign('myUrlProfile', $userProfileUrl); 

	//получаем из get запроса хештег, извлекаем публикации с таким хештегом
	$publications = getPublicationInHashtag($GLOBALS['connection'], str_replace(']}]', 'х', $_GET['hashtag']));

	//Если встречается русская буква х кодируем ее
	$smarty->assign('hashtag', '#' . str_replace(']}]', 'х', $_GET['hashtag']));
	$smarty->assign('count_publications', count($publications));
	//Получаем количество уведомлений
	$count_notification = getCountNotification($GLOBALS['connection'], $user['id']);
	//Формируем html тег, для вставки в шаблон
	$html_count_notification = '<span>' . $count_notification . '</span>';

	if($count_notification > 0)
		$smarty->assign('count_notification',  $html_count_notification);

	$smarty->assign('publications', $publications);
	
	loadTemplate($smarty, 'header');
	loadTemplate($smarty, 'search_page');
}

//Запрос к БД на поиск введенных данных
function searchAction()
{
	echo json_encode(searchRequest($GLOBALS['connection'], $_POST['search']));
}