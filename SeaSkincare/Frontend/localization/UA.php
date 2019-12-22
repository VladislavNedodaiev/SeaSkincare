<?php

$header = array (
	
	'title' => 'SeaSkincare',
	'index_button_text' => 'Головна сторінка',
	'businesses_button_text' => 'Знайти відпочинок',
	'login_button_text' => 'Вхід',
	'register_button_text' => 'Реєстрація',
	'guests_button_text' => 'Наші гості',
	'subscriptions_button_text' => 'Наші підписки',
	'vacations_button_text' => 'Мої відпочинки',
	'skin_problems_button_text' => "Моє здоров'я",
	'profile_button_text' => 'Профіль',
	'logout_button_text' => 'Вийти'
	
);

$footer = array (

	'up' => 'Вгору',
	'author_text' => 'Автор сайту',
	'author' => 'Владислав Недодаєв'

);

$login = array (

	'title' => 'Вхід в систему',
	'email_placeholder' => 'Введіть ваш email',
	'password_placeholder' => 'Введіть ваш пароль',
	'as_user' => 'Увійти в якості користувача',
	'as_business' => 'Увійти в якості бізнеса',
	'submit_text' => 'Вхід',
	'register_text' => "Не зареєстровані",
	'register' => 'Зареєструватися'

);

$authorize = array (

	'SUCCESS' => 'Авторизацію проведено успішно',
	'UNVERIFIED' => 'Акаунт не верифіковано, перевірте вашу електронну пошту для верифікації',
	'WRONG_PASSWORD' => 'Ви ввели неправильний пароль',
	'NOT_FOUND' => "Користувача з такою електронною поштою не знайдено",
	'DB_ERROR' => 'Сталася помилка при зверненні до бази даних',
	'UNKNOWN' => 'Сталася невідома помилка'

);

$logout = array (

	'SUCCESS' => 'Ви успішно вийшли з профіля',
	'NO_LOGIN' => 'Ви не авторизовані в системі'

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
	'INCORRECT_EMAIL' => 'Неправильний формат email',
	'DIFFERENT_PASSWORDS' => 'Паролі, які Ви ввели - не співпадають',
	'UNKNOWN' => 'Сталася невідома помилка'

);

$user_profile = array (

	'profile' => 'Профіль',
	'my_profile' => 'Мій профіль',
	'register_date' => 'Реєстрація',
	'email' => 'Електронна пошта',
	'nickname' => 'Нікнейм',
	'name' => "Ім'я",
	'gender' => 'Гендер',
	'female' => 'Жінка',
	'male' => 'Чоловік',
	'phone' => 'Номер телефону',
	'no_information' => 'Інформація відсутня'

);

$edit_profile = array (

	'edit_profile_title' => 'Редагувати профіль',
	'save_button_text' => 'Зберегти зміни',
	'cancel_button_text' => 'Скасувати зміни',
	'user_nickname_placeholder' => 'Введіть нікнейм',
	'business_nickname_placeholder' => 'Введіть назву бізнеса',
	'name_placeholder' => "Введіть ваше ім'я",
	'phone_placeholder' => 'Введіть номер телефону',
	'user_private' => 'Це можете бачити тільки ви та акаунт місця, де ви зупинилися'

);

$save_user_profile = array (

	'SUCCESS' => 'Зміни були застосовані',
	'DB_ERROR' => 'Сталася помилка при зверненні до бази даних',
	'UNKNOWN' => 'Сталася невідома помилка'

);

$business_profile = array (

	'show_devices' => 'Переглянути пристрої',
	'show_vacations' => 'Мої відпочинки тут',
	'register_date' => 'Реєстрація',
	'email' => 'Електронна пошта',
	'nickname' => 'Назва бізнесу',
	'phone' => 'Номер телефону',
	'no_information' => 'Інформація відсутня',
	'description' => 'Опис'

);

$save_business_profile = array (
	
	'SUCCESS' => 'Зміни були застосовані',
	'DB_ERROR' => 'Сталася помилка при зверненні до бази даних',
	'UNKNOWN' => 'Сталася невідома помилка',
	'PHOTO_ERROR' => 'Сталася помилка під час збереження зображення'
	
);

$my_skin_problems = array (

	'title' => "Моє здоров'я",
	'add_problem' => 'Додати хворобу',
	'no_information' => 'Щаслива людина! Не знайдено жодної проблеми!'

);

$skin_problems = array (

	'Atopic Dermatit' => 'Атопічний дерматит',
	'Sun Allergy' => 'Алергія на сонце',
	'Water Allergy' => 'Алергія на воду'

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
	'save_business_profile' => $save_business_profile,
	'my_skin_problems' => $my_skin_problems,
	'skin_problems' => $skin_problems

);

?>