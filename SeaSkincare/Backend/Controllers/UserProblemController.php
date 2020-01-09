<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Controllers\Controller;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\DTOs\UserProblemDTO;
use SeaSkincare\Backend\Services\UserProblemService;
use SeaSkincare\Backend\Communication\Response;

class UserProblemController extends Controller
{
	
	private $userProblemService;
	
	public $SUCCESS;
	public $NO_USERPROBLEMID;
	public $NO_USERID;
	public $NO_SKINPROBLEMID;
	
	public function __construct() {
		
		parent::__construct();
		
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_USERPROBLEMID = new Response("NO_USERPROBLEMID", null);
		$this->NO_USERID = new Response("NO_USERID", null);
		$this->NO_SKINPROBLEMID = new Response("NO_SKINPROBLEMID", null);

		$this->userProblemService = new UserProblemService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase(),
			$this->logService

		);
	
	}
	
	public function createUserProblem($userID, $skinProblemID) {
		
		$this->logService->logMessage("UserProblemController CreateUserProblem");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		if (!isset($skinProblemID))
			return $this->logResponse($this->NO_SKINPROBLEMID);
		
		$dto = new UserProblemDTO;
		$dto->userID = $userID;
		$dto->skinProblemID = $skinProblemID;
		
		return $this->logResponse($this->userProblemService->createUserProblem($dto));
		
	}
	
	public function getUserProblem($userProblemID) {
		
		$this->logService->logMessage("UserProblemController GetUserProblem");
		
		if (!isset($userProblemID))
			return $this->logResponse($this->NO_USERPROBLEMID);
		
		return $this->logResponse($this->userProblemService->getUserProblem($userProblemID));
		
	}
	
	public function getUserProblemsByIDs($userID, $skinProblemID) {
		
		$this->logService->logMessage("UserProblemController GetUserProblemsByIDs");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		if (!isset($skinProblemID))
			return $this->logResponse($this->NO_SKINPROBLEMID);
		
		return $this->logResponse($this->userProblemService->getUserProblemsByIDs($userID, $skinProblemID));
		
	}
	
	public function getUserProblemsByUserID($userID) {
		
		$this->logService->logMessage("UserProblemController GetUserProblemsByUserID");
		
		if (!isset($userID))
			return $this->logResponse($this->NO_USERID);
		
		return $this->logResponse($this->userProblemService->getUserProblemsByUserID($userID));
		
	}
	
	public function getUserProblemsBySkinProblemID($skinProblemID) {
		
		$this->logService->logMessage("UserProblemController GetUserProblemsBySkinProblemID");
		
		if (!isset($skinProblemID))
			return $this->logResponse($this->NO_SKINPROBLEMID);
		
		return $this->logResponse($this->userProblemService->getUserProblemsBySkinProblemID($skinProblemID));
		
	}
	
	public function getLastUserProblem() {
		
		$this->logService->logMessage("UserProblemController GetLastUserProblem");
		
		$userProblemID = $this->userProblemService->getLastID();
		if ($userProblemID->status != $this->userProblemService->SUCCESS->status)
			return $this->logResponse($userProblemID);
		
		return $this->logResponse($this->userProblemService->getUserProblem($userProblemID->content));
		
	}
	
	public function deleteUserProblem($userProblemID) {
	
		$this->logService->logMessage("UserProblemController DeleteUserProblem");
	
		if (!isset($userProblemID))
			return $this->logResponse($this->NO_USERPROBLEMID);
		
		return $this->logResponse($this->userProblemService->deleteUserProblem($userProblemID));
	
	}
	
}

?>