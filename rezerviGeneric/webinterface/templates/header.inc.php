<?php
	/**
	 * author: coster
	 * date: 9.9.05
	 * update: 5.10.05
	 * 1. teil des headers
	 * */
	 
	 //session starten:
	 session_start();
	 
	 // Send modified header for session-problem of ie:
	 // @see http://de.php.net/session
	 header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
 
	 //datenbank öffnen:
	 include_once($root."/conf/rdbmsConfig.inc.php");
	 //conf file öffnen:
	 include_once($root."/conf/conf.inc.php");
	 //uebersetzer öffnen:
	 include_once($root."/include/uebersetzer.inc.php");
	 include_once($root."/include/sessionFunctions.inc.php");
	 include_once($root."/include/cssFunctions.inc.php"); 
	 //passwortpruefung durchfuehren:
	 include_once($root."/webinterface/templates/checkPass.inc.php");
	 
	 //globale variablen initialisieren:
	 $vermieter_id = getSessionWert(VERMIETER_ID);
	 $sprache = getSessionWert(SPRACHE);
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Rezervi Generic Webinterface</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
  <?php include_once($root."/templates/stylesheets.php"); ?>
</style>  
</head>