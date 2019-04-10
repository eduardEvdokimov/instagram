<?php
/* Smarty version 3.1.33, created on 2019-04-07 19:37:29
  from 'C:\OSPanel\domains\instagram\views\default\list_add_subscribers.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5caa27497d9eb7_41566035',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ed2bd3f2af9283660129fe4e51f71749ca7279ad' => 
    array (
      0 => 'C:\\OSPanel\\domains\\instagram\\views\\default\\list_add_subscribers.tpl',
      1 => 1554655048,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5caa27497d9eb7_41566035 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='document_body'>
	<div id='center_block'>
		<h2>Рекомендации для вас</h2>
		<div id='list_users_sub'>
			<ul>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['users']->value, 'value', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
				<li id='<?php echo $_smarty_tpl->tpl_vars['value']->value['login'];?>
'>
					<a href='http://instagram/user/<?php echo $_smarty_tpl->tpl_vars['value']->value['login'];?>
/'>
						<img src='/img/users_avatar/<?php echo $_smarty_tpl->tpl_vars['value']->value['avatar'];?>
'>
						<p><?php echo $_smarty_tpl->tpl_vars['value']->value['login'];?>
</p>
					</a>
					<button class='show subscribe_btn' onclick='subscribe(event)' id='sub'>Подписаться</button>
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
 type='text/javascript' src='/js/users_script.js'><?php echo '</script'; ?>
><?php }
}
