function getData(block)
{
	var data = {};
	$('input', block).each(function(){
		if(this.value !== '')
			data[this.name] = this.value;
	});
	return data;
}


function registerUser(){
	
	var data = getData('#form_register');
	
	$.ajax({
		type: 'POST',
		url: 'http://instagram/registration/addUser/',
		data: data,
		dataType: 'json',
		success: function(data){
					$('#mail').html(data['mail']);

					$('#login').html(data['login']);				

					$('#password').html(data['password']);
				
					$('#message').html(data['error']);

    				if(data['message'] !== ''){
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

	var data = getData('#form_login');
	
	$.ajax({
		type: 'POST',
		url: 'http://instagram/login/login/',
		data: data,
		dataType: 'json',
		success: function(data){
			
			$('#error').html(data['error']);
			

			if(data['success'] == true){
				var date = new Date();
				date.setDate(date.getDate() + 7);
				document.cookie = 'login_mail=' + data['login_mail'] + ';expires=' + date.getDate() + ';path=/'; 
				document.cookie = 'password=' + data['password'] + ';expires=' + date.getDate() + ';path=/'; 
				document.location.href= 'http://instagram/';

			}

		},
		error: function(){
			alert('Не удалось зарегистрироваться');
		}

	});

}

//Подписка на новый аккаунт
function subscribe()
{
	var data = {};

	data['id_subscriber'] = $('#id_subscriber').val();
	
	data['sub_object'] = $('#sub_object').val();
	


	$.ajax({
		type: 'post',
		data: data,
		url: 'http://instagram/user/subscribe/',
		success: function(data){
			if(data == true){
				$('#sub').removeClass('show');
				$('#sub').addClass('hidden');
				$('#unsub').removeClass('hidden');
				$('#unsub').addClass('show');
			}
		
		},
		error: function(){
			alert('error');		
		}
	});

}

//Отписка от аккаунта
function unSubscribe()
{
	var data = {};

	data['id_subscriber'] = $('#id_subscriber').val();
	
	data['sub_object'] = $('#sub_object').val();
	
	$.ajax({
		type: 'post',
		data: data,
		url: 'http://instagram/user/unSubscribe/',
		success: function(data){
			if(data == true){
				$('#sub').addClass('show');
				$('#sub').removeClass('hidden');
				$('#unsub').addClass('hidden');
				$('#unsub').removeClass('show');


			}
		},
		error: function(){
			alert('error');		
		}
	});
}




function showForm() 
{

	$('#background_form').fadeIn();
	$('#background_form').removeClass('hidden');
	$('#background_form').addClass('background_form_show');
	$('#form_publications').fadeIn();
}





function addPublication()
{


	
	var title = $('#article').val();
	var hashtags = $('#hashtags').val();
	var url = window.location.pathname;
	var array_user_id = url.match('([0-9]+)');
	var user_id = array_user_id[0];
	var form = $('#form_publications');
	var message = $('#message');


	if($('#file')[0].files.length > 0)
		var file = $('#file')[0].files;
	else{
		message.text('Нужно выбрать фотографию');
		return false;
	}


	var formData = new FormData();

	formData.append('title', title);
	formData.append('hashtags', hashtags);
	formData.append('file', file[0]);
	formData.append('user_id', user_id);
	
		
	
	$.ajax({
		type: 'post',
		url: 'http://instagram/publication/addPublication/',
		data: formData,
		cache: false,
		contentType: false,
		processData: false, 
		dataType: 'json',
		beforeSend: function(){
			message.text('Отправка данных');
			form.find('input').prop('disabled', true);

		},
		success: function(data){
			form.find('input').prop('disabled', false);
			if(data['image']){
				message.text(data['image']);
			}
			if(data['hashtag']){
				message.text(data['hashtag']);
			}
			if(data['success']){
				form.find('input').prop('value', '');
				form.find('textarea').val('');
				message.text(data['success']);
			}
			
		},
		complete: function(){
			form.find('input').prop('disabled', false);
		},
		error: function(){
			message.text('Ошибка отправки');
			
		}

	});
}