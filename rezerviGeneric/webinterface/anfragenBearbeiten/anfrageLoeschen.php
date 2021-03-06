<?php $root = "../..";

/*   
	date: 7.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/components.inc.php"); 
include_once($root."/webinterface/templates/bodyStart.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/include/autoResponseFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/mail.inc.php");

$reservierungs_id = $_POST["reservierungs_id"];
$antwort = $_POST["antwort"];
if (isset($_POST["mieterEntfernen"])){
	$mieterEntfernen = $_POST["mieterEntfernen"];
}
else{
	$mieterEntfernen = false;
}
$mieter_id = getMieterIdFromReservierung($reservierungs_id);
$vonDatum = getDatumVonOfReservierung($reservierungs_id);
$bisDatum = getDatumBisOfReservierung($reservierungs_id);
$mieter_id = getMieterIdFromReservierung($reservierungs_id);

?>
<p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Reservierungsanfragen von Gästen löschen")); ?></p>
<?php
		
	//soll der gast automatisch informiert werden?
	if ($antwort == "true"){
	
		 $speech = getSpracheOfMieter($mieter_id);
		 $gastName = getNachnameOfMieter($mieter_id);
		 $an = getEmailOfMieter($mieter_id);
		 $von = getVermieterEmail($vermieter_id);		
		 $subject = getUebersetzungVermieter(getMessageSubject($vermieter_id,BUCHUNGS_ABLEHNUNG),$speech,$vermieter_id);
		 $anr = getUebersetzungVermieter(getMessageAnrede($vermieter_id,BUCHUNGS_ABLEHNUNG),$speech,$vermieter_id);
		 $message = $anr.(" ").($gastName).("!\n\n");
		 $bod = getUebersetzungVermieter(getMessageBody($vermieter_id,BUCHUNGS_ABLEHNUNG),$speech,$vermieter_id);
		 $message .= $bod.("\n\n");
		 $unt = getUebersetzungVermieter(getMessageUnterschrift($vermieter_id,BUCHUNGS_ABLEHNUNG),$speech,$vermieter_id);
		 $message .= $unt;
		 //mail absenden:     
		 sendMail($von,$an,$subject,$message);
	}
		
	//zuerst reservierung löschen:
	deleteReservation($reservierungs_id);	
	
	//wenn auch der gast entfernt werden soll
	if ($mieterEntfernen == "true" && !hasMieterReservations($mieter_id)){
		deleteMieter($mieter_id);	
		?>
		<table  border="0" cellpadding="0" cellspacing="3" class="<?php echo FREI ?>">
		  <tr>
		    <td><?php echo(getUebersetzung("Die Reservierungsanfrage und der Mieter wurde aus der Datenbank entfernt")); ?>.</td>
		  </tr>
		</table>
		<?php
	}
	else if ($mieterEntfernen == "true" && hasMieterReservations($mieter_id)){
	?>
		<table  border="0" cellpadding="0" cellspacing="3" class="<?php echo BELEGT ?>">
		  <tr>
		    <td><?php echo(getUebersetzung("Die Reservierungsanfrage wurde gelöscht, der Mieter kann nicht entfernt werden, es sind weitere Reservierungen für diesen Mieter eingetragen")); ?>!</td>
		  </tr>
		</table>
    <?php
	} 			
	?>

<table  border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
  <tr>
    <td><p class="<?php echo FREI ?>">
    	<?php echo(getUebersetzung("Die Reservierungsanfrage")); ?>
        <?php echo(getMieterVorname($mieter_id)." ".getNachnameOfMieter($mieter_id)); ?>
        <br/>
        <?php echo(getUebersetzung("von")); ?> <?php echo($vonDatum); ?><br/>
        <?php echo(getUebersetzung("bis")); ?> <?php echo($bisDatum); ?><br/>
        <?php echo(getUebersetzung("wurde erfolgreich entfernt")); ?>.</p>
      <?php if ($antwort == "true"){ ?>
      <p><?php echo(getUebersetzung("Die folgende Mitteilung wird per E-Mail an Ihren Mieter gesendet. Sie haben hier die Möglichkeiten noch Korrekturen vorzunehmen")); ?>:</p>
      <form action="./bestaetigungSenden.php" method="post" name="bestaetigungSenden" target="_self">
        <input name="an" type="hidden" value="<?php echo($an); ?>">
        <input name="von" type="hidden" value="<?php echo($von); ?>">
        <input name="mieter_id" type="hidden" value="<?php echo $mieter_id ?>">
        <table  border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
          <tr valign="top">
            <td><?php echo(getUebersetzung("Betreff")); ?></td>
            <td><input name="subject" type="text"  id="subject_de" value="<?php echo($subject); ?>" size="50"></td>
          </tr>
          <tr valign="top">
            <td><?php echo(getUebersetzung("Text")); ?></td>
            <td><textarea name="message" cols="50" rows="10"  id="text_de"><?php echo($message); ?></textarea></td>
          </tr>
        </table>
        <br/>
        <?php 
	  //-----buttons um zurück zum menue zu gelangen: 
  	  showSubmitButton(getUebersetzung("absenden"));
	  } //ende if
?>
      </p>
      </form>
      <br/>
      <?php 
	  showSubmitButtonWithForm("./index.php",getUebersetzung("zurück"));
include_once($root."/webinterface/templates/footer.inc.php");
?>

