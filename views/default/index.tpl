


<div id='body_document'>
	<div id='center_content'>

		{foreach from=$publications item=value}
		<div class='publication' id='{$value.public_id}'>
			<div class='header_block'>
				<a href='http://instagram/user/{$value.login}/'>
					<img src='/img/users_avatar/{$value.avatar}' alt='' >
					<p id='user_login'>{$value.login}</p>	
				</a>
			</div>
			<div class='image_publication' ondblclick="{$value.dbl_click_like}" onselectstart="return false" onmousedown="return false">
				<img src='/img/users_publications/{$value.img}' alt=''>
				<div id='background'>
					<img src="/img/cyte/heart_white.png" id='heart'>
				</div>
			</div>
			<div class='buttons_likes'>
				{$value.button_like}
				<button onclick="setFocus(event)">
					<img src='/img/cyte/comment.png' alt=''>
				</button>
				<p class='count_likes'>
					<span id='likes'>{$value.likes}</span>
					<span> отметок "Нравится"</span>
				</p>
				<p class='article_publication'>{$value.title}</p>
				{$value.visible_comment}
			</div>
			<div class='list_comments'>

				<ul> <!-- Изначально отображается 4 комментария -->
					{if is_array($value.comment)}

					{foreach from=$value.comment item=comment}
					<li id='{$comment.id}'>
						<p>
							<a href="http://instagram/user/{$comment.login}/">
								<span class='login'>{$comment.login}</span>
							</a>
							<span class='article'>&nbsp;{$comment.comment}</span>
						</p>
						{$comment.button_like}
					</li>
					{/foreach}
					{/if}
				</ul>
			</div>
			<div class='pub_date'>
				<p>{$value.pub_date}</p>
			</div>
			<div class='entry_field'>
				<input type='text' id='addComment' onkeypress='addComment(event)' placeholder="Добавьте комментарий...">
			</div>
		</div>

		

		{/foreach}
	</div>
	<div id='right_block'>
		<div id='header_block'>
			<p id='title_block'>Рекомендации для вас</p>
			<a href='#'>Все</a>
		</div>
		<div id='list_users'>
			<ul>
				{foreach from=$recomendateUsers item=item}
				<li id='{$item.login}'>
					<a href='http://instagram/user/{$item.login}/'>
						<img src='/img/users_avatar/{$item.avatar}' alt=''>
						<p>{$item.login}</p>
					</a>
					<button class='show' onclick='subscribe(event)' id='sub'>Подписаться</button>
				</li>
				{/foreach}
				
			</ul>
		</div>
	</div>
</div>
<script type="text/javascript" src='/js/index_page.js'></script>
<script type="text/javascript" src='/js/users_script.js'></script>
{literal}
<script>
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

	
</script>
{/literal}