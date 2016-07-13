<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung des designs
			author: christian osterrieder utilo.eu						
*/
//funktionen zum versenden von e-mails:
include_once($root."/include/mail.inc.php");
	
//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/autoResponseFunctions.php");
include_once("../../include/gastFunctions.php");
include_once("../../include/einstellungenFunctions.php");
include_once("../../include/propertiesFunctions.php");
include_once("../../include/uebersetzer.php");	
include_once("../templates/components.php"); 
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

if (isset($_POST["subject_de"])){
$subject_de = $_POST["subject_de"];
}
else{
$subject_de = false;
}
if (isset($_POST["subject_fr"])){
$subject_fr = $_POST["subject_fr"];
}
else{
$subject_fr = false;
}
if (isset($_POST["subject_en"])){
$subject_en = $_POST["subject_en"];
}
else{
$subject_en = false;
}
if (isset($_POST["subject_it"])){
$subject_it = $_POST["subject_it"];
}
else{
$subject_it =false;
}
if (isset($_POST["subject_nl"])){
$subject_nl = $_POST["subject_nl"];
}
else{
$subject_nl =false;
}
if (isset($_POST["subject_sp"])){
$subject_sp = $_POST["subject_sp"];
}
else{
$subject_sp = false;
}
if (isset($_POST["subject_es"])){
$subject_es = $_POST["subject_es"];
}
else{
$subject_es = false;
}

if (isset($_POST["anrede_de"])){
$anrede_de = $_POST["anrede_de"];
}
else{
$anrede_de = false;
}
if (isset($_POST["anrede_fr"])){
$anrede_fr = $_POST["anrede_fr"];
}
else{
$anrede_fr = false;
}
if (isset($_POST["anrede_en"])){
$anrede_en = $_POST["anrede_en"];
}
else{
	$anrede_en = false;
}
if (isset($_POST["anrede_it"])){
$anrede_it = $_POST["anrede_it"];
}
else{
	$anrede_it = false;
}
if (isset($_POST["anrede_nl"])){
$anrede_nl = $_POST["anrede_nl"];
}
else{
	$anrede_nl = false;
}
if (isset($_POST["anrede_sp"])){
$anrede_sp = $_POST["anrede_sp"];
}
else{
	$anrede_sp = false;
}
if (isset($_POST["anrede_es"])){
$anrede_es = $_POST["anrede_es"];
}
else{
$anrede_es =false;
}

if (isset($_POST["text_de"])){
$text_de = $_POST["text_de"];
}
else{
$text_de =false;
}
if (isset($_POST["text_en"])){
$text_en = $_POST["text_en"];
}
else{
$text_en = false;
}
if (isset($_POST["text_fr"])){
$text_fr = $_POST["text_fr"];
}
else{
$text_fr = false;
}
if (isset($_POST["text_it"])){
$text_it = $_POST["text_it"];
}
else{
$text_it = false;
}
if (isset($_POST["text_nl"])){
$text_nl = $_POST["text_nl"];
}
else{
$text_nl = false;
}
if (isset($_POST["text_sp"])){
$text_sp = $_POST["text_sp"];
}
else{
$text_sp = false;
}
if (isset($_POST["text_es"])){
$text_es = $_POST["text_es"];
}
else{
$text_es = false;
}

if (isset($_POST["unterschrift_de"])){
$unterschrift_de = $_POST["unterschrift_de"];
}
else{
$unterschrift_de =false;
}
if (isset($_POST["unterschrift_fr"])){
$unterschrift_fr = $_POST["unterschrift_fr"];
}
else{
$unterschrift_fr = false;
}
if (isset($_POST["unterschrift_en"])){
$unterschrift_en = $_POST["unterschrift_en"];
}
else{
$unterschrift_en = false;
}
if (isset($_POST["unterschrift_it"])){
$unterschrift_it = $_POST["unterschrift_it"];
}
else{
$unterschrift_it = false;
}
if (isset($_POST["unterschrift_nl"])){
$unterschrift_nl = $_POST["unterschrift_nl"];
}
else{
$unterschrift_nl = false;
}
if (isset($_POST["unterschrift_sp"])){
$unterschrift_sp = $_POST["unterschrift_sp"];
}
else{
$unterschrift_sp = false;
}
if (isset($_POST["unterschrift_es"])){
$unterschrift_es = $_POST["unterschrift_es"];
}
else{
$unterschrift_es=false;
}

if (isset($_POST["aktiviert"])){
	$aktiviert = $_POST["aktiviert"];
}
else{
	$aktiviert = -1;
}
if (isset($_POST["gaeste"])){
	$gaeste = $_POST["gaeste"];
}
else{
	$gaeste = false;
}
$art = $_POST["art"];
$sprache = getSessionWert(SPRACHE);
$standardsprache = getStandardSprache($unterkunft_id,$link);
$fehler = false;

