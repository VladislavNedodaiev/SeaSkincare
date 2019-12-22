<?php

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['profile']) || !$_SESSION['profile_type']) {

	header("Location: index.php");
	exit;

}

$account = $_SESSION['profile'];

?>

<?php require "templates/header.php"; ?>

<?php include "templates/alert.php" ?>

<article class="card-body mx-auto">
	<div class="card" style="width: 70rem;">
		<form action="scripts/save_business_profile.php" id='form' method="POST" enctype="multipart/form-data">
		<div class="card-header">
			<div class="row">
				<div class="col-8 my-auto"><?php echo getLocalString('edit_profile', 'edit_profile_title'); ?></div>
				<div class="col text-right my-auto">
				
					<button type="submit" class="btn btn-success"><?php echo getLocalString('edit_profile', 'save_button_text'); ?></button>
					<a href="business_profile.php"><button type="button" class="btn btn-secondary"><?php echo getLocalString('edit_profile', 'cancel_button_text'); ?></button></a>
				
				</div>
			</div>
		</div>
		
		<div class="card-body">
			<div class="row">
				<div class="col-3 border-right">
					<div class="card">
						<div class="card-header text-muted text-center" style="display: none" id="filepath"></div>
						<label style="margin: -1px" for="photo"><img id="photo_img" class="card-img-top" style="cursor: pointer"
							src="<?php if ($account->photo && file_exists($account->photo)) echo $account->photo; else echo "images/businesses/default.jpg" ?>"
							alt="<?php echo $account->nickname; ?>"></label>
						<input type="file" style="display: none" accept="image/png, image/jpeg" class="form-control-file" name="photo" id="photo">
						
						<div class="card-header text-center">
							<i class="far fa-calendar-alt"></i><small class = "text-muted"> <?php echo getLocalString('business_profile', 'register_date'); ?>: <?php echo substr($account->registerDate, 0, 10); ?> </small>
						</div>
					</div>
				</div>
				
				<div class="col">
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-envelope"></i> <?php echo getLocalString('business_profile', 'email'); ?>: </h4></div>
						<div class="col p-2"><h4><?php echo $account->email; ?></h4></div>
					</div>
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-user"></i> <?php echo getLocalString('business_profile', 'nickname'); ?>: </h4></div>
						<div class="col p-2"><h4><input type="text" class="form-control" id="nickname" name="nickname" placeholder="<?php echo getLocalString('edit_profile', 'business_nickname_placeholder'); ?>" value="<?php echo $account->nickname; ?>"></h4></div>
					</div>
					<div class="row m-2 border-bottom">
						<div class="col-5 my-auto"><h4 class = "text-muted"><i class="fas fa-phone"></i> <?php echo getLocalString('business_profile', 'phone'); ?>: </h4></div>
						<div class="col p-2">
							<h4><input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="<?php echo getLocalString('edit_profile', 'phone_placeholder'); ?>" value="<?php echo $account->phoneNumber; ?>"></h4>
						</div>
					</div>
				</div>
					
			</div>
			
			<h3 class = "text-center m-2"><?php echo getLocalString('business_profile', 'description'); ?></h3>
			<div class="container m-2">
				<textarea class="form-control" name="description" id="description" placeholder="Опис (не більше 3000 символів)" maxlength="3000" rows="8"><?php echo $account->description; ?></textarea>
			</div>
			
		</div>
		</form>
	</div>
</article>

<script>

var photo = document.getElementById('photo');
var photo_img = document.getElementById('photo_img');
var filepath = document.getElementById('filepath');

photo.onchange = function(event) {
	
	photo_img.src = URL.createObjectURL(event.target.files[0]);
	
	filepath.style="display: block;";
	filepath.innerHTML="<small>" + photo.value.split(/(\\|\/)/g).pop() + "</small>";
	
}

tinymce.init({selector:'#description'});

</script>

<?php require "templates/footer.php"; ?>