<!DOCTYPE html>
<html>
<head>
	<title>Instagram</title>
	<script src='js/users_script.js'></script>
	<script src='js/jquery.js'></script>
	<script src="https://vk.com/js/api/openapi.js?160" type="text/javascript"></script>
</head>
<body>
	<div id='block_register'>
		<h1>Форма регистрации</h1>
		<img href='#' alt=''>
		<div>
			<form id='form_register'>
				<span id='mail'></span>
				<input type='text' name='mail' placeholder='Электронный адрес*'><br>
				<input type='text' name='name' placeholder='Имя и фамилия'><br>
				<span id='login'></span>
				<input type='text' name='login' placeholder='Логин*'><br>
				<span id='password'></span>
				<input type='password' name='password' placeholder="Пароль*"><br>
				<input type='button' value="Регистрация" onclick='registerUser()'>
				<div id='message'></div>
			</form>
			<p>Есть аккаунт?</p>
			<a href='http://instagram/login/index/'>Войти</a>
			<a href='https://oauth.vk.com/authorize?client_id={$ID}&redirect_uri={$URL}&scope=4194304&response_type=code&v=5.52' target='_blank'>Войти через ВК</a>
		</div>
	</div>
	<div id='block_confirm_account' hidden="">
		<h1>Вы успешно зарегистрировались</h1>
		<p>На вашу электронную почту было отправлено сообщение с ссылкой для подтверждения аккаунта</p>
		<a href='https://mail.ru'>Перейти на почту</a>
	</div>
</body>
</html>