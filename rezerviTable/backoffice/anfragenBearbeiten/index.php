<?php 
$root = "../..";
$ueberschrift = "Anfragen bearbeiten";
/*   
	date: 7.10.05
	@author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/autoResponseFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");

if (!hasVermieterReservations($gastro_id,STATUS_RESERVIERT)){
	$fehler = true;
	$nachricht = "Es sind keine offenen Reservierungsanfragen gespeichert.";
	$nachricht = getUebersetzung($nachricht);
}

include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Anfragen", "anfragenBearbeiten/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php");

if (hasVermieterReservations($gastro_id,STATUS_RESERVIERT)){
?>
<script language="JavaScript">
	<!--
	    function sicher(){
	    return confirm("<?php echo(getUebersetzung("Anfrage wirklich löschen?")); ?>"); 	    
	    }
	    //-->
</script>

<table>
	<tr>
  		<td><?php echo(getUebersetzung("Reservierungsanfragen bestätigen oder löschen")); ?>
		</td>
  	</tr>
  	<tr></tr>
  <tr>
    <td>
    	<?php echo getUebersetzung("Hier sehen Sie die Liste mit noch nicht bestätigten Reservierungsanfragen.") ?><br/>
	        <ul>
	        	<li><?php echo getUebersetzung("Falls Sie eine Reservierungsanfrage bestätigen wird " .
	        			"diese als \"reserviert\" eingetragen, " .
	        			"der Gast wird darüber nur informiert wenn die automatischen " .
	        			"E-Mails aktiviert wurden.") ?></li>
	        	<li><?php echo getUebersetzung("Ein Gast kann nur gelöscht werden, falls es keine " .
	        		"anderen Reservierungen für diesen Gast gibt.") ?></li>
	        	<li><?php echo getUebersetzung("Falls ein Gast in einer Anfrage mehrere" .
	        			" Tische reserviert hat, ist für jeden Tisch einzeln" .
	        			" die Anfrage zu bearbeiten.") ?></li>
	        </ul>
     
    </td>
  </tr>
</table>
<hr/>	
  <?php //sodala, nun alle reservierungen mit status=1 auslesen, wenn
		$res = getReservationsOfVermieter($gastro_id,STATUS_RESERVIERT);
		while($d = $res->FetchNextObject()){
			$reservierungs_id = $d->RESERVIERUNG_ID;
			$mieter_id = $d->GAST_ID;
			$mieter = getMieterVorname($mieter_id)." ".getNachnameOfMieter($mieter_id).", ".getMieterOrt($mieter_id);
			$date = getDatumVonOfReservierung($reservierungs_id);
			$zeitraum = getYearFromBooklineDate($date)."-".getMonthFromBooklineDate($date)."-".
						getDayFromBooklineDate($date)." ".getHourFromBooklineDate($date).":".
						getMinuteFromBooklineDate($date);
			$tisch_id = $d->TISCH_ID;
			$raum_id = getRaumOfTisch($tisch_id);
			$mietobjekt = getRaumBezeichnung($raum_id)." ".$tisch_id;
			?>
<table>
  <tr></tr><tr></tr>
        <tr>
          <td><span><?php echo(getUebersetzung("Reservierungsanfrage von")); ?>:</span> <?php echo $mieter ?></td>
        </tr>
        <tr>
          <td><span><?php echo(getUebersetzung("Datum/Uhrzeit")); ?>:</span> <?php echo $zeitraum ?> <?php echo(getUebersetzung("Uhr")); ?></td>
        </tr>
        <tr>
          <td><span><?php echo(getUebersetzung("Raum/Tisch")); ?>:</span> <?php echo $mietobjekt ?></td>
        </tr>
</table>
<table>
        <form action="<?php echo $root ?>/backoffice/anfragenBearbeiten/gastInfo/index.php" 
        	method="post" name="mieterInfos" target="_self">
          <tr valign="middle">
            <td>
            	<input name="mieter_id" type="hidden" value="<?php echo $mieter_id ?>"/>
                <input name="gastInfos" type="submit" id="gastInfos" 
	              	value="<?php echo(getUebersetzung("Gast-Infos")); ?>" 
	              	class="button"/>
       		</td>
        </form>
        <form action="./anfrageLoeschen.php" method="post" name="reservierungEntfernen" target="_self" onSubmit="return sicher()">
            <td><input name="mieter_id" type="hidden" value="<?php echo $mieter_id ?>">
              <input name="reservierungs_id" type="hidden" value="<?php echo $reservierungs_id ?>"/>
              <input name="entfernen" type="submit" id="entfernen" 
              	value="<?php echo(getUebersetzung("Löschen")); ?>" 
              	class="button"/>
              <input name="mieterEntfernen" type="checkbox" id="mieterEntfernen" value="true">
              <?php echo(getUebersetzung("Gast löschen")); ?>
              <?php
			  //automatische absage muß hier nochmals best�tigt werden,
			  //allerdings nur wenn sie auch aktiv ist:
			  if (isMessageActive($gastro_id,BUCHUNGS_ABLEHNUNG)){
			  ?>
				  <input name="antwort" type="checkbox" id="antwort" value="true" checked="checked" />
				 
				  <?php echo(getUebersetzung("automatische Absage senden")); ?>
              <?php
			  }
			  ?>
            </td>
        </form>
        <form action="./anfrageBestaetigen.php" method="post" name="reservierungBestaetigen" target="_self" id="reservierungBestaetigen">
            <td><input name="reservierungs_id" type="hidden" value="<?php echo($reservierungs_id); ?>"/>
              <input type="submit" name="submit" 
              	     value="<?php echo(getUebersetzung("Bestätigen")); ?>" 
              	     class="button">
              <?php
               if (isMessageActive($gastro_id,BUCHUNGS_BESTAETIGUNG)){
			  ?>
				  <input name="antwort" type="checkbox" id="antwort" value="true" checked="checked" />
				  
				  <?php echo(getUebersetzung("automatische Bestätigung senden")); ?>
              <?php
			  }
			  ?>
            </td>
          </tr>
        </form>
</table>
<hr/>
<?php	}//ende while
}//ende else
include_once($root."/backoffice/templates/footer.inc.php");
?>