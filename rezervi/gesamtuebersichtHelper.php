<?php

/**
 * @author coster
 * @date 30.9.06
 * Hilfsfunktionen für die Gesamtübersicht
*/

function printResAdmin($zimmer_id,$i,$month,$year,$saAktiviert,$link){
	
	global $unterkunft_id;
	
	if (getDayName($i,$month,$year) == "SA" && $saAktiviert){
		$isSamstag = true;
	}
	else{
		$isSamstag = false;
	}	

	$status = getStatus($zimmer_id,$i,$month,$year,$link);
	if (sizeof($status) < 1 && hasChildRooms($zimmer_id) 
		&& getPropertyValue(RES_HOUSE,$unterkunft_id,$link) == "true"){
		//if room is a parent, check if the child has another status:
		$childs = getChildRooms($zimmer_id);
		while ($c = mysql_fetch_array($childs)){
			$child_zi_id = $c['PK_ID'];
			$status = getStatus($child_zi_id,$i,$month,$year,$link);	
			if (sizeof($status)>0){
				break;
			}
		}
	}		
	/////////////////////////////////////////////////////////
	//urlauberwechsel genau an diesem tag:
	/////////////////////////////////////////////////////////
	if (isset($status) && (sizeof($status)>1)){
		//an diesem tag ist ein urlauberwechsel:			
		?>
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td class="<?= parseStatus($status[0],$isSamstag) ?>" align="right" width="50%"></td>
					<td class="<?= parseStatus($status[1],$isSamstag) ?>" align="right" width="50%">&nbsp;</td>
				</tr>
			</table>
		<?php			
	} //ende if "an diesem tag ist urlauberwechsel"
	else if (isset($status) && (sizeof($status)==1)) {
				
		//schauen ob der letzte tag halb-frei ist:
		$nTag = $i+1;$nMonat = $month;$nJahr = $year;
		$anzahlTage = getNumberOfDays($month,$year);
		if ($nTag > $anzahlTage){
			$nTag = 1;
			$nMonat=$month+1;
		} //ende if tag zu gross
		if ($nMonat>12){
			$nMonat=1;
			$nJahr=$year+1;
		} //ende if monat zu gross
		
		$nStatus = getStatus($zimmer_id,$nTag,$nMonat,$nJahr,$link);	
		if (sizeof($nStatus) < 1 && hasChildRooms($zimmer_id) && getPropertyValue(RES_HOUSE,$unterkunft_id,$link) == "true"){
			//if room is a parent, check if the child has another status:
			$childs = getChildRooms($zimmer_id);
			while ($c = mysql_fetch_array($childs)){
				$child_zi_id = $c['PK_ID'];
				$nStatus = getStatus($child_zi_id,$nTag,$nMonat,$nJahr,$link);	
				if (sizeof($nStatus)>0){
					break;
				}
			}
		}		
					
		//if (!(isset($nStatus)) && isset($status)){
		if (sizeof($nStatus) == 0){				
			//am nächsten tag ist es frei:							
			?>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td class="<?= parseStatus($status[0],$isSamstag) ?>" align="right" width="50%">&nbsp;</td>
						<td class="<?= parseStatus(0,$isSamstag) ?>" align="right" width="50%"></td>
					</tr>
				</table>
			<?php
		} //ende if nächster tag frei
		else {				
			//schauen ob der tag vorher frei ist:
			$vTag = $i-1;$vMonat = $month;$vJahr = $year;
			if ($vTag < 1) {
				$vMonat= $month - 1;
				if ($vMonat < 1) {
					$vMonat = 12;
					$vJahr = $year-1;
				} //ende if monat zu klein
				$vTag = getNumberOfDays($vMonat,$vJahr);
			} //ende if tag zu klein		
						
			$vStatus = getStatus($zimmer_id,$vTag,$vMonat,$vJahr,$link);
			if (sizeof($vStatus) < 1 && hasChildRooms($zimmer_id) && getPropertyValue(RES_HOUSE,$unterkunft_id,$link) == "true"){
				//if room is a parent, check if the child has another status:
				$childs = getChildRooms($zimmer_id);
				while ($c = mysql_fetch_array($childs)){
					$child_zi_id = $c['PK_ID'];
					$vStatus = getStatus($child_zi_id,$vTag,$vMonat,$vJahr,$link);	
					if (sizeof($vStatus)>0){
						break;
					}
				}
			}			
			
			if (sizeof($vStatus) == 0){
				//am vorherigen tag ist es frei:
									
				?>
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td class="<?= parseStatus(0,$isSamstag) ?>" align="right" width="50%"></td>
							<td class="<?= parseStatus($status[0],$isSamstag) ?>" align="right" width="50%">&nbsp;</td>
						</tr>
					</table>
				<?php

			} //ende if tag vorher frei
			else{
				?>&nbsp;<?php
			}	
		}//ende else schauen ob tag vorher frei	
	} //ende else
	else { //tag ausgeben:
		?>&nbsp;<?php
	} //ende else tag ausgeben
			
}//ende printRes	

