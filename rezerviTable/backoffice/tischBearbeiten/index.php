<?php 
$root = "../..";
$ueberschrift = "Tisch bearbeiten";

/*   
	date: 26.9.05
	author: christian osterrieder utilo				
*/	 

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Tisch", "tischBearbeiten/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 

include_once($root."/include/mietobjektFunctions.inc.php");
?>
<table>
	<?php if (getAnzahlVorhandeneTische($gastro_id) > 0) { ?>
	<tr height="30">
    	<td><a href="<?php echo$root ?>/backoffice/tischBearbeiten/tischAendern/index.php"><?php echo getUebersetzung("Tisch ändern") ?></a></td>
    	<td> - </td>
    	<td><?php echo getUebersetzung("Anzeigen und Ändern von Tischen") ?>.</td>
	</tr>
	<tr height="30">
	    <td><a href="<?php echo$root ?>/backoffice/tischBearbeiten/tischLoeschen/index.php"><?php echo getUebersetzung("Tisch löschen") ?></a></td>
    	<td> - </td>
	    <td><?php echo getUebersetzung("Löschen vorhandener Tische") ?>.</td>
	</tr>
	<tr height="30">
	    <td><a href="<?php echo$root ?>/backoffice/tischBearbeiten/tischPositionieren/index.php"><?php echo getUebersetzung("Tisch positionieren") ?></a></td>
    	<td> - </td>
	    <td><?php echo getUebersetzung("Tische im Raum positionieren") ?>.</td>
	</tr>		
	<?php } ?>
	<tr height="30">
	    <td><a href="<?php echo$root ?>/backoffice/tischBearbeiten/tischAnlegen/index.php"><?php echo getUebersetzung("Tisch anlegen") ?></a></td>
    	<td> - </td>
	    <td><?php echo getUebersetzung("Einen neuen Tisch anlegen") ?>.</td>
	</tr>
</table>
<?php 

include_once($root."/backoffice/templates/footer.inc.php");
?>
