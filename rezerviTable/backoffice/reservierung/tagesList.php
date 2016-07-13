<?php 
$root = "../..";
$ueberschrift = "Reservierungen bearbeiten";

/*
 * Created on 24.09.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria
 * Anzeige die Reservierungslist in einem Tag  
 */

include_once($root."/backoffice/reservierung/tagesuebersicht.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/templates/constants.inc.php");	

$tischs = getTische($raum_id);
$vorhanden = "false";

while($tisch = $tischs->FetchNextObject()) {
	$hasRes = showReservierungen(0, 59, 0, 23, $tag,$monate,$jahr,$gastro_id,$tisch->TISCHNUMMER,MODUS_WEBINTERFACE, true, "index.php", "", $raum_id, $tag."/".$monate."/".$jahr, $ansicht);
	if($vorhanden == "false"){
		$vorhanden = $hasRes;
	}
}
if($vorhanden == "false"){?>
	<table class="frei">
		<tr>
			<td><?php echo getUebersetzung("Keine Reservierungen an diesem Tag vorhanden") ?>.</td>
		</tr>
	</table><?php
}
?>
