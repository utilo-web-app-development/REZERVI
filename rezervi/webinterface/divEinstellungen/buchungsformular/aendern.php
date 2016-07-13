<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

//datenbank öffnen:
include_once($root."/conf/rdbmsConfig.php");
//andere funktionen importieren:
include_once($root."/include/benutzerFunctions.php");
include_once($root."/include/unterkunftFunctions.php");
include_once($root."/include/propertiesFunctions.php");
include_once($root."/include/uebersetzer.php");	
include_once($root."/webinterface/templates/components.php"); 

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

?>

<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
<?php 
//passwortprüfung:	
if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
	
	$uebernachtung = false;
	$fruehstueck = false;
	$halbpension = false;
	$vollpension = false;
	if (isset($_POST["uebernachtung"])){
		$uebernachtung = $_POST["uebernachtung"];
	}	
	if (isset($_POST["fruehstueck"])){
		$fruehstueck = $_POST["fruehstueck"];
	}	
	if (isset($_POST["halbpension"])){
		$halbpension = $_POST["halbpension"];
	}	
	if (isset($_POST["vollpension"])){
		$vollpension = $_POST["vollpension"];
	}	
	
	//werte speichern:
	setProperty(PENSION_UEBERNACHTUNG,$uebernachtung,$unterkunft_id,$link);
	setProperty(PENSION_FRUEHSTUECK,$fruehstueck,$unterkunft_id,$link);
	setProperty(PENSION_HALB,$halbpension,$unterkunft_id,$link);
	setProperty(PENSION_VOLL,$vollpension,$unterkunft_id,$link);
	
	$nachricht = getUebersetzung("Die Änderungen wurden erfolgreich durchgeführt.",$sprache,$link);
		
?>
<div class="panel panel-default">
  <div class="panel-body">
  	
<h1><?php echo(getUebersetzung("Einstellungen für das Buchungsformular",$sprache,$link)); ?>.</h1>
<?php 
if (isset($nachricht) && $nachricht != ""){
?>
	<table  border="0" cellpadding="0" cellspacing="3" class="frei">
	  <tr>
		<td><?php echo($nachricht) ?></td>
	  </tr>
	</table>
	<br/>
<?php 
}
?>
<br/>
<!-- <?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zurück",$sprache,$link));
?>
<br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../../inhalt.php",getUebersetzung("Hauptmenü",$sprache,$link));
?> -->
<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 include_once("../../templates/end.php"); 
 ?>