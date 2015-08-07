<?php 
session_start();
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";

/**
@author coster
@date 30.07.2007
speichert eine Reservierungsdauer
* */
	
	if (isset($_POST["vonDauerStunde"]) && isset($_POST["vonDauerMinute"])){
		
		$vonDauerStunde = $_POST["vonDauerStunde"];
		$vonDauerMinute = $_POST["vonDauerMinute"];
		$dauer = $vonDauerStunde*60+$vonDauerMinute;
		
		include_once($root."/include/rdbmsConfig.inc.php");
		include_once($root."/include/vermieterFunctions.inc.php");
		include_once($root."/include/sessionFunctions.inc.php");
		include_once($root."/include/uebersetzer.inc.php");

		$sprache = getSessionWert(SPRACHE);
		$gastro_id = getSessionWert(GASTRO_ID);

		setGastroProperty(RESERVIERUNGSDAUER,$dauer,$gastro_id);
		
		$nachricht = "Die Reservierungsdauer wurde erfolgreich gespeichert.";
	 	$nachricht = getUebersetzung($nachricht);
	 	$info = true;
	 	include_once($root."/backoffice/divEinstellungen/buchung/index.php");
	 	exit;
		
	}
	
?>