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
	<div class='center_content' >


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
	<div class='visible_big_publication'>
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
				<button><img src='/img/cyte/heart.png' alt=''></button>
				<button onclick="setFocus('#addComment')"><img src='/img/cyte/comment.png' alt=''></button>
				<p><span></span> отметок "Нравится"</p>
				<p id='pub_date'></p>
			</div>
			<input type="text" name="" id='addComment' placeholder="Добавьте комментарий...">
		<div>
	</div>
</div>

<script type='text/javascript'>

$('#addComment').keydown(function(e){
	if(e.keyCode === 13){
		if(e.target.value && e.target.value !== ' ')
			alert('hello');
	}
});





//Отслеживаем нажатие на публикацию, для отображение большого окна публикации
$('.center_content').click(function(e){

	var element = e.target; //Получаем объект кажатого элемента

	if(element.className == 'center_content')
		return;

	var id_publication = element.closest('.item_publication').id; //Id дочернего элемента блока с class = item_publication

	var data = new FormData();
	data.append('pub_id', id_publication);

	$.ajax({
		type: 'post',
		url: 'http://instagram/publication/getPublication/',
		data: data,
		processData: false,
		contentType: false,
		dataType: 'json',
		beforeSend: function(){
			$('ul').html('');
			$('.hashtags').html('');
		},
		success: function(data){
			var comments = new Array;
			var hashtags = new Array;
			console.log(data);
			//Проверка, есть ли хештеги
			if(data['hashtags']){	
				$.each(data['hashtags'], function(index, item){
					var hashtag = '<span>' + item + '</span>';
					$('.hashtags').append(hashtag);
				});	
			}
			//Проверка, есть ли комментарии
			if(data['comments']){
				$.each(data['comments'], function(index, item){
					var comment = '<li><p id=login>' + item['login'] + '<p id=comment>' + item['comment'] + '</p></p></li>';
					$('ul').append(comment);
				});				
			}

			//Отображение картинки
			$('#photo_publication').attr('src', '/img/users_publications/' + data['img']);
			//Добавляем путь для отбражения аватарки автора публикации
			$('#right_block_pub > #head_window > #user_avatar').attr('src', '/img/users_avatar/' + data['author']['avatar']);
			//Отображаем логин, автора публикации
			$('#user_login').html(data['author']['login']);
			//Отображаем описание публикации
			$('#article_publication').html(data['title']);
			//Выводим количество лайков
			$('#buttons > p > span').html(data['likes']);
			//Выводим дату добавления публикации
			$('#pub_date').html(data['pub_date']);
			//Отображаем окно с публикацией
			$('#background_window_pub').addClass('background_window_pub').removeClass('hidden');

			$('.background_window_pub').css('height', $(window).height() + $(window).scrollTop());
			
			//Скрываем полосу прокрутки 
			$("body").css("overflow","hidden");				
		},
		error: function(){
			alert('Не удалось отобразить публикацию');
		}
	});
});

//отслеживаем где на что кликнули, для скрытия всплывающих окон
$(document).click(function(e) {	

	if(e.target.id == 'new_pub')
	//Если у нажатого элемента id = new_pub, выходим из функции
		return;
		
   	if($(e.target.closest('#form_publications')).length)
   	//Если нажали на div с id = form_publications или на его дочерний элемент выходим из функции
     	return;

   	if($(e.target.closest('.visible_big_publication')).length)
   	//Если нажали на div с id = visible_big_publication или на его дочерний элемент выходим из функции
     	return;
   		
   	//Если не одно условие не выполнилось, скрываем открытое окно	
	$('#background_window_pub').removeClass('background_window_pub').addClass('hidden');

	$("body").css("overflow","auto"); //Возращаем полосу прокрутки

	$('#background_form').fadeOut(); 
	$('#form_publications').fadeOut();
});


$(document).ready(function(){
	
	var inProgress = false; //Отслеживает запущен ли запрос к серверу

	var count_pub = 12; //Начальное количество показанных новостей

	var url = document.location.pathname;

	var user_id = url.match('/([0-9]+)/');

	var data = new FormData();
	data.append('user_id', user_id[1]);

	$(window).scroll(function(){
		if(($(window).scrollTop() + $(window).height() >= $(document).height() - 50) && !inProgress){

			data.append('count_pub', count_pub);
			
			$.ajax({
				type: 'post',
				url: 'http://instagram/publication/loading/',
				data: data,
				cache: false,
				contentType: false,
				processData: false, 
				dataType: 'json',
				beforeSend: function(){
					inProgress = true;
				},
				success: function(data){
					console.log(data);
					if(data.length > 0){
						$.each(data, function(index, data){

							var content = "<div class='item_publication' id=" + data['public_id'] + ">";

							content += "<img src='/img/users_publications/" + data['img'] + "'alt=''>";

							content += "<div class='background_publication'><p class='likes_comment'>";

							content += "<span><i class='fas fa-heart'>" + data['likes'] + "</i></span>";

							content += "<span><i class='fas fa-comment'>" + data['count_comment'] + "</i></span><p></div></div>";

							$('.center_content').append(content);

						});

						count_pub += 12;
					}
				},
				error: function(){
					alert('Не удалось извлечь из базы данных остальные публикации.');
				},
				complete: function(){
					inProgress = false;
				}
			});
		}
	});
});
</script>

