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
include_once($root."/include/autoResponseFunctions.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/sessionFunctions.inc.php");
 
$art = BUCHUNGS_BESTAETIGUNG;
$typ = "";
$standardsprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
$unterschrift = "Ändern der Reservierungsbestätigung";
if (isset($_GET["art"])){
	$typ = $_GET["art"];
}
if (isset($_POST[BUCHUNGS_BESTAETIGUNG]) || isset($_GET[BUCHUNGS_BESTAETIGUNG])|| $typ == BUCHUNGS_BESTAETIGUNG){
	$art = BUCHUNGS_BESTAETIGUNG;
	$unterschrift = "Ändern der Reservierungsbestätigung";
	$breadcrumps = erzeugenBC($root, $ueberschrift, "autoResponse/index.php",
							$unterschrift, "autoResponse/texteAnzeigen.php?".BUCHUNGS_BESTAETIGUNG."=true");							
}
else if (isset($_POST[BUCHUNGS_ABLEHNUNG]) || isset($_GET[BUCHUNGS_ABLEHNUNG]) || $typ == BUCHUNGS_ABLEHNUNG){
	$art = BUCHUNGS_ABLEHNUNG;
	$unterschrift = "Ändern des Absagetextes einer Anfrage";
	$breadcrumps = erzeugenBC($root, $ueberschrift, "autoResponse/index.php",
							$unterschrift, "autoResponse/texteAnzeigen.php?".BUCHUNGS_ABLEHNUNG."=true");
}
else if (isset($_POST[ANFRAGE_BESTAETIGUNG]) || isset($_GET[ANFRAGE_BESTAETIGUNG]) || $typ == ANFRAGE_BESTAETIGUNG){
	$art = ANFRAGE_BESTAETIGUNG;
	$unterschrift = "Ändern des Bestätigungstextes einer Reservierungsanfrage";
	$breadcrumps = erzeugenBC($root, $ueberschrift, "autoResponse/index.php",
							$unterschrift, "autoResponse/texteAnzeigen.php?".ANFRAGE_BESTAETIGUNG."=true");
}
else if (isset($_POST[NEWSLETTER]) || isset($_GET[NEWSLETTER]) || $typ == NEWSLETTER){
	$art = NEWSLETTER;
	$unterschrift = "Senden von E-Mails an Ihre Gäste";
	$breadcrumps = erzeugenBC($root, $ueberschrift, "autoResponse/index.php",
							$unterschrift, "autoResponse/texteAnzeigen.php?".NEWSLETTER."=true");
}
if ($art != NEWSLETTER){		
		
	$betreffStandard = getMessageSubject($gastro_id,$art);
	$anredeStandard = getMessageAnrede($gastro_id,$art);
	$textStandard = getMessageBody($gastro_id,$art);
	$unterschriftStandard = getMessageUnterschrift($gastro_id,$art);		
}else{	
	$betreffStandard = "";
	$anredeStandard = "";
	$textStandard = "";
	$unterschriftStandard = "";				
}	

include_once($root."/backoffice/templates/bodyStart.inc.php");	
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/backoffice/templates/components.inc.php"); 

?>	
<h2><?php echo(getUebersetzung($unterschrift)); ?></h2>

