<?php $root="../..";

include_once($root."/templates/header.inc.php");

include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/include/sucheFunctions.inc.php");

//check user inputs:
	$datepickerDatumVon = $_POST["datumVon"];
	$datepickerDatumBis = $_POST["datumBis"];
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
	
	$fehler = false;
	if (!isDatumEarlier($vonMinute,$vonStunde,$vonTag, $vonMonat, 
			$vonJahr, $bisMinute,$bisStunde,$bisTag, $bisMonat, $bisJahr)){
				$fehler = true;
				$nachricht = "Das Reservierungs-Datum wurde nicht korrekt angegeben, " .
						"bitte korrigieren Sie das Datum Ihrer Anfrage";
				$nachricht = getUebersetzung($nachricht);
			}
	
	$freieMo = searchFreieMietobjekte($gastro_id, $vonTag, $vonMonat, $vonJahr, $vonMinute, $vonStunde, 
						$bisTag, $bisMonat, $bisJahr, $bisMinute, $bisStunde); 
	if (count($freieMo) <= 0){ 
		$fehler = true;
		$nachricht = getUebersetzung("Leider konnte innerhalb des gew�hlten Zeitraumes kein")." ";
		$mietobjekt_einzahl = getMietobjekt_EZ($gastro_id);
		$nachricht.= getUebersetzungGastro($mietobjekt_einzahl,$sprache,$gastro_id)." ";
		$nachricht.= getUebersetzung("gefunden werden.<br/>");
		$nachricht.= getUebersetzung("Bitte wiederholen sie ihre Suche mit ver�nderten Suchparametern");
	}

	if ($fehler){
		include_once("./index.php");
		exit;	
	}

include_once($root."/templates/bodyStart.inc.php"); 
?>
<table border="0" class="<?php echo TABLE_STANDARD ?>">
  <tr>
    <td><?php echo getUebersetzung("Suchanfrage f�r") ?>:</td>
  </tr>
  <tr>
    <td><?php 
			$mietobjekt_einzahl = getMietobjekt_EZ($gastro_id);
			echo(getUebersetzungGastro($mietobjekt_einzahl,$sprache,$gastro_id));
		?>
	</td>
  </tr>
  <tr>
    <td><?php echo getUebersetzung("von") ?>: <?php echo $vonTag ?>.<?php echo $vonMonat ?>.<?php echo $vonJahr ?> 
    	<?php echo $vonStunde ?>:<?php echo $vonMinute ?> <?php echo getUebersetzung("Uhr") ?></td>
  </tr>
  <tr>
    <td><?php echo getUebersetzung("bis") ?>: <?php echo $bisTag ?>.<?php echo $bisMonat ?>.<?php echo $bisJahr ?> 
    	<?php echo $bisStunde ?>:<?php echo $bisMinute ?> <?php echo getUebersetzung("Uhr") ?></td>
  </tr>
</table>
<br/>
<form action="../anfrage/index.php" method="post" name="reservierung" target="_self" id="reservierung">
  <input name="datumVon" type="hidden"  value="<?php echo $datumVon ?>"/>
  <input name="datumBis" type="hidden"  value="<?php echo $datumBis ?>"/>
  <input name="bisMinute" type="hidden" value="<?php echo $bisMinute ?>"/>
  <input name="bisStunde" type="hidden" value="<?php echo $bisStunde ?>"/>
  <input name="vonMinute" type="hidden" value="<?php echo $vonMinute ?>"/>
  <input name="vonStunde" type="hidden" value="<?php echo $vonStunde ?>"/>
  <br/>
  <table border="0" class="<?php echo TABLE_STANDARD ?>">
    <tr>
      <td>
      	<span class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
      		<?php echo(getUebersetzung("Freie")." "); 
      			  $mietobjekt_mehrzahl = getMietobjekt_MZ($gastro_id);
	  			  echo(getUebersetzungGastro($mietobjekt_mehrzahl,$sprache,$gastro_id));
				  echo(" ".getUebersetzung("im gew�nschten Zeitraum").":" );
	  		?><br/>
        </span>
	  </td>
    </tr>
    <?php
	$zaehle = 0;
	foreach($freieMo as $mietobjekt_id){ 
	?>
    <tr>
	 	<td>
	 		<input type="radio" name="mietobjekt_id" value="<?php echo $mietobjekt_id ?>"
		      <?php
		      	if ($zaehle++ == 0){
		      		echo("checked=\"checked\"");
		      	}
		      ?>
     		 /> <?php echo getMietobjektBezeichnung($mietobjekt_id) ?>
	 	</td>
	</tr>
    <?php
	}
	?>
    <tr>
      <td><input name="reservierungAbsenden" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		   onMouseOut="this.className='<?php echo BUTTON ?>';" id="reservierungAbsenden" value="<?php echo(getUebersetzung("Reservierung starten...")); ?>"></td>
    </tr>
  </table>
</form>
<?php
	include_once($root."/templates/footer.inc.php");
?>
