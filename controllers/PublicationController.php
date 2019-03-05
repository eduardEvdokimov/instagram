<?php

require_once '../models/PublicationModel.php';
require_once '../config/db.php';

//Добавление публикации в БД
function addPublicationAction()
{
	$result = array();

	$data = addPublication(
						$GLOBALS['connection'], 
						$_POST['user_id'], 
						$_FILES['file'], 
						$_POST['title'], 
						$_POST['hashtags']);

	if(is_array($data)){

		echo json_encode($data);

	}elseif($data == true){
		$result['success'] = 'Публикация успешно добавлена';
		echo json_encode($result);
	}
}

//Подгрузка новых публикаций на страницу
function loadingAction()
{	
	$publications = loadingPublication($GLOBALS['connection'], $_POST['user_id'], $_POST['count_pub']);

	echo json_encode($publications);
}

