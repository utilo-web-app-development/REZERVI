<?php  
$root = "../../.."; 
$ueberschrift = "Benutzerdaten bearbeiten";
$unterschrift = "Anlegen";

/*
 * Created on 05.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria  
 */

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Benutzerdaten", "benutzerBearbeiten/index.php",
								$unterschrift, "benutzerBearbeiten/benutzerAnlegen/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once("./benutzerAnlegen.php"); 
include_once($root."/backoffice/templates/footer.inc.php");
?>