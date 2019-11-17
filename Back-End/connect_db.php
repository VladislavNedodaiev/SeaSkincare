<?php

$host = "127.0.0.1";
$user = "root";
$pswd = "";
$db = "vacationskin";

$mysqli = new mysqli($host, $user, $pswd, $db);

if ($mysqli->connect_errno) {
	return null;
}

$mysqli->set_charset('utf8');

return $mysqli;

?>