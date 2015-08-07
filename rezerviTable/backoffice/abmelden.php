<?php session_start();

	/* 
		author: coster
		date: 19.9.05	
		
		zerstoert die session und geht auf die login seite zurueck	
	*/
	
	$root = "..";
	
	//datenbank oeffnen:
	include_once ($root."/include/rdbmsConfig.inc.php");	
	
	//alle session eintraege zerstoeren:
	include_once($root."/include/sessionFunctions.inc.php");
	destroySession();
	
	// 4. zurueck zum login:
	include_once($root."/backoffice/index.php");
	exit;
	
?>
