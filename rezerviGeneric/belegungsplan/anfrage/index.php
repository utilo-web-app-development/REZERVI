<?php $root="../..";

include_once($root."/templates/header.inc.php");

include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");

if (!isset($fehler) || $fehler != true){
	$datepickerDatumVon = $_POST["datumVon"];
	$datepickerDatumBis = $_POST["datumBis"];
	if (isset($_POST["ansicht"])){
		$ansicht = $_POST["ansicht"];
	}
	else{
		$ansicht = getVermieterEigenschaftenWert(STANDARDANSICHT,$vermieter_id);
	}
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

	if(! isDatumEarlier($vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr)){
		$fehler = true;
		$nachricht = "Das gewählte Datum ist nicht korrekt! Das \"von Datum\" liegt nach dem \"bis Datum\".";
		$nachricht = getUebersetzung($nachricht);
		include_once($root."/start.php");
		exit;
	}
	
	if (isMietobjektTaken($mietobjekt_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr)){
		$fehler = true;
		$nachricht = "Zu diesem Datum existiert bereits eine Reservierung oder die Reservierungen überschneiden sich. Bitte korrigieren Sie das Reservierungsdatum.";
		$nachricht = getUebersetzung($nachricht);
		include_once($root."/start.php");
		exit;
	}
}
include_once($root."/templates/bodyStart.inc.php"); 

?>
<form action="./send.php" method="post" name="adresseForm" target="_self" id="adresseForm">
<table border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_COLOR ?>">
  <tr>
    <td>
    	<?php	
				//aus belegungsplan aufgerufen: 
				$mietobjektBezeichnung = getMietobjektBezeichnung($mietobjekt_id);
				$mietobjektVermieter   = getMietobjekt_EZ($vermieter_id);
				echo(getUebersetzung("Reservierungs-Anfrage für")."<br/>");				
				echo(getUebersetzungVermieter($mietobjektVermieter  ,$sprache,$vermieter_id)." ");
				echo(getUebersetzungVermieter($mietobjektBezeichnung,$sprache,$vermieter_id));
		  ?>
		  <br/>
      	  		<?php 
      	  		echo(getUebersetzung("von")); ?>:<span class="<?= STANDARD_SCHRIFT_BOLD ?>"> 
      	  			<?php echo($vonTag); ?>.<?php echo($vonMonat); ?>.<?php echo($vonJahr." ".$vonStunde.":".$vonMinute." ".getUebersetzung("Uhr")."<br/>"); 
      	  	    	?>
      	  	    </span>
      	  	    <?php
      	  	    echo(getUebersetzung("bis")); ?>:<span class="<?= STANDARD_SCHRIFT_BOLD ?>"> 
      	  	    	<?php echo($bisTag); ?>.<?php echo($bisMonat); ?>.<?php echo($bisJahr." ".$bisStunde.":".$bisMinute." ".getUebersetzung("Uhr")."<br/>"); 
      	        	?>
      	        </span>
     </td>
  </tr>
