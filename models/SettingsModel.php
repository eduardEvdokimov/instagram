<?php
//Работа с данными пользователя

require_once '../lib/MainFunction.php';//Основные функции для работы сайта
require_once '../config/config.php';//Константы проекта

//Проверка, есть ли пользователь с таким логином
function checkLogin(PDO $connection, $login)
{
	//Получаем данные пользователя по логину
	$sql = $connection->prepare($GLOBALS['SQL']->select_login);

	if(!$sql->execute([$login]))
		exit('Произошла ошибка сервера. Попробуйте позже');

	$data = $sql->fetch(PDO::FETCH_ASSOC);

	return empty($data) ? true : false; 
}

//Проверяет, правильно ли пользователь ввел пароль
function checkPassword(PDO $connection, $login, $password)
{	//Получаем данные пользователя по логину
	$user = getDataUserInLogin($connection, $login);

	if(empty($user))
		exit('Произошла ошибка сервера. Попробуйте позже');
	//Проверяем совпадает ли пароль
	$result = password_verify(SOL . $password . SOL, $user['password']);
	
	return $result;
}

//Сохраняет настройки данных пользователя
function saveChangeUserData(PDO $connection, $login, $name, $password, $avatar, $web_cyte, $about)
{
	//Очищаем данные
	$login = htmlspecialchars(trim($login));
	$name = empty($name) ? null : htmlspecialchars(trim($name));
	$password = empty($password) ? null : password_hash(SOL . htmlspecialchars(trim($password)) . SOL, PASSWORD_DEFAULT);
	$avatar = empty($avatar) ? null : $avatar;
	$web_cyte = empty($web_cyte) ? null : htmlspecialchars(trim($web_cyte));
	$about = empty($about) ? null : htmlspecialchars(trim($about));
	
	//Проверяем, загрузил ли пользователь аватарку
	if(!empty($avatar)){
		//Получаем данные пользователя по id
		$sql = $connection->prepare($GLOBALS['SQL']->insert_user_by_id);
		$sql->execute([$_SESSION['user']['id']]);
		$user = $sql->fetch(PDO::FETCH_ASSOC);
		//Проверяем, на то какая картинка установлена на аватарке
		if($user['avatar'] !== 'no_image_user.png'){
			//Если не стандартная, удаляем старую аватарку из папки
			unlink('img/users_avatar/' . $user['avatar']);
		}

		//Если загрузил, перемещаем из временного хранилища в постоянное
		$file = file_get_contents('img/tmp/' . $avatar['file']['name']);
		//Формируем название картинки
		$filename_DB = md5($avatar['file']['tmp_name']) . '.' . basename($avatar['file']['type']);
		//Проверяем успешность работы с файловой системой
		if(!$file)
			return false;

		if(!file_put_contents('img/users_avatar/' . $filename_DB, $file))
			return false;
		//Удаляем картинку из временного хранилища
		unlink('img/tmp/' . $avatar['file']['name']);

		$avatar = $filename_DB;
	}else
		$avatar = null;

	//Получаем массив из переменных
	$array = compact(['login', 'name', 'password', 'avatar', 'web_cyte', 'about']);
	//Проходимся по массиву и формируем строку для обновления данных БД
	foreach($array as $key => $value){
		if($key == 'name' || $key == 'web_cyte' || $key == 'about')
			$str .= $key . "='" . $value . "',";

		if(($value != null) && ($key != 'name' || $key != 'web_cyte' || $key != 'about')){
			$str .= $key . "='" . $value . "',";
		}
	}

	$str = rtrim($str, ','); //Удаляем последнюю запятую
	//Формируем строку запроса
	$update_user_data = sprintf("UPDATE users SET %s WHERE id=?", $str);

	$sql = $connection->prepare($update_user_data);

	if(!$sql->execute([$_SESSION['user']['id']]))
		return false;

	$_SESSION['user']['login'] = $login; //Обновляем сессию логина
	
	return true;
}