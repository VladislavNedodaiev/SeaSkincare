<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['profile'])) {
	
	header("Location: index.php");
	exit;
	
}

$my_past_vacations = require_once "scripts/my/my_past_vacations.php";
$my_current_vacations = require_once "scripts/my/my_current_vacations.php";
$my_future_vacations = require_once "scripts/my/my_future_vacations.php";

$my_denied_vacationRequests = require_once "scripts/my/my_denied_vacationRequests.php";
$my_pending_vacationRequests = require_once "scripts/my/my_pending_vacationRequests.php";

$accounts = array();

if (!$_SESSION['profile_type'])
	$accounts = require_once "scripts/my/my_vacations_businesses.php";
else
	$accounts = require_once "scripts/my/my_vacations_users.php";

?>

<?php require "templates/header.php"; ?>

<?php include "templates/alert.php" ?>

<form action="" id='form' method="POST">
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="formModalTitle"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<span id="body_text"></span>
				<input id="input" name="input" type="hidden" value="0">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo getLocalString('my_vacations', 'modal_close'); ?></button>
				<input type="submit" id="submit" class="btn btn-danger" value='<?php echo getLocalString('my_vacations', 'remove_submit'); ?>'>
			</div>
		</div>
	</div>
</div>
</form>

<?php include "templates/my/my_pending_vacationRequests.php" ?>
<?php include "templates/my/my_denied_vacationRequests.php" ?>

<?php include "templates/my/my_future_vacations.php" ?>
<?php include "templates/my/my_current_vacations.php" ?>
<?php include "templates/my/my_past_vacations.php" ?>

<?php require "templates/footer.php"; ?>