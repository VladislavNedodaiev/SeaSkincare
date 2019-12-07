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
	
	public const SUCCESS = new Response("SUCCESS", null);
	public const NO_SKINPROBLEMID = new Response("NO_SKINPROBLEMID", null);
	public const NO_TITLE = new Response("NO_TITLE", null);
	public const NO_NORMAL_PH = new Response("NO_NORMAL_PH", null);
	public const NO_NORMAL_SALT = new Response("NO_NORMAL_SALT", null);
	public const NO_NORMAL_AIR_POLLUTION = new Response("NO_NORMAL_AIR_POLLUTION", null);
	public const NO_NORMAL_SUN_POWER = new Response("NO_NORMAL_SUN_POWER", null);
	public const UNDEFINED = new Response("UNDEFINED", null);
	
	
	public function __construct() {
	
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
			return self::NO_TITLE;
		
		if (!isset($normalPH))
			return self::NO_NORMAL_PH;
		
		if (!isset($normalSalt))
			return self::NO_NORMAL_SALT;
		
		if (!isset($normalAirPollution))
			return self::NO_NORMAL_AIR_POLLUTION;
		
		if (!isset($normalSunPower))
			return self::NO_NORMAL_SUN_POWER;
		
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
			return self::NO_SKINPROBLEMID;
		
		return $this->skinProblemService->getSkinProblem($skinProblemID);
		
	}
	
	public function getSkinProblems() {
		
		return $this->skinProblemService->getSkinProblems();
		
	}
	
	public function getLastSkinProblem() {
		
		$skinProblemID = $this->skinProblemService->getLastID();
		if ($skinProblemID->status != SkinProblemService::SUCCESS->status)
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
		
		return self::UNDEFINED;
		
	}
	
	public function editSkinProblem($skinProblemID, $title, $normalPH, $normalSalt, $normalAirPollution, $normalSunPower) {
	
		if (!isset($skinProblemID))
			return self::NO_SKINPROBLEMID;
	
		if (!isset($title))
			return self::NO_TITLE;
		
		if (!isset($normalPH))
			return self::NO_NORMAL_PH;
		
		if (!isset($normalSalt))
			return self::NO_NORMAL_SALT;
		
		if (!isset($normalAirPollution))
			return self::NO_NORMAL_AIR_POLLUTION;
		
		if (!isset($normalSunPower))
			return self::NO_NORMAL_SUN_POWER;
		
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
			return self::NO_SKINPROBLEMID;
		
		return $this->skinProblemService->deleteSkinProblem($skinProblemID);
	
	}
	
}

?>