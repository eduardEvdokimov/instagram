<!DOCTYPE html>
<html>
<head>
	<title>Вход</title>
	<meta charset='utf-8'>
	<script src='/js/main.js'></script>
	<script src='/js/jquery.js'></script>
</head>
<body>
	<h1>Вход</h1>
	<div id='block_login'>
		<form id='form_login'>
			<input type='text' name='login_mail' value="{$login_mail}" placeholder='Логин или электронная почта'><br>
			<input type="password" name='password' value="{$password}" placeholder="Пароль"><br>
			<span id='error'></span>
			<input type="button" value="Войти" onclick='loginUser()'><br>
			<span>Еще нет аккаунта? <a href='http://instagram/'>Зарегистрируйтесь</a></span>
		</form>
	</div>
</body>
</html>