<?php $root = "..";
/*
 * Created on 22.10.2007
 * Autor: LI Haitao
 * Company: Alpstein-Austria
 * Hauptseite von Backoffice
 *  
 */
 
 $id = session_id();
if (empty($id)){
	session_start();
}


//datenbank oeffnen:
include_once ($root."/conf/conf.inc.php");
include_once ($root."/include/rdbmsConfig.inc.php");
//andere funktionen einbeziehen:
include_once ($root."/include/benutzerFunctions.inc.php");
include_once ($root."/include/vermieterFunctions.inc.php");
include_once ($root."/include/mietobjektFunctions.inc.php");
include_once ($root."/include/uebersetzer.inc.php");
include_once ($root."/include/sessionFunctions.inc.php");
include_once ($root."/include/cssFunctions.inc.php");

//alte sessions loeschen:
destroyInactiveSessions();

$angemeldet = getSessionWert(ANGEMELDET);

//sprache auslesen:
//entweder aus uebergebener url oder aus session
if (isset ($_POST["sprache"]) && $_POST["sprache"] != "") {
	$sprache = $_POST["sprache"];
	setSessionWert(SPRACHE, $sprache);
} else {
	$sprache = getSessionWert(SPRACHE);	
}
if (empty($sprache)){
	$sprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
	setSessionWert(SPRACHE,$sprache);	
}

if (isset($_POST["ben"])) {

	//variablen initialisieren:
	$ben = $_POST["ben"];
	$pass = $_POST["pass"];

	$benutzer_id = checkPassword($ben, $pass);	

	if ($benutzer_id == -1) {
		//passwortpruefung fehlgeschlagen, auf index-seite zurueck:
		$fehlgeschlagen = true;
		include_once ("./index.php");
		exit; //nachfolgenden code nicht mehr ausfuehren
	} else {
		//passwortpruefung erfolgreich:
		setSessionWert(ANGEMELDET, "true");

		//vermieter-id holen:
		$gastro_id = getVermieterID($benutzer_id);
		setSessionWert(GASTRO_ID, $gastro_id);
		setSessionWert(BENUTZER_ID, $benutzer_id);
	}
}

//benutzerrechte auslesen:
$benutzerrechte = getUserRights($benutzer_id);
$anzahlVorhandenerMietobjekte = getAnzahlVorhandeneRaeume($gastro_id);
Header("Location:   ./reservierung/index.php");
exit;
?>
