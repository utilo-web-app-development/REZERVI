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

//datenbank öffnen:
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
$standardsprache = getStandardSprache($unterkunft_id,$link);
			
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
<table  border="0" cellpadding="0" cellspacing="3" class="table">
  <tr>
    <td><?php echo(getUebersetzung("Markieren sie die Sprachen, die auf ihrer Website zur Auswahl angeboten werden sollen",$sprache,$link)); ?>:</td>
  </tr>
</table>
<br/>
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
  <form action="./sprachenAendern.php" method="post" target="_self">
  <?php
  //sprachen anzeigen die aktiviert sind: 
  	$res = getSprachenForBelegungsplan($link);
  	while($d = mysql_fetch_array($res)){
  		$bezeichnung = $d["Bezeichnung"];
  		$spracheID   = $d["Sprache_ID"];
  		$aktiviert   = isSpracheShown($unterkunft_id,$spracheID,$link);          
    ?>  
  <tr>
    <td><input name="<?php echo($spracheID); ?>" type="checkbox" id="<?php echo($spracheID); ?>" value="true" 
    	<?php if($aktiviert){ echo(" checked"); } ?>></td>
    <td><?php echo(getUebersetzung($bezeichnung,$sprache,$link)); ?></td>
  </tr>
	<?php
  	}
  	?>  
  <tr>
    <td colspan="2">
 	 <?php 
	  showSubmitButton(getUebersetzung("ändern",$sprache,$link));
	?>
	</td>
  </tr>
  </form>
</table>
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
 <?php include_once("../../templates/end.php"); ?>