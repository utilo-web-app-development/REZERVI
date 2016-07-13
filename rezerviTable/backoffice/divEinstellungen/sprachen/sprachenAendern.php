<?php 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";
$unterschrift = "Sprachen";
$unterschrift1 = "Ändern";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");

$standardsprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
if ($standardsprache == false || $standardsprache == ""){
	$standardsprache = "en";
}
			
include_once($root."/backoffice/templates/components.inc.php"); 		

$res = getSprachen();
$zaehle = 0; //zur kontrolle ob ueberhaupt eine sprache ausgewaehlt wurde
$standard = $_POST["standard"];
//zuerst alte sprachen rauslöschen, dann neu setzen:
deleteAllActivtedSprachenOfVermieter($gastro_id);

while($d = $res->FetchNextObject()){
	$bezeichnung = $d->BEZEICHNUNG;
	$spracheID   = $d->SPRACHE_ID;       

	//variablen initialisieren:
	$cur_sprache_id = false;
	if (isset($_POST[$spracheID])){
		$cur_sprache_id	= $_POST[$spracheID];
	}	

	if (($standard == $spracheID && $cur_sprache_id == false)){
		$nachricht = "Die Standardsprache muss auch ausgewählt werden!";
		$nachricht = getUebersetzung($nachricht);
		$fehler = true;
		include_once("./sprachen.php");
		exit;
	}
	
	if ($cur_sprache_id != false){
		setActivtedSpracheOfVermieter($gastro_id,$cur_sprache_id);
	}
	
	$zaehle++;

}

//kontrolle ob Überhaupt eine sprache ausgewählt wurde:
if ($zaehle <= 0){
	$nachricht = "Sie müssen mindestens eine Sprache auswählen!";
	$nachricht = getUebersetzung($nachricht);
	$fehler = true;
	include_once("./sprachen.php");
	exit;
}

setGastroProperty(STANDARDSPRACHE,$standard,$gastro_id);	
$info = true;
$nachricht = "Die angezeigten Sprachen wurden erfolgreich geändert!";
include_once('./sprachen.php');  
?>