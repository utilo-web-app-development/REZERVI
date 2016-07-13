<?php session_start();
$root = "..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
//datenbank öffnen:
include_once("../conf/rdbmsConfig.php");

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);

//alle werte für unterkunft auslesen:

$query = "select * from Rezervi_CSS where FK_Unterkunft_ID = '$unterkunft_id'";

  $res = mysql_query($query, $link);
  if (!$res)
  	echo("Anfrage $query scheitert.");
	
$d = mysql_fetch_array($res);

 echo(".backgroundColor { ").($d["backgroundColor"]).(" }");
 echo(".standardSchrift { ").($d["standardSchrift"]).(" }"); 
 echo(".frei { ").($d["frei"]).(" }"); 
 echo(".samstagFrei { ").($d["samstagFrei"]).(" }"); 
 echo(".reserviert { ").($d["reserviert"]).(" }"); 
 echo(".samstagReserviert { ").($d["samstagReserviert"]).(" }"); 
 echo(".belegt { ").($d["belegt"]).(" }");
 echo(".samstagBelegt { ").($d["samstagBelegt"]).(" }");
 echo(".standardSchriftBold { ").($d["standardSchriftBold"]).(" }"); 
 echo(".ueberschrift { ").($d["ueberschrift"]).(" }"); 
 echo(".table { ").($d["tableStandard"]).(" }"); 
 echo(".tableColor { ").($d["tableColor"]).(" }"); 
 echo(".button200pxB { ").($d["button200pxB"]).(" }"); 
 echo(".button200pxA { ").($d["button200pxA"]).(" }"); 

?>

