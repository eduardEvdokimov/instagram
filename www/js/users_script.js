//Валидация данных и регистрация пользователя
function registerUser(){

	var empty = false; //Проверка пустых полей, по умолчанию false
	var error = false; //Проверка ошибок введенных данных, по умолчанию false

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
	
	var data = new FormData();
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
				$('#block_register').hide();
				$('#block_confirm_account').show();
			}
		},
		error: function(){
			alert('Не удалось зарегистрироваться');
		}

	});
}


function loginUser()
{
	var empty = false;

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


	var data = new FormData();

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
	console.log(data['sub_object']);
	if(data['sub_object'] == undefined){
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
			console.log(data);
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
function unSubscribe()
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

	$.ajax({
		type: 'post',
		data: data,
		url: 'http://instagram/user/unSubscribe/',
		success: function(data){
			console.log(data);
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