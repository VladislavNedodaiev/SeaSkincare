<article class="card-body mx-auto">
	<div class="card" style="width: 70rem;">
		<div class="card-header">
			<div class="row">
				<div class="col my-auto"><?php echo getLocalString('my_vacations', 'my_past_vacations_title'); ?></div>
			</div>
		</div>
		
		<div class="card-body">
			<?php if (!$my_past_vacations || empty($my_past_vacations)) { ?>
				<div class="text-center m-2" style="width: 100%"><h4 class = "text-muted"><?php echo getLocalString('my_vacations', 'no_information'); ?></h4></div>
			<?php } else { ?>
				<?php foreach ($my_past_vacations as $key => &$value) { ?>
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4><a href="business_profile.php?businessID=<?php echo $value->businessID; ?>"><?php echo $businesses[$value->businessID]->nickname; ?></a></h4></div>
						<div class="col-3 text-center my-auto">
							<h4><?php echo substr($value->startDate, 0, 10); ?></h4>
							<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('my_vacations', 'start_date'); ?></small>
						</div>
						<div class="col-3 text-center my-auto">
							<h4><?php echo substr($value->finishDate, 0, 10); ?></h4>
							<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('my_vacations', 'finish_date'); ?></small>
						</div>
						<div class="col text-right my-auto"></div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</article>