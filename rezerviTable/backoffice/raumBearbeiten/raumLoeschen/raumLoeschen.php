<?  
$root = "../../.."; 
$ueberschrift = "Raum bearbeiten";

/*   
	date: 23.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");

//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");

$anzahl = 0;
if (isset($_POST["raum_id"])){
	$raum_id = $_POST["raum_id"];
	$anzahl = count($raum_id);
}
if ($anzahl < 1){
	$fehler = true;
	$nachricht = getUebersetzung("Es wurde kein Raum zum Löschen ausgewählt.");
	include_once("./index.php");	
	exit;	
}
if (DEMO == true){
	//im demo modus darf nicht das letzte mo gel�scht werden:
	$anzahl = getAnzahlVorhandeneRaeume($gastro_id);
	if ($anzahl <= 1){
		$fehler = true;
		$nachricht = getUebersetzung("Im Demo-Modus kann der letzte Raum nicht gelöscht werden.");
		include_once("./index.php");	
		exit;	
	}
}
for($i = 0; $i < $anzahl; $i++){
	deleteRaum($raum_id[$i]);
} //ende for 
$info = true;
if ($anzahl > 1){
	$nachricht = "Die Räume wurden samt seinen Tischen und Reservierungen aus der Datenbank gelöscht"; 
}else{
	$nachricht = "Der Raum wurde samt seinen Tischen und Reservierungen aus der Datenbank gelöscht"; 
}
include_once("./index.php");
?>