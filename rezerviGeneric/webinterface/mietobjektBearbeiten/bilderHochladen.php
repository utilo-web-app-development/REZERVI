<?php $root = "../..";

/*   
	date: 4.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/webinterface/templates/components.inc.php"); 

if (!(isset ($fehler) && $fehler != true)){
	//standardwerte setzen:
	$maxHoehe = getVermieterEigenschaftenWert(BILDER_HEIGHT,$vermieter_id);
	$maxBreite= getVermieterEigenschaftenWert(BILDER_WIDTH,$vermieter_id);
}

?>

<form action="./bilderHochladenDurchfuehren.php" method="post" name="bilderHochladen" 
	target="_self" enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="3">
    <tr> 
      <td colspan="2"><p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Bilder für Mietobjekt hochladen")); ?><br/>
          <span class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
          <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden")); ?>!</span></p>
      </td>
    </tr>
	<tr> 
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
 	<tr>
		<td><span class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Mietobjekt")); ?></span></td>
		<td><select name="mietobjekt_id" id="mietobjekt_id">
          <?php	
			 $res = getMietobjekte($vermieter_id);
			  //zimmer ausgeben:
			  while($d = mysql_fetch_array($res)) {
				$bezeichnung = getUebersetzungVermieter($d["BEZEICHNUNG"],$sprache,$vermieter_id);
				$id = $d["MIETOBJEKT_ID"]
				?>
					<option value="<?php echo $id ?>"
					<?php
					if (isset($mietobjekt_id) && $mietobjekt_id == $id){
					?>
						selected="selected"
					<?php
					}
					?>
					><?php echo $bezeichnung; ?></option>
				<?php 
			  } //ende while 
			 ?>
        </select>*</td>
	</tr>
	<tr>
		<td><span class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Bild")); ?></span></td>
		<td><input name="bild" type="file"/>*</td>
	</tr>
	<tr>
		<td><span class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Beschreibung")); ?></span></td>
		<td><textarea name="beschreibung" cols="50" rows="3"><?php if (isset($beschreibung)) { echo($beschreibung); } ?></textarea></td>
	</tr>
	<tr>
		<td><span class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Maximale Bildhöhe")); ?></span></td>
		<td><input type="text" name="maxHoehe" value="<?php echo $maxHoehe ?>"/>*</td>
	</tr>
	<tr>
		<td><span class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Maximale Bildbreite")); ?></span></td>
		<td><input type="text" name="maxBreite" value="<?php echo $maxBreite ?>"/>*</td>
	</tr>
    <tr class="<?php echo TABLE_STANDARD ?>"> 
      <td colspan="2">
        <input name="Submit" type="submit" id="Submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("Bild hochladen")); ?>"></td>
    </tr>
  </table>
</form>
<br/>
<?php 
	  //-----buttons um zurück zu gelangen: 
	  showSubmitButtonWithForm("./index.php",getUebersetzung("zurück"));
	  
include_once($root."/webinterface/templates/footer.inc.php");
?>
