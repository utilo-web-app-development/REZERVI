<? $root = "../../..";

/*   
	date: 14.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/webinterface/templates/components.inc.php"); 

if (!(isset($fehler) && $fehler == true)){
	$anrede = "";
	$vorname = "";
	$nachname = "";
	$strasse = "";
	$plz = "";
	$ort = "";
	$land = "";
	$email = "";
	$tel = "";
	$tel2= "";
	$fax = "";
	$url = "";
	$firma = "";
}

?>
<p class="<?= UEBERSCHRIFT ?>"><?php echo(getUebersetzung("Anlegen eines neuen Mieters")); ?>:</p>
<form action="./anlegen.php" method="post" name="adresseForm" target="_self">
  <table border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td colspan="2">
          <span class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
          	<?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden!")); ?>
          </span>
      </td>
    </tr>
    <tr>
      <td><table border="0" cellspacing="3" cellpadding="0" class="<?= STANDARD_SCHRIFT ?>">
          <tr> 
            <td><?php echo(getUebersetzung("Anrede")); ?></td>
            <td><input name="anrede" type="text" id="anrede" value="<?= $anrede ?>" /> 
            </td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Vorname")); ?></td>
            <td><input name="vorname" type="text" id="vorname" value="<?= $vorname ?>"></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Nachname")); ?></td>
            <td><input name="nachname" type="text" id="nachname" value="<?= $nachname ?>">*</td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Firma")); ?></td>
            <td><input name="firma" type="text" id="firma" value="<?= $firma ?>"></td>
          </tr>          
          <tr> 
            <td><?php echo(getUebersetzung("Straße/Hausnummer")); ?></td>
            <td><input name="strasse" type="text" id="strasse" value="<?= $strasse ?>"></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("PLZ")); ?></td>
            <td><input name="plz" type="text" id="plz" value="<?= $plz ?>"></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Ort")); ?></td>
            <td><input name="ort" type="text" id="ort" value="<?= $ort ?>"></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Land")); ?></td>
            <td><input name="land" type="text" id="land" value="<?= $land ?>"></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("E-Mail-Adresse")); ?></td>
            <td><input name="email" type="text" id="email" value="<?= $email ?>"></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Telefonnummer")); ?></td>
            <td><input name="tel" type="text" id="tel" value="<?= $tel ?>"></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("2. Telefonnummer")); ?></td>
            <td><input name="tel2" type="text" id="tel" value="<?= $tel2 ?>"></td>
          </tr>
          <tr>
            <td><?php echo(getUebersetzung("Faxnummer")); ?></td>
            <td><input name="fax" type="text" id="fax" value="<?= $fax ?>"></td>
          </tr>
          <tr>
            <td><?php echo(getUebersetzung("Homepage")); ?></td>
            <td><input name="url" type="text" id="url" value="<?= $url ?>"></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("bevorzugte Sprache")); ?></td>
            <td><select name="speech" id="speech">
            	<?php
            	//sprachen des belegungsplanes anzeigen:
            	$stdSpr= getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
            	$res = getSprachen($vermieter_id);
            	while ($d = mysql_fetch_array($res)){
				 	$spr = $d["SPRACHE_ID"];
					$bezeichnung = getBezeichnungOfSpracheID($spr);
            	?>
                	<option value="<?php echo($spr); ?>" <?php if ($stdSpr == $spr) echo("selected"); ?>><?php echo(getUebersetzung($bezeichnung)); ?></option>
                <?php
				}
				?>
            </select></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p>
    <input type="submit" name="anlegen" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("anlegen")); ?>">
  </p>
</form>

<table border="0" cellspacing="3" cellpadding="0" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td><form action="../index.php" method="post" name="form1" target="_self">
        <input name="zurueck" type="submit" class="<?= BUTTON ?>" id="zurueck" 
			onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>">
    </form></td>
  </tr>
</table>
<?php	  
include_once($root."/webinterface/templates/footer.inc.php");
?>

