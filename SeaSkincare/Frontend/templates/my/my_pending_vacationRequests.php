<article class="card-body mx-auto">
	<div class="card" style="width: 70rem;">
		<div class="card-header">
			<div class="row">
				<div class="col-8 my-auto"><?php echo getLocalString('my_vacations', 'my_pending_vacationRequests_title'); ?></div>
				<div class="col-4 text-right my-auto">
					<?php if (!$_SESSION['profile_type'] && isset($_GET['businessID']) && (!$my_pending_vacationRequests || empty($my_pending_vacationRequests))) { ?>
						<a href="#" data-toggle="modal" data-target="#formModal" onclick="addPendingVacationRequest(<?php echo $_GET['businessID']; ?>)" id="addPendingVacationRequest<?php echo $_GET['businessID']; ?>"><i class="text-success fas fa-plus"></i> <?php echo getLocalString('my_vacations', 'add_pending_vacationRequest'); ?></a>
					<?php } ?>
				</div>
			</div>
		</div>
		
		<div class="card-body">
			<?php if (!$my_pending_vacationRequests || empty($my_pending_vacationRequests)) { ?>
				<div class="text-center m-2" style="width: 100%"><h4 class = "text-muted"><?php echo getLocalString('my_vacations', 'no_information'); ?></h4></div>
			<?php } else { ?>
				<?php foreach ($my_pending_vacationRequests as $key => &$value) { ?>
					<div class="row m-2 border-bottom">
						<?php if (!$_SESSION['profile_type']) { ?>
							<div class="col-8 my-auto"><h4><a href="business_profile.php?businessID=<?php echo $value->businessID; ?>"><?php echo $accounts[$value->businessID]->nickname; ?></a></h4></div>
						<?php } else { ?>
							<div class="col-8 my-auto"><h4><a href="user_profile.php?userID=<?php echo $value->userID; ?>"><?php echo $accounts[$value->userID]->nickname; ?></a></h4></div>
						<?php } ?>
						<div class="col-3 text-center my-auto">
							<h4><?php echo substr($value->requestDate, 0, 10); ?></h4>
							<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('my_vacations', 'request_date'); ?></small>
						</div>
						<div class="col text-right my-auto">
							<a href="#" data-toggle="modal" data-target="#formModal" onclick="removePendingVacationRequest(<?php echo $value->id; ?>)" id="removePendingVacationRequest<?php echo $value->id; ?>"><i class="text-danger fas fa-times"></i></a> 
							<?php if ($_SESSION['profile_type']) { ?>
								<a href="#" data-toggle="modal" data-target="#formModal" onclick="addPendingVacationRequest(<?php echo $value->id; ?>)" id="addPendingVacationRequest<?php echo $value->id; ?>"><i class="text-success fas fa-check"></i></a>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</article>

<script>

function removePendingVacationRequest(id) {

	<?php if (!$_SESSION['profile_type']) { ?>
		document.getElementById('form').action = 'scripts/user/remove_vacationRequest.php';
	<?php } else { ?>
		document.getElementById('form').action = 'scripts/business/deny_vacationRequest.php';
	<?php } ?>
	document.getElementById('formModalTitle').innerHTML = '<?php echo getLocalString("my_vacations", "remove_vacationRequest_title"); ?>';
	document.getElementById('body_text').innerHTML = '<?php echo getLocalString("my_vacations", "remove_pending_vacationRequest_text"); ?>';
	document.getElementById('input').value = id;
	document.getElementById('submit').value = '<?php echo getLocalString("my_vacations", "remove_submit"); ?>';
	document.getElementById('submit').classList.remove('btn-success');
	document.getElementById('submit').classList.add('btn-danger');

}

function addPendingVacationRequest(id) {

	<?php if (!$_SESSION['profile_type']) { ?>
		document.getElementById('form').action = 'scripts/user/add_vacationRequest.php';
		document.getElementById('body_text').innerHTML = '<?php echo getLocalString("my_vacations", "add_pending_vacationRequest_text"); ?>';
	<?php } else { ?>
		document.getElementById('form').action = 'scripts/business/confirm_vacationRequest.php';
		document.getElementById('body_text').innerHTML = '<div class="row m-1">';
			document.getElementById('body_text').innerHTML += '<div class="col-6">';
				document.getElementById('body_text').innerHTML += '<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString("my_vacations", "start_date"); ?></small>';
			document.getElementById('body_text').innerHTML += '</div>';
			document.getElementById('body_text').innerHTML += '<div class="col-6">';
				document.getElementById('body_text').innerHTML += '<input id="startDate" type="date" min="<?php echo date("Y-m-d"); ?>">';
			document.getElementById('body_text').innerHTML += '</div>';
		document.getElementById('body_text').innerHTML += '</div>';
		document.getElementById('body_text').innerHTML = '<div class="row m-1">';
			document.getElementById('body_text').innerHTML += '<div class="col-6">';
				document.getElementById('body_text').innerHTML += '<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString("my_vacations", "finish_date"); ?></small>';
			document.getElementById('body_text').innerHTML += '</div>';
			document.getElementById('body_text').innerHTML += '<div class="col-6">';
				document.getElementById('body_text').innerHTML += '<input id="finishDate" type="date" min="<?php echo date("Y-m-d"); ?>">';
			document.getElementById('body_text').innerHTML += '</div>';
		document.getElementById('body_text').innerHTML += '</div>';
	<?php } ?>
	document.getElementById('formModalTitle').innerHTML = '<?php echo getLocalString("my_vacations", "add_vacationRequest_title"); ?>';
	document.getElementById('input').value = id;
	document.getElementById('submit').value = '<?php echo getLocalString("my_vacations", "add_submit"); ?>';
	document.getElementById('submit').classList.remove('btn-danger');
	document.getElementById('submit').classList.add('btn-success');

}

</script>