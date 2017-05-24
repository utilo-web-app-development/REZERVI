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

//variablen initialisieren:
if (isset($_POST["ben"]) && isset($_POST["pass"]))
{
	$ben  = $_POST["ben"];
	$pass = $_POST["pass"];
}
else
{
	//aufruf kam innerhalb des webinterface:
	$ben  = getSessionWert(BENUTZERNAME);
	$pass = getSessionWert(PASSWORT);
}

$benutzer_id = -1;
if (isset($ben) && isset($pass))
{
	$benutzer_id = checkPassword($ben, $pass, $link);
}
if ($benutzer_id == -1)
{
	//passwortprüfung fehlgeschlagen, auf index-seite zurück:
	$fehlgeschlagen = true;
	header("Location: " . $URL . "webinterface/index.php?fehlgeschlagen=true"); /* Redirect browser */
	exit();
	//include_once("./index.php");
	//exit;
}
else
{
	$benutzername = $ben;
	$passwort     = $pass;
	setSessionWert(BENUTZERNAME, $benutzername);
	setSessionWert(PASSWORT, $passwort);

	//unterkunft-id holen:
	$unterkunft_id = getUnterkunftID($benutzer_id, $link);
	setSessionWert(UNTERKUNFT_ID, $unterkunft_id);
	setSessionWert(BENUTZER_ID, $benutzer_id);
}
	
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
	//prüfe ob preis ein float oder integer:
	if (!is_numeric($preis)){
		$fehler = true;
 		$nachricht = "Der Preis ist kein gültiger Wert.";
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
 		$nachricht = "Das gewählte Datum ist nicht korrekt.";
 		$nachricht = getUebersetzung($nachricht,$sprache,$link);
 		include_once("./preis.php");
 		exit;
	}
	$datumVon = parseDateFormular($vonTag,$vonMonat,$vonJahr);
	$datumBis = parseDateFormular($bisTag,$bisMonat,$bisJahr);
	
	//wurde ein zimmer ausgewählt:
	if (!isset($_POST["zimmer_id_neu"]) || empty($_POST["zimmer_id_neu"])
		|| count($_POST["zimmer_id_neu"])<1){
		$fehler = true;
 		$nachricht = "Es muss mindestens ein Mietobjekt ausgewählt werden.";
 		$nachricht = getUebersetzung($nachricht,$sprache,$link);
 		include_once("./preis.php");
 		exit;
	}
 	$zimmer_id_neu = $_POST["zimmer_id_neu"];
 	//preis speichern:
 	setPrice($zimmer_id_neu,$datumVon,$datumBis,$preis,"Euro",false,$link); 	
 	
 	$nachricht = "Der Preis wurde erfolgreich hinzugefügt.";
 	$nachricht = getUebersetzung($nachricht,$sprache,$link);
 	include_once("./preis.php");
 	exit;
 }

 //2. wurde löschen geklickt?
 $res = getPrices($unterkunft_id,$link);
 while ($d = mysqli_fetch_array($res)){
	$preis_id 	= $d["PK_ID"];
	if (isset($_POST["loeschen_".$preis_id])){
		deletePreis($preis_id);
 		$nachricht = "Der Preis wurde erfolgreich gelöscht.";
 		$nachricht = getUebersetzung($nachricht,$sprache,$link);		
		include_once("./preis.php");
 		exit;
	}
 }
 
 //3. aendern der attribute:
 if (isset($_POST["aendern"])){
 	
 	 $res = getPrices($unterkunft_id,$link);
 	 //gehe alle preise durch ob sie evt. verändert wurden:
	 while ($d = mysqli_fetch_array($res)){
	 		
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
			//prüfe ob preis ein float oder integer:
			if (!is_numeric($preis)){
				$fehler = true;
		 		$nachricht = "Der Preis ist kein gültiger Wert.";
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
		 		$nachricht = "Das gewählte Datum ist nicht korrekt.";
		 		$nachricht = getUebersetzung($nachricht,$sprache,$link);
		 		include_once("./preis.php");
		 		exit;
			}
			$datumVon = parseDateFormular($vonTag,$vonMonat,$vonJahr);
			$datumBis = parseDateFormular($bisTag,$bisMonat,$bisJahr);
			
			//wurde ein zimmer ausgewählt:
			if (!isset($_POST["zimmer_".$preis_id]) || empty($_POST["zimmer_".$preis_id])
				|| count($_POST["zimmer_".$preis_id])<1){
				$fehler = true;
		 		$nachricht = "Es muss mindestens ein Mietobjekt ausgewählt werden.";
		 		$nachricht = getUebersetzung($nachricht,$sprache,$link);
		 		include_once("./preis.php");
		 		exit;
			}
		 	$zimmer_id_neu = $_POST["zimmer_".$preis_id];
		 	//preis speichern:
		 	changePrice($preis_id,$zimmer_id_neu,$datumVon,$datumBis,$preis,"Euro",false,$link); 	
		
	 }//ende alle möglichen preise durchlaufen
	 
	$nachricht = "Die Preise wurden erfolgreich geändert.";
 	$nachricht = getUebersetzung($nachricht,$sprache,$link);
 	include_once("./preis.php");
 	exit;
 }

?>
