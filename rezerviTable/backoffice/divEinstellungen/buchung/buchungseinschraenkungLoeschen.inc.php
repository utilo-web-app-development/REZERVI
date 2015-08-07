<?php

$root = "../../..";
$ueberschrift = "Diverse Einstellungen";

/*
 * Created on 24.04.2006
 *
 * @author coster
 */
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/buchungseinschraenkung.inc.php");

 if (isset($_POST["einschraenkungs_id"]) && !empty($_POST["einschraenkungs_id"])){
	 $einschraenkungs_id = $_POST["einschraenkungs_id"];
	 $alle = $_POST["alle"];
	 if (!empty($alle) && $alle == "true"){
	 	//delete all einschraenkungen of type:
	 	$typ = $_POST["typ"];
	 	deleteSameBuchungseinschraenkungen($einschraenkungs_id);
	 } 
	 else{
	 	deleteBuchungseinschraenkung($einschraenkungs_id);
	 }
 }
 if (isset($_POST["mietobjekt_id"]) && !empty($_POST["mietobjekt_id"])){
	 $mietobjekt_id = $_POST["mietobjekt_id"];
	 $typ = BE_TYP_TAG;
	 if ($mietobjekt_id == "alle"){
	 	//delete all einschraenkungen of type:
	 	deleteBuchungseinschraenkungenOfTyp($typ);
	 } 
	 else {
	 
	 deleteBuchungseinschraenkungenOfTisch($mietobjekt_id,$typ);
	 }
 }

 $nachricht = "Die Buchungseinschränkung wurde entfernt";
 $nachricht = getUebersetzung($nachricht);
 $erfolg = true;
 $info = true;
 
 include_once($root."/backoffice/divEinstellungen/buchung/index.php");
 
?>
