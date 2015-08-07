<? $root = "../..";

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
	    return confirm("<?php echo(getUebersetzung("Anfrage wirklich l�schen?")); ?>"); 	    
	    }
	    //-->
</script>
<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Reservierungsanfragen best�tigen oder l�schen")); ?></p>
<table width="100%" border="0" cellpadding="0" cellspacing="3">
  <tr>
    <td><p class="<?= STANDARD_SCHRIFT ?>">
    	<?= getUebersetzung("Hier sehen Sie die Liste mit noch nicht best�tigten Reservierungsanfragen.") ?><br/>
	        <ul class="<?= STANDARD_SCHRIFT ?>">
	        	<li><?= getUebersetzung("Falls Sie eine Reservierungsanfrage best�tigen wird " .
	        			"diese als \"belegt\" im Reservierungsplan eingetragen, " .
	        			"der Mieter wird dar�ber nur informiert wenn die automatischen " .
	        			"E-Mails aktiviert wurden.") ?></li>
	        	<li><?= getUebersetzung("Ein Mieter kann nur gel�scht werden, falls es keine " .
	        		"anderen Reservierungen f�r diesen Mieter gibt.") ?></li>
	        	<li><?= getUebersetzung("Falls ein Mieter in einer Buchung mehrere" .
	        			" Mietobjekte reserviert hat, ist f�r jedes Mietobjekt einzeln" .
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
<table width="100%" border="0" cellspacing="3" cellpadding="0" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td><table border="0" cellspacing="0" cellpadding="0" class="<?= STANDARD_SCHRIFT ?>">
        <tr>
          <td><span class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Anfrage von")); ?>:</span> <?= $mieter ?></td>
        </tr>
        <tr>
          <td><span class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Zeitraum")); ?>:</span> von <?= $zeitraum ?></td>
        </tr>
        <tr>
          <td><span class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Mietobjekt")); ?>:</span> <?= $mietobjekt ?></td>
        </tr>
        <form action="<?= $root ?>/webinterface/anfragenBearbeiten/gastInfo/index.php" method="post" name="mieterInfos" target="_self">
          <tr>
            <td><input name="mieter_id" type="hidden" value="<?= $mieter_id ?>"/>
              <input name="gastInfos" type="submit" id="gastInfos" value="<?php echo(getUebersetzung("Mieter-Infos anzeigen")); ?>" 
              	class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       			onMouseOut="this.className='<?= BUTTON ?>';"/></td>
          </tr>
        </form>
        <form action="./anfrageLoeschen.php" method="post" name="reservierungEntfernen" target="_self" onSubmit="return sicher()">
          <tr>
            <td><input name="mieter_id" type="hidden" value="<?= $mieter_id ?>">
              <input name="reservierungs_id" type="hidden" value="<?= $reservierungs_id ?>"/>
              <input name="entfernen" type="submit" id="entfernen" 
              	value="<?php echo(getUebersetzung("Anfrage l�schen")); ?>" 
              	class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       			onMouseOut="this.className='<?= BUTTON ?>';"/>
              <input name="mieterEntfernen" type="checkbox" id="mieterEntfernen" value="true">
              <?php echo(getUebersetzung("Mieter aus Datenbank l�schen")); ?>
              <?php
			  //automatische absage mu� hier nochmals best�tigt werden,
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
              	     value="<?php echo(getUebersetzung("Anfrage best�tigen")); ?>" 
              	     class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
      				 onMouseOut="this.className='<?= BUTTON ?>';">
              <?php
               if (isMessageActive($vermieter_id,BUCHUNGS_BESTAETIGUNG)){
			  ?>
				  <input name="antwort" type="checkbox" id="antwort" value="true" checked="checked" />
				  
				  <?php echo(getUebersetzung("automatische Best�tigung senden")); ?>
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