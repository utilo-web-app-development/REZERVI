<?php session_start();
$root = "..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

/*   
			reservierungsplan
			versenden einer nachricht an den Benutzer
			author: christian osterrieder utilo.eu						
			
*/ 
//funktionen zum versenden von e-mails:
include_once($root."/include/mail.inc.php");

//variablen initialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$name = $_POST["name"];
$email = $_POST["email"];
$telefon = $_POST["telefon"];		
$fax = $_POST["fax"];
$nachricht = $_POST["nachricht"];
$zimmer_id = $_POST["zimmer_id"];
$jahr = $_POST["jahr"];
$monat = $_POST["monat"];

include_once("../include/unterkunftFunctions.php");
include_once("../include/uebersetzer.php");
		
?>

<html>
<head>
<title>Reservierungssystem Mail versenden</title>
<meta http-equiv="Content-Type" content="text/html;"> 
<meta charset="utf-8">
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
</head>

<body class="backgroundColor">
<p class="ueberschrift"><?php echo(getUnterkunftName($unterkunft_id,$link)) ?></p>
<?php 	 
        				
         $von = $email;
		 $subject = getUebersetzung("Buchungsanfrage aus dem Rezervi Buchungssystem",$sprache,$link);
		 if ($name != "")
         	$message = getUebersetzung("Anfrage von",$sprache,$link).":    ".$name."\n";
		 if ($email != "")
		 	$message = $message.getUebersetzung("E-Mail-Adresse",$sprache,$link).": ".$email."\n";
		 if ($telefon != "")
		 	$message = $message.getUebersetzung("Telefonnummer",$sprache,$link).":  ".$telefon."\n";
		 if ($fax != "")
		 	$message = $message.getUebersetzung("Faxnummer",$sprache,$link).":      ".$fax."\n";
		 if ($nachricht != "")
		 	$message = $message."\n".getUebersetzung("Anfragetext",$sprache,$link).": \n".$nachricht;
		 	
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
		 	$message = $message."\n".getUebersetzung("Die Anfrage wurde in holländischer Sprache gestellt",$sprache,$link).".";
		 }
		 else{
			$message = $message."\n".getUebersetzung("Die Anfrage wurde in deutscher Sprache gestellt",$sprache,$link).".";
		 }							
		 
		 //e-mail-adresse aus datenbank holen:
		 $query = "select Email from Rezervi_Unterkunft where PK_ID = '$unterkunft_id'";

  		 $res = mysqli_query($link, $query);
  			if (!$res)
  				echo("Anfrage $query scheitert.");
					
		 $d = mysqli_fetch_array($res);
		 $an = $d["Email"];       
         	
  
    //mail absenden:     
	sendMail($von,$an,$subject,$message); 
	  
   ?>
<table border="0" cellspacing="3" cellpadding="0" class="tableColor">
  <tr>
    <td><?php echo(getUebersetzung("Danke für Ihre Anfrage!",$sprache,$link)); ?></td>
  </tr>
</table>
<br/>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td><form action="../ansichtWaehlen.php" method="post" name="form1" target="_self">	
			<input name="zimmer_id" type="hidden" value="<?php echo($zimmer_id); ?>">
			<input name="jahr" type="hidden" value="<?php echo($jahr); ?>">
			<input name="monat" type="hidden" value="<?php echo($monat); ?>">			
        <input type="submit" name="Submit" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';">
      </form></td>
  </tr>
</table>
</BODY>
</HTML>
