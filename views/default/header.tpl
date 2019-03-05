<!DOCTYPE html>
<html>
<head>
	<title>{$title}</title>
	<link href='{$TemplateWebPath}/css/main.css' rel='stylesheet'>
	<link rel='stylesheet' href='/fontawesome/css/all.css'>
	<script src='/js/jquery.js' type='text/javascript'></script>
	<script src='/js/main.js' type='text/javascript'></script>
	<script type="text/javascript">

		$(document).click(function(e) {
				  
			if(e.target.id == 'new_pub')
				return;
			
       		if($(e.target.closest('#form_publications')).length)	
         		return;
       		
    		$('#background_form').fadeOut();
    		$('#form_publications').fadeOut();
    		$("body").css("overflow","auto");

  		});

		
  		
  
		
			
		
		
	</script> 
	<meta charset="utf-8">
</head>
<body>
	<header>
		<p id='p'></p>
		<div id='header_content'>
			<h1><a href='http://instagram/'>Instagram</a></h1>
			<form id='searh_form'>
				<input type="text" name="searh">
				<input type="submit" name="sub" value='Найти'>
			</form>
			<div id='userInfo'>
				<img src='{$userAvatarPath}' alt='asdsa' height="20">
				<a href='{$urlProfile}'>{$userLogin}</a>
			</div>
		</div>
	</header>
	<a href='http://instagram/login/logOut/'>Выйти</a>
	
	
