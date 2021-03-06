<?php 
//Работа с публикациями

require_once '../lib/MainFunction.php';//Основные функции для работы сайта
require_once '../lib/create_relative_date.php'; //Подключаем функцию формирования относительной даты
require_once '../lib/sql_request.php'; //Подключаем класс со всеми SQL запросами

/*
param connection PDO object
param user_login string
param photo array
param title string
param hashtags string
	Добавляет публикацию в БД
*/
function addPublication(PDO $connection, $user_login, $photo, $title, $hashtags)
{
	$result = array();
	//Получаем данные пользователя по логину, который добавляет публикацию
	$user = getDataUserInLogin($connection, $user_login);

	//Проверка, пользователь загрузил картинку или другой файл
	if ($photo['type'] != 'image/jpeg' && 
		$photo['type'] != 'image/jpg' && 
		$photo['type'] != 'image/png' && 
		$photo['type'] && 'image/gif'){
		// Если тип файла не подходит ни к одному из типов картинок, возвращаем ошибку
		$result['image'] = 'Нужно загрузить картинку';
		return $result;
	}
	
	//Проверяем на пустату переданные переменные.
	//Если не пустые очищаем данные
	$title = !empty($title) ? trim(htmlspecialchars($title)) : null;
	$hashtags = !empty($hashtags) ? trim(htmlspecialchars($hashtags)) : null;
	$public_id = md5($photo['size'] . mt_rand(1, 100)) ;//Формируем внешний id публикации
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
	if($sql->execute([$public_id, $user['id'], $filename_DB, $title])){

		$idInsertPub = $connection->lastInsertId(); //Получаем id последней добавленной записи
		
		//Если запрос прошел успешно, увеличиваем количество публикаций пользователя
		$sql = $connection->prepare($GLOBALS['SQL']->add_count_publications);
		$sql->execute([$user['id']]);

	}else return false;

	//Если были переданны хештеги, делаем их валидацию
	if($hashtags){
		$line_hashtags = str_replace(' ', '', $hashtags); //Удаляем все пробелы

		$array = explode(',', $line_hashtags); //Формируем массив из хештегов
		//Проверяем каждый хештег на валидность
		foreach ($array as $value) {
			//Проверяем, каждый ли хештег начинается с #
			if(!preg_match('/^#\S+/is', $value)){
				//Если нет, возвращаем ошибку
				$result['hashtag'] = 'Хештеги должны содержать символ #';
				return $result;
			}
		}

		$sql = $connection->prepare($GLOBALS['SQL']->sql_add_hashtag);

		//Проверка, успешно ли выполнен запрос к БД (добавление записи в таблицу hashtags)
		if(!$sql->execute([$idInsertPub, $line_hashtags]))
			return false;
	}
	
	//Получаем первые 12 символов public_id, так как размер поля в БД 12 символов
    $public_id = mb_substr($public_id, 0, 12);
    //Формируем массив результатов, для динамического добавления публикации
	$result = [
		'success' => 'Публикация успешно добавлена', 
		'public_id_publication' => $public_id, 
		'image_publication' => $filename_DB
	];

	return $result;
}


/*
param connection Object PDO
param login int 
	Извлекает из БД 12 последних публикаций
	Возвращает в случае успешного извлечения публикаций массив с публикациями, в противном случае false
*/
function getUserPublication(PDO $connection, $login)
{
	//Получаем данные пользователя по логину
	$user = getDataUserInLogin($connection, $login);
	
	$sql = $connection->prepare($GLOBALS['SQL']->select_user_publications);

	if($sql->execute([$user['id']])){

		$array = $sql->fetchAll(PDO::FETCH_ASSOC);

		$sql = $connection->prepare($GLOBALS['SQL']->select_count_comment);

		if(count($array) > 0){
			//Если есть публикации, проходим по каждой и извлекаем количество комментариев
			foreach ($array as $value) {
				$sql->execute([$value['id']]);
				$count_comment = $sql->fetch(PDO::FETCH_ASSOC);
				$value['comment'] = $count_comment['COUNT(*)'];
				$result[] = $value;
			}
		}
		return $result;
	}else return false;
}

