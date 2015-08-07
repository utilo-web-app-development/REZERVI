<?  
$root = "../../.."; 
$ueberschrift = "Raum bearbeiten";

/*   
	date: 23.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");

//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/bildFunctions.inc.php");
//bild bearbeiten:
require_once($root."/include/imageResize/hft_image.php");
	
$standardsprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
if ($standardsprache == false || $standardsprache == ""){
	$standardsprache = "en";
}
	
$bild = $_FILES['bild']['tmp_name'];
if (empty($bild)){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte wählen sie ein Bild für den Raum!");
	include_once("./index.php");	
	exit;
}

$mimeType = $_FILES['bild']['type'];
$fileExtension = getFileExtension($mimeType);

if (!($fileExtension == ".png" || $fileExtension == ".gif" || $fileExtension == ".jpg")){
	$nachricht = "Sie können nur .png, .gif oder .jpg hochladen.".$fileExtension;
	$nachricht = getUebersetzung($nachricht);
	$fehler = true;
	include_once("./index.php");
	exit;
}

//uebersetzungen in array sammeln:
$uebers_bez = array();
$uebers_bes = array();
$defaultBezeichnung = false;
$defaultBeschreibung = false;
$res = getActivtedSprachenOfVermieter($gastro_id);
while ($d = $res->FetchNextObject()){
   	$sprache_id = $d->SPRACHE_ID;	
	$bezeichnung = false;
	if (isset($_POST["bezeichnung_".$sprache_id])){
		$bezeichnung = $_POST["bezeichnung_".$sprache_id];
	}
	$beschreibung = false;
	if (isset($_POST["beschreibung_".$sprache_id])){
		$beschreibung =  $_POST["beschreibung_".$sprache_id];
	}
	if (($standardsprache == $sprache_id) && ($bezeichnung == "" || $bezeichnung == false)){
		$fehler = true;
		$nachricht = getUebersetzung("Bitte geben sie die Bezeichnung ihrer Standardsprache ein!");
		$nachricht .= " (".getUebersetzung(getBezeichnungOfSpracheID($sprache_id)).")";
		include_once("./index.php");	
		exit;		
	}			
	if ($standardsprache == $sprache_id){
		$defaultBezeichnung = $bezeichnung;
		if(isRaumVorhanden($defaultBezeichnung, $gastro_id)){
			$fehler = true;
			$nachricht = getUebersetzung("Die Raum-Bezeichnung ist schon vorhanden!");
			include_once("./index.php");	
			exit;		
		}
	}	
	if ($standardsprache ==  $sprache_id){
		$defaultBeschreibung = $beschreibung;
	}		
	//assoziatives array aufbauen mit sprache als schluessel
	if ($beschreibung != false){
		$uebers_bes[$sprache_id]=$beschreibung;
	}
	if ($bezeichnung != false){
		$uebers_bez[$sprache_id]=$bezeichnung;
	}		
}
    
	//uebersetzungen durchfuehren:
	foreach ($uebers_bez as $sprache_id => $bezeichnung){
		setUebersetzungVermieter($bezeichnung,$defaultBezeichnung,$sprache_id);
	}
	foreach ($uebers_bes as $sprache_id => $beschreibung){
		setUebersetzungVermieter($beschreibung,$defaultBeschreibung,$sprache_id);
	}
	
	//bild bearbeiten und hochladen:
	$bild = $_FILES['bild']['tmp_name'];	
		
	//bild in groesse anpassen und speichern:	
	$maxBreite  = getGastroProperty(MAX_BILDBREITE_RAUM,$gastro_id);
	$maxHoehe   = getGastroProperty(MAX_BILDHOEHE_RAUM,$gastro_id);
	//create the image from JPEG file
	$img = new hft_image($_FILES['bild']['tmp_name']);
	$origWidth = $img->image_original_width;
	$origHeight = $img->image_original_height;
	
	if ($origWidth < $maxBreite){
		$maxBreite = $origWidth;
	}
	if ($origHeight < $maxHoehe){
		$maxHoehe = $origHeight;
	}
	
	//keep X to Y ratio
	//so there will be no geometrical distortions:
	$img->resize($maxBreite,$maxHoehe,"-"); 		
	//save the resized image to file
	//commented to save server load
	$img->output_resized($_FILES['bild']['tmp_name']);
	//file-upload war erfolgreich:
	$pfad = $_FILES['bild']['tmp_name'];

	//mietobjekt speichern:
	$bild_id = setBild($pfad,"Raumbild Raum".$defaultBezeichnung,
				  $img->image_resized_width,$img->image_resized_height,
				  $fileExtension);	
	$raum_id = setRaum($gastro_id,$defaultBezeichnung,$defaultBeschreibung,$bild_id);					  
	$anzahlVorhandenerMietobjekte = getAnzahlVorhandeneRaeume($gastro_id);

$info = true;
$nachricht = "Der Raum wurde erfolgreich hinzugefügt.";

include_once("./index.php");
?>
