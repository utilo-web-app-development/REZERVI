<?php
/**
 * Created on 31.08.2006
 *
 * @author coster
 * add, edit or delete attributes of rooms
 */

session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
include_once("../../conf/rdbmsConfig.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/zimmerAttributes.inc.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/benutzerFunctions.php");
include_once($root."/include/propertiesFunctions.php");

//variablen intitialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$benutzername = getSessionWert(BENUTZERNAME);
$passwort = getSessionWert(PASSWORT);
$sprache = getSessionWert(SPRACHE);

include_once("../templates/headerA.php"); 
?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php 
include_once("../templates/headerB.php"); 
include_once("../templates/bodyA.php"); 

//passwortpr�fung:	
if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
	
?>
<div class="panel panel-default">
  <div class="panel-body">
<a class="btn btn-primary" href="./index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
</div>
</div>

<div class="panel panel-default">
  <div class="panel-body">
  	
<h1>
	<?= getUebersetzung("Weitere Attribute für Zimmer/Appartement/Wohnung/etc. bearbeiten",$sprache,$link) ?>.
</h1>
</br>
<?php 
if (isset($nachricht) && $nachricht != ""){
?>
	<table border="0" cellpadding="0" cellspacing="3" class="table">
	  <tr>
		<td <?php if (isset($fehler) && $fehler == false) {echo("class=\"frei\""); } 
			else {echo("class=\"belegt\"");} ?>>
				<?= $nachricht ?>
		</td>
	  </tr>
	</table>
	<br/>
<?php 
}
?>
<form action="./attributeAendern.inc.php" method="post" target="_self">
<table border="0" cellpadding="0" cellspacing="3" class="table">
	<tr>
		<td>
			<?= getUebersetzung("Bezeichnung",$sprache,$link) ?>
		</td>
		<td>
			<?= getUebersetzung("Beschreibung",$sprache,$link) ?>
		</td>
		<td>
		</td>
	</tr>
<?php
		
	//alle bestehenden attribute auslesen:
	$res = getAttributes();
	while ($d = mysql_fetch_array($res)){	
		$bezeichnung = $d["Bezeichnung"];
		$beschreibung = $d["Beschreibung"];
		$att_id 	= $d["PK_ID"];
?>
		<tr>
			<td>				
				<input type="text" name="bezeichnung_<?= $att_id ?>" value="<?= $bezeichnung ?>">
			</td>
			<td>				
				<input type="text" name="beschreibung_<?= $att_id ?>" value="<?= $beschreibung ?>">
			</td>
			<td>
			    <input 
      				name="loeschen_<?= $att_id ?>" type="submit" id="loeschen_<?= $att_id ?>" 
      				class="btn btn-danger"value="<?php echo(getUebersetzung("löschen",$sprache,$link)); ?>" /> <!-- onMouseOver="this.className='button200pxB';"
       				onMouseOut="this.className='button200pxA';" --> 
       				
			</td>
		</tr>
<?php
	} //ende while attribute
?>
	<tr>
		<td>				
			<input type="text" name="bezeichnung_neu">
		</td>
		<td>				
			<input type="text" name="beschreibung_neu">
		</td>
		<td>
		    <input 
  				name="hinzufuegen" type="submit" id="hinzufuegen" 
  				class="btn btn-success" 
   				value="<?php echo(getUebersetzung("hinzufügen",$sprache,$link)); ?>" />
		</td>
	</tr>
</table>
<input type="hidden" name="att_id" value="<?= $att_id ?>" />
<h4>
	<?= getUebersetzung("Attribute anzeigen",$sprache,$link) ?>:
</h4>
<table border="0" cellpadding="0" cellspacing="3" class="tableColor">
	<tr>
		<td>
			<?= getUebersetzung("Gesamtübersicht",$sprache,$link) ?>
		</td>
		<td>
			<input type="checkbox" name="showInGesamtuebersicht" value="true"
			<?php
				$show = getPropertyValue(SHOW_ZIMMER_ATTRIBUTE_GESAMTUEBERSICHT,$unterkunft_id,$link);
				if ($show == "true"){
					?> checked="checked" <?php
				}
			?>
			/>
		</td>
	</tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="3" class="tableColor">
	<tr>
		<td colspan="3">
			<input 
  				name="aendern" type="submit" id="aendern" 
  				class="btn btn-success" 
   				value="<?php echo(getUebersetzung("speichern",$sprache,$link)); ?>" />
		</td>
	</tr>
</table>
</form>
</br>
    	
    	<!-- <form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">
		<input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 	onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
  		</form> -->
  
<!-- <table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
	<input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>">
  </form></td>
  </tr>
</table> -->
<?php
}
else {
	echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
}
?>   
</body>
</html>
