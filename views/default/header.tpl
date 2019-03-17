<!DOCTYPE html>
<html>
<head>
	<title>{$title}</title>
	<link href='{$TemplateWebPath}/css/main.css' rel='stylesheet'>
	
	<link rel='stylesheet' href='/fontawesome/css/all.css'>
	<script src='/js/jquery.js' type='text/javascript'></script>
	<script src='/js/main.js' type='text/javascript'></script>
	<script type="text/javascript">
		
	</script> 
	<meta charset="utf-8">
</head>
<body lang="ru">
	<header>
		<p id='p'></p>
		<div id='header_content'>
			<h1><a href='http://instagram/'>Instagram</a></h1>
			<form id='searh_form'>
				<input type="text" name="searh" placeholder="Поиск">
				<input type="submit" name="sub" value='Найти'>
			</form>
			<div id='userInfo'>
				<img src='{$userAvatarPath}' alt='asdsa' height="20">
				<a href='{$urlProfile}' id='my+login'>{$userLogin}</a>
			</div>
		</div>
	</header>
	<a href='http://instagram/login/logOut/'>Выйти</a>
	
	
