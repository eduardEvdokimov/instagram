<?php
/* Smarty version 3.1.33, created on 2019-04-10 10:31:22
  from 'C:\OSPanel\domains\instagram\views\default\user_page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5cad9bcad77f70_76022079',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2b4777a1b4add9991dfc7d11d2cf61ed34482a80' => 
    array (
      0 => 'C:\\OSPanel\\domains\\instagram\\views\\default\\user_page.tpl',
      1 => 1554881480,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5cad9bcad77f70_76022079 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='user_info_block'>
	<div id='user_content'>
		<img src='/img/users_avatar/<?php echo $_smarty_tpl->tpl_vars['user']->value['avatar'];?>
' alt=''>
		<div id='user_info'>
			<div id='header_block_user_info'>
				<p id='login_user'><?php echo $_smarty_tpl->tpl_vars['user']->value['login'];?>
</p>
				<input type='hidden' id='sub_object' value="<?php echo $_smarty_tpl->tpl_vars['sub_object']->value;?>
">
				<?php echo $_smarty_tpl->tpl_vars['buttonSub']->value;?>

				<?php echo $_smarty_tpl->tpl_vars['buttonUnSub']->value;?>

				<?php echo $_smarty_tpl->tpl_vars['dropDownList']->value;?>

			</div>
			<p class='count_info' style="cursor: text"><span class='number'><?php echo $_smarty_tpl->tpl_vars['user']->value['count_publications'];?>
</span>&nbsp;публикаций</p>
			<p class='count_info' name='subscribers' onclick='showWindowListUsers(event);'><span class='number'><?php echo $_smarty_tpl->tpl_vars['user']->value['count_subscribers'];?>
</span>&nbsp;подписчиков</p>
			<p class='count_info' name='subscriptions' onclick='showWindowListUsers(event);'><span class='number'><?php echo $_smarty_tpl->tpl_vars['user']->value['count_subscriptions'];?>
</span>&nbsp;подписок</p>
		</div>
		<div id='about_block'>
			<p><?php echo $_smarty_tpl->tpl_vars['user']->value['name'];?>
</p>
			<p><?php echo $_smarty_tpl->tpl_vars['user']->value['about'];?>
</p>
			<p><?php echo $_smarty_tpl->tpl_vars['user']->value['web_cyte'];?>
</p>
		</div>
	</div>
</div>
<div id='bg_popup_window' class="hidden">
	<div id='popup_window_user_list'>
		<div id='head'>
			<h2></h2>
		</div>
		<div id='list_users'>
			<ul>				
			</ul>
		</div>
	</div>
</div>
<div id='background_form' class='hidden'>
	<div id='form_publications'>
		<div id='form'>
			<p>Добавьте фотографию</p>
			<input type='file' name='file' id='file' multiple="">
			<p>Описание</p>
			<textarea name="article" id='article' rows='5' cols="30"></textarea>
			<p>Хештеги</p>
			<textarea name='hashtags' id='hashtags' rows='5' cols="30"></textarea>
			<p id='message'></p>
			<button name="Опубликовать" onclick='addPublication();' id='send'>Опубликовать</button>
			
		</div>
	</div>
</div>	
<p id='p'></p>
<div class='table_publications'>
	<div class='center_content' onclick='showBigPublication(event);'>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['publications']->value, 'value', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
			<div class='item_publication' id="<?php echo $_smarty_tpl->tpl_vars['value']->value['public_id'];?>
">
				<img src="/img/users_publications/<?php echo $_smarty_tpl->tpl_vars['value']->value['img'];?>
"  alt=''>
				<div class='background_publication' >
					<?php echo $_smarty_tpl->tpl_vars['btn_delete_publication']->value;?>

					<p class='likes_comment'>
						<span><i class="fas fa-heart">&nbsp;<span><?php echo $_smarty_tpl->tpl_vars['value']->value['likes'];?>
</span></i></span>
						<span><i class="fas fa-comment">&nbsp;<span><?php echo $_smarty_tpl->tpl_vars['value']->value['comment'];?>
</span></i></span>
					<p>
				</div>
			</div>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	</div>
<div>
<div id='bg_popup_confirmation' class="hidden">
	<div id='form'>
		<div id='msg_btn_confirmed'>
			<p>Вы точно хотите удалить публикацию. Ее нельзя будет восстановить.</p>
			<input type="hidden" id='' class='public_id_publication_delete'>
			<button onclick='deletePublication(event)' id='delete' class="btn">Удалить</button>
			<button id='cancel' class="btn" onclick='deletePublication(event)'>Отмена</button>
		</div>
		<p id='msg_confirmed' class='hidden'>Публикация успешно удалена.</p>
	</div>
</div>





<div class='hidden' id='background_window_pub'>
	<div class='visible_big_publication' id=''>
		<img src='' alt='' id='photo_publication'>
		<div id='right_block_pub'>
			<div id='head_window'>
				<a href='#'>
					<img src='' alt='' id='user_avatar'>
					<p id='user_login'></p>
				</a>
			</div>
			<p id='article_publication'></p>
		
			<div class='hashtags'></div>
			
			<ul id='list_comments'>
			</ul>
			
			<div id='buttons'>
				<button id='button_like'><img src='/img/cyte/heart.png' alt=''></button>
				<button onclick="setFocus('#addComment')"><img src='/img/cyte/comment.png' alt=''></button>
				<p><span></span> отметок "Нравится"</p>
				<p id='pub_date'></p>
			</div>
			<input type="text" name="" id='addComment' onkeypress='addComment(event)'  placeholder="Добавьте комментарий...">
		
</div>

<?php echo '<script'; ?>
 type='text/javascript' src='/js/publications_script.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='/js/users_script.js'><?php echo '</script'; ?>
>


<?php echo '<script'; ?>
 type="text/javascript">
			$(document).ready(function(){
				var show = false;
				//Блок отображение/скрытия выпадающего списка
				$(document).click(function(event){
					//Проверка на нажатие кнопки выпадающего списка
					if((event.target.getAttribute('class') == 'fas fa-angle-down') || (event.target.id == 'list_down')){
						//Если нажали на нее, показываем список и останавливаем скрипт
						//Проверяем был ли список ранее показан
						if(show == true){
							//Если да то скрываем список и переводим переключатель в false
							$('#list_down .show').removeClass('show').addClass('hidden');
							show = false;
							return;
						}else{
							//Если нет то показываем список и переводим переключатель в true
							$('#list_down ul').removeClass('hidden').addClass('show');
							show = true;
							return;
						}
					}

					//Проверяем нажали ли на элемент выпадающего списка
					if(event.target.closest('.show_item'))
						//Если нажали, останавливаем скрипт
						return;

					//Если нажали на все кроме выпадающего списка, скрываем список
					$('#list_down .show').removeClass('show').addClass('hidden');
					show = false; //Переводим переключатель в false
				});
			});
<?php echo '</script'; ?>
><?php }
}
