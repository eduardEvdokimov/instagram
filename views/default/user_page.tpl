<input type='hidden' id='id_subscriber' value="{$id_subscriber}">
<input type='hidden' id='sub_object' value="{$sub_object}">
<div id='button'>
	{$buttonSub}
	{$buttonUnSub}
	{$AddPublications}
	{$buttonChangeSettingData}
</div>

<div id='background_form' class='hidden'>

	<div id='form_publications'>
		<input type='file' name='file' id='file' multiple=""><br>
		<p>Описание</p>
		<textarea name="article" id='article' rows='5' cols="30"></textarea><br>
		<p>Хештеги</p>
		<textarea name='hashtags' id='hashtags' rows='5' cols="30"></textarea><br>
		<button name="Опубликовать" onclick='addPublication();' >Опубликовать</button>
		<p id='message'></p>
	</div>

</div>
	
<p id='p'></p>
<div class='table_publications'>
	<div class='center_content' onclick='showBigPublication(event);'>


		{foreach from=$publications key=k item=value}

			<div class='item_publication' id="{$value.public_id}">
				<img src="/img/users_publications/{$value.img}"  alt='' >
				<div class='background_publication' >
					<p class='likes_comment'>
						<span><i class="fas fa-heart">{$value.likes}</i></span>
						<span><i class="fas fa-comment">{$value.comment}</i></span>
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
				<img src='' alt='' id='user_avatar'>
				<p id='user_login'></p>
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
		<div>
	</div>
</div>

<script type='text/javascript' src='/js/publications_script.js'></script>
<script type='text/javascript' src='/js/users_script.js'></script>
<script type='text/javascript' src='/js/main.js'></script>