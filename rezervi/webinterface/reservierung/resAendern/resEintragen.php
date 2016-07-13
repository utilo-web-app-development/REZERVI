<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
	reservierungsplan
	eintragen einer reservierung
	author: christian osterrieder utilo.eu
*/	

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);
$gast_id = $_POST["gast_id"];
$zimmer_id = $_POST["zimmer_id"];
$status = $_POST["status"];
$vonTag = $_POST["vonTag"];
$bisTag = $_POST["bisTag"];
$vonMonat = $_POST["vonMonat"];
$bisMonat = $_POST["bisMonat"];
$vonJahr = $_POST["vonJahr"];
$bisJahr = $_POST["bisJahr"];
	
if ($gast_id != 1){ //1= anonymer gast

	$pension = $_POST["zusatz"]; 
	$anzahlErwachsene = $_POST["anzahlErwachsene"];
	$anzahlKinder = $_POST["anzahlKinder"];
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
	//$mob = $_POST["mob"];
	$speech = $_POST["speech"];
	$anmerkung = $_POST["anmerkungen"];
	
}
else{
	$anzahlErwachsene = 1;
	$anzahlKinder = 0;
	$pension = "";
}
	
//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");
//andere "include_onces" einfügen:
include_once("../../../include/gastFunctions.php");
include_once("../../../include/reservierungFunctions.php");			
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/benutzerFunctions.php");		
include_once("../../../include/uebersetzer.php");

?>
<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
<?php		
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ ?>
<?php 

	//anonymen gast eintragen:
	if ($gast_id == 1){
		//do nothing
	}		
	//2. gast ist neu:
	else if ($gast_id == -1) {
		$gast_id = insertGuest($unterkunft_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$fax,$anmerkung,$speech,$link);	
	}
	else{//3. gast ist bereits vorhanden und wurde gändert
		updateGuest($gast_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$fax,$anmerkung,$speech,$link);	
	}	
	
	//reservierung eintragen:
	//wenn bereits eine reservierung in dem geforderten zeitraum vorhanden ist,
	//muss diese upgedatet werden!
	//mach mas so: zuerst alle reservierungen in diesem zeitraum vernichten und
	//dann einfach neu eintragen...wird alles von funktion insertReservation erledigt:	
	insertReservation($zimmer_id,$gast_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$status,$anzahlErwachsene,$anzahlKinder,$pension,$link);

?>
<table  border="0" cellpadding="0" cellspacing="3" class="table">
  <tr>
    <td><p class="frei"><?php echo(getUebersetzung("Die Reservierung/Belegung wurde erfolgreich geändert",$sprache,$link)); ?>!</p>
      <table border="0" cellpadding="0" cellspacing="0" class="tableColor">
        <tr> 
          <td><?php echo(getUebersetzung("eingetragenes Datum",$sprache,$link)); ?>:</td>
          <td><?php echo(getUebersetzung("von",$sprache,$link)); ?> <?php echo($vonTag.".".$vonMonat.".".$vonJahr); ?> <?php echo(getUebersetzung("bis",$sprache,$link)); ?> <?php echo($bisTag.".".$bisMonat.".".$bisJahr);?> </td>
        </tr>
        <tr> 
          <td><?php echo(getUebersetzung("Status",$sprache,$link)); ?>:</td>
          <td><span class="<?php 
					//status = 0: frei
					//status = 1: reserviert
					//status = 2: belegt
					if ($status == 0)
						echo("frei");
					elseif ($status == 1)
						echo("reserviert");
					elseif ($status == 2)
						echo("belegt");
				?>"><?php if ($status == 0)
		  				echo(getUebersetzung("frei",$sprache,$link));
					elseif ($status == 1)
						echo(getUebersetzung("reserviert",$sprache,$link));
					else 
						echo(getUebersetzung("belegt",$sprache,$link));
				?></span></td>
        </tr>
        <tr>
          <td><?php echo(getUebersetzung("Gast",$sprache,$link)); ?>:</td>
          <td><?php echo(getGuestNachname($gast_id,$link)); ?></td>
        </tr>
      </table>
      </td>
  </tr>
</table>
<br/>
<form action="../ansichtWaehlen.php" method="post" name="form1" target="_self">
  
  <table border="0" cellspacing="3" cellpadding="0" class="table">
    <tr>
      <td>
        <input name="monat" type="hidden" id="monat" value="<?php echo($vonMonat); ?>"> 
        <input name="jahr" type="hidden" id="jahr" value="<?php echo($vonJahr) ?>">
		<input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo($zimmer_id); ?>"> 
        <input type="submit" name="Submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>"> </td>
    </tr>
  </table>
  <p>&nbsp; </p>
  </form>
<?php } //ende passwortprüfung 
	else{
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
		}
?>
</BODY>
</HTML>
