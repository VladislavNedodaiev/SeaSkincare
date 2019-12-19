<?php

namespace SeaSkincare\Backend\DTOs;



class BusinessDTO
{
	
	// Data
	public $id;
	public $registerDate;
	public $password;
	public $nickname;
	public $description;
	public $photo;
	public $email;
	public $verification;
	public $phoneNumber;
	
	// Relations
	public $subscriptions;
	public $vacations;
	public $vacationRequests;
	
}

?>