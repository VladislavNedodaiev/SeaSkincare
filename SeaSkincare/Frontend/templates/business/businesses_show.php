<div class="row">
<?php if (isset($businesses) && !empty($businesses)) { ?>
	<?php foreach($businesses as $key => &$business) { ?>
	
	<div class="col text-center">
	<div class="card d-inline-block m-3" style="width: 18rem">

		<a href="business.php?businessID=<?php echo $business->id; ?>">
			<div class="card-header text-center">
				<?php echo $business->nickname;?>
			</div>
			
			<img class="card-img-top" src="<?php if ($business->photo && file_exists($business->photo)) echo $business->photo; else echo "images/businesses/default.jpg" ?>" alt="<?php echo $business->nickname; ?>">
		</a>
	</div>
	</div>
	
	<?php } ?>
<?php } else { ?>
	<div class="text-center m-2" style="width: 100%"><h4 class = "text-muted"><?php echo getLocalString('businesses', 'no_information'); ?></h4></div>
<?php } ?>
</div>