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

include_once("../../templates/auth.php");

if (isset($_POST["xDays"]) && $_POST["xDays"] > 0){
	$xDays = "".$_POST["xDays"];
}
else{
	$xDays = "0";
}
if (isset($_POST["resAnzeigen"]) && $_POST["resAnzeigen"] == "true"){
	$resAnzeigen = "true";
}
else{
	$resAnzeigen = "false";
}

if (isset($_POST["resHouse"]) && $_POST["resHouse"] == "true"){
	$resHouse = "true";
}
else{
	$resHouse = "false";
}

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

//save the properties:
setProperty(RES_HOUSE,$resHouse,$unterkunft_id,$link);
setProperty(SHOW_RESERVATION_STATE,$resAnzeigen,$unterkunft_id,$link);
setProperty(RESERVATION_STATE_TIME,$xDays,$unterkunft_id,$link);
  
    //Dieser Satz muss noch in die Sprachtabellen eingefügt werden.
	$nachricht = "Die Änderungen wurden erfolgreich durchgeführt!";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	$fehler = false;

include_once ("index.php");

?>