<?php
/**
 * Created on 31.08.2006
 *
 * @author coster
 */
 //welche ansichten sollen gezeigt werden?
 $showMonatsansicht = getPropertyValue(SHOW_MONATSANSICHT,$unterkunft_id,$link);
 $showJahresansicht = getPropertyValue(SHOW_JAHRESANSICHT,$unterkunft_id,$link);
 $showGesamtansicht = getPropertyValue(SHOW_GESAMTANSICHT,$unterkunft_id,$link);
 $ansicht =  getSessionWert(ANSICHT);
 $anzahlAnsichten = 0;
 if ($showMonatsansicht == "true"){
 	$anzahlAnsichten++;
 }
 if ($showJahresansicht == "true"){
 	$anzahlAnsichten++;
 }
 if ($showGesamtansicht == "true"){
 	$anzahlAnsichten++;
 }
 //ansicht-auswahl nur anzeigen wenn mehr als 1 ansicht m�glich ist:
 if ($anzahlAnsichten>1){
?>
<div class="panel panel-default">
  <div class="panel-body">
  	
  	<h4><?php echo(getUebersetzung("Ansicht für",$sprache,$link)); ?>:</h4>
  	
  	<form action="./ansichtWaehlen.php" method="post" name="ansichtWaehlen" target="kalender" class="form-horizontal">
  		
  		
				<div class="col-sm-12">
					<select name="ansichtWechsel" onchange="submit()" class="form-control">
	    <?php
	    if ($showMonatsansicht == "true"){
	    ?>
	    	<option value="0" <?php if (isset($ansicht) && $ansicht == 0) {?> selected="selected" <?php } ?>><?php echo(getUebersetzung("Monatsübersicht",$sprache,$link)); ?></option>
	    <?php
	    }
	    if ($showJahresansicht == "true"){
	    ?>
	    	<option value="1" <?php if (isset($ansicht) && $ansicht == 1) {?> selected="selected" <?php } ?>><?php echo(getUebersetzung("Jahresübersicht",$sprache,$link)); ?></option>
	    <?php
	    }
	    if ($showGesamtansicht == "true"){
	    ?>
	    	<option value="2" <?php if (isset($ansicht) && $ansicht == 2) {?> selected="selected" <?php } ?>><?php echo(getUebersetzung("Gesamtübersicht",$sprache,$link)); ?></option>
	  	<?php
	    }
	    ?>
	  </select>
	  <input name="zimmer_id" type="hidden" id="zimmer_id" value="<? echo($zimmer_id); ?>">
	  <input name="jahr" type="hidden" id="jahr" value="<? echo($jahr); ?>">
	  <input name="monat" type="hidden" id="monat" value="<? echo(parseMonthNumber(getTodayMonth())); ?>">
				</div>
				
  		
<!-- <span class="standardSchriftBold"><?php echo(getUebersetzung("Ansicht f�r",$sprache,$link)); ?>:</span>
<form action="./ansichtWaehlen.php" method="post" name="ansichtWaehlen" target="kalender">
	<div align="left">
	  <select name="ansichtWechsel" onchange="submit()" class="button200pxA">
	    <?php
	    if ($showMonatsansicht == "true"){
	    ?>
	    	<option value="0" <?php if (isset($ansicht) && $ansicht == 0) {?> selected="selected" <?php } ?>><?php echo(getUebersetzung("Monats�bersicht",$sprache,$link)); ?></option>
	    <?php
	    }
	    if ($showJahresansicht == "true"){
	    ?>
	    	<option value="1" <?php if (isset($ansicht) && $ansicht == 1) {?> selected="selected" <?php } ?>><?php echo(getUebersetzung("Jahres�bersicht",$sprache,$link)); ?></option>
	    <?php
	    }
	    if ($showGesamtansicht == "true"){
	    ?>
	    	<option value="2" <?php if (isset($ansicht) && $ansicht == 2) {?> selected="selected" <?php } ?>><?php echo(getUebersetzung("Gesamt�bersicht",$sprache,$link)); ?></option>
	  	<?php
	    }
	    ?>
	  </select>
	  <input name="zimmer_id" type="hidden" id="zimmer_id" value="<? echo($zimmer_id); ?>">
	  <input name="jahr" type="hidden" id="jahr" value="<? echo($jahr); ?>">
	  <input name="monat" type="hidden" id="monat" value="<? echo(parseMonthNumber(getTodayMonth())); ?>">
	</div>
</form> -->
<?php
} //end if ansichten > 0
?>
</div>	
</div>
