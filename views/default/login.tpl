<!DOCTYPE html>
<html>
<head>
	<title>Вход</title>
	<meta charset='utf-8'>
	<link rel="shortcut icon" href="/img/cyte/logo.ico"  type="image/x-icon">
	<script src='/js/users_script.js'></script>
	<script src='/js/jquery.js'></script>
	<link rel='stylesheet' href='/default/css/authorize.css'>
</head>
<body>

	<script type="text/javascript">
	{literal}
	function theRotator() {
		// Устанавливаем прозрачность всех картинок в 0
		$('#phone_block ul li').css({opacity: 0.0});
	 
		// Берем первую картинку и показываем ее (по пути включаем полную видимость)
		$('#phone_block ul li:first').css({opacity: 1.0});
		// Вызываем функцию rotate для запуска слайдшоу, 5000 = смена картинок происходит раз в 5 секунд
		setInterval('rotate()',5000);
	}
 
	function rotate() {	
		// Берем первую картинку
		var current = ($('#phone_block ul li.show')?  $('#phone_block ul li.show') : $('#phone_block ul li:first'));

		// Берем следующую картинку, когда дойдем до последней начинаем с начала
		var next = ((current.next().length) ? ((current.next().hasClass('show')) ? $('#phone_block ul li:first') :current.next()) : $('#phone_block ul li:first'));	
	 
		// Подключаем эффект растворения/затухания для показа картинок, css-класс show имеет больший z-index
		next.css({opacity: 0.0})
		.addClass('show')
		.animate({opacity: 1.0}, 2000);
	 
		// Прячем текущую картинку
		current.animate({opacity: 0.0}, 2000)
		.removeClass('show');
	};
	 
	$(document).ready(function() {		
		// Запускаем слайдшоу
		theRotator();
	});
	{/literal}
	</script>



	<div id='main'>



		<div id='phone_block'>
			<img src="/img/cyte/xiaomi.png" alt=''>
			<ul>
				<li class='show'><img src="/img/cyte/1.jpg" alt=''></li>
				<li><img src="/img/cyte/2.jpg" alt=''></li>
				<li><img src="/img/cyte/3.jpg" alt=''></li>
				<li><img src="/img/cyte/4.jpg" alt=''></li>
				<li><img src="/img/cyte/5.jpg" alt=''></li>
				<li><img src="/img/cyte/6.jpg" alt=''></li>
				<li><img src="/img/cyte/7.jpg" alt=''></li>
			</ul>
		</div>



		<div id='block_authorize'>
			
				<h1>Insta2.0</h1>
				<form id='form_register'>
					<input type='text' class='field' name='login_mail' value="{$login_mail}" placeholder='Логин или электронная почта'><br>
					<input type="password" class='field' name='password' value="{$password}" placeholder="Пароль"><br>
					<span id='error'></span>
					<input type="button" value="Войти" id='send' onclick='loginUser()'>

				</form>
				<div id='login_social'>
					<p>Еще нет аккаунта?</p><a href='http://instagram/' id='login_system'>Зарегистрируйтесь</a><br>
					<button id='btn_restore_pass' onclick='showFormResetPass(); return false;'>Забыли пароль?</button>
				</div>
			
			<div id='form_restore_password' class="hidden">
				<h2>Введите имя пользователя или электронный адрес, и мы отправим вам ссылку для восстановления доступа к аккаунту.</h2>
				<p id='error_input' class="hidden">Нужно заполнить поле</p>
				<p id='error_user' class="hidden">Пользователь не найден</p>
				<input type="text" id='login_mail' placeholder="Введите логин или email">
				<input type="button"  id='send_email' onclick='sendMsgRestore()' value="Получить код восстановления">
				<button id='exit_restore_form' onclick='backLogin()'>Назад к входу</button>
			</div>
			<h2 id='success_msg' class="hidden">Сообщение с кодом восстановления отправлено. Проверьте Вашу почту.</h2>
		</div>
	</div>
</body>
</html>