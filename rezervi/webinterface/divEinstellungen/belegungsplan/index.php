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
include_once("../../../include/propertiesFunctions.php");
include_once("../../../include/uebersetzer.php");	
include_once("../../templates/components.php"); 

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);
$aktiviert = getPropertyValue(SHOW_OTHER_COLOR_FOR_SA,$unterkunft_id,$link);
if ($aktiviert != "true"){
	$aktiviert = false;
}
$showMonatsansicht = getPropertyValue(SHOW_MONATSANSICHT,$unterkunft_id,$link);
$showJahresansicht = getPropertyValue(SHOW_JAHRESANSICHT,$unterkunft_id,$link);
$showGesamtansicht = getPropertyValue(SHOW_GESAMTANSICHT,$unterkunft_id,$link);
			
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
<p class="standardSchriftBold"><?php echo(getUebersetzung("Einstellungen für den Belegungsplan",$sprache,$link)); ?>.</p>
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
  <form action="./planAendern.php" method="post" target="_self">
      <tr>
        <td><input name="showSamstag" type="checkbox" id="showSamstag" value="true" 
			<?php
			  if($aktiviert){ echo(" checked=\"checked\""); }
			?>
			>
		</td>		
		<td>
			<?php echo(getUebersetzung("Samstage andersfärbig anzeigen.",$sprache,$link)); ?>
		</td>
      </tr>
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
<table  border="0" cellpadding="0" cellspacing="3" class="tableColor">
  <form action="./ansichtenAendern.inc.php" method="post" target="_self">
      <tr>
	    <td colspan="2">
	 	 <?= getUebersetzung("Ansichten anzeigen",$sprache,$link) ?>
		</td>
  	  </tr>
      <tr>
        <td>
        	<input name="showMonatsansicht" type="checkbox" id="showMonatsansicht" value="true" 
			<?php
			  if($showMonatsansicht){ echo(" checked=\"checked\""); }
			?>
			/>
		</td>		
		<td>
			<?= getUebersetzung("Monatsübersicht",$sprache,$link) ?>
		</td>
      </tr>
      <tr>
        <td>
        	<input name="showJahresansicht" type="checkbox" id="showJahresansicht" value="true" 
			<?php
			  if($showJahresansicht){ echo(" checked=\"checked\""); }
			?>
			/>
		</td>		
		<td>
			<?= getUebersetzung("Jahresübersicht",$sprache,$link) ?>
		</td>
      </tr>   
     <tr>
        <td>
        	<input name="showGesamtansicht" type="checkbox" id="showGesamtansicht" value="true" 
			<?php
			  if($showGesamtansicht){ echo(" checked=\"checked\""); }
			?>
			/>
		</td>		
		<td>
			<?= getUebersetzung("Gesamtübersicht",$sprache,$link) ?>
		</td>
      </tr>           
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