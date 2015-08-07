<? 
$root = "../../..";
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
	$nachricht = getUebersetzung("Bitte geben sie den Nachnamen ein!".$_POST["nachname"]);
	include_once("./index.php");
	exit;
}

include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/backoffice/templates/components.inc.php"); 

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
$url = $_POST["url"];
$speech = $_POST["speech"];
$firma  = $_POST["firma"];
$bezeichnung = $_POST["bezeichnung"];
$beschreibung = $_POST["beschreibung"];
$bezeichnungAll = "";
foreach ($bezeichnung as $jede){
	$bezeichnungAll = $bezeichnungAll.$jede.",";
}
$mieter_id = insertMieter($gastro_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$speech, $beschreibung, $bezeichnungAll);	
$info = true;
$nachricht = getUebersetzung("Der Gast ").$vorname." ".$nachname.getUebersetzung(" wurde erfolgreich angelegt");
include_once("./index.php");
?>
