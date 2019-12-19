<?php
if (!isset($_SESSION))
	session_start();

include_once "localization/localization.php";

?>

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<meta name="author" content="Nedodaiev Vladyslav"> 
		<meta name="copyright" content="Nedodaiev Vladyslav"> 
		
		<title><?php echo getLocalString('header', 'title'); ?></title>
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
		<link rel="stylesheet" href="styles.css">

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</head>

	<body style="background-color: #0d47a1; word-wrap: break-word;">
	
		<header class="sticky-top">
			<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
					<div class="navbar-nav">
						<a class="nav-item nav-link" href="index.php"><?php echo getLocalString('header', 'index_button_text'); ?></a>
						<a class="nav-item nav-link" href="businesses.php"><?php echo getLocalString('header', 'businesses_button_text'); ?></a>
						<?php if (!isset($_SESSION['profile'])) { ?>
							<a class="nav-item nav-link" href="login.php"><?php echo getLocalString('header', 'login_button_text'); ?></a>
							<a class="nav-item nav-link" href="register.php"><?php echo getLocalString('header', 'register_button_text'); ?></a>
						<?php } else { ?>
							<?php if (isset($_SESSION['profile']->description)) { ?>
								<a class="nav-item nav-link" href="my_guests.php"><?php echo getLocalString('header', 'guests_button_text'); ?></a>
								<a class="nav-item nav-link" href="my_subscriptions.php"><?php echo getLocalString('header', 'subscriptions_button_text'); ?></a>
								<a class="nav-item nav-link" href="business_profile.php"><?php echo getLocalString('header', 'profile_button_text'); ?></a>
							<?php } else { ?>
								<a class="nav-item nav-link" href="my_vacations.php"><?php echo getLocalString('header', 'vacations_button_text'); ?></a>
								<a class="nav-item nav-link" href="user_profile.php"><?php echo getLocalString('header', 'profile_button_text'); ?></a>
							<?php } ?>
							<a class="nav-item nav-link" href="logout.php"><?php echo getLocalString('header', 'logout_button_text'); ?></a>
						<?php } ?>
					</div>
					<span class="mx-3">
						<a href="localization/localize.php?language=ENG&address=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"><img src='images/languages/ENG.png'></a>
						<a href="localization/localize.php?language=UA&address=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"><img src='images/languages/UA.png'></a>
					</span>
				</div>
			</nav>
		</header>
		
		<div class = "content" style="background-color: #FFF">