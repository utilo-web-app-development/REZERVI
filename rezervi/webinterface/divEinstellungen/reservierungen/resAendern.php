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

if (isset($_POST["xDays"]) && $_POST["xDays"] > 0){
	$xDays = "".$_POST["xDays"];
}
else{
	$xDays = "0";
}
if (isset($_POST["resAnzeigen"]) && $_POST["resAnzeigen"] == "true"){
	$resAnzeigen = "true";
}
else{
	$resAnzeigen = "false";
}

if (isset($_POST["resHouse"]) && $_POST["resHouse"] == "true"){
	$resHouse = "true";
}
else{
	$resHouse = "false";
}

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

//save the properties:
setProperty(RES_HOUSE,$resHouse,$unterkunft_id,$link);
setProperty(SHOW_RESERVATION_STATE,$resAnzeigen,$unterkunft_id,$link);
setProperty(RESERVATION_STATE_TIME,$xDays,$unterkunft_id,$link);
  
    //Dieser Satz muss noch in die Sprachtabellen eingef�gt werden.
	$nachricht = "Die Änderungen wurden erfolgreich durchgeführt!";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
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
<div class="panel panel-default">
  	<div class="panel-body">
  		  <a class="btn btn-primary" href="./index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
  	</div>
  </div>
<div class="panel panel-default">
  <div class="panel-body">
<h1><?php echo(getUebersetzung("Einstellungen für Reservierungen",$sprache,$link)); ?>.</h1>
<?php 
if (isset($nachricht) && $nachricht != "")
{
?>
	
	<div class="alert alert-info" role="alert"
		<?php if (isset($fehler) && !$fehler) {echo("class=\"frei\"");} 
			else{ echo("class=\"belegt\""); }?>><?php echo($nachricht) ?>
	</div>

<?php 
}
?>

<!-- <?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zurück",$sprache,$link));
?> -->

<!-- <?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../../inhalt.php",getUebersetzung("Hauptmen�",$sprache,$link));
?> -->
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../../templates/end.php");  ?>