<?php
/*
	Файл загрузки главной станицы
*/

function indexAction(Smarty $smarty)
{
	$user = createArraySmarty($_SESSION['user']);
	$userAvatarPath = '/img/users_avatar/' . $user['avatar']; //путь к аватарке пользователя
	$userProfileUrl = 'http://instagram/user/' . $user['id'] . '/'; //url на персональную страницу пользователя

	$template = 'default'; // Название папки с файлами веб пространства для дефолтного шаблона

	$smarty->assign('title', 'Instagram'); 
	$smarty->assign('TemplateWebPath', $template);
	$smarty->assign('userLogin', $user['login']);
	$smarty->assign('userAvatarPath', $userAvatarPath);

	$smarty->assign('urlProfile', $userProfileUrl);

	loadTemplate($smarty, 'header');
	loadTemplate($smarty, 'index');
	loadTemplate($smarty, 'footer');
}