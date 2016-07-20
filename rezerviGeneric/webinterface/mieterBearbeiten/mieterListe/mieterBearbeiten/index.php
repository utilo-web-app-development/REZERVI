<?php $root = "../../../..";

/*   
	date: 14.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 

include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/webinterface/templates/components.inc.php"); 

$mieter_id = $_POST["mieter_id"];
$index = $_POST["index"];

?>

<p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Mieter bearbeiten")); ?>.</p>
<form action="./mieterAendern.php" method="post" name="mieterAendern" target="_self" id="mieterAendern" >

      	<table border="0" cellspacing="3" cellpadding="0">
      	   <tr>
		      <td colspan="2">
		          <span class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
		          	<?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden!")); ?>
		          </span>
		      </td>
		    </tr>
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Anrede")); ?></td>
            <td><input name="anrede" type="text" id="anrede" value="<?php echo(getMieterAnrede($mieter_id)); ?>" >
            </td>
          </tr>
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Vorname")); ?></td>
            <td><input name="vorname" type="text" id="vorname" value="<?php echo(getMieterVorname($mieter_id)); ?>" ></td>
          </tr>
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Nachname")); ?></td>
            <td><input name="nachname" type="text" id="nachname" value="<?php echo(getNachnameOfMieter($mieter_id)); ?>" >*</td>
          </tr>
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Firma")); ?></td>
            <td><input name="firma" type="text" id="firma" value="<?php echo(getMieterFirma($mieter_id)); ?>" ></td>
          </tr>          
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Straße/Hausnummer")); ?></td>
            <td><input name="strasse" type="text" id="strasse" value="<?php echo(getMieterStrasse($mieter_id)); ?>" ></td>
          </tr>
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("PLZ")); ?></td>
            <td><input name="plz" type="text" id="plz" value="<?php echo(getMieterPlz($mieter_id)); ?>" ></td>
          </tr>
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Ort")); ?></td>
            <td><input name="ort" type="text" id="ort" value="<?php echo(getMieterOrt($mieter_id)); ?>" ></td>
          </tr>
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Land")); ?></td>
            <td><input name="land" type="text" id="land" value="<?php echo(getMieterLand($mieter_id)); ?>" ></td>
          </tr>
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("E-Mail-Adresse")); ?></td>
            <td><input name="email" type="text" id="email" value="<?php echo(getEmailOfMieter($mieter_id)); ?>" ></td>
          </tr>
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Telefonnummer")); ?></td>
            <td><input name="tel" type="text" id="tel" value="<?php echo(getMieterTel($mieter_id)); ?>" ></td>
          </tr>
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("2. Telefonnummer")); ?></td>
            <td><input name="tel2" type="text" id="tel" value="<?php echo(getMieterTel2($mieter_id)); ?>" ></td>
          </tr>
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Faxnummer")); ?></td>
            <td><input name="fax" type="text" id="fax" value="<?php echo(getMieterFax($mieter_id)); ?>" ></td>
          </tr>
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Homepage")); ?></td>
            <td><textarea name="url"  id="textarea"><?php echo(getMieterUrl($mieter_id)); ?></textarea></td>
          </tr>
          <tr>
            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Sprache")); ?></td>
            <td><select name="speech" id="speech">
            	<?php
            	//sprachen des belegungsplanes anzeigen:
            	$res = getSprachen($vermieter_id);
            	while ($d = mysqli_fetch_array($res)){
				 	$spr = $d["SPRACHE_ID"];
					$bezeichnung = getBezeichnungOfSpracheID($spr);
            	?>
                	<option value="<?php echo($spr); ?>" <?php if (getSpracheOfMieter($mieter_id) == $spr) echo("selected"); ?>><?php echo(getUebersetzung($bezeichnung)); ?></option>
                <?php
				}
				?>
                </select></td>
          </tr>
        </table>
        <br/>
        <input name="gastAendern" type="submit" id="gastAendern" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("Mieter ändern")); ?>">
        <input name="mieter_id" type="hidden" id="gast_id" value="<?php echo($mieter_id); ?>">
		<input name="index" type="hidden" value="<?php echo($index); ?>"/>
</form>
<br/>
<form action="../index.php" method="post" name="form1" target="_self">
    	<input name="index" type="hidden" value="<?php echo $index ?>"/>
        <input name="zurueck" type="submit" class="<?php echo BUTTON ?>" id="zurueck" 
			onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>"/>
</form>
<?php	  
include_once($root."/webinterface/templates/footer.inc.php");
?>
