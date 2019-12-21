<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['profile']) || isset($_SESSION['profile']->description)) {

	header("Location: index.php");
	exit;

}

$account = $_SESSION['profile'];

?>

<?php require "templates/header.php"; ?>

<?php include "templates/alert.php" ?>

<article class="card-body mx-auto">
	<div class="card" style="width: 70rem;">
		<form action="save_user_profile.php" method="POST">
		<div class="card-header">
			<div class="row">
				<div class="col-8 my-auto"><?php echo getLocalString('edit_profile', 'edit_profile_title'); ?></div>
				<div class="col text-right my-auto">
				
					<button type="submit" class="btn btn-success"><?php echo getLocalString('edit_profile', 'save_button_text'); ?></button>
					<a href="user_profile.php"><button type="button" class="btn btn-secondary"><?php echo getLocalString('edit_profile', 'cancel_button_text'); ?></button></a>
				
				</div>
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
						<div class="col p-2"><h4><?php echo $account->email; ?></h4></div>
					</div>
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-user"></i> <?php echo getLocalString('user_profile', 'nickname'); ?>: </h4></div>
						<div class="col p-2"><h4><input type="text" class="form-control" id="nickname" name="nickname" placeholder="<?php echo getLocalString('edit_profile', 'nickname_placeholder'); ?>" value="<?php echo $account->nickname; ?>"></h4></div>
					</div>
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-user"></i> <?php echo getLocalString('user_profile', 'name'); ?>: </h4></div>
						<div class="col p-2">
							<h4><input type="text" class="form-control" id="name" name="name" placeholder="<?php echo getLocalString('edit_profile', 'name_placeholder'); ?>" value="<?php echo $account->name; ?>"></h4>
							<small class = "text-muted">*<?php echo getLocalString('edit_profile', 'user_private'); ?></small>
						</div>
					</div>
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4 class = "text-muted"><i class="fas fa-transgender-alt"></i> <?php echo getLocalString('user_profile', 'gender'); ?>: </h4></div>
						<div class="col p-2">
						<select id="gender" name="gender" class="form-control">
							<option value="0" <?php if($account->gender == 0) echo 'selected'; ?>><?php echo getLocalString('user_profile', 'no_information'); ?></option>
							<option value="-1" <?php if($account->gender < 0) echo 'selected'; ?>><?php echo getLocalString('user_profile', 'female'); ?></option>
							<option value="1" <?php if($account->gender > 0) echo 'selected'; ?>><?php echo getLocalString('user_profile', 'male'); ?></option>
						</select>
						<small class = "text-muted">*<?php echo getLocalString('edit_profile', 'user_private'); ?></small>
						</div>
					</div>
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4 class = "text-muted"><i class="fas fa-phone"></i> <?php echo getLocalString('user_profile', 'phone'); ?>: </h4></div>
						<div class="col p-2">
							<h4><input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="<?php echo getLocalString('edit_profile', 'phone_placeholder'); ?>" value="<?php echo $account->phoneNumber; ?>"></h4>
							<small class = "text-muted">*<?php echo getLocalString('edit_profile', 'user_private'); ?></small>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
</article>

<?php require "templates/footer.php"; ?>