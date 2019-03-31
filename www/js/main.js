//Отображает форму добавления публикации
function showForm() 
{
	$('#background_form').fadeIn(); //Плавно показываем блок
	$('#background_form').removeClass('hidden');
	$('#background_form').addClass('background_form_show');
	$('#form_publications').fadeIn(); //Плавно показываем блок
	//отмена скрола страницы
	$("body").css("overflow","hidden");
}


//отслеживаем где на что кликнули, для скрытия всплывающих окон
$(document).click(function(e) {	


	if(event.target.className == 'count_info')
   		return;
  	
  	
 	if(event.target.id == 'bg_popup_window'){
 		 $('#bg_popup_window').addClass('hidden');
 		 $('html').css('overflow', 'auto');
 	}
  		
  


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
			console.log(data);
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
			alert('error');
		},
		complete: function(){
			$('#notification').attr('onclick', 'showNotification()');
		}

	});
}


function search(event){

	if((event.target.value.length >= 3) && (event.keyCode != 8)){
		$.ajax({
			type: 'post',
			url: 'http://instagram/search/search/',
			data: {'search': event.target.value},
			dataType: 'json',
			success: function(data){
				console.log(data);

				if(data){

					if($('#form_search > ul').find('li').length > 0)
						var dropDownList = true;						
					else
						var dropDownList = false;
					
					

					$.each(data, function(index, item){

						if(dropDownList){
							
							for(var i = 0; i < $('#form_search > ul').find('li').length; i++){
								var li = $('#form_search > ul').find('li')[i];
								var p = $(li).find('.login');
								var match = item.match(/<p\sclass='login'>(\S+)<\/p>/u);
								console.log(p.html() + '____' + match[1]);

								if(p.html() == match[1]){
									var chek_sovp = true;
									break;
								}
							}

							if(!chek_sovp)
								$('#form_search > ul').append(item);
							
						}else{
							$('#form_search > ul').append(item);
						}
					});
					$('#form_search > ul').removeClass('hidden');
				}

				
				
			},
			error: function(){
				alert('error');
			}
		});


	}
	if(event.target.value.length <= 1){
		$('#form_search > ul').html('').addClass('hidden');
	}
		
}