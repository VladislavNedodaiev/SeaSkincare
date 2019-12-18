<?php include "classes/account.php";

header('Content-Type: text/html; charset=utf-8');
session_start();

$account = false;

if (!isset($_GET['account_id'])) {
	if (!isset($_SESSION['account'])) {
		$_SESSION['msg']['type'] = "alert-warning";
		$_SESSION['msg']['text'] = "Спочатку треба увійти у свій профіль!";
		header("Location: login.php");
		exit;
	}
	
	$account = $_SESSION['account'];
	$account->reload_db();
}
else if (isset($_SESSION['account']) && $_GET['account_id'] == $_SESSION['account']->account_id) {
	$account = $_SESSION['account'];
	$account->reload_db();
}
else {
	
	require "templates/connect_db.php";
	if ($mysqli->connect_errno) {
		header("Location: index.php");
		exit;
	}
	
	if ($result = $mysqli->query("SELECT `account`.* FROM `account` WHERE `account`.`account_id`=".$_GET['account_id']." AND `account`.`verified`=1;")) {
		if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$account = new account($res);
		}
		else {
			$_SESSION['msg']['type'] = "alert-warning";
			$_SESSION['msg']['text'] = "Профіль не знайдено!";
			header("Location: index.php");
			exit;
		}
	}
	else {
		$_SESSION['msg']['type'] = "alert-warning";
		$_SESSION['msg']['text'] = "Профіль не знайдено!";
		header("Location: index.php");
		exit;
	}
}
?>

<?php require "templates/header.php"; ?>

<div class="card bg-light">
	<?php include "templates/alert.php" ?>
	<article class="card-body mx-auto">
		<div class="card" style="width: 60rem;">
			<div class="card-header">
				<div class="row">
					<div class="col-8 my-auto">Профіль користувача <a href="?account_id=<?php echo $account->account_id; ?>"><?php echo $account->login; ?></a></div>
					<div class="col text-right my-auto"><?php if (isset($_SESSION['account']) && $_SESSION['account']->account_id == $account->account_id) echo '<a href="edit_profile.php"><i class="fas fa-pencil-alt"></i></a>';?> <a href="print_profile.php?account_id=<?php echo $account->account_id; ?>"><i class="fas fa-print"></i></a></div>
				</div>
			</div>
			
			<div class="card-body">
				<div class="row">
					<div class="col-3 border-right">
						<div class="card">
							<img class="card-img-top"
								src="<?php
									if ($account->avatar != "" && file_exists($account->avatar)) echo $account->avatar;
									else echo "images/default_account.jpg";?>" 
								alt="<?php echo $account->login;?>">
							
							<div class="card-header text-center">
								<i class="far fa-calendar-alt"></i><small class = "text-muted"> Реєстрація: <?php echo substr($account->register_date, 0, 10); ?> </small>
							</div>
						</div>
					</div>
					
					<div class="col">
						<ul class="nav nav-tabs" id="profileTab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="common-tab" data-toggle="tab" href="#common" role="tab" aria-controls="common" aria-selected="true">Загальне</a>
							</li>
							<?php if ($account->biography) { ?>
							<li class="nav-item">
								<a class="nav-link" id="bio-tab" data-toggle="tab" href="#bio" role="tab" aria-controls="bio" aria-selected="false">Біографія</a>
							</li>
							<?php } ?>
							<li class="nav-item">
								<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Контакти</a>
							</li>
						</ul>
						<div class="tab-content" id="profileTabContent">
							<div class="tab-pane fade show active" id="common" role="tabpanel" aria-labelledby="common-tab">
								<div class="row m-2 border-bottom">
									<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-user"></i> Прізвище: </h4></div>
									<?php if ($account->second_name) { ?>
									<div class="col my-auto"><h4><?php echo $account->second_name; ?></h4></div>
									<?php } else { ?>
									<div class="col my-auto"><h4 class = "text-muted"><i>Інформація відсутня</i></h4></div>
									<?php } ?>
								</div>
								<div class="row m-2 border-bottom">
									<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-user"></i> Ім'я: </h4></div>
									<?php if ($account->first_name) { ?>
									<div class="col my-auto"><h4><?php echo $account->first_name; ?></h4></div>
									<?php } else { ?>
									<div class="col my-auto"><h4 class = "text-muted"><i>Інформація відсутня</i></h4></div>
									<?php } ?>
								</div>
								<div class="row m-2 border-bottom">
									<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-user"></i> По батькові: </h4></div>
									<?php if ($account->patronymic) { ?>
									<div class="col my-auto"><h4><?php echo $account->patronymic; ?></h4></div>
									<?php } else { ?>
									<div class="col my-auto"><h4 class = "text-muted"><i>Інформація відсутня</i></h4></div>
									<?php } ?>
								</div>
								<div class="row m-2 border-bottom">
									<div class="col-5 my-auto"><h4 class = "text-muted"><i class="fas fa-transgender-alt"></i> Гендер: </h4></div>
									<?php if ($account->gender) { ?>
									<div class="col my-auto"><h4><?php echo $account->gender; ?></h4></div>
									<?php } else { ?>
									<div class="col my-auto"><h4 class = "text-muted"><i>Інформація відсутня</i></h4></div>
									<?php } ?>
								</div>
								<div class="row m-2 border-bottom">
									<div class="col-5 my-auto"><h4 class = "text-muted"><i class="fas fa-birthday-cake"></i> День народження: </h4></div>
									<?php if ($account->birthday) { ?>
									<div class="col my-auto"><h4><?php echo $account->birthday; ?></h4></div>
									<?php } else { ?>
									<div class="col my-auto"><h4 class = "text-muted"><i>Інформація відсутня</i></h4></div>
									<?php } ?>
								</div>
							</div>
							<?php if ($account->biography) { ?>
							<div class="tab-pane fade" id="bio" role="tabpanel" aria-labelledby="bio-tab">
								<div class="container m-2"><?php echo $account->biography; ?></div>
							</div>
							<?php } ?>
							<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
								<div class="row m-2 border-bottom">
									<div class="col-5 my-auto"><h4 class = "text-muted"><i class="fas fa-phone"></i> Телефон: </h4></div>
									<?php if ($account->phone) { ?>
									<div class="col my-auto"><h4><?php echo $account->phone; ?></h4></div>
									<?php } else { ?>
									<div class="col my-auto"><h4 class = "text-muted"><i>Інформація відсутня</i></h4></div>
									<?php } ?>
								</div>
								<div class="row m-2 border-bottom">
									<div class="col-5 my-auto"><h4 class = "text-muted"><i class="far fa-envelope"></i> Електронна пошта: </h4></div>
									<div class="col my-auto"><h4><?php echo $account->email; ?></h4></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>
</div>
<?php require "templates/footer.php"; ?>