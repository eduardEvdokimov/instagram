
<div id='user_info_block'>
	<div id='user_content'>
		<img src='/img/users_avatar/{$user.avatar}' alt=''>
		<div id='user_info'>
			<div id='header_block_user_info'>
				<p id='login_user'>{$user.login}</p>
				<input type='hidden' id='sub_object' value="{$sub_object}">
				{$buttonSub}
				{$buttonUnSub}
				{$dropDownList}
			</div>
			<p class='count_info' style="cursor: text"><span class='number'>{$user.count_publications}</span>&nbsp;публикаций</p>
			<p class='count_info' onclick='showWindowListUsers(event);'><span class='number'>{$user.count_subscribers}</span>&nbsp;подписчиков</p>
			<p class='count_info' onclick='showWindowListUsers(event);'><span class='number'>{$user.count_subscriptions}</span>&nbsp;подписок</p>
		</div>
		<div id='about_block'>
			<p>{$user.name}</p>
			<p>{$user.about}</p>
			<p>{$user.web_cyte}</p>
		</div>
	</div>

</div>


<div id='bg_popup_window' >
	<div id='popup_window_user_list'>
		<div id='head'>
			<h2>Подписчики</h2>
		</div>
		<div id='list_users'>
			<ul>
				<li>
					<img src='/img/users_avatar/5385bd4228a99b3647537793bf5f584b.jpg' alt=''>
					<div>
						<p id='login'>kosmas</p>
						<p id='name'>Эдуард Евдокимов</p>
					</div>
					<p id='btn'>Подписаться</p>
				</li>
				<li>
					<img src='/img/users_avatar/5385bd4228a99b3647537793bf5f584b.jpg' alt=''>
					<div>
						<p id='login'>kosmas</p>
						<p id='name'>Эдуард Евдокимов</p>
					</div>
					<p id='btn'>Подписаться</p>
				</li>
				<li>
					<img src='/img/users_avatar/5385bd4228a99b3647537793bf5f584b.jpg' alt=''>
					<div>
						<p id='login'>kosmas</p>
						<p id='name'>Эдуард Евдокимов</p>
					</div>
					<p id='btn'>Подписаться</p>
				</li>
				<li>
					<img src='/img/users_avatar/5385bd4228a99b3647537793bf5f584b.jpg' alt=''>
					<div>
						<p id='login'>kosmas</p>
						<p id='name'>Эдуард Евдокимов</p>
					</div>
					<p id='btn'>Подписаться</p>
				</li>
				<li>
					<img src='/img/users_avatar/5385bd4228a99b3647537793bf5f584b.jpg' alt=''>
					<div>
						<p id='login'>kosmas</p>
						<p id='name'>Эдуард Евдокимов</p>
					</div>
					<p id='btn'>Подписаться</p>
				</li>
				<li>
					<img src='/img/users_avatar/5385bd4228a99b3647537793bf5f584b.jpg' alt=''>
					<div>
						<p id='login'>kosmas</p>
						<p id='name'>Эдуард Евдокимов</p>
					</div>
					<p id='btn'>Подписаться</p>
				</li>
				<li>
					<img src='/img/users_avatar/5385bd4228a99b3647537793bf5f584b.jpg' alt=''>
					<div>
						<p id='login'>kosmas</p>
						<p id='name'>Эдуард Евдокимов</p>
					</div>
					<p id='btn'>Подписаться</p>
				</li>
			</ul>
		</div>
	</div>
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

<script type='text/javascript' src='/js/publications_script.js'></script>
<script type='text/javascript' src='/js/users_script.js'></script>


<script type="text/javascript">
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
</script>