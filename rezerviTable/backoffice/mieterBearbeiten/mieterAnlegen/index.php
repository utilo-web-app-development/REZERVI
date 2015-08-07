<? 
$root = "../../..";
$ueberschrift = "Gäste bearbeiten";
$unterschrift = "Anlegen";

/*   
	date: 14.10.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Gäste", "mieterBearbeiten/index.php",
							$unterschrift, "mieterBearbeiten/mieterAnlegen/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/backoffice/templates/components.inc.php"); 

if(isset($mieter_id)){
	$anrede = getMieterAnrede($mieter_id);
	$vorname = getMieterVorname($mieter_id);
	$nachname = getNachnameOfMieter($mieter_id);
	$strasse = getMieterStrasse($mieter_id);
	$plz = getMieterPlz($mieter_id);
	$ort = getMieterOrt($mieter_id);
	$land = getMieterLand($mieter_id);
	$email = getEmailOfMieter($mieter_id);
	$tel = getMieterTel($mieter_id);
	$tel2= getMieterTel2($mieter_id);
	$fax = getMieterFax($mieter_id);
	$url = getMieterUrl($mieter_id);
	$firma = getMieterFirma($mieter_id);	
	$bezeichnung = getMieterBezeichnung($mieter_id);
	$beschreibung = getMieterBeschreibung($mieter_id);
}else{
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
	$bezeichnung = array();
	$beschreibung = "";
}

?>
<h2><?php echo(getUebersetzung("Anlegen eines neuen Gastes")); ?></h2>
<table>
  	<tr>
      <td colspan="2">
          <span><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
          	<?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden!")); ?>
          </span>
      </td>
    </tr>
	<form action="./anlegen.php" method="post" name="adresseForm" target="_self">
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
           <td><?php echo(getUebersetzung("Strasse/Hausnummer")); ?></td>
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
           <td><?php include_once($root."/templates/selectCountries.inc.php"); ?></td>
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
           <td><?php echo(getUebersetzung("Bevorzugte Sprache")); ?></td>
           <td><select name="speech" id="speech">
           	<?php
           	//sprachen des belegungsplanes anzeigen:
           	$stdSpr= getGastroProperty(STANDARDSPRACHE,$gastro_id);
           	$res = getSprachen($gastro_id);
           	while ($d = $res->FetchNextObject()){
			 	$spr = $d->SPRACHE_ID;
				$bezeichnungSpr = getBezeichnungOfSpracheID($spr);
           	?>
               	<option value="<?php echo($spr); ?>" <?php if ($stdSpr == $spr) echo("selected"); ?>><?php echo(getUebersetzung($bezeichnungSpr)); ?></option>
               <?php
			}
			?>
           </select></td>
	</tr>
	<?php /*
	<tr>
   		<td><?php echo(getUebersetzung("Bezeichnung")); ?></td>
		<td>      	
		  <select name="bezeichnung[]" size="6" multiple><?php 
			$res = getGaesteGruppen($gastro_id);
   			while ($d = $res->FetchNextObject()){
   				$temp = $d->GRUPPENBEZEICHNUNG;   ?>
		    	<option value="<?= $temp ?>" <?php 
		    		foreach ($bezeichnung as $jede){
		    			if($jede == $temp) { 
		    				echo("selected='selected'"); 
		    			} 
		    		} ?> > <?= $temp ?>
		    	</option>    <?php
		    }    ?>
		  </select>  
		</td>
	</tr>
	*/ 
	?>
	<tr>
           <td><?php echo(getUebersetzung("Beschreibung")); ?></td>
           <td><textarea name="beschreibung"><?= $beschreibung ?></textarea></td>
	</tr>
    <tr>
    	<td>
    		<input type="submit" name="anlegen" class="button" value="<?php echo(getUebersetzung("anlegen")); ?>">
  		</td>
  	</tr>
	</form>
</table>
  
<?php	  
include_once($root."/backoffice/templates/footer.inc.php");
?>

