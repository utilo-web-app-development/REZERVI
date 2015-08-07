<? 
$root = "../../../..";
$ueberschrift = "Gäste bearbeiten";

/*   
	date: 14.10.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");

//wurde der nachname eingegeben?
if (!isset($_POST["nachname"]) || trim($_POST["nachname"]) == ""){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte geben sie den Nachnamen ein!");
	include_once("./index.php");
	exit;
}

$anrede = $_POST["anrede"];
$vorname = $_POST["vorname"];
$nachname = $_POST["nachname"];
$strasse = $_POST["strasse"];
$plz = $_POST["plz"];
$ort = $_POST["ort"];
$land = $_POST["country"];
$email = $_POST["email"];
$tel = $_POST["tel"];
$tel2 = $_POST["tel2"];
$fax = $_POST["fax"];
$speech = $_POST["speech"];
$url = $_POST["url"];
$mieter_id = $_POST["mieter_id"];
$index = $_POST["index"];
$firma = $_POST["firma"];
$bezeichnung = $_POST["bezeichnung"];
$beschreibung = $_POST["beschreibung"];
$bezeichnungAll = "";
foreach ($bezeichnung as $jede){
	$bezeichnungAll = $bezeichnungAll.$jede.",";
}

include_once($root."/include/mieterFunctions.inc.php");

if(!updateMieter($mieter_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$speech, $bezeichnungAll, $beschreibung)){
	$fehler = true;
	$nachricht = getUebersetzung("Die Änderung des Gastes ist gescheitert!");
	include_once("./index.php");
}else{
	$info = true;
	$nachricht = getUebersetzung("Die Daten des Gastes wurden erfolgreich geändert!");
	$_POST["root"] = $root;
	include_once($root."/backoffice/mieterBearbeiten/mieterListe/index.php");
}
