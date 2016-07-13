<?php 
$root = "../../..";
$ueberschrift = "Tisch bearbeiten";

/*   
	date: 23.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");

//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");

$anzahl = 0;
if (isset($_POST["tisch_id"])){
	$tisch_id = $_POST["tisch_id"];
	$anzahl = count($tisch_id);
}
if ($anzahl < 1){
	$fehler = true;
	$nachricht = getUebersetzung("Es wurde kein Tisch zum Löschen ausgewählt.");
	include_once("./index.php");	
	exit;	
}
if (DEMO == true){
	//im demo modus darf nicht das letzte mo gel�scht werden:
	$anzahl = getAnzahlVorhandeneRaeume($gastro_id);
	if ($anzahl <= 1){
		$fehler = true;
		$nachricht = getUebersetzung("Im Demo-Modus kann der letzte Tisch nicht gelöscht werden.");
		include_once("./index.php");	
		exit;	
	}
}
for($i = 0; $i < $anzahl; $i++){
	deleteTisch($tisch_id[$i]);
}
$info = true;
if ($anzahl > 1){
	$nachricht = "Die Tische wurden samt seinen Reservierungen aus der Datenbank gelöscht!"; 
}else{
	$nachricht = "Der Tisch wurde samt seinen Reservierungen aus der Datenbank gelöscht!"; 
}
include_once("./index.php");
?>