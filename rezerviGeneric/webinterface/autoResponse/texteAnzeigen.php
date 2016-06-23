<? $root = "../..";

/*   
	date: 7.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php");
	
include_once("../../include/mieterFunctions.inc.php");
include_once("../../include/autoResponseFunctions.inc.php");
include_once("../templates/components.inc.php"); 

$standardsprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
			
	if (isset($_POST[BUCHUNGS_BESTAETIGUNG])){
		$art = BUCHUNGS_BESTAETIGUNG;
	?>
		<p class="<?= UEBERSCHRIFT ?>"><?php echo(getUebersetzung("Ändern der Buchungsbestätigung")); ?></p>
	<?php
	}
	else if (isset($_POST[BUCHUNGS_ABLEHNUNG])){
		$art = BUCHUNGS_ABLEHNUNG;
	?>
		<p class="<?= UEBERSCHRIFT ?>"><?php echo(getUebersetzung("Ändern des Absagetextes einer Anfrage")); ?></p>
	<?php
	}
	else if (isset($_POST[ANFRAGE_BESTAETIGUNG])){
		$art = ANFRAGE_BESTAETIGUNG;
	?>
		<p class="<?= UEBERSCHRIFT ?>"><?php echo(getUebersetzung("Ändern des Bestätigungstextes einer Buchungsanfrage")); ?></p>
	<?php
	}
	else if (isset($_POST[NEWSLETTER])){
		$art = NEWSLETTER;
	?>
		<p class="<?= UEBERSCHRIFT ?>"><?php echo(getUebersetzung("Senden von E-Mails an Ihre Mieter")); ?></p>
	<?php
	}
	if ($art != NEWSLETTER){		
			
			$betreffStandard = getMessageSubject($vermieter_id,$art);
			$anredeStandard = getMessageAnrede($vermieter_id,$art);
			$textStandard = getMessageBody($vermieter_id,$art);
			$unterschriftStandard = getMessageUnterschrift($vermieter_id,$art);		
	}
	else{
		
			$betreffStandard = "";
			$anredeStandard = "";
			$textStandard = "";
			$unterschriftStandard = "";	
			
	}	
	
?>
<form action="./texteAendern.php" method="post" target="_self">
  <input name="art" type="hidden" value="<?php echo($art); ?>">
  <p class="<?= STANDARD_SCHRIFT ?>">
  	<?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden")); ?>!
  </p>
    <?php

    $res = getActivtedSprachenOfVermieter($vermieter_id);
    while ($d = mysql_fetch_array($res)){
    	$sprache_id = $d["SPRACHE_ID"];
    	$bezeichnung= $d["BEZEICHNUNG"];
		$subject = 			getUebersetzungVermieter($betreffStandard,$sprache_id,$vermieter_id);
		$anrede = 			getUebersetzungVermieter($anredeStandard,$sprache_id,$vermieter_id);
		$text = 			getUebersetzungVermieter($textStandard,$sprache_id,$vermieter_id);
		$unterschrift = 	getUebersetzungVermieter($unterschriftStandard,$sprache_id,$vermieter_id);
		if (isset($fehler) && $fehler === true){
			$subject = $_POST["subject_".$sprache_id];
			$anrede = $_POST["anrede_".$sprache_id];
			$text = $_POST["text_".$sprache_id];
			$unterschrift = $_POST["unterschrift_".$sprache_id];
		}
    ?>
  <p class="<?= STANDARD_SCHRIFT_BOLD ?>">
  	<?php echo(getUebersetzung("Texte in")." ".$bezeichnung); 
  	if ($standardsprache != $sprache_id){
  	?>
  	<br/>
   (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.")); ?>):
   <?php
  	}
  	?>
  </p>
  <table  border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
    <tr valign="top">
      <td><?php echo(getUebersetzung("Betreff")); ?></td>
      <td><input name="subject_<?= $sprache_id ?>" type="text"  value="<?php echo($subject); ?>" size="50" maxlength="255">
      <?php  	
      	if  ($standardsprache == $sprache_id){
	  	  echo("*"); 
	  	}
	  ?>
  	</td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Anrede")); ?></td>
      <td><input name="anrede_<?= $sprache_id ?>" type="text"  value="<?php echo($anrede); ?>" size="50" maxlength="255">      <?php  	
      	if  ($standardsprache == $sprache_id){
	  	  echo("*"); 
	  	}
	  ?>
        <br/>
        (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Mieters automatisch eingesetzt")); ?>)</td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Text")); ?></td>
      <td><textarea name="text_<?= $sprache_id ?>" cols="50" rows="5"  ><?php echo($text); ?></textarea>      <?php  	
      	if  ($standardsprache == $sprache_id){
	  	  echo("*"); 
	  	}
	  ?></td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Unterschrift")); ?></td>
      <td><textarea name="unterschrift_<?= $sprache_id ?>" cols="50" rows="5" ><?php echo($unterschrift); ?></textarea>
      <?php  	
      	if  ($standardsprache == $sprache_id){
	  	  echo("*"); 
	  	}
	  ?></td>
    </tr>
  </table>  
  <?php
   }
  if ($art != NEWSLETTER){ 
  ?>
  <br/>
  <table  border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
    <tr valign="top">
      <td><?php echo(getUebersetzung("Automatische Antwort aktiviert")); ?> </td>
      <td><p>
          <label>
          <input name="aktiviert" type="radio" value="1" <?php if (isMessageActive($vermieter_id,$art) == true) echo("checked=\"checked\""); ?>>
          <?php echo(getUebersetzung("ja")); ?></label>
          <br/>
          <label>
          <input type="radio" name="aktiviert" value="0" <?php if (isMessageActive($vermieter_id,$art) != true) echo("checked=\"checked\""); ?>>
          <?php echo(getUebersetzung("nein")); ?></label>
        </p></td>
    </tr>
    <tr valign="top">
      <td>&nbsp;</td>
      <td><?php echo(getUebersetzung("Falls sie bei dieser Option nein gewählt haben, werden keine automatischen Antworten gesendet.")); ?> 
    </tr>
  </table>
  <br/>
  <?php 
	  //-----buttons um zurück zum menue zu gelangen:
  	  showSubmitButton(getUebersetzung("Texte ändern"));
  }
  if ($art == NEWSLETTER){
  ?>
  <br/>
  <table class="<?= TABLE_STANDARD ?>" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td><?php echo(getUebersetzung("Bitte wählen Sie die Mieter aus, an denen das E-Mail gesendet werden soll.")); ?><br/>
          <?php echo(getUebersetzung("Wenn Sie mehrere auswählen wollen müssen Sie die [Strg] Taste gedrückt halten.")); ?></td>
    </tr>
    <tr>
      <td><select name="mieter[]" size="10" multiple>
          <?php
		//alle gäste der unterkunft auslesen:
		$res = getAllMieterFromVermieter($vermieter_id);
		while ($d = mysql_fetch_array($res)){
			$mieter_id = $d["MIETER_ID"];
			$vorname = $d["VORNAME"];
			$nachname = $d["NACHNAME"];
			$ort = $d["ORT"];
			$land = $d["LAND"];
			$gast=$nachname." ".$vorname.", ".$ort.", ".$land;
		?>
          <option value="<?php echo($mieter_id); ?>" selected="selected"><?php echo($gast); ?></option>
          <?php
		} //ende schleife.
		?>
        </select></td>
    </tr>
    <tr>
      <td></td>
    </tr>    
  </table>
	<?php
		echo("<br/>");
	  	showSubmitButton(getUebersetzung("E-Mails senden"));
	  	echo("<br/>");
	}
?>
</form>
<br/>
<?php 
	  showSubmitButtonWithForm("./index.php",getUebersetzung("zurück"));
	  
include_once($root."/webinterface/templates/footer.inc.php");
?>
