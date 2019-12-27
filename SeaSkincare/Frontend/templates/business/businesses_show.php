<?php if (isset($businesses) && !empty($businesses)) { ?>
	<?php foreach($businesses as $key => &$business) { ?>
	
	<div class="card d-inline-block m-3" style="width: 18rem;">

		<a href="business.php?businessID=<?php echo $business->id; ?>">
			<div class="card-header text-center">
				<?php echo $business->nickname;?>
			</div>
			
			<img class="card-img-top" src="<?php if ($business->photo && file_exists($business->photo)) echo $business->photo; else echo "images/businesses/default.jpg" ?>" alt="<?php echo $business->nickname; ?>">
		</a>
	
	<?php } ?>
<?php } ?>