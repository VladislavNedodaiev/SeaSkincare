<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\Entities;
use SeaSkincare\Backend\DTOs;
use SeaSkincare\Backend\Mappers;

class SkinProblemService
{
	
	private $database;
	
	private const DB_TABLE = "Skin_Problem";
	
	public const NOT_FOUND = "NOT_FOUND";
	
	public const SUCCESS = "SUCCESS";
	public const DB_ERROR = "DB_ERROR";
	
	public function __construct($host, $user, $pswd, $db) {
	
		$this->connectToDB();
	
	}
	
	private function connectToDB($host, $user, $pswd, $db) {

		$this->database = new mysqli($host, $user, $pswd, $db);

		if ($this->database->connect_errno) {
			return null;
		}

		$this->database->set_charset('utf8');

		return $this->database;
		
	}
	
	public function createSkinProblem($dto) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("INSERT INTO `".self::DB_TABLE."`(`title`, `norm_ph`, `norm_salt`, `norm_air_pollution`, `norm_sun_power`)".
						   "VALUES (".
						   "'".$dto->title."',".
						   "'".$dto->normalPH."', ".
						   "'".$dto->normalSalt."', ".
						   "'".$dto->normalAirPollution."', ".
						   "'".$dto->normalSunPower."');")) {
			if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`skin_problem_id`=".$this->getLastID().";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['skin_problem_id'];
					
					return SkinProblemMapper::DTOToEntity($dto);
					
				}
			}
		}
			
		return self::DB_ERROR;
		
	}
	
	public function getSkinProblem($skinProblemID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`skin_problem_id`='".$skinProblemID."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new SkinProblemDTO;
					
				$dto->id = $res['skin_problem_id'];
				$dto->title = $res['title'];
				$dto->normalPH = $res['norm_ph'];
				$dto->normalSalt = $res['norm_salt'];
				$dto->normalAirPollution = $res['norm_air_pollution'];
				$dto->normalSunPower = $res['norm_sun_power'];
				
				return SkinProblemMapper::DTOToEntity($dto);
				
			}
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getSkinProblems() {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($result = $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."`;")) {
			
			$skinProblems = new Array();
			
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$dto = new SkinProblemDTO;
					
				$dto->id = $res['skin_problem_id'];
				$dto->title = $res['title'];
				$dto->normalPH = $res['norm_ph'];
				$dto->normalSalt = $res['norm_salt'];
				$dto->normalAirPollution = $res['norm_air_pollution'];
				$dto->normalSunPower = $res['norm_sun_power'];
				
				array_push($skinProblems, SkinProblemMapper::DTOToEntity($dto));
				
			}
			
			return $skinProblems;
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return 0;
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`skin_problem_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return $res['id'];
				
			}
		}
		
		return 0;
		
	}
	
	public function updateSkinProblem($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `title`='".$dto->title."', `norm_ph`='".$dto->normalPH."', `norm_salt`='".$dto->normalSalt."', `norm_air_pollution`='".$dto->normalAirPollution."', `norm_sun_power`='".$dto->normalSunPower."' WHERE `skin_problem_id`='".$dto->id."';"))
			return self::SUCCESS;
			
		return self::DB_ERROR;
		
	}
	
	public function deleteSkinProblem($skinProblemID)
	{
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `skin_problem_id`='".$skinProblemID."';"))
			return self::SUCCESS;
			
		return self::DB_ERROR;
		
	}
	
}

?>