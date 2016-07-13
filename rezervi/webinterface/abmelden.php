<?php session_start();
	$root = "..";
	// Set flag that this is a parent file
define( '_JEXEC', 1 );
	include_once($root."/include/sessionFunctions.inc.php");

	/* 
		reservierungsplan - utilo.eu
		author: christian osterrieder
			
	*/
	
	//session zerstören:
	destroySession();

	include_once($root."/include/schliesseDB.php");
	
	header("Location: ".$root."/webinterface/index.php");
  	exit;
	
?>
