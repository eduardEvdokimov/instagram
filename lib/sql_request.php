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
	public $sql_add_publication = 'INSERT INTO publications (`parent_id`, `img`, `title`) VALUES (?,?,?)';
	//Добавление хештега
	public $sql_add_hashtag = 'INSERT INTO hashtags (`parent_id_publication`, `hashtag`) VALUES (?,?)';

}