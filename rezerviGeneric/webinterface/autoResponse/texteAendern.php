<?php $root = "../..";

/*   
	date: 7.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
	
include_once("../../include/mieterFunctions.inc.php");
include_once("../../include/autoResponseFunctions.inc.php");
include_once("../templates/components.inc.php"); 
include_once("../../include/vermieterFunctions.inc.php");

$standardsprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);

$art = $_POST["art"];

	$anredeArray = array();
	$subjectArray = array();
	$textArray = array();
	$unterschriftArray = array();
	
	$res = getActivtedSprachenOfVermieter($vermieter_id);
	while ($d = mysqli_fetch_array($res)){
		$sprache_id = $d["SPRACHE_ID"];
		$bezeichnung= $d["BEZEICHNUNG"];
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
				//Änderungen durchführen:
				changeMessage($vermieter_id,$art,$subjectStandard,$textStandard,$unterschriftStandard,$anredeStandard);	
			}
					
		}
		
						
		$anredeArray[$sprache_id]=$anrede;
		$subjectArray[$sprache_id] = $subject;
		$textArray[$sprache_id]=$text;
		$unterschriftArray[$sprache_id] = $unterschrift;	
	
	} //ende while aktivierte sprachen

	if ($art != NEWSLETTER){
		$aktiviert = $_POST["aktiviert"];	
		//anrede fuer andere sprachen speichern:	
		foreach ($anredeArray as $sprache_id => $anrede){
			setUebersetzungVermieter($anrede,$anredeStandard,$sprache_id,$standardsprache,$vermieter_id);
		}
		//subject fuer andere sprachen speichern:	
		foreach ($subjectArray as $sprache_id => $subject){
			setUebersetzungVermieter($subject,$subjectStandard,$sprache_id,$standardsprache,$vermieter_id);
		}
		foreach ($textArray as $sprache_id => $text){
			setUebersetzungVermieter($text,$textStandard,$sprache_id,$standardsprache,$vermieter_id);
		}
		foreach ($unterschriftArray as $sprache_id => $unterschrift){
			setUebersetzungVermieter($unterschrift,$unterschriftStandard,$sprache_id,$standardsprache,$vermieter_id);
		}
			
		//aktiviert oder nicht:
		if ($aktiviert == 0){
			setMessageInactive($vermieter_id,$art);
		}
		else{
			setMessageActive($vermieter_id,$art);
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
	
	include_once($root."/webinterface/templates/bodyStart.inc.php");
	
if ($art != NEWSLETTER){
?>
<table border="0" cellpadding="0" cellspacing="2" class="<?php echo FREI ?>">
  <tr>
    <td><?php echo(getUebersetzung("Ihre automatische E-Mail-Antwort wurde erfolgreich verändert.")); ?></td>
  </tr>
</table>
<br/>
<?php 
} //ende wenn nicht emails.
else{
		
?>
	<table class="<?php echo TABLE_STANDARD ?>" border="0" cellspacing="2" cellpadding="0">
	   <tr>
  		<td><select name="mieter[]" size="10">
		<?php
			//emails versenden:
			$von = getVermieterEmail($vermieter_id);
			foreach ($mieter as $mieter_id){
			
				 $speech = getSpracheOfMieter($mieter_id);					 
				 $gastName = getNachnameOfMieter($mieter_id);
				 $an = getEmailOfMieter($mieter_id);
				 
				 $res = getActivtedSprachenOfVermieter($vermieter_id);
				 while ($d = mysqli_fetch_array($res)){
					$sprache_id = $d["SPRACHE_ID"];
					$bezeichnung= $d["BEZEICHNUNG"];
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
	<table border="0" cellpadding="0" cellspacing="2" class="<?php echo FREI ?>">
	  <tr>
		<td><?php echo(getUebersetzung("Die E-Mails wurden erfolgreich versendet")); ?>!</td>
	  </tr>
	</table>
<br/>
<?php
	}	
	showSubmitButtonWithForm("./index.php",getUebersetzung("zurück"));
	
include_once($root."/webinterface/templates/footer.inc.php");
?>