<?php
/**
 * @author coster
 * @date 3.9.2007
 * 
 * edit, delete the room <-> house merge
 */
session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
include_once($root . "/conf/rdbmsConfig.php");
include_once($root . "/include/uebersetzer.php");
include_once($root . "/include/zimmerFunctions.php");
include_once($root . "/include/unterkunftFunctions.php");
include_once($root . "/include/benutzerFunctions.php");
include_once($root . "/include/propertiesFunctions.php");
include_once($root . "/include/datumFunctions.php");

 
$zimmer = $_POST['zimmer'];
if (empty($zimmer)){
	$nachricht = "Bitte wählen Sie die Zimmer zum ausgewählten Haus.";
	$fehler = true;
}
else{
	
	//delete old merges first:
	deleteChildRooms($house);
	foreach($zimmer as $zi){

		setParentRoom($zi,$house);	
	
	}

}
header("Location: " . $URL . "webinterface/zimmerBearbeiten/mergeRooms/index.php"); /* Redirect browser */
exit();
 
?>