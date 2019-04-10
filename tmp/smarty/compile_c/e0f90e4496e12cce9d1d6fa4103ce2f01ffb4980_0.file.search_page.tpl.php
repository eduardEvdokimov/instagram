<?php
/* Smarty version 3.1.33, created on 2019-04-10 09:33:24
  from 'C:\OSPanel\domains\instagram\views\default\search_page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5cad8e34871ed3_18866967',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e0f90e4496e12cce9d1d6fa4103ce2f01ffb4980' => 
    array (
      0 => 'C:\\OSPanel\\domains\\instagram\\views\\default\\search_page.tpl',
      1 => 1554876947,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5cad8e34871ed3_18866967 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='head2_page'>
	<h1><?php echo $_smarty_tpl->tpl_vars['hashtag']->value;?>
</h1>
	<p><span><?php echo $_smarty_tpl->tpl_vars['count_publications']->value;?>
</span> публикаций</p>
</div>
<?php echo '<script'; ?>
 type='text/javascript' src='/js/publications_script.js'><?php echo '</script'; ?>
>
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
"  alt='' >
				<div class='background_publication' >
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
</div><?php }
}
