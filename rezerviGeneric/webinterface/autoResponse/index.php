<? $root = "../..";

/*   
	date: 7.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php");
include_once("../../include/autoResponseFunctions.inc.php");

?>
<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Automatische Antworten bearbeiten, E-Mails an Ihre Gäste senden")); ?></p>
<table  border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td><?php echo(getUebersetzung("Ändern Sie hier die automatischen E-Mail Antworten oder benutzen Sie das Mail-Formular zum Senden von Newslettern.")); ?>
	<?php echo(getUebersetzung("Bitte achten Sie darauf, dass die automatischen E-Mail Antworten nur ausgeführt werden wenn Sie aktiviert wurden.")); ?>
  </tr>
</table>
<br/>
<form action="./texteAnzeigen.php" method="post" target="_self">
<table  border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td>
		<input name="<?= BUCHUNGS_BESTAETIGUNG ?>" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?= BUTTON ?>';" id="bestaetigung" value="<?php echo(getUebersetzung("Buchungsbestätigung")); ?>">
   </td>
    <td><?php echo(getUebersetzung("Ändern der E-Mail-Buchungsbestätigung wenn Sie die Reservierung akzeptieren")); ?>.</td>
  </tr>
  <tr>
    <td>
		<input name="<?= BUCHUNGS_ABLEHNUNG ?>" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?= BUTTON ?>';" id="ablehnung" value="<?php echo(getUebersetzung("Buchungs-Absage")); ?>">
    </td>
    <td><?php echo(getUebersetzung("Ändern des Absagetextes einer Anfrage wenn Sie die Reservierung ablehnen")); ?>.</td>
  </tr>
    <tr>
    <td>
		<input name="<?= ANFRAGE_BESTAETIGUNG ?>" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?= BUTTON ?>';" id="anfrage" value="<?php echo(getUebersetzung("Buchungs-Anfrage")); ?>">
    </td>
    <td><?php echo(getUebersetzung("Ändern des Bestätigungstextes einer Buchungsanfrage wenn eine Buchungsanfrage gestellt wird")); ?>.</td>
  </tr>
    <tr>
      <td><input name="<?= NEWSLETTER ?>" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?= BUTTON ?>';" id="emails" value="<?php echo(getUebersetzung("E-Mails senden")); ?>">
      </td>
      <td><?php echo(getUebersetzung("Newsletter senden")); ?>.</td>
    </tr>
</table>
</form>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>