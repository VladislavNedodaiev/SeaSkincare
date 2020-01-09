<?php 

if (!isset($_SESSION))
	session_start();

if (isset($_SESSION['msg'])) {
	echo "<div class='alert text-center m-4 ".$_SESSION['msg']['type']."' role='alert'>".$_SESSION['msg']['text']."</div>";
	unset($_SESSION['msg']); 
}

?>