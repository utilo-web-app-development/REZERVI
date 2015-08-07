<? 
$root = "../..";
$ueberschrift = "Diverse Einstellungen";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, $ueberschrift, "divEinstellungen/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php");

?>
<table>
  <tr height="30">
    <td><a href="<?=$root ?>/backoffice/divEinstellungen/sprachen/sprachen.php"><?= getUebersetzung("Sprachen") ?></a></td>
    	<td> - </td>
    <td><?= getUebersetzung("Ändern der zur Auswahl stehenden Sprachen ihres Belegungsplanes") ?>.</td>
  </tr>
  <?php if (MIETE == false){ ?>
		  <tr height="30">
		    <td><a href="<?=$root ?>/backoffice/divEinstellungen/uebersetzungen/index.php"><?= getUebersetzung("Übersetzungen") ?></a></td>
    	<td> - </td>
		    <td><?= getUebersetzung("Ändern der verwendeten Übersetzungen") ?>.</td>
		  </tr>
  <?php } ?>
	  <tr height="30">
	    <td><a href="<?=$root ?>/backoffice/divEinstellungen/bilder/index.php"><?= getUebersetzung("Bilder") ?></a></td>
    	<td> - </td>
	    <td><?= getUebersetzung("Einstellungen für Bilder der Räume") ?>.</td>
	  </tr>
    <!-- 
    <form action="./suche/index.php" method="post" target="_self">
	  <tr>
	    <td><?php showSubmitButton(getUebersetzung("Suche")); ?></td>
    	<td> - </td>
	    <td><?= getUebersetzung("Einstellungen zur Suche nach freien Tischen") ?>.</td>
	  </tr>
    </form>
     -->
	  <tr height="30">
	    <td><a href="<?=$root ?>/backoffice/divEinstellungen/links/index.php"><?= getUebersetzung("Links") ?></a></td>
    	<td> - </td>
	    <td><?= getUebersetzung("Anzeigen aller Links zu ihren Räumen") ?>.</td>
	  </tr>
	  <tr height="30">
	    <td><a href="<?=$root ?>/backoffice/divEinstellungen/buchung/index.php"><?= getUebersetzung("Reservierungen") ?></a></td>
    	<td> - </td>
	    <td><?= getUebersetzung("Reservierungen nur zu bestimmten Zeiten erlauben, Dauer einer Reservierung festlegen") ?>.</td>
	  </tr>
	  <tr height="30">
	    <td><a href="<?=$root ?>/backoffice/divEinstellungen/register/index.php"><?= getUebersetzung("Registerierung") ?></a></td>
    	<td> - </td>
	    <td><?= getUebersetzung("Registrieren Sie Bookline um den vollen Funktionsumfang nutzen zu können") ?>.</td>
	  </tr>
</table>
<?php 
include_once($root."/backoffice/templates/footer.inc.php");
?>