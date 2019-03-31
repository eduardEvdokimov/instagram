<!DOCTYPE html>
<html>
<head>
	<title>{$user.login}</title>
	<link href='{$TemplateWebPath}/css/main.css' rel='stylesheet'>
	<link href='{$TemplateWebPath}/css/main_page.css' rel='stylesheet'>
	<link rel='stylesheet' href='/fontawesome/css/all.css'>
	<link rel='stylesheet' href='{$TemplateWebPath}/css/list_users.css'>
	<script src='/js/jquery.js' type='text/javascript'></script>
	<script src='/js/main.js' type='text/javascript'></script>
	<link href="https://fonts.googleapis.com/css?family=Srisakdi" rel="stylesheet">
	<meta charset="utf-8">

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
</head>
<body lang="ru">
	<header>
		<p id='p'></p>
		<div id='header_content'>
			<h1><a href='http://instagram/'>Instagram</a></h1>
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
				<img src='{$myAvatarPath}' alt='asdsa' height="20">
				<a href='{$myUrlProfile}' id='my_login'>{$myLogin}</a>
			</div>
		</div>
	</header>
	
	
	
