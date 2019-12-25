<form action="scripts/user/remove_current_vacation.php" id='removeCurrentVacation' method="POST">
<div class="modal fade" id="removeCurrentVacationModal" tabindex="-1" role="dialog" aria-labelledby="removeCurrentVacationModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="removeCurrentVacationModalTitle"><?php echo getLocalString('my_vacations', 'remove_vacation_title'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<?php echo getLocalString('my_vacations', 'remove_current_vacation_text'); ?>
				<input id="removeCurrentVacationID" name="removeCurrentVacationID" type="hidden" value="0">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo getLocalString('my_vacations', 'modal_close'); ?></button>
				<input type="submit" class="btn btn-danger" value='<?php echo getLocalString('my_vacations', 'remove_submit'); ?>'>
			</div>
		</div>
	</div>
</div>
</form>

<article class="card-body mx-auto">
	<div class="card" style="width: 70rem;">
		<div class="card-header">
			<div class="row">
				<div class="col my-auto"><?php echo getLocalString('my_vacations', 'my_current_vacations_title'); ?></div>
			</div>
		</div>
		
		<div class="card-body">
			<?php if (!$my_current_vacations || empty($my_current_vacations)) { ?>
				<div class="text-center m-2" style="width: 100%"><h4 class = "text-muted"><?php echo getLocalString('my_vacations', 'no_information'); ?></h4></div>
			<?php } else { ?>
				<?php foreach ($my_current_vacations as $key => &$value) { ?>
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4><a href="business_profile.php?businessID=<?php echo $value->business_id; ?>"><?php echo $businesses[$value->business_id]->nickname; ?></a></h4></div>
						<div class="col-3 text-right my-auto">
							<h4><?php echo substr($value->startDate, 0, 10); ?></h4>
							<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('my_vacations', 'start_date'); ?></small>
						</div>
						<div class="col-3 text-right my-auto">
							<h4><?php echo substr($value->finishDate, 0, 10); ?></h4>
							<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('my_vacations', 'finish_date'); ?></small>
						</div>
						<div class="col text-right my-auto"><a href="#" data-toggle="modal" data-target="#removeCurrentVacation" onclick="removeCurrentVacation(<?php echo $value->id; ?>)" id="removeCurrentVacation<?php echo $value->id; ?>"><i class="text-danger fas fa-times"></i></a></div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</article>

<script>

function removeCurrentVacation(id) {

	document.getElementById('removeCurrentVacationID').value = id;

}

</script>