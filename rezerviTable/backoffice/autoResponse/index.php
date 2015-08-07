<? 
$root = "../..";
$ueberschrift = "Automatische e-Mails";

/*   
	date: 7.10.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, $ueberschrift, "autoResponse/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php");
include_once($root."/include/autoResponseFunctions.inc.php");

?>
<h2><?php echo(getUebersetzung("Automatische Antworten bearbeiten, E-Mails an Ihre Gäste senden")); ?></h2>
<table>
  <tr>
    <td><?php echo(getUebersetzung("Ändern Sie hier die automatischen E-Mail Antworten oder benutzen Sie das Mail-Formular zum Senden von Newslettern.")); ?>
	<?php echo(getUebersetzung("Bitte achten Sie darauf, dass die automatischen E-Mail Antworten nur ausgeführt werden wenn Sie aktiviert wurden.")); ?>
  </tr>
</table>
<br/>
<form action="./texteAnzeigen.php" method="post" target="_self">
<table>
  <tr height="30">
    <td><a href="<?=$root ?>/backoffice/autoResponse/texteAnzeigen.php?<?=BUCHUNGS_BESTAETIGUNG?>=true"><?php echo(getUebersetzung("Reservierungsbestätigung")); ?></a> </td>
    	<td> - </td>
    <td><?php echo(getUebersetzung("Ändern der E-Mail-Reservierungsbestätigung wenn Sie die Reservierung akzeptieren")); ?>.</td>
  </tr>
  <tr height="30">
    <td><a href="<?=$root ?>/backoffice/autoResponse/texteAnzeigen.php?<?=BUCHUNGS_ABLEHNUNG?>=true"><?php echo(getUebersetzung("Reservierungs-Absage")); ?></a> </td>
    	<td> - </td>
    <td><?php echo(getUebersetzung("Ändern des Absagetextes einer Anfrage wenn Sie die Reservierung ablehnen")); ?>.</td>
  </tr>
    <tr height="30">
    <td><a href="<?=$root ?>/backoffice/autoResponse/texteAnzeigen.php?<?=ANFRAGE_BESTAETIGUNG?>=true"><?php echo(getUebersetzung("Buchungs-Anfrage")); ?></a></td>
    	<td> - </td>
    <td><?php echo(getUebersetzung("Ändern des Bestätigungstextes einer Reservierungssanfrage wenn eine Anfrage gestellt wird")); ?>.</td>
  </tr>
    <tr height="30">
      <td><a href="<?=$root ?>/backoffice/autoResponse/texteAnzeigen.php?<?=NEWSLETTER?>=true"><?php echo(getUebersetzung("E-Mails senden")); ?></a></td>
    	<td> - </td>
      <td><?php echo(getUebersetzung("Newsletter an ihre Gäste senden")); ?>.</td>
    </tr>
</table>
</form>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>