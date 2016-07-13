<?php
/*
 * Created on 24.04.2006
 *
 * @author coster
 */
 $root = "../../..";

include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/buchungseinschraenkung.inc.php");

 if (isset($_POST["einschraenkungs_id"]) && !empty($_POST["einschraenkungs_id"])){
	 $einschraenkungs_id = $_POST["einschraenkungs_id"]; 
	 deleteBuchungseinschraenkung($einschraenkungs_id);
 }
 if (isset($_POST["mietobjekt_id"]) && !empty($_POST["mietobjekt_id"])){
	 $mietobjekt_id = $_POST["mietobjekt_id"]; 
	 $typ = BE_TYP_TAG;
	 deleteBuchungseinschraenkungenOfMietobjekt($mietobjekt_id,$typ);
 }

 $nachricht = "Die Buchungseinschränkung wurde entfernt";
 $nachricht = getUebersetzung($nachricht);
 $erfolg = true;
 
 include_once($root."/webinterface/divEinstellungen/buchung/index.php");
 
?>
