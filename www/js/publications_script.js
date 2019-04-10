//Добавляет новую публикацию в БД
function addPublication()
{
	var formData = new FormData(); //Объявляем объект для удобного отсыла на сервер данных
	var title = $('#article').val(); //Получаем описание 
	var hashtags = $('#hashtags').val(); //Получаем хештеги 
	var url = window.location.pathname; //Получаем URI
	var array_user_id = url.match(/user\/(\S+)\//); //Извлекаем из URI id пользователя
	var user_login = array_user_id[1]; //Получаем id
	var form = $('#form_publications'); //Получаем объект формы для достука с ее элементам
	var message = $('#message'); //Получаем элемент с выводом сообщений

	//Узнаем сколько фотографий загрузили
	if($('#file')[0].files.length > 0)
		//Если больше 0
		var file = $('#file')[0].files; // Получаем массив с объектами фотографий
	else{
		//Если не выбрали фото, выводим сообщение
		message.text('Нужно выбрать фотографию');
		return false;
	}

	formData.append('title', title);
	formData.append('hashtags', hashtags);
	formData.append('file', file[0]);
	formData.append('user_login', user_login);
	
	$.ajax({
		type: 'post',
		url: 'http://instagram/publication/addPublication/',
		data: formData,
		cache: false,
		contentType: false,
		processData: false, 
		dataType: 'json',
		beforeSend: function(){ 
		//Перед отправкой запроса на сервер выводим сообщение и блокируем инпуты
			message.text('Отправка данных');
			form.find('input').prop('disabled', true);
		},
		success: function(data){
			//В случае успешной работы сервера проверяем на ошибки
			if(data['image']){
				//Если есть ошибки по части картинки
				message.text(data['image']);
			}
			if(data['hashtag']){
				//Если есть ошибки по части хештегов
				message.text(data['hashtag']);
			}
			if(data['success']){
				//Если ошибок нет
				var content = "<div class='item_publication' id='" + data['public_id_publication'] + "'>";
				content += "<img src='/img/users_publications/" + data['image_publication'] + "' alt=''>";
				content += "<div class='background_publication'><p id='delete_publication' onclick='comfirmedForm(event)'><i class='fas fa-times'></i></p><p class='likes_comment'>";
				content += "<span><i class='fas fa-heart'>0</i></span>";
				content += "<span><i class='fas fa-comment'>0</i></span><p></div></div>";

				$('.center_content').prepend(content);
				form.find('input').prop('value', ''); //Устанавливаем инпутам значение по умолчанию
				form.find('textarea').val(''); //Значение по умолчанию textarea
				message.text(data['success']); //Выводим сообщение об успехе
			}
		},
		complete: function(){
			//В случаем любого результата по завершении работы включаем инпуты
			form.find('input').prop('disabled', false);
		},
		error: function(){
			//В случае ошибки по части ответа от сервера 
			message.text('Ошибка отправки');
		}
	});
}


//Отслеживаем нажатие на публикацию, для отображение большого окна публикации
function showBigPublication(event)
{
	var data = new FormData();
	var element = event.target; //Получаем объект кажатого элемента
	//Id дочернего элемента блока с class = item_publication
	var id_publication = element.closest('.item_publication').id; 
	
	if(element.className == 'center_content')
		return;

	if($(element).closest('#delete_publication').length)
		return;

	data.append('pub_id', id_publication);

	$.ajax({
		type: 'post',
		url: 'http://instagram/publication/getPublication/',
		data: data,
		processData: false,
		contentType: false,
		dataType: 'json',
		beforeSend: function(){
			$('#list_comments').html('');
			$('.hashtags').html('');
		},
		success: function(data){
			var comments = new Array;
			var hashtags = new Array;
			//Проверка, есть ли хештеги
			if(data['hashtags']){	
				$.each(data['hashtags'], function(index, item){	
					var hashtag = "<span>" + item + '</span>&nbsp;';
					$('.hashtags').append(hashtag);
				});	
				
			}
			//Проверка, есть ли комментарии
			if(data['comments']){
				$.each(data['comments'], function(index, item){
					var comment = "<li id='" + item['id'] + "'><p class='item_comment'><span id='login'>" + item['login'] + '</span>&ensp;<span id=comment>' + item['comment'] + '</span></p>';

					if(item['press_like'] == true){
						comment += "<button onclick='delLikeComment(event);'><span id='count_like_comment'>" + item['likes'] + "</span>&ensp;<img src='/img/cyte/heart_red.png' alt=''></button>"
					}else{
						comment += "<button onclick='addLikeComment(event);'><span id='count_like_comment'>" + item['likes'] + "</span>&ensp;<img src='/img/cyte/heart.png' alt=''></button>";
					}
						
					comment += "<p id='pub_date_comment'>" + item['pub_date'] + "</p></li>";

					$('#list_comments').append(comment);
				});				
			}
			
			if(data['like'] == 1){
				$('#button_like').attr('onclick', 'delLike(event)');
				$('#button_like > img').attr('src', '/img/cyte/heart_red.png');
			}else{
				$('#button_like').attr('onclick', 'addLike(event)');
				$('#button_like > img').attr('src', '/img/cyte/heart.png');
			}

			//Вписываем id открытой публикации
			$('.visible_big_publication').attr('id', id_publication);
			//Отображение картинки
			$('#photo_publication').attr('src', '/img/users_publications/' + data['img']);
			$('#right_block_pub > #head_window > a').attr('href', 'http://instagram/user/' + data['author']['login'] + '/');
			//Добавляем путь для отбражения аватарки автора публикации
			$('#right_block_pub > #head_window > a > #user_avatar').attr('src', '/img/users_avatar/' + data['author']['avatar']);
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
			//Делаем высоту фона по высоте документа
			$('.background_window_pub').css('height', $(window).height() + $(window).scrollTop());
			//Скрываем полосу прокрутки 
			$("html").css("overflow","hidden");				
		},
		error: function(){
			alert('Не удалось отобразить публикацию');
		}
	});
}

//Отображает форму подтверждения удаления публикации
function comfirmedForm(event)
{
	//Получаем внешний id публикации
	var public_id = $(event.target).closest('.item_publication').attr('id');
	//Записываем в скрытое поле внешний id
	$('.public_id_publication_delete').attr('id', public_id);

	$('#msg_btn_confirmed').removeClass('hidden');
	$('#msg_confirmed').addClass('hidden');

	$('#bg_popup_confirmation').css('height', $(window).height() + $(window).scrollTop()).removeClass('hidden');
	//Скрываем полосу прокрутки 
	$("html").css("overflow","hidden");	
}

//Удаляет публикацию
function deletePublication(event)
{
	var public_id = $('.public_id_publication_delete').attr('id');
	
	if(event.target.id == "cancel"){
		$('#bg_popup_confirmation').addClass('hidden');
		$("html").css("overflow","auto");
		return;	
	}

	if(event.target.id == "delete"){
		$.ajax({
			type: 'post',
			url: 'http://instagram/publication/deletePublication/',
			data: {'public_id': public_id},
			success: function(data){
				if(data == true){
					$('#msg_btn_confirmed').addClass('hidden');
					$('#msg_confirmed').removeClass('hidden');
					$('#'+public_id).remove();
					setTimeout(function(){
						$('#bg_popup_confirmation').addClass('hidden');
						$("html").css("overflow","auto");
					}, 3000);
				}else{
					alert('Произошла ошибка сервера. Попробуйте позже.');
				}
			},
			error: function(){
				alert('Произошла ошибка сервера. Попробуйте позже.');
			}
		});
	}
}

//Установка фокуска на элемент
function setFocus(element){
	$(element).focus();
}

//Добавление комментария публикации
function addComment(event){
	//Проверяем нажал ли пользователь на enter
	if(event.keyCode == 13){
	
		var object = $(event.target);
		var comment = $(event.target).val(); //Получаем значение инпута (комментарий)
		//Ищем родителя object с классом visible_big_publication и извлекаем его id
		var id_publication = $(event.target).closest('.visible_big_publication').attr('id');	

		if(object.val()){
			//Если инпут не пустой проверяем на пробелы
			if(object.val().search(/^\s+$/) == 0){
				//Если ничего не введено, а есть пробелы
				//Меняем подсказка у инпута
				$('#addComment').prop('placeholder', 'Введите что-нибудь');
				//Добавляем класс инпуту, красящий подсказку в красный
				$('#addComment').addClass('comment_error');
				//Обнуляем инпут
				$('#addComment').val('');
			}else{
				//Если инпут не пустой и не заполнен одними пробелами
				var data = new FormData();
				data.append('comment', comment);
				data.append('public_id', id_publication);
				$.ajax({
					type: 'post',
					url: 'http://instagram/publication/addComment/',
					data: data,
					processData: false,
					contentType: false,
					success: function(data){
						var user_login = $('#my_login').html(); //Извлекаем из тега логин пользователя публикации
						if(data){
							//Если скрипт запущен на странице пользователя
							//Если true, формируем переменную для отображения комментария на странице
							var content = '<li id=\'' + data + '\'><p class=item_comment><span id=login>' + user_login + '</span>&ensp;<span id=comment>' + comment + '</span></p>';
							content += "<button onclick='addLikeComment(event);'><span id='count_like_comment'>0</span>&ensp;<img src='/img/cyte/heart.png' alt=''></button>";
							content += "<p id='pub_date_comment'>ТОЛЬКО ЧТО</p></li>";
							//Вставляем в начало блока list_comments переменную
							$('#list_comments').prepend(content);
							//Получаем дочерний элемент # + id_publication блока с классом center_content
							var publication = $('.center_content').children('#' + id_publication);
							// Ищем в JQuery объекте блок с классом fa-comment и извлекаем его
							var comments = publication.find('.fa-comment > span');
							//Увеличиваем количество комментариев на 1
							comments.html(Number(comments.html()) + 1);	
						}else{
							alert('Не удалось добавить комментарий. Попробуйте позже.');
						}
						//Переводим инпут ввода комментария в значение по умолчанию
						$('#addComment').val('').removeClass('comment_error').prop('placeholder', 'Добавьте комментарий...');
					},
					error: function(){
						alert('Не удалось добавить комментарий. Попробуйте позже.');
					}
				});
			}
		}
	}
}


//Добавляет лайк публикации
function addLike(event){
	var publication_id = $('.visible_big_publication').attr('id');
	var data = new FormData();
	
	data.append('publication_id', publication_id);

	$.ajax({
		type: 'post',
		url: 'http://instagram/publication/addLike/',
		data: data,
		processData: false,
		contentType: false,
		success: function(data){
			//Меняем картинку на закрашенное сердце
			$('#button_like > img').attr('src', '/img/cyte/heart_red.png');
			//Меняем значение onclick на функцию удаления лайка
			$('#button_like').attr('onclick', 'delLike(event)');
			//Увеличиваем количество лайков на 1
			$('#buttons > p > span').html(Number($('#buttons > p > span').html()) + 1);

			//Увеличиваем количество лайков на 1 на главной странице
			var publication = $('.center_content').children('#' + publication_id);
			var likes = publication.find('.fa-heart > span');
			likes.html(Number(likes.html()) + 1);
		
		},
		error: function(){
			alert('Произошла ошибка. Попробуйте позже.');
		}
	});
}

//Удаляет лайк публикации
function delLike(event){
	var publication_id = $('.visible_big_publication').attr('id');
	var data = new FormData();

	data.append('publication_id', publication_id);

	$.ajax({
		type: 'post',
		url: 'http://instagram/publication/delLike/',
		data: data,
		processData: false,
		contentType: false,
		success: function(data){
			//Меняем картинку на пустое сердце
			$('#button_like > img').attr('src', '/img/cyte/heart.png');
			//Меняем значение onclick на функцию добавления лайка
			$('#button_like').attr('onclick', 'addLike(event)');
			//Уменьшаем количество лайков на 1
			$('#buttons > p > span').html(Number($('#buttons > p > span').html()) - 1);

			//Уменьшаем количество лайков на 1 на главной странице
			var publication = $('.center_content').children('#' + publication_id);
			var likes = publication.find('.fa-heart > span');
			likes.html(Number(likes.html()) - 1);
		},
		error: function(){
			alert('Произошла ошибка. Попробуйте позже.');
		}
	});
}

//Добавляет лайк комментарию
function addLikeComment(event)
{
	var elemet_li = event.target.closest('li');
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

//Отслеживает скрол на странице пользователя, для подгрузки публикаций
$(document).ready(function(){
	var inProgress = false; //Отслеживает запущен ли запрос к серверу
	var count_pub = 12; //Начальное количество показанных новостей
	var url = document.location.pathname;
	var user_login = url.match(/user\/(\S+)(\/)/);	
	var data = new FormData();
	
	data.append('user_login', user_login[1]);

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
							var content = "<div class='item_publication' id=" + data['public_id'] + ">";
							content += "<img src='/img/users_publications/" + data['img'] + "'alt=''>";
							content += "<div class='background_publication'><p id='delete_publication' onclick='comfirmedForm(event)'><i class='fas fa-times'></i></p>";
							content += "<p class='likes_comment'>";
							content += "<span><i class='fas fa-heart'>&nbsp;<span>" + data['likes'] + "</span></i></span>";
							content += "<span><i class='fas fa-comment'>&nbsp;<span>" + data['count_comment'] + "</span></i></span></p></div></div>";

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