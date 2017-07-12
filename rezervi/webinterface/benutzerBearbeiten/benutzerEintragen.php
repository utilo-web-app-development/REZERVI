<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			benutzer eintragen
			author utilo.eu
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$pass1 = $_POST["pass"];
$name = $_POST["name"];
$pass2 = $_POST["pass2"];
$rechte = $_POST["rechte"];
$sprache = getSessionWert(SPRACHE);

//variablen initialisieren:
if (isset($_POST["ben"]) && isset($_POST["pass"])) {
	$ben = $_POST["ben"];
	$pass = $_POST["pass"];
} else {
	//aufruf kam innerhalb des webinterface:
	$ben = getSessionWert(BENUTZERNAME);
	$pass = getSessionWert(PASSWORT);
}

	//datenbank öffnen:
	include_once("../../conf/rdbmsConfig.php");

	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once("../../include/unterkunftFunctions.php");
	//uebersetzer einfuegen:
	include_once("../../include/uebersetzer.php");

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

if(!isset($name) || !isset($pass1) || !isset($pass2) || !isset($rechte)){
	header("Location: ".$URL."webinterface/benutzerBearbeiten/benutzerAnlegen.php"); /* Redirect browser */
	exit();
}

 //passwortprüfung:
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
		setUser($name,$pass1,$rechte);
        header("Location: ".$URL."webinterface/benutzerBearbeiten/index.php"); /* Redirect browser */
        exit();
    } //ende if passwortprüfung
    else {
        echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
        header("Location: ".$URL."webinterface/index.php"); /* Redirect browser */
        exit();
    }
?>
