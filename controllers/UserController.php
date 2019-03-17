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
		$buttonAddPublications = "<button onclick='showForm()' id='new_pub'>Новая публикация</button>";
		$buttonChangeSettingData = "<button>Редактировать профиль</button>";

		$smarty->assign('AddPublications', $buttonAddPublications);
		$smarty->assign('buttonChangeSettingData', $buttonChangeSettingData);
	}else{
		//Если переходит на чужую страницу
		//Проверка подписан ли пользователь на этот аккаунт
		if(checkSubscribe($GLOBALS['connection'], $user['id'], $user_action['login'])){
			//Если подписан, скрываем кнопку подписаться и отображаем отписаться
			$buttonSub = "<button class='hidden' onclick='subscribe()' id='sub'>Подписаться</button>";
			$buttonUnSub = "<button class='show' onclick='unSubscribe()' id='unsub'>Отписаться</button>";
		}
		else{
			$buttonSub = "<button class='show' onclick='subscribe()' id='sub'>Подписаться</button>";
			$buttonUnSub = "<button class='hidden' onclick='unSubscribe()' id='unsub'>Отписаться</button>";
		}
	}

	//Извлекаем публикации пользователя
	$publications = getUserPublication($GLOBALS['connection'], $user_action['login']);

	$smarty->assign('publications', $publications);
	
	$smarty->assign('userLogin', $user['login']);
	$smarty->assign('userAvatarPath', $userAvatarPath);

	$smarty->assign('buttonSub', $buttonSub);
	$smarty->assign('buttonUnSub', $buttonUnSub);

	$smarty->assign('title', $user['login']); 
	$smarty->assign('TemplateWebPath', $template);	

	$smarty->assign('id_subscriber', $user['id']);
	$smarty->assign('sub_object', $user_action['login']);

	$smarty->assign('urlProfile', $userProfileUrl);

	loadTemplate($smarty, 'header');
	loadTemplate($smarty, 'user_page');
}


//Подписка на пользователя
function subscribeAction()
{
	echo addSubscribe($GLOBALS['connection'], $_POST['user_login'], $_POST['sub_object']);
}


//Отписка от пользователя
function unSubscribeAction()
{	
	echo deletSubscribe($GLOBALS['connection'], $_POST['user_login'], $_POST['sub_object']);
}