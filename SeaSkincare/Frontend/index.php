<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

$businesses = include "scripts/index/businesses.php";
$connections = include "scripts/index/connections.php";

?>
<?php require "templates/header.php"; ?>

<?php include "templates/alert.php"; ?>

<?php include "templates/index/index_buoys_map.php"; ?>

<?php require "templates/footer.php"; ?>