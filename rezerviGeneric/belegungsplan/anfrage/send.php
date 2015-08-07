<?php $root="../..";

include_once($root."/templates/header.inc.php");

include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/include/mail.inc.php");
include_once($root."/include/autoResponseFunctions.inc.php");

$ansicht = $_POST["ansicht"];
$vonTag = $_POST["vonTag"];
$bisTag = $_POST["bisTag"];
$vonMonat = $_POST["vonMonat"];
$bisMonat = $_POST["bisMonat"];
$vonJahr = $_POST["vonJahr"];
$bisJahr = $_POST["bisJahr"];
$mietobjekt_id = $_POST["mietobjekt_id"];
$vonMinute=$_POST["vonMinute"];
$vonStunde=$_POST["vonStunde"];
$bisMinute=$_POST["bisMinute"];
$bisStunde=$_POST["bisStunde"];

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

//pruefen der eingegebenen daten:
$fehler = false;
if (empty($vorname)){
	$fehler = true;
	$nachricht = "Bitte geben sie ihren Vornamen ein.";
}
else if (empty($nachname)){
	$fehler = true;
	$nachricht = "Bitte geben sie ihren Nachnamen ein.";
}
else if (empty($strasse)){
	$fehler = true;
	$nachricht = "Bitte geben sie ihre Straße und Hausnummer ein.";
}
else if (empty($plz)){
	$fehler = true;
	$nachricht = "Bitte geben sie ihre Postleizahl ein.";
}
else if (empty($ort)){
	$fehler = true;
	$nachricht = "Bitte geben sie ihren Ort ein.";
}
else if (empty($email)){
	$fehler = true;
	$nachricht = "Bitte geben sie ihre E-Mail-Adresse ein.";
}
else if (checkMailAdress($email) === false){
	$fehler = true;
	$nachricht = "Bitte prüfen sie ihre E-Mail-Adresse, es handelt sich um eine ungültige Adresse.";
}

if ($fehler === true){
	$nachricht = getUebersetzung($nachricht);
	include_once("./index.php");	
	exit;
}

//ist der mieter schon angelegt?
$mieter_id = getMieterId($vermieter_id,$vorname,$nachname,$email);
if (empty($mieter_id)){
	//mieter neu anlegen:
	$mieter_id = insertMieter($vermieter_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$speech);	
}
else{
	//mieter sicherheitshalber mal updaten:
	updateMieter($mieter_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$speech);	
}

//reservierung eintragen:
$status = STATUS_RESERVIERT;
insertReservation($mietobjekt_id,$mieter_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr,$status);
if (!empty($anmerkung)){
	insertMieterText($anmerkung,$mieter_id);
}

include_once($root."/templates/bodyStart.inc.php"); 
?>
<table border="0" cellspacing="3" cellpadding="0" class="<?= TABLE_STANDARD ?>">
  <tr> 
    <td><span class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Danke für Ihre Anfrage!")); ?></span> <p>
	<?php echo(getUebersetzung("Der Vermieter wurde über Ihre Reservierungs-Anfrage verständigt, und wird sich mit Ihnen in Verbindung setzen.")); ?> <br/>
        <?php echo(getUebersetzung("Bitte beachten Sie, dass die Reservierung nur mit Bestätigung des Vermieters gültig ist.")); ?> <br/>
      </p>
      </td>
  </tr>