//pruefen ob alle pflichtfelder eingegeben wurden:
if (
	 ($standardsprache == "de" && 
		($subject_de == false || 
		 $anrede_de == false || 
		 $text_de == false || 
		 $unterschrift_de == false) 
      )
      ||
      ($standardsprache == "en" && 
		($subject_en == false || 
		 $anrede_en == false || 
		 $text_en == false || 
		 $unterschrift_en == false) 
      )
      ||
      ($standardsprache == "fr" && 
		($subject_fr == false || 
		 $anrede_fr == false || 
		 $text_fr == false || 
		 $unterschrift_fr == false) 
      )
      ||
      ($standardsprache == "it" && 
		($subject_it == false || 
		 $anrede_it == false || 
		 $text_it == false || 
		 $unterschrift_it == false) 
      ) 
      ||
      ($standardsprache == "nl" && 
		($subject_nl == false || 
		 $anrede_nl == false || 
		 $text_nl == false || 
		 $unterschrift_nl == false) 
      ) 
      ||      
      ($standardsprache == "sp" && 
		($subject_sp == false || 
		 $anrede_sp == false || 
		 $text_sp == false || 
		 $unterschrift_sp == false) 
      )  
      ||
      ($standardsprache == "es" && 
		($subject_es == false || 
		 $anrede_es == false || 
		 $text_es == false || 
		 $unterschrift_es == false) 
      ) 
   ){
	$fehler = true;
	$message = getUebersetzung("Es wurden nicht alle Felder korrekt ausgefüllt!",$sprache,$link);
}
if($fehler == true){
	//zurueck zur eingabeseite:
	include_once("./texteAnzeigen.php");	
}
else{

if ($standardsprache == "de"){
	$subjectStandard = $subject_de;
	$anredeStandard = $anrede_de;
	$textStandard = $text_de;
	$unterschriftStandard = $unterschrift_de;
}
else if ($standardsprache == "en"){
	$subjectStandard = $subject_en;
	$anredeStandard = $anrede_en;
	$textStandard = $text_en;
	$unterschriftStandard = $unterschrift_en;
}
else if ($standardsprache == "fr"){
	$subjectStandard = $subject_fr;
	$anredeStandard = $anrede_fr;
	$textStandard = $text_fr;
	$unterschriftStandard = $unterschrift_fr;
}
else if ($standardsprache == "it"){
	$subjectStandard = $subject_it;
	$anredeStandard = $anrede_it;
	$textStandard = $text_it;
	$unterschriftStandard = $unterschrift_it;
}
else if ($standardsprache == "nl"){
	$subjectStandard = $subject_nl;
	$anredeStandard = $anrede_nl;
	$textStandard = $text_nl;
	$unterschriftStandard = $unterschrift_nl;
}
else if ($standardsprache == "sp"){
	$subjectStandard = $subject_sp;
	$anredeStandard = $anrede_sp;
	$textStandard = $text_sp;
	$unterschriftStandard = $unterschrift_sp;
}
else if ($standardsprache == "es"){
	$subjectStandard = $subject_es;
	$anredeStandard = $anrede_es;
	$textStandard = $text_es;
	$unterschriftStandard = $unterschrift_es;
}			
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
	
	if ($art != "emails"){
		
		$ownMail = $_POST["ownMail"];
		if ($ownMail == "true"){
			$ownMail = true;	
		}
		else{
			$ownMail = false;	
		}
		
		if ($art == "bestaetigung"){
			if ($ownMail){
				setProperty(MAIL_KOPIE_AN_VERMIETER_BESTAETIGUNG,"true",$unterkunft_id,$link);	
			}
			else{
				setProperty(MAIL_KOPIE_AN_VERMIETER_BESTAETIGUNG,"false",$unterkunft_id,$link);	
			}
		}
		else if ($art == "ablehnung"){
			if ($ownMail){
				setProperty(MAIL_KOPIE_AN_VERMIETER_ABLEHNUNG,"true",$unterkunft_id,$link);	
			}
			else{
				setProperty(MAIL_KOPIE_AN_VERMIETER_ABLEHNUNG,"false",$unterkunft_id,$link);	
			}
		}
		else if ($art == "anfrage"){
			if ($ownMail){
				setProperty(MAIL_KOPIE_AN_VERMIETER_ANFRAGE,"true",$unterkunft_id,$link);	
			}
			else{
				setProperty(MAIL_KOPIE_AN_VERMIETER_ANFRAGE,"false",$unterkunft_id,$link);	
			}
		}	
	
	//Änderungen durchführen:
	changeMessage($unterkunft_id,$art,$subjectStandard,$textStandard,$unterschriftStandard,$anredeStandard,$link);
	//auch die anderen sprachen:
	setUebersetzungUnterkunft($subject_de,$subjectStandard,"de",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($subject_en,$subjectStandard,"en",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($subject_fr,$subjectStandard,"fr",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($subject_it,$subjectStandard,"it",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($subject_nl,$subjectStandard,"nl",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($subject_sp,$subjectStandard,"sp",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($subject_es,$subjectStandard,"es",$standardsprache,$unterkunft_id,$link);

	setUebersetzungUnterkunft($text_de,$textStandard,"de",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($text_en,$textStandard,"en",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($text_fr,$textStandard,"fr",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($text_it,$textStandard,"it",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($text_nl,$textStandard,"nl",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($text_sp,$textStandard,"sp",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($text_es,$textStandard,"es",$standardsprache,$unterkunft_id,$link);
	
	setUebersetzungUnterkunft($unterschrift_de,$unterschriftStandard,"de",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($unterschrift_en,$unterschriftStandard,"en",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($unterschrift_fr,$unterschriftStandard,"fr",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($unterschrift_it,$unterschriftStandard,"it",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($unterschrift_nl,$unterschriftStandard,"nl",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($unterschrift_sp,$unterschriftStandard,"sp",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($unterschrift_es,$unterschriftStandard,"es",$standardsprache,$unterkunft_id,$link);
	
	setUebersetzungUnterkunft($anrede_de,$anredeStandard,"de",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($anrede_en,$anredeStandard,"en",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($anrede_fr,$anredeStandard,"fr",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($anrede_it,$anredeStandard,"it",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($anrede_nl,$anredeStandard,"nl",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($anrede_sp,$anredeStandard,"sp",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($anrede_es,$anredeStandard,"es",$standardsprache,$unterkunft_id,$link);
	
	//aktiviert oder nicht:
	if ($aktiviert == 0){
		setMessageInactive($unterkunft_id,$art,$link);
	}
	else{
		setMessageActive($unterkunft_id,$art,$link);
	}
	
?>
<table border="0" cellpadding="0" cellspacing="2">
  <tr>
    <td class="frei"><?php echo(getUebersetzung("Ihre automatische E-Mail-Antwort wurde erfolgreich verändert.",$sprache,$link)); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<br/>
<?php 
	} //ende wenn nicht emails.
	else{
	?>
	<table class="table" border="0" cellspacing="2" cellpadding="0">
    	   <tr>
      		<td><select name="gaeste[]" size="10">
			<?php
				//emails versenden:
				//array: gaeste mit gast_ids:
				$von = getUnterkunftEmail($unterkunft_id,$link);
				foreach ($gaeste as $gast_id){
				
					 $speech = getGuestSprache($gast_id,$link);
					 
					 $gastName = getGuestNachname($gast_id,$link);
					 $an = getGuestEmail($gast_id,$link);
					 
					 if ($speech == "fr") 		
					 	$subject = $subject_fr;
					 else if ($speech == "en")
					 	$subject = $subject_en;
					 else 
					 	$subject = $subject_de;
						
					 if ($speech == "fr") 		
					 	$anr = $anrede_fr;
					 else if ($speech == "en")
					 	$anr = $anrede_en;
					 else
					 	$anr = $anrede_de;
						
					 $message = $anr.(" ").($gastName).("!\n\n");
					 
					 if ($speech == "fr") 
					 	$bod = $text_fr;
					 else if ($speech == "en")
					 	$bod = $text_en;
					 else 
					 	$bod = $text_de;
						
					 $message .= $bod.("\n\n");
					 
					 if ($speech == "fr")
					 	$unt = $unterschrift_fr;
					 else if ($speech == "en")
					 	$unt = $unterschrift_en;
					 else
					 	$unt = $unterschrift_de;
					
					 $message .= $unt;		 
					 
					 ?><option><?php 
					 	echo(getUebersetzung("E-Mail an:",$sprache,$link)." ".$gastName." (".$an.") ... ");
					 	echo(getUebersetzung("erfolgreich gesendet",$sprache,$link)." ...<br/>"); 
					 	?></option><?php 
					 
					 //mail($an, $subject, $message, "From: $von\nReply-To: $von\nX-Mailer: PHP/" . phpversion());	
					 //mail($an, unhtmlentities($subject), unhtmlentities($message), "From: $von\nReply-To: $von\nX-Mailer: PHP/" . phpversion());
	  				 sendMail($von,$an,$subject,$message);	
			}
			?>
	  	</select></td>
    </tr>
  </table>
  <br/>
	<table border="0" cellpadding="0" cellspacing="2" class="tableColor">
	  <tr>
		<td><?php echo(getUebersetzung("Die E-Mails wurden versendet",$sprache,$link)); ?>!</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>
<br/>
<?php
	}	
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
 <?php
 } //ende kontrolle pflichtfelder
 ?>