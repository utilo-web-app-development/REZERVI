<?php session_start();

	/* 
		author: coster
		date: 19.9.05	
		
		zerst�rt die session und geht auf die login seite zur�ck	
	*/
	
	$root = "..";
	
	//datenbank �ffnen:
	include_once ($root."/conf/rdbmsConfig.inc.php");	
	
	//alle session eintraege zerst�ren:
	include_once($root."/include/sessionFunctions.inc.php");
	destroySession();
	
	// 4. zur�ck zum login:
	include_once($root."/webinterface/index.php");
	
?>
