<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
//�ndern der angezeigten sprachen:

//variablen initialisieren:
if (isset($_POST["de"]))
	$de	= $_POST["de"];
else
	$de = false;
if (isset($_POST["en"]))
	$en	= $_POST["en"];
else
	$en = false;
if (isset($_POST["fr"]))
	$fr	= $_POST["fr"];
else
	$fr = false;
if (isset($_POST["it"]))
	$it	= $_POST["it"];
else
	$it = false;
if (isset($_POST["nl"]))
	$nl	= $_POST["nl"];
else
	$nl = false;	
if (isset($_POST["sp"]))
	$sp	= $_POST["sp"];
else 
	$sp = false;
if (isset($_POST["es"]))
	$es	= $_POST["es"];
else
	$es = false;

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

//datenbank �ffnen:
include_once("../../../conf/rdbmsConfig.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../templates/components.php");

//kontrolle ob �berhaupt eine sprache ausgew�hlt wurde:
if ($de != "true" && $en != "true" && $fr != "true" 
	&& $it != "true" && $nl != "true" && $sp != "true" && $es != "true"){
	$nachricht = "Sie müssen mindestens eine Sprache auswählen!";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	$fehler = true;
	include_once("sprachen.php");
}
else{
	
	//zuerst alle alten eintraege l�schen:
	removeAllStandardSpracheFromModul($unterkunft_id,2,$link);
	
	if ($de == "true"){
		setSprache($unterkunft_id,"de",2,$link);
	}	
	if ($en == "true"){
		setSprache($unterkunft_id,"en",2,$link);
	}
	if ($fr == "true"){
		setSprache($unterkunft_id,"fr",2,$link);
	}
	if ($it == "true"){
		setSprache($unterkunft_id,"it",2,$link);
	}
	if ($nl == "true"){
		setSprache($unterkunft_id,"nl",2,$link);
	}
	if ($sp == "true"){
		setSprache($unterkunft_id,"sp",2,$link);
	}
	if ($es == "true"){
		setSprache($unterkunft_id,"es",2,$link);
	}
	
	
	$nachricht = "Die angezeigten Sprachen wurden erfolgreich geändert!";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	$fehler = false;

?>
<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
<?php 
	//passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("Ändern der angezeigten Sprachen",$sprache,$link)); ?>.</p>
<?php 
if (isset($nachricht) && $nachricht != ""){
?>
	<table  border="0" cellpadding="0" cellspacing="3">
	  <tr>
		<td <?php if (isset($fehler) && !$fehler) {echo("class=\"frei\"");} else{ echo("class=\"belegt\""); }?>><?php echo($nachricht) ?></td>
	  </tr>
	</table>
	<br/>
<?php 
}
?>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zur�ck",$sprache,$link));
?>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../../inhalt.php",getUebersetzung("Hauptmen�",$sprache,$link));
?>
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../../templates/end.php"); 
}
 ?>