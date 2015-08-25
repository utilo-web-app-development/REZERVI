<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung des designs
			author: christian osterrieder utilo.eu						
*/

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

//datenbank �ffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");	
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php 
	//passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("Automatische Antworten bearbeiten, E-Mails an Ihre Gäste senden",$sprache,$link)); ?></p>
<table  border="0" cellpadding="0" cellspacing="3" class="table">
  <tr>
    <td><?php echo(getUebersetzung("ändern Sie hier die automatischen E-Mail Antworten an Ihre Gäste oder benutzen Sie das Mail-Formular zum senden von E-Mails an Ihre Gäste.",$sprache,$link)); ?>
	<?php echo(getUebersetzung("Bitte achten Sie darauf, dass die automatischen E-Mail Antworten nur ausgeführt werden wenn Sie aktiviert wurden.",$sprache,$link)); ?>
	<?php echo(getUebersetzung("Eine nicht-aktivierte E-Mail Antwort wird nicht an Ihren Gast gesendet - Sie müssen die Anfragen händisch beantworten!",$sprache,$link)); ?></td>
  </tr>
</table>
<br/>
<form action="./texteAnzeigen.php" method="post" target="_self">
<table  border="0" cellpadding="0" cellspacing="3" class="table">
  <tr>
    <td>
		<input name="bestaetigung" type="submit" class="btn btn-primary" id="bestaetigung" value="<?php echo(getUebersetzung("Buchungsbestätigung",$sprache,$link)); ?>">
   </td>
    <td><?php echo(getUebersetzung("ändern der E-Mail-Buchungsbestätigung die ein Gast erhält wenn Sie die Reservierung akzeptieren",$sprache,$link)); ?>.</td>
  </tr>
  <tr>
    <td>
		<input name="ablehnung" type="submit" class="btn btn-primary" id="ablehnung" value="<?php echo(getUebersetzung("Buchungs-Absage",$sprache,$link)); ?>">
    </td>
    <td><?php echo(getUebersetzung("ändern des Absagetextes einer Anfrage die ein Gast erhält wenn Sie die Reservierung ablehnen",$sprache,$link)); ?>.</td>
  </tr>
    <tr>
    <td>
		<input name="anfrage" type="submit" class="btn btn-primary" id="anfrage" value="<?php echo(getUebersetzung("Buchungs-Anfrage",$sprache,$link)); ?>">
    </td>
    <td><?php echo(getUebersetzung("ändern des Bestätigungstextes einer Buchungsanfrage die ein Gast erhält wenn er eine Buchungsanfrage im Belegungsplan vornimmt",$sprache,$link)); ?>.</td>
  </tr>
    <tr>
      <td><input name="emails" type="submit" class="btn btn-primary" id="emails" value="<?php echo(getUebersetzung("E-Mails senden",$sprache,$link)); ?>">
      </td>
      <td><?php echo(getUebersetzung("E-Mails an ihre Gäste senden",$sprache,$link)); ?>.</td>
    </tr>
</table>
</form>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
      include_once("../templates/components.php"); 
	  showSubmitButtonWithForm("../inhalt.php",getUebersetzung("Hauptmenü",$sprache,$link));
?>
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../templates/end.php"); ?>