/*
param connection Object PDO
param user_login string
param count_pub int 
	Извлекает 12 записей начиная с опреденной позиции. 
	Служит для подгрузки публикаций на страницу. 
	Возвращает в случае успешного извлечения публикаций массив с ними, в противном случае false
*/
function loadingPublication(PDO $connection, $user_login, $count_pub)
{
	//Извлечение 12 последнедобавленных публикаций начиная с определенного места
	$load_user_pub = "SELECT * FROM publications WHERE parent_id=? ORDER BY pub_date DESC LIMIT {$count_pub}, 12";

	$user = getDataUserInLogin($connection, $user_login);

	$sql = $connection->prepare($load_user_pub);
	
	if($sql->execute([$user['id']])){
		$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($array)){
			//Если публикации найдены, извлекаем для каждой количество комментариев
			$sql = $connection->prepare($GLOBALS['SQL']->select_count_comment);
			foreach ($array as  $value) {
				$sql->execute([$value['id']]);
				$count = $sql->fetch(PDO::FETCH_ASSOC);
				$value['count_comment'] = $count['COUNT(*)'];
				$result[] = $value;
			}
			return $result;
		}else return false;
	}else return false;
}


/*
param connection Object PDO
param public_id int
	Извлекает всю информацию о публикации, для вывода ее в popup окне 
	В случае успешного запроса к БД и если найдена нужная публикация возвращается массив с данными публикации , в противном случае false
*/
function getFullDataPublication(PDO $connection, $public_id)
{
	$data = []; //Массив для промежуточных данных
	$result = []; //Массив результата

	$sql = $connection->prepare($GLOBALS['SQL']->select_pub_public_id);

	//Извлекаем данные из таблицы publications
	if($sql->execute([$public_id])){
		$data = $sql->fetch(PDO::FETCH_ASSOC);

		if(empty($data))
			//Если не удалось извлеч данные публикации из БД, возвращаем false
			return false;

		$result = $data;
	}else return false;

	$sql = $connection->prepare($GLOBALS['SQL']->insert_user_by_id);

	//Извлекаем данные из таблицы users
	if($sql->execute([$result['parent_id']])){
		$data = $sql->fetch(PDO::FETCH_ASSOC);

		if(empty($data))
			//Если не удалось извлеч данные публикации из БД, возвращаем false
			return false;

		$result['author'] = $data;
	}else return false;


	$sql = $connection->prepare($GLOBALS['SQL']->select_hastags_pub);
	//Извлекаем данные из таблицы hashtags
	if($sql->execute([$result['id']])){
		$data = $sql->fetch(PDO::FETCH_ASSOC);

		if(!empty($data)){
			
			
			$data = explode(',', $data["hashtag"]); //Формируем массив с хештегами

			foreach ($data as $value) {
				$hashtags[] = "<a href='http://instagram/search/" . str_replace(['х', '#'], [']}]', ''], $value) . "/'>{$value}</a>";
			}

			$result['hashtags'] = $hashtags;		
		}
	}else return false;

	$sql = $connection->prepare($GLOBALS['SQL']->select_comment_pub);

	//Извлекаем данные из таблицы comments
	if($sql->execute([$result['id']])){
		$data = $sql->fetchAll(PDO::FETCH_ASSOC);

		if(!empty($data)){
			foreach ($data as $value) {
				$value['pub_date'] = mb_strtoupper(relativeDate($value['pub_date']));
				//Проверяем лайкай ли пользователь комментарий
				$value['press_like'] = commentCheckPressLike($connection, $_SESSION['user']['id'], $value['id']);
				$final_comments[] = $value;
			}
			$result['comments'] = $final_comments;
		}
	}else return false;

	//Преобразуем обычную дату в относительную
	$result['pub_date'] = mb_strtoupper(relativeDate($result['pub_date']));
	//Проверяем лайкал ли пользователь публикацию
	$result['like'] = checkPressLike($connection, $_SESSION['user']['id'], $_POST['pub_id']);
	return $result;
}

