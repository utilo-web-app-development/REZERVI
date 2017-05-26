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

include_once("./templates/auth.php");

//variablen initialisieren:

if (isset($_POST["showSamstag"])){
	$showSamstag = $_POST["showSamstag"];
}
else{
	$showSamstag = false;
}
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

  setProperty(SHOW_OTHER_COLOR_FOR_SA,$showSamstag,$unterkunft_id,$link);

  
    //Dieser Satz muss noch in die Sprachtabellen eingefügt werden.
	$nachricht = "Die Änderungen wurden erfolgreich durchgeführt!";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	$nachricht2 = "Um die Farbe des Samstages zu ändern müssen sie [Design bearbeiten] aufrufen und die Hintergrundfarben zu [Samstag belegt] und [Samstag frei] ändern.";
	$nachricht2 = getUebersetzung($nachricht2,$sprache,$link);
	$nachricht .= "<br/>".$nachricht2;
	$fehler = false;

include_once ("index.php");

?>