<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

$account = require_once "scripts/business_profile.php";
$vacation = require_once "scripts/business_profile_user_vacation.php";

if (!$account) {
	
	header("Location: index.php");
	exit;
	
}

?>

<?php require "templates/header.php"; ?>

<?php include "templates/alert.php" ?>

<article class="card-body mx-auto">
	<div class="card" style="width: 70rem;">
		<div class="card-header">
			<div class="row">
			
				<div class="col-6 my-auto"><?php echo $account->nickname; ?></div>
				<div class="col text-right my-auto">
					<?php if (isset ($_SESSION['profile']) && $account == $_SESSION['profile']) { ?>
						<div class="col text-right my-auto"><a href="edit_business_profile.php"><i class="fas fa-pencil-alt"></i></a></div>
					<?php 
					} else {
						if ($vacation) { ?>
							<a href="user_business_subscriptions.php?businessID=<?php echo $account->id; ?>"><button type="button" class="btn btn-primary"><?php echo getLocalString('business_profile', 'show_devices'); ?></button></a>
						<?php 
						} 
						if (isset($_SESSION['profile_type']) && !$_SESSION['profile_type']) { ?>
							<a href="user_business_vacations.php?businessID=<?php echo $account->id; ?>"><button type="button" class="btn btn-primary"><?php echo getLocalString('business_profile', 'show_vacations'); ?></button></a>
						<?php
						} ?>
					<?php
					} ?>
				</div>
			</div>
		</div>
		
		<div class="card-body">
			<div class="row">
				<div class="col-3 border-right">
					<div class="card">
						<img class="card-img-top" src="<?php if ($account->photo && file_exists($account->photo)) echo $account->photo; else echo "images/businesses/default.jpg" ?>" alt="<?php echo $account->nickname; ?>">
						
						<div class="card-header text-center">
							<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('business_profile', 'register_date'); ?>: <?php echo substr($account->registerDate, 0, 10); ?> </small>
						</div>
					</div>
				</div>
				
				<div class="col">
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-envelope"></i> <?php echo getLocalString('business_profile', 'email'); ?>: </h4></div>
						<div class="col my-auto"><h4><?php echo $account->email; ?></h4></div>
					</div>
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4 class = "text-muted"><i class="fas fa-phone"></i> <?php echo getLocalString('business_profile', 'phone'); ?>: </h4></div>
						<?php if ($account->phoneNumber) { ?>
						<div class="col my-auto"><h4><?php echo $account->phoneNumber; ?></h4></div>
						<?php } else { ?>
						<div class="col my-auto"><h4 class = "text-muted"><i><?php echo getLocalString('business_profile', 'no_information'); ?></i></h4></div>
						<?php } ?>
					</div>
				</div>
			</div>
			<h3 class = "text-center m-2"><?php echo getLocalString('business_profile', 'description'); ?></h3>
			<?php if (!$account->description) { ?>
				<h4 class = "text-center text-muted m-2"><i><?php echo getLocalString('business_profile', 'no_information'); ?></i></h4>
			<?php } else { ?>
				<h4 class = "m-2"><?php echo $account->description; ?></h4>
			<?php } ?>
		</div>
	</div>
</article>

<?php require "templates/footer.php"; ?>