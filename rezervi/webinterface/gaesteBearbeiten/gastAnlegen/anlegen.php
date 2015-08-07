<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
	reservierungsplan
	gast-infos anzeigen und evt. ändern:
	author: christian osterrieder utilo.eu
			
	dieser seite muss übergeben werden:
	Gast PK_ID $gast_id
	$unterkunft_id
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
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
$speech = $_POST["speech"];
$anmerkungen = $_POST["anmerkungen"];
$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");

//funktions einbinden:
include_once("../../../include/unterkunftFunctions.php");
//uebersetzer einfuegen:
include_once("../../../include/uebersetzer.php");
include_once("../../../include/gastFunctions.php");
include_once("../../../include/benutzerFunctions.php");	
	
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
	//nachsehen ob der gast bereits existiert:
	$gast_id = getGuestIDDetail($unterkunft_id,$vorname,$nachname,$strasse,$ort,$link);	
	
	//1. gast ist neu:
	if ($gast_id == -1) {
		$gast_id = insertGuest($unterkunft_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$fax,$anmerkungen,$speech,$link);	
		?>
		<table class="frei"><tr><td><?php echo(getUebersetzung("Der Gast wurde neu angelegt und erfolgreich in der Datenbank gespeichert",$sprache,$link)); ?>!</td></tr></table>
		<?php
	}
	else{//2. gast ist bereits vorhanden und wurde gändert
		updateGuest($gast_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$fax,$anmerkungen,$speech,$link);	
		?>
		<table class="belegt"><tr><td><?php echo(getUebersetzung("Ein Gast mit denselben Daten existiert bereits, die Daten wurden ergänzt bzw. korregiert",$sprache,$link)); ?>.</td></tr></table>
		<?php
	}
		
?>
<br/><table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><form action="./index.php" method="post" name="form1" target="_self">
        <input name="nochmal" type="submit" class="button200pxA" id="nochmal" 
			onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("einen weiteren Gast anlegen",$sprache,$link)); ?>">
    </form></td>
  </tr>
</table>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><form action="../index.php" method="post" name="form1" target="_self">
        <input name="zurueck" type="submit" class="button200pxA" id="zurueck" 
			onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
    </form></td>
  </tr>
</table>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><form action="../../inhalt.php" method="post" name="form1" target="_self">
        <input name="hauptmenue" type="submit" class="button200pxA" id="hauptmenue" 
			onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>">
    </form></td>
  </tr>
</table>
<?php } //ende passwortprüfung 
	else{
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
		}
?>
</body>
</html>
