<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_GET['businessID']) && (!isset($_SESSION['profile']) || !$_SESSION['profile_type'])) {
	
	header("Location: index.php");
	exit;
	
}

$business_subscriptions = require_once "scripts/business/business_subscriptions.php";

$business_current_subscriptions = require_once "scripts/business/business_current_subscriptions.php";
$business_past_subscriptions = require_once "scripts/business/business_past_subscriptions.php";

$free_buoys_count = require_once "scripts/buoy/free_buoys_count.php";

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
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo getLocalString('business_subscriptions', 'modal_close'); ?></button>
				<input type="submit" id="submit" class="btn btn-danger" value='<?php echo getLocalString('business_subscriptions', 'remove_submit'); ?>'>
			</div>
		</div>
	</div>
</div>
</form>

<?php include "templates/business/business_current_subscriptions.php" ?>
<?php include "templates/business/business_past_subscriptions.php" ?>

<?php require "templates/footer.php"; ?>