<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			eine angefragte reservierung bestätigen - als belegt im plan eintragen
			author: christian osterrieder utilo.eu						
			
			dieser seite muss übergeben werden:
			Benutzer PK_ID $benutzer_id
			Reservierung PK_ID $reservierungs_id
			Unterkunft PK_ID $unterkunft_id
*/
//funktionen zum versenden von e-mails:
include_once($root."/include/mail.inc.php");
//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$an = $_POST["an"];
$von = $_POST["von"];
$subject = $_POST["subject"];
$message = $_POST["message"];
$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/propertiesFunctions.php");	
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php //passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
<table border="0" cellpadding="0" cellspacing="3">
  <tr>
    <td><p class="frei"><?php
	
	  echo(getUebersetzung("Der Gast wurde per E-Mail verständigt",$sprache,$link)); ?>.</p><?php
	  
	  //mail($an, unhtmlentities($subject), unhtmlentities($message), "From: $von\nReply-To: $von\nX-Mailer: PHP/" . phpversion());
  	  sendMail($von,$an,$subject,$message);	
  		if (getPropertyValue(MAIL_KOPIE_AN_VERMIETER_BESTAETIGUNG,$unterkunft_id,$link) == "true"){
			$message = getUebersetzung("Folgende Nachricht wurde an ihren Gast versendet",$sprache,$link).":\n\n".$message;
			//mail($von, unhtmlentities($subject), unhtmlentities($message), "From: $von\nReply-To: $von\nX-Mailer: PHP/" . phpversion());
			sendMail($von,$von,$subject,$message);	
		}
	  //-----buttons um zurück zum menue zu gelangen: 
      include_once("../templates/components.php"); 

		?>
      <br/>
      <?php 
	 	 showSubmitButtonWithForm("./index.php",getUebersetzung("zurück",$sprache,$link));
		?>
      <br/>
      <?php 
	  	showSubmitButtonWithForm("../inhalt.php",getUebersetzung("Hauptmenü",$sprache,$link));
		?>
    </td>
  </tr>
</table>
<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
?>
</body>
</html>
