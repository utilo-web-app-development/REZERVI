<?php
/**
 * zeigt eine Datumskomponente auf Klick
 * @author coster
 * @date 10.10.06
 */  
?>
<script type="text/javascript" src="<?php echo $root ?>/templates/calendarDateInput.inc.php?root=<?php echo $root ?>">
	/***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/	
</script>
<tr>
	<td colspan = "2">
		<script>DateInput('datumAnsicht', true, 'DD/MM/YYYY','<?php echo $startdatumDP  ?>')</script>
	</td>
</tr>
<tr>
	<td width="20">
	</td>
	<td><select name="stunde"  id="stunde">
		<?php				
		for ($l=0; $l < 24; $l++){ 
				if ($l<10){$l="0".$l;} ?>
		<option value="<?php echo $l ?>"<?php if ($l == $stunde) echo(" selected=\"selected\""); ?>><?php echo $l ?></option>
		<?php } ?>
	  </select>:
	  <select name="minute"  id="minute">
		<?php				
		for ($l=0; $l < 60; $l++){ 
				if ($l<10){$l="0".$l;} ?>
		<option value="<?php echo $l ?>"<?php if ($l == $minute) echo(" selected=\"selected\""); ?>><?php echo $l ?></option>
		<?php } ?>
	  </select> <span class="<?php echo STANDARD_SCHRIFT ?>">
		<?php echo getUebersetzung("Uhr"); ?></span></td>
</tr>