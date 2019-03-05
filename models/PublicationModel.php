<?php 

require_once '../lib/sql_request.php'; //Подключаем класс со всеми SQL запросами
$GLOBALS['SQL'] = new SqlRequest(); //Объект со всеми запросами к БД


/*
param $connection PDO object
param $user_id int
param $photo array
param $title string
param $hashtags string
	Добавляет публикацию в БД
*/
function addPublication($connection, $user_id, $photo, $title, $hashtags)
{
	$result = array();

	//Проверка, пользователь загрузил картинку или другой файл
	if($photo['type'] != 'image/jpeg' && $photo['type'] != 'image/jpg' && $photo['type'] != 'image/png' && $photo['type'] && 'image/gif'){
		// Если тип файла не подходит ни к одному из типов картинок, возвращаем ошибку
		$result['image'] = 'Нужно загрузить картинку';
		return $result;
	}
	
	//Проверяем на пустату переданные переменные.
	//Если не пустые очищаем данные
	$title = !empty($title) ? trim(htmlspecialchars($title)) : null;
	$hashtags = !empty($hashtags) ? trim(htmlspecialchars($hashtags)) : null;


	$filename = $photo['tmp_name']; // Временный путь картинки на сервере
	//Формируем путь куда будет загружена картинка. Имя картинки делаем путем хеширования временного пути
	$upload_path = 'img/users_publications/' . md5($photo['tmp_name']) . '.' . basename($photo['type']);

	//Проверка успешно ли бул загружен файл на сервер
	if(!move_uploaded_file($filename, $upload_path)){
		return false;
	}

	$filename_DB = basename($upload_path); //Получаем имя картинки с расширением

	$sql = $connection->prepare($GLOBALS['SQL']->sql_add_publication);

	//Проверка, успешно ли выполнен запрос к БД (добавление записи в таблицу publications)
	if(!$sql->execute([$user_id, $filename_DB, $title])){
		return false;
	}

	//Если были переданны хештеги, делаем их валидацию
	if($hashtags){
		$line_hashtags = str_replace(' ', '', $hashtags); //Удаляем все пробелы

		$array = explode(',', $line_hashtags); //Формируем массив из хештегов

		foreach ($array as $value) {
			//Проверяем, каждый ли хештег начинается с #
			if(!preg_match('/^#\w+/is', $value)){
				//Если нет, возвращаем ошибку
				$result['hashtag'] = 'Хештеги должны содержать символ #';
				return $result;
			}
		}

		$idInsertPub = $connection->lastInsertId(); //Получаем id последней добавленной записи

		$sql = $connection->prepare($GLOBALS['SQL']->sql_add_hashtag);

		//Проверка, успешно ли выполнен запрос к БД (добавление записи в таблицу hashtags)
		if(!$sql->execute([$idInsertPub, $line_hashtags]))
			return false;
	}
	
	return true;

}


/*
param connection Object PDO
param user_id int 
	Извлекает из БД 12 последних публикаций
*/
function getUserPublication($connection, $user_id)
{
	$select_user_publications = 'SELECT * FROM publications WHERE parent_id=?  ORDER BY pub_date DESC LIMIT 12';

	$sql = $connection->prepare($select_user_publications);

	if($sql->execute([$user_id])){
		$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $array;
	}
}

/*
param connection Object PDO
param user_id int 
param count_pub int 
	Извлекает 12 записей начиная с опреденной позиции. 
	Служит для ассинхронной подгрузки публикаций на страницу. 
*/
function loadingPublication($connection, $user_id, $count_pub){

	$load_user_pub = "SELECT * FROM publications WHERE parent_id=? ORDER BY pub_date DESC LIMIT {$count_pub}, 12";

	$sql = $connection->prepare($load_user_pub);
	
	if($sql->execute([$user_id])){
		$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $array;
	}
}