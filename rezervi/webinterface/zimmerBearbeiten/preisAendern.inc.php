<?php
/**
 * @author coster
 * @date 19.1.2007
 * 
 * edit, delete the preis form
 */
 
 session_start();
 $root = "../..";
 // Set flag that this is a parent file
define( '_JEXEC', 1 );
 include_once($root."/conf/rdbmsConfig.php");
 include_once($root."/include/uebersetzer.php");
 include_once($root."/include/uebersetzer.php");
 include_once($root."/include/sessionFunctions.inc.php");
 include_once($root."/include/propertiesFunctions.php");
 include_once($root."/include/priceFunctions.inc.php");
 include_once($root."/include/datumFunctions.php");
	
 $fehler = false;
 $nachricht = "";
 $sprache = getSessionWert(SPRACHE);
 $unterkunft_id = getSessionWert(UNTERKUNFT_ID);
 
 //1. wurde der hinzufuegen butten geklickt?
 if (isset($_POST["hinzufuegen"])){
 	
 	if (!isset($_POST["preis_neu"]) || empty($_POST["preis_neu"])){
 		$fehler = true;
 		$nachricht = "Der Preis muss eingegeben werden.";
 		$nachricht = getUebersetzung($nachricht,$sprache,$link);
 		include_once("./preis.php");
 		exit;
 	}
 	
 	$preis =  $_POST["preis_neu"];
 	$preis = str_replace(",",".",$preis);
	//pr�fe ob preis ein float oder integer:
	if (!is_numeric($preis)){
		$fehler = true;
 		$nachricht = "Der Preis ist kein g�ltiger Wert.";
 		$nachricht = getUebersetzung($nachricht,$sprache,$link);
 		include_once("./preis.php");
 		exit;
	}
	
	//pruefe ob datum korrekt von - bis:
	$valid_from_neu = $_POST["valid_from_neu"];
	$valid_to_neu   = $_POST["valid_to_neu"];
	$datumVAr = convertDatePickerDate($valid_from_neu);
	$datumBAr = convertDatePickerDate($valid_to_neu);
	$vonTag = $datumVAr[0];
	$vonMonat = $datumVAr[1];
	$vonJahr = $datumVAr[2];
	$bisTag = $datumBAr[0];
	$bisMonat = $datumBAr[1];
	$bisJahr = $datumBAr[2];
	if (isDatumEarlier($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr) == FALSE) {
		$fehler = true;
 		$nachricht = "Das gew�hlte Datum ist nicht korrekt.";
 		$nachricht = getUebersetzung($nachricht,$sprache,$link);
 		include_once("./preis.php");
 		exit;
	}
	$datumVon = parseDateFormular($vonTag,$vonMonat,$vonJahr);
	$datumBis = parseDateFormular($bisTag,$bisMonat,$bisJahr);
	
	//wurde ein zimmer ausgew�hlt:
	if (!isset($_POST["zimmer_id_neu"]) || empty($_POST["zimmer_id_neu"])
		|| count($_POST["zimmer_id_neu"])<1){
		$fehler = true;
 		$nachricht = "Es muss mindestens ein Mietobjekt ausgew�hlt werden.";
 		$nachricht = getUebersetzung($nachricht,$sprache,$link);
 		include_once("./preis.php");
 		exit;
	}
 	$zimmer_id_neu = $_POST["zimmer_id_neu"];
 	//preis speichern:
 	setPrice($zimmer_id_neu,$datumVon,$datumBis,$preis,"Euro",false,$link); 	
 	
 	$nachricht = "Der Preis wurde erfolgreich hinzugef�gt.";
 	$nachricht = getUebersetzung($nachricht,$sprache,$link);
 	include_once("./preis.php");
 	exit;
 }

 //2. wurde l�schen geklickt?
 $res = getPrices($unterkunft_id,$link);
 while ($d = mysql_fetch_array($res)){	
	$preis_id 	= $d["PK_ID"];
	if (isset($_POST["loeschen_".$preis_id])){
		deletePreis($preis_id);
 		$nachricht = "Der Preis wurde erfolgreich gel�scht.";
 		$nachricht = getUebersetzung($nachricht,$sprache,$link);		
		include_once("./preis.php");
 		exit;
	}
 }
 
 //3. aendern der attribute:
 if (isset($_POST["aendern"])){
 	
 	 $res = getPrices($unterkunft_id,$link);
 	 //gehe alle preise durch ob sie evt. ver�ndert wurden:
	 while ($d = mysql_fetch_array($res)){	
	 		
	 		$preis_id = $d["PK_ID"];
		
		 	if (!isset($_POST["preis_".$preis_id]) || 
		 		empty($_POST["preis_".$preis_id])){
		 		$fehler = true;
		 		$nachricht = "Der Preis muss eingegeben werden.";
		 		$nachricht = getUebersetzung($nachricht,$sprache,$link);
		 		include_once("./preis.php");
		 		exit;
		 	}
		 	
		 	$preis =  $_POST["preis_".$preis_id];
		 	$preis = str_replace(",",".",$preis);
			//pr�fe ob preis ein float oder integer:
			if (!is_numeric($preis)){
				$fehler = true;
		 		$nachricht = "Der Preis ist kein g�ltiger Wert.";
		 		$nachricht = getUebersetzung($nachricht,$sprache,$link);
		 		include_once("./preis.php");
		 		exit;
			}
			
			//pruefe ob datum korrekt von - bis:
			$valid_from_neu = $_POST["valid_from_".$preis_id];
			$valid_to_neu   = $_POST["valid_to_".$preis_id];
			$datumVAr = convertDatePickerDate($valid_from_neu);
			$datumBAr = convertDatePickerDate($valid_to_neu);
			$vonTag = $datumVAr[0];
			$vonMonat = $datumVAr[1];
			$vonJahr = $datumVAr[2];
			$bisTag = $datumBAr[0];
			$bisMonat = $datumBAr[1];
			$bisJahr = $datumBAr[2];
			if (isDatumEarlier($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr) == FALSE) {
				$fehler = true;
		 		$nachricht = "Das gew�hlte Datum ist nicht korrekt.";
		 		$nachricht = getUebersetzung($nachricht,$sprache,$link);
		 		include_once("./preis.php");
		 		exit;
			}
			$datumVon = parseDateFormular($vonTag,$vonMonat,$vonJahr);
			$datumBis = parseDateFormular($bisTag,$bisMonat,$bisJahr);
			
			//wurde ein zimmer ausgew�hlt:
			if (!isset($_POST["zimmer_".$preis_id]) || empty($_POST["zimmer_".$preis_id])
				|| count($_POST["zimmer_".$preis_id])<1){
				$fehler = true;
		 		$nachricht = "Es muss mindestens ein Mietobjekt ausgew�hlt werden.";
		 		$nachricht = getUebersetzung($nachricht,$sprache,$link);
		 		include_once("./preis.php");
		 		exit;
			}
		 	$zimmer_id_neu = $_POST["zimmer_".$preis_id];
		 	//preis speichern:
		 	changePrice($preis_id,$zimmer_id_neu,$datumVon,$datumBis,$preis,"Euro",false,$link); 	
		
	 }//ende alle m�glichen preise durchlaufen
	$nachricht = "Die Preise wurden erfolgreich ge�ndert.";
 	$nachricht = getUebersetzung($nachricht,$sprache,$link);
 	include_once("./preis.php");
 	exit;
 }

?>
