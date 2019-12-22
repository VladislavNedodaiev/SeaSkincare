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
$add_problems = $skin_problems;

if ($user_problems && !empty($user_problems)) {
	foreach($user_problems as $key => &$value) {

		if (isset($add_problems[$value->skinProblemID]))
			unset($add_problems[$value->skinProblemID]);

	}
}

?>

<?php require "templates/header.php"; ?>

<?php include "templates/alert.php" ?>

<form action="scripts/add_skin_problem.php" id='add_skin_problem' method="POST">
<div class="modal fade" id="addSkinProblemModal" tabindex="-1" role="dialog" aria-labelledby="addSkinProblemModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addSkinProblemModalTitle"><?php echo getLocalString('my_skin_problems', 'add_problem_modal_title'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<select id="addSkinProblemID" name="addSkinProblemID" class="form-control" required>
					<option value="" selected disabled><?php echo getLocalString('my_skin_problems', 'add_problem_no_information'); ?></option>
					<?php if ($add_problems && !empty($add_problems)) { ?>
						<?php foreach ($add_problems as $key => &$value) { ?>
							<option value="<?php echo $value->id; ?>"><?php echo getLocalString('skin_problems', $value->title); ?></option>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo getLocalString('my_skin_problems', 'modal_close'); ?></button>
				<input type="submit" class="btn btn-success" value='<?php echo getLocalString('my_skin_problems', 'add_problem_modal_submit'); ?>'>
			</div>
		</div>
	</div>
</div>
</form>

<form action="scripts/remove_skin_problem.php" id='remove_skin_problem' method="POST">
<div class="modal fade" id="removeSkinProblemModal" tabindex="-1" role="dialog" aria-labelledby="removeSkinProblemModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="removeSkinProblemModalTitle"><?php echo getLocalString('my_skin_problems', 'remove_problem_modal_title'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<?php echo getLocalString('my_skin_problems', 'remove_problem_modal_text'); ?>
				<input id="removeSkinProblemID" name="removeSkinProblemID" type="hidden" value="0">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo getLocalString('my_skin_problems', 'modal_close'); ?></button>
				<input type="submit" class="btn btn-danger" value='<?php echo getLocalString('my_skin_problems', 'remove_problem_modal_submit'); ?>'>
			</div>
		</div>
	</div>
</div>
</form>

<article class="card-body mx-auto">
	<div class="card" style="width: 70rem;">
		<div class="card-header">
			<div class="row">
			
				<div class="col-6 my-auto"><?php echo getLocalString('my_skin_problems', 'title'); ?></div>
				<div class="col text-right my-auto">
					<a href="#" data-toggle="modal" data-target="#addSkinProblemModal"><i class="text-success fas fa-plus"></i> <?php echo getLocalString('my_skin_problems', 'add_problem'); ?></a>
				</div>
			</div>
		</div>
		
		<div class="card-body">
			<?php if (!$user_problems || empty($user_problems)) { ?>
				<div class="text-center m-2" style="width: 100%"><h4 class = "text-muted"><?php echo getLocalString('my_skin_problems', 'no_information'); ?></h4></div>
			<?php } else { ?>
				<?php foreach ($user_problems as $key => &$value) { ?>
					<div class="row m-2 border-bottom">
						<div class="col-8 my-auto"><h4><i class="fas fa-allergies"></i> <?php echo getLocalString('skin_problems', $skin_problems[$value->skinProblemID]->title); ?></h4></div>
						<div class="col text-right my-auto"><a href="#" data-toggle="modal" data-target="#removeSkinProblemModal" onclick="removeProblemClick(<?php echo $value->id; ?>)" id="removeProblem<?php echo $value->id; ?>"><i class="text-danger fas fa-times"></i></a></div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</article>

<script>

function removeProblemClick(id) {

	document.getElementById('removeSkinProblemID').value = id;

}

</script>

<?php require "templates/footer.php"; ?>