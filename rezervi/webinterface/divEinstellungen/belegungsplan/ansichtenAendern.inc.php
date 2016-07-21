<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/propertiesFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../templates/components.php");

//variablen initialisieren:

if (isset($_POST["showMonatsansicht"])){
	$showMonatsansicht = $_POST["showMonatsansicht"];
}
else{
	$showMonatsansicht = false;
}
if (isset($_POST["showJahresansicht"])){
	$showJahresansicht = $_POST["showJahresansicht"];
}
else{
	$showJahresansicht = false;
}
if (isset($_POST["showGesamtansicht"])){
	$showGesamtansicht = $_POST["showGesamtansicht"];
}
else{
	$showGesamtansicht = false;
}
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

  setProperty(SHOW_MONATSANSICHT,$showMonatsansicht,$unterkunft_id,$link);
  setProperty(SHOW_JAHRESANSICHT,$showJahresansicht,$unterkunft_id,$link);
  setProperty(SHOW_GESAMTANSICHT,$showGesamtansicht,$unterkunft_id,$link);

  
    //Dieser Satz muss noch in die Sprachtabellen eingefügt werden.
	$nachricht = "Die Änderungen wurden erfolgreich durchgeführt!";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	$fehler = false;

include_once ("index.php");

?>