<article class="card-body mx-auto">
	<div class="card" style="width: 70rem;">
		<div class="card-header">
			<div class="row">
				<div class="col-8 my-auto"><?php echo getLocalString('business_subscriptions', 'business_current_subscriptions_title'); ?></div>
				<div class="col-4 text-right my-auto">
					<?php if (!isset($_GET['businessID']) || (isset($_SESSION['profile']) && $_SESSION['profile_type'] && $_GET['businessID'] == $_SESSION['profile']->id)) { ?>
						<a href="#" data-toggle="modal" data-target="#formModal" onclick="addSubscription()" id="addSubscription<?php echo $_SESSION['profile']->id; ?>"><i class="text-success fas fa-plus"></i> <?php echo getLocalString('business_subscriptions', 'add_subscription'); ?></a>
					<?php } ?>
				</div>
			</div>
		</div>
		
		<div class="card-body">
			<?php if (!$business_current_subscriptions || empty($business_current_subscriptions)) { ?>
				<div class="text-center m-2" style="width: 100%"><h4 class = "text-muted"><?php echo getLocalString('business_subscriptions', 'no_information'); ?></h4></div>
			<?php } else { ?>
				<?php foreach ($business_current_subscriptions as $key => &$value) { ?>
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4><a href="buoy.php?buoyID=<?php echo $value->buoyID; ?>"><?php echo getLocalString('business_subscriptions', 'device_text'); ?> #<?php echo $value->buoyID; ?></a></h4></div>
						<div class="col-3 text-center my-auto">
							<h4><?php echo substr($value->startDate, 0, 10); ?></h4>
							<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('business_subscriptions', 'start_date'); ?></small>
						</div>
						<div class="col-3 text-center my-auto">
							<h4><?php echo substr($value->finishDate, 0, 10); ?></h4>
							<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('business_subscriptions', 'finish_date'); ?></small>
						</div>
						<div class="col text-right my-auto">
							<?php if (!isset($_GET['businessID']) || (isset($_SESSION['profile']) && $_SESSION['profile_type'] && $_GET['businessID'] == $_SESSION['profile']->id)) { ?>
								<a href="#" data-toggle="modal" data-target="#formModal" onclick="removeSubscription(<?php echo $value->id; ?>)" id="removeSubscription<?php echo $value->id; ?>"><i class="text-danger fas fa-times"></i></a> 
								<a href="#" data-toggle="modal" data-target="#formModal" onclick="editSubscription('<?php echo $value->startDate; ?>', '<?php echo $value->finishDate; ?>', <?php echo $value->id; ?>)" id="editSubscription<?php echo $value->id; ?>"><i class="text-primary fas fa-pencil-alt"></i></a>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</article>


<?php if (!isset($_GET['businessID']) || (isset($_SESSION['profile']) && $_SESSION['profile_type'] && $_GET['businessID'] == $_SESSION['profile']->id)) { ?>
<script>

function removeSubscription(id) {

	document.getElementById('form').action = 'scripts/business/remove_subscription.php';
	document.getElementById('formModalTitle').innerHTML = '<?php echo getLocalString("business_subscriptions", "remove_subscription_title"); ?>';
	document.getElementById('body_text').innerHTML = '<?php echo getLocalString("business_subscriptions", "remove_subscription_text"); ?>';
	document.getElementById('input').value = id;
	document.getElementById('submit').style.display = "inline-block";
	document.getElementById('submit').value = '<?php echo getLocalString("business_subscriptions", "remove_submit"); ?>';
	document.getElementById('submit').classList.remove('btn-success');
	document.getElementById('submit').classList.add('btn-danger');

}

function addSubscription() {

	document.getElementById('form').action = 'scripts/business/add_subscription.php';
	
	var addinnerHTML = '';
	
	<?php if (isset($free_buoys_count) && $free_buoys_count > 0) { ?>
		addinnerHTML += '<div class="row m-1">';
			addinnerHTML += '<div class="col-6 text-left">';
				addinnerHTML += '<i class="far fa-calendar-alt"></i> <?php echo getLocalString("business_subscriptions", "start_date"); ?>';
			addinnerHTML += '</div>';
			addinnerHTML += '<div class="col-6 text-right">';
				addinnerHTML += '<input name="startDate" id="startDate" type="date" value="<?php echo date("Y-m-d"); ?>" readonly>';
			addinnerHTML += '</div>';
		addinnerHTML += '</div>';
		addinnerHTML += '<div class="row m-1">';
			addinnerHTML += '<div class="col-6 text-left">';
				addinnerHTML += '<i class="far fa-calendar-alt"></i> <?php echo getLocalString("business_subscriptions", "finish_date"); ?>';
			addinnerHTML += '</div>';
			addinnerHTML += '<div class="col-6 text-right">';
				addinnerHTML += '<input name="finishDate" id="finishDate" type="date" min="<?php echo date("Y-m-d"); ?>" required>';
			addinnerHTML += '</div>';
		addinnerHTML += '</div>';
		document.getElementById('submit').style.display = "inline-block";
	<?php } else { ?>
		addinnerHTML += '<?php echo getLocalString("business_subscriptions", "no_free_buoys"); ?>';
		document.getElementById('submit').style.display = "none";
	<?php } ?>
	
	document.getElementById('body_text').innerHTML = addinnerHTML;
		
	document.getElementById('formModalTitle').innerHTML = '<?php echo getLocalString("business_subscriptions", "add_subscription_title"); ?>';
	document.getElementById('submit').value = '<?php echo getLocalString("business_subscriptions", "add_submit"); ?>';
	document.getElementById('submit').classList.remove('btn-danger');
	document.getElementById('submit').classList.add('btn-success');

}

function editSubscription(startDate, finishDate, id) {

	document.getElementById('form').action = 'scripts/business/edit_subscription.php';
	
	var addinnerHTML = '';
	
	addinnerHTML += '<div class="row m-1">';
		addinnerHTML += '<div class="col-6 text-left">';
			addinnerHTML += '<i class="far fa-calendar-alt"></i> <?php echo getLocalString("business_subscriptions", "start_date"); ?>';
		addinnerHTML += '</div>';
		addinnerHTML += '<div class="col-6 text-right">';
			addinnerHTML += '<input name="startDate" id="startDate" type="date" value="' + startDate + '" readonly>';
		addinnerHTML += '</div>';
	addinnerHTML += '</div>';
	addinnerHTML += '<div class="row m-1">';
		addinnerHTML += '<div class="col-6 text-left">';
			addinnerHTML += '<i class="far fa-calendar-alt"></i> <?php echo getLocalString("business_subscriptions", "finish_date"); ?>';
		addinnerHTML += '</div>';
		addinnerHTML += '<div class="col-6 text-right">';
			addinnerHTML += '<input name="finishDate" id="finishDate" type="date" value="' + finishDate + '" min="<?php echo date("Y-m-d"); ?>" required>';
		addinnerHTML += '</div>';
	addinnerHTML += '</div>';
	
	document.getElementById('body_text').innerHTML = addinnerHTML;
		
	document.getElementById('formModalTitle').innerHTML = '<?php echo getLocalString("business_subscriptions", "edit_subscription_title"); ?>';
	document.getElementById('input').value = id;
	document.getElementById('submit').style.display = "inline-block";
	document.getElementById('submit').value = '<?php echo getLocalString("business_subscriptions", "edit_submit"); ?>';
	document.getElementById('submit').classList.remove('btn-danger');
	document.getElementById('submit').classList.add('btn-success');

}

</script>

<?php } ?>