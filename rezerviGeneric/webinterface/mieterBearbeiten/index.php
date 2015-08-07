<? $root = "../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/webinterface/templates/components.inc.php");
include_once($root."/include/mieterFunctions.inc.php");

?>
<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Mieter bearbeiten")); ?></p>
<table  border="0" cellpadding="0" cellspacing="3" class="<?= TABLE ?>">
  <form action="./mieterAnlegen/index.php" method="post" target="_self">
  <tr>
    <td><?php showSubmitButton(getUebersetzung("Mieter anlegen")); ?></td>
    <td><?php echo(getUebersetzung("Einen neuen Mieter in der Datenbank speichern")); ?>.</td>
  </tr>
  </form>
  <?php if (getAnzahlMieter($vermieter_id) > 0){ ?>
	  <form action="./mieterListe/index.php" method="post" target="_self">
		  <tr>
		    <td><?php showSubmitButton(getUebersetzung("Mieter Liste anzeigen")); ?></td>
		    <td><?php echo(getUebersetzung("Anzeigen und Ändern von Mietern")); ?>.</td>
		  </tr>
	  </form>
  <?php } ?>
 </table>
<?php 
include_once($root."/webinterface/templates/footer.inc.php");
?>