<div id='document_body'>
	<div id='center_block'>
		<h2>Рекомендации для вас</h2>
		<div id='list_users_sub'>
			<ul>
				{foreach from=$users key=k item=value}
				<li id='{$value.login}'>
					<a href='http://instagram/user/{$value.login}/'>
						<img src='/img/users_avatar/{$value.avatar}'>
						<p>{$value.login}</p>
					</a>
					<button class='show subscribe_btn' onclick='subscribe(event)' id='sub'>Подписаться</button>
				</li>
				{/foreach}
			</ul>
		</div>
	</div>
</div>
<script type='text/javascript' src='/js/users_script.js'></script>