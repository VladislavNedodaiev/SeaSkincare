<?php

namespace SeaSkincare\Backend\DTOs;

use SeaSkincare\Backend\Entities;

class ConnectionDTO
{
	
	// Data
	public $id;
	public $buoyID;
	public $connectionDate;
	public $latitude;
	public $longitude;
	public $battery;
	
	// Relations
	public $air;
	public $water;
	public $weather;
	
}

?>