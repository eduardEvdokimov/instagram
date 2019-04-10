<?php
//Работа с данными уведомлений БД 

require_once '../lib/create_relative_date.php';//Подключаем функцию относительной даты
require_once '../lib/sql_request.php';

//Извлекает количество непрочитанных уведомлений пользователя
function getCountNotification(PDO $connection, $user_id)
{
	$sql = $connection->prepare($GLOBALS['SQL']->select_count_nocheck_notif);

	$sql->execute([$user_id]);
	$data = $sql->fetch(PDO::FETCH_ASSOC);
	$result = $data['COUNT(*)'];

	return $result;
}


//Извлекает из БД уведомления пользователя
function getNotificationUser(PDO $connection, $user_id)
{
	//Извлечение уведомлений
	$sql = $connection->prepare($GLOBALS['SQL']->select_notification_user);

	if(!$sql->execute([$user_id])){
		return false;
	}

	//Получаем массив с уведомлениями
	$notification = $sql->fetchAll(PDO::FETCH_ASSOC);

	//Извлечение данных пользователя сделавшего активность на нашем аккаунте
	$sql = $connection->prepare($GLOBALS['SQL']->sql_get_last_Insert_user);
	//Обновление статуса уведомления
	$sql_update = $connection->prepare($GLOBALS['SQL']->update_checked);

	//Проверяем, есть ли уведомления
	if(count($notification) == 0)
		return false;

	//Проходимся по всем уведомлениям
	foreach($notification as $value){

		$now_date = new DateTime;//Текущая дата
		$date_add_action = new DateTime($value['action_date']);//Дата дейстия пользователя
		$diff = $now_date->diff($date_add_action);//Разница текущей даты и даты действия

		//Проверяем видел ли пользователь данное уведомление
		if($value['checked'])
			$class = 'class=\'long_date\''; //Если видел, добавляем класс для затемнения фона
		else
			$class = '';
		
		//Если прошло больше 7 дней с момента получения уведомления, не отображаем его
		if($diff->format('%d') >= 7)
			continue;
		
		$sql_update->execute([$value['id']]);
		//Формируем относительную дату
		$value['date'] = relativeDate($value['action_date']);

		$sql->execute([$value['action_user']]);

		$user_data = $sql->fetch(PDO::FETCH_ASSOC);

		//Начинаем формировать html уведомления для отображения
		$value['visible_item'] = "<li {$class}><a href='http://instagram/user/{$user_data['login']}/'><img src='/img/users_avatar/{$user_data['avatar']}' alt=''></a>";

		//Определяем какого рода уведомление
		if($value['action'] == 'subscribe_user'){

			$value['visible_item'] .= "<p><a href='http://instagram/user/{$user_data['login']}/'>{$user_data['login']}</a> подписался на Вас<br><span class='date'>{$value['date']}</span></p></li>";

		}elseif($value['action'] == 'like_publication'){
				
			$value['visible_item'] .= "<p><a href='http://instagram/user/{$user_data['login']}/'>{$user_data['login']}</a> оценил Вашу публикацию<br><span class='date'>{$value['date']}</span></p></li>";

		}elseif($value['action'] == 'like_comment'){
			//Запрос извлечения данных комментария
			$sql_item = $connection->prepare($GLOBALS['SQL']->select_comment_in_id);
			$sql_item->execute([$value['more']]);
			$data_comment = $sql_item->fetch(PDO::FETCH_ASSOC);

			$value['visible_item'] .= "<p><a href='http://instagram/user/{$user_data['login']}/'>{$user_data['login']}</a> оценил Ваш комментарий<span>&nbsp;{$data_comment['comment']}&nbsp;</span><br><span class='date'>{$value['date']}</span></p></li>";

		}elseif($value['action'] == 'add_comment'){

			$sql_item = $connection->prepare($GLOBALS['SQL']->select_comment_in_id);
			$sql_item->execute([$value['more']]);
			$data_comment = $sql_item->fetch(PDO::FETCH_ASSOC);

			$value['visible_item'] .= "<p><a href='http://instagram/user/{$user_data['login']}/'>{$user_data['login']}</a> оставил комментарий<span>&nbsp;{$data_comment['comment']}&nbsp;</span>под Вашей публикацией<br><span class='date'>{$value['date']}</span></p></li>";

		}else return false;

		$result[] = $value;
	}

	return $result;
}