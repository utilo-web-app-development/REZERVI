<? $root = "../..";

/*   
	date: 7.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/include/autoResponseFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php");
include_once($root."/webinterface/templates/components.inc.php");

$reservierungs_id = $_POST["reservierungs_id"];
$antwort = $_POST["antwort"]; //muss "true" sein
$mieter_id = getMieterIdFromReservierung($reservierungs_id);
$vonDatum = getDatumVonOfReservierung($reservierungs_id);
$bisDatum = getDatumBisOfReservierung($reservierungs_id);

?>
<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Reservierungsanfrage bestätigen")); ?></p>
<?php

	//belegung eintragen:
	changeReservationState($reservierungs_id,STATUS_BELEGT);
		
	//soll der gast automatisch informiert werden?
	if ($antwort == "true"){
		 
		 $speech = getSpracheOfMieter($mieter_id);
		 $gastName = getNachnameOfMieter($mieter_id);
		 $an = getEmailOfMieter($mieter_id);
		 $von = getVermieterEmail($vermieter_id);		
		 $subject = getUebersetzungVermieter(getMessageSubject($vermieter_id,BUCHUNGS_BESTAETIGUNG),$speech,$vermieter_id);
		 $anr = getUebersetzungVermieter(getMessageAnrede($vermieter_id,BUCHUNGS_BESTAETIGUNG),$speech,$vermieter_id);
		 $message = $anr.(" ").($gastName).("!\n\n");
		 $bod = getUebersetzungVermieter(getMessageBody($vermieter_id,BUCHUNGS_BESTAETIGUNG),$speech,$vermieter_id);
		 $message .= $bod.("\n\n");
		 $unt = getUebersetzungVermieter(getMessageUnterschrift($vermieter_id,BUCHUNGS_BESTAETIGUNG),$speech,$vermieter_id);
		 $message .= $unt;
		
	}
		
?>
<table border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td><p class="<?= FREI ?>"><?php echo(getUebersetzung("Die Reservierungsanfrage")); ?>
        <?php echo(getMieterVorname($mieter_id)." ".getNachnameOfMieter($mieter_id)); ?>
        <br/>
        <?php echo(getUebersetzung("von")); ?> <?php echo($vonDatum); ?><br/>
        <?php echo(getUebersetzung("bis")); ?> <?php echo($bisDatum); ?><br/>
        <?php echo(getUebersetzung("wurde erfolgreich als")); ?> <span class="<?= BELEGT ?>">&quot;
        <?php echo(getUebersetzung("belegt")); ?>&quot;</span> <?php echo(getUebersetzung("in den Belegungsplan aufgenommen")); ?>.</p>
      <?php if ($antwort == "true"){ ?>
      <p><?php echo(getUebersetzung("Die folgende Mitteilung wird per E-Mail an Ihren Mieter gesendet. Sie haben hier die Möglichkeiten noch Korrekturen vorzunehmen")); ?>:</p>
	<form action="./bestaetigungSenden.php" method="post" name="bestaetigungSenden" target="_self">
	<input name="an" type="hidden" value="<?php echo($an); ?>">
	<input name="von" type="hidden" value="<?php echo($von); ?>">
	<input name="mieter_id" type="hidden" value="<?= $mieter_id ?>">	
	<table  border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
		  <tr valign="top">
			<td><?php echo(getUebersetzung("Betreff")); ?></td>
			<td><input name="subject" type="text"  id="subject_de" value="<?php echo($subject); ?>" size="50"></td>
		  </tr>
			<tr valign="top">
			<td><?php echo(getUebersetzung("Text")); ?>
			</td>
			<td><textarea name="message" cols="50" rows="10"  id="text_de"><?php echo($message); ?></textarea></td>
		  </tr>
	</table>
<br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
  	  showSubmitButton(getUebersetzung("absenden"));
	  } //ende if antwort true
?>
</p>
</form>
<br/>
<?php 
	  showSubmitButtonWithForm("./index.php",getUebersetzung("zurück"));

include_once($root."/webinterface/templates/footer.inc.php");
?>
