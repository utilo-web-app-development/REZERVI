<?php session_start();
$root = "..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
include_once($root."/include/propertiesFunctions.php");
/*   
			rezervi
			versenden und eintragen einer reservierung
			author: christian osterrieder utilo.eu					
			
*/ 
//funktionen zum versenden von e-mails:
include_once($root."/include/mail.inc.php");

	//variablen initialisieren:
	if (isset($_POST["zusatz"])){
		$pension = $_POST["zusatz"];
	}
	else{
		$pension = false;	
	}
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	$sprache = getSessionWert(SPRACHE);
	
	if (isset($_POST["zimmer_id"])){
		$zimmer_id = $_POST["zimmer_id"];
	}
	else{
		$zimmer_id = "";
	}
	
	if (isset($_POST["zimmer_ids"])){
		$zimmer_ids = $_POST["zimmer_ids"];
	}

	$anrede = $_POST["anrede"];
	$vorname = $_POST["vorname"];
	$nachname = $_POST["nachname"];
	$strasse = $_POST["strasse"];
	$plz = $_POST["plz"];
	$ort = $_POST["ort"];
	$land = $_POST["land"];	
	$email = $_POST["email"];
	$tel = $_POST["tel"];	
	$fax = $_POST["fax"];
	$anmerkung = $_POST["anmerkung"];
	$anzahlErwachsene = $_POST["anzahlErwachsene"];
	if (isset($_POST["preis"])){
		$preis = $_POST["preis"];
	}
	else{
		$preis = 0;
	}
	if (isset($_POST["anzahlKinder"])){
		$anzahlKinder = $_POST["anzahlKinder"];
	}
	else{
		$anzahlKinder = 0;
	}
	if (isset($_POST["Haustiere"])){
		$haustiere = $_POST["Haustiere"];
	}
	else{
		$haustiere = "false";
	}
	$vonTag = $_POST["vonTag"];
	$vonMonat = $_POST["vonMonat"];	
	$bisTag = $_POST["bisTag"];
	$bisMonat = $_POST["bisMonat"];
	$bisJahr = $_POST["bisJahr"];
	$vonJahr = $_POST["vonJahr"];

	//andere "include_onces" einfügen:
	include_once("../include/gastFunctions.php");
	include_once("../include/reservierungFunctions.php");
	include_once("../include/zimmerFunctions.php");
	include_once("../include/unterkunftFunctions.php");
	include_once("../include/uebersetzer.php");
	include_once("../include/autoResponseFunctions.php");
	
?>

<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>

<?php	
	//ist der gast schon angelegt?
	$gastID = getGuestID($unterkunft_id,$vorname,$nachname,$email,$link);
	if ($gastID == ""){
		//gast neu anlegen:
		$gastID = insertGuest($unterkunft_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$fax,$anmerkung,$sprache,$link);	
	}
	//reservierung eintragen:
?>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr> 
    <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Danke für Ihre Anfrage!",$sprache,$link)); ?></span> <p>
	<?php echo(getUebersetzung("Der Vermieter wurde über Ihre Reservierungs-Anfrage verständigt, und wird sich mit Ihnen in Verbindung setzen.",$sprache,$link)); ?> <br/>
        <?php echo(getUebersetzung("Bitte beachten Sie, dass die Reservierung nur mit Bestätigung des Vermieters gültig ist.",$sprache,$link)); ?> <br/>
      </p>
      </td>
  </tr>
