<?php  
$root = "../.."; 
$ueberschrift = "Benutzerdaten bearbeiten";

/*   
	date: 22.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Benutzerdaten", "benutzerBearbeiten/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 

?>
<table>
	<tr height="30">
    	<td><a href="<?php echo$root ?>/backoffice/benutzerBearbeiten/benutzerAendern/index.php"><?php echo getUebersetzung("Benutzer ändern") ?></a></td>
    	<td> - </td>
    	<td><?php echo getUebersetzung("Anzeigen und Ändern von Benutzer") ?>.</td>
	</tr>
	<tr height="30">
	    <td><a href="<?php echo$root ?>/backoffice/benutzerBearbeiten/benutzerLoeschen/index.php"><?php echo getUebersetzung("Benutzer löschen") ?></a></td>
    	<td> - </td>
	    <td><?php echo getUebersetzung("Löschen von den vorhanden Benutzer") ?>.</td>
	</tr>
	<tr height="30">
	    <td><a href="<?php echo$root ?>/backoffice/benutzerBearbeiten/benutzerAnlegen_2/index.php"><?php echo getUebersetzung("Benutzer anlegen") ?></a></td>
    	<td> - </td>
	    <td><?php echo getUebersetzung("Einen neuen Benutzer in der Datenbank speichern") ?>.</td>
	</tr>
</table>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>
