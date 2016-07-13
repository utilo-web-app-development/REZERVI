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

if (isset($_POST["id"])){
	$id = $_POST["id"];
}
else{
	$id = array();	
}

$anzahl = count($id);
if ($anzahl < 1){
	$fehler = true;
	$nachricht = getUebersetzung("Es wurde kein Benutzer zum Löschen ausgew�hlt.");
	include_once("./index.php");	
	exit;	
}
for($i = 0; $i < $anzahl; $i++){			
	deleteBenutzer($id[$i]);      
}
$info = true;
$nachricht = "Löschungen wurden erfolgreich durchgeführt!";
include_once("./index.php");	
?>
