<div id='document_body'>
	<div id='center_block'>
		<h2>Рекомендации для вас</h2>
		<div id='list_users_sub'>
			<ul>
				{foreach from=$users key=k item=value}
				<li id='{$value.login}'>
					<img src='/img/users_avatar/{$value.avatar}'>
					<p>{$value.login}</p>
					
					<button class='show subscribe_btn' onclick='subscribe(event)' id='sub'>Подписаться</button>
					<button class='hidden subscribe_btn' onclick='unSubscribe(event)' id='unsub'>Отписаться</button>
					<input type='hidden' id='id_subscriber' value="{$user_id}">
				</li>
				{/foreach}
			</ul>
		</div>
	</div>
</div>
<script type='text/javascript' src='/js/users_script.js'></script>