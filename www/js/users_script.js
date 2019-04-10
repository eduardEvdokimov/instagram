//Валидация данных и регистрация пользователя
function registerUser(){

	var empty = false; //Проверка пустых полей, по умолчанию false
	var error = false; //Проверка ошибок введенных данных, по умолчанию false
	var data = new FormData();
	//Проверяем все инпуты, кроме поля имени_фамилии на пустоту
	$('#form_register').find('input').each(function(index, item){
		if($(item).attr('name') != 'name')
			if(item.value.match(/^\s+$/m) || item.value == '')
				//Если поле заполнено пробелами или пустое
				empty = true;
	});
	//Проверяем есть ли пустоты
	if(empty){
		//Если есть, очищаем все поля с ранее выведенными ошибками
		$('#form_register').find('span').html('');
		//Выводим сообщение с ошибкой
		$('#message').html('Нужно заполнить обязательные поля*');
		return; //Выходим из функции
	}else
		//Если все поля заполнены, убираем сообщение с ошибкой
		$('#message').html('');

	//Проверка полей на количество символов
	if($("[name='login']").val().length < 3){
		$('#login').html('Слишком короткий логин');
		error = true;
	}else{
		//Если длина поля соблюдена, очищаем поле с ошибкой логина 
		$('#login').html('');
		//Проверяем на ввод кирилицы
		if($("[name='login']").val().match(/\W+/)){
			$('#login').html('Логин не должен содержать символов кирилицы.');
			error = true;
		}else{
			$('#login').html('');
		}
	}

	if($("[name='password']").val().length < 3){
		$('#password').html('Слишком короткий пароль');
		error = true;
	}else
		$('#password').html('');

	if(error) return; //Если есть ошибки, останавливаем скрипт
	
	//Записываем данные в объект для отправки на сервер 
	data.append('mail', $("[name='mail']").val());
	data.append('name', $("[name='name']").val());
	data.append('login', $("[name='login']").val());
	data.append('password', $("[name='password']").val());
	
	$.ajax({
		type: 'POST',
		url: 'http://instagram/registration/addUser/',
		data: data,
		dataType: 'json',
		processData: false,
		contentType: false,
		success: function(data){
			//Если сервер вернул ошибки, выводим их
			if(data['error']){
				$('#message').html(data['error']);
				return;
			}
			//Если ошибок нет, проверяем есть ли сообщение с успехом
			if(data['message'] !== ''){ 
			//Если ошибок нет, скрываем блок регистрации и показываем блок подтверждения пароля
				$('#form_register').addClass('hidden');
				$('#block_confirm_account').removeClass('hidden');
				$('#login_social').addClass('hidden');
			}
		},
		error: function(){
			alert('Не удалось зарегистрироваться');
		}
	});
}

//Авторизация пользователя
function loginUser()
{
	var empty = false;
	var data = new FormData();

	$('#form_login').find('input').each(function(index, item){
		if(item.value.match(/^\s+$/m) || item.value == '')
			empty = true;
	});

	if(empty){
		$('#form_register').find('#error').html('');
		$('#error').html('Нужно заполнить все поля');
		return;
	}else
		$('#error').html('');

	data.append('login_mail', $("[name='login_mail']").val());
	data.append('password', $("[name='password']").val());
	
	$.ajax({
		type: 'POST',
		url: 'http://instagram/login/login/',
		data: data,
		dataType: 'json',
		processData: false,
		contentType: false,
		success: function(data){
			$('#error').html(data['error']);

			if(data['success'] == true){
				var date = new Date(); //Объявляем объект с датой
				date.setDate(date.getDate() + 7); //Прибовляем к текущей дате 7 дней
				//Записываем куку логина или мыла
				document.cookie = 'login_mail=' + data['login_mail'] + ';expires=' + date.getDate() + ';path=/'; 
				//Записываем куку пароля
				document.cookie = 'password=' + data['password'] + ';expires=' + date.getDate() + ';path=/'; 
				//Редирект на главную
				document.location.href= 'http://instagram/';
			}
		},
		error: function(){
			alert('Не удалось зарегистрироваться');
		}
	});
}

//Подписка на новый аккаунт
function subscribe(event)
{	
	var data = {};

	//Получаем id объекта подписки (на кого подписываются)
	data['sub_object'] = $('#sub_object').val();
	
	if(data['sub_object'] == undefined){
		var element_li = event.target.closest('li');
		//Делаем скрыпт универсальным. Записываем из списка самых 
		//популярных пользователей логин, на кого хотим подписаться.
		//В data['sub_object'] будет либо значение поля #sub_object либо li.id 
		//в зависимости на какой старнице отрабатывает скрипт
		data['sub_object'] = element_li.id;
		var is_list_users = true;
	}

	if($(event.target).closest('#popup_window_user_list').length){
		var element_li = event.target.closest('li');
		//Делаем скрыпт универсальным. Записываем из списка самых 
		//популярных пользователей логин, на кого хотим подписаться.
		//В data['sub_object'] будет либо значение поля #sub_object либо li.id 
		//в зависимости на какой старнице отрабатывает скрипт
		data['sub_object'] = element_li.id;
		var is_list_users = true;
	}
	
	$.ajax({
		type: 'post',
		data: data,
		url: 'http://instagram/user/subscribe/',
		success: function(data){
			if(data == true){
				if(is_list_users){
					$(element_li)
					.children('#sub')
					.html('Отписаться')
					.attr({'id': 'unsub', 'onclick': 'unSubscribe(event)'});	
				}else{
					//Если ошибок по серверной части не возникло
				//Скрываем кнопку подписки
				$('#sub').removeClass('show').addClass('hidden');
				//Отображаем кнопку отписки
				$('#unsub').removeClass('hidden').addClass('show');
				}
			}
		},
		error: function(){
			alert('Ошибка. Попробуйте позже.');		
		}
	});
}