<form action="./texteAendern.php?art=<?=$art?>" method="post" target="_self">
  <input name="art" type="hidden" value="<?php echo($art); ?>"/>
  <p class="standardschrift">
  	<?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden")); ?>!
  </p>
    <?php

    $res = getActivtedSprachenOfVermieter($gastro_id);
    while ($d = $res->FetchNextObject()){ 
    	$sprache_id = $d->SPRACHE_ID;
    	$standardsprache = getSessionWert(SPRACHE);
    	$bezeichnung =  getBezeichnungOfSpracheID($sprache_id);
		$subject = 			getUebersetzungGastro($betreffStandard,$sprache_id,$gastro_id);
		$anrede = 			getUebersetzungGastro($anredeStandard,$sprache_id,$gastro_id);
		$text = 			getUebersetzungGastro($textStandard,$sprache_id,$gastro_id);
		$unterschrift = 	getUebersetzungGastro($unterschriftStandard,$sprache_id,$gastro_id);
/*		if (isset($fehler) && $fehler === true){
			$subject = $_POST["subject_".$sprache_id];
			$anrede = $_POST["anrede_".$sprache_id];
			$text = $_POST["text_".$sprache_id];
			$unterschrift = $_POST["unterschrift_".$sprache_id];
		}*/
    ?>
  <p class="standardschrift">
  	<?php echo(getUebersetzung("Texte in")." ".$bezeichnung); 
  	if ($standardsprache != $sprache_id){
  	?>
  	<br/>
   (<?php echo(getUebersetzung("Wenn sie diese Felder leer lassen wird auch in dieser Sprache die Standardsprache verwendet.")); ?>):
   <?php
  	}
  	?>
  </p>
  <table>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Betreff")); ?></td>
      <td><input name="subject_<?= $sprache_id ?>" type="text"  value="<?php echo($subject); ?>" size="50" maxlength="255"/>
      <?php  	
      	if  ($standardsprache == $sprache_id){
	  	  echo("*"); 
	  	}
	  ?>
  	  </td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Anrede")); ?></td>
      <td><input name="anrede_<?= $sprache_id ?>" type="text"  value="<?php echo($anrede); ?>" size="50" maxlength="255"/><?php  	
      	if  ($standardsprache == $sprache_id){
	  	  echo("*"); 
	  	}
	  ?>
        <br/>
        (<?php echo(getUebersetzung("Nach ihrer Anrede wird der Name des Mieters automatisch eingesetzt")); ?>)</td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Text")); ?></td>
      <td>
      	<textarea name="text_<?= $sprache_id ?>" cols="50" rows="5"  ><?php echo($text); ?></textarea><?php  	
      		if  ($standardsprache == $sprache_id){
	  	 	 echo("*"); 
		  	}
		?>
	  </td>
    </tr>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Unterschrift")); ?></td>
      <td>
	      <textarea name="unterschrift_<?= $sprache_id ?>" cols="50" rows="5" ><?php echo($unterschrift); ?></textarea>
	      <?php  	
	      	if  ($standardsprache == $sprache_id){
		  	  echo("*"); 
		  	}
		  ?>
	  </td>
    </tr>
  </table>  
  <?php
  }
  if ($art != NEWSLETTER){ 
  ?>
  <br/>
  <table>
    <tr valign="top">
      <td><?php echo(getUebersetzung("Automatische Antwort aktiviert")); ?> </td>
      <td>
      	<p>
          <label>
          	<input name="aktiviert" type="radio" 
          		value="1" <?php if (isMessageActive($gastro_id,$art) == true) echo("checked=\"checked\""); ?>/>
          <?php echo(getUebersetzung("ja")); ?>
          </label>
          <br/>
          <label>
          	<input type="radio" name="aktiviert" 
          		value="0" <?php if (isMessageActive($gastro_id,$art) != true) echo("checked=\"checked\""); ?>/>
          <?php echo(getUebersetzung("nein")); ?></label>
        </p>
       </td>
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
  <table>
    <tr>
      <td><?php echo(getUebersetzung("Bitte wählen Sie die Gäste aus, an denen das E-Mail gesendet werden soll.")); ?><br/>
          <?php echo(getUebersetzung("Wenn Sie mehrere Gäste auswählen wollen müssen Sie die [Strg] Taste gedrückt halten.")); ?></td>
    </tr>
    <tr>
      <td><select name="mieter[]" size="10" multiple>
          <?php
		//alle gäste der unterkunft auslesen:
		$res = getAllMieterFromVermieter($gastro_id);
		while ($d = $res->FetchNextObject()){
			$mieter_id = $d->GAST_ID;
			$vorname = $d->VORNAME;
			$nachname = $d->NACHNAME;
			$ort = $d->ORT;
			$land = $d->LAND;
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
	} //ende if newsletter
?>
</form>
<?php 
include_once($root."/backoffice/templates/footer.inc.php");
?>
