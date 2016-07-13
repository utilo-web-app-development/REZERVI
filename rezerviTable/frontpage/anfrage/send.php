<?php $root="../..";

include_once($root."/templates/header.inc.php");

include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/include/mail.inc.php");
include_once($root."/include/autoResponseFunctions.inc.php");


$vonTag = $_POST["tag"];
$vonMonat = $_POST["monat"];
$vonJahr = $_POST["jahr"];
$vonMinute=$_POST["minute"];
$vonStunde=$_POST["stunde"];

$raum_id = $_POST["raum_id"];
$personen = $_POST["personen"];

if (isset($_POST["anrede"])){
	$anrede = $_POST["anrede"];
}
else{
	$anrede = "";
}
if (isset($_POST["anmerkung"])){
	$anmerkung = $_POST["anmerkung"];
}
else{
	$anmerkung = "";
}
if (isset($_POST["vorname"])){
	$vorname = $_POST["vorname"];
}
else{
	$vorname = "";
}
if (isset($_POST["nachname"])){
	$nachname = $_POST["nachname"];
}
else{
	$nachname = "";
}
if (isset($_POST["strasse"])){
	$strasse = $_POST["strasse"];
}
else{
	$strasse = "";
}
if (isset($_POST["plz"])){
	$plz = $_POST["plz"];
}
else{
	$plz = "";
}
if (isset($_POST["ort"])){
	$ort = $_POST["ort"];
}
else{
	$ort = "";
}
if (isset($_POST["land"])){
	$land = $_POST["land"];
}
else{
	$land = "";
}
if (isset($_POST["email"])){
	$email = $_POST["email"];
}
else{
	$email = "";
}
if (isset($_POST["tel"])){
	$tel = $_POST["tel"];
}
else{
	$tel = "";
}
if (isset($_POST["tel2"])){
	$tel2 = $_POST["tel2"];
}
else{
	$tel2 = "";
}
if (isset($_POST["fax"])){
	$fax = $_POST["fax"];
}
else{
	$fax = "";
}
if (isset($_POST["url"])){
	$url = $_POST["url"];
}
else{
	$url = "";
}
$speech = $sprache;
if (isset($_POST["firma"])){
	$firma = $_POST["firma"];
}
else{
	$firma = "";
}

//ist der mieter schon angelegt?
$gast_id = getMieterId($gastro_id,$vorname,$nachname,$email);
if (empty($mieter_id)){
	//mieter neu anlegen:
	$mieter_id = insertMieter($gastro_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$speech,'','');	
}
else{
	//mieter sicherheitshalber mal updaten:
	updateMieter($mieter_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$speech,'','');	
}

//reservierung eintragen:
$status = STATUS_RESERVIERT;
$tisch_ids = $_POST["tisch_ids"];
foreach ($tisch_ids as $id){
	insertReservation($id,$mieter_id,$personen,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$status);
}
if (!empty($anmerkung)){
	insertMieterText($anmerkung,$mieter_id);
}

include_once($root."/templates/bodyStart.inc.php"); 
?>
<table border="0" cellspacing="3" cellpadding="0" class="<?php echo TABLE_STANDARD ?>">
  <tr> 
    <td>
    	<span class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
    		<?php echo(getUebersetzung("Danke für Ihre Reservierungsanfrage!")); ?>
    	</span>
    	<p>
			<?php echo(getUebersetzung("Wir haben ihre Reservierungs-Anfrage erhalten, und werden uns mit Ihnen in Verbindung setzen.")); ?> 
			<br/>
	        <?php echo(getUebersetzung("Bitte beachten Sie, dass die Reservierung nur mit einer Bestätigung von uns gültig ist.")); ?> 
	        <br/>
        </p>
      </td>
  </tr>
