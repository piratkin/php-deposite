<?php

$files  = 0; //список фаилов в базе
$max_id = 0; //
$counts = 0; //количество записей в базе
$id     = test(ACCESS_PAGE) ? $_POST['user_page'] : 1; //адрес запрашиваемой страницы

//получаем число строк в базе
$response = mysql_query("SELECT COUNT(*) FROM ".MYSQL_FILE_TBL);
if ($response) { 
	$counts = mysql_result($response, 0);
	$max_id = intval(($counts - 1) / OUTPUT_RECORDS) + 1; 
	mysql_free_result($response);
	unset($response);
	//проверка на привышение лимита страниц
	if ($id > $max_id) $id = $max_id; 
	if ($id < 1) $id = 1;
	//вычисляем начальное и конечное смещение окна навигации
	$cx = floor(PAGES/2);
	$start_id = $id - $cx;
	if (!(PAGES%2)) $start_id++;
	$end_id   = $id + $cx;
	//вжимаем окно в допустимые рамки
	while ($start_id < 1) {    //сначала двигаем "вправо",
		$start_id++; if ($end_id < $max_id) $end_id++;
	}
	while ($end_id > $max_id) {//а потом двигаем "влево"
		$end_id--; if ($start_id > 1) $start_id--;
	}
} else {
    return_error(DATABASE_ERROR);
}
//получаем список фаилов из базы
if ($counts) {
	$response = mysql_query("SELECT * FROM `".MYSQL_FILE_TBL."` ORDER BY `date` DESC LIMIT ".(($id*OUTPUT_RECORDS) - OUTPUT_RECORDS).", ".OUTPUT_RECORDS);
	if ($response) {
		//заголовок страницы 
		echo "<table><tr><th></th><th>Наименование</th><th>Автор</th><th>Дата</th></tr>";
		//выводим список фаилов в хранилище
		while ($line = mysql_fetch_array($response, MYSQL_ASSOC)) {
			$format = "<tr><td><img src='img/".($line["state"]?'ok':'err').".gif'/></td><td><a href='#' id='%s' onclick='javascript:downloadFiles(this.id)'>%s</a></td><td><a href='mailto:%s'>%s</a></td><td>%s</td></tr>";
			printf($format, $line["id"], $line["name"], $line["mail"], $line["mail"], date("d.m.Y", strtotime($line["date"])));
		}
		mysql_free_result($response);
		unset($response);
	} else {
        return_error(DATABASE_ERROR);
	}
	if ($start_id != $end_id) {
		echo "<tbody id='footer'><tr><td colspan='4' style='text-align: center;'>Страницы: <ul class='pager'>";
		if (($start_id - 1) > 1) echo "<li class='first'><a href='#' onclick='javascript:updateFiles(".($start_id - 1).")'>«</a></li>";   
		if ($id > 1) echo "<li class='previous'><a href='#' onclick='javascript:updateFiles(".($id - 1).")'>‹</a></li>";
		for ($iter = $start_id; $iter <= $end_id; $iter++) {
			echo "<li class='page".(($iter == $id)?" selected' id='current_page'":"'")."><a href='#' onclick='javascript:updateFiles(".$iter.")'>".$iter."</a></li>";
		}; 
		if ($id < $max_id) echo "<li class='next'><a href='#' onclick='javascript:updateFiles(".($id + 1).")'>›</a></li>";
		if (($end_id + 1) < $max_id) echo "<li class='last'><a href='#' onclick='javascript:updateFiles(".($end_id + 1).")'>»</a></li>";
		echo "</ul></td></tr></tbody>";
	}
	echo "</table>";
}

