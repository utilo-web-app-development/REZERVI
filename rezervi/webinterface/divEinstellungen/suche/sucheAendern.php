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
if (isset($_POST["Kinder"])){
	$kinder_wert = $_POST["Kinder"];
}
if (!isset($kinder_wert) || $kinder_wert != "true"){
	$kinder_wert = "false";
}
$kinder = KINDER_SUCHE;

if (isset($_POST["Haustiere"])){
	$haustiere_wert = $_POST["Haustiere"];
}
if (!isset($haustiere_wert) || $haustiere_wert != "true"){
	$haustiere_wert = "false";
}
$haustiere = HAUSTIERE_ALLOWED;

if (isset($_POST["Link"])){
	$link_wert = $_POST["Link"];
}
if (!isset($link_wert) || $link_wert != "true"){
	$link_wert = "false";
}
$linkName = LINK_SUCHE;

if (isset($_POST["showParent"]) && $_POST["showParent"] == "true"){
	$showParent = "true";
}
else{
	$showParent = "false";
}


$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$suchFilter = $_POST["suchFilter"];

//Properties f�r eine bestimmte Unterkunft setzen!
  setProperty($kinder,$kinder_wert,$unterkunft_id,$link);
  setProperty($haustiere,$haustiere_wert,$unterkunft_id,$link);
  setProperty($linkName,$link_wert,$unterkunft_id,$link);
  setProperty(SEARCH_SHOW_PARENT_ROOM,$showParent,$unterkunft_id,$link);
  
  if ($suchFilter == "filterZimmer"){
  	setProperty(SUCHFILTER_ZIMMER,"true",$unterkunft_id,$link);
	setProperty(SUCHFILTER_UNTERKUNFT,"false",$unterkunft_id,$link);
  }
  else{
  	setProperty(SUCHFILTER_UNTERKUNFT,"true",$unterkunft_id,$link);
	setProperty(SUCHFILTER_ZIMMER,"false",$unterkunft_id,$link);
  }
  
    //Dieser Satz muss noch in die Sprachtabellen eingef�gt werden.
	$nachricht = "Die Suchoptionen wurden erfolgreich geändert!";
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
<h1><?php echo(getUebersetzung("Ändern der Suchoptionen",$sprache,$link)); ?>.</h1>
<?php 
if (isset($nachricht) && $nachricht != "")
{
?>
	
	
		<<?php if (isset($fehler) && !$fehler) {echo("class=\"frei\"");} else{ echo("class=\"belegt\""); }?>><?php echo($nachricht) ?>



<?php 
}
?>
<br/>
<!-- <?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zur�ck",$sprache,$link));
?>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../../inhalt.php",getUebersetzung("Hauptmen�",$sprache,$link));
?> -->
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../../templates/end.php"); 
//} ende else-schleife
 ?>