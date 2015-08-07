<?php $root="../..";

include_once($root."/templates/header.inc.php");
include_once($root."/include/mail.inc.php");

$ansicht = $_POST["ansicht"];
$tag=$_POST["tag"];
$monat=$_POST["monat"];
$jahr=$_POST["jahr"];
$mietobjekt_id = $_POST["mietobjekt_id"];

//variablen initialisieren:
$name = $_POST["name"];
$email = $_POST["email"];
$telefon = $_POST["telefon"];		
$ihreNachricht = $_POST["ihreNachricht"];

$fehler = false;
if (empty($name)){
	$fehler = true;
	$nachricht = "Bitte geben sie ihren Namen ein.";
}
else if (empty($ihreNachricht)){
	$fehler = true;
	$nachricht = "Bitte geben sie ihre Nachricht ein.";
}
else if (empty($email)){
	$fehler = true;
	$nachricht = "Bitte geben sie ihre E-Mail-Adresse ein.";
}
else if (checkMailAdress($email) === false){
	$fehler = true;
	$nachricht = "Bitte pr�fen sie ihre E-Mail-Adresse, es handelt sich um eine ung�ltige Adresse.";
}	

if ($fehler === true){
	$nachricht = getUebersetzung($nachricht);
	include_once("./anfragePerEMail.php");	
	exit;
}
      				
 $von = $email;
 $subject = getUebersetzung("Anfrage aus dem Bookline Buchungssystem");
 $message = getUebersetzung("Anfrage von").": ".$name."\n";
 $message = $message.getUebersetzung("E-Mail-Adresse").": ".$email."\n";
 if (!empty($telefon)){
 	$message = $message.getUebersetzung("Telefonnummer").": ".$telefon."\n";
 }
 $message = $message."\n".getUebersetzung("Anfragetext").": \n".$ihreNachricht;
 
 $spracheBezeichnung = getBezeichnungOfSpracheID($sprache);	
 $message = $message."\n\n".getUebersetzung("Die Anfrage wurde in $spracheBezeichnung gestellt").".";
						
 //e-mail-adresse aus datenbank holen:
 $an = getVermieterEmail($gastro_id);       
 	
  
  //mail absenden:      
 sendMail($von,$an,$subject,$message);
		
 include_once($root."/templates/bodyStart.inc.php"); 		
?>
<table border="0" cellspacing="3" cellpadding="0" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td><?php echo(getUebersetzung("Die Nachricht wurde versendet. <br/> Danke f�r Ihre Anfrage!")); ?></td>
  </tr>
</table>
<br/>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td>
    	<form action="<?= $root ?>/start.php" method="post" name="form1">	
			<input name="jahr" type="hidden" value="<?php echo($jahr); ?>"/>
			<input name="monat" type="hidden" value="<?php echo($monat); ?>"/>
			<input name="tag" type="hidden" id="monat" value="<? echo($tag); ?>"/>
			<input name="ansicht" type="hidden" id="ansicht" value="<? echo($ansicht); ?>"/>
			<input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<? echo($mietobjekt_id); ?>"/>			
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
