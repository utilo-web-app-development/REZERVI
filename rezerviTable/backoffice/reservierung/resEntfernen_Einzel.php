<?php 
$root = "../..";
$ueberschrift = "Reservierungen bearbeiten";

/*
 * Created on 24.09.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria
 * Löschen der Reservierung und zurückkehren
 *  
 */
		  
include_once($root."/backoffice/templates/functions.php");
include_once($root."/include/reservierungFunctions.inc.php");

$reservierung_id = $_POST["reservierung_id"];
deleteReservation($reservierung_id);

include_once("./index.php");
?>