</table>
<?php
		 $von = $email;		
		 $subject = getUebersetzung("Buchungsanfrage aus dem Rezervi Buchungssystem",$sprache,$link);
		 $message = getUebersetzung("Buchungsanfrage von",$sprache,$link)." $anrede $vorname $nachname\n";
		 $message = $message.getUebersetzung("Adresse",$sprache,$link).": $land $plz $ort $strasse \n";
		 $message = $message.getUebersetzung("Telefonnummer",$sprache,$link).": $tel \n";
		 $message = $message.getUebersetzung("Faxnummer",$sprache,$link).": $fax \n";
		 $message = $message.getUebersetzung("E-Mail-Adresse",$sprache,$link).": $email \n";
		 $message = $message.getUebersetzung("Anmerkungen",$sprache,$link).": $anmerkung \n";
		 $message = $message.getUebersetzung("von",$sprache,$link).": $vonTag.$vonMonat.$vonJahr bis $bisTag.$bisMonat.$bisJahr \n";
		 $message = $message.getUebersetzung("Erwachsene",$sprache,$link).": $anzahlErwachsene \n";
		 $message = $message.getUebersetzung("Kinder",$sprache,$link).": $anzahlKinder \n";
		 if ($preis > 0){
		 	$message = $message.getUebersetzung("Preis",$sprache,$link).": $preis ".getWaehrung($unterkunft_id)." \n";
		 }
		 $message = $message."Pension: ".$pension." \n";
		 if ($haustiere == "true"){
		 	$haustiereUeb = "ja";
			$haustiereUeb = getUebersetzung($haustiereUeb,$sprache,$link);
			$message = $message.getUebersetzung("Haustiere",$sprache,$link).": $haustiereUeb \n";
		 }

					
		//anfrage kam ueber das suchformular:
		if (isset($zimmer_ids)){

			foreach($zimmer_ids as $zi_id){
				insertAnfrage($zi_id,$gastID,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,1,$anzahlErwachsene,$anzahlKinder,$haustiere,$pension,$link);
				$zimmerNummer = getZimmerNr($unterkunft_id,$zi_id,$link);
				$message=$message.getUebersetzungUnterkunft(getZimmerart_EZ($unterkunft_id,$link),$sprache,$unterkunft_id,$link).(": $zimmerNummer \n");
				$zimmer_id = $zi_id;
			}
		}
		else{
			insertAnfrage($zimmer_id,$gastID,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,1,$anzahlErwachsene,$anzahlKinder,$haustiere,$pension,$link);			
			$zimmerNummer = getZimmerNr($unterkunft_id,$zimmer_id,$link);
							$message=$message.getUebersetzungUnterkunft(getZimmerart_EZ($unterkunft_id,$link),$sprache,$unterkunft_id,$link).(": $zimmerNummer \n");
		} //ende elso von suchformular
		$message=$message.getUebersetzung("Sie können diese Anfrage im Webinterface des Reservierungssystems bestätigen oder ablehnen",$sprache,$link)."\n"; 

		 if ($sprache == "en"){
		 	$message = $message."\n".getUebersetzung("Die Anfrage wurde in englischer Sprache gestellt",$sprache,$link).".";
		 }
		 else if ($sprache == "fr"){
			$message = $message."\n".getUebersetzung("Die Anfrage wurde in französischer Sprache gestellt",$sprache,$link).".";
		 }
		 else if ($sprache == "it"){
		 	$message = $message."\n".getUebersetzung("Die Anfrage wurde in italienischer Sprache gestellt",$sprache,$link).".";
		 }
		 else if ($sprache == "sp"){
		 	$message = $message."\n".getUebersetzung("Die Anfrage wurde in spanischer Sprache gestellt",$sprache,$link).".";
		 }
		 else if ($sprache == "es"){
		 	$message = $message."\n".getUebersetzung("Die Anfrage wurde in estonischer Sprache gestellt",$sprache,$link).".";
		 }
		 else if ($sprache == "nl"){
		 	$message = $message."\n".getUebersetzung("Die Anfrage wurde in holländische Sprache gestellt",$sprache,$link).".";
		 }		 
		 else{
			$message = $message."\n".getUebersetzung("Die Anfrage wurde in deutscher Sprache gestellt",$sprache,$link).".";
		 }	  
		  
		 //e-mail-adresse aus datenbank holen:
		 $query = "select Email from Rezervi_Unterkunft where PK_ID = '$unterkunft_id'";

  			$res = mysql_query($query, $link);
  				if (!$res)
  					echo("Anfrage $query scheitert.");
						
		 $d = mysql_fetch_array($res);
		 $mailVermieter = $d["Email"];
		 $an = $mailVermieter;       	
  
  		//mail absenden:     
		//mail($an, unhtmlentities($subject), unhtmlentities($message), "From: $von\nReply-To: $von\nX-Mailer: PHP/" . phpversion());
	  	sendMail($von,$an,$subject,$message);
	  	
		 //bestaetigung an gast auch senden?
		 $art = "anfrage";
		 if (isMessageActive($unterkunft_id,$art,$link)){			 
			 $gastName = getGuestNachname($gastID,$link);
			 $an = getGuestEmail($gastID,$link);
			 $von = getUnterkunftEmail($unterkunft_id,$link);		
			 $subject = getUebersetzungUnterkunft(getMessageSubject($unterkunft_id,$art,$link),$sprache,$unterkunft_id,$link);
			 $anrede = getUebersetzungUnterkunft(getMessageAnrede($unterkunft_id,$art,$link),$sprache,$unterkunft_id,$link);
			 $message = $anrede.(" ").($gastName).("!\n\n");
			 $body = getUebersetzungUnterkunft(getMessageBody($unterkunft_id,$art,$link),$sprache,$unterkunft_id,$link);
			 $message .= $body.("\n\n");
			 $unterschrift = getUebersetzungUnterkunft(getMessageUnterschrift($unterkunft_id,$art,$link),$sprache,$unterkunft_id,$link);
			 $message .= $unterschrift;
			//mail absenden:     
			//mail($an, unhtmlentities($subject), unhtmlentities($message), "From: $von\nReply-To: $von\nX-Mailer: PHP/" . phpversion());
	  		sendMail($von,$an,$subject,$message);
	  		
	  		//soll eine kopie an den vermieter gesendet werden:
	  		if (getPropertyValue(MAIL_KOPIE_AN_VERMIETER_ANFRAGE,$unterkunft_id,$link) == "true"){
	  			$message = getUebersetzung("Folgende Nachricht wurde an ihren Gast versendet",$sprache,$link).":\n\n".$message;
	  			//mail($mailVermieter, unhtmlentities($subject), unhtmlentities($message), "From: $von\nReply-To: $von\nX-Mailer: PHP/" . phpversion());
	  			sendMail($von,$mailVermieter,$subject,$message);
	  		}
     	 }	
	 
   ?>
<table border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td><form action="../ansichtWaehlen.php" method="post" name="form1" target="_self">	
			<input name="zimmer_id" type="hidden" value="<?php echo($zimmer_id); ?>">
			<input name="jahr" type="hidden" value="<?php echo($vonJahr); ?>">
			<input name="monat" type="hidden" value="<?php echo($vonMonat); ?>">			
        <input type="submit" name="Submit" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';">
      </form></td>
  </tr>
</table>
</BODY>
</HTML>