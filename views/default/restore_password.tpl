<!DOCTYPE html>
<html>
<head>
	<title>Восстановление пароля</title>
	<script type="text/javascript" src='/js/users_script.js'></script>
	<script type="text/javascript" src='/js/jquery.js'></script>
	<link rel="stylesheet" type="text/css" href="/default/css/authorize.css">
	<link rel="shortcut icon" href="/img/cyte/logo.ico"  type="image/x-icon">
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


	<div id='block_authorize' >
		<h1>Insta2.0</h1>
		<h2>Восстановление пароля</h2>
		<input type="text" class='field' placeholder="Новый пароль" id='new_password'>
		<input type="text" class='field' placeholder="Повторите пароль" id='repeat_password'>
		<p id='error_msg'></p>
		<button onclick='saveNewPassword()' id='send'>Сохранить</button>
	</div>
</body>
</html>