<?php
if (!isset($_SESSION))
	session_start();

function getLanguageString($language, $section, $string) {
	
	if (!isset($_SERVER['localization'])) {
		
		$_SERVER['localization']['ENG'] = include_once "ENG.php";
		
	}
	
	if (!isset($_SERVER['localization'][$language]))
		$language = 'ENG';
	
	if (!isset($_SERVER['localization'][$language][$section])
		|| !isset($_SERVER['localization'][$language][$section][$string]))
		return '';
		
	return $_SERVER['localization'][$language][$section][$string];
	
}

function getLocalString($section, $string) {
	
	if (!isset($_SESSION['language'])) {
		
		$ipInfo = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".getRealIpAddr());
		if (isset($ipInfo) && $ipInfo['geoplugin_countryCode'] == 'UA')
			$_SESSION['language']='UA';
		else
			$_SESSION['language']='ENG';
		
	}
	
	return getLanguageString($_SESSION['language'], $section, $string);
	
}

/*$UA = include_once "UA.php";

if (!isset($_SESSION['language']))
{
	$ipInfo = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".getRealIpAddr());
	if ($ipInfo['geoplugin_countryCode'] == 'UA')
	{
		$_SESSION['language']='UA';
	}
}
else if (!isset($_SESSION['	*/

?>