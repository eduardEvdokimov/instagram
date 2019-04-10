<?php
//Работаем с публикациями

require_once '../models/PublicationModel.php';//Работа с БД публикаций
require_once '../config/db.php';//Получаем объект PDO

//Добавление публикации в БД
function addPublicationAction()
{
	echo json_encode(addPublication(
						$GLOBALS['connection'], 
						$_POST['user_login'], 
						$_FILES['file'], 
						$_POST['title'], 
						$_POST['hashtags']));
}

//Подгрузка новых публикаций на страницу
function loadingAction()
{	
	echo json_encode(loadingPublication($GLOBALS['connection'], $_POST['user_login'], $_POST['count_pub']));
}

//Получение всей информации конкретной публикации
function getPublicationAction()
{
	echo json_encode(getFullDataPublication($GLOBALS['connection'], $_POST['pub_id']));
}

//Добавление комментария публикации
function addCommentAction()
{
	echo addComment($GLOBALS['connection'], $_SESSION['user']['id'], $_POST['public_id'],  $_POST['comment']); 
}

//Добавление лайка комментарию
function addLikeCommentAction()
{
	echo addLikeComment($GLOBALS['connection'], $_SESSION['user']['id'], $_POST['comment_id']);
}

//Удаление лайка у комментария
function delLikeCommentAction()
{
	echo delLikeComment($GLOBALS['connection'], $_SESSION['user']['id'], $_POST['comment_id']);
}

//Добавление лайка публикации
function addLikeAction()
{
	echo addLike($GLOBALS['connection'], $_SESSION['user']['id'], $_POST['publication_id']);
}

//Удаление лайка публикации
function delLikeAction()
{
	echo delLike($GLOBALS['connection'], $_SESSION['user']['id'], $_POST['publication_id']);
}

//Удаление публикации
function deletePublicationAction()
{
	echo deletePublication($GLOBALS['connection'], $_POST['public_id']);
}