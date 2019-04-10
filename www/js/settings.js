//Проверяет повтор логинов
function heckLogin(event)
{
	var login = event.target.value;
	//Проверка, на ввод своего логина
	if($('#my_login').html() == login){
		$('#login_error').addClass('hidden');
		return;
	}

	if(login.length < 3){
		$('#login_error_min_size').removeClass('hidden');
		$('#login_error_kirilica').addClass('hidden');
		$('#login_error').addClass('hidden');
		$('#btn_save').attr('disabled', 'disabled');
		$('#input_login').css('border', '1px solid red');
		return;
	}else{
		$('#login_error_min_size').addClass('hidden');
		$('#btn_save').removeAttr('disabled');
		$('#input_login').css('border', '1px solid silver');
	}
	//Проверка на кирилицу
	if(login.match(/\W+/)){
		$('#login_error_kirilica').removeClass('hidden');
		$('#btn_save').attr('disabled', 'disabled');
		$('#input_login').css('border', '1px solid red');
		return;
	}else{
		$('#login_error_kirilica').addClass('hidden');
		$('#btn_save').removeAttr('disabled');
		$('#input_login').css('border', '1px solid silver');
	}

	if(login.length >= 3)
		$.ajax({
			type: 'post',
			url: 'http://instagram/settings/loginCheck/',
			data: {'login': login},
			success: function(data){
				if(!data){
					$('#login_error').removeClass('hidden');
					$('#input_login').css('border', '1px solid red');
				}else{
					$('#login_error').addClass('hidden');
					$('#input_login').css('border', '1px solid silver');
				}
			},
			error: function(){
				alert('Произошла ошибка сервера. Попробуйте позже.');
			}
		});
}

//Проверяет, правильно ли пользователь ввел свой пароль
function heckPassword(event)
{
	var password = event.target.value;

	if(password.length == 0){
		$('#pass_error').addClass('hidden');
		$('#btn_save').removeAttr('disabled');
		$('#old_pass').css('border', '1px solid silver');
	}

	if(password.length > 0)
		$.ajax({
			type: 'post',
			url: 'http://instagram/settings/passwordCheck/',
			data: {'password': password},
			success: function(data){
				if(!data){
					$('#pass_error').removeClass('hidden');
					$('#btn_save').attr('disabled', 'disabled');
					$('#old_pass').css('border', '1px solid red');
				}else{
					$('#pass_error').addClass('hidden');
					$('#btn_save').removeAttr('disabled');
					$('#old_pass').css('border', '1px solid silver');
				}
			},
			error: function(){
				alert('Произошла ошибка сервера. Попробуйте позже.');
			}
		});
}

//Динамически изменяет аватарку пользователя, помещаяя ее во временное хранилище
function changeAvatar(event)
{
	var data = new FormData();
	var file = event.target.files[0];

	if(file == null)
		return;
	
	data.append('file', file);

	$.ajax({
		type: 'post',
		url: 'http://instagram/settings/changeAvatar/',
		data: data,
		processData: false,
		contentType: false,
		success: function(data){
			$('li > img').attr('src', data);
		},
		error: function(){
			alert('Произошла ошибка сервера. Попробуйте позже.');
		}
	});
}

//Сохраняет изменения в данных пользователя
function saveChangeSettings(event)
{
	var data = new FormData();
	var file = document.getElementById('file').files[0];

	if(file == undefined)
		file = null;

	data.append('file', file);
	//Проходимся по всем полям, и формируем объекс с данными
	$.each($('.pole'), function(index, item){
		data.append(item.name, item.value);
	});
	//Проверка, на длину пароля
	if($('#new_pass').val().length < 3 && $('#new_pass').val().length > 0){
		$('#new_pass_error').removeClass('hidden');
		return;
	}else
		$('#new_pass_error').addClass('hidden');

	//Проверка, новый пароль введен, а старый нет
	if(($('#old_pass').val().length < 3) && ($('#new_pass').val().length >= 3)){
		$('#old_pass').css('border', '1px solid red');
		return;
	}else
		$('#old_pass').css('border', '1px solid silver');

	$.ajax({
		type: 'post',
		url: 'http://instagram/settings/saveChange/',
		data: data,
		processData: false,
		contentType: false,
		beforeSend: function(){
			event.target.setAttribute("disabled", "disabled");
		},
		success: function(data){
			if(data == true)
				$('.success').removeClass('hidden');
			else
				$('.error_form').removeClass('hidden');
		},
		error: function(){
			alert('Произошла ошибка сервера. Попробуйте позже.');
		},
		complete: function(){
			event.target.removeAttribute('disabled');
		}
	});
}