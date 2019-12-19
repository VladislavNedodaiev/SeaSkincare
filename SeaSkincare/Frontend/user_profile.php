<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['profile'])) {

	header("Location: index.php");
	exit;

}

$account = require_once "templates/user_profile.php";

if (!$account) {
	
	header("Location: index.php");
	exit;
	
}

?>

<?php require "templates/header.php"; ?>

<div class="card bg-light">
	<?php include "templates/alert.php" ?>
	<article class="card-body mx-auto">
		<div class="card" style="width: 70rem;">
			<div class="card-header">
				<div class="row">
					<?php if (!isset($_SESSION['profile']->description)) { ?>
						<div class="col-8 my-auto"><?php echo getLocalString('user_profile', 'my_profile'); ?></div>
						<div class="col text-right my-auto"><a href="edit_user_profile.php"><i class="fas fa-pencil-alt"></i></a></div>
					<?php } else { ?>
						<div class="col-8 my-auto"><?php echo getLocalString('user_profile', 'profile'); ?> <?php echo $account->nickname; ?></div>
					<?php } ?>
				</div>
			</div>
			
			<div class="card-body">
				<div class="row">
					<div class="col-3 border-right">
						<div class="card">
							<img class="card-img-top" src="images/users/default.jpg" alt="<?php echo getLocalString('user_profile', 'nickname'); ?> <?php echo $account->nickname; ?>">
							
							<div class="card-header text-center">
								<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('user_profile', 'register_date'); ?>: <?php echo substr($account->registerDate, 0, 10); ?> </small>
							</div>
						</div>
					</div>
					
					<div class="col">
						<div class="row m-2 border-bottom">
							<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-envelope"></i> <?php echo getLocalString('user_profile', 'email'); ?>: </h4></div>
							<div class="col my-auto"><h4><?php echo $account->email; ?></h4></div>
						</div>
						<div class="row m-2 border-bottom">
							<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-user"></i> <?php echo getLocalString('user_profile', 'nickname'); ?>: </h4></div>
							<div class="col my-auto"><h4><?php echo $account->nickname; ?></h4></div>
						</div>
						<div class="row m-2 border-bottom">
							<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-user"></i> <?php echo getLocalString('user_profile', 'name'); ?>: </h4></div>
							<?php if ($account->name) { ?>
							<div class="col my-auto"><h4><?php echo $account->name; ?></h4></div>
							<?php } else { ?>
							<div class="col my-auto"><h4 class = "text-muted"><i><?php echo getLocalString('user_profile', 'no_information'); ?></i></h4></div>
							<?php } ?>
						</div>
						<div class="row m-2 border-bottom">
							<div class="col-5 my-auto"><h4 class = "text-muted"><i class="fas fa-transgender-alt"></i> <?php echo getLocalString('user_profile', 'gender'); ?>: </h4></div>
							<?php if ($account->gender < 0) { ?>
							<div class="col my-auto"><h4><?php echo getLocalString('user_profile', 'female'); ?></h4></div>
							<?php } else if ($account->gender > 0) { ?>
							<div class="col my-auto"><h4><?php echo getLocalString('user_profile', 'male'); ?></h4></div>
							<?php } else { ?>
							<div class="col my-auto"><h4 class = "text-muted"><i><?php echo getLocalString('user_profile', 'no_information'); ?></i></h4></div>
							<?php } ?>
						</div>
						<div class="row m-2 border-bottom">
							<div class="col-5 my-auto"><h4 class = "text-muted"><i class="fas fa-phone"></i> <?php echo getLocalString('user_profile', 'phone'); ?>: </h4></div>
							<?php if ($account->phoneNumber) { ?>
							<div class="col my-auto"><h4><?php echo $account->phoneNumber; ?></h4></div>
							<?php } else { ?>
							<div class="col my-auto"><h4 class = "text-muted"><i><?php echo getLocalString('user_profile', 'no_information'); ?></i></h4></div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>
</div>
<?php require "templates/footer.php"; ?>