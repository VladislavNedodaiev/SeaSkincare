<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class ConnectionMapper
{
	
	private function __construct() {}
	
	public static EntityToDTO($entity) {
	
		$dto = new ConnectionDTO;
		
		$dto->id = $entity->getID();
		$dto->buoyID = $entity->getBuoyID();
		$dto->connectionDate = $entity->getConnectionDate();
		$dto->latitude = $entity->getLatitude();
		$dto->longitude = $entity->getLongitude();
		$dto->battery = $entity->getBattery();
		
		return $dto;
	
	}
	
	public static DTOToEntity($dto) {
		
		$entity = new Connection;
		
		self::UpdateFromDTO(&$entity, &$dto);
		
		return $entity;	
		
	}
	
	public static UpdateFromDTO($entity, $dto) {
		
		$entity->setID($dto->id);
		$entity->setBuoyID($dto->buoyID);
		$entity->setConnectionDate($dto->connectionDate);
		$entity->setLatitude($dto->latitude);
		$entity->setLongitude($dto->longitude);
		$entity->setBattery($dto->battery);
		
	}	
	
}
?>