</table>
<?php
		 $standardsprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
		 $von = $email;		
		 $subject = getUebersetzungFromSprache("Buchungsanfrage aus dem Bookline Buchungssystem",$standardsprache);
		 $message = getUebersetzungFromSprache("Buchungsanfrage von",$standardsprache)." ".$anrede." ".$vorname." ".$nachname." ".$firma."\n";
		 $message = $message.getUebersetzungFromSprache("Adresse",$standardsprache).": ".$land." ".$plz." ".$ort." ".$strasse." "."\n";
		 $message = $message.getUebersetzungFromSprache("Telefonnummer",$standardsprache).": ".$tel." ".", ".$tel2." \n";
		 $message = $message.getUebersetzungFromSprache("Faxnummer",$standardsprache).": ".$fax." \n";
		 $message = $message.getUebersetzungFromSprache("E-Mail-Adresse",$standardsprache).": ".$email.", ".$url." \n";
		 $message = $message.getUebersetzungFromSprache("Anmerkungen",$standardsprache).": ".$anmerkung." \n";
		 $message = $message.getUebersetzungFromSprache("Reservierung am",$standardsprache).": ".$vonTag.".".$vonMonat.".".$vonJahr." ".$vonStunde.":".$vonMinute."  \n";
					
         $message=$message.getUebersetzungFromSprache("Sie k�nnen diese Anfrage im Backoffice best�tigen oder ablehnen",$standardsprache)."\n"; 

		 $bezSprache = getBezeichnungOfSpracheID($sprache);
	     $message = $message."\n".getUebersetzungFromSprache("Die Anfrage wurde in $bezSprache Sprache gestellt",$standardsprache).".";
	  
		 //e-mail-adresse aus datenbank holen:
		 $anVermieter = getVermieterEmail($gastro_id);         	
 
  		 //mail absenden:     
		 sendMail($von,$anVermieter,$subject,$message);
		 
		 //bestaetigung an gast auch senden?
		 $art = ANFRAGE_BESTAETIGUNG;
		 if (isMessageActive($gastro_id,$art)){		
			 $gastName = $nachname;
			 $an = $email;
			 $von = $anVermieter;		
			 $subject = getUebersetzungGastro(getMessageSubject($gastro_id,$art),$sprache,$gastro_id);
			 $anrede = getUebersetzungGastro(getMessageAnrede($gastro_id,$art),$sprache,$gastro_id);
			 $message = $anrede.(" ").($gastName).("!\n\n");
			 $body = getUebersetzungGastro(getMessageBody($gastro_id,$art),$sprache,$gastro_id);
			 $message .= $body.("\n\n");
			 $unterschrift = getUebersetzungGastro(getMessageUnterschrift($gastro_id,$art),$sprache,$gastro_id);
			 $message .= $unterschrift; 
			 sendMail($von,$an,$subject,$message);
			 //save mail in mieter Texte:
			 $text = "Automatisch generierte Best�tigung zu einer Anfrage.\n";
			 $text .="Betreff: ".$subject."\n";
			 $text .="Nachricht: ".$message;			 
			 insertMieterText($text,$mieter_id);
     	 }	
	
   ?>
<table border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td>
    	<form action="<?php echo $root."/index.php" ?>" method="post" name="form1" target="_self">	          
          <input name="vonTag" type="hidden" id="vonTag" value="<?php echo $vonTag ?>"/>
          <input name="vonMonat" type="hidden" id="vonMonat" value="<?php echo $vonMonat ?>"/>
          <input name="vonJahr" type="hidden" id="vonJahr" value="<?php echo $vonJahr ?>"/>
          <input name="vonMinute" type="hidden" id="vonMinute" value="<?php echo $vonMinute ?>"/>
          <input name="vonStunde" type="hidden" id="vonStunde" value="<?php echo $vonStunde ?>"/>	
          <input type="submit" name="Submit" value="<?php echo(getUebersetzung("zurück")); ?>" 
          		class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
      			onMouseOut="this.className='<?php echo BUTTON ?>';">
        </form>
    </td>
  </tr>
</table>
<?php
	include_once($root."/templates/footer.inc.php");
?>