<?php
/* Smarty version 3.1.33, created on 2019-04-10 11:31:10
  from 'C:\OSPanel\domains\instagram\views\default\settings.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5cada9ce7c59a2_24190577',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a44f4af5865400d77fbebacbc42a69ac6a0944aa' => 
    array (
      0 => 'C:\\OSPanel\\domains\\instagram\\views\\default\\settings.tpl',
      1 => 1554881479,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5cada9ce7c59a2_24190577 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
<head>
	<title>Радактирование профиля</title>
	<link href='<?php echo $_smarty_tpl->tpl_vars['TemplateWebPath']->value;?>
/css/main.css' rel='stylesheet'>
	<link rel='stylesheet' href='/fontawesome/css/all.css'>
	<?php echo '<script'; ?>
 src='/js/main.js' type='text/javascript'><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src='/js/jquery.js' type='text/javascript'><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src='/js/settings.js'><?php echo '</script'; ?>
>
	<link rel="shortcut icon" href="/img/cyte/logo.ico"  type="image/x-icon">
	<?php echo '<script'; ?>
 type='text/javascript'>
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
	<?php echo '</script'; ?>
>
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
					<?php echo $_smarty_tpl->tpl_vars['count_notification']->value;?>

				</p>
				<div id='window_notification' class="hidden">
					<ul>
						
					</ul>
				</div>
				<a href='<?php echo $_smarty_tpl->tpl_vars['myUrlProfile']->value;?>
' id='my_login'><?php echo $_smarty_tpl->tpl_vars['myLogin']->value;?>
</a>
				<img src='<?php echo $_smarty_tpl->tpl_vars['myAvatarPath']->value;?>
' alt=''>
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
					<img src='/img/users_avatar/<?php echo $_smarty_tpl->tpl_vars['user']->value['avatar'];?>
' alt=''>
					<p id='login'><?php echo $_smarty_tpl->tpl_vars['user']->value['login'];?>
</p>
					<input id='file' type="file" name="file" onchange="changeAvatar(event)">
					<p class='hidden'>Нужно выбрать картинку</p>
				</li>
				<li>
				<input class='pole' value='<?php echo $_smarty_tpl->tpl_vars['user']->value['name'];?>
' type="text" name="name" autocomplete="off">	<p class='label'>Имя</p>
				</li>
				<li>
					<p id='login_error_kirilica' class='hidden error'>Логин не должен содержать символов кирилицы</p>
					<p id='login_error_min_size' class='hidden error'>Слишком короткий логин</p>
					<p id='login_error' class='hidden error'>Пользователь с данным логином уже существует</p>
				<input class='pole' id='input_login' value="<?php echo $_smarty_tpl->tpl_vars['user']->value['login'];?>
" type="text" name="login" onkeyup="heckLogin(event)" autocomplete="off">	<p class='label'>Логин</p>
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
					<input class='pole' value="<?php echo $_smarty_tpl->tpl_vars['user']->value['web_cyte'];?>
" type="text" name="web_cyte" autocomplete="off"><p class='label'>Веб-сайт</p>
				</li>
				<li>
					<textarea name='about' class='pole'><?php echo $_smarty_tpl->tpl_vars['user']->value['about'];?>
</textarea><p class='label'>О себе</p>
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
</html><?php }
}
