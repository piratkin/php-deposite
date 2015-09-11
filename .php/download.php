<?php
//отключаем кеширование (нужно только для `readfile`!)
if (ob_get_level()) ob_end_clean();
//поиск фаила в БД
$response = mysql_query("SELECT * FROM `".MYSQL_FILE_TBL."` WHERE `id`='".$_POST['user_file']."'  LIMIT 1");
if ($response) {
	$row = mysql_fetch_assoc($response);
	mysql_free_result($response);
	unset($response);
} else {
	return_error(DATABASE_ERROR);
}
//отправка файла клиенту
if (file_exists(TEMP_UPLOAD_PATH.$row['id'])) {
	header('Content-Type: application/octet-stream; charset=utf-8');
	header('Content-Disposition:attachment;filename='.htmlentities($row['name']));
	header('Cache-Control:'); 
	readfile(TEMP_UPLOAD_PATH.$row['id']);
} else {
    return_error(FILE_NOT_FOUND);
}

exit();