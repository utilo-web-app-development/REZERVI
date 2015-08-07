<?php 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";
/*
 * Created on 17.10.2007
 * Autor: LI Haitao
 * Company: Alpstein-Austria
 * Entfernung einer Sprach
 *  
 */

include_once($root."/include/rdbmsConfig.inc.php");
require_once($root."/include/imageResize/hft_image.php");
include_once($root."/include/bildFunctions.inc.php");
include_once($root."/include/uebersetzer.inc.php");
include_once($root."/include/sessionFunctions.inc.php");
include_once($root."/include/cssFunctions.inc.php");
session_start();
$sprache = getSessionWert(SPRACHE);
$gastro_id = getSessionWert(GASTRO_ID);
if ($_POST["spracheID"]==null||$_POST["bezeichnung"]==null || $_FILES['bild']['tmp_name']==null){
	$fehler = true;
	$nachricht = "Sprache ID, Bezeichnung und Fahne müssen vollständig gegeben werden.";
	include_once("./spracheHinfuegen.php");
	exit;
}
$spracheID = $_POST["spracheID"];
$bezeichnung = $_POST["bezeichnung"];
if (isset($_FILES['bild']['tmp_name'])){
	$bild = $_FILES['bild']['tmp_name'];
	$mimeType = $_FILES['bild']['type'];
	$fileExtension = getFileExtension($mimeType);	
	if (!($fileExtension == ".png" || $fileExtension == ".jpg")){
		$fehler = true;
		$nachricht = "Sie können nur .png oder .jpg hochladen. Sie versuchten ".$fileExtension." hochzuladen.";
		include_once("./spracheHinfuegen.php");
		exit;
	}
	//bild in groesse anpassen und speichern:	
	$maxBreite  = 25;
	$maxHoehe   = 16;
	
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
	$bild_id = setBild($pfad,'Fahne Thumbnail zu Sprache '.$bezeichnung,
			  $img->image_resized_width,$img->image_resized_height,
			  $fileExtension);
	setSprache($spracheID,$bild_id,$bezeichnung);
	
	$nachricht = "Die Sprache ".$bezeichnung." wurde erfolgreich gespeichert";
	$info = true;
	include_once('./sprachen.php');
	exit;  
}	
?>
