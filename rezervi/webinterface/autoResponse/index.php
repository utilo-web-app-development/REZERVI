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
<p class="standardSchriftBold"><?php echo(getUebersetzung("Automatische Antworten bearbeiten, E-Mails an Ihre G�ste senden",$sprache,$link)); ?></p>
<table  border="0" cellpadding="0" cellspacing="3" class="table">
  <tr>
    <td><?php echo(getUebersetzung("�ndern Sie hier die automatischen E-Mail Antworten an Ihre G�ste oder benutzen Sie das Mail-Formular zum senden von E-Mails an Ihre G�ste.",$sprache,$link)); ?>
	<?php echo(getUebersetzung("Bitte achten Sie darauf, dass die automatischen E-Mail Antworten nur ausgef�hrt werden wenn Sie aktiviert wurden.",$sprache,$link)); ?>
	<?php echo(getUebersetzung("Eine nicht-aktivierte E-Mail Antwort wird nicht an Ihren Gast gesendet - Sie m�ssen die Anfragen h�ndisch beantworten!",$sprache,$link)); ?></td>
  </tr>
</table>
<br/>
<form action="./texteAnzeigen.php" method="post" target="_self">
<table  border="0" cellpadding="0" cellspacing="3" class="table">
  <tr>
    <td>
		<input name="bestaetigung" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" id="bestaetigung" value="<?php echo(getUebersetzung("Buchungsbest�tigung",$sprache,$link)); ?>">
   </td>
    <td><?php echo(getUebersetzung("�ndern der E-Mail-Buchungsbest�tigung die ein Gast erh�lt wenn Sie die Reservierung akzeptieren",$sprache,$link)); ?>.</td>
  </tr>
  <tr>
    <td>
		<input name="ablehnung" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" id="ablehnung" value="<?php echo(getUebersetzung("Buchungs-Absage",$sprache,$link)); ?>">
    </td>
    <td><?php echo(getUebersetzung("�ndern des Absagetextes einer Anfrage die ein Gast erh�lt wenn Sie die Reservierung ablehnen",$sprache,$link)); ?>.</td>
  </tr>
    <tr>
    <td>
		<input name="anfrage" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" id="anfrage" value="<?php echo(getUebersetzung("Buchungs-Anfrage",$sprache,$link)); ?>">
    </td>
    <td><?php echo(getUebersetzung("�ndern des Best�tigungstextes einer Buchungsanfrage die ein Gast erh�lt wenn er eine Buchungsanfrage im Belegungsplan vornimmt",$sprache,$link)); ?>.</td>
  </tr>
    <tr>
      <td><input name="emails" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" id="emails" value="<?php echo(getUebersetzung("E-Mails senden",$sprache,$link)); ?>">
      </td>
      <td><?php echo(getUebersetzung("E-Mails an ihre G�ste senden",$sprache,$link)); ?>.</td>
    </tr>
</table>
</form>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
      include_once("../templates/components.php"); 
	  showSubmitButtonWithForm("../inhalt.php",getUebersetzung("Hauptmen�",$sprache,$link));
?>
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../templates/end.php"); ?>