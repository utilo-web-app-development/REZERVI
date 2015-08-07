<?php 
$root = "../..";
$ueberschrift = "Reservierungen bearbeiten";

/*
 * Created on 20.11.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria
 * Löschen der Reservierung und zurückkehren
 *  
 */ 
	  			  
include_once($root."/backoffice/templates/functions.php");
include_once($root."/backoffice/reservierung/tagesuebersicht.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");

$reservierung_id = $_POST["reservierung_id"];
$bisMinute = $_POST["bisMinute"];
$vonMinute = $_POST["vonMinute"];
$vonStunde = $_POST["vonStunde"];
$bisStunde = $_POST["bisStunde"];
$tisch_id = $_POST["table_id"];
$raum_id = $_POST["raum_id"];
$datumVon = $_POST["datumVon"];
$tag = getTagFromDatePicker($datumVon);
$monat = getMonatFromDatePicker($datumVon); 
$jahr = getJahrFromDatePicker($datumVon); 
if(isBlock($raum_id, $tisch_id, $vonMinute,$vonStunde,$tag,$monat,$jahr,$bisMinute,$bisStunde,$tag,$monat,$jahr)){
	$fehler = true;
	$nachricht = "Wegen der Blockierung wurde die Reservierung nicht erfolgreich geändert!";
	include_once("./dispAendern.php");
	exit;
}else if(hasReservierung($reservierung_id, $tisch_id,$vonMinute,$vonStunde,$tag,$monat,$jahr,$bisMinute,$bisStunde,$tag,$monat,$jahr)){
	$fehler = true;
	$nachricht = "Im neuen Zeitraum ist andere Reservierung vorhanden!";
	include_once("./dispAendern.php");
	exit;
}
changeReservationTime($reservierung_id,$tisch_id,$vonMinute,$vonStunde, $bisMinute,$bisStunde, $tag, $monat, $jahr);
?>
<script>
	window.history.go(0);
</script>	