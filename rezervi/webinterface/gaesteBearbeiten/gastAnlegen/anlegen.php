<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
	reservierungsplan
	gast-infos anzeigen und evt. �ndern:
	author: christian osterrieder utilo.eu
			
	dieser seite muss �bergeben werden:
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

//datenbank �ffnen:
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
	//passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ ?>
<?php 
	//nachsehen ob der gast bereits existiert:
	$gast_id = getGuestIDDetail($unterkunft_id,$vorname,$nachname,$strasse,$ort,$link);	
	
	//1. gast ist neu:
	if ($gast_id == -1) {
		$gast_id = insertGuest($unterkunft_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$fax,$anmerkungen,$speech,$link);	
		?>
		<div class="alert alert-info" role="alert">
		<?php echo(getUebersetzung("Der Gast wurde neu angelegt und erfolgreich in der Datenbank gespeichert",$sprache,$link)); ?>!</div>
		<?php
	}
	else{//2. gast ist bereits vorhanden und wurde g�ndert
		updateGuest($gast_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$fax,$anmerkungen,$speech,$link);	
		?>
		<div class="alert alert-info" role="alert">
		<?php echo(getUebersetzung("Ein Gast mit denselben Daten existiert bereits, die Daten wurden ergänzt bzw. korregiert",$sprache,$link)); ?>.</div>
		<?php
	}
		
?>
<div class="panel panel-default">
  	<div class="panel-body">
  		<a class="btn btn-primary" href="../index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
	</div>
</div>

  <div class="panel panel-default">
  <div class="panel-body">
  	
<form action="./index.php" method="post" name="form1" target="_self">
        <input name="nochmal" type="submit" class="btn btn-success" id="nochmal" 
			 value="<?php echo(getUebersetzung("einen weiteren Gast anlegen",$sprache,$link)); ?>">
 </form>
  
  
<?php } //ende passwortpr�fung 
	else{
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
		}
?>
</body>
</html>
