<?php
//проверяем наличие места в хранилище
$response = mysql_query("SELECT SUM(size) AS total_size FROM ".MYSQL_FILE_TBL." WHERE state <> 0");
if ($response) {
    $row = mysql_fetch_assoc($response);
	mysql_free_result($response);
	unset($response);
	if (isset($row['total_size']) && $row['total_size'] > MAX_STORAGE_SIZE) return_error(EXCEEDEED_STORAGE_LIMIT);
} else {
    return_error(DATABASE_UPLOAD_ERROR);
}
//сохраняем атрибуты фаила в БД
$id    = md5(uniqid(rand(), 1));
$name  = $_FILES['file_name']['name'];
$mail  = $_POST['user_login'];
$date  = date("Y-m-d H:i:s");
$ip    = test(HAS_ADDRESS) ? $_SERVER['REMOTE_ADDR'] : "unknown";
$size  = $_FILES['file_name']['size'];
$query = "INSERT INTO `".MYSQL_DATABASE."`.`".MYSQL_FILE_TBL."` (`id`, `name`, `mail`, `date`, `ip`, `state`, `size`) VALUES ('".$id."', '".$name."', '".$mail."', '".$date."', '".$ip."', 0, ".$size.")";
if (!mysql_query($query)) return_error(DATABASE_UPLOAD_ERROR);
//Перемещаем файл в хранилище
if (!move_uploaded_file($_FILES['file_name']['tmp_name'], TEMP_UPLOAD_PATH.$id)) return_error(SAVE_FILE_ERROR);
//подтверждаем сохранение данных в БД
$save_date  = date("Y-m-d H:i:s"); //
$query = "UPDATE `".MYSQL_DATABASE."`.`".MYSQL_FILE_TBL."` SET `date`='".$save_date."', `state`=1 WHERE `id`='".$id."' AND `state`=0 LIMIT 1";
if (!mysql_query($query)) return_error(DATABASE_UPLOAD_ERROR);
//возыращаем состояние полученного файла
return_error(test(HAS_ERROR) ? $_FILES['file_name']['error'] : UPLOAD_FILE_ERROR);