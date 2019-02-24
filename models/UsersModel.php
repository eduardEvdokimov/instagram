<?php
/*
	Модель для работы с пользователями
*/
require_once '../lib/sql_request.php'; //Файл с запросами к БД
require_once '../config/config.php'; //Константы, настройки сайта
$GLOBALS['SQL'] = new SqlRequest(); //Объект со всеми запросами к БД

/*
param connection PDO object
param login string
param mail string
	Проверка слуществует ли пользователь с таким логином и электронной почтой
*/
function checkExistLoginMail($connection, $login, $mail)
{
	$result = ['error' => '']; // Массив ошибок

	


	// Проверка существует ли пользователь с таким логином
	$sql = $connection->prepare($GLOBALS['SQL']->sql_check_login);
	$sql->execute([$login]);
	$data = $sql->fetch(PDO::FETCH_NUM);
	//Если data НЕ пустой, значит пользователь с данным логином уже существует
	if($data[0] != 0){
		$result['error'] = 'Пользователь с данным логином (' . $login . ') уже существует';
		return $result; 
	}


	//Проверка существует ли пользователь с такой электронной почтой
	$sql = $connection->prepare($GLOBALS['SQL']->sql_check_mail);
	$sql->execute([$mail]);
	$data = $sql->fetch(PDO::FETCH_NUM);
	if(!empty($data)){
		$result['error'] = 'Пользователь с данной эл. почтой (' . $mail . ') уже существует';
		return $result; 
	}

	// Если все проверки прошли успешно, возвращаем true
	return true;
}



/*
param connection PDO object
param login string
param mail string
param password string
param name string
	Добавление нового пользователя в БД (Регистрация)
*/
function registerUserAction($connection, $login, $mail, $password, $name)
{
	

	//Генерируем код подтверждения регистрации
	$key = md5($mail . time());


	//Очистка данных
	$login = htmlspecialchars(trim($login));
	$mail = htmlspecialchars(trim($mail));
	$password = htmlspecialchars(trim($password));
	$name = !empty($name) ? htmlspecialchars(trim($name)) : null;


	//Хештрование пароля
	$passwordHash = password_hash(SOL . $password . SOL, PASSWORD_DEFAULT);

	//Аватарка по умолчанию
	$default_avatar_user = 'no_image_user.png';

	// Добавление пользователя в таблицу users
	$sql = $connection->prepare($GLOBALS['SQL']->sql_users_DB);
	if(!$sql->execute([$login, $name, $passwordHash, $key, $default_avatar_user]))
		return false;

	// Добавление пользователя в таблицу mails
	$lastInsertId = $connection->lastInsertId();
	$sql = $connection->prepare($GLOBALS['SQL']->sql_mails_DB);

	//Если не удалось добавить в таблицу mails возвращаем false
	if(!$sql->execute([$lastInsertId, $mail]))
		return false;

	//Извлекаем из БД только что добавленного пользователя
	$sql = $connection->prepare($GLOBALS['SQL']->sql_get_last_Insert_user);
	if($sql->execute([$lastInsertId])){
		mailAction($mail, $key);
		$result = $sql->fetch(PDO::FETCH_ASSOC);
		return $result;
	}else
		return false;
}

//Функция отправки смс на электронную почту с кодом подтверждения регистрация
function mailAction($mail, $key)
{
	$url = 'http://instagram/registration/confirm/?key=' . $key;
	mail($mail, 'Подтверждение регистрации', 'Чтобы подтвердить регистрацию перейдите по сслыке: ' . $url);
}

//Подтверждение регистрации аккаунта
function confirmedAccaunt($connection, $key)
{
	

	$sql = $connection->prepare($GLOBALS['SQL']->sql_update);
	if($sql->execute([$key]))
		return true;
	else
		return false;
}



function loginUser($connection, $login_mail, $password)
{
	$result = array();

	


	$sql = $connection->prepare($GLOBALS['SQL']->sql_select_user);
	$sql->execute([$login_mail]);
	$data = $sql->fetch(PDO::FETCH_ASSOC);

	//Если data пустая, значит по логину пользователь не найден
	if(empty($data)){
		$sql = $connection->prepare($GLOBALS['SQL']->sql_select_mail);
		$sql->execute([$login_mail]);
		$data = $sql->fetch(PDO::FETCH_ASSOC);

		//Если data пустая, значит по мылу пользователь не найден
		if(empty($data)){
			return false;
		}else{
			//Если пользователь найден по мылу извлекаем из таблицы users пользователя по внешнему ключу
			$sql = $connection->prepare($GLOBALS['SQL']->sql_select_user_from_mail);
			$sql->execute([$data['parent_id']]);
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			//Проверяем подтвержден ли аккаунт
			if($data['confirmed'] !== '1')
				return false;

			//Проверяем, совпадает ли пароль
			if(checkPassword($data['password'], $_POST['password']))
				//Если совпадает возвращаем массив с данными пользователя
				return $data;
			else
				return false;
		}

	}else{
		//Если пользователь найден по логину
		//Проверяем подтвержден ли аккаунт
		if($data['confirmed'] !== '1')
				return false;
		//Проверяем, совпадает ли пароль
		if(checkPassword($data['password'], $_POST['password']))
			//Если совпадает возвращаем массив с данными пользователя
			return $data;
		else
			return false;
	}
}


