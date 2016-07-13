<?php $root = "../..";

/*   
	date: 7.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/autoResponseFunctions.inc.php");

if (!hasVermieterReservations($vermieter_id,STATUS_RESERVIERT)){
	$fehler = true;
	$nachricht = "Es sind keine offenen Reservierungsanfragen gespeichert.";
	$nachricht = getUebersetzung($nachricht);
}

include_once($root."/webinterface/templates/bodyStart.inc.php");

if (hasVermieterReservations($vermieter_id,STATUS_RESERVIERT)){
?>
<script language="JavaScript">
	<!--
	    function sicher(){
	    return confirm("<?php echo(getUebersetzung("Anfrage wirklich löschen?")); ?>"); 	    
	    }
	    //-->
</script>
<p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Reservierungsanfragen bestätigen oder löschen")); ?></p>
<table width="100%" border="0" cellpadding="0" cellspacing="3">
  <tr>
    <td><p class="<?php echo STANDARD_SCHRIFT ?>">
    	<?php echo getUebersetzung("Hier sehen Sie die Liste mit noch nicht bestätigten Reservierungsanfragen.") ?><br/>
	        <ul class="<?php echo STANDARD_SCHRIFT ?>">
	        	<li><?php echo getUebersetzung("Falls Sie eine Reservierungsanfrage bestätigen wird " .
	        			"diese als \"belegt\" im Reservierungsplan eingetragen, " .
	        			"der Mieter wird darüber nur informiert wenn die automatischen " .
	        			"E-Mails aktiviert wurden.") ?></li>
	        	<li><?php echo getUebersetzung("Ein Mieter kann nur gelöscht werden, falls es keine " .
	        		"anderen Reservierungen für diesen Mieter gibt.") ?></li>
	        	<li><?php echo getUebersetzung("Falls ein Mieter in einer Buchung mehrere" .
	        			" Mietobjekte reserviert hat, ist für jedes Mietobjekt einzeln" .
	        			" die Anfrage zu bearbeiten.") ?></li>
	        </ul>
        </p>
    </td>
  </tr>
</table>
<p>
  <?php //sodala, nun alle reservierungen mit status=1 auslesen, wenn
		$res = getReservationsOfVermieter($vermieter_id,STATUS_RESERVIERT);
		while($d = mysql_fetch_array($res)){
			$reservierungs_id = $d["RESERVIERUNG_ID"];
			$mieter_id = $d["MIETER_ID"];
			$mieter = getMieterVorname($mieter_id)." ".getNachnameOfMieter($mieter_id).", ".getMieterOrt($mieter_id);
			$zeitraum = getDatumVonOfReservierung($reservierungs_id)." bis ".getDatumBisOfReservierung($reservierungs_id);
			$mietobjekt = getMietobjektBezeichnung($d["MIETOBJEKT_ID"]);
			?>
</p>
<table width="100%" border="0" cellspacing="3" cellpadding="0" class="<?php echo TABLE_STANDARD ?>">
  <tr>
    <td><table border="0" cellspacing="0" cellpadding="0" class="<?php echo STANDARD_SCHRIFT ?>">
        <tr>
          <td><span class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Anfrage von")); ?>:</span> <?php echo $mieter ?></td>
        </tr>
        <tr>
          <td><span class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Zeitraum")); ?>:</span> von <?php echo $zeitraum ?></td>
        </tr>
        <tr>
          <td><span class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Mietobjekt")); ?>:</span> <?php echo $mietobjekt ?></td>
        </tr>
        <form action="<?php echo $root ?>/webinterface/anfragenBearbeiten/gastInfo/index.php" method="post" name="mieterInfos" target="_self">
          <tr>
            <td><input name="mieter_id" type="hidden" value="<?php echo $mieter_id ?>"/>
              <input name="gastInfos" type="submit" id="gastInfos" value="<?php echo(getUebersetzung("Mieter-Infos anzeigen")); ?>" 
              	class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       			onMouseOut="this.className='<?php echo BUTTON ?>';"/></td>
          </tr>
        </form>
        <form action="./anfrageLoeschen.php" method="post" name="reservierungEntfernen" target="_self" onSubmit="return sicher()">
          <tr>
            <td><input name="mieter_id" type="hidden" value="<?php echo $mieter_id ?>">
              <input name="reservierungs_id" type="hidden" value="<?php echo $reservierungs_id ?>"/>
              <input name="entfernen" type="submit" id="entfernen" 
              	value="<?php echo(getUebersetzung("Anfrage löschen")); ?>" 
              	class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       			onMouseOut="this.className='<?php echo BUTTON ?>';"/>
              <input name="mieterEntfernen" type="checkbox" id="mieterEntfernen" value="true">
              <?php echo(getUebersetzung("Mieter aus Datenbank löschen")); ?>
              <?php
			  //automatische absage muss hier nochmals bestätigt werden,
			  //allerdings nur wenn sie auch aktiv ist:
			  if (isMessageActive($vermieter_id,BUCHUNGS_ABLEHNUNG)){
			  ?>
				  <input name="antwort" type="checkbox" id="antwort" value="true" checked="checked" />
				 
				  <?php echo(getUebersetzung("automatische Absage senden")); ?>
              <?php
			  }
			  ?>
            </td>
          </tr>
        </form>
        <form action="./anfrageBestaetigen.php" method="post" name="reservierungBestaetigen" target="_self" id="reservierungBestaetigen">
          <tr>
            <td><input name="reservierungs_id" type="hidden" value="<?php echo($reservierungs_id); ?>"/>
              <input type="submit" name="submit" 
              	     value="<?php echo(getUebersetzung("Anfrage bestätigen")); ?>" 
              	     class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
      				 onMouseOut="this.className='<?php echo BUTTON ?>';">
              <?php
               if (isMessageActive($vermieter_id,BUCHUNGS_BESTAETIGUNG)){
			  ?>
				  <input name="antwort" type="checkbox" id="antwort" value="true" checked="checked" />
				  
				  <?php echo(getUebersetzung("automatische Bestätigung senden")); ?>
              <?php
			  }
			  ?>
            </td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
<?php	}//ende while
	}//ende else
include_once($root."/webinterface/templates/footer.inc.php");
?>