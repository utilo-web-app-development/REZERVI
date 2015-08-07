<?php
/**
	@author coster
	@date 31.07.2007
	change the pictures for the free or occupied views
*/

session_start();
$root = "../..";
$ueberschrift = "Design";

include_once($root."/include/rdbmsConfig.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/sessionFunctions.inc.php");
include_once($root."/include/uebersetzer.inc.php");

$sprache = getSessionWert(SPRACHE);
$gastro_id = getSessionWert(GASTRO_ID);

if ( !(isset($_POST["breite"]) && isset($_POST["hoehe"])) ){
	$fehler = true;
	$nachricht = "Die maximale Höhe und maximale Breite der Bilder muss angegeben werden.";
	$nachricht = getUebersetzung($nachricht);
	include_once($root."/backoffice/designBearbeiten/freiBelegtTisch.php");
	exit;
}

include_once($root."/include/bildFunctions.inc.php");
//bild bearbeiten:
require_once($root."/include/imageResize/hft_image.php");

$hoehe = $_POST["hoehe"];
$breite= $_POST["breite"];
//speichere hoehe und breite
setGastroProperty(MAX_BILDBREITE_BELEGT_FREI,$breite,$gastro_id);
setGastroProperty(MAX_BILDHOEHE_BELEGT_FREI,$hoehe,$gastro_id);

$freiFile =  $_FILES['frei']['tmp_name'];
$belegtFile =$_FILES['belegt']['tmp_name'];

if (!empty($freiFile)){

	$mimeType = $_FILES['frei']['type'];
	$fileExtension = getFileExtension($mimeType);
	
	if (!($fileExtension == ".png" || $fileExtension == ".gif" || $fileExtension == ".jpg")){
		$nachricht = "Sie können nur .png, .gif oder .jpg hochladen. Sie versuchten ".$fileExtension." hochzuladen.";
		$nachricht = getUebersetzung($nachricht);
		$fehler = true;
		include_once("./freiBelegtTisch.php");
		exit;
	}
	/*
	$img = new hft_image($freiFile);
	$origWidth = $img->image_original_width;
	$origHeight = $img->image_original_height;
	
	if ($origWidth < $breite){
		$breite = $origWidth;
	}
	if ($origHeight < $hoehe){
		$hoehe = $origHeight;
	}
	
	//keep X to Y ratio
	//so there will be no geometrical distortions:
	$img->resize($breite,$hoehe,"-"); 		
	//save the resized image to file
	//commented to save server load
	$img->output_resized($freiFile);
	*/
	//file-upload war erfolgreich:
	$pfad = $freiFile;
	
	//altes bild loeschen
	deleteBild(getBildWithMarker(SYMBOL_TABLE_FREE));
	//neues bild speichern:
	$bild_id = setBild($pfad,"Symbol frei",
				  $breite,$hoehe,
				  $fileExtension,SYMBOL_TABLE_FREE);							  

}
if (!empty($belegtFile)){

	$mimeType = $_FILES['belegt']['type'];
	$fileExtension = getFileExtension($mimeType);
	
	if (!($fileExtension == ".png" || $fileExtension == ".gif" || $fileExtension == ".jpg")){
		$nachricht = "Sie können nur .png, .gif oder .jpg hochladen. Sie versuchten ".$fileExtension." hochzuladen.";
		$nachricht = getUebersetzung($nachricht);
		$fehler = true;
		include_once("./freiBelegtTisch.php");
		exit;
	}
	
	/*
	$img = new hft_image($belegtFile);
	$origWidth = $img->image_original_width;
	$origHeight = $img->image_original_height;
	
	if ($origWidth < $breite){
		$breite = $origWidth;
	}
	if ($origHeight < $hoehe){
		$hoehe = $origHeight;
	}
	
	//keep X to Y ratio
	//so there will be no geometrical distortions:
	$img->resize($breite,$hoehe,"-"); 		
	//save the resized image to file
	//commented to save server load
	$img->output_resized($belegtFile);
	//file-upload war erfolgreich:
	*/
	$pfad = $belegtFile;
	
	//altes bild loeschen
	deleteBild(getBildWithMarker(SYMBOL_TABLE_OCCUPIED));
	//neues bild speichern:
	$bild_id = setBild($pfad,"Symbol belegt",
				  $breite,$hoehe,
				  $fileExtension,SYMBOL_TABLE_OCCUPIED);			  

}

$nachricht = "Die Änderungen wurden erfolgreich durchgeführt";
$info = true;
include_once("./freiBelegtTisch.php");
exit;

?>