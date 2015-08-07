<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
//variablen initialisieren:
$active = $_POST["active"];
$active2 = $_POST["active2"];
$width = $_POST["width"];
$height  = $_POST["height"];

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");
include_once("../../../include/propertiesFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/filesAndFolders.php");
include_once("../../templates/components.php");

	if ($active == true){	
		setProperty(ZIMMER_THUMBS_ACTIV,"true",$unterkunft_id,$link);
	}
	else{
		setProperty(ZIMMER_THUMBS_ACTIV,"false",$unterkunft_id,$link);
	}
	if ($active2 == true){	
		setProperty(ZIMMER_THUMBS_AV_OV,"true",$unterkunft_id,$link);
	}
	else{
		setProperty(ZIMMER_THUMBS_AV_OV,"false",$unterkunft_id,$link);
	}	
	setProperty(BILDER_SUCHE_WIDTH,$width,$unterkunft_id,$link);
	setProperty(BILDER_SUCHE_HEIGHT,$height,$unterkunft_id,$link);
	
	$nachricht = "Die Einstellungen wurden erfolgreich geändert";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	$nachricht.=".";
	$fehler = false;
	
	//falls das upload-verzeichnis noch nicht vorhanden ist, muss es erzeugt werden:
	$path = "../../../upload";
	if (!hasDirectory($path)){
		if (!phpMkDir($path)){
			//file erzeugen war nicht erfolgreich
				$nachricht = "Das Upload Verzeichnis konnte nicht erstellt werden";
				$nachricht = getUebersetzung($nachricht,$sprache,$link);
				$nachricht.=".";
				$fehler = false;
		}
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
<p class="standardSchriftBold"><?php echo(getUebersetzung("Einstellungen für Bilder der Zimmer",$sprache,$link)); ?>.</p>
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