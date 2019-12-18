<?php

namespace SeaSkincare\Backend\DTOs;

class SkinProblemDTO
{
	
	// Data
	public $id;
	public $title;
	public $normalPH;
	public $normalSalt;
	public $normalAirPollution;
	public $normalSunPower;
	
	// Relations
	public $userProblems;
	
}

?>