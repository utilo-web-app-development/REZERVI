<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
//Ändern der angezeigten sprachen:

//variablen initialisieren:
$standardsprache = $_POST["standardsprache"];
$standardspracheBelegungsplan = $_POST["standardspracheBelegungsplan"];
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$jetztWechseln = $_POST["jetztWechseln"];

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../templates/components.php");

//kontrolle ob überhaupt eine sprache ausgewählt wurde:
if (!isset($standardsprache) || $standardsprache == "" || !isset($standardspracheBelegungsplan) || $standardspracheBelegungsplan == ""){
	$nachricht = "Sie müssen mindestens eine Sprache auswählen!";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	$fehler = true;
	include_once("./index.php");
}
else{
	
	setStandardSprache($unterkunft_id,$standardsprache,$link);
	setStandardSpracheBelegungsplan($unterkunft_id,$standardspracheBelegungsplan,$link);
	if (isset($jetztWechseln) && $jetztWechseln == "true"){
		
		setSessionWert(SPRACHE,$standardsprache);
		$sprache = $standardsprache;
	}
	$nachricht = "Die Standard-Sprache wurde erfolgreich geändert!";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	$fehler = false;
	include_once("./index.php");
	
}
?>