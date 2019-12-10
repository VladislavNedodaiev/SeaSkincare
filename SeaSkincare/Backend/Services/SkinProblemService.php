<?php

namespace SeaSkincare\Backend\Services;

use SeaSkincare\Backend\DTOs\SkinProblemDTO;
use SeaSkincare\Backend\Communication\Response;

class SkinProblemService
{
	
	private $database;
	
	private const DB_TABLE = "Skin_Problem";
	
	public const NOT_FOUND = new Response("NOT_FOUND", null);
	public const SUCCESS = new Response("SUCCESS", null);
	public const DB_ERROR = new Response("DB_ERROR", null);
	
	public function __construct($host, $user, $pswd, $db) {
	
		$this->connectToDB($host, $user, $pswd, $db);
	
	}
	
	private function connectToDB($host, $user, $pswd, $db) {

		$this->database = new \mysqli($host, $user, $pswd, $db);

		if ($this->database->connect_errno) {
			return self::DB_ERROR;
		}

		$this->database->set_charset('utf8');

		return new Response(self::SUCCESS->status, $this->database);
		
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
			$lastID = $this->getLastID();
			if ($lastID->status == self::SUCCESS->status
				&& $this->database->query("SELECT `".self::DB_TABLE."`.* FROM `".self::DB_TABLE."` WHERE `".self::DB_TABLE."`.`skin_problem_id`=".$lastID->content.";")) {
				if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					
					$dto->id = $res['skin_problem_id'];
					
					return new Response(self::SUCCESS->status, $dto);
					
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
				
				return new Response(self::SUCCESS->status, $dto);
				
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
				
				array_push($skinProblems, $dto);
				
			}
			
			return new Response(self::SUCCESS->status, $skinProblems);
		}
		
		return self::NOT_FOUND;
		
	}
	
	public function getLastID() {
		
		if (!$this->database || $this->database->connect_errno)
			return new Response(self::DB_ERROR->status, 0);
		
		if ($result = $this->database->query("SELECT MAX(`".self::DB_TABLE."`.`skin_problem_id`) AS `id` FROM `".self::DB_TABLE."`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return new Response(self::SUCCESS->status, $res['id']);
				
			}
		}
		
		return new Response(self::DB_ERROR->status, 0);
		
	}
	
	public function updateSkinProblem($dto) {
		
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("UPDATE `".self::DB_TABLE."` SET `title`='".$dto->title."', `norm_ph`='".$dto->normalPH."', `norm_salt`='".$dto->normalSalt."', `norm_air_pollution`='".$dto->normalAirPollution."', `norm_sun_power`='".$dto->normalSunPower."' WHERE `skin_problem_id`='".$dto->id."';"))
			return self::SUCCESS;
			
		return self::NOT_FOUND;
		
	}
	
	public function deleteSkinProblem($skinProblemID) {
		
		if (!$this->database || $this->database->connect_errno)
			return self::DB_ERROR;
		
		if ($this->database->query("DELETE FROM `".self::DB_TABLE."` WHERE `skin_problem_id`='".$skinProblemID."';"))
			return self::SUCCESS;
			
		return self::NOT_FOUND;
		
	}
	
}

?>