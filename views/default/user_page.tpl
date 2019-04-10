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
			<p class='count_info' name='subscribers' onclick='showWindowListUsers(event);'><span class='number'>{$user.count_subscribers}</span>&nbsp;подписчиков</p>
			<p class='count_info' name='subscriptions' onclick='showWindowListUsers(event);'><span class='number'>{$user.count_subscriptions}</span>&nbsp;подписок</p>
		</div>
		<div id='about_block'>
			<p>{$user.name}</p>
			<p>{$user.about}</p>
			<p>{$user.web_cyte}</p>
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
		{foreach from=$publications key=k item=value}
			<div class='item_publication' id="{$value.public_id}">
				<img src="/img/users_publications/{$value.img}"  alt=''>
				<div class='background_publication' >
					{$btn_delete_publication}
					<p class='likes_comment'>
						<span><i class="fas fa-heart">&nbsp;<span>{$value.likes}</span></i></span>
						<span><i class="fas fa-comment">&nbsp;<span>{$value.comment}</span></i></span>
					<p>
				</div>
			</div>
		{/foreach}
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