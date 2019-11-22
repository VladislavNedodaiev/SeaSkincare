<?php

namespace SeaSkincare\Backend\Communication;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;
use SeaSkincare\Backend\Mappers;

class Response
{
	public $status;
	public $content;
	
	public function __construct($status, $content) {
	
		$this->status = $status;
		$this->content = $content;
	
	}
	
}

?>