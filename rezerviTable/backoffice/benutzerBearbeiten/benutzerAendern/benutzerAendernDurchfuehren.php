<?php  
$root = "../../.."; 
$ueberschrift = "Benutzerdaten bearbeiten";
$unterschrift = "Ändern";

/*   
	date: 22.9.05
	author: christian osterrieder alpstein-austria						
*/
//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/benutzerFunctions.inc.php");

$pass = $_POST["pass"];
$name = $_POST["name"];
$pass2 = $_POST["pass2"];
$rechte = $_POST["rechte"];
$id = $_POST["id"];
$testuser = $_POST["testuser"];

$fehler = false;
//eingaben pruefen:
if ($name == ""){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte geben sie den Benutzernamen ein!");
	include_once("./benutzerAendern.php");	
	exit;
}
else if($pass == "" || $pass2 == ""){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte geben sie das Passwort ein!");
	include_once("./benutzerAendern.php");	
	exit;
}
else if($pass != $pass2){
	$fehler = true;
	$nachricht = getUebersetzung("Die beiden Passwörter stimmen nicht überein!");
	include_once("./benutzerAendern.php");	
	exit;
}
else if(isBenutzerVorhanden($name,$pass,$gastro_id) && getSessionWert(BENUTZER_ID) != $id){
	$fehler = true;
	$nachricht = getUebersetzung("Ein Benutzer mit diesen Zugangsdaten ist bereits vorhanden!");
	include_once("./benutzerAendern.php");	
	exit;
}
//wenn im testmodus, dann nicht den test-benutzer ändern:
if(DEMO == true && $testuser == true){
	$fehler = true;
	$nachricht = getUebersetzung("Der Testbenutzer kann im Demo Modus nicht verändert werden!");
	include_once("./benutzerAendern.php");	
	exit;
}	
	
changeBenutzer($id,$name,$pass,$rechte);

$info = true;
$nachricht = getUebersetzung("Die Änderung wurde erfolgreich durchgeführt");

include_once("./index.php");
?>
