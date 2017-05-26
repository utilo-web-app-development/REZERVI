<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
//Ändern der angezeigten sprachen:

//variablen initialisieren:
$artRightWI  = $_POST["artRightWI"];
$artRightBP  = $_POST["artRightBP"];
$artLeftWI   = $_POST["artLeftWI"];
$artLeftBP   = $_POST["artLeftBP"];
$wertRightWI = $_POST["wertRightWI"];
$wertRightBP = $_POST["wertRightBP"];
$wertLeftWI  = $_POST["wertLeftWI"];
$wertLeftBP  = $_POST["wertLeftBP"];
//sicherstellen, dass es sich um int handelt
//mit trick:
//$foo = 1 + "bob3";   // $foo is integer (1)
if ($artRightWI != "*")
{
	$wertRightWI = 1 + $wertRightWI - 1;
}
if ($artRightBP != "*")
{
	$wertRightBP = 1 + $wertRightBP - 1;
}
if ($artLeftWI != "*")
{
	$wertLeftWI = 1 + $wertLeftWI - 1;
}
if ($artLeftBP != "*")
{
	$wertLeftBP = 1 + $wertLeftBP - 1;
}
if ($artRightBP == "*")
{
	$wertRightBP = "*";
}
if ($artLeftBP == "*")
{
	$wertLeftBP = "*";
}
if ($artRightWI == "*")
{
	$wertRightWI = "*";
}
if ($artLeftWI == "*")
{
	$wertLeftWI = "*";
}

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache       = getSessionWert(SPRACHE);
$passwort      = getSessionWert(PASSWORT);
$benutzername  = getSessionWert(BENUTZERNAME);

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../templates/components.php");
include_once($root . "/include/propertiesFunctions.php");

include_once("../../templates/auth.php");

setFramesizeLeftBP($unterkunft_id, $wertLeftBP, $artLeftBP, $link);
setFramesizeRightBP($unterkunft_id, $wertRightBP, $artRightBP, $link);
setFramesizeRightWI($unterkunft_id, $wertRightWI, $artRightWI, $link);
setFramesizeLeftWI($unterkunft_id, $wertLeftWI, $artLeftWI, $link);

$nachricht = "Die Framegrößen wurden erfolgreich geändert";
$nachricht = getUebersetzung($nachricht, $sprache, $link);
$nachricht .= ".";
$fehler    = false;
$success = true;

if (isset($_POST["splitHorizontal"]) && $_POST["splitHorizontal"] == "true")
{
	$success = setProperty(HORIZONTAL_FRAME, "true", $unterkunft_id, $link);
}
else
{
    echo "test";
	$success = setProperty(HORIZONTAL_FRAME, "false", $unterkunft_id, $link);
}

if(!$success){
	$nachricht = getUebersetzung("Fehler bei der Änderung den Framegrößen.", $sprache, $link);
	$fehler = true;
}
include_once("./index.php");

?>