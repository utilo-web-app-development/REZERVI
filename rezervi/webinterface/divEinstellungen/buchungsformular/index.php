<? session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

/*   
	date: 5.11.05
	author: christian osterrieder utilo.eu						
*/

//datenbank öffnen:
include_once($root."/conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once($root."/include/benutzerFunctions.php");
include_once($root."/include/unterkunftFunctions.php");
include_once($root."/include/propertiesFunctions.php");
include_once($root."/include/uebersetzer.php");	
include_once($root."/webinterface/templates/components.php"); 

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);
			
?>
<?php include_once($root."/webinterface/templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<script language="JavaScript" type="text/javascript" src="./updateDate.js">
</script>
<?php include_once($root."/webinterface/templates/headerB.php"); ?>
<?php include_once($root."/webinterface/templates/bodyA.php"); ?>
<?php 
//passwortprüfung:	
if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
<div class="panel panel-default">
  <div class="panel-body">
<h1><?php echo(getUebersetzung("Einstellungen für das Buchungsformular",$sprache,$link)); ?>.</h1>
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

  	
  <form action="./aendern.php" method="post" target="_self" name="reservierung">
  <tr>
    <td valign="top">
		<?php echo(getUebersetzung("Zusätzliche Attribute anzeigen:",$sprache,$link)); ?>
	</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="0" >
          <tr class="standardSchrift">
            <td>
              <?php
              	echo(getUebersetzung("Übernachtung",$sprache,$link));
              ?>
            </td>
		    <td>
		      <input name="uebernachtung" type="checkbox" value="true" 
		      <?php
		      	if (getPropertyValue(PENSION_UEBERNACHTUNG,$unterkunft_id,$link) == "true"){
		      ?>
		      		checked="checked"
		      <?
		      	}
		      ?>
		      />
            </td>
          </tr>
		  <tr class="standardSchrift">
            <td>
              <?php
              	echo(getUebersetzung("Frühstück",$sprache,$link));
              ?>
            </td>
		    <td>
		      <input name="fruehstueck" type="checkbox" value="true" 
		      <?php
		      	if (getPropertyValue(PENSION_FRUEHSTUECK,$unterkunft_id,$link) == "true"){
		      ?>
		      		checked="checked"
		      <?
		      	}
		      ?>
		      />
            </td>
          </tr>
		  <tr class="standardSchrift">
            <td>
              <?php
              	echo(getUebersetzung("Halbpension",$sprache,$link));
              ?>
            </td>
		    <td>
		      <input name="halbpension" type="checkbox" value="true" 
		      <?php
		      	if (getPropertyValue(PENSION_HALB,$unterkunft_id,$link) == "true"){
		      ?>
		      		checked="checked"
		      <?
		      	}
		      ?>
		      />
            </td>
          </tr>
		  <tr class="standardSchrift">
            <td>
              <?php
              	echo(getUebersetzung("Vollpension",$sprache,$link));
              ?>
            </td>
		    <td>
		      <input name="vollpension" type="checkbox" value="true" 
		      <?php
		      	if (getPropertyValue(PENSION_VOLL,$unterkunft_id,$link) == "true"){
		      ?>
		      		checked="checked"
		      <?
		      	}
		      ?>
		      />
            </td>
          </tr>
		</table>
		<tr><td colspan="2"><?php 
	  	//-----buttons um zurück zum menue zu gelangen: 
	  	showSubmitButton(getUebersetzung("ändern",$sprache,$link));
		?></td></tr>
	</td>
  </tr>
  </form>
</table>
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
 ?>
 <?php include_once("../../templates/end.php"); ?>