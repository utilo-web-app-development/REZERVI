<?php session_start();

	/* 
		author: coster
		date: 19.9.05	
		
		zerst�rt die session und geht auf die login seite zur�ck	
	*/
	
	$root = "..";
	
	//datenbank öffnen:
	include_once ($root."/conf/rdbmsConfig.inc.php");	
	
	//alle session eintraege zerstören:
	include_once($root."/include/sessionFunctions.inc.php");
	destroySession();
	
	// 4. zurück zum login:
	include_once($root."/webinterface/index.php");
	
?>
