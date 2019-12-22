<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['profile'])
	|| $_SESSION['profile_type']) {
	
	header("Location: index.php");
	exit;
	
}

$user_problems = require_once "scripts/my_user_problems.php";
$skin_problems = require_once "scripts/skin_problems.php";

?>

<?php require "templates/header.php"; ?>

<?php include "templates/alert.php" ?>

<article class="card-body mx-auto">
	<div class="card" style="width: 70rem;">
		<div class="card-header">
			<div class="row">
			
				<div class="col-6 my-auto"><?php echo getLocalString('my_skin_problems', 'title'); ?></div>
				<div class="col text-right my-auto">
					<a href=""><i class="text-success fas fa-plus"></i></a>
				</div>
			</div>
		</div>
		
		<div class="card-body">
			<?php if (!$user_problems || empty($user_problems)) { ?>
				<div class="row text-center m-2"><h4 class = "text-muted"><?php echo getLocalString('my_skin_problems', 'no_information'); ?></h4></div>
			<?php } else { ?>
				<?php foreach ($user_problems as $key => &$value) { ?>
					<div class="row m-2 border-bottom">
						<div class="col-8 my-auto"><h4><i class="far fa-envelope"></i> <?php echo getLocalString('skin_problems', $skin_problems[$value->skinProblemID]->title); ?>: </h4></div>
						<div class="col text-right my-auto"><a href="scripts/remove_user_problem.php?userProblemID=<?php echo $key; ?>"><i class="text-danger fas fa-times"></i></a></div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</article>

<?php require "templates/footer.php"; ?>