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
	<div class='center_content'>

		{foreach from=$publications key=k item=value}

			<div class='item_publication'>
				<a href=''>
				<img src="/img/users_publications/{$value.img}"  alt='' >
				<div class='background_publication'>
					<p class='likes_comment'>
						<span><i class="fas fa-heart">{$value.id}</i></span>
						<span>Комменты</span>
					<p>
				</div>
				</a>
			</div>

		{/foreach}
	</div>
<div>

<script type='text/javascript'>
		
	
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
						if(data.length > 0){
							$.each(data, function(index, data){

								var content = "<div class='item_publication'><a href=''>";

								content += "<img src='/img/users_publications/" + data['img'] + "'alt=''>";

								content += "<div class='background_publication'><p class='likes_comment'>";

								content += "<span><i class='fas fa-heart'>" + data['id'] + "</i></span>";

								content += "<span>Комменты</span><p></div></a></div>";

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

