<?php
require_once '../config/db.php';
require_once '../models/NotificationModel.php';

function getNotificationAction()
{
	 echo json_encode(getNotificationUser($GLOBALS['connection'], $_SESSION['user']['id']));
}