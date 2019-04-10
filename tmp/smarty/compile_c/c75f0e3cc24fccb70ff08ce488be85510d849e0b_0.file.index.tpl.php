<?php
/* Smarty version 3.1.33, created on 2019-04-10 09:35:55
  from 'C:\OSPanel\domains\instagram\views\default\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5cad8ecb2c7b12_72807341',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c75f0e3cc24fccb70ff08ce488be85510d849e0b' => 
    array (
      0 => 'C:\\OSPanel\\domains\\instagram\\views\\default\\index.tpl',
      1 => 1554878112,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5cad8ecb2c7b12_72807341 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='body_document'>
	<div id='center_content'>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['publications']->value, 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>
		<div class='publication' id='<?php echo $_smarty_tpl->tpl_vars['value']->value['public_id'];?>
'>
			<div class='header_block'>
				<a href='http://instagram/user/<?php echo $_smarty_tpl->tpl_vars['value']->value['login'];?>
/'>
					<img src='/img/users_avatar/<?php echo $_smarty_tpl->tpl_vars['value']->value['avatar'];?>
' alt='' >
					<p id='user_login'><?php echo $_smarty_tpl->tpl_vars['value']->value['login'];?>
</p>	
				</a>
			</div>
			<div class='image_publication' ondblclick="<?php echo $_smarty_tpl->tpl_vars['value']->value['dbl_click_like'];?>
" onselectstart="return false" onmousedown="return false">
				<img src='/img/users_publications/<?php echo $_smarty_tpl->tpl_vars['value']->value['img'];?>
' alt=''>
				<div id='background'>
					<img src="/img/cyte/heart_white.png" id='heart'>
				</div>
			</div>
			<div class='buttons_likes'>
				<?php echo $_smarty_tpl->tpl_vars['value']->value['button_like'];?>

				<button onclick="setFocus(event)">
					<img src='/img/cyte/comment.png' alt=''>
				</button>
				<p class='count_likes'>
					<span id='likes'><?php echo $_smarty_tpl->tpl_vars['value']->value['likes'];?>
</span>
					<span> отметок "Нравится"</span>
				</p>
				<p class='article_publication'><?php echo $_smarty_tpl->tpl_vars['value']->value['title'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['value']->value['hashtags'];?>
</p>
				<?php echo $_smarty_tpl->tpl_vars['value']->value['visible_comment'];?>

			</div>
			<div class='list_comments'>
				<ul> <!-- Изначально отображается 4 комментария -->
					<?php if (is_array($_smarty_tpl->tpl_vars['value']->value['comment'])) {?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['value']->value['comment'], 'comment');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['comment']->value) {
?>
					<li id='<?php echo $_smarty_tpl->tpl_vars['comment']->value['id'];?>
'>
						<p>
							<a href="http://instagram/user/<?php echo $_smarty_tpl->tpl_vars['comment']->value['login'];?>
/">
								<span class='login'><?php echo $_smarty_tpl->tpl_vars['comment']->value['login'];?>
</span>
							</a>
							<span class='article'>&nbsp;<?php echo $_smarty_tpl->tpl_vars['comment']->value['comment'];?>
</span>
						</p>
						<?php echo $_smarty_tpl->tpl_vars['comment']->value['button_like'];?>

					</li>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					<?php }?>
				</ul>
			</div>
			<div class='pub_date'>
				<p><?php echo $_smarty_tpl->tpl_vars['value']->value['pub_date'];?>
</p>
			</div>
			<div class='entry_field'>
				<input type='text' id='addComment' onkeypress='addComment(event)' placeholder="Добавьте комментарий...">
			</div>
		</div>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	</div>
	<div id='right_block'>
		<div id='header_block'>
			<p id='title_block'>Рекомендации для вас</p>		
		</div>
		<div id='list_users'>
			<ul>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['recomendateUsers']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
				<li id='<?php echo $_smarty_tpl->tpl_vars['item']->value['login'];?>
'>
					<a href='http://instagram/user/<?php echo $_smarty_tpl->tpl_vars['item']->value['login'];?>
/'>
						<img src='/img/users_avatar/<?php echo $_smarty_tpl->tpl_vars['item']->value['avatar'];?>
' alt=''>
						<p><?php echo $_smarty_tpl->tpl_vars['item']->value['login'];?>
</p>
					</a>
					<button class='show' onclick='subscribe(event)' id='sub'>Подписаться</button>
				</li>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>				
			</ul>
		</div>
	</div>
</div>
<?php echo '<script'; ?>
 type="text/javascript" src='/js/index_page.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src='/js/users_script.js'><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
	//Отслеживаем скрол мыши, чтобы закрепить правое меню
	$(document).ready(function(){
		var offset = $('#right_block').offset();
		$(window).scroll(function(){
			if($(window).scrollTop() > offset.top){
				$('#right_block').css({'position': 'fixed', 'top': 50, 'left': offset.left - 30});
			}else{
				$('#right_block').css({'position': 'static', 'margin-top': 10});
			}
		});
	});	
<?php echo '</script'; ?>
>
<?php }
}
