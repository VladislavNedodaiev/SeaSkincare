<?php

$header = array (
	
	'title' => 'SeaSkincare',
	'index_button_text' => 'Home',
	'businesses_button_text' => 'Vacation',
	'login_button_text' => 'Login',
	'register_button_text' => 'Register',
	'guests_button_text' => 'Our guests',
	'subscriptions_button_text' => 'Our subscriptions',
	'vacations_button_text' => 'My vacations',
	'profile_button_text' => 'Profile',
	'logout_button_text' => 'Logout'
	
);

$footer = array (

	'up' => 'Go Up',
	'author_text' => 'Developer and author',
	'author' => 'Vladyslav Nedodaiev'

);

$login = array (

	'title' => 'Login',
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

$logout = array (

	'SUCCESS' => 'You have successfully logged out',
	'NO_LOGIN' => 'You are not logged in'

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

$user_profile = array (

	'profile' => 'Profile',
	'my_profile' => 'My profile',
	'register_date' => 'Registered',
	'email' => 'Email',
	'nickname' => 'Nickname',
	'name' => 'Name',
	'gender' => 'Gender',
	'female' => 'Female',
	'male' => 'Male',
	'phone' => 'Phone',
	'no_information' => 'No information'

);

$edit_profile = array (

	'edit_profile_title' => 'Edit profile',
	'save_button_text' => 'Save changes',
	'cancel_button_text' => 'Cancel changes',
	'user_nickname_placeholder' => 'Enter nickname',
	'business_nickname_placeholder' => 'Enter business name',
	'name_placeholder' => 'Enter your name',
	'phone_placeholder' => 'Enter phone number',
	'user_private' => 'This can only be seen by you and account of place, where you are staying'

);

$save_user_profile = array (

	'SUCCESS' => 'Changes saved successfully',
	'DB_ERROR' => 'Database error occured',
	'UNKNOWN' => 'Unknown error occured'

);

$business_profile = array (

	'show_devices' => 'Show devices',
	'show_vacations' => 'My vacations here',
	'register_date' => 'Registered',
	'email' => 'Email',
	'nickname' => 'Business title',
	'phone' => 'Phone',
	'no_information' => 'No information',
	'description' => 'Description'

);

$save_business_profile = array (
	
	'SUCCESS' => 'Changes saved successfully',
	'DB_ERROR' => 'Database error occured',
	'UNKNOWN' => 'Unknown error occured',
	'PHOTO_ERROR' => 'Error occured while saving photo'
	
);

return array (

	'header' => $header,
	'footer' => $footer,
	'login' => $login,
	'authorize' => $authorize,
	'logout' => $logout,
	'register' => $register,
	'registration' => $registration,
	'user_profile' => $user_profile,
	'edit_profile' => $edit_profile,
	'save_user_profile' => $save_user_profile,
	'business_profile' => $business_profile,
	'save_business_profile' => $save_business_profile

);

?>