//Отписка от аккаунта
function unSubscribe(event)
{
	var data = {};
	//Получаем id объекта подписки (на кого подписываются)
	data['sub_object'] = $('#sub_object').val();
	
	if(data['sub_object'] == undefined){
		var element_li = event.target.closest('li');
		//Делаем скрыпт универсальным. Записываем из списка самых 
		//популярных пользователей логин, на кого хотим подписаться.
		//В data['sub_object'] будет либо значение поля #sub_object либо li.id 
		//в зависимости на какой старнице отрабатывает скрипт
		data['sub_object'] = element_li.id;
		var is_list_users = true;
	}

	if($(event.target).closest('#popup_window_user_list').length){
		var element_li = event.target.closest('li');
		//Делаем скрыпт универсальным. Записываем из списка самых 
		//популярных пользователей логин, на кого хотим подписаться.
		//В data['sub_object'] будет либо значение поля #sub_object либо li.id 
		//в зависимости на какой старнице отрабатывает скрипт
		data['sub_object'] = element_li.id;
		var is_list_users = true;
	}

	$.ajax({
		type: 'post',
		data: data,
		url: 'http://instagram/user/unSubscribe/',
		success: function(data){
			if(data == true){
				if(is_list_users){
					$(element_li)
					.children('#unsub')
					.html('Подписаться')
					.attr({'id': 'sub', 'onclick': 'subscribe(event)'});		
				}else{
					//Если ошибок по серверной части не возникло
					//Отображаем кнопку подписки
					$('#sub').addClass('show').removeClass('hidden');
					//Скрываем кнопку отписки
					$('#unsub').addClass('hidden').removeClass('show');
				}		
			}
		},
		error: function(){
			alert('Ошибка. Попробуйте позже.');		
		}
	});
}

//Показывает списко подписчиков или подписок
function showWindowListUsers(event)
{
	var url = document.location.pathname;
	var user_login = url.match(/user\/(\S+)(\/)/);
	user_login = user_login[1];
	var type = $(event.target).attr('name');
	
	$.ajax({
		type: 'post',
		url: 'http://instagram/user/getSubUsers/',
		data: {'user_login': user_login, 'type': type},
		dataType: 'json',
		success: function(data){
			if(type == 'subscribers'){
				$('#popup_window_user_list > #head > h2').html('Подписчики');
			}else{
				$('#popup_window_user_list > #head > h2').html('Ваши подписки');
			}
			
			$.each(data, function(index, item){
				item.name = (item.name == undefined) ? '' : item.name;
				item.button = (item.button == undefined) ? '' : item.button;

				var content = "<li id='" + item.login + "'><a href='http://instagram/user/" + item.login + "/'><img src='/img/users_avatar/" + item.avatar + "' alt=''></a><div><a href='http://instagram/user/" + item.login + "/'>";
				content += "<p id='login'>" + item.login + "</p>";
				content += "<p id='name'>" + item.name + "</p></a></div>";
				content += item.button + "</li>";

				$('#popup_window_user_list > #list_users > ul').append(content);
			});
			
			$('html').css('overflow', 'hidden');
			$('#bg_popup_window').removeClass('hidden');
		},
		error: function(){
			alert('Произошла ошибка. Попробуйте позже.');
		}
	});
}

//Показывает форму восстановления пароля
function showFormResetPass()
{
	$('#form_login').addClass('hidden');
	$('#form_restore_password').removeClass('hidden');
	$('#form_register').addClass('hidden');
	$('#login_social').addClass('hidden');
}
//Показывает форму входа
function backLogin()
{
	$('#form_login').removeClass('hidden');
	$('#form_restore_password').addClass('hidden');
	$('#form_register').removeClass('hidden');
	$('#login_social').removeClass('hidden')
}

//Отправляет сообщение для востановления пароля
function sendMsgRestore()
{
	var login_mail = $('#login_mail').val();

	if(login_mail.length == 0 || login_mail.search(/^\s+$/) == 0){
		$('#error_input').removeClass('hidden');
		$('#login_mail').css('border', '1px solid red');
		return;
	}else{
		$('#error_input').addClass('hidden');
		$('#login_mail').css('border', '1px solid silver');
	}

	$.ajax({
		type: 'post',
		url: 'http://instagram/login/restorePassword/',
		data: {'login_mail': login_mail},
		success: function(data){
			console.log(data);
			if(data == true){
				$('#success_msg').removeClass('hidden');
				$('#form_restore_password').addClass('hidden');
			}else{
				$('#error_user').removeClass('hidden');
			}
		},
		error: function(){
			alert('error');
		}
	});
}

//Сохраняет новый пароль
function saveNewPassword(){

	if($('#new_password').val().length == 0 || $('#new_password').val().search(/^\s+$/) == 0){
		$('#error_msg').html('Заполните поля');
		return;
	}

	if($('#new_password').val().length < 3 ){
		$('#error_msg').html('Слишком короткий пароль');
		return;
	}

	if($('#new_password').val() !== $('#repeat_password').val()){
		$('#error_msg').html('Пароли должны совпадать');
		return;
	}		

	$('#error_msg').html('');
	var code = document.location.search.match(/code=(\S+)/);
	code = code[1];

	$.ajax({
		type: 'post',
		url: 'http://instagram/login/saveNewPassword/',
		data: {'password': $('#new_password').val(), 'code': code},
		success: function(data){
			if(data == true){
				$('#error_msg').html('Пароль успешно сохранен.');
				setTimeout(function(){
					document.location.href = 'http://instagram/login/index/';
				}, 5000);
			}
		},
		error: function(){
			alert('Произошла ошибка сервера. Попробуйте позже.');
		}
	});
}