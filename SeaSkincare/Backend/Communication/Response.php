<?php

namespace SeaSkincare\Backend\Communication;

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