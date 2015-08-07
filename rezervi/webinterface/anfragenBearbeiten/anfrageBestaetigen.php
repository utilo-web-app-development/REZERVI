<? session_start();
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

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$reservierungs_id = $_POST["reservierungs_id"];
$reservierungen = split  ( ","  , $reservierungs_id );

if (isset($_POST["antwort"])){
	$antwort = $_POST["antwort"];
	$art = $_POST["art"];
}
else{
	$antwort = false;
}

$sprache = getSessionWert(SPRACHE);

	//datenbank öffnen:
	include_once("../../conf/rdbmsConfig.php");
	
	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once($root.'/include/zimmerFunctions.php');
	include_once("../../include/datumFunctions.php");
	include_once("../../include/unterkunftFunctions.php");
	include_once("../../include/gastFunctions.php");
	include_once("../../include/reservierungFunctions.php");
	include_once("../../include/autoResponseFunctions.php");
	include_once("../../include/priceFunctions.inc.php");
	include_once("../../include/uebersetzer.php");
	include_once("../templates/components.php"); 
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
<p class="standardSchriftBold"><?php echo(getUebersetzung("Reservierungsanfrage bestätigen",$sprache,$link)); ?></p>
<?php

	foreach ($reservierungen as $res_id){
		
		//zuerst prüfen ob nicht mitlerweile eine andere buchung eingetragen wurde:
		$vonDatum = getDatumVon($res_id,$link);
		$bisDatum = getDatumBis($res_id,$link);
		
		$vonTag = getTagFromSQLDate($vonDatum);
		$vonMonat=getMonatFromSQLDate($vonDatum);
		$vonJahr =getJahrFromSQLDate($vonDatum);
		$bisTag = getTagFromSQLDate($bisDatum);
		$bisMonat=getMonatFromSQLDate($bisDatum);
		$bisJahr =getJahrFromSQLDate($bisDatum);
		
		$gast_id = getGastID($res_id,$link);
		$zimmer_id = getZimmerID($res_id,$link);
		
		if (isRoomTaken($zimmer_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$link)){	
		?>
		<table border="0" cellpadding="0" cellspacing="0" class="tableColor">
		  <tr>
		    <td><p class="standardSchriftBold"><?php echo(getUebersetzung("Zu dieser Zeit ist bereits eine Buchung eingetragen!",$sprache,$link)); ?></p>
		        <p class="standardSchriftBold"><?php echo(getUebersetzung("Bitte löschen sie zuerst bereits vorhandene Buchungen zu diesem Datum!",$sprache,$link)); ?></p>
			</td>
		  </tr>
		</table>
		<br/>
		<?php
		showSubmitButtonWithForm("./index.php",getUebersetzung("zurück",$sprache,$link));
		}
		else{
			//belegung eintragen
			changeReservationState($res_id,2,$link);
		}
	}
			
	//soll der gast automatisch informiert werden?
	$speech = "";
	$an = "";
	$von = "";
	$message = "";
	$subject = "";
	$preis = 0;
	
	if ($antwort == "true"){	
		
		foreach ($reservierungen as $res_id){
		 $preis += calculatePriceOfReservation($res_id);	
		}		
		
	}
			
	?>
	<table border="0" cellpadding="0" cellspacing="3" class="tableColor">
	  <tr>
	    <td><p><?php echo(getUebersetzung("Die Reservierungsanfrage",$sprache,$link)); ?>
	        <?php echo(getGuestVorname($gast_id,$link)." ".getGuestNachname($gast_id,$link)); ?>
	        <br/>
	        <?php echo(getUebersetzung("von",$sprache,$link)); ?> <?php echo($vonDatum); ?><br/>
	        <?php echo(getUebersetzung("bis",$sprache,$link)); ?> <?php echo($bisDatum); ?><br/>
	        <?php echo(getUebersetzung("wurde erfolgreich als",$sprache,$link)); ?> <span class="belegt">&quot;<?php echo(getUebersetzung("belegt",$sprache,$link)); ?>&quot;</span> <?php echo(getUebersetzung("in den Reservierungsplan aufgenommen",$sprache,$link)); ?>.</p>
	     
	      <?php if ($antwort == "true"){ 
	         
	         $speech = getGuestSprache($gast_id,$link);
			 $gastName = getGuestNachname($gast_id,$link);
			 $an = getGuestEmail($gast_id,$link);
			 $von = getUnterkunftEmail($unterkunft_id,$link);		
			 $subject = getUebersetzungUnterkunft(getMessageSubject($unterkunft_id,$art,$link),$speech,$unterkunft_id,$link);
			 $anr = getUebersetzungUnterkunft(getMessageAnrede($unterkunft_id,$art,$link),$speech,$unterkunft_id,$link);
			 $message = $anr.(" ").($gastName).("!\n\n");
			 $bod = getUebersetzungUnterkunft(getMessageBody($unterkunft_id,$art,$link),$speech,$unterkunft_id,$link);
			 $message .= $bod.("\n\n");
			 if (!empty($preis) && $preis > 0){
			 	$pr = getUebersetzung("Preis").": ".$preis." ".getWaehrung($unterkunft_id);
			 	$message .= $pr;
			 	$message .= ("\n\n");
			 }
			 $unt = getUebersetzungUnterkunft(getMessageUnterschrift($unterkunft_id,$art,$link),$speech,$unterkunft_id,$link);
			 $message .= $unt;
	      }
	      	?>
	      <p><?php echo(getUebersetzung("Die folgende Mitteilung wird per E-Mail an Ihren Gast gesendet. Sie haben hier die Möglichkeiten noch Korrekturen vorzunehmen",$sprache,$link)); ?>:</p>
		<form action="./bestaetigungSenden.php" method="post" name="bestaetigungSenden" target="_self">
		<input name="an" type="hidden" value="<?php echo($an); ?>">
		<input name="von" type="hidden" value="<?php echo($von); ?>">
		<table  border="0" cellpadding="0" cellspacing="3" class="tableColor">
			  <tr valign="top">
				<td><?php echo(getUebersetzung("Betreff",$sprache,$link)); ?></td>
				<td><input name="subject" type="text"  id="subject_de" value="<?php echo($subject); ?>" size="100"></td>
			  </tr>
				<tr valign="top">
				<td><?php echo(getUebersetzung("Text",$sprache,$link)); ?>
				</td>
				<td><textarea name="message" cols="100" rows="10"  id="text_de"><?php echo($message); ?></textarea></td>
			  </tr>
		</table>
	<br/>
	<?php 
		  //-----buttons um zurück zum menue zu gelangen: 
	  	  showSubmitButton(getUebersetzung("absenden",$sprache,$link));
		  //} //ende if
	?>
	</p>
	</form>
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
		//} //ende wenn noch keine buchung vorhanden
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
?>
</body>
</html>
