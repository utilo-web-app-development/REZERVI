<?php
/**
 * zeigt eine Datumskomponente auf Klick
 * @author coster
 * @date 10.10.06
 */  
?>
<script type="text/javascript" src="<?= $root ?>/templates/calendarDateInput.inc.php?root=<?= $root ?>">
	/***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/	
</script>
<tr>
	<td colspan = "2">
		<script>DateInput('datumAnsicht', true, 'DD/MM/YYYY','<?= $startdatumDP  ?>')</script>
	</td>
</tr>
<tr>
	<td width="20">
	</td>
	<td><select name="stunde"  id="stunde">
		<?php				
		for ($l=0; $l < 24; $l++){ 
				if ($l<10){$l="0".$l;} ?>
		<option value="<?= $l ?>"<?php if ($l == $stunde) echo(" selected=\"selected\""); ?>><?= $l ?></option>
		<?php } ?>
	  </select>:
	  <select name="minute"  id="minute">
		<?php				
		for ($l=0; $l < 60; $l++){ 
				if ($l<10){$l="0".$l;} ?>
		<option value="<?= $l ?>"<?php if ($l == $minute) echo(" selected=\"selected\""); ?>><?= $l ?></option>
		<?php } ?>
	  </select> <span class="<?= STANDARD_SCHRIFT ?>">
		<?= getUebersetzung("Uhr"); ?></span></td>
</tr>