<?php
/* Smarty version 3.1.33, created on 2019-04-10 10:46:55
  from 'C:\OSPanel\domains\instagram\views\default\register.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5cad9f6f9b6f80_33457462',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'de6e949d2b3b2594fe16e28128b4a26cad769a93' => 
    array (
      0 => 'C:\\OSPanel\\domains\\instagram\\views\\default\\register.tpl',
      1 => 1554881463,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5cad9f6f9b6f80_33457462 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
<head>
	<title>Insta2.0</title>
	<link rel="shortcut icon" href="/img/cyte/logo.ico"  type="image/x-icon">
	<?php echo '<script'; ?>
 src='js/users_script.js'><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src='js/jquery.js'><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="https://vk.com/js/api/openapi.js?160" type="text/javascript"><?php echo '</script'; ?>
>
	<link rel="stylesheet" type="text/css" href="/default/css/authorize.css">
</head>
<body>
	<?php echo '<script'; ?>
 type="text/javascript">
	
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
	
	<?php echo '</script'; ?>
>
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
			<form id='form_register'>
				<span id='mail'></span>
				<input type='text' name='mail' class='field' placeholder='Электронный адрес*' autocomplete="off"><br>
				<input type='text' name='name' class='field' placeholder='Имя и фамилия' autocomplete="off"><br>
				<span id='login'></span>
				<input type='text' name='login' class='field' placeholder='Логин*' autocomplete="off"><br>
				<span id='password'></span>
				<input type='password' name='password' class='field' placeholder="Пароль*" autocomplete="off"><br>
				<input type='button' value="Регистрация" id='send' onclick='registerUser()'>
				<div id='message'></div>
			</form>
			<div id='login_social'>
				<p>Есть аккаунт?</p>
				<a href='http://instagram/login/index/' id='login_system'>Войти</a>
				<a href='https://oauth.vk.com/authorize?client_id=<?php echo $_smarty_tpl->tpl_vars['ID']->value;?>
&redirect_uri=<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
&scope=4194304&response_type=code&v=5.52' target='_blank' id='login_VK'>ВКонтакте</a>
			</div>
			<div id='block_confirm_account' class="hidden">
				<h2>Вы успешно зарегистрировались</h2>
				<p>На вашу электронную почту было отправлено сообщение с ссылкой для подтверждения аккаунта</p>
				<a id='action_mail' href='https://mail.ru'>Перейти на почту</a>
			</div>
		</div>	
	</div>
</body>
</html><?php }
}
