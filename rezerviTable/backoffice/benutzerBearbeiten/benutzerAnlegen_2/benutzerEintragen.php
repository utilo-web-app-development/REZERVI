<?php  
$root = "../../.."; 
$ueberschrift = "Benutzerdaten bearbeiten";

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

$fehler = false;
//eingaben pruefen:
if ($name == ""){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte geben sie den Benutzernamen ein!");
	include_once("./index.php");	
	exit;
}
else if($pass == "" || $pass2 == ""){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte geben sie das Passwort ein!");
	include_once("./index.php");	
	exit;
}
else if($pass != $pass2){
	$fehler = true;
	$nachricht = getUebersetzung("Die beiden Passwörter stimmen nicht überein!");
	include_once("./index.php");	
	exit;
}
else if(isBenutzerVorhanden($name,$pass,$gastro_id)){
	$fehler = true;
	$nachricht = getUebersetzung("Ein Benutzer mit diesen Zugangsdaten ist bereits vorhanden!");
	include_once("./index.php");	
	exit;
}
	
//eintragen in db
setBenutzer($name,$pass,$rechte,$gastro_id);

$info = true;
$nachricht = getUebersetzung("Der Benutzer $name wurde erfolgreich hinzugefügt.");
include_once("./index.php");
exit;
?>