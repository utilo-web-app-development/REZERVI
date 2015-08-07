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
include_once($root."/include/propertiesFunctions.php"); 

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
<p class="standardSchriftBold"><?php echo(getUebersetzung("Ändern der Framegrößen",$sprache,$link)); ?>.</p>
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
  <form action="./frameAendern.php" method="post" target="_self">
  <?php

  	$framesizeLeftWI = getFramesizeLeftWI($unterkunft_id,$link);
  	$framesizeRightWI= getFramesizeRightWI($unterkunft_id,$link);
  	$framesizeLeftBP = getFramesizeLeftBP($unterkunft_id,$link);
  	$framesizeRightBP= getFramesizeRightBP($unterkunft_id,$link);
	$framesizeLeftWIUnit = getFramesizeLeftWIUnit($unterkunft_id,$link);
  	$framesizeRightWIUnit= getFramesizeRightWIUnit($unterkunft_id,$link);
  	$framesizeLeftBPUnit = getFramesizeLeftBPUnit($unterkunft_id,$link);
  	$framesizeRightBPUnit= getFramesizeRightBPUnit($unterkunft_id,$link);
         
    ?>  
  <tr>
    <td><?php echo(getUebersetzung("Belegungsplan links oder oben",$sprache,$link)); ?>
    </td>
    <td>
  <input type="text" name="wertLeftBP" value="<?php echo($framesizeLeftBP); ?>" size="4" maxlength="3"/>&nbsp;
  <select name="artLeftBP">
    <option value="%" <?php if ($framesizeLeftBPUnit == "%") echo("selected"); ?>>%</option>
    <option value="px" <?php if ($framesizeLeftBPUnit == "px") echo("selected"); ?>>px</option>
    <option value="*" <?php if ($framesizeLeftBPUnit == "*") echo("selected"); ?>><?php echo(getUebersetzung("relativ",$sprache,$link)); ?></option>
  </select>  
   </td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Belegungsplan rechts oder unten",$sprache,$link)); ?>
    </td>
    <td>  
      <input type="text" name="wertRightBP" value="<?php echo($framesizeRightBP); ?>" size="4" maxlength="3"/>&nbsp;
	  <select name="artRightBP">
	    <option value="%" <?php if ($framesizeRightBPUnit == "%") echo("selected"); ?>>%</option>
	    <option value="px" <?php if ($framesizeRightBPUnit == "px") echo("selected"); ?>>px</option>
	    <option value="*" <?php if ($framesizeRightBPUnit == "*") echo("selected"); ?>><?php echo(getUebersetzung("relativ",$sprache,$link)); ?></option>
	  </select>
  </td>
  </tr>
  <tr>
    <td>
    </td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Webinterface links",$sprache,$link)); ?>
    </td>
    <td>
      <input type="text" name="wertLeftWI" value="<?php echo($framesizeLeftWI); ?>" size="4" maxlength="3"/>&nbsp;
	  <select name="artLeftWI">
	    <option value="%" <?php if ($framesizeLeftWIUnit == "%") echo("selected"); ?>>%</option>
	    <option value="px" <?php if ($framesizeLeftWIUnit == "px") echo("selected"); ?>>px</option>
	    <option value="*" <?php if ($framesizeLeftWIUnit == "*") echo("selected"); ?>><?php echo(getUebersetzung("relativ",$sprache,$link)); ?></option>
	  </select>
     </td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Webinterface rechts",$sprache,$link)); ?>
    </td>
    <td> 
      <input type="text" name="wertRightWI" value="<?php echo($framesizeRightWI); ?>" size="4" maxlength="3"/>&nbsp;
	  <select name="artRightWI">
	    <option value="%" <?php if ($framesizeRightWIUnit == "%") echo("selected"); ?>>%</option>
	    <option value="px" <?php if ($framesizeRightWIUnit == "px") echo("selected"); ?>>px</option>
	    <option value="*" <?php if ($framesizeRightWIUnit == "*") echo("selected"); ?>><?php echo(getUebersetzung("relativ",$sprache,$link)); ?></option>
	  </select>
    </td>
  </tr>
  <tr>
    <td>
    	<?php echo(getUebersetzung("Frame horizontal teilen",$sprache,$link)); ?>
    </td>
    <td> 
      <input type="checkbox" name="splitHorizontal" value="true"
	  <?php
	  	if (getPropertyValue(HORIZONTAL_FRAME,$unterkunft_id,$link) == "true"){
	  		?> checked="checked"<?php
	  	}
	  ?>
	  />
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