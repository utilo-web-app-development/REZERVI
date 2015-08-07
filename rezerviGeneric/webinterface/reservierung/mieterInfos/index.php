<? $root = "../../..";

/*   
	date: 4.11.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");

include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/webinterface/templates/components.inc.php"); 
include_once($root."/include/datumFunctions.inc.php");

$mieter_id = $_POST["mieter_id"];
$mietobjekt_id = $_POST["mietobjekt_id"];
$jahr  = $_POST["jahr"];
$monat = $_POST["monat"];
$tag   = $_POST["tag"];
if (isset($_POST["ansicht"])){
	$ansicht = $_POST["ansicht"];
}
else{
	$ansicht = getVermieterEigenschaftenWert(STANDARDANSICHT,$vermieter_id);
}

include_once($root."/webinterface/templates/bodyStart.inc.php"); 

?>
<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Mieter Informationen")); ?>:
</p>
<table border="0" cellspacing="3" cellpadding="0" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td><?php echo(getUebersetzung("Anrede")); ?></td>
    <td><?php echo(getMieterAnrede($mieter_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Vorname")); ?></td>
    <td><?php echo(getMieterVorname($mieter_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Nachname")); ?></td>
    <td><?php echo(getNachnameOfMieter($mieter_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Straße/Hausnummer")); ?></td>
    <td><?php echo(getMieterStrasse($mieter_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("PLZ")); ?></td>
    <td><?php echo(getMieterPlz($mieter_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Ort")); ?></td>
    <td><?php echo(getMieterOrt($mieter_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Land")); ?></td>
    <td><?php echo(getMieterLand($mieter_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("E-Mail-Adresse")); ?></td>
    <td><?php echo(getEmailOfMieter($mieter_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Telefonnummer")); ?></td>
    <td><?php echo(getMieterTel($mieter_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("2. Telefonnummer")); ?></td>
    <td><?php echo(getMieterTel2($mieter_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Faxnummer")); ?></td>
    <td><?php echo(getMieterFax($mieter_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Homepage")); ?></td>
    <td><?php echo(getMieterUrl($mieter_id)); ?></td>
  </tr>
  <tr>
    <td><?php echo(getUebersetzung("Sprache")); ?></td>
    <td>
    	<?php
		 	$spr = $d["SPRACHE_ID"];
			$bezeichnung = getBezeichnungOfSpracheID(getSpracheOfMieter($mieter_id));
			echo(getUebersetzung($bezeichnung));
		?>
	</td>
  </tr>
</table>

<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Es liegen folgende Reservierungen für den Mieter vor")); ?>:
</p>
<table  border="1" cellpadding="0" cellspacing="3">
  <tr class="<?= TABLE_COLOR ?>">
	<td><?php echo(getUebersetzung("Reservierung von")); ?></td>
	<td><?php echo(getUebersetzung("bis")); ?></td>
	<td><?php echo(getUebersetzung("für")); ?></td>
  </tr>
	<!-- ausgeben der reservierungen: -->
	<?php
		$res = getReservationsOfMieter($mieter_id);
		while($d = mysql_fetch_array($res)){
			//variablen auslesen:
			$mietobjekt_id = $d["MIETOBJEKT_ID"];
			$bezeichnung = getMietobjektBezeichnung($mietobjekt_id);
			$datumVon = $d["VON"];
			$datumVon = parseMySqlTimestamp($datumVon,true,true,true,true,true);
			$datumBis = $d["BIS"];
			$datumBis = parseMySqlTimestamp($datumBis,true,true,true,true,true);
	 ?>
              <tr class="<?= TABLE_STANDARD ?>">
                <td><?php echo($datumVon); ?></td>
                <td><?php echo($datumBis); ?></td>
                <td><?php echo($bezeichnung); ?></td>
  			  </tr>
		<?php 
			} //ende while
		?>
</table>
<br/>
<table border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td>
      <form action="../index.php" method="post" name="ok" target="_self" id="ok">
	    <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?= $mietobjekt_id ?>">
	    <input name="jahr" type="hidden" id="jahr" value="<?= $jahr ?>">
	    <input name="monat" type="hidden" id="monat" value="<?= $monat ?>">
	    <input name="tag" type="hidden" id="tag" value="<?= $tag ?>">
	    <input name="ansicht" type="hidden" value="<?= $ansicht ?>" />
        <input type="submit" name="Submit" class="<?= BUTTON ?>" id="zurueck" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>">
		<input name="index" type="hidden" value="<?php echo($index); ?>"/>
      </form>      
    </td>
  </tr>
</table>
<?php	
include_once($root."/webinterface/templates/footer.inc.php");
?>