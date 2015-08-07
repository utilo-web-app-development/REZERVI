<? 
$root = "../..";
$ueberschrift = "Gäste bearbeiten";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Gäste", "mieterBearbeiten/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php");
include_once($root."/include/mieterFunctions.inc.php");

?>
<table>
	<tr height="30">
    	<td><a href="<?=$root ?>/backoffice/mieterBearbeiten/mieterAnlegen/index.php"><?= getUebersetzung("Gast anlegen") ?></a></td>
    	<td> - </td>
    	<td><?= getUebersetzung("Einen neuen Gast in der Datenbank speichern") ?>.</td>
	</tr>
	<tr height="30">
	    <td><a href="<?=$root ?>/backoffice/mieterBearbeiten/mieterListe/index.php"><?= getUebersetzung("Gästeliste anzeigen") ?></a></td>
    	<td> - </td>
	    <td><?= getUebersetzung("Anzeigen und Ändern von Gästen") ?>.</td>
	</tr>
</table>

<?php 
include_once($root."/backoffice/templates/footer.inc.php");
?>