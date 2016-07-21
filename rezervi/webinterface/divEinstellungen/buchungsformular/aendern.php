<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");

//datenbank öffnen:
include_once($root . "/conf/rdbmsConfig.php");
//andere funktionen importieren:
include_once($root . "/include/benutzerFunctions.php");
include_once($root . "/include/unterkunftFunctions.php");
include_once($root . "/include/propertiesFunctions.php");
include_once($root . "/include/uebersetzer.php");
include_once($root . "/webinterface/templates/components.php");

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

?>

<?php

$uebernachtung = false;
$fruehstueck = false;
$halbpension = false;
$vollpension = false;
if (isset($_POST["uebernachtung"])) {
    $uebernachtung = $_POST["uebernachtung"];
}
if (isset($_POST["fruehstueck"])) {
    $fruehstueck = $_POST["fruehstueck"];
}
if (isset($_POST["halbpension"])) {
    $halbpension = $_POST["halbpension"];
}
if (isset($_POST["vollpension"])) {
    $vollpension = $_POST["vollpension"];
}

//werte speichern:
setProperty(PENSION_UEBERNACHTUNG, $uebernachtung, $unterkunft_id, $link);
setProperty(PENSION_FRUEHSTUECK, $fruehstueck, $unterkunft_id, $link);
setProperty(PENSION_HALB, $halbpension, $unterkunft_id, $link);
setProperty(PENSION_VOLL, $vollpension, $unterkunft_id, $link);

$nachricht = getUebersetzung("Die Änderungen wurden erfolgreich durchgeführt.", $sprache, $link);
$fehler = false;

include_once("index.php");

?>