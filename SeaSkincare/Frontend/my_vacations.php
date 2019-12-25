<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['profile'])
	|| $_SESSION['profile_type']) {
	
	header("Location: index.php");
	exit;
	
}

$my_past_vacations = require_once "scripts/user/my_past_vacations.php";
$my_current_vacations = require_once "scripts/user/my_current_vacations.php";
$my_future_vacations = require_once "scripts/user/my_future_vacations.php";

$my_denied_vacationRequests = require_once "scripts/user/my_denied_vacationRequests.php";
$my_pending_vacationRequests = require_once "scripts/user/my_pending_vacationRequests.php";

$businesses = require_once "scripts/user/my_vacations_businesses.php";

?>

<?php require "templates/header.php"; ?>

<?php include "templates/alert.php" ?>

<?php include "templates/user/my_pending_vacationRequests.php" ?>
<?php include "templates/user/my_denied_vacationRequests.php" ?>

<?php include "templates/user/my_future_vacations.php" ?>
<?php include "templates/user/my_current_vacations.php" ?>
<?php include "templates/user/my_past_vacations.php" ?>

<?php require "templates/footer.php"; ?>