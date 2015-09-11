<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf8'>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<title>MySpace</title>
</head>
<body style="background: #eee; margin: 20px 10%; min-width: 600px;">
<div id="menu">
<ul>
<li style="margin-left: 16px;"><a href="/">Выход</a></li>
<li><a href="#" id='about'>Описание</a></li>
</ul>
</div>
<div style="text-align: center;">
    <form id="send_form" action="/" target="upload_target" method="post" enctype="multipart/form-data" style="text-align: center;">
    <div style="width: 100%;">
	    <div style="margin: 5px 30% 16px 30%; font-style: italic;">Для хранения данных на диске Вам предоставляется 100 MБ свободного пространства. Максимально допустимый размер файла – 30 MБ. Внимание! Удаление фаилов из хранилища может производить лишь пользователь с административными правами!</div>
	</div>
		<p id="upload_form">
		    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
			<input type="file" id="file_name" name="file_name" class="button uploadfile"/>
	        <input id="upload_button" type="submit" class="button" value="Сохранить" />
	        <input type="hidden" id="user_login" name="user_login" value="<?php if (test(ACCESS_LOGIN)) echo $_POST['user_login']; ?>" />
	        <input type="hidden" id="user_code" name="user_code"  value="<?php if (test(ACCESS_PASSWORD)) echo md5($_POST['user_pass']); ?>" />
		    <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff; display:none"></iframe>
		</p>
		<p id="upload_process" style="display: none;"><img src="/img/loader.gif" /> Загрузка... </p>
    </form>
	<div style="height: 24px; width: 100%;">
	    <span id="message"></span>
	</div>
</div>
<script language="javascript" type="text/javascript" src="js/main.js"></script>
<script language="javascript" type="text/javascript">
var result = <?php echo CLIENT_MAX_RETRY; ?>;
function updateFiles(page) {
    if (!page && !(page = $("#current_page").children().html()))  page = 1;
	var data = { user_login : $("#user_login").val(), user_code : $("#user_code").val(), user_page : page };
    $.ajax( {
        url: '/',
        type: 'post',
        data: data,
		success: function (data) {
		    if (result) $("#content_table").html(data);
		    result = 0;
        },
		complete: function(data) {
		    if (result) {
			    if (!(--result)) alert(data.responseText);
			    setTimeout(updateFiles, <?php echo CLIENT_UPDATE_PERIOD; ?>, 0);
            } else result = <?php echo CLIENT_MAX_RETRY; ?>;				
		}
    });
    return true;
};
$("#about").click(function() {
	alert("test!"); 
	return true;
});
$("#send_form").submit(function(event) {
	if ($("#file_name").val() == '') {
		alert("Сначала надо выбрать фаил!"); 
		event.preventDefault();
		return false;
	} 
	$("#upload_process").css('display', 'inline');
	$("#upload_form").css('display', 'none');
    return true;
});
</script> 
<div id="form_container" style="width:0;height:0;border:0px solid #fff; display:none"></div>
<div style="margin: 5px 30% 5px 30%;">
<noscript>К сожалению Ваш браузер не поддерживает JavaScript по этой причине динамическое обновление таблицы не возможно!</noscript>
</div>
<div id="content_table" style="width: 100%; height: 100%; position: relative; border: 1px #000;">
<?php include ".php/ajax.php"; ?>
</div>
</body>
</html>