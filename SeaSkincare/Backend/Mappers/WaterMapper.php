<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class WaterMapper implements iMapper
{
	private function __construct() {}
	
	public static function EntityToDTO($entity) {
	
		$dto = new WaterDTO;
		
		$dto->id = $entity->getID();
		$dto->temperature = $entity->getTemperature();
		$dto->pH = $entity->getPH();
		$dto->NaCl = $entity->getNaCl();
		$dto->MgCl2 = $entity->getMgCl2();
		$dto->MgSO4 = $entity->getMgSO4();
		$dto->CaSO4 = $entity->getCaSO4();
		$dto->NaBr = $entity->getNaBr();
		
		return $dto;
	
	}
	
	public static function DTOToEntity($dto) {
		
		$entity = new Water;
		
		self::UpdateFromDTO(&$entity, &$dto);
		
		return $entity;	
		
	}
	
	public static function UpdateFromDTO($entity, $dto) {
		
		$entity->setID($dto->id);
		$entity->setTemperature($dto->temperature);
		$entity->setPH($dto->pH);
		$entity->setNaCl($dto->NaCl);
		$entity->setMgCl2($dto->MgCl2);
		$entity->setMgSO4($dto->MgSO4);
		$entity->setCaSO4($dto->CaSO4);
		$entity->setNaBr($dto->NaBr);
		
	}	
	
}
?>