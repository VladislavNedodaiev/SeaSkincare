<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
?>
<?php require "templates/header.php"; ?>

<div class="card bg-light">

	<?php include "templates/alert.php"; ?>
	
	<article class="card-body mx-auto" style="max-width: 400px;">
		<h4 class="card-title mt-3 text-center"><?php echo getLocalString('login_business', 'title'); ?></h4>
		
		<form action="authorize_user.php" method="POST">
			<div class="form-group input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"> <i class="fa fa-user"></i> </span>
				</div>
				<input name="email" class="form-control" placeholder="<?php echo getLocalString('login_business', 'email_placeholder'); ?>" type="text" required>
			</div>
			
			<div class="form-group input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
				</div>
				<input name="password" class="form-control" placeholder="<?php echo getLocalString('login_business', 'password_placeholder'); ?>" type="password" required>
			</div>
			
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block"><?php echo getLocalString('login_business', 'submit_text'); ?></button>
			</div>
			
			<p class="text-center"><?php echo getLocalString('login_business', 'register_text'); ?>? <a href="register.php"><?php echo getLocalString('login_business', 'register'); ?></a> </p>
		</form>
	</article>
	
</div>

<?php require "templates/footer.php"; ?>