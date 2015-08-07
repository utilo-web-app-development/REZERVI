<?php 

$root="../..";

include_once($root."/templates/header.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");

?>

<script type="text/javascript">

	function chkFormular() {
	     if( (document.adresseForm.vorname.value == "")){
	       alert("<?php echo(getUebersetzung("Bitte geben Sie den Vornamen ein!")); ?>");
	       document.adresseForm.vorname.focus();
	       return false;
	     }
	     else if( (document.adresseForm.nachname.value == "")){
	       alert("<?php echo(getUebersetzung("Bitte geben Sie den Nachnamen ein!")); ?>");
	       document.adresseForm.nachname.focus();
	       return false;
	     }
		 else if( (document.adresseForm.strasse.value == "")){
	       alert("<?php echo(getUebersetzung("Bitte geben Sie die Straße und Hausnummer ein!")); ?>");
	       document.adresseForm.strasse.focus();
	       return false;
	     }
		 else if( (document.adresseForm.plz.value == "")){
	       alert("<?php echo(getUebersetzung("Bitte geben Sie die Postleitzahl ein!")); ?>");
	       document.adresseForm.plz.focus();
	       return false;
	     }
		 else if( (document.adresseForm.ort.value == "")){
	       alert("<?php echo(getUebersetzung("Bitte geben Sie den Wohnort ein!")); ?>");
	       document.adresseForm.ort.focus();
	       return false;
	     }
		 else if( (document.adresseForm.email.value == "")){
	       alert("<?php echo(getUebersetzung("Bitte geben Sie die E-Mail-Adresse ein!")); ?>");
	       document.adresseForm.email.focus();
	       return false;
	     }
		 else{
	     	return true;
		 }
	}	

</script>

<?php

$datepickerDatum = $_POST["datum"];

$tag = getTagFromDatePicker($datepickerDatum);
$monat = getMonatFromDatePicker($datepickerDatum);
$jahr = getJahrFromDatePicker($datepickerDatum);

$tisch_ids = $_POST["tisch_ids"];
$raum_id = $_POST["raum_id"];
$raumBezeichnung = getRaumBezeichnung($raum_id);

$minute = $_POST["minute"]; 
$stunde = $_POST["stunde"];
$personen =  $_POST["personen"];

$datum = $jahr."-".$monat."-".$tag." ".$stunde.":".$minute;

include_once($root."/templates/bodyStart.inc.php"); 

?>
<form action="./send.php" method="post" name="adresseForm" target="_self" id="adresseForm" onSubmit="return chkFormular();">
<table border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_COLOR ?>">
  <tr>
    <td colspan="2">
		<?= getUebersetzung("Tischreservierung für"); ?> <?= $raumBezeichnung ?> <?= getUebersetzung("am"); ?> <?= $datum ?> <?= getUebersetzung("Uhr"); ?>
    </td>
  </tr>
  <?php
  //alle ausgewählten tische nochmals auflisten mit checkboxen:
  foreach ($tisch_ids as $id){
  ?>
  <tr>
    <td>
    	<input type="checkbox" name="tisch_ids[]" value="<?= $id ?>" checked="checked" />		
    </td>
    <td>
    	<?= getUebersetzung("Tisch Nr."); ?> <?= $id ?>
    </td>
  </tr>  
  <?php
	} //ende foreach tisch
  ?>
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
            <td><?php echo(getUebersetzung("Stra&szlig;e/Hausnummer")); ?></td>
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

          <input name="raum_id" type="hidden"  value="<?= $raum_id ?>"/>        
          <input name="tag" type="hidden"  value="<?= $tag ?>"/>          
          <input name="monat" type="hidden"  value="<?= $monat ?>"/>          
          <input name="jahr" type="hidden"  value="<?= $jahr ?>"/>          
          <input name="minute" type="hidden"  value="<?= $minute ?>"/>
          <input name="stunde" type="hidden"  value="<?= $stunde ?>"/> 
          <input name="personen" type="hidden" value="<?= $personen ?>"/>
        </p>
        <p><?php echo(getUebersetzung("Hinweis: Es handelt sich hierbei um eine Reservierungs-Anfrage."));
			?> <?php echo(getUebersetzung("Der Gastronomiebetrieb wird sich mit Ihnen in Verbindung setzen um gegebenenfalls die Reservierung zu bestätigen.")); ?></p>
        </td>
  </tr>
</table>
  <br/>
  <table border="0" cellspacing="3" cellpadding="0">
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