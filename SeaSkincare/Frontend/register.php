<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
?>
<?php require "templates/header.php"; ?>

<div class="card bg-light">

	<?php include "templates/alert.php"; ?>
	
	<article class="card-body mx-auto" style="max-width: 400px;">
		<h4 class="card-title mt-3 text-center"><?php echo getLocalString('register', 'title'); ?></h4>
		
		<form action="registration.php" method="POST">
		<div class="form-group input-group">
			<div class="input-group-prepend">
				<span class="input-group-text"> <i class="fa fa-user"></i> </span>
			</div>
			<input name="nickname" class="form-control" placeholder="<?php echo getLocalString('register', 'nickname_placeholder'); ?>" type="text" required>
		</div>
		
		<div class="form-group input-group">
			<div class="input-group-prepend">
				<span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
			</div>
			<input name="email" class="form-control" placeholder="<?php echo getLocalString('register', 'email_placeholder'); ?>" type="email" required>
		</div>
		
		<div class="form-group input-group">
			<div class="input-group-prepend">
				<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
			</div>
			<input name="password" class="form-control" placeholder="<?php echo getLocalString('register', 'password_placeholder'); ?>" type="password" required>
		</div>
		<div class="form-group input-group">
			<div class="input-group-prepend">
				<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
			</div>
			<input name="repeat_password" class="form-control" placeholder="<?php echo getLocalString('register', 'repeat_password_placeholder'); ?>" type="password" required>
		</div>
		
		<div class="custom-control custom-radio">
			<input type="radio" id="as_user" name="register_option" class="custom-control-input" value="as_user" required>
			<label class="custom-control-label" for="as_user"><?php echo getLocalString('register', 'as_user'); ?></label>
		</div>
		<div class="custom-control custom-radio">
			<input type="radio" id="as_business" name="register_option" class="custom-control-input" value="as_business" required>
			<label class="custom-control-label" for="as_business"><?php echo getLocalString('register', 'as_business'); ?></label>
		</div>
		<br>
		
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block"><?php echo getLocalString('register', 'submit_text'); ?></button>
		</div>
		
		<p class="text-center"><?php echo getLocalString('register', 'login_text'); ?>? <a href="login.php"><?php echo getLocalString('register', 'login'); ?></a> </p>                                                                 
		</form>
	</article>
	
</div>

<?php require "templates/footer.php"; ?>