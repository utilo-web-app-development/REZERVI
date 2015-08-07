<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
//datenbank �ffnen:
include_once("../../../conf/rdbmsConfig.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/propertiesFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../templates/components.php");

//variablen initialisieren:

if (isset($_POST["showSamstag"])){
	$showSamstag = $_POST["showSamstag"];
}
else{
	$showSamstag = false;
}
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

  setProperty(SHOW_OTHER_COLOR_FOR_SA,$showSamstag,$unterkunft_id,$link);

  
    //Dieser Satz muss noch in die Sprachtabellen eingef�gt werden.
	$nachricht = "Die �nderungen wurden erfolgreich durchgef�hrt!";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	$nachricht2 = "Um die Farbe des Samstages zu �ndern m�ssen sie [Design bearbeiten] aufrufen und die Hintergrundfarben zu [Samstag belegt] und [Samstag frei] �ndern.";
	$nachricht2 = getUebersetzung($nachricht2,$sprache,$link);
	$nachricht .= "<br/>".$nachricht2;
	$fehler = false;

?>
<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php");?>
<?php include_once("../../templates/bodyA.php");?>
<?php 
	//passwortpr�fung:	
if (checkPass($benutzername,$passwort,$unterkunft_id,$link))
{
?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("Einstellungen f�r den Belegungsplan",$sprache,$link)); ?>.</p>
<?php 
if (isset($nachricht) && $nachricht != "")
{
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
//} ende else-schleife
 ?>