</table>
<?php
		 $standardsprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
		 $von = $email;		
		 $subject = getUebersetzungFromSprache("Buchungsanfrage aus dem Rezervi Generic Buchungssystem",$standardsprache);
		 $message = getUebersetzungFromSprache("Buchungsanfrage von",$standardsprache)." ".$anrede." ".$vorname." ".$nachname." ".$firma."\n";
		 $message = $message.getUebersetzungFromSprache("Adresse",$standardsprache).": ".$land." ".$plz." ".$ort." ".$strasse." "."\n";
		 $message = $message.getUebersetzungFromSprache("Telefonnummer",$standardsprache).": ".$tel." ".", ".$tel2." \n";
		 $message = $message.getUebersetzungFromSprache("Faxnummer",$standardsprache).": ".$fax." \n";
		 $message = $message.getUebersetzungFromSprache("E-Mail-Adresse",$standardsprache).": ".$email.", ".$url." \n";
		 $message = $message.getUebersetzungFromSprache("Anmerkungen",$standardsprache).": ".$anmerkung." \n";
		 $message = $message.getUebersetzungFromSprache("von",$standardsprache).": ".$vonTag.".".$vonMonat.".".$vonJahr." ".$vonStunde.":".$vonMinute." bis ".$bisTag.".".$bisMonat.".".$bisJahr." ".$bisStunde.":".$bisMinute." \n";
					
		 $moNummer = getMietobjektBezeichnung($mietobjekt_id);
		 $moArt    = getMietobjekt_EZ($vermieter_id);
		 
		 $message=$message.getUebersetzungVermieter($moArt,$standardsprache,$vermieter_id).": ".getUebersetzungVermieter($moNummer,$standardsprache,$vermieter_id);
         $message=$message.getUebersetzungFromSprache("Sie können diese Anfrage im Webinterface bestätigen oder ablehnen",$standardsprache)."\n"; 

		 $bezSprache = getBezeichnungOfSpracheID($sprache);
	     $message = $message."\n".getUebersetzungFromSprache("Die Anfrage wurde in $bezSprache Sprache gestellt",$standardsprache).".";
	  
		 //e-mail-adresse aus datenbank holen:
		 $anVermieter = getVermieterEmail($vermieter_id);         	
  
  		 //mail absenden:     
		 sendMail($von,$anVermieter,$subject,$message);
		
		 //bestaetigung an gast auch senden?
		 $art = ANFRAGE_BESTAETIGUNG;
		 if (isMessageActive($vermieter_id,$art)){			 
			 $gastName = $nachname;
			 $an = $email;
			 $von = $anVermieter;		
			 $subject = getUebersetzungVermieter(getMessageSubject($vermieter_id,$art),$sprache,$vermieter_id);
			 $anrede = getUebersetzungVermieter(getMessageAnrede($vermieter_id,$art),$sprache,$vermieter_id);
			 $message = $anrede.(" ").($gastName).("!\n\n");
			 $body = getUebersetzungVermieter(getMessageBody($vermieter_id,$art),$sprache,$vermieter_id);
			 $message .= $body.("\n\n");
			 $unterschrift = getUebersetzungVermieter(getMessageUnterschrift($vermieter_id,$art),$sprache,$vermieter_id);
			 $message .= $unterschrift;
			 sendMail($von,$an,$subject,$message);
			 //save mail in mieter Texte:
			 $text = "Automatisch generierte Bestätigung zu einer Anfrage.\n";
			 $text .="Betreff: ".$subject."\n";
			 $text .="Nachricht: ".$message;
			 insertMieterText($text,$mieter_id);
     	 }	
	 
   ?>
<table border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td>
    	<form action="<?= $root."/start.php" ?>" method="post" name="form1" target="_self">	
          <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?= $mietobjekt_id ?>"/>
		  <input name="ansicht" type="hidden" id="ansicht" value="<?= $ansicht ?>"/>          
          <input name="vonTag" type="hidden" id="vonTag" value="<?= $vonTag ?>"/>
          <input name="bisTag" type="hidden" id="bisTag" value="<?= $bisTag ?>"/>
          <input name="vonMonat" type="hidden" id="vonMonat" value="<?= $vonMonat ?>"/>
          <input name="bisMonat" type="hidden" id="bisMonat" value="<?= $bisMonat ?>"/>
          <input name="vonJahr" type="hidden" id="vonJahr" value="<?= $vonJahr ?>"/>
          <input name="bisJahr" type="hidden" id="bisJahr" value="<?= $bisJahr ?>"/>
          <input name="vonMinute" type="hidden" id="vonMinute" value="<?= $vonMinute ?>"/>
          <input name="bisMinute" type="hidden" id="bisMinute" value="<?= $bisMinute ?>"/>
          <input name="vonStunde" type="hidden" id="vonStunde" value="<?= $vonStunde ?>"/>
          <input name="bisStunde" type="hidden" id="bisStunde" value="<?= $bisStunde ?>"/>
          <input name="bisStunde" type="hidden" id="bisStunde" value="<?= $bisStunde ?>"/>		
          <input type="submit" name="Submit" value="<?php echo(getUebersetzung("zurück")); ?>" 
          		class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
      			onMouseOut="this.className='<?= BUTTON ?>';">
        </form>
    </td>
  </tr>
</table>
<?php
	include_once($root."/templates/footer.inc.php");
?>