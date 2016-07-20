<?php
/*
 * Created on 24.04.2006
 *
 * @author coster
 */
 $root = "../../..";

include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/buchungseinschraenkung.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
 
 $typ = $_POST["typ"];
 $moId = $_POST["moId"];
 
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
	 	include_once($root."/webinterface/divEinstellungen/buchung/index.php");
	 	exit;
	 }

 	if ($moId == "alle"){
 		$res = getMietobjekteOfVermieter($vermieter_id);
 		while ($d = mysqli_fetch_array($res)){
 			$mietobjekt_id = $d["MIETOBJEKT_ID"];
 			insertBuchungseinschraenkung($mietobjekt_id,$vonStunde,$vonMinute,$bisStunde,$bisMinute,$typ);
 		}
 	}
 	else{
 		insertBuchungseinschraenkung($moId,$vonStunde,$vonMinute,$bisStunde,$bisMinute,$typ);
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
 		include_once($root."/webinterface/divEinstellungen/buchung/index.php");
 		exit;
 	}
 	//buchungseinschraenkung eintragen:
 	$anzahlTage = count($tage);
 	for ($i = 0; $i<$anzahlTage; $i++){
 		$day = $tage[$i];
	 	if ($moId == "alle"){
	 		$res = getMietobjekteOfVermieter($vermieter_id);
	 		while ($d = mysqli_fetch_array($res)){
	 			$mietobjekt_id = $d["MIETOBJEKT_ID"];
	 			insertBuchungseinschraenkungTag($mietobjekt_id,$day);
	 		}
	 	}
	 	else{
	 		insertBuchungseinschraenkungTag($moId,$day);
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
 		include_once($root."/webinterface/divEinstellungen/buchung/index.php");
 		exit;
 	}
    if ($moId == "alle"){
 		$res = getMietobjekteOfVermieter($vermieter_id);
 		while ($d = mysqli_fetch_array($res)){
 			$mietobjekt_id = $d["MIETOBJEKT_ID"];
 			insertBuchungseinschraenkungVonBis($mietobjekt_id,$datumVon,$datumBis,$typ);
 		}
 	}
 	else{
 		insertBuchungseinschraenkungVonBis($moId,$datumVon,$datumBis,$typ);
 	}
 	
 }
 
 include_once($root."/webinterface/divEinstellungen/buchung/index.php");
 
?>
