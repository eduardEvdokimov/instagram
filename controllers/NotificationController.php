<?php
//Работа с уведомлениями

require_once '../config/db.php';//Получаем объект PDO
require_once '../models/NotificationModel.php';//Работаем с уведомлениями

//Получаем уведомления пользователя
function getNotificationAction()
{
	 echo json_encode(getNotificationUser($GLOBALS['connection'], $_SESSION['user']['id']));
}