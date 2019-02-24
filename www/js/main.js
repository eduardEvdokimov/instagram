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

function showForm() {
	$('#background_form').show();
}