<?php

namespace SeaSkincare\Backend\Services;
use SeaSkincare\Backend\Communication\Response;

class MailService
{
	
	public $host;
	
	public $SUCCESS;
	public $EMAIL_UNSENT;
	
	public function __construct($host) {
		
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->EMAIL_UNSENT = new Response("EMAIL_UNSENT", null);
		
		$this->host = $host;
	
	}
	
	// sending email with verification address
	public function sendVerificationEmail($email, $verification) {
		
		$subject = 'Registration | Verification';
		$message = '
		 
			Дякуємо за реєстрацію!
			Ваш акаунт було створено, після активації Ви зможете увійти використовуючи наступні дані:
			
			 
			Активація акаунту:
			'.$this->host.'?email='.$email.'&verification='.$verification.'
		 
		';
		
		$headers = array(
			'From' => 'seaskincare@gmail.com',
			'Reply-To' => 'seaskincare@gmail.com',
			'X-Mailer' => 'PHP/' . phpversion()
		);
		
		if (mail($email, $subject, $message, $headers))
			return $this->SUCCESS;
		
		return $this->EMAIL_UNSENT;
		
	}
	
}

?>