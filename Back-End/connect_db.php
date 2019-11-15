<?php

if (!isset($_SESSION))
	session_start();

$host = "127.0.0.1";
$user = "root";
$pswd = "";
$db = "vacationskin";

$mysqli = new mysqli($host, $user, $pswd, $db);

if ($mysqli->connect_errno) {
	$_SESSION['msg']['type'] = "alert-danger";
	$_SESSION['msg']['text'] = "Не вийшло підключитися до бази даних: ".mysqli_connect_error();
}

$mysqli->set_charset('utf8');

?>