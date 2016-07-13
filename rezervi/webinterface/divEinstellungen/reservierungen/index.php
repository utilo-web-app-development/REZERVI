<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung des designs
			author: christian osterrieder utilo.eu						
*/

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/propertiesFunctions.php");
include_once("../../../include/uebersetzer.php");	
include_once("../../templates/components.php"); 

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);
$resAnzeigen = getPropertyValue(SHOW_RESERVATION_STATE,$unterkunft_id,$link);

if ($resAnzeigen != "true"){
	$resAnzeigen = false;
}

$resHouse = getPropertyValue(RES_HOUSE,$unterkunft_id,$link);
if ($resHouse != "true"){
	$resHouse = false;
}

$xDays = getPropertyValue(RESERVATION_STATE_TIME,$unterkunft_id,$link);
if (empty($xDays) || $xDays == 0 || $xDays == "0"){
	$xDays = "";
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
  <div class="panel panel-default">
  <div class="panel-body">
  	
		<form action="./resAendern.php" method="post" name="adresseForm" target="_self" onSubmit="return chkFormular();" class="form-horizontal">

<h3><?php echo(getUebersetzung("Einstellungen für Reservierungen",$sprache,$link)); ?>.</h3>
<?php 
if (isset($nachricht) && $nachricht != ""){
?>
	<table  border="0" cellpadding="0" cellspacing="3" class="tableColor">
	  <tr>
		<td <?php if (isset($fehler) && $fehler == false) {echo("class=\"frei\""); } else {echo("class=\"belegt\"");} ?>><?php echo($nachricht) ?></td>
	  </tr>
	</table>
	<br/>
<?php 
}
?>
<table  border="0" cellpadding="0" cellspacing="3" class="tableColor">
  <form action="./resAendern.php" method="post" target="_self">
    <tr>
        <td>
        	<input name="resAnzeigen" type="checkbox" id="resAnzeigen" value="true" 
			<?php
			  if($resAnzeigen == "true"){ echo(" checked=\"checked\""); }
			?>
			/>
			<?php echo getUebersetzung("Eingehende Anfragen als reserviert anzeigen.",$sprache,$link) ?>
		</td>
    </tr>
  	<tr>
	    <td>
	 	 <?php echo getUebersetzung("Eingehende Anfragen nach",$sprache,$link) ?>&nbsp; 	 	 
  			<input type="text" name="xDays" value="<?php echo $xDays ?>" size="3" maxlength="3"/>&nbsp;  
	 	 <?php echo getUebersetzung("Tagen löschen falls unbestätigt.",$sprache,$link) ?>&nbsp;  
	 	 <?php echo getUebersetzung("(Bitte lassen sie dieses Feld leer falls dies nicht erwünscht ist.)",$sprache,$link) ?>  
		</td>
    </tr>  
    <tr>
        <td>
        	<input name="resHouse" type="checkbox" id="resHouse" value="true" 
			<?php
			  if($resHouse == "true"){ echo(" checked=\"checked\""); }
			?>
			/>
			<?php echo getUebersetzung("Wenn ein Zimmer eines Hauses reserviert oder belegt ist, das gesamte Haus als belegt anzeigen.",$sprache,$link) ?>
		</td>
    </tr>      
  	<tr>
	    <td>
	    <br/>
	 	 <?php 
		  showSubmitButton(getUebersetzung("speichern",$sprache,$link));
		 ?>
		</td>
   </tr>
  </form>
</table>
<!-- <br/>
<?php 
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
 ?>
 <?php include_once("../../templates/end.php"); ?>