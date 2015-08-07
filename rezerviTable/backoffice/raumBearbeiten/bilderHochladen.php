<?  
$root = "../.."; 
$ueberschrift = "Raum bearbeiten";

/*   
	date: 4.10.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php"); 

if (!(isset ($fehler) && $fehler != true)){
	//standardwerte setzen:
	$maxHoehe = getGastroProperty(BILDER_HEIGHT,$gastro_id);
	$maxBreite= getGastroProperty(BILDER_WIDTH,$gastro_id);
}

?>

<form action="./bilderHochladenDurchfuehren.php" method="post" name="bilderHochladen" 
	target="_self" enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="3">
    <tr> 
      <td colspan="2"><p class="standardschrift"><?php echo(getUebersetzung("Bilder für Mietobjekt hochladen")); ?><br/>
          <span><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
          <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden")); ?>!</span></p>
      </td>
    </tr>
	<tr> 
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
 	<tr>
		<td><span><?php echo(getUebersetzung("Mietobjekt")); ?></span></td>
		<td><select name="mietobjekt_id" id="mietobjekt_id">
          <?php	
			 $res = getMietobjekte($gastro_id);
			  //zimmer ausgeben:
			  while($d = $res->FetchNextObject()) {
				$bezeichnung = getUebersetzungGastro($d->BEZEICHNUNG,$sprache,$gastro_id);
				$id = $d->MIETOBJEKT_ID
				?>
					<option value="<?= $id ?>"
					<?php
					if (isset($mietobjekt_id) && $mietobjekt_id == $id){
					?>
						selected="selected"
					<?
					}
					?>
					><?= $bezeichnung; ?></option>
				<?php 
			  } //ende while 
			 ?>
        </select>*</td>
	</tr>
	<tr>
		<td><span><?php echo(getUebersetzung("Bild")); ?></span></td>
		<td><input name="bild" type="file"/>*</td>
	</tr>
	<tr>
		<td><span><?php echo(getUebersetzung("Beschreibung")); ?></span></td>
		<td><textarea name="beschreibung" cols="50" rows="3"><?php if (isset($beschreibung)) { echo($beschreibung); } ?></textarea></td>
	</tr>
	<tr>
		<td><span><?php echo(getUebersetzung("Maximale Bildhöhe")); ?></span></td>
		<td><input type="text" name="maxHoehe" value="<?= $maxHoehe ?>"/>*</td>
	</tr>
	<tr>
		<td><span><?php echo(getUebersetzung("Maximale Bildbreite")); ?></span></td>
		<td><input type="text" name="maxBreite" value="<?= $maxBreite ?>"/>*</td>
	</tr>
    <tr> 
      <td colspan="2">
        <input name="Submit" type="submit" id="Submit" class="button"  value="<?php echo(getUebersetzung("Bild hochladen")); ?>"></td>
    </tr>
  </table>
</form>
<br/>
<?php 
	  //-----buttons um zurück zu gelangen: 
	  showSubmitButtonWithForm("./index.php",getUebersetzung("zurück"));
	  
include_once($root."/backoffice/templates/footer.inc.php");
?>