/**
 * @author: coster
 * @date: 30.9.06
 * listet alle zimmer auf und erzeugt die tabellenzeilen 
 * */
function showAllRooms($month,$year,$unterkunft_id,$link,$saAktiviert,$sprache){ 
	
	$zimmerart = getUebersetzungUnterkunft(getZimmerart_EZ($unterkunft_id,$link),$sprache,$unterkunft_id,$link);
	$attResult = false;
	if (getPropertyValue(SHOW_ZIMMER_ATTRIBUTE_GESAMTUEBERSICHT,$unterkunft_id,$link) == "true"){
		$attResult = getAttributes();
	}
	
?>

	<table border="0" cellspacing="0" cellpadding="0" class="tableColor">
		<tr>
			<td></td>
			<?php
			//ausgeben von leeren spalten wenn zusaetzlich attribute da sind:
			if ($attResult != false){
				for ($i = 0; $i < mysql_num_rows($attResult); $i++){
					?><td></td><?php
				}
			}
			//ausgeben der tage in namen:
			$anzahlTageMo = getNumberOfDays($month,$year);
			for ($i = 1; $i <= $anzahlTageMo; $i++){
				$tagName = getDayName($i,$month,$year);	
			?>
				<td align="center"><?= getUebersetzung($tagName,$sprache,$link) ?></td>
			<?php
			}
			?>
		</tr>	
		<tr>
			<td><?= $zimmerart ?>&nbsp;</td>
			<?php
			//ausgeben der spaltenüberschriften wenn zusaetzlich attribute da sind:
			if ($attResult != false){
				while ($d = mysql_fetch_array($attResult)){
					$bezeichnung = $d["Bezeichnung"];
					?><td align="center"><?= $bezeichnung ?>&nbsp;</td><?php
				}
			}			
			//ausgeben der tage in ziffern:
			$anzahlTageMo = getNumberOfDays($month,$year);
			for ($i = 1; $i <= $anzahlTageMo; $i++){
			?>
				<td align="center"><?= $i ?></td>
			<?php
			}
			?>
		</tr>
      <?php
		$res = getZimmer($unterkunft_id,$link);
		while($d = mysql_fetch_array($res)){ 
			$zimmer_id = $d["PK_ID"];	
		    $zimmer_value = $d["Zimmernr"]; 
	  ?>
		  <tr> 
			<td align="center">
				<?= getUebersetzungUnterkunft($zimmer_value,$sprache,$unterkunft_id,$link) ?>
			</td>
			<?php
			//ausgeben der spaltenwerte wenn zusaetzlich attribute da sind:
			if ($attResult != false){
				$attResult = getAttributes();
				while ($d = mysql_fetch_array($attResult)){
					$attribut_id = $d["PK_ID"];
					$wert = getAttributValue($attribut_id,$zimmer_id);
					?><td align="center"><?= $wert ?></td><?php
				}
			}			
			for ($i = 1; $i <= $anzahlTageMo; $i++){
			?>
				<td width="20"
					<?php $statusString = getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link);?> 
					class="<?php echo($statusString); ?>">
					<?php printResAdmin($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?>
				</td>
			<?php } ?>
		  </tr>
	  <?php
		}
	  ?>
	</table>
	
<?php 
}//ende funktion showAllRooms
?>