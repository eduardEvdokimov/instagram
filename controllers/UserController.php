<?php
require_once '../config/db.php'; //подключаемся к базе данных
require_once '../models/UsersModel.php'; //работаем с бд
require_once '../models/PublicationModel.php';
require_once '../lib/MainFunction.php'; 

function indexAction(Smarty $smarty)
{
	//Формируем массив с данными пользователя 
	$user = $_SESSION['user'];
	$userAvatarPath = '/img/users_avatar/' . $user['avatar']; //Путь к аватарке пользователя
	$template = '/default'; // Название папки с файлами веб пространства для дефолтного шаблона
	$userProfileUrl = 'http://instagram/user/' . $user['login'] . '/'; //url на персональную страницу пользователя
	

	$user_action = getDataUserInLogin($GLOBALS['connection'], $_GET['id']);

	//Проверяем найдена ли страница пользователя
	if($user_action == false){
		//Если не найдена, делаем вброс чтобы сработа ErrorDocument
		header('Location: http://instagram/throw_error');
	}

	//Проверяем пользователь открывает свою страницу или другого пользователя
	if($user['login'] == $user_action['login']){
		//Если свою, формируем кнопки добавления публикации и редактирования профиля

		$list = "<ul><li id='list_down'><i class='fas fa-angle-down'></i><ul class='hidden'>";
		
		$list .= "<li class='show_item'><button onclick='showForm()' id='new_pub'>Новая публикация</button></li>";
		
		$list .= "<li class='show_item'><button>Редактировать профиль</button></li>";
		
		$list .= "<li class='show_item'><a href='http://instagram/login/logOut/'>Выйти</a></li></ul></li></ul>";
					
		$smarty->assign('dropDownList', $list);
	}else{
		//Если переходит на чужую страницу
		//Проверка подписан ли пользователь на этот аккаунт
		if(checkSubscribe($GLOBALS['connection'], $user['id'], $user_action['login'])){
			//Если подписан, скрываем кнопку подписаться и отображаем отписаться
			$buttonSub = "<button class='hidden' onclick='subscribe(event)' id='sub'>Подписаться</button>";
			$buttonUnSub = "<button class='show' onclick='unSubscribe(event)' id='unsub'>Отписаться</button>";
		}
		else{
			$buttonSub = "<button class='show' onclick='subscribe(event)' id='sub'>Подписаться</button>";
			$buttonUnSub = "<button class='hidden' onclick='unSubscribe(event)' id='unsub'>Отписаться</button>";
		}
	}

	//Извлекаем публикации пользователя
	$publications = getUserPublication($GLOBALS['connection'], $user_action['login']);

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