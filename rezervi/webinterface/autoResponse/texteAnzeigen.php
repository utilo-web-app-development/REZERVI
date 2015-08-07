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

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/gastFunctions.php");
include_once("../../include/autoResponseFunctions.php");
include_once("../../include/einstellungenFunctions.php");
include_once("../../include/propertiesFunctions.php");
include_once("../../include/uebersetzer.php");	
include_once("../templates/components.php"); 
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");

$standardsprache = getStandardSprache($unterkunft_id,$link);
	
//variablen initialisieren:	
$subject_de = "";
$anrede_de = "";
$text_de = "";
$unterschrift_de = "";
$subject_en = "";
$anrede_en = "";
$text_en = "";
$unterschrift_en = "";
$subject_fr = "";
$anrede_fr = "";
$text_fr = "";
$unterschrift_fr = "";
$subject_it = "";
$anrede_it = "";
$text_it = "";
$unterschrift_it = "";
$subject_nl = "";
$anrede_nl = "";
$text_nl = "";
$unterschrift_nl = "";
$subject_sp = "";
$anrede_sp ="";
$text_sp = "";
$unterschrift_sp = "";
$subject_es = "";
$anrede_es = "";
$text_es = "";
$unterschrift_es = "";
		
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php 
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
<?php 
	if (isset($_POST["bestaetigung"])){
		$art = "bestaetigung";
	?>
<p class="ueberschrift"><?php echo(getUebersetzung("Ändern der Buchungsbestätigung",$sprache,$link)); ?></p>
<?php
	}
	else if (isset($_POST["ablehnung"])){
		$art = "ablehnung";
	?>
<p class="ueberschrift"><?php echo(getUebersetzung("Ändern des Absagetextes einer Anfrage",$sprache,$link)); ?></p>
<?php
	}
	else if (isset($_POST["anfrage"])){
		$art = "anfrage";
	?>
<p class="ueberschrift"><?php echo(getUebersetzung("Ändern des Bestätigungstextes einer Buchungsanfrage",$sprache,$link)); ?></p>
<?php
	}
	else if (isset($_POST["emails"])){
		$art = "emails";
	?>
<p class="ueberschrift"><?php echo(getUebersetzung("Senden von E-Mails an Ihre Gäste",$sprache,$link)); ?></p>
<?php
	}
	if ($art != "emails"){
		
		if (!isset($fehler) || $fehler != true){
			
				$betreffStandard = getMessageSubject($unterkunft_id,$art,$link);
				$anredeStandard = getMessageAnrede($unterkunft_id,$art,$link);
				$textStandard = getMessageBody($unterkunft_id,$art,$link);
				$unterschriftStandard = getMessageUnterschrift($unterkunft_id,$art,$link);
			
			if (isGermanShown($unterkunft_id,$link)){
				$subject_de = getUebersetzungUnterkunft($betreffStandard,"de",$unterkunft_id,$link);
				$anrede_de = getUebersetzungUnterkunft($anredeStandard,"de",$unterkunft_id,$link);
				$text_de = getUebersetzungUnterkunft($textStandard,"de",$unterkunft_id,$link);
				$unterschrift_de = getUebersetzungUnterkunft($unterschriftStandard,"de",$unterkunft_id,$link);
			}
			if (isEnglishShown($unterkunft_id,$link)){
				$subject_en = getUebersetzungUnterkunft($betreffStandard,"en",$unterkunft_id,$link);
				$anrede_en = getUebersetzungUnterkunft($anredeStandard,"en",$unterkunft_id,$link);
				$text_en = getUebersetzungUnterkunft($textStandard,"en",$unterkunft_id,$link);
				$unterschrift_en = getUebersetzungUnterkunft($unterschriftStandard,"en",$unterkunft_id,$link);
			}
			if (isFrenchShown($unterkunft_id,$link)){
				$subject_fr = getUebersetzungUnterkunft($betreffStandard,"fr",$unterkunft_id,$link);
				$anrede_fr = getUebersetzungUnterkunft($anredeStandard,"fr",$unterkunft_id,$link);
				$text_fr = getUebersetzungUnterkunft($textStandard,"fr",$unterkunft_id,$link);
				$unterschrift_fr = getUebersetzungUnterkunft($unterschriftStandard,"fr",$unterkunft_id,$link);
			}
			if (isItalianShown($unterkunft_id,$link)){
				$subject_it = getUebersetzungUnterkunft($betreffStandard,"it",$unterkunft_id,$link);
				$anrede_it = getUebersetzungUnterkunft($anredeStandard,"it",$unterkunft_id,$link);
				$text_it = getUebersetzungUnterkunft($textStandard,"it",$unterkunft_id,$link);
				$unterschrift_it = getUebersetzungUnterkunft($unterschriftStandard,"it",$unterkunft_id,$link);
			}
			if (isNetherlandsShown($unterkunft_id,$link)){
				$subject_nl = getUebersetzungUnterkunft($betreffStandard,"nl",$unterkunft_id,$link);
				$anrede_nl = getUebersetzungUnterkunft($anredeStandard,"nl",$unterkunft_id,$link);
				$text_nl = getUebersetzungUnterkunft($textStandard,"nl",$unterkunft_id,$link);
				$unterschrift_nl = getUebersetzungUnterkunft($unterschriftStandard,"nl",$unterkunft_id,$link);
			}
			if (isEspaniaShown($unterkunft_id,$link)){
				$subject_sp = getUebersetzungUnterkunft($betreffStandard,"sp",$unterkunft_id,$link);
				$anrede_sp = getUebersetzungUnterkunft($anredeStandard,"sp",$unterkunft_id,$link);
				$text_sp = getUebersetzungUnterkunft($textStandard,"sp",$unterkunft_id,$link);
				$unterschrift_sp = getUebersetzungUnterkunft($unterschriftStandard,"sp",$unterkunft_id,$link);
			}
			if (isEstoniaShown($unterkunft_id,$link)){
				$subject_es = getUebersetzungUnterkunft($betreffStandard,"es",$unterkunft_id,$link);
				$anrede_es = getUebersetzungUnterkunft($anredeStandard,"es",$unterkunft_id,$link);
				$text_es = getUebersetzungUnterkunft($textStandard,"es",$unterkunft_id,$link);
				$unterschrift_es = getUebersetzungUnterkunft($unterschriftStandard,"es",$unterkunft_id,$link);
			}
		} //ende if kein fehler
	}
