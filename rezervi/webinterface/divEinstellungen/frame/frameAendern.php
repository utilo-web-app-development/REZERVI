<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
//Ändern der angezeigten sprachen:

//variablen initialisieren:
$artRightWI = $_POST["artRightWI"];
$artRightBP = $_POST["artRightBP"];
$artLeftWI  = $_POST["artLeftWI"];
$artLeftBP = $_POST["artLeftBP"];
$wertRightWI = $_POST["wertRightWI"];
$wertRightBP = $_POST["wertRightBP"];
$wertLeftWI  = $_POST["wertLeftWI"];
$wertLeftBP= $_POST["wertLeftBP"];
//sicherstellen, dass es sich um int handelt
//mit trick:
//$foo = 1 + "bob3";   // $foo is integer (1)
if ($artRightWI != "*"){
	$wertRightWI = 1 + $wertRightWI - 1;
}
if ($artRightBP != "*"){	
	$wertRightBP = 1 + $wertRightBP - 1;
}
if ($artLeftWI != "*"){
	$wertLeftWI  = 1 + $wertLeftWI - 1;
}
if ($artLeftBP != "*"){
	$wertLeftBP = 1 + $wertLeftBP - 1;
}
if ($artRightBP == "*"){
	$wertRightBP = "*";
}
if ($artLeftBP == "*"){
	$wertLeftBP = "*";
}
if ($artRightWI == "*"){
	$wertRightWI = "*";
}
if ($artLeftWI == "*"){
	$wertLeftWI = "*";
}

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../templates/components.php");
include_once($root."/include/propertiesFunctions.php"); 
	
	setFramesizeLeftBP($unterkunft_id,$wertLeftBP,$artLeftBP,$link);
	setFramesizeRightBP($unterkunft_id,$wertRightBP,$artRightBP,$link);
	setFramesizeRightWI($unterkunft_id,$wertRightWI,$artRightWI,$link);
	setFramesizeLeftWI($unterkunft_id,$wertLeftWI,$artLeftWI,$link);	
	
	$nachricht = "Die Framegrößen wurden erfolgreich geändert";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	$nachricht.=".";
	$fehler = false;
	
	if (isset($_POST["splitHorizontal"]) && $_POST["splitHorizontal"] == "true"){
		setProperty(HORIZONTAL_FRAME,"true",$unterkunft_id,$link);
	}
	else{
		setProperty(HORIZONTAL_FRAME,"false",$unterkunft_id,$link);
	}

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
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zurück",$sprache,$link));
?>
<br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../../inhalt.php",getUebersetzung("Hauptmenü",$sprache,$link));
?>
<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../../templates/end.php"); 

 ?>