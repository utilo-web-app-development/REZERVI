<?php 
$root = "../../..";
$ueberschrift = "Reservierungen bearbeiten";
$unterschrift = "Listenansicht";
$unterschrift1 = "GastInfo";

/*   
	date: 4.11.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, $ueberschrift, "reservierung/index.php",
							$unterschrift, "reservierung/index.php?ansicht=LISTENANSICHT",
							$unterschrift1, "");
include_once($root."/backoffice/templates/bodyStart.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/backoffice/templates/components.inc.php"); 
include_once($root."/include/datumFunctions.inc.php");

$gast_id = $_POST["gast_id"];

?>

<table class="moduletable_line" >
  <tr >
  	<td colspan=2><?php echo(getUebersetzung("Gast Informationen")); ?>:
	</td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Anrede")); ?></td>
    <td><?php echo(getMieterAnrede($gast_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Vorname")); ?></td>
    <td><?php echo(getMieterVorname($gast_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Nachname")); ?></td>
    <td><?php echo(getNachnameOfMieter($gast_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Straße/Hausnummer")); ?></td>
    <td><?php echo(getMieterStrasse($gast_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("PLZ")); ?></td>
    <td><?php echo(getMieterPlz($gast_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Ort")); ?></td>
    <td><?php echo(getMieterOrt($gast_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Land")); ?></td>
    <td><?php echo(getMieterLand($gast_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("E-Mail-Adresse")); ?></td>
    <td><?php echo(getEmailOfMieter($gast_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Telefonnummer")); ?></td>
    <td><?php echo(getMieterTel($gast_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("2. Telefonnummer")); ?></td>
    <td><?php echo(getMieterTel2($gast_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Faxnummer")); ?></td>
    <td><?php echo(getMieterFax($gast_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Homepage")); ?></td>
    <td><?php echo(getMieterUrl($gast_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Sprache")); ?></td>
    <td>
    	<?php
			$bezeichnung = getBezeichnungOfSpracheID(getSpracheOfMieter($gast_id));
			echo(getUebersetzung($bezeichnung));
		?>&nbsp;
	</td>
  </tr>
</table>
<br/><br/>
<table>
	<tr>
		<td><?php echo(getUebersetzung("Es liegen folgende Reservierungen für den Gast vor")); ?>:
		</td>
	</tr>
</table>
<br/><br/>
<table class="moduletable_line">
		  <tr >
			<td><?php echo(getUebersetzung("Datum/Uhrzeit")); ?></td>
			<td><?php echo(getUebersetzung("Tisch")); ?></td>
		  </tr>
			<!-- ausgeben der reservierungen: -->
			<?php
				$res = getReservationsOfMieter($gast_id);
				while($d = $res->FetchNextObject()){
					//variablen auslesen:
					$tisch_id =$d->TISCH_ID;
					$raum_id = getRaumOfTisch($tisch_id);
					$bezeichnung = getRaumBezeichnung($raum_id)." ".$tisch_id;
					$datumVon = getFormatedDateFromBooklineDate($d->VON);
			 ?>
		              <tr>
		                <td><?php echo($datumVon); ?></td>
		                <td><?php echo($bezeichnung); ?></td>
		  			  </tr>
				<?php 
					} //ende while
				?>
</table>
<br/>
<table>
  <tr>
    <td>      
        <input type="submit" name="Submit" class="button" value="<?php echo(getUebersetzung("zurück")); ?>" onclick="javascript:history.back();">
    </td>
  </tr>
</table>
<?php	
include_once($root."/backoffice/templates/footer.inc.php");
?>