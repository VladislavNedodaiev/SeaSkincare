<?php

$header = array (
	
	'title' => 'SeaSkincare',
	'index_button_text' => 'Головна сторінка',
	'businesses_button_text' => 'Бізнеси',
	'login_button_text' => 'Вхід',
	'register_button_text' => 'Реєстрація',
	'profile_button_text' => 'Мій профіль'
	
);

$footer = array (

	'up' => 'Вгору',
	'author_text' => 'Автор сайту',
	'author' => 'Владислав Недодаєв'

);

$login = array (

	'title' => 'Вхід в якості користувача',
	'email_placeholder' => 'Введіть ваш email',
	'password_placeholder' => 'Введіть ваш пароль',
	'as_user' => 'Увійти в якості користувача',
	'as_business' => 'Увійти в якості бізнеса',
	'submit_text' => 'Вхід',
	'register_text' => "Не зареєстровані",
	'register' => 'Зареєструватися'

);

$register = array (

	'title' => 'Створення профілю',
	'nickname_placeholder' => "Введіть ім'я користувача/бізнеса",
	'email_placeholder' => 'Введіть ваш email',
	'password_placeholder' => 'Введіть ваш пароль',
	'repeat_password_placeholder' => 'Повторіть ваш пароль',
	'as_user' => 'Зареєструватися в якості користувача',
	'as_business' => 'Зареєструватися в якості бізнеса',
	'submit_text' => 'Реєстрація',
	'login_text' => 'Вже маєте акаунт',
	'login' => 'Увійти'
	
);

$registration = array (

	'SUCCESS' => 'Пітверджувальний лист надіслано, перевірте вашу електронну пошту, щоб верифікувати акаунт',
	'EMAIL_REGISTERED' => 'Акаунт з такою електронною поштою вже зареєстровано',
	'NICKNAME_REGISTERED' => "Акаунт з таким ім'ям вже зареєстровано",
	'EMAIL_UNSENT' => "Підтверджувальний лист не було надіслано, спробуйте зареєструватися пізніше",
	'DB_ERROR' => 'Сталася помилка при зверненні до бази даних',
	'UNKNOWN' => 'Сталася невідома помилка'

);

return array (

	'header' => $header,
	'footer' => $footer,
	'login' => $login,
	'register' => $register,
	'registration' => $registration

);

?>