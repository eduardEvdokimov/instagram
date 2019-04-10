<!DOCTYPE html>
<html>
<head>
	<title>{$title}</title>
	<link rel="shortcut icon" href="/img/cyte/logo.ico"  type="image/x-icon">
	<link href='{$TemplateWebPath}/css/main.css' rel='stylesheet'>
	<link href='{$TemplateWebPath}/css/main_page.css' rel='stylesheet'>
	<link rel='stylesheet' href='/fontawesome/css/all.css'>
	<link rel='stylesheet' href='{$TemplateWebPath}/css/list_users.css'>
	<script src='/js/jquery.js' type='text/javascript'></script>
	<script src='/js/main.js' type='text/javascript'></script>
	<meta charset="utf-8">
	<script type='text/javascript'>
		//Отслеживание нажатия на все кроме кнопки показа уведомлений и строки поиска
		$(document).ready(function(){
			$(document).click(function(event){
				var element = event.target;

				if(element.id == 'notification')
					return;
				if(element.closest('#window_notification'))
					return;

				if(element.id == 'search')
					return;
				//Если кликнули на все, кроме поиска и уведомлений, скрываем выпадающие списки
				$('#form_search > ul').html('').addClass('hidden'); //Выпадающий список поиска
				//Окно уведомлений
				$('#window_notification').addClass('hidden');
				$('#window_notification > ul').html('');
			});
		});
	</script>
</head>
<body lang="ru">
	<header>
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
	
	
	
