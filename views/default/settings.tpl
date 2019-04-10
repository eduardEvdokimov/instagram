<!DOCTYPE html>
<html>
<head>
	<title>Радактирование профиля</title>
	<link href='{$TemplateWebPath}/css/main.css' rel='stylesheet'>
	<link rel='stylesheet' href='/fontawesome/css/all.css'>
	<script src='/js/main.js' type='text/javascript'></script>
	<script src='/js/jquery.js' type='text/javascript'></script>
	<script type="text/javascript" src='/js/settings.js'></script>
	<link rel="shortcut icon" href="/img/cyte/logo.ico"  type="image/x-icon">
	<script type='text/javascript'>
		$(document).ready(function(){
			$(document).click(function(event){
				var element = event.target;

				if(element.id == 'notification')
					return;
				if(element.closest('#window_notification'))
					return;

				if(element.id == 'search')
					return;
				
				$('#form_search > ul').html('').addClass('hidden');

				$('#window_notification').addClass('hidden');
				$('#window_notification > ul').html('');
			});
		});
	</script>
	<meta charset="UTF-8">
</head>
<body lang="ru">
	<header>
		<p id='p'></p>
		<div id='header_content'>
			<h1><a href='http://instagram/'>Insta2.0</a></h1>
				<div id='form_search'>
					<input type="text" id='search' placeholder="Поиск" autocomplete="off" onkeyup="search(event);">
					
					<ul class="hidden">
				
					</ul>
				</div>
			<div id='userInfo'>
				<p id='notification' onclick="showNotification();" title='Уведомления'>
					<i class="fas fa-bell"></i>
					{$count_notification}
				</p>
				<div id='window_notification' class="hidden">
					<ul>
						
					</ul>
				</div>
				<a href='{$myUrlProfile}' id='my_login'>{$myLogin}</a>
				<img src='{$myAvatarPath}' alt=''>
			</div>
		</div>
	</header>

	<div id='backgroud_form_settings'>
		<div id='head'>
			<h2>Редактировать профиль</h2>
		</div>
		<div id='form_settings'>
			<ul>
				<li>
					<img src='/img/users_avatar/{$user.avatar}' alt=''>
					<p id='login'>{$user.login}</p>
					<input id='file' type="file" name="file" onchange="changeAvatar(event)">
					<p class='hidden'>Нужно выбрать картинку</p>
				</li>
				<li>
				<input class='pole' value='{$user.name}' type="text" name="name" autocomplete="off">	<p class='label'>Имя</p>
				</li>
				<li>
					<p id='login_error_kirilica' class='hidden error'>Логин не должен содержать символов кирилицы</p>
					<p id='login_error_min_size' class='hidden error'>Слишком короткий логин</p>
					<p id='login_error' class='hidden error'>Пользователь с данным логином уже существует</p>
				<input class='pole' id='input_login' value="{$user.login}" type="text" name="login" onkeyup="heckLogin(event)" autocomplete="off">	<p class='label'>Логин</p>
				</li>
				<li>
					<p id='pass_error' class='hidden error'>Проверьте правильность введенного пароля</p>
				<input class='pole' type="password" id="old_pass" name="old_pass" autocomplete="off" onkeyup="heckPassword(event)" placeholder="Вход ВК? Введите здесь логин.">	<p class='label'>Старый пароль</p>
				</li>
				<li>
					<p id='new_pass_error' class="hidden error">Слишком короткий пароль</p>
					<input id='new_pass' class='pole' type="password" name="new_pass" autocomplete="off"><p class='label'>Новый пароль</p>
				</li>
				<li>
					<input class='pole' value="{$user.web_cyte}" type="text" name="web_cyte" autocomplete="off"><p class='label'>Веб-сайт</p>
				</li>
				<li>
					<textarea name='about' class='pole'>{$user.about}</textarea><p class='label'>О себе</p>
				</li>
				<li>
					<p class='hidden success'>Данные успешно сохранены</p>
					<p class='hidden error_form'>Не удалось сохранить данные</p>
					<button onclick='saveChangeSettings(event)' id='btn_save'>Сохранить</button>
				</li>
			</ul>
		</div>

	</div>

</body>
</html>