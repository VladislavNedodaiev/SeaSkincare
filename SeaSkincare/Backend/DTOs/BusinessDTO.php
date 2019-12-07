<?php

namespace SeaSkincare\Backend\DTOs;

use SeaSkincare\Backend\Entities;

class BusinessDTO
{
	
	// Data
	public $id;
	public $password;
	public $nickname;
	public $description;
	public $photo;
	public $email;
	public $verification;
	
	// Relations
	public $vacations;
	public $subscriptions;
	
}

?>