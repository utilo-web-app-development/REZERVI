<? session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
	rezervi
	einstellungen zu bildern in der suchfunktion
	author: coster utilo.eu
	date: 3. aug. 2005					
*/

//datenbank �ffnen:
include_once("../../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/bildFunctions.php");
include_once("../../../include/propertiesFunctions.php");
include_once("../../../include/uebersetzer.php");	
include_once("../../templates/components.php"); 

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

//check if the upload dir is writeable:
if (!is_writable($root."/upload")){
	$nachricht = "Achtung! Das Verzeichnis 'upload' ist nicht beschreibbar, Sie k�nnen erst Bilder hochladen wenn Sie diesem Verzeichnis Schreibrechte zuweisen!";
	$nachricht = getUebersetzung($nachricht,$sprache,$link);
	$fehler = true;
}
			
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
<p class="standardSchriftBold"><?php echo(getUebersetzung("Einstellungen f�r Bilder der Zimmer",$sprache,$link)); ?>.</p>
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
  <form action="./bilderAendern.php" method="post" target="_self">
  <?php
  		$active = getPropertyValue(ZIMMER_THUMBS_ACTIV,$unterkunft_id,$link);
  		if ($active != "true"){
  			$active = false;
  		}
  		else{
  			$active = true;
  		}
  		$active2 = getPropertyValue(ZIMMER_THUMBS_AV_OV,$unterkunft_id,$link);
  		if ($active2 != "true"){
  			$active2 = false;
  		}
  		else{
  			$active2 = true;
  		}		
        $width  = getPropertyValue(BILDER_SUCHE_WIDTH,$unterkunft_id,$link);
        $height = getPropertyValue(BILDER_SUCHE_HEIGHT,$unterkunft_id,$link);
    ?>  
  <tr>
    <td colspan="2"><input name="active" type="checkbox" id="active" value="true" 
    <?php if ($active) echo("checked=\"checked\""); ?>>
    <?php echo(getUebersetzung("Bilder bei Suchergebnissen anzeigen",$sprache,$link)); ?></td>
  </tr>
  <tr>
    <td colspan="2"><input name="active2" type="checkbox" id="active2" value="true" 
    <?php if ($active2) echo("checked=\"checked\""); ?>>
    <?php echo(getUebersetzung("Bilder und Beschreibungen im Belegungsplan anzeigen",$sprache,$link)); ?></td>
  </tr>  
  <tr>
    <td><?php echo(getUebersetzung("Maximale H�he bei upload",$sprache,$link)); ?>
    </td>
    <td>  
      <input name="width" type="text" id="width" value="<?php echo($width); ?>" size="5" maxlength="5"/>&nbsp;
    </td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Maximale Breite bei upload",$sprache,$link)); ?>
    </td>
    <td>
      <input name="height" type="text" id="height" value="<?php echo($height); ?>" size="5" maxlength="5"/>&nbsp;
     </td>
  </tr>
  <tr>
    <td colspan="2">
 	 <?php 
	  showSubmitButton(getUebersetzung("�ndern",$sprache,$link));
	?>
	</td>
  </tr>
  </form>
</table>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zur�ck",$sprache,$link));
?>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../../inhalt.php",getUebersetzung("Hauptmen�",$sprache,$link));
?>
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../../templates/end.php"); ?>