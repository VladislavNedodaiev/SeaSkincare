<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class BusinessMapper
{
	
	private function __construct() {}
	
	public static EntityToDTO($businessEntity) {
	
		$businessDTO = new BusinessDTO;
		
		$businessDTO->id = $businessEntity->getID();
		$businessDTO->nickname = $businessEntity->getNickname();
		$businessDTO->description = $businessEntity->getDescription();
		$businessDTO->photo = $businessEntity->getPhoto();
		$businessDTO->email = $businessEntity->getEmail();
		
		return $businessDTO;
	
	}
	
	public static DTOToEntity($businessDTO) {
		
		$businessEntity = new Business;
		
		self::UpdateFromDTO(&$businessEntity, &$businessDTO);
		
		return $businessEntity;	
		
	}
	
	public static UpdateFromDTO($businessEntity, $businessDTO) {
		
		$businessEntity->setID($businessDTO->id);
		$businessEntity->setNickname($businessDTO->nickname);
		$businessEntity->setDescription($businessDTO->description);
		$businessEntity->setPhoto($businessDTO->photo);
		$businessEntity->setEmail($businessDTO->email);
		
	}	
	
}
?>