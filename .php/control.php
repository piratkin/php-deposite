<?php
define("HAS_LOGIN",        (1  <<  0)); //бит корректности логина
define("HAS_PASSWORD",     (1  <<  1)); //бит корректности пароля
define("HAS_REQUEST_PAGE", (1  <<  2)); //бит наличия под запроса страницы
define("HAS_REQUEST_ID",   (1  <<  3)); //бит наличия под запроса файла
define("HAS_AJAX",         (1  <<  4)); //бит уст. в случае ajax-запроса
define("HAS_HASH",         (1  <<  5)); //бит наличия под hash-кода в запросе
define("HAS_NAME",         (1  <<  6)); //бит наличия атрибута фаила
define("HAS_TMP_NAME",     (1  <<  7)); //бит наличия атрибута фаила
define("HAS_SIZE",         (1  <<  8)); //бит наличия атрибута фаила
define("HAS_ERROR",        (1  <<  9)); //бит наличия атрибута фаила
define("ACCESS_LOGIN",     (1  << 10)); //подтверждение валидности формата
define("ACCESS_PASSWORD",  (1  << 11)); //подтверждение валидности формата
define("ACCESS_PAGE",      (1  << 12)); //подтверждение валидности запроса страницы
define("HAS_ADDRESS",      (1  << 13)); //наличие адресса
define("USER_HASH_ACCESS", (1  << 14)); //проверка на валидность по БД
//
define("REQUEST_AJAX",                      HAS_AJAX | USER_HASH_ACCESS | HAS_REQUEST_PAGE); //разрешение ajax-запроса
define("ERROR_AJAX",                                                             HAS_AJAX ); //неправильный ajax-запроса
define("REQUEST_AUTHORIZATION",                                           USER_HASH_ACCESS); //разрешение на авторизацию
define("REQUEST_UPLOAD", USER_HASH_ACCESS | HAS_NAME | HAS_ERROR | HAS_TMP_NAME | HAS_SIZE); //разрешение на загрузку фаилов
define("REQUEST_DOWNLOAD",                               USER_HASH_ACCESS | HAS_REQUEST_ID); //
define("ERROR_UPLOAD",                                                           HAS_NAME ); //

$status = 0; //состояние запроса клиента

function test_post($mask, $index) {
	if (isset($_POST[$index]) && !empty($_POST[$index])) return $mask; else return 0;
}
function test_http($mask, $index, $value) {
	if (isset($_SERVER[$index]) && !empty($_SERVER[$index])) {
	    if ($value) {
		    if (strtolower($_SERVER[$index]) == $value) return $mask; else return 0;
		} return  $mask;
	} return 0;	
}
function test_file($mask, $index_file, $index_sys) {
    if (isset($_FILES[$index_file][$index_sys])) return $mask; else return 0;
}
function test($mask) {
    global $status;
    return (($status & $mask) == $mask);
}
//тестируем запрос клиента
$status += test_post(HAS_REQUEST_PAGE,                               'user_page');
$status += test_post(HAS_LOGIN,                                     'user_login');
$status += test_post(HAS_PASSWORD,                                   'user_pass');
$status += test_post(HAS_HASH,                                       'user_code');
$status += test_post(HAS_REQUEST_ID,                                 'user_file');
$status += test_http(HAS_AJAX,         'HTTP_X_REQUESTED_WITH', 'xmlhttprequest');
$status += test_http(HAS_ADDRESS,      'REMOTE_ADDR',                          0);
$status += test_file(HAS_NAME,         'file_name',                       'name');
$status += test_file(HAS_TMP_NAME,     'file_name',                   'tmp_name');
$status += test_file(HAS_SIZE,         'file_name',                       'size');
$status += test_file(HAS_ERROR,        'file_name',                      'error');
//проверяем корректность формата
if (test(HAS_LOGIN)        && preg_match("/^[0-9a-zA-Z\._-]+@[0-9a-zA-Z\._-]+\.[a-zA-Z]{2,4}$/", $_POST['user_login'])) $status += ACCESS_LOGIN;
if (test(HAS_PASSWORD)     && preg_match("/^.{8,50}$/",                                          $_POST['user_pass']))  $status += ACCESS_PASSWORD;
if (test(HAS_REQUEST_PAGE) && preg_match("/^\d{1,3}$/",                                          $_POST['user_page']))  $status += ACCESS_PAGE;
//всеряем логин и пароль по БД
if (test(ACCESS_LOGIN) && (test(ACCESS_PASSWORD) || test(HAS_HASH))) {
	//поиск клиента в БД
	$response = mysql_query("SELECT * FROM `".MYSQL_USER_TBL."` WHERE `mail`='".$_POST['user_login']."'  LIMIT 1");
	if ($response) {
		$row = mysql_fetch_assoc($response);
		mysql_free_result($response);
		unset($response);
	} else {
		if (test(HAS_NAME)) return_error(DATABASE_UPLOAD_UNKNOWN); else return_error(DATABASE_ERROR);
	}
	//сверяем хэш пароля по БД
	if (isset($row['hash'])) {
		if      (test(HAS_HASH)     &&     $_POST['user_code']  == $row['hash']) $status += USER_HASH_ACCESS;
		else if (test(HAS_PASSWORD) && md5($_POST['user_pass']) == $row['hash']) $status += USER_HASH_ACCESS;
	}
}
