<?php
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";

/*
 * Created on 24.04.2006
 *
 * @author coster
 */

include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/buchungseinschraenkung.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
 
 $typ = $_POST["typ"];
 $tisch_id = $_POST["moId"];
 
 if ($typ == BE_TYP_ZEIT){ 	
	
	 $vonStunde = $_POST["vonStunde"];
	 $vonMinute = $_POST["vonMinute"];
	 $bisStunde = $_POST["bisStunde"];
	 $bisMinute = $_POST["bisMinute"]; 
	 $fehler = false;
	 if ($bisStunde < $vonStunde){
	 	$fehler = true;
	 }
	 else if(($bisStunde == $vonStunde) && ($bisMinute < $vonMinute)){
	 	$fehler = true;
	 }
	 if ($fehler){
	 	$nachricht = "Die Uhrzeit wurde falsch eingegeben. Bitte wiederholen sie ihre Eingabe.";
	 	$nachricht = getUebersetzung($nachricht);
	 	include_once($root."/backoffice/divEinstellungen/buchung/index.php");
	 	exit;
	 }

 	if ($tisch_id == "alle"){
 		$res = getAllTische($gastro_id);
 		while ($d = $res->FetchNextObject()){
 			$mietobjekt_id = $d->TISCHNUMMER;
 			insertBuchungseinschraenkung($mietobjekt_id,$vonStunde,$vonMinute,$bisStunde,$bisMinute,$typ);
 		}
 	}
 	else{
 		insertBuchungseinschraenkung($tisch_id,$vonStunde,$vonMinute,$bisStunde,$bisMinute,$typ);
 	}
 }
 else if($typ == BE_TYP_TAG){
 	
 	$tage = array();
 	if (isset($_POST["tage"]) && !empty($_POST["tage"])){
 		$tage = $_POST["tage"];
 	}
 	else{
 		$nachricht = "Bitte wählen sie einen oder mehrere Tage für die Buchungseinschränkung";
 		$nachricht = getUebersetzung($nachricht);
 		$fehler = true;
 		include_once($root."/backoffice/divEinstellungen/buchung/index.php");
 		exit;
 	}
 	//buchungseinschraenkung eintragen:
 	$anzahlTage = count($tage);
 	for ($i = 0; $i<$anzahlTage; $i++){
 		$day = $tage[$i];
	 	if ($tisch_id == "alle"){
	 		$res = getAllTische($gastro_id);
	 		while ($d = $res->FetchNextObject()){
	 			$mietobjekt_id = $d->TISCHNUMMER;
	 			insertBuchungseinschraenkungTag($mietobjekt_id,$day);
	 		}
	 	}
	 	else{
	 		insertBuchungseinschraenkungTag($tisch_id,$day);
	 	}
 	}
 	
 }
 else if($typ == BE_TYP_DATUM_VON_BIS){
 	
 	$datumVon = $_POST["datumVon"];
 	$datumBis = $_POST["datumBis"];
 	$vonStunde= $_POST["vonStunde"];
 	$vonMinute= $_POST["vonMinute"];
 	$bisStunde= $_POST["bisStunde"];
 	$bisMinute= $_POST["bisMinute"]; 
 	$vonTag	  = getTagFromDatePicker($datumVon);
 	$vonMonat = getMonatFromDatePicker($datumVon);
 	$vonJahr  = getJahrFromDatePicker($datumVon);
 	$bisTag   = getTagFromDatePicker($datumBis); 
 	$bisMonat = getMonatFromDatePicker($datumBis);
 	$bisJahr  = getJahrFromDatePicker($datumBis);
 	$datumVon = constructMySqlTimestampFromDatePicker($datumVon,$vonMinute,$vonStunde);
 	$datumBis = constructMySqlTimestampFromDatePicker($datumBis,$bisMinute,$bisStunde);
 	if (!isDatumEarlier($vonMinute,$vonStunde,$vonTag, $vonMonat, $vonJahr, $bisMinute,$bisStunde,$bisTag, $bisMonat, $bisJahr)){
 		$nachricht = "Das Datum wurde falsch eingegeben. Bitte wiederholen sie ihre Eingabe.";
 		$nachricht = getUebersetzung($nachricht);
 		$fehler = true;
 		include_once($root."/backoffice/divEinstellungen/buchung/index.php");
 		exit;
 	}
    if ($tisch_id == "alle"){
 		$res = getAllTische($gastro_id);
 		while ($d = $res->FetchNextObject()){
 			$mietobjekt_id = $d->TISCHNUMMER;
 			insertBuchungseinschraenkungVonBis($mietobjekt_id,$datumVon,$datumBis,$typ);
 		}
 	}
 	else{
 		insertBuchungseinschraenkungVonBis($tisch_id,$datumVon,$datumBis,$typ);
 	}
 	
 }
 
 $info = true;
 $nachricht = "Die Reservierungseinschränkung wurde erfolgreich gespeichert.";
 $nachricht = getUebersetzung($nachricht);
 include_once($root."/backoffice/divEinstellungen/buchung/index.php");
 
?>
