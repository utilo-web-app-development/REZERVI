<? $root = "../..";

/*   
	date: 1.11.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");

include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");

$datepickerDatumVon = $_POST["datumVon"];
$datepickerDatumBis = $_POST["datumBis"];
$ansicht = $_POST["ansicht"];
$status = $_POST["status"];
$vonTag = getTagFromDatePicker($datepickerDatumVon);
$bisTag = getTagFromDatePicker($datepickerDatumBis);
$bisMinute=$_POST["bisMinute"];
$bisStunde=$_POST["bisStunde"];
$vonMonat = getMonatFromDatePicker($datepickerDatumVon);
$bisMonat = getMonatFromDatePicker($datepickerDatumBis);
$vonJahr = getJahrFromDatePicker($datepickerDatumVon);
$vonMinute=$_POST["vonMinute"];
$vonStunde=$_POST["vonStunde"];
$bisJahr = getJahrFromDatePicker($datepickerDatumBis);
$mietobjekt_id = $_POST["mietobjekt_id"];
if (isset($_POST["mieter_id"])){
	$mieter_id = $_POST["mieter_id"];
}
else{
	$mieter_id = NEUER_MIETER;
}

if(! isDatumEarlier($vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr)){
	$fehler = true;
	$nachricht = "Das gewählte Datum ist nicht korrekt! Das von Datum liegt nach dem bis Datum.";
	$nachricht = getUebersetzung($nachricht);
	include_once($root."/webinterface/reservierung/index.php");
	exit;
}

if (isMietobjektTaken($mietobjekt_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr) 
		&& ($status == STATUS_BELEGT)){
	$fehler = true;
	$nachricht = "Zu diesem Datum existiert bereits eine Reservierung oder die Reservierungen überschneiden sich. Bitte korrigieren Sie das Datum oder löschen Sie die bereits vorhandene Reservierung.";
	$nachricht = getUebersetzung($nachricht);
	include_once($root."/webinterface/reservierung/index.php");
	exit;
}

include_once($root."/webinterface/templates/bodyStart.inc.php"); 

?>

<table border="0" cellpadding="0" cellspacing="0" class="<?= TABLE_COLOR ?>">
  <tr>
    <td>
    	<?php echo(getUebersetzung("Reservierungs-Änderung für")); ?> <?php echo(getUebersetzungVermieter(getMietobjektBezeichnung($mietobjekt_id),$sprache,$vermieter_id)); ?>
    		<br/>
        <?php echo(getUebersetzung("von")); ?>:<span class="<?= STANDARD_SCHRIFT_BOLD ?>"> <?= $vonTag ?>. <?= $vonMonat ?>. <?= $vonJahr ?>, <?= $vonStunde ?>:<?= $vonMinute ?> <?= getUebersetzung("Uhr"); ?></span>
        	<br/>
        <?php echo(getUebersetzung("bis")); ?>:<span class="<?= STANDARD_SCHRIFT_BOLD ?>"> <?= $bisTag ?>. <?= $bisMonat ?>. <?= $bisJahr ?>, <?= $bisStunde ?>:<?= $bisMinute ?> <?= getUebersetzung("Uhr"); ?></span>
        	<br/>
        <?php echo(getUebersetzung("Status")); ?>: 
        <span class="<?= parseStatus($status) ?>"><?= getUebersetzung(parseStatus($status)) ?></span>
    </td>
  </tr>
</table>
<?php 
//wenn belegt oder reserviert eingabe des mieters fordern:
if ($status != STATUS_FREI) { ?>
  <br/>	
  <form action="./resEintragen.php" method="post" name="noAdressForm" target="_self" id="noAdressForm">
  <input type="hidden" name="ansicht" value="<?= $ansicht ?>"/>
  <table border="0" cellspacing="0" cellpadding="3" class="<?= TABLE_STANDARD ?>">
    <tr>
  		<td>
  			<?php echo(getUebersetzung("Wenn sie keinen Mieter klicken wird die Reservierung für einen anonymen Mieter gespeichert")); ?>.
  		</td>
  	</tr>
  	<tr>
  		<td>
  		  <input name="mieter_id" type="hidden" id="mieter_id" value="<?= ANONYMER_MIETER_ID ?>">
          <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?= $mietobjekt_id ?>">
          <input name="vonTag" type="hidden" id="vonTag" value="<?= $vonTag ?>">
          <input name="bisTag" type="hidden" id="bisTag" value="<?= $bisTag ?>">
          <input name="vonMonat" type="hidden" id="vonMonat" value="<?= $vonMonat ?>">
          <input name="bisMonat" type="hidden" id="bisMonat" value="<?= $bisMonat ?>">
          <input name="vonJahr" type="hidden" id="vonJahr" value="<?= $vonJahr ?>">
          <input name="bisJahr" type="hidden" id="bisJahr" value="<?= $bisJahr ?>">
          <input name="vonMinute" type="hidden" id="vonMinute" value="<?= $vonMinute ?>">
          <input name="bisMinute" type="hidden" id="bisMinute" value="<?= $bisMinute ?>">
          <input name="bisStunde" type="hidden" id="bisStunde" value="<?= $bisStunde ?>">
          <input name="vonStunde" type="hidden" id="vonStunde" value="<?= $vonStunde ?>">
		  <input name="status" type="hidden" id="status" value="<?= $status ?>">
          <input name="monat" type="hidden" id="monat" value="<?= $vonMonat ?>">
          <input name="jahr" type="hidden" id="jahr" value="<?= $vonJahr ?>">
          <input name="send" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?= BUTTON ?>';" id="send" value="<?php echo(getUebersetzung("keinen Mieter eingeben")); ?>">
  		</td>
  	</tr>
  </table>
  </form>
  <br/>
<table border="0" cellspacing="0" cellpadding="0" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td>
    	<p class="<?= STANDARD_SCHRIFT ?>">
    		<?php echo(getUebersetzung("Bitte geben Sie hier den Mieter ein, oder wählen Sie einen bereits vorhanden Mieter aus der Liste aus")); ?>:
    	</p>
    	<p>(<?php echo(getUebersetzung("Die mit * gekennzeichneten Felder müssen ausgefüllt werden")); ?>!)         
        </p>  
      <form action="./resAendern.php" method="post" name="gastWaehlen" target="_self">  
      <input type="hidden" name="ansicht" value="<?= $ansicht ?>"/>    	
        <table border="0" cellspacing="0" cellpadding="0">
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("Mieter auswählen")); ?></td>
            <td>
            	<select name="mieter_id" id="select" onChange="submit()">
	                <option value="<?= NEUER_MIETER ?>" selected><?php echo(getUebersetzung("neuer Mieter")); ?></option>
	                <?php 
	                $res = getAllMieterFromVermieter($vermieter_id);
					while($d = mysql_fetch_array($res)) {
						$mie_id = $d["MIETER_ID"];
						$nachname = getNachnameOfMieter($mie_id);
						$vorname = getMieterVorname($mie_id);
						$ort = getMieterOrt($mie_id);
						$temp = $nachname." ".$vorname." ".$ort;
					?>
	                	<option value="<?= $mie_id ?>" <?php if ($mie_id == $mieter_id) {?> selected="selected" <?php } ?>><?= $temp ?></option>
	                <?php				
					} //ende while						
					?>
              	</select>
             </td>
          </tr>
        </table>        
        <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?= $mietobjekt_id ?>">
        <input name="datumVon" type="hidden" id="vonTag" value="<?= $datepickerDatumVon ?>">
        <input name="datumBis" type="hidden" id="bisTag" value="<?= $datepickerDatumBis ?>">
        <input name="vonMinute" type="hidden" id="vonMinute" value="<?= $vonMinute ?>">
        <input name="bisMinute" type="hidden" id="bisMinute" value="<?= $bisMinute ?>">
        <input name="bisStunde" type="hidden" id="bisStunde" value="<?= $bisStunde ?>">
        <input name="vonStunde" type="hidden" id="vonStunde" value="<?= $vonStunde ?>">
        <input name="jahr" type="hidden" id="vonJahr" value="<?= $vonJahr ?>">
        <input name="status" type="hidden" id="status" value="<?= $status ?>">
      </form>
      
      <form action="./resEintragen.php" method="post" name="adresseForm" target="_self" id="adresseForm" onSubmit="return chkFormular()">    
	    <input name="mieter_id" type="hidden" value="<?= $mieter_id ?>">
	    <input type="hidden" name="ansicht" value="<?= $ansicht ?>"/>
	    <table border="0" cellspacing="0" cellpadding="3" class="<?= TABLE_STANDARD ?>">
          <tr> 
            <td><?php echo(getUebersetzung("Anrede")); ?></td>
            <td>
				<input name="anrede" type="text" id="anrede" 
					value="<?php if ($mieter_id != -1) { echo(getMieterAnrede($mieter_id)); } ?>" /> 
            </td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Vorname")); ?></td>
            <td><input name="vorname" type="text" 
					value="<?php if ($mieter_id != -1) { echo(getMieterVorname($mieter_id)); } ?>" /></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Nachname")); ?></td>
            <td><input name="nachname" type="text" 
            		value="<?php if ($mieter_id != -1) { echo(getNachnameOfMieter($mieter_id)); } ?>" />*</td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Firma")); ?></td>
            <td><input name="firma" type="text" 
            		value="<?php if ($mieter_id != -1) { echo(getMieterFirma($mieter_id)); } ?>" /></td>
          </tr>          
          <tr> 
            <td><?php echo(getUebersetzung("Straße/Hausnummer")); ?></td>
            <td><input name="strasse" type="text" 
            		value="<?php if ($mieter_id != -1) { echo(getMieterStrasse($mieter_id)); } ?>" /></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Postleitzahl")); ?></td>
            <td><input name="plz" type="text" 
            		value="<?php if ($mieter_id != -1) { echo(getMieterPlz($mieter_id)); } ?>" /></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Ort")); ?></td>
            <td><input name="ort" type="text" 
            		value="<?php if ($mieter_id != -1) { echo(getMieterOrt($mieter_id)); } ?>" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Land")); ?></td>
            <td><input name="land" type="text" 
            		value="<?php if ($mieter_id != -1) { echo(getMieterLand($mieter_id)); } ?>" /></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("E-Mail-Adresse")); ?></td>
            <td><input name="email" type="text"
            		value="<?php if ($mieter_id != -1) { echo(getEmailOfMieter($mieter_id)); } ?>" /></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Telefonnummer")); ?></td>
            <td><input name="tel" type="text" 
            		value="<?php if ($mieter_id != -1) { echo(getMieterTel($mieter_id)); } ?>" /></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("2. Telefonnummer")); ?></td>
            <td><input name="tel2" type="text" 
            		value="<?php if ($mieter_id != -1) { echo(getMieterTel2($mieter_id)); } ?>" /></td>
          </tr>
          <tr>
            <td><?php echo(getUebersetzung("Faxnummer")); ?></td>
            <td><input name="fax" type="text" 
            		value="<?php if ($mieter_id != -1) { echo(getMieterFax($mieter_id)); } ?>" /></td>
          </tr>
          <tr>
            <td><?php echo(getUebersetzung("Homepage")); ?></td>
            <td><input name="url" type="text" 
            		value="<?php if ($mieter_id != -1) { echo(getMieterUrl($mieter_id)); } ?>" /></td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("bevorzugte Sprache")); ?></td>
            <td><select name="speech" id="speech">
            	<?php
            	//sprachen des belegungsplanes anzeigen:
            	$stdSpr= getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
            	$res = getActivtedSprachenOfVermieter($vermieter_id);
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
         </table>
      
        <p> 		  
          <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?= $mietobjekt_id ?>">
          <input name="vonTag" type="hidden" id="vonTag" value="<?= $vonTag ?>">
          <input name="bisTag" type="hidden" id="bisTag" value="<?= $bisTag ?>">
          <input name="vonMonat" type="hidden" id="vonMonat" value="<?= $vonMonat ?>">
          <input name="bisMonat" type="hidden" id="bisMonat" value="<?= $bisMonat ?>">
          <input name="vonJahr" type="hidden" id="vonJahr" value="<?= $vonJahr ?>">
          <input name="bisJahr" type="hidden" id="bisJahr" value="<?= $bisJahr ?>">
		  <input name="status" type="hidden" id="status" value="<?= $status ?>">
          <input name="monat" type="hidden" id="vonMonat2" value="<?= $vonMonat ?>">
          <input name="vonMinute" type="hidden" id="vonMinute" value="<?= $vonMinute ?>">
          <input name="bisMinute" type="hidden" id="bisMinute" value="<?= $bisMinute ?>">
          <input name="bisStunde" type="hidden" id="bisStunde" value="<?= $bisStunde ?>">
          <input name="vonStunde" type="hidden" id="vonStunde" value="<?= $vonStunde ?>">
          <input name="jahr" type="hidden" id="vonJahr2" value="<?= $vonJahr ?>">
          <input name="send" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?= BUTTON ?>';" id="send" value="<?php echo(getUebersetzung("weiter")); ?>">
          
	    </p>
	  	</form>
	  	<p>		  	
 	  	<form action="./index.php" method="post" enctype="text/plain">  
 	  	  <input type="hidden" name="ansicht" value="<?= $ansicht ?>"/>	  
          <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?= $mietobjekt_id ?>">
          <input name="vonTag" type="hidden" id="vonTag" value="<?= $vonTag ?>">
          <input name="bisTag" type="hidden" id="bisTag" value="<?= $bisTag ?>">
          <input name="vonMonat" type="hidden" id="vonMonat" value="<?= $vonMonat ?>">
          <input name="bisMonat" type="hidden" id="bisMonat" value="<?= $bisMonat ?>">
          <input name="vonJahr" type="hidden" id="vonJahr" value="<?= $vonJahr ?>">
          <input name="bisJahr" type="hidden" id="bisJahr" value="<?= $bisJahr ?>">
		  <input name="status" type="hidden" id="status" value="<?= $status ?>">
          <input name="monat" type="hidden" id="vonMonat2" value="<?= $vonMonat ?>">
          <input name="vonMinute" type="hidden" id="vonMinute" value="<?= $vonMinute ?>">
          <input name="bisMinute" type="hidden" id="bisMinute" value="<?= $bisMinute ?>">
          <input name="bisStunde" type="hidden" id="bisStunde" value="<?= $bisStunde ?>">
          <input name="vonStunde" type="hidden" id="vonStunde" value="<?= $vonStunde ?>">          
          <input name="jahr" type="hidden" id="vonJahr2" value="<?= $vonJahr ?>">
          <input name="send" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?= BUTTON ?>';" id="send" value="<?php echo(getUebersetzung("abbrechen")); ?>">
        </form>
	    </p>
        <?php } //ende if status != frei
	  	else { //wenn nur frei dann daten löschen und nur ok-button anzeigen:
		?>
			<br/>
			<table cellspacing="0" cellpadding="0" class="<?= BELEGT ?>">
			<?php
			//alle Reservierungen ausgeben die gelöscht werden, wenn auf ok gedrueckt wird:
			$result = getReservationWithDate($mietobjekt_id,0,0,$vonTag,$vonMonat,$vonJahr,0,0,$bisTag,$bisMonat,$bisJahr);
			$first = true;
			while($d = mysql_fetch_array($result)){
				if ($first){ ?>					
					  <tr>
					  	<td>
					  		<?php echo(getUebersetzung("Folgende Reservierungen werden gelöscht")); ?>:
					  	</td>
					  </tr>						 
				<?php }
				$first = false;
				$res_id = $d["RESERVIERUNG_ID"];
				$mie_id = getMieterIdFromReservierung($res_id);
				$datumV = getDatumVonOfReservierung($res_id);
				$datumV = parseMySqlTimestamp($datumV,false,false,true,true,true);
				$datumB = getDatumBisOfReservierung($res_id);
				$datumB = parseMySqlTimestamp($datumB,false,false,true,true,true);
				$gast_nn = getNachnameOfMieter($mie_id);
			?>
				<tr>
					<td class="<?= STANDARD_SCHRIFT ?>">
					<?php
						echo(getUebersetzung("Reservierung von")." ".$datumV." ".getUebersetzung("bis")." ".$datumB.", ".getUebersetzung("Mieter").": ".$gast_nn);
					?>
					</td>
				</tr>
			<?php 
			} //ende while reservierungen anzeigen
			?>
			</table>
			<br/>
			<form name="zimmerFrei" method="post" action="./resEntfernen.php" target="_self">	
			<input type="hidden" name="ansicht" value="<?= $ansicht ?>"/>		
          	<input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?= $mietobjekt_id ?>">
          	<input name="vonTag" type="hidden" id="vonTag" value="<?= $vonTag ?>">
          	<input name="bisTag" type="hidden" id="bisTag" value="<?= $bisTag ?>">
          	<input name="vonMonat" type="hidden" id="vonMonat" value="<?= $vonMonat ?>">
          	<input name="bisMonat" type="hidden" id="bisMonat" value="<?= $bisMonat ?>">
          	<input name="vonJahr" type="hidden" id="vonJahr" value="<?= $vonJahr ?>">
          	<input name="bisJahr" type="hidden" id="bisJahr" value="<?= $bisJahr ?>">
			<input name="monat" type="hidden" id="vonMonat2" value="<?= $vonMonat ?>">
            <input name="vonMinute" type="hidden" id="vonMinute" value="<?= $vonMinute ?>">
            <input name="bisMinute" type="hidden" id="bisMinute" value="<?= $bisMinute ?>">
            <input name="bisStunde" type="hidden" id="bisStunde" value="<?= $bisStunde ?>">
            <input name="vonStunde" type="hidden" id="vonStunde" value="<?= $vonStunde ?>">			
            <input name="jahr" type="hidden" id="vonJahr2" value="<?= $vonJahr ?>">
      		<input name="status" type="hidden" id="status" value="<?= $status ?>">
      		<input name="send2" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       			onMouseOut="this.className='<?= BUTTON ?>';" id="send2" value="<?php echo(getUebersetzung("weiter")); ?>">       
      		</form> 
      		<br/>
			<form action="./index.php" method="post" name="adresseForm" target="_self" id="adresseForm" > 
			  <input type="hidden" name="ansicht" value="<?= $ansicht ?>"/>    
			  <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?= $mietobjekt_id ?>">
			  <input name="monat" type="hidden" id="monat" value="<?= $vonMonat ?>">
			  <input name="jahr" type="hidden" id="jahr" value="<?= $vonJahr ?>">
			  <input name="abbrechen" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		 	onMouseOut="this.className='<?= BUTTON ?>';" id="abbrechen" value="<?php echo(getUebersetzung("abbrechen")); ?>">
			</form>
<?php }
include_once($root."/webinterface/templates/footer.inc.php");
?>