<?php
	/**
	 * author: coster
	 * date: 9.9.05
	 * update: 5.10.05
	 * 1. teil des headers
	 * */
	 
	 if (!isset($nachricht)){
		 //session starten:
		 session_start();
		 
		 // Send modified header for session-problem of ie:
		 // @see http://de.php.net/session
		 header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
	 }
	 //conf file oeffnen:
	 include_once($root."/conf/conf.inc.php");
	 //datenbank �oeffnen:
	 include_once($root."/include/rdbmsConfig.inc.php");
	 //uebersetzer oeffnen:
	 include_once($root."/include/uebersetzer.inc.php");
	 include_once($root."/include/sessionFunctions.inc.php");
	 include_once($root."/include/cssFunctions.inc.php"); 
	 include_once($root."/include/vermieterFunctions.inc.php");
	 
	 //globale variablen initialisieren:
	 $gastro_id = getSessionWert(GASTRO_ID);
	 $sprache = getSessionWert(SPRACHE);
	
?>
<!DOCTYPE html>
<html>
<head>
<title>Bookline Booking System - Bookline Buchungssystem - alpstein-austria</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
  <?php include_once($root."/templates/stylesheets.php"); ?>
</style>  
<link rel="stylesheet" type="text/css" href="<?php echo $root ?>/templates/rezerviTable.css"/>
</head>