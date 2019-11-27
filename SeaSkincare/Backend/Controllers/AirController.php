<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\Air;
use SeaSkincare\Backend\DTOs\AirDTO;
use SeaSkincare\Backend\Mappers\AirMapper;
use SeaSkincare\Backend\Services\AirService;
use SeaSkincare\Backend\Communication\Response;

class AirController
{
	
	private $dataRep;
	private $airService;
	
	public const NO_AIRID = new Response("NO_AIRID", null);
	public const SUCCESS = new Response("SUCCESS", null);
	
	
	public function __construct() {
	
		$this->dataRep = new DataRepository;

		$this->userService = new UserService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase()

		);
	
	}
	
	public function getAir($airID) {
		
		if (!isset($airID))
			return self::NO_AIRID;
		
		return $this->airService->getAir($airID);
		
	}
	
	public function editAir($airID) {
	
		/*if (!isset($userID))
			return self::NO_USERID;
		
		$dto = UserDTO;
		$dto->id = $userID;
		$dto->nickname = $nickname;
		$dto->email = $email;
		
		return $this->userService->updateUser($dto);*/
	
	}
	
	public function deleteAir($airID, $oldPassword, $newPassword) {
	
		/*if (!isset($userID))
			return self::NO_USERID;
		
		if (!isset($oldPassword))
			return self::NO_OLD_PASSWORD;
		
		if (!isset($newPassword))
			return self::NO_NEW_PASSWORD;
		
		return $this->userService->updatePassword($userID, $oldPassword, $newPassword);*/
	
	}
	
}

?>