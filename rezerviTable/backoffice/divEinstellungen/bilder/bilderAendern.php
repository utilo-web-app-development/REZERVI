<?php 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/filesAndFolders.inc.php");

//variablen initialisieren:
if (isset($_POST["suchergebnisseActive"])){
	$suchergebnisseActive = $_POST["suchergebnisseActive"];
}
else{
	$suchergebnisseActive = false;
}
if (isset($_POST["belegungsplanActive"])){
	$belegungsplanActive  = $_POST["belegungsplanActive"];
}
else{
	$belegungsplanActive = false;
}
$width = $_POST["width"];
$height  = $_POST["height"];

	//falls das upload-verzeichnis noch nicht vorhanden ist, muss es erzeugt werden:
	$path = $root."/upload";
	if (!hasDirectory($path)){
		if (!phpMkDir($path)){
			//file erzeugen war nicht erfolgreich
				$nachricht = "Das Upload Verzeichnis für die Bilder konnte nicht erstellt werden.";
				$nachricht = getUebersetzung($nachricht);
				$fehler = true;
				include_once($root."/backoffice/divEinstellungen/bilder/index.php");
				exit;
		}
	}	

//sicherstellen, dass es sich um integer handelt:
$width = 1 + $width - 1;
$height = 1 + $height - 1;

if ($width == "" || $height == "" || $height <=0 || $width <= 0){
	
	$nachricht = "Die Bildgrössen wurden nicht korrekt eingegeben.";
	$nachricht = getUebersetzung($nachricht);
	$fehler = true;
	include_once("./index.php");
	exit;
}	

include_once($root."/include/vermieterFunctions.inc.php");	
include_once($root."/backoffice/templates/components.inc.php"); 

if (isset($suchergebnisseActive) && $suchergebnisseActive == true){	
	setGastroProperty(SUCHERGEBNISSE_BILDER_ACTIV,"true",$gastro_id);
}else{
	setGastroProperty(SUCHERGEBNISSE_BILDER_ACTIV,"false",$gastro_id);
}

if (isset($belegungsplanActive) && $belegungsplanActive == true){	
	setGastroProperty(BELEGUNGSPLAN_BILDER_ACTIV,"true",$gastro_id);
}else{
	setGastroProperty(BELEGUNGSPLAN_BILDER_ACTIV,"false",$gastro_id);
}
setGastroProperty(MAX_BILDBREITE_RAUM,$width,$gastro_id);
setGastroProperty(MAX_BILDHOEHE_RAUM,$height,$gastro_id);

$nachricht = getUebersetzung("Die Einstellungen der Bilder wurden erfolgreich geändert.");
$info = true;
include_once($root."/backoffice/divEinstellungen/bilder/index.php");
?>