/*
param connection PDO object
param id_user int
param $public_id string
param comment string
	Добавление комментария в БД. 
	Возвращает в случае успешного добавлния комментария true, в противном случае false
*/
function addComment(PDO $connection, $id_user, $public_id, $comment)
{
	$data = []; //Промежуточные данные

	$comment = htmlspecialchars(trim($comment)); //Очистка данных

	$sql = $connection->prepare($GLOBALS['SQL']->select_pub_public_id);

	if($sql->execute([$public_id])){
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		$id_publication = $data['id'];
	}else return false;

	$sql = $connection->prepare($GLOBALS['SQL']->add_comment);

	if($sql->execute([$id_user, $id_publication, $comment])){
		$id_comment = $connection->lastInsertId();

		$sql = $connection->prepare($GLOBALS['SQL']->sql_get_last_Insert_user);
		$sql->execute([$data['parent_id']]);
		$user = $sql->fetch(PDO::FETCH_ASSOC);

		//Проверяем, что оставили комментарий не под своей публикацией, для добавления уведомления
		if($id_user != $user['id']){
			$sql = $connection->prepare($GLOBALS['SQL']->add_action_comment);
			$sql->execute([$id_user, 'add_comment', $user['id'], $id_comment]);
		}

		return $id_comment;
	}else return false;
}
	
/*
param connection PDO object
param user_id int
param $public_id string
	Проверяет лайкал ли пользователь данную публикацию. 
	Возвращает успешной работы с БД true, в противном случае false
*/
function checkPressLike(PDO $connection, $user_id, $public_id)
{
	$sql = $connection->prepare($GLOBALS['SQL']->check_line_like);

	if($sql->execute([$public_id, $user_id])){
		$data = $sql->fetch(PDO::FETCH_NUM);
		if(!empty($data))
			return true;
		else
			return false;
	}	
}

/*
param connection PDO object
param user_id int
param $comment_id int
	Проверяет лайкал ли пользователь данный комментарий. 
	Возвращает в случае успешной работы с БД true, в противном случае false
*/
function commentCheckPressLike(PDO $connection, $user_id, $comment_id)
{
	$sql = $connection->prepare($GLOBALS['SQL']->check_press_like_comm);

	if($sql->execute([$user_id, $comment_id])){
		$data = $sql->fetch();

		if(!empty($data))
			return true;
		else 
			return false;

	}else return false;
}

/*
param connection PDO object
param id_user int
param $public_id string
	Удаление лайка у комментария. 
	Возвращает в случае успешной работы с БД true, в противном случае false
*/
function delLikeComment(PDO $connection, $user_id, $comment_id)
{	
	//Удаление лайка у комментария
	$sql = $connection->prepare($GLOBALS['SQL']->drop_like_comment);

	if($sql->execute([$user_id, $comment_id])){
		//Уменьшение количества лайков у комментария
		$sql = $connection->prepare($GLOBALS['SQL']->decrement_like_comment);

		if($sql->execute([$comment_id])){
			//Извлекает пользователя под чьим постом был комментарий
			$sql = $connection->prepare($GLOBALS['SQL']->select_user_from_comment_id);
			$sql->execute([$comment_id]);
			$user = $sql->fetch(PDO::FETCH_ASSOC);
			//Проверяем, что удалили лайк не у своего комментария
			if($user_id != $user['id']){
				//Удаляем уведомление у пользователя
				$sql = $connection->prepare($GLOBALS['SQL']->action_del_like_comment);
				$sql->execute([$user_id, $comment_id]);
			}

			return true;
		}
		else
			return false;
	}else return false;
}

