<?php
//Работа с пользователем

require_once '../config/db.php'; //подключаемся к базе данных
require_once '../models/UsersModel.php'; //работаем с бд
require_once '../models/PublicationModel.php'; //Работа с публикациями
require_once '../lib/MainFunction.php'; //Основные функции для работы сайта
require_once '../models/NotificationModel.php';

function indexAction(Smarty $smarty)
{
	//Формируем массив с данными авторизованного пользователя 
	$user = getDataUserInLogin($GLOBALS['connection'], $_SESSION['user']['login']);
	//Формируем массив с данными пользователя на чью страницу мы вошли
	$user_action = getDataUserInLogin($GLOBALS['connection'], $_GET['id']);

	$userAvatarPath = '/img/users_avatar/' . $user['avatar']; //Путь к аватарке пользователя
	$template = '/default'; // Название папки с файлами веб пространства для стандартного шаблона
	$userProfileUrl = 'http://instagram/user/' . $user['login'] . '/'; //url на персональную страницу пользователя

	//Проверяем найдена ли страница пользователя
	if($user_action == false){
		//Если не найдена, делаем вброс чтобы сработа ErrorDocument
		header('Location: http://instagram/throw_error');
	}

	//Проверяем пользователь открывает свою страницу или другого пользователя
	if($user['login'] == $user_action['login']){
		//Если свою, формируем кнопки добавления публикации и редактирования профиля

		$list = "<ul><li id='list_down'><i class='fas fa-angle-down'></i><ul class='hidden'>";
		
		$list .= "<li class='show_item'><button onclick='showForm()' class='item_list_settings_user' id='new_pub'>Новая публикация</button></li>";
		
		$list .= "<li class='show_item'><a href='http://instagram/settings/' class='item_list_settings_user'>Редактировать профиль</a></li>";
		
		$list .= "<li class='show_item'><a href='http://instagram/login/logOut/' class='item_list_settings_user'>Выйти</a></li></ul></li></ul>";

		$btn_delete_publication = "<p id='delete_publication' onclick='comfirmedForm(event)'><i class='fas fa-times'></i></p>";
		

		$smarty->assign('btn_delete_publication', $btn_delete_publication);			
		$smarty->assign('dropDownList', $list);
	}else{
		//Если переходит на чужую страницу
		//Проверка подписан ли пользователь на этот аккаунт
		if(checkSubscribe($GLOBALS['connection'], $user['id'], $user_action['login'])){
			//Если подписан, скрываем кнопку подписаться и отображаем отписаться
			$buttonSub = "<button class='hidden user_action' onclick='subscribe(event)' id='sub'>Подписаться</button>";
			$buttonUnSub = "<button class='show user_action' onclick='unSubscribe(event)' id='unsub'>Отписаться</button>";
		}
		else{
			$buttonSub = "<button class='show user_action' onclick='subscribe(event)' id='sub'>Подписаться</button>";
			$buttonUnSub = "<button class='hidden user_action' onclick='unSubscribe(event)' id='unsub'>Отписаться</button>";
		}
	}

	//Извлекаем публикации пользователя
	$publications = getUserPublication($GLOBALS['connection'], $user_action['login']);
	$count_notification = getCountNotification($GLOBALS['connection'], $user['id']);

	//Формируем html тег для вставки в шаблон
	$html_count_notification = '<span>' . $count_notification . '</span>';
	//Если уведомлений больше 0, формируем переменную smarty
	if($count_notification > 0)
		$smarty->assign('count_notification',  $html_count_notification);
	
	$smarty->assign('title', $user_action['login']);
	$smarty->assign('publications', $publications);
	$smarty->assign('myLogin', $user['login']);
	$smarty->assign('myAvatarPath', $userAvatarPath);
	$smarty->assign('buttonSub', $buttonSub);
	$smarty->assign('buttonUnSub', $buttonUnSub);
	$smarty->assign('TemplateWebPath', $template);	
	$smarty->assign('sub_object', $user_action['login']);
	$smarty->assign('user', $user_action);
	$smarty->assign('myUrlProfile', $userProfileUrl);

	loadTemplate($smarty, 'header');
	loadTemplate($smarty, 'user_page');
}

//Подписка на пользователя
function subscribeAction()
{
	echo addSubscribe($GLOBALS['connection'], $_SESSION['user']['id'], $_POST['sub_object']);
}


//Отписка от пользователя
function unSubscribeAction()
{	
	echo deletSubscribe($GLOBALS['connection'], $_SESSION['user']['id'], $_POST['sub_object']);
}

//Получаем список пользователей на которых подписаны либо кто на нас подписаны
function getSubUsersAction()
{
	echo json_encode(getSubUsers($GLOBALS['connection'], $_POST['user_login'], $_POST['type']));
}


