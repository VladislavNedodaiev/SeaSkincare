<article class="card-body mx-auto">
	<div class="card" style="width: 70rem;">
		<div class="card-header">
			<div class="my-auto"><?php echo getLocalString('business_subscriptions', 'business_past_subscriptions_title'); ?></div>
		</div>
		
		<div class="card-body">
			<?php if (!$business_past_subscriptions || empty($business_past_subscriptions)) { ?>
				<div class="text-center m-2" style="width: 100%"><h4 class = "text-muted"><?php echo getLocalString('business_subscriptions', 'no_information'); ?></h4></div>
			<?php } else { ?>
				<?php foreach ($business_past_subscriptions as $key => &$value) { ?>
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
						<div class="col text-right my-auto"></div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</article>