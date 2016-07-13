<?php 
$root = "../..";
$ueberschrift = "Anfragen bearbeiten";
$unterschrift = "Bestätigen";

/*   
	date: 7.10.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/include/autoResponseFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php"); 
include_once($root."/backoffice/templates/breadcrumps.inc.php");	
$breadcrumps = erzeugenBC($root, "Anfragen", "anfragenBearbeiten/index.php",
							$unterschrift, "anfragenBearbeiten/anfrageBestaetigen.php");							
include_once($root."/backoffice/templates/bodyStart.inc.php");
include_once($root."/backoffice/templates/components.inc.php");

$reservierungs_id = $_POST["reservierungs_id"];
$antwort = false;
if (isset($_POST["antwort"])){
	$antwort = $_POST["antwort"]; //muss "true" sein
}

$mieter_id = getMieterIdFromReservierung($reservierungs_id);
$vonDatum = getDatumVonOfReservierung($reservierungs_id);
$vonDatum = getFormatedDateFromBooklineDate($vonDatum);


?>
<p><?php echo(getUebersetzung("Reservierungsanfrage bestätigen")); ?></p>
<?php

	//belegung eintragen:
	changeReservationState($reservierungs_id,STATUS_BELEGT);
		
	//soll der gast automatisch informiert werden?
	if ($antwort == "true"){
		 
		 $speech = getSpracheOfMieter($mieter_id);
		 $gastName = getNachnameOfMieter($mieter_id);
		 $an = getEmailOfMieter($mieter_id);
		 $von = getVermieterEmail($gastro_id);		
		 $subject = getUebersetzungGastro(getMessageSubject($gastro_id,BUCHUNGS_BESTAETIGUNG),$speech,$gastro_id);
		 $anr = getUebersetzungGastro(getMessageAnrede($gastro_id,BUCHUNGS_BESTAETIGUNG),$speech,$gastro_id);
		 $message = $anr.(" ").($gastName).("!\n\n");
		 $bod = getUebersetzungGastro(getMessageBody($gastro_id,BUCHUNGS_BESTAETIGUNG),$speech,$gastro_id);
		 $message .= $bod.("\n\n");
		 $unt = getUebersetzungGastro(getMessageUnterschrift($gastro_id,BUCHUNGS_BESTAETIGUNG),$speech,$gastro_id);
		 $message .= $unt;
		
	}
		
?>
<table border="0" cellpadding="0" cellspacing="3">
  <tr>
    <td><p class="frei"><?php echo(getUebersetzung("Die Reservierungsanfrage")); ?>
        <?php echo(getMieterVorname($mieter_id)." ".getNachnameOfMieter($mieter_id)); ?>
        <br/>
        <?php echo(getUebersetzung("am")); ?> <?php echo($vonDatum); ?>  <?php echo(getUebersetzung("Uhr")); ?><br/>
        <?php echo(getUebersetzung("wurde erfolgreich als")); ?> <span class="<?php echo BELEGT ?>">&quot;<?php echo(getUebersetzung("belegt")); ?>&quot;</span>
        <?php echo(getUebersetzung("gespeichert")); ?>.</p>
      <?php if ($antwort == "true"){ ?>
      <p><?php echo(getUebersetzung("Die folgende Mitteilung wird per E-Mail an Ihren Gast gesendet. Sie haben hier die Möglichkeiten noch Korrekturen vorzunehmen")); ?>:</p>
	<form action="./bestaetigungSenden.php" method="post" name="bestaetigungSenden" target="_self">
	<input name="an" type="hidden" value="<?php echo($an); ?>">
	<input name="von" type="hidden" value="<?php echo($von); ?>">
	<input name="mieter_id" type="hidden" value="<?php echo $mieter_id ?>">	
	<table  border="0" cellpadding="0" cellspacing="3" >
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
</td>
</tr>
</table>
<?php 
	  showSubmitButtonWithForm("./index.php",getUebersetzung("zurück"));

include_once($root."/backoffice/templates/footer.inc.php");
?>