</table>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td><p><?php echo(getUebersetzung("Wir benötigen noch folgende Daten von Ihnen")); ?>:</p>
         <table border="0" cellspacing="0" cellpadding="3">
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("Anrede")); ?></td>
            <td>
              <select name="anrede" id="anrede">
                <option value="Familie" <?php if (isset($anrede) && $anrede == "Familie") echo("selected=\"selected\""); ?>><?= getUebersetzung("Familie") ?></option>
                <option value="Frau" <?php if (isset($anrede) && $anrede == "Frau") echo("selected=\"selected\""); ?>><?php echo(getUebersetzung("Frau")); ?></option>
                <option value="Herr" <?php if (isset($anrede) && $anrede == "Herr") echo("selected=\"selected\""); ?>><?php echo(getUebersetzung("Herr")); ?></option>
                <option value="Firma" <?php if (isset($anrede) && $anrede == "Firma") echo("selected=\"selected\""); ?>><?php echo(getUebersetzung("Firma")); ?></option>
              </select> 
             </td>
          </tr>
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("Vorname")); ?></td>
            <td><input name="vorname" type="text" id="vorname" <? if (isset($vorname)) echo("value=\"$vorname\""); ?>/>*</td>
          </tr>
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("Nachname")); ?></td>
            <td><input name="nachname" type="text" id="nachname" <? if (isset($nachname)) echo("value=\"$nachname\""); ?>/>*</td>
          </tr>
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("Firma")); ?></td>
            <td><input name="firma" type="text" id="firma" <? if (isset($firma)) echo("value=\"$firma\""); ?>/></td>
          </tr>          
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("Straße/Hausnummer")); ?></td>
            <td><input name="strasse" type="text" id="strasse" <? if (isset($strasse)) echo("value=\"$strasse\""); ?>/>*</td>
          </tr>
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("PLZ")); ?></td>
            <td><input name="plz" type="text" id="plz" <? if (isset($plz)) echo("value=\"$plz\""); ?>/>*</td>
          </tr>
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("Ort")); ?></td>
            <td><input name="ort" type="text" id="ort" <? if (isset($ort)) echo("value=\"$ort\""); ?>/>*</td>
          </tr>
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("Land")); ?></td>
            <td><input name="land" type="text" id="land" <? if (isset($land)) echo("value=\"$land\""); ?>/></td>
          </tr>
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("E-Mail-Adresse")); ?></td>
            <td><input name="email" type="text" id="email" <? if (isset($email)) echo("value=\"$email\""); ?>/>*</td>
          </tr>
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("Telefonnummer")); ?></td>
            <td><input name="tel" type="text" id="tel" <? if (isset($tel)) echo("value=\"$tel\""); ?>/></td>
          </tr>
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("2. Telefonnummer")); ?></td>
            <td><input name="tel2" type="text" id="tel2" <? if (isset($tel2)) echo("value=\"$tel2\""); ?>/></td>
          </tr>          
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("Faxnummer")); ?></td>
            <td><input name="fax" type="text" id="fax" <? if (isset($fax)) echo("value=\"$fax\""); ?>/></td>
          </tr>
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("Hompage")); ?></td>
            <td><input name="url" type="text" id="url" <? if (isset($url)) echo("value=\"$url\""); ?>/></td>
          </tr>          
          <tr class="<?= STANDARD_SCHRIFT ?>"> 
            <td><?php echo(getUebersetzung("Anmerkungen/Fragen")); ?></td>
            <td><textarea name="anmerkung" id="anmerkung"><? if (isset($anmerkung)) echo($anmerkung); ?></textarea></td>
          </tr>
        </table>
        <p>(<?php echo(getUebersetzung("Die mit * gekennzeichneten Felder müssen ausgefüllt werden!")); ?>) 

          <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?= $mietobjekt_id ?>"/>
		  <input name="ansicht" type="hidden" id="ansicht" value="<?= $ansicht ?>"/>          
          <input name="vonTag" type="hidden" id="vonTag" value="<?= $vonTag ?>"/>
          <input name="bisTag" type="hidden" id="bisTag" value="<?= $bisTag ?>"/>
          <input name="vonMonat" type="hidden" id="vonMonat" value="<?= $vonMonat ?>"/>
          <input name="bisMonat" type="hidden" id="bisMonat" value="<?= $bisMonat ?>"/>
          <input name="vonJahr" type="hidden" id="vonJahr" value="<?= $vonJahr ?>"/>
          <input name="bisJahr" type="hidden" id="bisJahr" value="<?= $bisJahr ?>"/>
          <input name="vonMinute" type="hidden" id="vonMinute" value="<?= $vonMinute ?>"/>
          <input name="bisMinute" type="hidden" id="bisMinute" value="<?= $bisMinute ?>"/>
          <input name="vonStunde" type="hidden" id="vonStunde" value="<?= $vonStunde ?>"/>
          <input name="bisStunde" type="hidden" id="bisStunde" value="<?= $bisStunde ?>"/>
          <input name="bisStunde" type="hidden" id="bisStunde" value="<?= $bisStunde ?>"/>
        </p>
        <p><?php echo(getUebersetzung("Hinweis: Es handelt sich hierbei um eine Reservierungs-Anfrage."));
			?> <?php echo(getUebersetzung("Der Vermieter wird sich mit Ihnen in Verbindung setzen um gegebenenfalls die Reservierung zu bestätigen.")); ?></p>
        </td>
  </tr>
</table>
  <br/>
  <table border="0" cellspacing="3" cellpadding="0" class="<?= TABLE_STANDARD ?>">
    <tr>
      <td><p>
          <input name="send" type="submit" class="<?= BUTTON ?>" 
		  	onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?= BUTTON ?>';" id="send" 
			value="<?php echo(getUebersetzung("Absenden")); ?>">        
        </p>     
    </td>
    </tr>
  </table>
</form>
<?php
	include_once($root."/templates/footer.inc.php");
?>