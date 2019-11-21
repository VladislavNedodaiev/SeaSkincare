<?php

namespace SeaSkincare\Backend\Services;

class MailService
{
	
	public $host;
	
	// sending email with verification address
	public function sendVerificationEmail($email, $verification) {
		
		$subject = 'Registration | Verification';
		$message = '
		 
			Дякуємо за реєстрацію!
			Ваш акаунт було створено, після активації Ви зможете увійти використовуючи наступні дані:
			
			 
			Активація акаунту:
			'.$host.'?email='.$email.'&verification='.$verification.'
		 
		';
		
		if (mail($email, $subject, $message))
			return true;
		
		return false;
		
	}
	
}

?>