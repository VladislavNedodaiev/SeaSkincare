<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

$businesses = include "scripts/business/businesses.php";
$connections = include "scripts/business/connections.php";

?>
<?php require "templates/header.php"; ?>

<?php include "templates/alert.php"; ?>

<?php include "templates/business/businesses_buoys_map.php"; ?>

<article class="card-body mx-auto">
	<div class="card" style="width: 70rem;">
	
		<?php include "templates/business/businesses_filter.php"; ?>

		<?php include "templates/business/businesses_show.php"; ?>
		
	</div>
</article>

<?php include "templates/business/businesses_pagination.php"; ?>

<?php require "templates/footer.php"; ?>