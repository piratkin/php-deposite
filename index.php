<?php

//error_reporting(E_ALL ^ E_DEPRECATED); //убираем предупреждение использ. устаревшего метода подкл. в БД

include ".php/config.php";  //настройки системы
include ".php/control.php"; //проверка пользовательского запроса
include ".php/track.php";   //отслеживание посетителей

if (test(REQUEST_AJAX)) {
    include ".php/ajax.php";
} else if (test(ERROR_AJAX)) {
    return_error(AUTORIZATION_ERROR);
} else if (test(REQUEST_UPLOAD)) {
    include ".php/upload.php";
} else if (test(REQUEST_DOWNLOAD)) {
    include ".php/download.php";
} else if (test(REQUEST_AUTHORIZATION)) {
    include ".php/main.php";
} else if (test(ERROR_UPLOAD)) {
    return_error(UPLOAD_AUTORIZATION_ERROR);          
} else {
    include ".php/login.php";
}

#ini_set('display_errors', 1);
#error_reporting(E_ALL);

exit();