/*
param connection PDO object
param user_id int
param $comment_id int
	Добавление лайка комментарию. 
	Возвращает в случае успешной работы с БД true, в противном случае false
*/
function addLikeComment(PDO $connection, $user_id, $comment_id)
{
	//Добавляет лайк комментарию
	$sql = $connection->prepare($GLOBALS['SQL']->add_like_comment);

	if($sql->execute([$user_id, $comment_id])){
		//Увеличивает количество лайков комментария
		$sql = $connection->prepare($GLOBALS['SQL']->increment_like_comment);

		if($sql->execute([$comment_id])){
			//Извлекает пользователя, чей комментарий
			$sql = $connection->prepare($GLOBALS['SQL']->select_user_from_comment_id);
			$sql->execute([$comment_id]);
			$user = $sql->fetch(PDO::FETCH_ASSOC);

			if($user_id != $user['id']){
				//Добавляем уведомление пользователю
				$sql = $connection->prepare($GLOBALS['SQL']->action_add_like_comment);
				$sql->execute([$user_id, 'like_comment', $user['id'], $comment_id]);
			}
			return true;
		
		}else return false;
	}else return false;
}

/*
param connection PDO object
param user_id int
param $public_id string
	Добавление лайка публикации. 
	Возвращает в случае успешной работы с БД true, в противном случае false
*/
function addLike(PDO $connection, $user_id, $public_id)
{
	$sql = $connection->prepare($GLOBALS['SQL']->select_pub_public_id);
	
	if($sql->execute([$public_id])){
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		$pub_id = $data['id'];
	}

	$sql = $connection->prepare($GLOBALS['SQL']->add_like_publication);

	if($sql->execute([$user_id, $pub_id])){
		$sql = $connection->prepare($GLOBALS['SQL']->increment_like);
		if($sql->execute([$pub_id])){
			$sql = $connection->prepare($GLOBAL['SQL']->select_user_from_public_id_pub);
			$sql->execute([$public_id]);
			$publication = $sql->fetch(PDO::FETCH_ASSOC);

			if($user_id != $publication['parent_id']){
				$sql = $connection->prepare($GLOBALS['SQL']->action_add_like_publication);
				$sql->execute([$user_id, 'like_publication', $publication['parent_id'], $publication['id']]);
			}

			return true;
		}
	}
	return false;
}

/*
param connection PDO object
param user_id int
param $public_id string
	Удаление лайка у публикации. 
	Возвращает в случае успешной работы с БД true, в противном случае false
*/
function delLike(PDO $connection, $user_id, $public_id)
{
	$sql = $connection->prepare($GLOBALS['SQL']->select_pub_public_id);
	
	if($sql->execute([$public_id])){
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		$pub_id = $data['id'];
	}

	$sql = $connection->prepare($GLOBALS['SQL']->del_like_publication);

	if($sql->execute([$user_id, $pub_id])){
		$sql = $connection->prepare($GLOBALS['SQL']->decrement_likes);
		if($sql->execute([$pub_id])){

			$sql = $connection->prepare($GLOBALS['SQL']->select_user_from_public_id_pub);
			$sql->execute([$public_id]);
			$publication = $sql->fetch(PDO::FETCH_ASSOC);

			if($user_id != $publication['parent_id']){
				$sql = $connection->prepare($GLOBALS['SQL']->action_del_like_publication);
				$sql->execute([$user_id, $publication['id']]);
			}
			return true;
		}
	}
	return false;
}

