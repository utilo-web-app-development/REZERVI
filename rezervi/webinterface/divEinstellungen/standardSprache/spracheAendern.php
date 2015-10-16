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
	$nachricht = "Sie müssen mindestens eine Sprache auswählen!";
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
	$nachricht = "Die Standard-Sprache wurde erfolgreich geändert!";
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
<h1><?php echo(getUebersetzung("Ändern der angezeigten Sprachen",$sprache,$link)); ?>.</h1>

<div class="panel panel-default">
  <div class="panel-body">
    <a class="btn btn-primary" href="../standardSprache/index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-body">
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
<!-- <?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zurück",$sprache,$link));
?>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../../inhalt.php",getUebersetzung("Hauptmenü",$sprache,$link));
?> -->
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../../templates/end.php"); ?>