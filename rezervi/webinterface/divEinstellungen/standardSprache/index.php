<? session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung des designs
			author: christian osterrieder utilo.eu						
*/

//datenbank �ffnen:
include_once("../../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/uebersetzer.php");	
include_once("../../templates/components.php"); 

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);
//standard-sprache aus datenbank auslesen:
$standard = getStandardSprache($unterkunft_id,$link);
$standardBelegungsplan = getStandardSpracheBelegungsplan($unterkunft_id,$link);
			
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
  <div class="panel panel-default">
  <div class="panel-body">
<h1><?php echo(getUebersetzung("ändern der Standard-Sprache",$sprache,$link)); ?>.</h1>
<?php 
if (isset($nachricht) && $nachricht != ""){
?>
	<table  border="0" cellpadding="0" cellspacing="3" class="tableColor">
	  <tr>
		<td><?php echo($nachricht) ?></td>
	  </tr>
	</table>
	<br/>
<?php 
}
?>
<form action="./spracheAendern.php" method="post" target="_self">
<table  border="0" cellpadding="0" cellspacing="3" class="tableColor">
  <tr>
    <td><?php echo(getUebersetzung("Bitte wählen sie die Standard-Sprache ihres Belegungsplanes",$sprache,$link)); ?>.
    </td>
  </tr>
  <tr>
    <td>
    	<?php echo(getUebersetzung("Es werden hier nur Sprachen angeboten die unter dem Menüpunkt [Sprachen] ausgewählt wurden",$sprache,$link)); ?>.
    </td>
  </tr>
  <?php  
 
	$res = getSprachen($unterkunft_id,$link);
	while ($d = mysql_fetch_array($res)){
	 	$spracheID = $d["Sprache_ID"];
  		$bezeichnung = getBezeichnungOfSpracheID($spracheID,$link);
  ?>
  <tr>
    <td><input type="radio" name="standardspracheBelegungsplan" value="<?php echo($spracheID); ?>"
    	<?php if($standardBelegungsplan == $spracheID){ echo(" checked"); } ?>>
    	<?php echo(getUebersetzung($bezeichnung,$sprache,$link)); ?></td>
  </tr>
  <?php
  } //ende foreach 
  ?>
</table>
<br/>
<table  border="0" cellpadding="0" cellspacing="3" class="tableColor">
  <tr>
    <td>
    	<?php echo(getUebersetzung("Bitte wählen sie die Standard-Sprache ihres Webinterfaces",$sprache,$link)); ?>.
    </td>
  </tr>
  <?php  
  $res = getSprachenForWebinterface($link);
  while($d=mysql_fetch_array($res)){
  	$bezeichnung = $d["Bezeichnung"];
  	$spracheID	 = $d["Sprache_ID"];
  ?>
  <tr>
    <td><input type="radio" name="standardsprache" value="<?php echo($spracheID); ?>"
    	<?php if($standard == $spracheID){ echo(" checked"); } ?>>
    	<?php echo(getUebersetzung($bezeichnung,$sprache,$link)); ?></td>
  </tr>
  <?php
  } //ende foreach 
  ?>
  <br/>
  <tr>
    <td><input type="checkbox" name="jetztWechseln" value="true" checked>
    <?php echo(getUebersetzung("Zur ausgewählten Sprache wechseln",$sprache,$link)); ?>.</td>
  </tr>
 </table>
 <br/>
 <?php showSubmitButton(getUebersetzung("ändern",$sprache,$link));?>
  </form>
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