//Проверка пароля
function checkPassword($hash, $password)
{
	if(password_verify(SOL . $password . SOL, $hash))
		return true;
	else
		return false;
}

//Добавление новой подписки
function addSubscribe($connection, $id_subscriber, $sub_object)
{	
	

	$sql = $connection->prepare($GLOBALS['SQL']->sql_add_sub);

	if($sql->execute([$id_subscriber, $sub_object]))
		return true;
	else
		return false;
}

function deletSubscribe($connection, $id_subscriber, $sub_object)
{
	

	$sql = $connection->prepare($GLOBALS['SQL']->sql_drop_sub);

	if($sql->execute([$id_subscriber, $sub_object]))
		return true;
	else
		return false;
}

//Проверка подписан ли пользователь на открытый аккаунт
function checkSubscribe($connection, $id_subscriber, $sub_object)
{
	

	$sql = $connection->prepare($GLOBALS['SQL']->sql_check);

	$sql->execute([$id_subscriber, $sub_object]);

	$data = $sql->fetch(PDO::FETCH_ASSOC);
	

	//Если пользователь подписан, возвращаем true
	if(!empty($data))
		return true;
	else
		return false;
}

/*
param connection PDO Object
param data array
	Авторизация пользователя по аккаунту соц. сети Вконтакте
*/

function registrationVK($connection, $data)
{	
	$variable = array(); // Промежуточные данные

	
	
	$sql = $connection->prepare($GLOBALS['SQL']->sql_check_mail); //Проверка существует ли пользователь с такой электронной почтой
	$sql->execute([$data['email']]);
	$variable = $sql->fetch();
	
	if(!empty($variable)){
		//Если variable не пустой, значит такое мыло уже есть в БД. Извлекаем данные пользователя из БД и записываем в сессию.
		$sql = $connection->prepare($GLOBALS['SQL']->sql_select_user_from_mail);
		$sql->execute([$variable['parent_id']]);
		$variable = $sql->fetch(PDO::FETCH_ASSOC);
		$_SESSION['user'] = $variable;
		return $variable;
	}else{
		//Если мыло не найдено в БД
		$login = (string)$data['id']; //Формируем логин из id аккаунта ВК
		$name = $data['first_name'] . ' ' . $data['last_name']; //Имя пользователя (имя и фамилия)
		$mail = $data['email'];
		$password = SOL . $data['id'] . SOL; 

		//Хеш пароля
		$passwordHash = password_hash($password, PASSWORD_DEFAULT);

		//Проверка установлена ли аватарка на аккаунте пользователя ВК 
		if($data['photo_max_orig'] == 'https://vk.com/images/camera_400.png?ava=1')
			//Если не установлена, записываем картинку по умолчанию
			$avatar_name = 'no_image_user.png';
		else{
			//Если установлена, формируем имя и записываем картинку в папку проекта
			$avatar_name = md5(mt_rand(10000, 99999));
			$avatar_name .= '.jpg';
			$photo = file_put_contents('img/users_avatar/' . $avatar_name , file_get_contents($data['photo_max_orig']));
		}

		//Добавляем пользователя БД
		$sql = $connection->prepare($GLOBALS['SQL']->insert_user_vk);

		if($sql->execute([$login, $name, $passwordHash, $avatar_name, '1'])){
			//Если в таблицу users успешно добавили, записываем в таблицу mails
			
			$lastInsertId = $connection->lastInsertId(); // получаем id добавленного пользователя

			$sql = $connection->prepare($GLOBALS['SQL']->insert_user_mail_vk);
			
			if($sql->execute([$lastInsertId, $mail])){
				//Если умпешно добавли мыло в таблицу mails, извлекаем данные пользователя из БД
				$sql = $connection->prepare($GLOBALS['SQL']->insert_user_by_id);
				$sql->execute([$lastInsertId]);
				$variable = $sql->fetch(PDO::FETCH_ASSOC);
				//Записываем данные пользователя в сессию
				$_SESSION['user'] = $variable;
				return $variable;
			}
		}





	}

}