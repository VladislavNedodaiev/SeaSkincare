<?php

namespace SeaSkincare\Backend\Controllers;

use SeaSkincare\Backend\Data\DataRepository;
use SeaSkincare\Backend\Entities\SkinProblem;
use SeaSkincare\Backend\DTOs\SkinProblemDTO;
use SeaSkincare\Backend\Mappers\SkinProblemMapper;
use SeaSkincare\Backend\Services\SkinProblemService;
use SeaSkincare\Backend\Communication\Response;

class SkinProblemController
{
	
	private $dataRep;
	private $skinProblemService;
	
	public $SUCCESS;
	public $NO_SKINPROBLEMID;
	public $NO_TITLE;
	public $NO_NORMAL_PH;
	public $NO_NORMAL_SALT;
	public $NO_NORMAL_AIR_POLLUTION;
	public $NO_NORMAL_SUN_POWER;
	public $UNDEFINED;
	
	
	public function __construct() {
		
		$this->SUCCESS = new Response("SUCCESS", null);
		$this->NO_SKINPROBLEMID = new Response("NO_SKINPROBLEMID", null);
		$this->NO_TITLE = new Response("NO_TITLE", null);
		$this->NO_NORMAL_PH = new Response("NO_NORMAL_PH", null);
		$this->NO_NORMAL_SALT = new Response("NO_NORMAL_SALT", null);
		$this->NO_NORMAL_AIR_POLLUTION = new Response("NO_NORMAL_AIR_POLLUTION", null);
		$this->NO_NORMAL_SUN_POWER = new Response("NO_NORMAL_SUN_POWER", null);
		$this->UNDEFINED = new Response("UNDEFINED", null);
		
		$this->dataRep = new DataRepository;

		$this->skinProblemService = new SkinProblemService(

			$this->dataRep->getHost(),
			$this->dataRep->getUser(),
			$this->dataRep->getPassword(),
			$this->dataRep->getDatabase()

		);
	
	}
	
	public function createSkinProblem($title, $normalPH, $normalSalt, $normalAirPollution, $normalSunPower) {
		
		if (!isset($title))
			return $this->NO_TITLE;
		
		if (!isset($normalPH))
			return $this->NO_NORMAL_PH;
		
		if (!isset($normalSalt))
			return $this->NO_NORMAL_SALT;
		
		if (!isset($normalAirPollution))
			return $this->NO_NORMAL_AIR_POLLUTION;
		
		if (!isset($normalSunPower))
			return $this->NO_NORMAL_SUN_POWER;
		
		$dto = new SkinProblemDTO;
		$dto->title = $title;
		$dto->normalPH = $normalPH;
		$dto->normalSalt = $normalSalt;
		$dto->normalAirPollution = $normalAirPollution;
		$dto->normalSunPower = $normalSunPower;
		
		return $this->skinProblemService->createSkinProblem($dto);
		
	}
	
	public function getSkinProblem($skinProblemID) {
		
		if (!isset($skinProblemID))
			return $this->NO_SKINPROBLEMID;
		
		return $this->skinProblemService->getSkinProblem($skinProblemID);
		
	}
	
	public function getSkinProblems() {
		
		return $this->skinProblemService->getSkinProblems();
		
	}
	
	public function getLastSkinProblem() {
		
		$skinProblemID = $this->skinProblemService->getLastID();
		if ($skinProblemID->status != $this->skinProblemService->SUCCESS->status)
			return $skinProblemID;
		
		return $this->skinProblemService->getSkinProblem($skinProblemID->content);
		
	}
	
	public function getAverageSkinProblem($dtos) {
		
		$skinProblemDTO = new SkinProblemDTO;
		$skinProblemDTO->id = 0;
		$skinProblemDTO->title = "";
		$skinProblemDTO->normalPH = 0;
		$skinProblemDTO->normalSalt = 0;
		$skinProblemDTO->normalAirPollution = 0;
		$skinProblemDTO->normalSunPower = 0;
		
		$count = 0;
		foreach ($dtos as $key => &$value) {
		
			$skinProblemDTO->normalPH += $value->normalPH;
			$skinProblemDTO->normalSalt += $value->normalSalt;
			$skinProblemDTO->normalAirPollution += $value->normalAirPollution;
			$skinProblemDTO->normalSunPower += $value->normalSunPower;
		
		}
		
		if ($count) {
			
			$skinProblemDTO->normalPH /= $count;
			$skinProblemDTO->normalSalt /= $count;
			$skinProblemDTO->normalAirPollution /= $count;
			$skinProblemDTO->normalSunPower /= $count;
			
			return new Response("SUCCESS", $skinProblemDTO);
			
		}
		
		return $this->UNDEFINED;
		
	}
	
	public function editSkinProblem($skinProblemID, $title, $normalPH, $normalSalt, $normalAirPollution, $normalSunPower) {
	
		if (!isset($skinProblemID))
			return $this->NO_SKINPROBLEMID;
	
		if (!isset($title))
			return $this->NO_TITLE;
		
		if (!isset($normalPH))
			return $this->NO_NORMAL_PH;
		
		if (!isset($normalSalt))
			return $this->NO_NORMAL_SALT;
		
		if (!isset($normalAirPollution))
			return $this->NO_NORMAL_AIR_POLLUTION;
		
		if (!isset($normalSunPower))
			return $this->NO_NORMAL_SUN_POWER;
		
		$dto = new SkinProblemDTO;
		$dto->id = $skinProblemID;
		$dto->title = $title;
		$dto->normalPH = $normalPH;
		$dto->normalSalt = $normalSalt;
		$dto->normalAirPollution = $normalAirPollution;
		$dto->normalSunPower = $normalSunPower;
		
		return $this->skinProblemService->updateSkinProblem($dto);
	
	}
	
	public function deleteSkinProblem($skinProblemID) {
	
		if (!isset($skinProblemID))
			return $this->NO_SKINPROBLEMID;
		
		return $this->skinProblemService->deleteSkinProblem($skinProblemID);
	
	}
	
}

?>