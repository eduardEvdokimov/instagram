<?php
/* Smarty version 3.1.33, created on 2019-04-10 10:30:31
  from 'C:\OSPanel\domains\instagram\views\default\header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5cad9b97443a26_65327731',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd40b21ca96738f86508879e1f4fe071e75edd0bb' => 
    array (
      0 => 'C:\\OSPanel\\domains\\instagram\\views\\default\\header.tpl',
      1 => 1554881430,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5cad9b97443a26_65327731 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
<head>
	<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
	<link rel="shortcut icon" href="/img/cyte/logo.ico"  type="image/x-icon">
	<link href='<?php echo $_smarty_tpl->tpl_vars['TemplateWebPath']->value;?>
/css/main.css' rel='stylesheet'>
	<link href='<?php echo $_smarty_tpl->tpl_vars['TemplateWebPath']->value;?>
/css/main_page.css' rel='stylesheet'>
	<link rel='stylesheet' href='/fontawesome/css/all.css'>
	<link rel='stylesheet' href='<?php echo $_smarty_tpl->tpl_vars['TemplateWebPath']->value;?>
/css/list_users.css'>
	<?php echo '<script'; ?>
 src='/js/jquery.js' type='text/javascript'><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src='/js/main.js' type='text/javascript'><?php echo '</script'; ?>
>
	<meta charset="utf-8">
	<?php echo '<script'; ?>
 type='text/javascript'>
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
	<?php echo '</script'; ?>
>
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
	
	
	
<?php }
}
