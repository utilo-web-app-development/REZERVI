<?php 

$root = "../../..";
$ueberschrift = "Diverse Einstellungen";
$unterschrift = "Sprachen";
$unterschrift1 = "Löschen";

/*
 * Created on 17.10.2007
 * Autor: LI Haitao
 * Company: Alpstein-Austria
 * Entfernung der Sprachen
 */ 


$sessId = session_id();
if (empty($sessId)){
	session_start();
}
include_once($root."/include/sessionFunctions.inc.php");
include_once($root."/include/rdbmsConfig.inc.php");
include_once($root."/include/cssFunctions.inc.php");
include_once($root."/include/uebersetzer.inc.php");

$sprache = getSessionWert(SPRACHE);
$gastro_id = getSessionWert(GASTRO_ID);

$status = BELEGT;
if(isset($_GET["status"])){
	$status = $_GET["status"];
}
if($status == "false"){
	$status = BELEGT;
	$fehler = true;
	$nachricht = "Löschen wird abgebrochen"; 
}else{
	$sprachen = getSprachen();
	while($cur_sprache = $sprachen->FetchNextObject()){
		$bezeichnung = $cur_sprache->BEZEICHNUNG;
		$spracheID   = $cur_sprache->SPRACHE_ID;
		if (isset($_POST[$spracheID])){
			$cur_sprache_id	= $_POST[$spracheID]; 
			deleteSprache($cur_sprache_id);
			$nachricht = "Die Sprachen wurden erfolgreich gelöscht";
			$status = FREI;
			$info = true;
		}
	}
	if($status == BELEGT){
		$nachricht = "Keine Sprache wurde erfolgreich gelöscht";
		$fehler = true;
	}
}
include_once('./sprachen.php');
exit;  
?>
