<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

interface iMapper
{
	
	public static function EntityToDTO(&$entity);
	public static function DTOToEntity(&$dto);
	public static function UpdateFromDTO(&$entity, &$dto);
	
}
?>