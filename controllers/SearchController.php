<?php
require_once '../config/db.php'; //подключаемся к базе данных
require_once '../models/PublicationModel.php';//Функции для работы с публикациями
require_once '../lib/MainFunction.php';//Основные функции для работы проекта
require_once '../models/NotificationModel.php';
function indexAction(Smarty $smarty){
	//получаем из get запроса хештег, извлекаем публикации с таким хештегом

	$user = $_SESSION['user'];
	$userAvatarPath = '/img/users_avatar/' . $user['avatar']; //путь к аватарке пользователя
	$userProfileUrl = 'http://instagram/user/' . $user['login'] . '/'; //url на персональную страницу 
	
	$template = '/default';
	$smarty->assign('title', 'Instagram'); 
	$smarty->assign('TemplateWebPath', $template);
	$smarty->assign('myLogin', $user['login']);
	$smarty->assign('myAvatarPath', $userAvatarPath);
	$smarty->assign('myUrlProfile', $userProfileUrl); 


	$publications = getPublicationInHashtag($GLOBALS['connection'], str_replace(']}]', 'х', $_GET['hashtag']));

	$smarty->assign('hashtag', '#' . str_replace(']}]', 'х', $_GET['hashtag']));
	$smarty->assign('count_publications', count($publications)); 
	$count_notification = getCountNotification($GLOBALS['connection'], $user['id']);

	$html_count_notification = '<span>' . $count_notification . '</span>';

	if($count_notification > 0)
		$smarty->assign('count_notification',  $html_count_notification);


	$smarty->assign('publications', $publications);
	
	loadTemplate($smarty, 'header');
	loadTemplate($smarty, 'search_page');
}



function searchAction()
{
	echo json_encode(searchRequest($GLOBALS['connection'], $_POST['search']));
}