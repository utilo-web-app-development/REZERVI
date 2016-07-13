<?php
/*
 * Created on 14.04.2006
 *
 */ 
  include_once($root."/include/datumFunctions.inc.php");
    
 	if (!isset($vonMinute)){
		$vonMinute = getTodayMinute();
	}
	if (!isset($bisMinute)){
		$bisMinute = getTodayMinute();
	}
	if (!isset($bisStunde)){
		$bisStunde = getTodayStunde();
	}
	if (!isset($vonStunde)){
		$vonStunde = getTodayStunde();
	}	
	if (!isset($vonTag)){
		$vonTag = getTodayDay();
	}
	if (!isset($bisTag)){
		$bisTag = getTodayDay();
	}
	if (!isset($vonMonat)){
		$vonMonat = getTodayMonth();
	}
	if (!isset($bisMonat)){
		$bisMonat = getTodayMonth();
	}
	if (!isset($vonJahr)){
		$vonJahr = getTodayYear();
	}
	if (!isset($bisJahr)){
		$bisJahr = getTodayYear();
	}
	if (!isset($tag)){
		$tag = $vonTag;
	}
	if (!isset($monat)){
		$monat = $vonMonat;
	}
	if (!isset($jahr)){
		$jahr = $vonJahr;
	}
	
	$startdatumDP = $tag."/".$monat."/".$jahr;
	$enddatumDP =   $startdatumDP;
 
?>
<script type="text/javascript" src="<?php echo $root ?>/templates/calendarDateInput.inc.php?root=<?php echo $root ?>">
	/***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/	
</script>
<table border="0" class="<?php echo TABLE_STANDARD ?>">		  
  <tr>
    <td>
        <span class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
        	<?php echo getUebersetzung("Reservierungsanfrage") ?>:</span>
        <table>
	        <tr>
	        	<td colspan = "2">
	        		<span class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
	        			<?php echo getUebersetzung("von") ?>:
	          		</span>
	          	</td>
	        </tr>
	        <tr>
	        	<td colspan = "2">
					<script>DateInput('datumVon', true, 'DD/MM/YYYY','<?php echo $startdatumDP  ?>')</script>
	          	</td>
	        </tr>
	        <tr>
	        	<td width="20">
	          	</td>
	          	<td><select name="vonStunde"  id="vonStunde">
		            <?php				
					for ($l=0; $l < 24; $l++){ 
							if ($l<10){$l="0".$l;} ?>
		            <option value="<?php echo $l ?>"<?php if ($l == $vonStunde) echo(" selected=\"selected\""); ?>><?php echo $l ?></option>
		            <?php } ?>
		          </select>:
		          <select name="vonMinute"  id="vonMinute">
		            <?php				
					for ($l=0; $l < 60; $l++){ 
							if ($l<10){$l="0".$l;} ?>
		            <option value="<?php echo $l ?>"<?php if ($l == $vonMinute) echo(" selected=\"selected\""); ?>><?php echo $l ?></option>
		            <?php } ?>
		          </select> <span class="<?php echo STANDARD_SCHRIFT ?>">
		          	<?php echo getUebersetzung("Uhr"); ?></span></td>
	        </tr>
        </table>
        <table>
	        <tr>
	        	<td colspan = "2">
	        		<span class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
	        			<?php echo(getUebersetzung("bis")); ?>:
	          		</span>
	          	</td>
	        </tr>
	        <tr>
	        	<td colspan = "2">
					<script>DateInput('datumBis', true, 'DD/MM/YYYY','<?php echo $enddatumDP  ?>')</script>
	          	</td>
	        </tr>
	        <tr>
	        	<td width="20">
	          	</td>
	          	<td><select name="bisStunde"  id="bisStunde">
		            <?php				
					for ($l=0; $l < 24; $l++){ 
						if ($l<10){$l="0".$l;}	
					?>
		            <option value="<?php echo $l ?>"<?php if ($l == $bisStunde) echo(" selected=\"selected\""); ?>><?php echo $l ?></option>
		            <?php } ?>
		          </select>:
		          <select name="bisMinute"  id="bisMinute">
		            <?php				
					for ($l=0; $l < 60; $l++){ 
						if ($l<10){$l="0".$l;}		
					?>
		            <option value="<?php echo $l ?>"<?php if ($l == $bisMinute) echo(" selected=\"selected\""); ?>><?php echo $l ?></option>
		            <?php } ?>
		          </select> <span class="<?php echo STANDARD_SCHRIFT ?>">
		          	<?php echo getUebersetzung("Uhr"); ?></span></td>
	        </tr>
        </table>

