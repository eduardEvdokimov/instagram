<?php

require_once '../models/PublicationModel.php';
require_once '../config/db.php';

//Добавление публикации в БД
function addPublicationAction()
{
	$data = addPublication(
						$GLOBALS['connection'], 
						$_POST['user_login'], 
						$_FILES['file'], 
						$_POST['title'], 
						$_POST['hashtags']);

	echo json_encode($data);
}

//Подгрузка новых публикаций на страницу
function loadingAction()
{	
	$publications = loadingPublication($GLOBALS['connection'], $_POST['user_login'], $_POST['count_pub']);

	echo json_encode($publications);
}


function getPublicationAction()
{
	$result = getFullDataPublication($GLOBALS['connection'], $_POST['pub_id']);
	
	echo json_encode($result);
}


function addCommentAction()
{
	echo addComment($GLOBALS['connection'], $_SESSION['user']['id'], $_POST['public_id'],  $_POST['comment']); 
}


function addLikeCommentAction()
{
	echo addLikeComment($GLOBALS['connection'], $_SESSION['user']['id'], $_POST['comment_id']);
}


function delLikeCommentAction()
{
	echo delLikeComment($GLOBALS['connection'], $_SESSION['user']['id'], $_POST['comment_id']);
}


function addLikeAction()
{
	echo addLike($GLOBALS['connection'], $_SESSION['user']['id'], $_POST['publication_id']);
}


function delLikeAction()
{
	echo delLike($GLOBALS['connection'], $_SESSION['user']['id'], $_POST['publication_id']);
}