<?php 
$root = "../../../..";
$ueberschrift = "Gäste bearbeiten";
$unterschrift = "Gästeliste";
$unterschrift1= "DatenÄndern";

/*   
	date: 14.10.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");;
$breadcrumps = erzeugenBC($root, "Gäste", "mieterBearbeiten/index.php",
							$unterschrift, "mieterBearbeiten/mieterListe/index.php",
							$unterschrift1, "");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 

include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/backoffice/templates/components.inc.php"); 

$mieter_id = $_POST["mieter_id"];
$index = $_POST["index"];

?>

<h2><?php echo(getUebersetzung("Daten verändern")); ?>.</p>
<form action="./mieterAendern.php" method="post" name="mieterAendern" target="_self" id="mieterAendern" >
<table>
	<tr>
		<td colspan="2">
			<span><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
				<?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden!")); ?>
			</span>
		</td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("Anrede")); ?></td>
		<td><input name="anrede" type="text" id="anrede" value="<?php echo(getMieterAnrede($mieter_id)); ?>" ></td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("Vorname")); ?></td>
		<td><input name="vorname" type="text" id="vorname" value="<?php echo(getMieterVorname($mieter_id)); ?>" ></td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("Nachname")); ?></td>
		<td><input name="nachname" type="text" id="nachname" value="<?php echo(getNachnameOfMieter($mieter_id)); ?>" >*</td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("Firma")); ?></td>
		<td><input name="firma" type="text" id="firma" value="<?php echo(getMieterFirma($mieter_id)); ?>" ></td>
	</tr>          
	<tr>
		<td><?php echo(getUebersetzung("Strasse/Hausnummer")); ?></td>
		<td><input name="strasse" type="text" id="strasse" value="<?php echo(getMieterStrasse($mieter_id)); ?>" ></td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("PLZ")); ?></td>
		<td><input name="plz" type="text" id="plz" value="<?php echo(getMieterPlz($mieter_id)); ?>" ></td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("Ort")); ?></td>
		<td><input name="ort" type="text" id="ort" value="<?php echo(getMieterOrt($mieter_id)); ?>" ></td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("Land")); ?></td>
		<td><?php 
			$country = getMieterLand($mieter_id); 
			include_once($root."/templates/selectCountries.inc.php");?>
		</td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("E-Mail-Adresse")); ?></td>
		<td><input name="email" type="text" id="email" value="<?php echo(getEmailOfMieter($mieter_id)); ?>" ></td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("Telefonnummer")); ?></td>
		<td><input name="tel" type="text" id="tel" value="<?php echo(getMieterTel($mieter_id)); ?>" ></td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("2. Telefonnummer")); ?></td>
		<td><input name="tel2" type="text" id="tel" value="<?php echo(getMieterTel2($mieter_id)); ?>" ></td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("Faxnummer")); ?></td>
		<td><input name="fax" type="text" id="fax" value="<?php echo(getMieterFax($mieter_id)); ?>" ></td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("Homepage")); ?></td>
		<td><input name="url" id="url" value="<?php echo(getMieterUrl($mieter_id)); ?>"/></td>
	</tr>
	<tr>
		<td><?php echo(getUebersetzung("Sprache")); ?></td>
		<td><select name="speech" id="speech">
            	<?php
            	//sprachen des belegungsplanes anzeigen:
            	$res = getSprachen($gastro_id);
            	while ($d = $res->FetchNextObject()){
				 	$spr = $d->SPRACHE_ID;
					$bezeichnungSpr = getBezeichnungOfSpracheID($spr);
            	?>
                	<option value="<?php echo($spr); ?>" <?php if (getSpracheOfMieter($mieter_id) == $spr) echo("selected"); ?>><?php echo(getUebersetzung($bezeichnungSpr)); ?></option>
                <?php
				}
				?>
                </select>
		</td>
	</tr>
	<tr>
   		<td><?php echo(getUebersetzung("Bezeichnung")); ?></td>
		<td>      	
		  <select name="bezeichnung[]" size="6" multiple><?php 
			$res = getGaesteGruppen($gastro_id);
			$bezeichnung = getMieterBezeichnung($mieter_id);
   			while ($d = $res->FetchNextObject()){
   				$temp = $d->GRUPPENBEZEICHNUNG; ?>
		    	<option value="<?php echo $temp ?>" <?php 
			    	foreach ($bezeichnung as $jede){
		    			if($jede == $temp) { 
		    				echo("selected='selected'"); 
		    			} 
		    		} ?> > <?php echo $temp ?>
	    		</option>    <?php
		    }    ?>
		  </select>  
		<input type="checkbox" <?php if(getMieterEchtbuchung($mieter_id) == 1){ echo(" checked"); } ?> disabled> <?php echo(getUebersetzung("Echte Buchung")); ?>
		</td>
	</tr>
	<tr>
           <td><?php echo(getUebersetzung("Beschreibung")); ?></td>
           <td><textarea name="beschreibung"><?php echo getMieterBeschreibung($mieter_id) ?></textarea></td>
	</tr>
</table>
<br/>
<input name="gastAendern" type="submit" id="gastAendern" class="button" value="<?php echo(getUebersetzung("ändern")); ?>">
<input name="mieter_id" type="hidden" id="gast_id" value="<?php echo($mieter_id); ?>">
<input name="index" type="hidden" value="<?php echo($index); ?>"/>
</form>
<?php	  
include_once($root."/backoffice/templates/footer.inc.php");
?>
