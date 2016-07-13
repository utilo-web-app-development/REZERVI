<?php  
$root = "../.."; 
$ueberschrift = "Räume bearbeiten";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Räume", "raumBearbeiten/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
?>
<table>
	<?php if (getAnzahlVorhandeneRaeume($gastro_id) > 0){ ?>
	<tr height="30">
    	<td><a href="<?php echo$root ?>/backoffice/raumBearbeiten/raumAendern/index.php"><?php echo getUebersetzung("Räume ändern") ?></a></td>
    	<td> - </td>
    	<td><?php echo getUebersetzung("Anzeigen und Ändern von Räumen") ?>.</td>
	</tr>
	<tr height="30">
	    <td><a href="<?php echo$root ?>/backoffice/raumBearbeiten/raumLoeschen/index.php"><?php echo getUebersetzung("Räume löschen") ?></a></td>
    	<td> - </td>
	    <td><?php echo getUebersetzung("Löschen von vorhandenen Räumen") ?>.</td>
	</tr>
	<?php } ?>
	<tr height="30">
	    <td><a href="<?php echo$root ?>/backoffice/raumBearbeiten/raumAnlegen/index.php"><?php echo getUebersetzung("Raum anlegen") ?></a></td>
    	<td> - </td>
	    <td><?php echo getUebersetzung("Einen neuen Raum anlegen") ?>.</td>
	</tr>
</table>
<?php 
include_once($root."/backoffice/templates/footer.inc.php");
?>
