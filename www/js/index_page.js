background_form//Добавление комментария публикации
function addComment(event)
{
	//Проверяем нажал ли пользователь на enter
	if(event.keyCode == 13){
		var publication = $(event.target).closest('.publication');
		var comment = $(event.target).val(); //Получаем значение инпута (комментарий)
		//Ищем родителя object с классом visible_big_publication и извлекаем его id
		var id_publication = publication.attr('id');	
		var data = new FormData();

		if(comment){
			//Если инпут не пустой проверяем на пробелы
			if(comment.search(/^\s+$/) == 0){
				//Если ничего не введено, а есть пробелы
				//Меняем подсказку у инпута
				publication.find('#addComment').prop('placeholder', 'Введите что-нибудь');
				//Добавляем класс инпуту, красящий подсказку в красный
				publication.find('#addComment').addClass('comment_error');
				//Обнуляем инпут
				publication.find('#addComment').val('');
				return;
			}
		}else return;

		data.append('comment', comment);
		data.append('public_id', id_publication);

		$.ajax({
			type: 'post',
			url: 'http://instagram/publication/addComment/',
			data: data,
			processData: false,
			contentType: false,
			success: function(data){
				console.log(data);
				var user_login = $('#my_login').html(); //Извлекаем из тега логин пользователя публикации
				if(data){
					//Проверяем где запущен скрипт. Если check_main_page = true, значит на главной
					//Если true, формируем переменную для отображения комментария на главной странице
					var content = "<li id='" + data + "'><p><a href='http://instagram/user/" + user_login + "/'><span class='login'>" + user_login + "</span></a>";
					content += "<span class='article'>&nbsp;" + comment + '</span></p>';
					content += "<button onclick='addLikeComment(event);'><img src='/img/cyte/heart.png' alt=''></button></li>";
					//Вставляем в начало блока list_comments переменную
					publication.find('.list_comments > ul').append(content);
				}else{
					alert('Не удалось добавить комментарий. Попробуйте позже.');
				}
				//Переводим инпут ввода комментария в значение по умолчанию
				publication.find('#addComment').val('').removeClass('comment_error').prop('placeholder', 'Добавьте комментарий...');
			},
			error: function(){
				alert('Не удалось добавить комментарий. Попробуйте позже.');
			}
		});
	}
}

function falseLike(event){
	//Получаем JQuery объект публикации на которыую кликнули
	var publication = $(event.target).closest('.publication');

	publication.find('#background > img').animate({height: 100, opacity: 1.0}, 200);
	publication.find('#background > img').animate({height: 90, opacity: 1.0}, 100);
	//Воспроизводим анимацию затухания спустя 1 секунду
	setTimeout(function(){
		publication.find('#background > img').animate({height: 50, opacity: 0.0}, 200);
	}, 1000);
}

//Ставит лайк публикации по двойному клику
function likeDoubleClick(event)
{
	var publication = $(event.target).closest('.publication');
	var publication_id = publication.attr('id');
	console.log(publication);
	var data = new FormData();

	data.append('publication_id', publication_id);

	$.ajax({
		type: 'post',
		url: 'http://instagram/publication/addLike/',
		data: data,
		processData: false,
		contentType: false,
		success: function(data){
			console.log('+');
			//Меняем картинку на закрашенное сердце
			publication.find('#button_like > img').attr('src', '/img/cyte/heart_red.png');
			//Меняем значение onclick на функцию удаления лайка
			publication.find('#button_like').attr('onclick', 'delLike(event)');
			//Увеличиваем количество лайков на 1
			publication.find('#likes').html(Number(publication.find('#likes').html()) + 1);	

			publication.find('.image_publication').attr('ondblclick', 'falseLike(event)');

			publication.find('#background > img').animate({height: 100, opacity: 1.0}, 200);
			publication.find('#background > img').animate({height: 90, opacity: 1.0}, 100);

			setTimeout(function(){
				publication.find('#background > img').animate({height: 50, opacity: 0.0}, 200);
			}, 1000);
		},
		error: function(){
			alert('Произошла ошибка. Попробуйте позже.');
		}
	});
}


