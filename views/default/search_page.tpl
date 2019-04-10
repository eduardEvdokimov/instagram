<div id='head2_page'>
	<h1>{$hashtag}</h1>
	<p><span>{$count_publications}</span> публикаций</p>
</div>
<script type='text/javascript' src='/js/publications_script.js'></script>
<div class='table_publications'>
	<div class='center_content' onclick='showBigPublication(event);'>
		{foreach from=$publications key=k item=value}
			<div class='item_publication' id="{$value.public_id}">
				<img src="/img/users_publications/{$value.img}"  alt='' >
				<div class='background_publication' >
					<p class='likes_comment'>
						<span><i class="fas fa-heart">&nbsp;<span>{$value.likes}</span></i></span>
						<span><i class="fas fa-comment">&nbsp;<span>{$value.comment}</span></i></span>
					<p>
				</div>
			</div>
		{/foreach}
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
</div>