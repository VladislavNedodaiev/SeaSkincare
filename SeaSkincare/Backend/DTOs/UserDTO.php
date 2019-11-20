<?php

namespace SeaSkincare\Backend\DTOs;

use SeaSkincare\Backend\Entities;

class UserDTO
{
	
	// Data
	public $id;
	public $passwordHash;
	public $nickname;
	public $email;
	public $verificationHash;
	
	// Relations
	public $userProblems;
	public $vacations;
	
}

?>