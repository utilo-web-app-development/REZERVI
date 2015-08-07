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
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/autoResponseFunctions.inc.php");
include_once($root."/backoffice/templates/components.inc.php"); 
include_once($root."/include/vermieterFunctions.inc.php");

$breadcrumps = erzeugenBC($root, $ueberschrift, "autoResponse/index.php",
						"Text Ändern", "");

$art = $_GET["art"];
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
$standardsprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
$subjectStandard = 	getUebersetzungGastro($betreffStandard,$standardsprache,$gastro_id);
$anredeStandard = 	getUebersetzungGastro($anredeStandard,$standardsprache,$gastro_id);
$textStandard = getUebersetzungGastro($textStandard,$standardsprache,$gastro_id);
$unterschriftStandard = getUebersetzungGastro($unterschriftStandard,$standardsprache,$gastro_id);

	$anredeArray = array();
	$subjectArray = array();
	$textArray = array();
	$unterschriftArray = array();
	
	$res = getActivtedSprachenOfVermieter($gastro_id);
//	while ($d = $res->FetchNextObject()){
//		$sprache_id = $d->SPRACHE_ID;
    	$sprache_id = getSessionWert(SPRACHE);
    	$bezeichnung =  getBezeichnungOfSpracheID($sprache_id);
		$subject = "";
		$anrede = "";
		$text = "";
		$unterschrift = "";
		if (isset($_POST["subject_".$sprache_id])){
			$subject = $_POST["subject_".$sprache_id];
		}	
		if (isset($_POST["anrede_".$sprache_id])){
			$anrede = $_POST["anrede_".$sprache_id];
		}
		if (isset($_POST["text_".$sprache_id])){
			$text = $_POST["text_".$sprache_id];
		}
		if (isset($_POST["unterschrift_".$sprache_id])){
			$unterschrift = $_POST["unterschrift_".$sprache_id];
		}
		if ($standardsprache == $sprache_id && 
			($subject == "" || 
			 $anrede == "" || 
			 $text == "" || 
			 $unterschrift == "") ){
			$fehler = true;
			$nachricht = getUebersetzung("Es wurden nicht alle Felder der Standardsprache korrekt ausgefüllt!");	
			include_once("./texteAnzeigen.php");
			exit;	
		}
		if ($art != NEWSLETTER){
			if ($standardsprache == $sprache_id){
				$subjectStandard = $subject;
				$anredeStandard = $anrede;
				$textStandard = $text;
				$unterschriftStandard = $unterschrift;	
				//Änderungen durchführenchangeMessage($gastro_id,$subject,$body,$unterschrift,$anrede,$aktiv,$art)
				changeMessage($gastro_id,$subjectStandard,$textStandard,$unterschriftStandard,$anredeStandard,0,$art);	
			}
			
		}
		
		$anredeArray[$sprache_id]=$anrede;
		$subjectArray[$sprache_id] = $subject;
		$textArray[$sprache_id]=$text;
		$unterschriftArray[$sprache_id] = $unterschrift;
	
//	} //ende while aktivierte sprachen

	if ($art != NEWSLETTER){
		$aktiviert = $_POST["aktiviert"];	
		//anrede fuer andere sprachen speichern:	
		foreach ($anredeArray as $sprache_id => $anrede){
			setUebersetzungVermieter($anrede,$anredeStandard,$sprache_id);
		}
		//subject fuer andere sprachen speichern:	
		foreach ($subjectArray as $sprache_id => $subject){
			setUebersetzungVermieter($subject,$subjectStandard,$sprache_id);
		}
		foreach ($textArray as $sprache_id => $text){
			setUebersetzungVermieter($text,$textStandard,$sprache_id);
		}
		foreach ($unterschriftArray as $sprache_id => $unterschrift){
			setUebersetzungVermieter($unterschrift,$unterschriftStandard,$sprache_id);
		}
			
		//aktiviert oder nicht:
		if ($aktiviert == 0){
			setMessagesInactive($gastro_id,$art);
		}
		else{
			setMessagesActive($gastro_id,$art);
		}
	}
	
if ($art == NEWSLETTER){

	if (isset($_POST["mieter"])){
		$mieter = $_POST["mieter"];
	}
	else {
		$mieter = false;
	}
	
	if (empty($mieter) || count($mieter)<1){
			
		$fehler = true;
		$nachricht = getUebersetzung("Es wurden keine Mieter ausgewählt!");	
		include_once("./texteAnzeigen.php");
		exit;	
	
	}
}
	
if ($art != NEWSLETTER){
	$info = true;
	$nachricht = getUebersetzung("Ihre automatische E-Mail-Antwort wurde erfolgreich verändert."); 
	include_once("./index.php");
	exit;
} //ende wenn nicht emails.
else{	
	include_once($root."/backoffice/templates/bodyStart.inc.php");	
?>
	<table>
	   <tr>
  		<td><select name="mieter[]" size="10">
		<?php
			//emails versenden:
			$von = getVermieterEmail($gastro_id);
			foreach ($mieter as $mieter_id){
			
				 $speech = getSpracheOfMieter($mieter_id);					 
				 $gastName = getNachnameOfMieter($mieter_id);
				 $an = getEmailOfMieter($mieter_id);
				 
				 $res = getActivtedSprachenOfVermieter($gastro_id);
				 while ($d = $res->FetchNextObject()){
					$sprache_id = $d->SPRACHE_ID;
					$bezeichnung= $d->BEZEICHNUNG;
					if ($speech == $sprache_id){
						$subject = $subjectArray[$sprache_id];
						$anrede  = $anredeArray[$sprache_id];
						$message = $anrede.(" ").($gastName).("!\n\n");
						$body    = $textArray[$sprache_id];
						$message .= $body.("\n\n");
						$unterschrift = $unterschriftArray[$sprache_id];
						$message .= $unterschrift;
						break;
					}					
				 }				 		 
				 
			 ?><option><?php 
			 	echo(getUebersetzung("E-Mail an:")." ".$gastName." (".$an.") ... ");
			 	echo(getUebersetzung("erfolgreich gesendet")." ...<br/>"); 
			 ?></option><?php 
			 
			 //mail($an, $subject, $message, "From: $von\nReply-To: $von\nX-Mailer: PHP/" . phpversion());	
			 include_once($root."/include/mail.inc.php");
			 sendMail($von,$an,$subject,$message);
		}
		?>
	  	</select></td>
    </tr>
  </table>
  <br/>
	<table class="frei">
	  <tr>
		<td><?php echo(getUebersetzung("Die E-Mails wurden erfolgreich versendet")); ?>!</td>
	  </tr>
	</table>
   <br/>
<?php
}	

include_once($root."/backoffice/templates/footer.inc.php");
?>