/*
param connection PDO object
param user_id int
	Возвращает новые публикации пользователей на которых подписан
*/
function getNewPublications(PDO $connection, $user_id)
{
	$sql = $connection->prepare($GLOBALS['SQL']->select_new_publications);
	//Проверка успешности работы с БД
	if(!$sql->execute([$user_id]))
		return false;

	$publications = $sql->fetchAll(PDO::FETCH_ASSOC);
	$sql = $connection->prepare($GLOBALS['SQL']->select_comment_pub);
	$sql_hashtag = $connection->prepare($GLOBALS['SQL']->select_hastags_pub);
	//Проходим по каждой публикации
	foreach($publications as $value){
		//Преобразуем дату публикации в относительный вид
		$value['pub_date'] = mb_strtoupper(relativeDate($value['pub_date']));
		//Узнаем лайкал ли позователь публикацию
		$value['check_like'] = checkPressLike($connection, $user_id, $value['public_id']);



		if($value['check_like']){
			$value['button_like'] = "<button id='button_like' onclick='delLike(event)'><img src='/img/cyte/heart_red.png' alt=''></button>";
			$value['dbl_click_like'] = 'falseLike(event)';
		}
		else{
			$value['button_like'] = "<button id='button_like' onclick='addLike(event)'><img src='/img/cyte/heart.png' alt=''></button>";

			$value['dbl_click_like'] = 'likeDoubleClick(event)';
		}
		//Извлекаем комментарии для публикации
		$sql->execute([$value['id']]);
		$value['comment'] = $sql->fetchAll(PDO::FETCH_ASSOC);

		$sql_hashtag->execute([$value['id']]);

		$data = $sql_hashtag->fetch(PDO::FETCH_ASSOC);

		$data = explode(',', $data["hashtag"]); //Формируем массив с хештегами

		if(!empty($data))
		foreach ($data as $hashtag) {
			$value['hashtags'] .= "<a href='http://instagram/search/" . str_replace(['х', '#'], [']}]', ''], $hashtag) . "/'>{$hashtag}</a>&nbsp;";
		}


		if(count($value['comment']) > 3)
			//Если комментариев больше 3 добавляем кнопку подгрузки комментариев
			$value['visible_comment'] = "<button id='loadComment' onclick='loadComments(event);'>Загрузить еще комментарии</button>";

		//Обрезаем массив с комментариями до 3
		$value['comment'] = array_slice($value['comment'], 0, 3);
		//Инвертируем массив
		$value['comment'] = array_reverse($value['comment']);
		
		if(!empty($value['comment'])){
			$count = 0;
			//Проходим по каждому комментарию, чтобы узнать лайкал ли пользователь его
			foreach ($value['comment'] as  $comment) {
				
				if(commentCheckPressLike($connection, $user_id, $comment['id']))
					$button = "<button onclick='delLikeComment(event);'><img src='/img/cyte/heart_red.png' alt=''></button>";
				else
					$button = "<button onclick='addLikeComment(event);'><img src='/img/cyte/heart.png' alt=''></button>";
	
				$value['comment'][$count]['button_like'] = $button;
				$count++;
			}
		}
		$result[] = $value;
	}
	return $result;
}


