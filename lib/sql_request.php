<?php

class SqlRequest{
	//Извлекаем мыло для проверки, есть ли такой пользоватль
	public $sql_check_mail = 'SELECT * FROM mails WHERE `mail`=?';
	// запрос на добавление в БД users
	public $sql_users_DB = 'INSERT INTO users (`login`, `name`, `password`, `confirmed`, `avatar`) VALUES (?,?,?,?,?)'; 
	// запрос на добавление в БД mails
	public $sql_mails_DB = 'INSERT INTO mails (`parent_id`, `mail`) VALUES (?,?)';
	// запрос на извлечение из БД добавленного пользователя
	public $sql_get_last_Insert_user = 'SELECT * FROM users WHERE id=?'; 
	//заврос на извлечение пользователя по мылу
	public $sql_select_user_from_mail = 'SELECT * FROM users WHERE id=?';
	//Возвращает поле с подпиской пользоваетя
	public $sql_check = 'SELECT * FROM subscribers WHERE `id_subscriber`=? AND `sub_object`=?';
	//Удаляет подписку на пользоваеля
	public $sql_drop_sub = 'DELETE FROM subscribers WHERE `id_subscriber`=? AND `sub_object`=?';
	//Добавление подписки на пользователя
	public $sql_add_sub = 'INSERT INTO subscribers (`id_subscriber`, `sub_object`) VALUES (?,?)';
	//запрос на извлечение пользователя из БД по логину 
	public $sql_select_user = 'SELECT * FROM users WHERE login=?';
	//запрос на извлечение мыла из БД
	public $sql_select_mail = 'SELECT * FROM mails WHERE mail=?';
	//Зпрос обновления статуса аккаунта
	public $sql_update = 'UPDATE users SET `confirmed`=1 WHERE `confirmed`=?';
	//Запрос на выборку логинов
	public $sql_check_login = 'SELECT COUNT(`login`) FROM users WHERE `login`=?';
	//Добавление пользователя в БД, по данным из соц.сети ВК
	public $insert_user_vk = 'INSERT INTO users (`login`, `name`, `password`, `avatar`, `confirmed`) VALUES (?,?,?,?,?)';
	//Добавление мыла пользователя из ВК
	public $insert_user_mail_vk = 'INSERT INTO mails (`parent_id`, `mail`) VALUES (?,?)';
	//Извлечение пользователя по id
	public $insert_user_by_id = 'SELECT * FROM users WHERE id=?';
	//Добавление публикации
	public $sql_add_publication = 'INSERT INTO publications (`public_id`, `parent_id`, `img`, `title`) VALUES (?,?,?,?)';
	//Добавление хештега
	public $sql_add_hashtag = 'INSERT INTO hashtags (`parent_id_publication`, `hashtag`) VALUES (?,?)';
	//Извлечение 12 последнедобавленных публикаций пользователя
	public $select_user_publications = 'SELECT * FROM publications WHERE parent_id=?  ORDER BY pub_date DESC LIMIT 12';
	//Возвращает количество комментариев для определенной публикации
	public $select_count_comment = 'SELECT COUNT(*) FROM comments WHERE parent_id_publication=?';
	
	//Извлечение публикации по public_id
	public $select_pub_public_id = 'SELECT * FROM publications WHERE public_id=?';
	//Извлечение хештегов отдельной публикации
	public $select_hastags_pub = 'SELECT hashtag FROM hashtags WHERE parent_id_publication=?';
	//Извлечение из 2-х таблиц (users, comments) комментариев и их авторов определенной публикации
	public $select_comment_pub = 'SELECT comments.*, users.login FROM comments, users WHERE comments.parent_id_publication=? AND users.id=comments.parent_id_user ORDER BY pub_date DESC';

	//Извлечение пользователя по логину
	public $select_user_from_login = 'SELECT * FROM users WHERE login=?';
	//Добавляет запись в таблицу comments
	public $add_comment = 'INSERT INTO comments (`parent_id_user`, `parent_id_publication`, `comment`) VALUES (?,?,?)';

	//Извлекает все из таблицы likes_publications и id из таблицы publications по id. 
	//Нужно для проверки лайкал ли пользователь данную публикацию или нет
	public $check_line_like = 'SELECT likes_publications.*, publications.id FROM likes_publications, publications WHERE publications.public_id=? AND likes_publications.user_id=? AND likes_publications.publication_id=publications.id';
	//Извлекает поле из таблицы likes_comments. Для проверки лайкал ли пользователь данный комментарий
	public $check_press_like_comm = 'SELECT * FROM likes_comments WHERE id_user=? AND id_comment=?';
	//Идаляет запись из таблицы likes_comments
	public $drop_like_comment = 'DELETE FROM likes_comments WHERE id_user=? AND id_comment=?';
	//Уменьшает количество лайков комментария на 1
	public $decrement_like_comment = 'UPDATE comments SET likes = likes - 1 WHERE id=?';
	//Добавляет поле в таблицу likes_comments
	public $add_like_comment = 'INSERT INTO likes_comments VALUES (?,?)';
	//Увеличивает количество лайков у комментария на 1
	public $increment_like_comment = 'UPDATE comments SET likes = likes + 1 WHERE id=?';
	//Добавление поля в таблицу likes_publications
	public $add_like_publication = 'INSERT INTO likes_publications VALUES (?,?)';
	//Увеличение лайков у публикации
	public $increment_like = 'UPDATE publications SET likes = likes + 1 WHERE id=?';
	//Удаление поля из таблицы likes_publications
	public $del_like_publication = 'DELETE FROM likes_publications WHERE user_id=? AND publication_id=?';
	//Уменьшение количества лайков публикации
	public $decrement_likes = 'UPDATE publications SET likes = likes - 1 WHERE id=?';
	//Увеличавает количество подписчиков на 1 у пользователя
	public $add_update_count_subscribers = 'UPDATE users SET count_subscribers = count_subscribers + 1 WHERE id=?';
	//Увеличивает количество подписок на 1 у пользователя
	public $add_update_count_subscriprions = 'UPDATE users SET count_subscriptions = count_subscriptions + 1 WHERE id=?';
	//Уменьшает количество подписчиков на 1
	public $del_update_count_subscribers = 'UPDATE users SET count_subscribers = count_subscribers - 1 WHERE id=?';
	//Уменьшает количество подписок на 1
	public $del_update_count_subscriprions = 'UPDATE users SET count_subscriptions = count_subscriptions - 1 WHERE id=?';
	//Увеличиваем количество публикаций на 1
	public $add_count_publications = 'UPDATE users SET count_publications = count_publications + 1 WHERE id=?';
}