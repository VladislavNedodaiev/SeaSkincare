<form action="scripts/user/remove_denied_vacationRequest.php" id='removeDeniedVacationRequest' method="POST">
<div class="modal fade" id="removeDeniedVacationRequestModal" tabindex="-1" role="dialog" aria-labelledby="removeDeniedVacationRequestModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="removeDeniedVacationRequestModalTitle"><?php echo getLocalString('my_vacations', 'remove_vacationRequest_title'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<?php echo getLocalString('my_vacations', 'remove_denied_vacationRequest_text'); ?>
				<input id="removeDeniedVacationRequestID" name="removeDeniedVacationRequestID" type="hidden" value="0">
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
				<div class="col my-auto"><?php echo getLocalString('my_vacations', 'my_denied_vacationRequests_title'); ?></div>
			</div>
		</div>
		
		<div class="card-body">
			<?php if (!$my_denied_vacationRequests || empty($my_denied_vacationRequests)) { ?>
				<div class="text-center m-2" style="width: 100%"><h4 class = "text-muted"><?php echo getLocalString('my_vacations', 'no_information'); ?></h4></div>
			<?php } else { ?>
				<?php foreach ($my_denied_vacationRequests as $key => &$value) { ?>
					<div class="row m-2 border-bottom">
						<div class="col-8 my-auto"><h4><a href="business_profile.php?businessID=<?php echo $value->business_id; ?>"><?php echo $businesses[$value->business_id]->nickname; ?></a></h4></div>
						<div class="col-3 text-right my-auto">
							<h4><?php echo substr($value->requestDate, 0, 10); ?></h4>
							<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('my_vacations', 'request_date'); ?></small>
						</div>
						<div class="col text-right my-auto"><a href="#" data-toggle="modal" data-target="#removeDeniedVacationRequest" onclick="removeDeniedVacationRequest(<?php echo $value->id; ?>)" id="removeDeniedVacationRequest<?php echo $value->id; ?>"><i class="text-danger fas fa-times"></i></a></div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</article>

<script>

function removeDeniedVacationRequest(id) {

	document.getElementById('removeDeniedVacationRequestID').value = id;

}

</script>