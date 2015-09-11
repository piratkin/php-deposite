<?php

define("DEBUG",                                                 0); //задаем отображение переменных
define("PAGES",                                                 5); //задаем длинну поля навигации  
define("OUTPUT_RECORDS",                                       10); //число записей на один лист
//параметры подключения к БД:
define("MYSQL_HOST",                             "127.0.0.1:3306"); //адресс SQL-базы данных  
define("MYSQL_USER",                                       "root"); //имя пользователя БД  
define("MYSQL_PASSWORD",                                       ""); //пароль пользователя БД  
define("MYSQL_DATABASE",                               "deposite");
define("MYSQL_USER_TBL",                                  "users");
define("MYSQL_FILE_TBL",                                  "files");
//настройки фронтенда
define("CLIENT_UPDATE_PERIOD",                               5000); //период обновления страницы клиентами
define("CLIENT_MAX_RETRY",                                      3); //количество попыток соединится с сервером (может приводить к утечке памяти!!!)
define("MAX_FILE_SIZE",                              30*1024*1024); //максимально допустимый обьем хранилища в байтах
define("MAX_STORAGE_SIZE",                          100*1024*1024); //максимально допустимый обьем хранилища в байтах
//Коды ошибок для фронтенда:
define("TRANSACTION_SUCCESS",                                   0);
define("UPLOAD_AUTORIZATION_ERROR",                             9);
define("EXCEEDEED_STORAGE_LIMIT",                              10);
define("SAVE_FILE_ERROR",                                      11);
define("DATABASE_UPLOAD_ERROR",                                12);
define("DATABASE_UPLOAD_UNKNOWN",                              13);
define("UPLOAD_FILE_ERROR",                                    14);
//Коды ошибок для бэкенда:
define("AUTORIZATION_ERROR",                                   20);
define("DATABASE_UNKNOWN",                                     21);
define("DATABASE_ERROR",                                       22);
define("FILE_NOT_FOUND",                                       23);
//
define("TEMP_UPLOAD_PATH", "..\\deposite.host.by\\.downloads\\"); //директория хранилища
//
$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
if ($db) mysql_select_db(MYSQL_DATABASE); else return_error(DATABASE_UPLOAD_UNKNOWN);

function return_error($error) {   
    if ($error <= UPLOAD_FILE_ERROR) {
	    echo "<script language='javascript' type='text/javascript'>window.top.window.stopUpload(".$error.");</script>";
	} else if ($error) {
	    header("HTTP/1.0 406 Not Acceptable");
		switch ($error) {
		  case   DATABASE_UNKNOWN: echo "Сервер БД не найден!";             break;
		  case     DATABASE_ERROR: echo "Сервер БД не отвечает!";           break;
		  case AUTORIZATION_ERROR: echo "Ошибка авторизации в системе!";    break;
		  case     FILE_NOT_FOUND: echo "Файл не найден!";                  break;
		  default                : echo "Неопознанная ошибка №".$error."!"; break;
		};
	}
	//print_status();
	if (isset($db_user)) {
	    mysql_close($db_user); 
		unset($db_user);
	}
	if (isset($db_file)) {
	    mysql_close($db_file); 
		unset($db_file);
	}
	exit();
}
function print_status() {
    global $status;
    echo "<br>";
	printf("status: %b:<br>", $status);
    if (test(HAS_LOGIN))        echo "HAS_LOGIN<br>";
	if (test(HAS_PASSWORD))     echo "HAS_PASSWORD<br>";
	if (test(HAS_REQUEST_PAGE)) echo "HAS_REQUEST_PAGE<br>";
	if (test(HAS_REQUEST_ID))   echo "HAS_REQUEST_ID<br>";
	if (test(HAS_AJAX))         echo "HAS_AJAX<br>";
	if (test(HAS_HASH))         echo "HAS_HASH<br>";
	if (test(HAS_NAME))         echo "HAS_NAME<br>";
	if (test(HAS_TMP_NAME))     echo "HAS_TMP_NAME<br>";
	if (test(HAS_SIZE))         echo "HAS_SIZE<br>";
	if (test(HAS_ERROR))        echo "HAS_ERROR<br>";
	if (test(ACCESS_LOGIN))     echo "ACCESS_LOGIN<br>";
	if (test(ACCESS_PASSWORD))  echo "ACCESS_PASSWORD<br>";
	if (test(USER_HASH_ACCESS)) echo "USER_HASH_ACCESS<br>";
}
