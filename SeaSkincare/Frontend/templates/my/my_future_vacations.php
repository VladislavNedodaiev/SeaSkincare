<article class="card-body mx-auto">
	<div class="card" style="width: 70rem;">
		<div class="card-header">
			<div class="row">
				<div class="col my-auto"><?php echo getLocalString('my_vacations', 'my_future_vacations_title'); ?></div>
			</div>
		</div>
		
		<div class="card-body">
			<?php if (!$my_future_vacations || empty($my_future_vacations)) { ?>
				<div class="text-center m-2" style="width: 100%"><h4 class = "text-muted"><?php echo getLocalString('my_vacations', 'no_information'); ?></h4></div>
			<?php } else { ?>
				<?php foreach ($my_future_vacations as $key => &$value) { ?>
					<div class="row m-2 border-bottom">
						<?php if (!$_SESSION['profile_type']) { ?>
							<div class="col-5 my-auto"><h4><a href="business_profile.php?businessID=<?php echo $value->businessID; ?>"><?php echo $accounts[$value->businessID]->nickname; ?></a></h4></div>
						<?php } else { ?>
							<div class="col-5 my-auto"><h4><a href="user_profile.php?userID=<?php echo $value->userID; ?>"><?php echo $accounts[$value->userID]->nickname; ?></a></h4></div>
						<?php } ?>
						<div class="col-3 text-center my-auto">
							<h4><?php echo substr($value->startDate, 0, 10); ?></h4>
							<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('my_vacations', 'start_date'); ?></small>
						</div>
						<div class="col-3 text-center my-auto">
							<h4><?php echo substr($value->finishDate, 0, 10); ?></h4>
							<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('my_vacations', 'finish_date'); ?></small>
						</div>
						<div class="col text-right my-auto"><a href="#" data-toggle="modal" data-target="#formModal" onclick="removeFutureVacation(<?php echo $value->id; ?>)" id="removeFutureVacation<?php echo $value->id; ?>"><i class="text-danger fas fa-times"></i></a></div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</article>

<script>

function removeFutureVacation(id) {

	<?php if (!$_SESSION['profile_type']) { ?>
		document.getElementById('form').action = 'scripts/user/remove_vacation.php';
	<?php } else { ?>
		document.getElementById('form').action = 'scripts/business/remove_vacation.php';
	<?php } ?>
	document.getElementById('formModalTitle').innerHTML = '<?php echo getLocalString("my_vacations", "remove_future_vacation_title"); ?>';
	document.getElementById('body_text').innerHTML = '<?php echo getLocalString("my_vacations", "remove_future_vacation_text"); ?>';
	document.getElementById('input').value = id;
	document.getElementById('submit').value = '<?php echo getLocalString("my_vacations", "remove_submit"); ?>';
	document.getElementById('submit').classList.remove('btn-success');
	document.getElementById('submit').classList.add('btn-danger');

}

</script>