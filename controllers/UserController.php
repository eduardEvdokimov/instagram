<?php
require_once '../config/db.php'; //подключаемся к базе данных
require_once '../models/UsersModel.php'; //работаем с бд

function indexAction(Smarty $smarty)
{
	
	//Формируем массив с данными пользователя 
	$user = createArraySmarty($_SESSION['user']);
	$userAvatarPath = '/img/users_avatar/' . $user['avatar']; //Путь к аватарке пользователя
	$template = '/default'; // Название папки с файлами веб пространства для дефолтного шаблона
	$userProfileUrl = 'http://instagram/user/' . $user['id'] . '/'; //url на персональную страницу пользователя
	
	


	//Проверяем пользователь открывает свою страницу или другого пользователя
	if($user['id'] == $_GET['id']){
		//Если свою, формируем кнопки добавления публикации и редактирования профиля
		$buttonAddPublications = "<button onclick='showForm()'>Добавить фото</button>";
		$buttonChangeSettingData = "<button>Редактировать профиль</button>";

		$smarty->assign('AddPublications', $buttonAddPublications);
		$smarty->assign('buttonChangeSettingData', $buttonChangeSettingData);

	}else{
		//Если переходит на чужую страницу
		//Проверка подписан ли пользователь на этот аккаунт
		if(checkSubscribe($GLOBALS['connection'], $user['id'], $_GET['id'])){

			//Если подписан, скрываем кнопку подписаться и отображаем отписаться
			$buttonSub = "<button class='hidden' onclick='subscribe()' id='sub'>Подписаться</button>";
			$buttonUnSub = "<button class='show' onclick='unSubscribe()' id='unsub'>Отписаться</button>";

		}
		else{

			$buttonSub = "<button class='show' onclick='subscribe()' id='sub'>Подписаться</button>";
			$buttonUnSub = "<button class='hidden' onclick='unSubscribe()' id='unsub'>Отписаться</button>";
		}
	}


	
	$smarty->assign('userLogin', $user['login']);
	$smarty->assign('userAvatarPath', $userAvatarPath);

	$smarty->assign('buttonSub', $buttonSub);
	$smarty->assign('buttonUnSub', $buttonUnSub);

	$smarty->assign('title', $user['login']); 
	$smarty->assign('TemplateWebPath', $template);	

	$smarty->assign('id_subscriber', $user['id']);
	$smarty->assign('sub_object', $_GET['id']);

	$smarty->assign('urlProfile', $userProfileUrl);

	loadTemplate($smarty, 'header');
	loadTemplate($smarty, 'user_page');
	
}


//Подписка на пользователя
function subscribeAction()
{

	$result;
	if(addSubscribe($GLOBALS['connection'], $_POST['id_subscriber'], $_POST['sub_object'])){
		$result = true;
	}else{
		$result = false;
	}
	echo $result;
}

function unSubscribeAction()
{	
	$result;
	if(deletSubscribe($GLOBALS['connection'], $_POST['id_subscriber'], $_POST['sub_object'])){
		$result = true;
	}else{
		$result = false;
	}
	echo $result;
}