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

//Установка фокуска на элемент
function setFocus(element){
	$(element).focus();
}


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