//Добавляет лайк публикации
function addLike(event)
{
	var publication = $(event.target).closest('.publication');
	var publication_id = publication.attr('id');
	console.log(publication);
	var data = new FormData();

	data.append('publication_id', publication_id);

	$.ajax({
		type: 'post',
		url: 'http://instagram/publication/addLike/',
		data: data,
		processData: false,
		contentType: false,
		success: function(data){
				console.log('+');
				//Меняем картинку на закрашенное сердце
				publication.find('#button_like > img').attr('src', '/img/cyte/heart_red.png');
				//Меняем значение onclick на функцию удаления лайка
				publication.find('#button_like').attr('onclick', 'delLike(event)');
				//Увеличиваем количество лайков на 1
				publication.find('#likes').html(Number(publication.find('#likes').html()) + 1);

				publication.find('.image_publication').attr('ondblclick', 'falseLike(event)');
			
		},
		error: function(){
			alert('Произошла ошибка. Попробуйте позже.');
		}
	});
}

//Удаляет лайк из публикации
function delLike(event)
{
	var publication = $(event.target).closest('.publication');
	var publication_id = publication.attr('id');
	var data = new FormData();

	data.append('publication_id', publication_id);

	$.ajax({
		type: 'post',
		url: 'http://instagram/publication/delLike/',
		data: data,
		processData: false,
		contentType: false,
		success: function(data){
				//Меняем картинку на не закрашенное сердце
				publication.find('#button_like > img').attr('src', '/img/cyte/heart.png');
				//Меняем значение onclick на функцию добавления лайка
				publication.find('#button_like').attr('onclick', 'addLike(event)');
				//Уменьшаем количество лайков на 1
				publication.find('#likes').html(Number(publication.find('#likes').html()) - 1);

				publication.find('.image_publication').attr('ondblclick', 'likeDoubleClick(event)');
		},
		error: function(){
			alert('Произошла ошибка. Попробуйте позже.');
		}
	});
}

//Добавляет лайк комментарию
function addLikeComment(event)
{
	var elemet_li = $(event.target).closest('li');
	var comment_id = $(elemet_li).attr('id');
	var data = new FormData();

	data.append('comment_id', comment_id);

	$.ajax({
		type: 'post',
		url: 'http://instagram/publication/addLikeComment/',
		data: data,
		processData: false,
		contentType: false,
		success: function(data){
			console.log(data);
			if(data == true){
				//Меняем картинку на закрашенное сердце
				$(elemet_li).find('img').attr('src', '/img/cyte/heart_red.png');
				//Меняем значение onclick на функцию удаления лайка
				$(elemet_li).find('button').attr('onclick', 'delLikeComment(event)');
				//Увеличиваем количество лайков на 1
				$(elemet_li).find('#count_like_comment').html(Number($(elemet_li).find('#count_like_comment').html()) + 1);
			}
		},
		error: function(){
			alert('Произошла ошибка сервера. Попробуйте позже.');
		}
	});
}

//Установка фокуска на элемент
function setFocus(event){
	$(event.target).closest('.publication').find('#addComment').focus();
}
//Удаляет лайк комментария
function delLikeComment(event)
{
	var elemet_li = event.target.closest('li');
	var comment_id = $(elemet_li).attr('id');
	var data = new FormData();

	data.append('comment_id', comment_id);

	$.ajax({
		type: 'post',
		url: 'http://instagram/publication/delLikeComment/',
		data: data,
		processData: false,
		contentType: false,
		success: function(data){
			console.log(data);
			if(data == true){
				//Меняем картинку на не закрашенное сердце
				$(elemet_li).find('img').attr('src', '/img/cyte/heart.png');
				//Меняем значение onclick на функцию добавления лайка
				$(elemet_li).find('button').attr('onclick', 'addLikeComment(event)');
				//Уменьшаем количество лайков на 1
				$(elemet_li).find('#count_like_comment').html(Number($(elemet_li).find('#count_like_comment').html()) - 1);
			}
		},
		error: function(){
			alert('Произошла ошибка сервера. Попробуйте позже.');
		}
	});
}

