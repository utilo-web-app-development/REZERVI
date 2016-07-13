<?php 
$root = "../..";
$ueberschrift = "Reservierungen bearbeiten";

/*   
	date: 3.11.05
	author: christian osterrieder alpstein-austria						
*/

include_once($root."/backoffice/templates/functions.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/backoffice/reservierung/tagesuebersicht.php");
include_once($root."/include/rdbmsConfig.inc.php");
 
$anzahlRes = $_POST["anzahlRes"];
$vonTag = $_POST["vonTag"];
$bisTag = $_POST["bisTag"];
$vonMonat = $_POST["vonMonat"];
$bisMonat = $_POST["bisMonat"];
$vonJahr = $_POST["vonJahr"];
$bisJahr = $_POST["bisJahr"];
$tisch_id = $_POST["table_id"];
$vonMinute=$_POST["vonMinute"];
$vonStunde=$_POST["vonStunde"];
$bisMinute=$_POST["bisMinute"];
$bisStunde=$_POST["bisStunde"];
$raum_id = $_POST["raum_id"];
$tag = $vonTag;
$monate = $vonMonat;
$jahr = $vonJahr;
$anzahlPersonen_default = 2;
$status = 2;

if (isset($_POST["mieter_id"])){
	$gast_id = $_POST["mieter_id"];
}else{
	$gast_id = $_POST["gast_id"];
}
if (isset($_POST["anrede"])){
	$anrede = $_POST["anrede"];
}else{
	$anrede = "";
}
if (isset($_POST["vorname"])){
	$vorname = $_POST["vorname"];
}else{
	$vorname = "";
}
if (isset($_POST["nachname"])){
	$nachname = $_POST["nachname"];
}else{
	$nachname = "";
}
if (isset($_POST["strasse"])){
	$strasse = $_POST["strasse"];
}else{
	$strasse = "";
}
if (isset($_POST["plz"])){
		$plz = $_POST["plz"];
}else{
	$plz = "";
}
if (isset($_POST["ort"])){
	$ort = $_POST["ort"];
}else{
	$ort = "";
}
if (isset($_POST["land"])){
	$land = $_POST["land"];
}else{
	$land = "";
}
if (isset($_POST["email"])){
	$email = $_POST["email"];
}else{
	$email = "";
}
if (isset($_POST["tel"])){
	$tel = $_POST["tel"];
}else{
	$tel = "";
}
if (isset($_POST["tel2"])){
	$tel2 = $_POST["tel2"];
}else{
	$tel2 = "";
}if (isset($_POST["fax"])){
	$fax = $_POST["fax"];
}else{
	$fax = "";
}if (isset($_POST["url"])){
	$url = $_POST["url"];
}else{
	$url = "";
}if (isset($_POST["speech"])){
	$speech = $_POST["speech"];
}else{
	$speech = "";
}
if (isset($_POST["firma"])){
	$firma = $_POST["firma"];
}else{
	$firma = "";
}
//pruefen ob daten vollstaendig eingegeben:
if (trim($nachname) == "" && $gast_id != ANONYMER_GAST_ID){
	$fehler = true;
	$nachricht = "Bitte geben sie den Nachnamen ein.";
}else{
	if($anzahlRes == "true"){	
		$fehler = true;
		$nachricht = "In diesem Zeitraum gibt es noch andere Reservierungen";
	} else {
		//anonymen gast eintragen:
		if ($gast_id == ANONYMER_GAST_ID){
			//do nothing
		}		
		//2. gast ist neu:
		else if ($gast_id == NEUER_MIETER) {		
			$gast_id = insertMieter($gastro_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$speech,'','');	
		}
		else{//3. gast ist bereits vorhanden und wurde geändert
			updateMieter($gast_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$speech);	
		}	
	
		if(isBlock($raum_id, $tisch_id, $vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr)){
			$fehler = true;
			$nachricht = "Wegen einer eingetragenen Blockierung wurde die Reservierung nicht erfolgreich eingetragen!";
		}else if(hasReservierung(0, $tisch_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr)){
			$fehler = true;
			$nachricht = "Zum gew�hlten Zeitraum ist andere Reservierung vorhanden!";
		}
		//reservierung eintragen:	
		$res = insertReservation1($tisch_id,$gast_id,$anzahlPersonen_default,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr,$status);
		if($res == "true"){
			$info = true; $fehler = false;
			$nachricht = getUebersetzung("Die Reservierung wurde erfolgreich ge&auml;ndert.");
		}else{	
			$fehler = true;
			$nachricht = getUebersetzung("Fehler beim &Auml;ndern der Reservierung.");
		 }
	} 
}
?>