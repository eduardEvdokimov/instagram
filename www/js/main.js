//Отображает форму добавления публикации
function showForm() 
{
	$('#background_form').fadeIn(); //Плавно показываем блок
	$('#background_form').removeClass('hidden');
	$('#background_form').addClass('background_form_show');
	$('#form_publications').fadeIn(); //Плавно показываем блок
	//отмена скрола страницы
	$("html").css("overflow","hidden");
}

//отслеживаем на что кликнули, для скрытия всплывающих окон
$(document).click(function(e){	
	if(e.target.className == 'count_info')
   		return;

  	if($(e.target).closest('#delete_publication').length)
  		return;

  	if($(e.target).closest('#form').length)
  		return;
  	
 	if(e.target.id == 'bg_popup_window'){
 		 $('#bg_popup_window').addClass('hidden');
 		 $('#popup_window_user_list > #list_users > ul').html('');
 		 $("html").css("overflow","auto"); //Возращаем полосу прокрутки
 		 return;
 	}

 	if($(e.target).closest('#popup_window_user_list').length)
 		return;
  		
  	if(e.target.className == "background_publication")
  		return;
  	
	if(e.target.id == 'new_pub')
	//Если у нажатого элемента id = new_pub, выходим из функции
		return;
		
   	if($(e.target).closest('#form_publications').length)
   	//Если нажали на div с id = form_publications или на его дочерний элемент выходим из функции
     	return;

   	if($(e.target).closest('.visible_big_publication').length)
   	//Если нажали на div с id = visible_big_publication или на его дочерний элемент выходим из функции
     	return;
 	
    //Окно подтверждения удаления публикации
 	$('#bg_popup_confirmation').addClass('hidden');

   	//Если не одно условие не выполнилось, скрываем открытое окно большой публикации	
	$('#background_window_pub').removeClass('background_window_pub').addClass('hidden');

	$("html").css("overflow","auto"); //Возращаем полосу прокрутки
	//Форма добавления публикации
	$('#background_form').fadeOut(); 
	$('#form_publications').fadeOut();
	$('#form_publications > #form > #message').html('');
});

//Показывает окно с уведомлениями
function showNotification()
{
	$.ajax({
		type: 'post',
		url: 'http://instagram/notification/getNotification/',
		dataType: 'json',
		beforeSend: function(){
			$('#notification').attr('onclick', '');
		},
		success: function(data){
			if(data){
				$.each(data, function(index, item){
					$('#window_notification > ul').append(item['visible_item']);
					$('#window_notification').removeClass('hidden');
					$('#notification > span').html('').addClass('hidden');
				});		
			}else{
				$('#window_notification > ul').append('<p id=\'empty_notification\'>Здесь будут показаны отметки "Нравится" и комментарии к вашим публикациям.</p>');
				$('#window_notification').removeClass('hidden');		
			}
		},
		error: function(){
			alert('Произошла ошибка сервера. Попробуйте позже.');
		},
		complete: function(){
			$('#notification').attr('onclick', 'showNotification()');
		}
	});
}

//Активирует строку поиска
function search(event){
	//Проверяем что введено больше 3 символов и не нажали на backspace
	if((event.target.value.length >= 3) && (event.keyCode != 8)){
		$.ajax({
			type: 'post',
			url: 'http://instagram/search/search/',
			data: {'search': event.target.value},
			dataType: 'json',
			success: function(data){
				//Проверяем что массив не пустой
				if(data != null)
				if(data.length > 0){
					//Проверяем, что элементы в выпадающем списке уже есть
					if($('#form_search > ul').find('li').length > 0)
						var dropDownList = true;						
					else
						var dropDownList = false;
					
					//Проходимся по массиву
					$.each(data, function(index, item){
						if(dropDownList){
							//Проходимся по элементам выпадающего списка и проверяем с данными, которые пришли
							for(var i = 0; i < $('#form_search > ul').find('li').length; i++){
								//Извлекаем содержимое каждого элемента выпадающего списка
								var li = $('#form_search > ul').find('li')[i];
								var p = $(li).find('.login');
								var match = item.match(/<p\sclass='login'>(\S+)<\/p>/);
								//Сравниваем, был ли ранее показан элемент пришедший с сервера
								if(p.html() == match[1]){
									//Если такой элемент уже есть, 
									//прерываем поиск и переходим к следующему элементу серверных данных
									var chek_sovp = true;
									break;
								}
							}
							//Если такой элемент не был ранее показан, показываем его
							if(!chek_sovp)
								$('#form_search > ul').append(item);

						}else{
							//Если выпадающего списка еще нет, добавляем элементы
							$('#form_search > ul').append(item);
						}
					});
					//Показываем выпадающий список
					$('#form_search > ul').removeClass('hidden');
				}
			},
			error: function(){
				alert('Произошла ошибка сервера. Попробуйте позже.');
			}
		});
	}

	if(event.target.value.length <= 1){
		//Если букв меньше 1 скрываем выпадающий список
		$('#form_search > ul').html('').addClass('hidden');
	}	
}