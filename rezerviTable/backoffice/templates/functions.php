<?php
/*
 * Created on 17.12.2007
 * Autor: LI Haitao
 * Company: Alpstein-Austria
 * Hauptseite von Backoffice
 *  
 */
	 
 //session starten wenn dies noch nicht erfolgt ist:
 $sessId = session_id();
 if (empty($sessId)){
 	session_start();
 }
 
 // Send modified header for session-problem of ie:
 // @see http://de.php.net/session
 header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
 //datenbank Öffnen:
 include_once($root."/include/rdbmsConfig.inc.php");
 //conf file Öffnen:
 include_once($root."/conf/conf.inc.php");
 //uebersetzer Öffnen:
 include_once($root."/include/uebersetzer.inc.php");
 include_once($root."/include/sessionFunctions.inc.php");
 include_once($root."/include/cssFunctions.inc.php");  
 include_once($root."/include/benutzerFunctions.inc.php"); 
 include_once($root."/include/autoResponseFunctions.inc.php");
 //passwortpruefung durchfuehren:
 include_once($root."/backoffice/templates/checkPass.inc.php");

 //globale variablen initialisieren:
 $gastro_id = getSessionWert(GASTRO_ID);
 if (isset($_POST["standardSprache"])) {
	$sprache = $_POST["standardSprache"];
	setSessionWert(SPRACHE, $sprache);
 }else{
	$sprache = getSessionWert(SPRACHE);
 }
 
 $benutzer_id = getSessionWert(BENUTZER_ID);
 $benutzerrechte = getUserRights($benutzer_id);

?>
