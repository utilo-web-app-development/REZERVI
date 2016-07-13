<?php 
$root = "../..";
$ueberschrift = "Anfragen bearbeiten";

/*   
	date: 7.10.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/components.inc.php"); 
include_once($root."/include/mail.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
$an = $_POST["an"];
$von = $_POST["von"];
$subject = $_POST["subject"];
$message = $_POST["message"];
$mieter_id = $_POST["mieter_id"];
$mieter_deleted = $_POST["mieter_deleted"];

sendMail($von,$an,$subject,$message); 

 //save mail in mieter Texte if the guest exists:
 $text = "Automatisch generierte Bestätigung zu einer Anfrage.\n";
 $text .="Betreff: ".$subject."\n";
 $text .="Nachricht: ".$message;
 if ($mieter_deleted != "true"){
 	insertMieterText($text,$mieter_id);  
 }
$info = true;
$nachricht = getUebersetzung("Der Gast wurde per E-Mail verständigt");
include_once("./index.php");

?>