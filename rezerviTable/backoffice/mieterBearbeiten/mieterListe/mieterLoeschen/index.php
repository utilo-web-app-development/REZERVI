<?php 
$root = "../../../..";
$ueberschrift = "Gäste bearbeiten";

/*   
	date: 17.10.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");

//prüfen ob noch reservierungen oder sowas für diesen gast vorhanden sind:
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
$mieter_id = $_POST["mieter_id"];
if(hasMieterReservations($mieter_id)){
	$fehler = true;
	$nachricht = getUebersetzung("Der Gast kann nicht gelöscht werden, da noch Reservierungen oder offene Reservierungsanfragen für diesen Gast eingetragen sind!");

}else{
	$index = $_POST["index"];
	deleteMieter($mieter_id);
	$info = true;
	$nachricht = getUebersetzung("Der Gast wurde erfolgreich gelöscht!");
}
$_POST["root"] = $root;
include_once($root."/backoffice/mieterBearbeiten/mieterListe/index.php");
?>
