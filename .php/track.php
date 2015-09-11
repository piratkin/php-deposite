<?php
$adress = isset($_SERVER['REMOTE_ADDR'])     ? $_SERVER['REMOTE_ADDR']     : "unknown";
$agent  = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "unknown";
$refer  = isset($_SERVER['HTTP_REFERRER'])   ? $_SERVER['HTTP_REFERRER']   : "unknown";
@mysql_query("INSERT INTO `ikantambase`.`adress` (`ip`, `date`, `uri`, `agent`) VALUES ('".$adress."', '".date("Y-m-d H:i:s")."', '".$refer."', '".$agent."')");

