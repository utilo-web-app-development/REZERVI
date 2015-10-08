<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
//�ndern der angezeigten sprachen:

//variablen initialisieren:
$standardsprache = $_POST["standardsprache"];
$standardspracheBelegungsplan = $_POST["standardspracheBelegungsplan"];
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$jetztWechseln = $_POST["jetztWechseln"];

//datenbank �ffnen:
include_once("../../../conf/rdbmsConfig.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../templates/components.php");

//kontrolle ob �berhaupt eine sprache ausgew�hlt wurde:
if (!isset($standardsprache) || $standardsprache == "" || !isset($standardspracheBelegungsplan) || $standardspracheBelegungsplan == ""){
	$nachricht = "Sie m�ssen mindestens eine Sprache ausw�hlen!";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	include_once("./index.php");
}
else{
	
	setStandardSprache($unterkunft_id,$standardsprache,$link);
	setStandardSpracheBelegungsplan($unterkunft_id,$standardspracheBelegungsplan,$link);
	if (isset($jetztWechseln) && $jetztWechseln == "true"){
		
		setSessionWert(SPRACHE,$standardsprache);
		$sprache = $standardsprache;
	}
	$nachricht = "Die Standard-Sprache wurde erfolgreich ge�ndert!";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	
}

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
		<td class="frei"><?php echo($nachricht) ?></td>
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
 <?php include_once("../../templates/end.php"); ?>