


<input type='hidden' id='id_subscriber' value="{$id_subscriber}">
<input type='hidden' id='sub_object' value="{$sub_object}">
<div id='button'>
	{$buttonSub}
	{$buttonUnSub}
	{$AddPublications}
	{$buttonChangeSettingData}
</div>

<div id='background_form' hidden="">
	<form>
		<input type='file' name='file'>
		<input type="text" name="article" placeholder="Добавьте описание">
		<input type='text' name='hashtags' placeholder="Добавьте хештеги">
		<input type="submit" name="Опубликовать">

	</form>
</div>
	
