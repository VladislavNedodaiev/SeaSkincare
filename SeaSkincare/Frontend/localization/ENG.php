<?php

$header = array (
	
	'title' => 'SeaSkincare',
	'index_button_text' => 'Home',
	'businesses_button_text' => 'Businesses',
	'login_button_text' => 'Login',
	'register_button_text' => 'Register',
	'profile_button_text' => 'My Profile',
	'logout_button_text' => 'Logout'
	
);

$footer = array (

	'up' => 'Go Up',
	'author_text' => 'Developer and author',
	'author' => 'Vladyslav Nedodaiev'

);

$login = array (

	'title' => 'Login as User',
	'email_placeholder' => 'Enter your email',
	'password_placeholder' => 'Enter your password',
	'as_user' => 'Login as user',
	'as_business' => 'Login as business',
	'submit_text' => 'Login',
	'register_text' => "Don't have an account yet",
	'register' => 'Create account'

);

$authorize = array (

	'SUCCESS' => 'Logged in successfully',
	'UNVERIFIED' => 'Account is unverified, check your email to verify',
	'WRONG_PASSWORD' => 'Wrong password entered',
	'NOT_FOUND' => "No user with such email",
	'DB_ERROR' => 'Database error occured',
	'UNKNOWN' => 'Unknown error occured'

);

$register = array (

	'title' => 'Create new profile',
	'nickname_placeholder' => 'Enter name of user/business',
	'email_placeholder' => 'Enter your email',
	'password_placeholder' => 'Enter your password',
	'repeat_password_placeholder' => 'Repeat your password',
	'as_user' => 'Register as user',
	'as_business' => 'Register as business',
	'submit_text' => 'Register',
	'login_text' => 'Already have an account',
	'login' => 'Login'
	
);

$registration = array (

	'SUCCESS' => 'The confirmation email has been sent, check your email to verify your account',
	'EMAIL_REGISTERED' => 'Account with the same email is already registered',
	'NICKNAME_REGISTERED' => 'Account with the same nickname is already registered',
	'EMAIL_UNSENT' => "The confirmation email hasn't been sent, try registering again later",
	'DB_ERROR' => 'Database error occured',
	'INCORRECT_EMAIL' => 'Incorrect email format',
	'DIFFERENT_PASSWORDS' => 'The passwords you have entered are different',
	'UNKNOWN' => 'Unknown error occured'

);

$logout = array (

	'SUCCESS' => 'You have successfully logged out',
	'NO_LOGIN' => 'You are not logged in',
	'UNKNOWN' => 'Unknown error occured'

);

return array (

	'header' => $header,
	'footer' => $footer,
	'login' => $login,
	'authorize' => $authorize,
	'register' => $register,
	'registration' => $registration,
	'logout' => $logout

);

?>