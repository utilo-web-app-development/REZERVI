<? 
$root = "../..";
$ueberschrift = "Stammdaten bearbeiten";

/*   
	date: 20.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");

//andere funktionen importieren:
include_once($root."/include/vermieterFunctions.inc.php");

//sprachunabhängige variablen:
$strasse = $_POST["strasse"];
$plz = $_POST["plz"];
$ort = $_POST["ort"];
$email = $_POST["email"];
$tel = $_POST["tel"];
$tel2 = $_POST["tel2"];
$fax = $_POST["fax"];
$url = $_POST["url"];
$land = $_POST["land"];
$vorname =  $_POST["vorname"];
$nachname=  $_POST["nachname"];

$standardsprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
$fehler = false;

//pruefen ob alle pflichtfelder eingegeben wurden:
if($email == ""){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte geben sie ihre E-Mail-Adresse ein!");
	include_once("./index.php");	
	exit;
}

$ueb_fir = array();
$ueb_mo_ez = array();
$ueb_mo_mz = array();

$res = getActivtedSprachenOfVermieter($gastro_id);
while ($d = $res->FetchNextObject()){
	$sprache_id = $d->SPRACHE_ID;	
	$firma = false;
	
	if (isset($_POST["firma_".$sprache_id])){
		$firma = $_POST["firma_".$sprache_id];
	}

	if ($standardsprache == $sprache_id){
		
		if ($firma == false || $firma == ""){
			$fehler = true;
			$nachricht = getUebersetzung("Bitte geben sie ihren Firmennamen ein!");
			include_once("./index.php");	
			exit;
		}
		
		$defaultFirma = $firma;
		
	} //ende if standardsprache
	
	$ueb_fir[$sprache_id] 	= $firma;
	  
}	
	
	//unterkunft änderung durchf�hren:	
	setVermieterStrasse($gastro_id,$strasse);
	setVermieterPlz($gastro_id,$plz);
	setVermieterOrt($gastro_id,$ort);	
	setVermieterEmail($gastro_id,$email);
	setVermieterTel($gastro_id,$tel);
	setVermieterTel2($gastro_id,$tel2);
	setVermieterVorname($gastro_id,$vorname);
	setVermieterNachname($gastro_id,$nachname);
	setVermieterUrl($gastro_id,$url);
	setVermieterFax($gastro_id,$fax);	
	setVermieterFirmenname($gastro_id,$defaultFirma);
	setVermieterLand($gastro_id,$land);
	
	//uebersetzungen durchfuehren:
	foreach ($ueb_fir as $sprache_id => $firma){
		setUebersetzungVermieter($firma,$defaultFirma,$sprache_id);
	}		
	
	$nachricht = "Ihre Daten wurden erfolgreich verändert.";
	$info = true;

include_once($root."/backoffice/vermieter/index.php");
?>