//Подгрузка комментариев
function loadComments(event){
	var publication = $(event.target).closest('.publication');
	var count_comment = publication.find('li').length;
	var publication_id = publication.attr('id');
	var data = new FormData();

	data.append('start', count_comment);
	data.append('publication_id', publication_id);

	$.ajax({
		type: 'post',
		url: 'http://instagram/index/loadComments/',
		data: data,
		processData: false,
		contentType: false,
		dataType: 'json',
		success: function(data){
			console.log(data);
			//Проверяем сколько пришло комментариев от сервера
			if(data.length < 10){
				//Если меньше 10, прячем кнопку подгрузки комментариев
				publication.find('#loadComment').remove();
			}	
			//Добавляем комментарии в hmtl страницу
			$.each(data, function(index, item){
				var comment = "<li id='" + item['id'] + "'>";
				comment += "<p><a href='http://instagram/user/" + item['login'] + "/'>";
				comment += "<span class='login'>" + item['login'] + "</span></a>";
				comment += "<span class='article'>&nbsp;" + item['comment'] + "</span></p>";
				comment += item['button_like'];
				publication.find('.list_comments > ul').prepend(comment);
			});
		},
		error: function(){
			alert('Произошла ошибка. Попробуйте позже.');
		}
	});
}



$(document).ready(function(){
	
	var inProgress = false; //Отслеживает запущен ли запрос к серверу

	var count_pub = 12; //Начальное количество показанных новостей
	
	$(window).scroll(function(){
		if(($(window).scrollTop() + $(window).height() >= $(document).height() - 50) && !inProgress){

			
			
			$.ajax({
				type: 'post',
				url: 'http://instagram/index/loadPublications/',
				dataType: 'json',
				data: {'count_pub': count_pub},
				beforeSend: function(){
					inProgress = true;
				},
				success: function(data){
					console.log(data);
					
					if(data.length > 0){
						$.each(data, function(index, data){

							var content = "<div class='publication' id='" + data.public_id + "'><div class='header_block'>";
							content += "<a href='http://instagram/user/" + data.login + "/'>";
							content += "<img src='/img/users_avatar/" + data.avatar + "' alt=''>";
							content += "<p id='user_login'>" + data.login + "</p></a></div>";
							content += "<div class='image_publication' ondblclick=" + data.dbl_click_like + " onselectstart='return false' onmousedown='return false'>";
							content += "<img src='/img/users_publications/" + data.img + "' alt=''><div id='background'>";
							content += "<img src='/img/cyte/heart_white.png' id='heart'></div></div>";
							content += "<div class='buttons_likes'>" + data.button_like;
							content += "<button onclick='setFocus(event)'><img src='/img/cyte/comment.png' alt=''></button>";
							content += "<p class='count_likes'><span id='likes'>" + data.likes + "</span><span> отметок 'Нравится'</span></p>";
							data.visible_comment = (data.visible_comment == undefined) ? '' : data.visible_comment;
							data.title = (data.title == undefined) ? '' : data.title;
							content += "<p class='article_publication'>" + data.title + "</p>" + data.visible_comment;

							
							content += "</div><div class='list_comments'><ul>";

							if(data.comment.length > 0)
							for(var i = 0; i < data.comment.length; i++){
								content += "<li id='" + data.comment[i].id + "'><p>";
								content += "<a href='http://instagram/user/" + data.comment[i].login + "/'>";
								content += "<span class='login'>" + data.comment[i].login + "</span></a>";
								content += "<span class='article'>&nbsp;" + data.comment[i].comment + "</span></p>" + data.comment[i].button_like + "</li>";

							}
				
	
							content += "</ul></div><div class='pub_date'>";
							content += "<p>" + data.pub_date + "</p></div><div class='entry_field'>";
							content += "<input type='text' id='addComment' onkeypress='addComment(event)' placeholder='Добавьте комментарий...'></div></div>";

							$('#center_content').append(content);
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