/*
param connection Object PDO
param user_login string
param count_pub int 
	Извлекает 12 записей начиная с опреденной позиции. 
	Служит для ассинхронной подгрузки публикаций на страницу. 
	Возвращает в случае успешного извлечения публикаций массив с ними, в противном случае false
*/
function loadingNewPublication(PDO $connection, $user_id, $count_pub)
{
	//Извлечение 12 последнедобавленных публикаций начиная с определенного места
	$load_new_pub = "SELECT subscribers.*, publications.*, users.login, users.avatar FROM subscribers, publications, users WHERE subscribers.id_subscriber=? AND publications.parent_id=subscribers.sub_object AND users.id=publications.parent_id ORDER BY publications.pub_date DESC LIMIT {$count_pub}, 12";

	$sql = $connection->prepare($load_new_pub);
	if(!$sql->execute([$user_id]))
		return false;

	$publications = $sql->fetchAll(PDO::FETCH_ASSOC);

	$sql = $connection->prepare($GLOBALS['SQL']->select_comment_pub);
	if(!empty($publications))
	//Проходим по каждой публикации
	foreach($publications as $value){
		//Преобразуем дату публикации в относительный вид
		$value['pub_date'] = mb_strtoupper(relativeDate($value['pub_date']));
		//Узнаем лайкал ли позователь публикацию
		$value['check_like'] = checkPressLike($connection, $user_id, $value['public_id']);

		if($value['check_like']){
			$value['button_like'] = "<button id='button_like' onclick='delLike(event)'><img src='/img/cyte/heart_red.png' alt=''></button>";
			$value['dbl_click_like'] = 'falseLike(event)';
		}
		else{
			$value['button_like'] = "<button id='button_like' onclick='addLike(event)'><img src='/img/cyte/heart.png' alt=''></button>";

			$value['dbl_click_like'] = 'likeDoubleClick(event)';
		}
		//Извлекаем комментарии для публикации
		$sql->execute([$value['id']]);
		$value['comment'] = $sql->fetchAll(PDO::FETCH_ASSOC);

		if(count($value['comment']) > 3)
			//Если комментариев больше 3 добавляем кнопку подгрузки комментариев
			$value['visible_comment'] = "<button id='loadComment' onclick='loadComments(event);'>Загрузить еще комментарии</button>";

		//Обрезаем массив с комментариями до 3
		$value['comment'] = array_slice($value['comment'], 0, 3);
		//Инвертируем массив
		$value['comment'] = array_reverse($value['comment']);
		
		if(!empty($value['comment'])){
			$count = 0;
			//Проходим по каждому комментарию, чтобы узнать лайкал ли пользователь его
			foreach ($value['comment'] as  $comment) {
				
				if(commentCheckPressLike($connection, $user_id, $comment['id']))
					$button = "<button onclick='delLikeComment(event);'><img src='/img/cyte/heart_red.png' alt=''></button>";
				else
					$button = "<button onclick='addLikeComment(event);'><img src='/img/cyte/heart.png' alt=''></button>";
	
				$value['comment'][$count]['button_like'] = $button;
				$count++;
			}
		}
		$result[] = $value;
	}
	return $result;
}

/*
param connection PDO Object
param publication_id string
param start int
Извлекает комментарии из БД начиная с позиции start
*/
function loadComments(PDO $connection, $publication_id, int $start)
{
	$select_comment_in_start = "SELECT  users.login, publications.id, comments.* FROM comments, users, publications WHERE publications.public_id=? AND comments.parent_id_publication=publications.id AND users.id=comments.parent_id_user ORDER BY pub_date DESC LIMIT {$start}, 10";

	if(!is_int($start))
		return false;

	$sql = $connection->prepare($select_comment_in_start);

	if($sql->execute([$publication_id])){
		$result = $sql->fetchAll(PDO::FETCH_ASSOC);
	}else return false;

	foreach ($result as $comment) {
		//Определяем лайкал ли пользователь комментарий
		if(commentCheckPressLike($connection, $_SESSION['user']['id'], $comment['id']))
			$comment['button_like'] = "<button onclick='delLikeComment(event);'><img src='/img/cyte/heart_red.png' alt=''></button>";
		else
			$comment['button_like'] = "<button onclick='addLikeComment(event);'><img src='/img/cyte/heart.png' alt=''></button>";	

		$data[] = $comment;
	}

	$result = $data;
	
	return $result;
}

