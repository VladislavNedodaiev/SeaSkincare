<form action="businesses.php" method="GET">
<div class="card-header">
	<div class="row">
		<div class="col-2 my-auto text-left"><?php echo getLocalString('businesses', 'filter_title'); ?></div>
		<div class="col-3 my-auto">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" name="activeCheck" class="custom-control-input" id="activeCheck" <?php if (isset($_GET['activeCheck']) && $_GET['activeCheck']) echo 'checked'; ?>>
				<label class="custom-control-label" for="activeCheck"><?php echo getLocalString('businesses', 'filter_active_check'); ?></label>
			</div>
		</div>
		<div class="col-4 my-auto">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" id="filter_search_prepend"><i class="fas fa-search"></i></span>
				</div>
				<input type="text" value="<?php if (isset($_GET['search'])) echo $_GET['search']; ?>" class="form-control" id="search" name="search" aria-describedby="filter_search_prepend">
			</div>
		</div>
		<div class="col-3 text-right my-auto">
			<input class="btn btn-primary" type="submit" value="<?php echo getLocalString('businesses', 'filter_submit'); ?>">
		</div>
	</div>
</div>
</form>