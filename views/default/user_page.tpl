


<input type='hidden' id='id_subscriber' value="{$id_subscriber}">
<input type='hidden' id='sub_object' value="{$sub_object}">
<div id='button'>
	{$buttonSub}
	{$buttonUnSub}
	{$AddPublications}
	{$buttonChangeSettingData}
</div>

<div id='background_form' class='hidden'>
	<div id='form_publications'>
		<input type='file' name='file' id='file' multiple=""><br>
		<p>Описание</p>
		<textarea name="article" id='article' rows='5' cols="30"></textarea><br>
		<p>Хештеги</p>
		<textarea name='hashtags' id='hashtags' rows='5' cols="30"></textarea><br>
		<button name="Опубликовать" onclick='addPublication(); return false;' >Опубликовать</button>
		<p id='message'></p>
	</div>

</div>
	

	{foreach from=$publications key=k item=value}

		<img src="/img/users_publications/{$value.img}" alt='' height='100'>


	{/foreach}