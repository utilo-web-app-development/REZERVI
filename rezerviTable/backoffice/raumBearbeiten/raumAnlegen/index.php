<?  
$root = "../../.."; 
$ueberschrift = "Raum bearbeiten";
$unterschrift = "Anlegen";

/*
 * Created on 05.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria  
 */

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Raum", "raumBearbeiten/index.php",
								$unterschrift, "raumBearbeiten/raumAnlegen/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 

//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/bildFunctions.inc.php");
include_once("./raumAnlegen.php");
include_once($root."/backoffice/templates/footer.inc.php");
?>
