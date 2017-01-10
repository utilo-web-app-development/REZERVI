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
$pass = $_POST["pass"];
$name = $_POST["name"];
$pass2 = $_POST["pass2"];
$rechte = $_POST["rechte"];
$sprache = getSessionWert(SPRACHE);

	//datenbank öffnen:
	include_once("../../conf/rdbmsConfig.php");

	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once("../../include/unterkunftFunctions.php");
	//uebersetzer einfuegen:
	include_once("../../include/uebersetzer.php");

 //passwortprüfung:
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
		setUser($name,$pass,$rechte);
        header("Location: http://localhost/rezervi/rezervi/webinterface/benutzerBearbeiten/index.php"); /* Redirect browser */
        exit();
    } //ende if passwortprüfung
    else {
        echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
        header("Location: http://localhost/rezervi/rezervi/webinterface/index.php"); /* Redirect browser */
        exit();
    }
?>
