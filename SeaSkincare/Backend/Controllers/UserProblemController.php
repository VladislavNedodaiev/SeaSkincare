<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\UserProblem;
use SeaSkincare\Backend\DTOs\UserProblemDTO;
use SeaSkincare\Backend\Mappers\UserProblemMapper;
use SeaSkincare\Backend\Services\UserProblemService;
use SeaSkincare\Backend\Communication\Response;

class UserProblemController
{
	
	private $dataRep;
	private $userProblemService;
	
	public const SUCCESS = new Response("SUCCESS", null);
	public const NO_USERPROBLEMID = new Response("NO_USERPROBLEMID", null);
	public const NO_USERID = new Response("NO_USERID", null);
	public const NO_SKINPROBLEMID = new Response("NO_SKINPROBLEMID", null);
	
	public function __construct() {
	
		$this->dataRep = new DataRepository;

		$this->userProblemService = new UserProblemService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase()

		);
	
	}
	
	public function createUserProblem($userID, $skinProblemID) {
		
		if (!isset($userID))
			return self::NO_USERID;
		
		if (!isset($skinProblemID))
			return self::NO_SKINPROBLEMID;
		
		$dto = new UserProblemDTO;
		$dto->userID = $userID;
		$dto->skinProblemID = $skinProblemID;
		
		return $this->userProblemService->createUserProblem($dto);
		
	}
	
	public function getUserProblem($userProblemID) {
		
		if (!isset($userProblemID))
			return self::NO_USERPROBLEMID;
		
		return $this->userProblemService->getUserProblem($userProblemID);
		
	}
	
	public function getUserProblemsByIDs($userID, $skinProblemID) {
		
		if (!isset($userID))
			return self::NO_USERID;
		
		if (!isset($skinProblemID))
			return self::NO_SKINPROBLEMID;
		
		return $this->userProblemService->getUserProblemsByIDs($userID, $skinProblemID);
		
	}
	
	public function getUserProblemsByUserID($userID) {
		
		if (!isset($userID))
			return self::NO_USERID;
		
		return $this->userProblemService->getUserProblemsByUserID($userID);
		
	}
	
	public function getUserProblemsBySkinProblemID($skinProblemID) {
		
		if (!isset($skinProblemID))
			return self::NO_SKINPROBLEMID;
		
		return $this->userProblemService->getUserProblemsBySkinProblemID($skinProblemID);
		
	}
	
	public function getLastUserProblem() {
		
		$userProblemID = $this->userProblemService->getLastID();
		if ($userProblemID->status != UserProblemService::SUCCESS->status)
			return $userProblemID;
		
		return $this->userProblemService->getUserProblem($userProblemID->content);
		
	}
	
	public function deleteUserProblem($userProblemID) {
	
		if (!isset($userProblemID))
			return self::NO_USERPROBLEMID;
		
		return $this->userProblemService->deleteUserProblem($userProblemID);
	
	}
	
}

?>