//Извлекает пользователей, хештеги, которые совпадает с запросом
function searchRequest(PDO $connection, $search)
{
	$sql = $connection->prepare($GLOBALS['SQL']->search_users);
	//Формируем строку для поиска по пользователям, удаляем символ хештега
	$search = str_replace('#', '', $search);

	if(!$sql->execute(['%' . $search . '%','%' . $search . '%']))
		return faslse;

	$result = $sql->fetchAll(PDO::FETCH_ASSOC);
	//Проверяем, нашлись ли пользователи
	if(count($result) > 0)
	//Если нашлись проходимся по каждому и формируем html
	foreach ($result as $value) {
		//Проверяем есть ли у пользователя имя
		if($value['name'] == null){

			$item = "<a href='http://instagram/user/{$value['login']}/'><li><img src='/img/users_avatar/{$value['avatar']}' alt=''><div>";
			$item .= "<p class='login'>{$value['login']}</p></div></li></a>";

		}else{

			$item = "<a href='http://instagram/user/{$value['login']}/'><li><img src='/img/users_avatar/{$value['avatar']}' alt=''><div>";
			$item .= "<p class='login'>{$value['login']}</p>";
			$item .= "<p class='name'>{$value['name']}</p></div></li></a>";

		}

		$final_result[] = $item;
	}

	//Извлекаем хештеги, соответствующие поиску
	$sql = $connection->prepare($GLOBALS['SQL']->search_hashtags);

	if(!$sql->execute(['%#' . $search . '%']))
		return false;

	$hashtags = $sql->fetchAll(PDO::FETCH_ASSOC);
	//Проверяем есть ли хештеги
	if(!empty($hashtags)){
		//Получаем количество публикаций определенного хештега
		$count_pub_in_hashtag = count($hashtags);
		//Формируем паттерн, для извлечение хештега которого искали из строки хештегов БД
		$pattern = sprintf("/(#%s[^,]*)/su", $search);
	
		preg_match($pattern, $hashtags[0]['hashtag'], $m);
		$filter_hashtag = $m[1]; //Получаем нужный хештег
		//Кодируем русскую букву х
		$url_hashtag = str_replace(['#', 'х'], ['', ']}]'], $filter_hashtag);

		//Формируем html хештега
		$item = "<a href='http://instagram/search/{$url_hashtag}/'><li><img src='/img/cyte/hashtag.jpeg' alt=''><div>";
		$item .= "<p class='login'>{$filter_hashtag}</p>";
		$item .= "<p class='name'><span>{$count_pub_in_hashtag}</span> публикаций</p></div></li></a>";

		$final_result[] = $item;
	}
	return $final_result;
}
 
//Извлекает публикации по хештегу
function getPublicationInHashtag(PDO $connection, $hashtag)
{
	$sql = $connection->prepare($GLOBALS['SQL']->select_publication_in_hashtag);

	$hashtag_sql = '%' . $hashtag . '%'; //Формируем параметр для вставки в запрос

	if(!$sql->execute([$hashtag_sql]))
		return false;

	$data = $sql->fetchAll(PDO::FETCH_ASSOC);
	//Проходимся по всем публикациям и получаем внешние id
	foreach ($data as  $value) {
		$dat[] = $value['parent_id_publication'];
	}
	//Получаем количество публикаций
	$count_publication = count($data);
	//Подготавливаем количество параметров в запросе
	$sql_param =  implode(',', explode(' ', trim(str_repeat('? ', $count_publication))));

	$select_publication = "SELECT * FROM publications WHERE id IN($sql_param)";
	$sql = $connection->prepare($select_publication);

	if(!$sql->execute($dat))
		return false;

	$d = $sql->fetchAll(PDO::FETCH_ASSOC);

	$sql = $connection->prepare($GLOBALS['SQL']->select_count_comment);

		if(count($d) > 0){
			//Если есть публикации, проходим по каждой и извлекаем количество комментариев
			foreach ($d as $value) {
				$sql->execute([$value['id']]);
				$count_comment = $sql->fetch(PDO::FETCH_ASSOC);
				$value['comment'] = $count_comment['COUNT(*)'];
				$result[] = $value;
			}
		}
	return $result;
}

//Удаляет публикацию
function deletePublication(PDO $connection, $public_id_publication)
{
	$sql = $connection->prepare($GLOBALS['SQL']->select_pub_public_id);

	if(!$sql->execute([$public_id_publication]))
		return false;

	$publication = $sql->fetch(PDO::FETCH_ASSOC);

	//Удаляем фотографию публикации
	unlink('img/users_publications/' . $publication['img']);

	$sql = $connection->prepare($GLOBALS['SQL']->decrement_count_publications);

	if(!$sql->execute([$publication['parent_id']]))
		return false;

	$sql = $connection->prepare($GLOBALS['SQL']->delete_publication);

	if(!$sql->execute([$public_id_publication]))
		return false;

	return true;
}