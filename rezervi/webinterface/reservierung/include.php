<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */
?>
<?php

//session_save_path('/Users/emreerden/Desktop/temp');
session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");
include_once("../../include/einstellungenFunctions.php");
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);

//sprache auslesen:
//entweder aus übergebener url oder aus session
if (isset($_POST["sprache"]) && $_POST["sprache"] != "") {
    $sprache = $_POST["sprache"];
    setSessionWert(SPRACHE, $sprache);
} else {
    $sprache = getSessionWert(SPRACHE);

}
setSessionWert(SPRACHE, $sprache);

$error = $_GET["error"];
$message1 = $_GET["messsage1"];
$message2 = $_GET["messsage2"];

//datums-funktionen einbinden:
include_once("../../include/datumFunctions.php");
include_once("../../include/benutzerFunctions.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/propertiesFunctions.php");
include_once("../../include/reseller/reseller.php");
//funktions einbinden:

include_once("../../include/reservierungFunctions.php");
include_once("../../include/gastFunctions.php");

//variablen initialisieren:
if (isset($_POST["ben"]) && isset($_POST["pass"])) {
    $ben = $_POST["ben"];
    $pass = $_POST["pass"];
} else {
    //aufruf kam innerhalb des webinterface:
    $ben = getSessionWert(BENUTZERNAME);
    $pass = getSessionWert(PASSWORT);
}

$benutzer_id = -1;
if (isset($ben) && isset($pass)) {
    $benutzer_id = checkPassword($ben, $pass, $link);
}
if ($benutzer_id == -1) {
    //passwortprüfung fehlgeschlagen, auf index-seite zurück:
    $fehlgeschlagen = true;
    header("Location: ".$URL."webinterface/index.php?fehlgeschlagen=true"); /* Redirect browser */
    exit();
    //include_once("./index.php");
    //exit;
} else {
    $benutzername = $ben;
    $passwort = $pass;
    setSessionWert(BENUTZERNAME, $benutzername);
    setSessionWert(PASSWORT, $passwort);

    //unterkunft-id holen:
    $unterkunft_id = getUnterkunftID($benutzer_id, $link);
    setSessionWert(UNTERKUNFT_ID, $unterkunft_id);
    setSessionWert(BENUTZER_ID, $benutzer_id);
}

include_once("./rightHelper.php");
include_once("../../leftHelper.php");

?>