?>
<form action="./texteAendern.php" method="post" target="_self">
  <input name="art" type="hidden" value="<?php echo($art); ?>">
  <p class="standardSchrift">
  	<?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden",$sprache,$link)); ?>!
  </p>
  <?php
	if (isset($fehler) && $fehler == true){
   ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="belegt">
	  <tr>
		<td><?php echo($message); ?></td>
	  </tr>
	</table>
	<br />
   <?php
	}
   ?>
  <?php
  if (isGermanShown($unterkunft_id,$link)){
  ?>
  <p class="standardSchriftBold">
  	<?php echo(getUebersetzung("Texte in Deutsch",$sprache,$link)); 
  	if ($standardsprache != "de"){
  	?>
   (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.",$sprache,$link)); ?>):
   <?php
  	}
  	else {
  	  echo("*"); 
  	}
  	?>
  </p>
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr valign="top">
      <td><?php echo(getUebersetzung("Betreff",$sprache,$link)); ?></td>
      <td><input name="subject_de" type="text" id="subject_de" value="<?php echo($subject_de); ?>" size="100" maxlength="255"></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
      <td><input name="anrede_de" type="text"  id="anrede_de" value="<?php echo($anrede_de); ?>" size="100" maxlength="255">
        <br/>
        (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt",$sprache,$link)); ?>)</td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Text",$sprache,$link)); ?></td>
      <td><textarea name="text_de" cols="100" rows="5"  id="text_de"><?php echo($text_de); ?></textarea></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Unterschrift",$sprache,$link)); ?></td>
      <td><textarea name="unterschrift_de" cols="100" rows="5"  id="unterschrift_de"><?php echo($unterschrift_de); ?></textarea></td>
    </tr>
  </table>
  <?php 
  }
  if (isEnglishShown($unterkunft_id,$link)){
  ?>
  <p class="standardSchriftBold"><?php echo(getUebersetzung("Texte in Englisch",$sprache,$link)); 
  	if ($standardsprache != "en"){
  	?>
   (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.",$sprache,$link)); ?>):
   <?php
  	}
  	else {
  	  echo("*"); 
  	}
  	?>
  	</p>
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr valign="top">
      <td><?php echo(getUebersetzung("Betreff",$sprache,$link)); ?></td>
      <td><input name="subject_en" type="text"  id="subject_en" value="<?php echo($subject_en); ?>" size="100" maxlength="255"></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
      <td><input name="anrede_en" type="text"  id="anrede_en" value="<?php echo($anrede_en); ?>" size="100" maxlength="255">
    <br/>
        (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt",$sprache,$link)); ?>)</td>
  
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Text",$sprache,$link)); ?></td>
      <td><textarea name="text_en" cols="100" rows="5"  id="text_en"><?php echo($text_en); ?></textarea></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Unterschrift",$sprache,$link)); ?></td>
      <td><textarea name="unterschrift_en" cols="100" rows="5" " id="unterschrift_en"><?php echo($unterschrift_en); ?></textarea></td>
    </tr>
  </table>
  <?php
  }
  if (isFrenchShown($unterkunft_id,$link)){
  ?>
  <p class="standardSchriftBold"><?php echo(getUebersetzung("Texte in Französisch",$sprache,$link)); 
  	if ($standardsprache != "fr"){
  	?>
   (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.",$sprache,$link)); ?>):
   <?php
  	}
  	else {
  	  echo("*"); 
  	}
  	?></p>
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr valign="top">
      <td><?php echo(getUebersetzung("Betreff",$sprache,$link)); ?></td>
      <td><input name="subject_fr" type="text"  id="subject_fr" value="<?php echo($subject_fr); ?>" size="100" maxlength="255"></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
      <td><input name="anrede_fr" type="text"  id="anrede_fr" value="<?php echo($anrede_fr); ?>" size="100" maxlength="255">
    <br/>
        (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt",$sprache,$link)); ?>)</td>
  
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Text",$sprache,$link)); ?></td>
      <td><textarea name="text_fr" cols="100" rows="5"  id="text_fr"><?php echo($text_fr); ?></textarea></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Unterschrift",$sprache,$link)); ?></td>
      <td><textarea name="unterschrift_fr" cols="100" rows="5"  id="unterschrift_fr"><?php echo($unterschrift_fr); ?></textarea></td>
    </tr>
  </table>
  <?php
  }
  if (isItalianShown($unterkunft_id,$link)){
  ?>
  <p class="standardSchriftBold"><?php echo(getUebersetzung("Texte in Italienisch",$sprache,$link)); 
  	if ($standardsprache != "it"){
  	?>
   (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.",$sprache,$link)); ?>):
   <?php
  	}
  	else {
  	  echo("*"); 
  	}
  	?></p>
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr valign="top">
      <td><?php echo(getUebersetzung("Betreff",$sprache,$link)); ?></td>
      <td><input name="subject_it" type="text" " id="subject_it" value="<?php echo($subject_it); ?>" size="100" maxlength="255"></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
      <td><input name="anrede_it" type="text"  id="anrede_it" value="<?php echo($anrede_it); ?>" size="100" maxlength="255">
    <br/>
        (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt",$sprache,$link)); ?>)</td>
  
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Text",$sprache,$link)); ?></td>
      <td><textarea name="text_it" cols="100" rows="5"  id="text_it"><?php echo($text_it); ?></textarea></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Unterschrift",$sprache,$link)); ?></td>
      <td><textarea name="unterschrift_it" cols="100" rows="5" id="unterschrift_it"><?php echo($unterschrift_it); ?></textarea></td>
    </tr>
  </table>
  <?php
  }
  if (isNetherlandsShown($unterkunft_id,$link)){
  ?>
  <p class="standardSchriftBold"><?php echo(getUebersetzung("Texte in Holländisch",$sprache,$link)); 
  	if ($standardsprache != "nl"){
  	?>
   (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.",$sprache,$link)); ?>):
   <?php
  	}
  	else {
  	  echo("*"); 
  	}
  	?></p>
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr valign="top">
      <td><?php echo(getUebersetzung("Betreff",$sprache,$link)); ?></td>
      <td><input name="subject_nl" type="text" " id="subject_nl" value="<?php echo($subject_nl); ?>" size="100" maxlength="255"></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
      <td><input name="anrede_nl" type="text"  id="anrede_nl" value="<?php echo($anrede_nl); ?>" size="100" maxlength="255">
    <br/>
        (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt",$sprache,$link)); ?>)</td>
  
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Text",$sprache,$link)); ?></td>
      <td><textarea name="text_nl" cols="100" rows="5"  id="text_nl"><?php echo($text_nl); ?></textarea></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Unterschrift",$sprache,$link)); ?></td>
      <td><textarea name="unterschrift_nl" cols="100" rows="5" id="unterschrift_nl"><?php echo($unterschrift_nl); ?></textarea></td>
    </tr>
  </table>
  <?php
  }  
  if (isEspaniaShown($unterkunft_id,$link)){
  ?>
  <p class="standardSchriftBold"><?php echo(getUebersetzung("Texte in Spanisch",$sprache,$link)); 
  	if ($standardsprache != "sp"){
  	?>
   (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.",$sprache,$link)); ?>):
   <?php
  	}
  	else {
  	  echo("*"); 
  	}
  	?> </p>
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr valign="top">
      <td><?php echo(getUebersetzung("Betreff",$sprache,$link)); ?></td>
      <td><input name="subject_sp" type="text"  id="subject_sp" value="<?php echo($subject_sp); ?>" size="100" maxlength="255"></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
      <td><input name="anrede_sp" type="text"  id="anrede_sp" value="<?php echo($anrede_sp); ?>" size="100" maxlength="255">
    <br/>
        (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt",$sprache,$link)); ?>)</td>
  
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Text",$sprache,$link)); ?></td>
      <td><textarea name="text_sp" cols="100" rows="5"  id="text_sp"><?php echo($text_sp); ?></textarea></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Unterschrift",$sprache,$link)); ?></td>
      <td><textarea name="unterschrift_sp" cols="100" rows="5" " id="unterschrift_sp"><?php echo($unterschrift_sp); ?></textarea></td>
    </tr>
  </table>
  <?php
  }
  if (isEstoniaShown($unterkunft_id,$link)){
  ?>
  <p class="standardSchriftBold"><?php echo(getUebersetzung("Texte in Estnisch",$sprache,$link));
  	if ($standardsprache != "es"){
  	?>
   (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.",$sprache,$link)); ?>):
   <?php
  	}
  	else {
  	  echo("*"); 
  	}
  	?> </p>
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr valign="top">
      <td><?php echo(getUebersetzung("Betreff",$sprache,$link)); ?></td>
      <td><input name="subject_es" type="text"  id="subject_es" value="<?php echo($subject_es); ?>" size="100" maxlength="255"></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
      <td><input name="anrede_es" type="text"  id="anrede_es" value="<?php echo($anrede_es); ?>" size="100" maxlength="255">
    <br/>
        (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Gastes automatisch eingesetzt",$sprache,$link)); ?>)</td>
  
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Text",$sprache,$link)); ?></td>
      <td><textarea name="text_es" cols="100" rows="5"  id="text_es"><?php echo($text_es); ?></textarea></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Unterschrift",$sprache,$link)); ?></td>
      <td><textarea name="unterschrift_es" cols="100" rows="5"  id="unterschrift_es"><?php echo($unterschrift_es); ?></textarea></td>
    </tr>
  </table>
  <?php
  }  
  ?>
  
  <?php
	if ($art != "emails"){
  ?>
  <br/>
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr valign="top">
      <td><?php echo(getUebersetzung("Automatische Antwort aktiviert",$sprache,$link)); ?> </td>
      <td><p>
          <label>
          <input name="aktiviert" type="radio" value="1" <?php if (isMessageActive($unterkunft_id,$art,$link)) echo("checked"); ?>>
          <?php echo(getUebersetzung("ja",$sprache,$link)); ?></label>
          <br/>
          <label>
          <input type="radio" name="aktiviert" value="0" <?php if (!isMessageActive($unterkunft_id,$art,$link)) echo("checked"); ?>>
          <?php echo(getUebersetzung("nein",$sprache,$link)); ?></label>
        </p></td>
    </tr>
    <tr valign="top">
      <td>&nbsp;</td>
      <td><?php echo(getUebersetzung("Falls sie bei dieser Option nein gewählt haben, werden keine automatischen Antworten an Ihre Gäste gesendet.",$sprache,$link)); ?> 
	  <?php echo(getUebersetzung("Sie müssen sich in diesem Falle selbst mit Ihren Gästen in Verbindung setzen.",$sprache,$link)); ?></td>
    </tr>
  </table>
  <br/>
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr valign="top">
      <td><?php echo(getUebersetzung("Kopie an eigene E-Mailadresse senden",$sprache,$link)); ?> </td>
      <td>
      <?php 
		if ($art == "bestaetigung") {
		?>
      	<p>
          <label>
          <input name="ownMail" type="radio" value="true" <?php if (getPropertyValue(MAIL_KOPIE_AN_VERMIETER_BESTAETIGUNG,$unterkunft_id,$link) == "true") echo("checked=\"checked\""); ?>>
          <?php echo(getUebersetzung("ja",$sprache,$link)); ?></label>
          <br/>
          <label>
          <input type="radio" name="ownMail" value="false" <?php if (getPropertyValue(MAIL_KOPIE_AN_VERMIETER_BESTAETIGUNG,$unterkunft_id,$link) != "true") echo("checked=\"checked\""); ?>>
          <?php echo(getUebersetzung("nein",$sprache,$link)); ?></label>
        </p>
        <?php
		}
		else if($art == "ablehnung"){
		?>
      	<p>
          <label>
          <input name="ownMail" type="radio" value="true" <?php if (getPropertyValue(MAIL_KOPIE_AN_VERMIETER_ABLEHNUNG,$unterkunft_id,$link) == "true") echo("checked=\"checked\""); ?>>
          <?php echo(getUebersetzung("ja",$sprache,$link)); ?></label>
          <br/>
          <label>
          <input type="radio" name="ownMail" value="false" <?php if (getPropertyValue(MAIL_KOPIE_AN_VERMIETER_ABLEHNUNG,$unterkunft_id,$link) != "true") echo("checked=\"checked\""); ?>>
          <?php echo(getUebersetzung("nein",$sprache,$link)); ?></label>
        </p>
        <?php			
		}
		else if($art == "anfrage"){
		?>
      	<p>
          <label>
          <input name="ownMail" type="radio" value="true" <?php if (getPropertyValue(MAIL_KOPIE_AN_VERMIETER_ANFRAGE,$unterkunft_id,$link) == "true") echo("checked=\"checked\""); ?>>
          <?php echo(getUebersetzung("ja",$sprache,$link)); ?></label>
          <br/>
          <label>
          <input type="radio" name="ownMail" value="false" <?php if (getPropertyValue(MAIL_KOPIE_AN_VERMIETER_ANFRAGE,$unterkunft_id,$link) != "true") echo("checked=\"checked\""); ?>>
          <?php echo(getUebersetzung("nein",$sprache,$link)); ?></label>
        </p>
        <?php			
		}
		?>
        </td>
    </tr>
  </table>
  <br/>
  <?php 
	  //-----buttons um zurück zum menue zu gelangen:
  	  showSubmitButton(getUebersetzung("Texte ändern",$sprache,$link));
  ?>
  <?php
	}
	else{
		echo("<br/>");
		//gästeliste anzeigen zur auswahl:
		?>
  <table class="table" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td><?php echo(getUebersetzung("Bitte wählen Sie die Gäste aus, an denen das E-Mail gesendet werden soll.",$sprache,$link)); ?><br/>
          <?php echo(getUebersetzung("Wenn Sie mehrere auswählen wollen müssen Sie die [Strg] Taste gedrückt halten.",$sprache,$link)); ?></td>
    </tr>
    <tr>
      <td><select name="gaeste[]" size="10" multiple>
          <?php
		//alle gäste der unterkunft auslesen:
		$res = getGuestList($unterkunft_id,$link);
		while ($d = mysql_fetch_array($res)){
			$gast_id = $d["PK_ID"];
			$vorname = $d["Vorname"];
			$nachname = $d["Nachname"];
			$ort = $d["Ort"];
			$land = $d["Land"];
			$gast=$nachname." ".$vorname.", ".$ort.", ".$land;
		?>
          <option value="<?php echo($gast_id); ?>"><?php echo($gast); ?></option>
          <?php
		} //ende schleife.
		?>
        </select></td>
    </tr>
  </table>
  <?php
		echo("<br/>");
	  	showSubmitButton(getUebersetzung("E-Mails senden",$sprache,$link));
	}
?>
</form>
<?php 
	  showSubmitButtonWithForm("./index.php",getUebersetzung("zurück",$sprache,$link));
?>
<br/>
<?php 
	  showSubmitButtonWithForm("../inhalt.php",getUebersetzung("Hauptmenü",$sprache,$link));
?>
<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>
<?php include_once("../templates/end.php"); ?>
