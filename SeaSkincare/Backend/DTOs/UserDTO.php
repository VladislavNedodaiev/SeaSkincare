<?php

namespace SeaSkincare\Backend\DTOs;



class UserDTO
{
	
	// Data
	public $id;
	public $registerDate;
	public $password;
	public $nickname;
	public $email;
	public $verification;
	public $name;
	public $gender;
	public $phoneNumber;
	
	// Relations
	public $userProblems;
	public $vacations;
	public $vacationRequests;
	
}

?>