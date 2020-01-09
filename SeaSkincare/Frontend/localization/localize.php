<?php
if (!isset($_SESSION))
	session_start();

if (!isset($_GET['language']) && !isset($_SESSION['language']))
	$_SESSION['language'] = 'ENG';

$_SESSION['language'] = $_GET['language'];

if (!isset($_GET['address']))
	header("Location: index.php");

header("Location: ".$_GET['address']);

exit;

?>