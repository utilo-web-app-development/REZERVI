<?php
/**
 * Created on 31.08.2006
 *
 * @author coster
 * @date 31.10.06
 * 
 * edit, delete the attributeHinzufuegen form
 */
 
 session_start();
 $root = "../..";
 // Set flag that this is a parent file
define( '_JEXEC', 1 );
 include_once($root."/conf/rdbmsConfig.php");
include_once("../../include/benutzerFunctions.php");
 include_once($root."/include/uebersetzer.php");
 include_once($root."/include/zimmerAttributes.inc.php");
 include_once($root."/include/uebersetzer.php");
 include_once($root."/include/sessionFunctions.inc.php");
 include_once($root."/include/propertiesFunctions.php");
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

$fehler = false;
 $nachricht = "";
 $sprache = getSessionWert(SPRACHE);
 $unterkunft_id = getSessionWert(UNTERKUNFT_ID);

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
 
 //1. wurde der hinzufuegen butten geklickt?
 if (isset($_POST["hinzufuegen"])){
 	
 	if (!isset($_POST["bezeichnung_neu"]) || empty($_POST["bezeichnung_neu"])){
 		$fehler = true;
 		$nachricht = "Die Bezeichnung muss eingegeben werden.";
 		$nachricht = getUebersetzung($nachricht,$sprache,$link);
 		include_once("./attributeHinzufuegen.php");
 		exit;
 	}
 	
 	$bezeichnung =  $_POST["bezeichnung_neu"];
 	$beschreibung = $_POST["beschreibung_neu"];
 	
 	setAttribute($bezeichnung,$beschreibung);
 	
 	$nachricht = "Das Attribut wurde erfolgreich hinzugefügt.";
 	$nachricht = getUebersetzung($nachricht,$sprache,$link);
 	include_once("./attributeHinzufuegen.php");
 	exit;
 }

 //2. wurde löschen geklickt?
 $res = getAttributes();
 while ($d = mysqli_fetch_array($res)){
	$att_id 	= $d["PK_ID"];
	if (isset($_POST["loeschen_".$att_id])){
		deleteAttribut($att_id);
 		$nachricht = "Das Attribut wurde erfolgreich entfernt.";
 		$nachricht = getUebersetzung($nachricht,$sprache,$link);		
		include_once("./attributeHinzufuegen.php");
 		exit;
	}
 }
 
 //3. aendern der attribute:
 if (isset($_POST["aendern"])){
 	
 	 $res = getAttributes();
	 while ($d = mysqli_fetch_array($res)){
		$att_id 	= $d["PK_ID"];
		$bezeichnung = "";
		$beschreibung = "";
		if (isset($_POST["bezeichnung_".$att_id])){
			$bezeichnung = $_POST["bezeichnung_".$att_id];
		}
		if (isset($_POST["beschreibung_".$att_id])){
			$beschreibung = $_POST["beschreibung_".$att_id];
		}
		if(!empty($bezeichnung)){
			changeAttribut($att_id,$bezeichnung,$beschreibung);
		}
		else{
			$nachricht = "Die Bezeichnung muss eingegeben werden.";
			$nachricht = getUebersetzung($nachricht,$sprache,$link);
			$fehler = true;
		}
	 }
	 
 	$bezeichnung = "";
	$beschreibung = "";
	if (isset($_POST["bezeichnung_neu"])){
		$bezeichnung = $_POST["bezeichnung_neu"];
	}
	if (isset($_POST["beschreibung_neu"])){
		$beschreibung = $_POST["beschreibung_neu"];
	}
	if (!empty($bezeichnung)){
		setAttribute($bezeichnung,$beschreibung);
	}
	
	//in der gesamtübersicht anzeigen?
	$showInGesamtuebersicht = "false";
	if (isset($_POST["showInGesamtuebersicht"]) && $_POST["showInGesamtuebersicht"] == "true"){
		$showInGesamtuebersicht = "true";
	}
	setProperty(SHOW_ZIMMER_ATTRIBUTE_GESAMTUEBERSICHT,$showInGesamtuebersicht,$unterkunft_id,$link);
	 
	if ($fehler != true){
		$nachricht = "Die Attribute wurden erfolgreich gespeichert.";
		$nachricht = getUebersetzung($nachricht,$sprache,$link);
	}		
	include_once("./attributeHinzufuegen.php");
	exit;
	
 }

?>
