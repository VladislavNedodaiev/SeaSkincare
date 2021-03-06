<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Services\Service;
use SeaSkincare\Backend\Services\LogService;
use SeaSkincare\Backend\DTOs\SkinProblemDTO;
use SeaSkincare\Backend\Communication\Response;

class SkinProblemService extends Service
{
	
	private $DB_TABLE;
	
	public function __construct($host, $user, $pswd, $db, $logService) {
		
		parent::__construct($host, $user, $pswd, $db, $logService);
	
		$this->DB_TABLE = "Skin_Problem";
	
	}
	
	public function createSkinProblem($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("INSERT INTO `".$this->DB_TABLE."`(`title`, `norm_ph`, `norm_salt`, `norm_air_pollution`, `norm_sun_power`)".
						   "VALUES (".
						   "'".$dto->title."',".
						   "'".$dto->normalPH."', ".
						   "'".$dto->normalSalt."', ".
						   "'".$dto->normalAirPollution."', ".
						   "'".$dto->normalSunPower."');")) {
			$lastID = $this->getLastID();
			if ($lastID->status ==$this->SUCCESS->status
				&& $result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`skin_problem_id`=".$lastID->content.";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['skin_problem_id'];
					
					return new Response($this->SUCCESS->status, $dto);
					
				}
			}
		}
			
		return $this->DB_ERROR;
		
	}
	
	public function getSkinProblem($skinProblemID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."` WHERE `".$this->DB_TABLE."`.`skin_problem_id`='".$skinProblemID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new SkinProblemDTO;
					
				$dto->id = $res['skin_problem_id'];
				$dto->title = $res['title'];
				$dto->normalPH = $res['norm_ph'];
				$dto->normalSalt = $res['norm_salt'];
				$dto->normalAirPollution = $res['norm_air_pollution'];
				$dto->normalSunPower = $res['norm_sun_power'];
				
				return new Response($this->SUCCESS->status, $dto);
				
			}
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getSkinProblems() {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".$this->DB_TABLE."`.* FROM `".$this->DB_TABLE."`;")) {
			
			$skinProblems = array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new SkinProblemDTO;
					
				$dto->id = $res['skin_problem_id'];
				$dto->title = $res['title'];
				$dto->normalPH = $res['norm_ph'];
				$dto->normalSalt = $res['norm_salt'];
				$dto->normalAirPollution = $res['norm_air_pollution'];
				$dto->normalSunPower = $res['norm_sun_power'];
				
				array_push($skinProblems, $dto);
				
			}
			
			if (!empty($skinProblems))
				return new Response($this->SUCCESS->status, $skinProblems);
		}
		
		return $this->NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response($this->DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".$this->DB_TABLE."`.`skin_problem_id`) AS `id` FROM `".$this->DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response($this->SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response($this->DB_ERROR->status, 0);
		
	}
	
	public function updateSkinProblem($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("UPDATE `".$this->DB_TABLE."` SET `title`='".$dto->title."', `norm_ph`='".$dto->normalPH."', `norm_salt`='".$dto->normalSalt."', `norm_air_pollution`='".$dto->normalAirPollution."', `norm_sun_power`='".$dto->normalSunPower."' WHERE `skin_problem_id`='".$dto->id."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
	public function deleteSkinProblem($skinProblemID) {
		
		if (!$this->database || $this->database->connect_errno)
			return $this->DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".$this->DB_TABLE."` WHERE `skin_problem_id`='".$skinProblemID."';"))
			return $this->SUCCESS;
			
		return $this->NOT_FOUND;
		
	}
	
}

?>