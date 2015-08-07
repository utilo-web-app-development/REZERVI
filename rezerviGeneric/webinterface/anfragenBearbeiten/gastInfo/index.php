<? $root = "../../..";

/*   
	date: 20.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/autoResponseFunctions.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php");

$mieter_id = $_POST["mieter_id"]; 
?>

<p class="ueberschrift"><?php echo(getUebersetzung("Informationen über den Mieter")); ?>:</p>
<form action="../index.php" method="post" name="form1" target="_self" >
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><table border="0" cellspacing="3" cellpadding="0">
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Anrede")); ?></td>
            <td> <input name="anrede" type="text" id="anrede" value="<?php echo(getMieterAnrede($mieter_id)); ?>" readonly="readonly"> 
            </td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Vorname")); ?></td>
            <td><input name="vorname" type="text" id="vorname" value="<?php echo(getMieterVorname($mieter_id)); ?>" readonly="readonly"></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Nachname")); ?></td>
            <td><input name="nachname" type="text" id="nachname" value="<?php echo(getNachnameOfMieter($mieter_id)); ?>" readonly="readonly"></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Firma")); ?></td>
            <td><input name="firma" type="text" id="firma" value="<?php echo(getMieterFirma($mieter_id)); ?>" readonly="readonly"></td>
          </tr>          
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Straße/Hausnummer")); ?></td>
            <td><input name="strasse" type="text" id="strasse" value="<?php echo(getMieterStrasse($mieter_id)); ?>" readonly="readonly"></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("PLZ")); ?></td>
            <td><input name="plz" type="text" id="plz" value="<?php echo(getMieterPLZ($mieter_id)); ?>" readonly="readonly"></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Ort")); ?></td>
            <td><input name="ort" type="text" id="ort" value="<?php echo(getMieterOrt($mieter_id)); ?>" readonly="readonly"></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Land")); ?></td>
            <td><input name="land" type="text" id="land" value="<?php echo(getMieterLand($mieter_id)); ?>" readonly="readonly"></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("E-Mail-Adresse")); ?></td>
            <td><input name="email" type="text" id="email" value="<?php echo(getEmailOfMieter($mieter_id)); ?>" readonly="readonly"></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Telefonnummer")); ?></td>
            <td><input name="tel" type="text" id="tel" value="<?php echo(getMieterTel($mieter_id)); ?>" readonly="readonly"></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("2. Telefonnummer")); ?></td>
            <td><input name="tel" type="text" id="tel" value="<?php echo(getMieterTel2($mieter_id)); ?>" readonly="readonly"></td>     
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Faxnummer")); ?></td>
            <td><input name="fax" type="text" id="fax" value="<?php echo(getMieterFax($mieter_id)); ?>" readonly="readonly"></td>        
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Homepage")); ?></td>
            <td><textarea name="url" readonly="readonly" id="url"><?php echo(getMieterUrl($mieter_id)); ?></textarea></td>     
          </tr>
        </table>
       </td>
    </tr>
    <tr>
    	<td>
    	<?php
    	if(hasMieterReservations($mieter_id)){
		?>
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
					$datumBis = $d["BIS"];
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
		<?
		}
		?>
    	</td>
    </tr>
  </table>
   <p>
    <input type="submit" name="Submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück")); ?>">
  </p>
</form>
<?php	
include_once($root."/webinterface/templates/footer.inc.php");
?>
