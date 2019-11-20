<?php

namespace SeaSkincare\Backend\Mappers;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;

class UserMapper
{
	
	private function __construct() {}
	
	public static EntityToDTO($userEntity) {
	
		$userDTO = new UserDTO;
		
		$userDTO->id = $userEntity->getID();
		$userDTO->nickname = $userEntity->getNickname();
		$userDTO->email = $userEntity->getEmail();
		
		return $userDTO;
	
	}
	
	public static DTOToEntity($userDTO) {
		
		$userEntity = new User;
		
		self::UpdateFromDTO(&$userEntity, &$userDTO);
		
		return $userEntity;	
		
	}
	
	public static UpdateFromDTO($userEntity, $userDTO) {
		
		$userEntity->setID($userDTO->id);
		$userEntity->setNickname($userDTO->nickname);
		$userEntity->setEmail($userDTO->email);
		
	}	
	
}

?>