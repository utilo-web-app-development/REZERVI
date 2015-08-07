<?php

	function printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link){
		
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
		?>
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td class="<?= parseStatus($status[0],$isSamstag) ?>" 
						align="right" width="50%">
							<?= $i ?>
					</td>
					<td class="<?= parseStatus($status[1],$isSamstag) ?>" 
						align="right" width="50%">&nbsp;
					</td>
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
			if (sizeof($nStatus) < 1 && hasChildRooms($zimmer_id) 
				&& getPropertyValue(RES_HOUSE,$unterkunft_id,$link) == "true"){
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
			
			if (sizeof($nStatus) == 0){				
			?>		
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td class="<?= parseStatus($status[0],$isSamstag) ?>" align="right" width="50%">&nbsp;</td>
						<td class="<?= parseStatus(0,$isSamstag) ?>" align="right" width="50%"><? echo $i; ?></td>
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

				if (sizeof($vStatus) < 1 && hasChildRooms($zimmer_id) && 
					getPropertyValue(RES_HOUSE,$unterkunft_id,$link) == "true"){
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
								<td class="<?= parseStatus(0,$isSamstag) ?>" align="right" width="50%"><? echo $i; ?></td>
								<td class="<?= parseStatus($status[0],$isSamstag) ?>" align="right" width="50%">&nbsp;</td>
							</tr>
						</table>
					<?php

				} //ende if tag vorher frei
				else{
					echo($i);
				}	
			}//ende else schauen ob tag vorher frei	
		} //ende else
		else { //tag ausgeben:
			echo($i);
		} //ende else tag ausgeben
				
	}//ende printRes	
	
		//---------------------------------------------------------------
	//funktion zum anzeigen eines kalendermonats:
	function showMonth($month,$year,$unterkunft_id,$zimmer_id,$link,$saAktiviert,$sprache){
	
	//anzahl der tage des monats:
	$anzahlTage = getNumberOfDays($month,$year);
	$firstDay = getFirstDayOfMonth($month,$year);
	
	$MO = getUebersetzung("MO",$sprache,$link);
	$DI = getUebersetzung("DI",$sprache,$link);
	$MI = getUebersetzung("MI",$sprache,$link);
	$DO = getUebersetzung("DO",$sprache,$link);
	$FR = getUebersetzung("FR",$sprache,$link);
	$SA = getUebersetzung("SA",$sprache,$link);
	$SO = getUebersetzung("SO",$sprache,$link);
	
	//erste tag im monat ist ein montag:
	if ($firstDay == "Mon"){	
	?><table width="100%" border="0" class="tableColor">
        <tr> 
          <td colspan="7" class="standardSchriftBold"><? echo((getUebersetzung(parseMonthName($month),$sprache,$link))." ".($year)); ?></td>
        </tr>
        <tr> 
          <td class="tableColor"><?php echo($MO); ?></td>
          <td class="tableColor"><?php echo($DI); ?></td>
          <td class="tableColor"><?php echo($MI); ?></td>
          <td class="tableColor"><?php echo($DO); ?></td>
          <td class="tableColor"><?php echo($FR); ?></td>
          <td class="tableColor"><?php echo($SA); ?></td>
          <td class="tableColor"><?php echo($SO); ?></td>
        </tr>
        <tr> 
		<? for ($i=1; $i<=7; $i++){ ?>
          <td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		<? } ?>          
        </tr>
        <tr> 
        <? for ($i=8; $i<=14; $i++){ ?>
          <td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		<? } ?> 
        </tr>
        <tr> 
        <? for ($i=15; $i<=21; $i++){ ?>
          <td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		<? } ?> 
        </tr>
        <tr> 
        <? for ($i=22; $i<=28; $i++){ ?>
          <td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		<? } ?> 
        </tr>
        <tr>
          <td class="<? if ($anzahlTage >= 29) {echo(getStatusString($zimmer_id,29,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 29) {printRes($zimmer_id,29,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="<? if ($anzahlTage >= 30) {echo(getStatusString($zimmer_id,30,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 30) {printRes($zimmer_id,30,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="<? if ($anzahlTage >= 31) {echo(getStatusString($zimmer_id,31,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 31) {printRes($zimmer_id,31,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
        </tr>
		<tr>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
        </tr>
      </table><?php
	  } //ende if montag
	  
	  //erste tag im monat ist ein dienstag:
	elseif ($firstDay == "Tue"){	
	?><table width="100%" border="0" class="tableColor">
        <tr> 
          <td colspan="7" class="standardSchriftBold"><? echo((getUebersetzung(parseMonthName($month),$sprache,$link))." ".($year)); ?></td>
        </tr>
        <tr> 
          <td class="tableColor"><?php echo($MO); ?></td>
          <td class="tableColor"><?php echo($DI); ?></td>
          <td class="tableColor"><?php echo($MI); ?></td>
          <td class="tableColor"><?php echo($DO); ?></td>
          <td class="tableColor"><?php echo($FR); ?></td>
          <td class="tableColor"><?php echo($SA); ?></td>
          <td class="tableColor"><?php echo($SO); ?></td>
        </tr>
        <tr> 
          <td class="tableColor">&nbsp;</td>
          <? for ($i=1; $i<=6; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=7; $i<=13; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=14; $i<=20; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=21; $i<=27; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr>
          <td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
          <td class="<? if ($anzahlTage >= 29) {echo(getStatusString($zimmer_id,29,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 29) {printRes($zimmer_id,29,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="<? if ($anzahlTage >= 30) {echo(getStatusString($zimmer_id,30,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 30) {printRes($zimmer_id,30,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="<? if ($anzahlTage >= 31) {echo(getStatusString($zimmer_id,31,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 31) {printRes($zimmer_id,31,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
        </tr>
		<tr>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
        </tr>
      </table><?php
	  } //ende if dienstag
	  
	//erste tag im monat ist ein mittwoch:
	elseif ($firstDay == "Wed"){	
	?><table width="100%" border="0" class="tableColor">
        <tr> 
          <td colspan="7" class="standardSchriftBold"><? echo((getUebersetzung(parseMonthName($month),$sprache,$link))." ".($year)); ?></td>
        </tr>
        <tr> 
          <td class="tableColor"><?php echo($MO); ?></td>
          <td class="tableColor"><?php echo($DI); ?></td>
          <td class="tableColor"><?php echo($MI); ?></td>
          <td class="tableColor"><?php echo($DO); ?></td>
          <td class="tableColor"><?php echo($FR); ?></td>
          <td class="tableColor"><?php echo($SA); ?></td>
          <td class="tableColor"><?php echo($SO); ?></td>
        </tr>
        <tr> 
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <? for ($i=1; $i<=5; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=6; $i<=12; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=13; $i<=19; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=20; $i<=26; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr>
          <? for ($i=27; $i<=28; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>          
          <td class="<? if ($anzahlTage >= 29) {echo(getStatusString($zimmer_id,29,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 29) {printRes($zimmer_id,29,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="<? if ($anzahlTage >= 30) {echo(getStatusString($zimmer_id,30,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 30) {printRes($zimmer_id,30,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="<? if ($anzahlTage >= 31) {echo(getStatusString($zimmer_id,31,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 31) {printRes($zimmer_id,31,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
        </tr>
		<tr>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
        </tr>
      </table><?php
	  } //ende if mittwoch
	  
	//erste tag im monat ist ein donnerstag:
	elseif ($firstDay == "Thu"){	
	?><table width="100%" border="0" class="tableColor">
        <tr> 
          <td colspan="7" class="standardSchriftBold"><? echo((getUebersetzung(parseMonthName($month),$sprache,$link))." ".($year)); ?></td>
        </tr>
        <tr> 
          <td class="tableColor"><?php echo($MO); ?></td>
          <td class="tableColor"><?php echo($DI); ?></td>
          <td class="tableColor"><?php echo($MI); ?></td>
          <td class="tableColor"><?php echo($DO); ?></td>
          <td class="tableColor"><?php echo($FR); ?></td>
          <td class="tableColor"><?php echo($SA); ?></td>
          <td class="tableColor"><?php echo($SO); ?></td>
        </tr>
        <tr> 
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
		  <td class="tableColor">&nbsp;</td>
          <? for ($i=1; $i<=4; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=5; $i<=11; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=12; $i<=18; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=19; $i<=25; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr>
          <? for ($i=26; $i<=28; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>          
          <td class="<? if ($anzahlTage >= 29) {echo(getStatusString($zimmer_id,29,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 29) {printRes($zimmer_id,29,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="<? if ($anzahlTage >= 30) {echo(getStatusString($zimmer_id,30,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 30) {printRes($zimmer_id,30,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="<? if ($anzahlTage >= 31) {echo(getStatusString($zimmer_id,31,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 31) {printRes($zimmer_id,31,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="tableColor">&nbsp;</td>          
        </tr>
		<tr>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
        </tr>
      </table><?php
	  } //ende if donnerstag
	  
	//erste tag im monat ist ein freitag:
	elseif ($firstDay == "Fri"){	
	?><table width="100%" border="0" class="tableColor">
        <tr> 
          <td colspan="7" class="standardSchriftBold"><? echo((getUebersetzung(parseMonthName($month),$sprache,$link))." ".($year)); ?></td>
        </tr>
        <tr> 
          <td class="tableColor"><?php echo($MO); ?></td>
          <td class="tableColor"><?php echo($DI); ?></td>
          <td class="tableColor"><?php echo($MI); ?></td>
          <td class="tableColor"><?php echo($DO); ?></td>
          <td class="tableColor"><?php echo($FR); ?></td>
          <td class="tableColor"><?php echo($SA); ?></td>
          <td class="tableColor"><?php echo($SO); ?></td>
        </tr>
        <tr> 
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
		  <td class="tableColor">&nbsp;</td>
		  <td class="tableColor">&nbsp;</td>
          <? for ($i=1; $i<=3; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=4; $i<=10; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=11; $i<=17; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=18; $i<=24; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr>
          <? for ($i=25; $i<=28; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>          
          <td class="<? if ($anzahlTage >= 29) {echo(getStatusString($zimmer_id,29,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 29) {printRes($zimmer_id,29,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="<? if ($anzahlTage >= 30) {echo(getStatusString($zimmer_id,30,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 30) {printRes($zimmer_id,30,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="<? if ($anzahlTage >= 31) {echo(getStatusString($zimmer_id,31,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 31) {printRes($zimmer_id,31,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
         </tr>
		 <tr>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
        </tr>
      </table><?php
	  } //ende if freitag
	  
	//erste tag im monat ist ein samstag:
	elseif ($firstDay == "Sat"){	
	?><table width="100%" border="0" class="tableColor">
        <tr> 
          <td colspan="7" class="standardSchriftBold"><? echo((getUebersetzung(parseMonthName($month),$sprache,$link))." ".($year)); ?></td>
        </tr>
        <tr> 
          <td class="tableColor"><?php echo($MO); ?></td>
          <td class="tableColor"><?php echo($DI); ?></td>
          <td class="tableColor"><?php echo($MI); ?></td>
          <td class="tableColor"><?php echo($DO); ?></td>
          <td class="tableColor"><?php echo($FR); ?></td>
          <td class="tableColor"><?php echo($SA); ?></td>
          <td class="tableColor"><?php echo($SO); ?></td>
        </tr>
        <tr> 
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
		  <td class="tableColor">&nbsp;</td>
		  <td class="tableColor">&nbsp;</td>
		  <td class="tableColor">&nbsp;</td>
          <? for ($i=1; $i<=2; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=3; $i<=9; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=10; $i<=16; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=17; $i<=23; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr>
          <? for ($i=24; $i<=28; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>          
          <td class="<? if ($anzahlTage >= 29) {echo(getStatusString($zimmer_id,29,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 29) {printRes($zimmer_id,29,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="<? if ($anzahlTage >= 30) {echo(getStatusString($zimmer_id,30,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 30) {printRes($zimmer_id,30,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
         </tr>
		 <tr>
          <td class="<? if ($anzahlTage >= 31) {echo(getStatusString($zimmer_id,31,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 31) {printRes($zimmer_id,31,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
        </tr>
      </table><?php
	  } //ende if samstag
	  
	//erste tag im monat ist ein sonntag:
	elseif ($firstDay == "Sun"){	
	?><table width="100%" border="0" class="tableColor">
        <tr> 
          <td colspan="7" class="standardSchriftBold"><? echo((getUebersetzung(parseMonthName($month),$sprache,$link))." ".($year)); ?></td>
        </tr>
       <tr> 
          <td class="tableColor"><?php echo($MO); ?></td>
          <td class="tableColor"><?php echo($DI); ?></td>
          <td class="tableColor"><?php echo($MI); ?></td>
          <td class="tableColor"><?php echo($DO); ?></td>
          <td class="tableColor"><?php echo($FR); ?></td>
          <td class="tableColor"><?php echo($SA); ?></td>
          <td class="tableColor"><?php echo($SO); ?></td>
        </tr>
        <tr> 
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
		  <td class="tableColor">&nbsp;</td>
		  <td class="tableColor">&nbsp;</td>
		  <td class="tableColor">&nbsp;</td>
		  <td class="tableColor">&nbsp;</td>          
          <td class="<? echo(getStatusString($zimmer_id,1,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,1,$month,$year,$saAktiviert,$link); ?></td>
        </tr>
        <tr> 
          <? for ($i=2; $i<=8; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=9; $i<=15; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr> 
          <? for ($i=16; $i<=22; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>
        </tr>
        <tr>
          <? for ($i=23; $i<=28; $i++){ ?>
          	<td class="<? echo(getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link)); ?>"><?php printRes($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?></td>
		  <? } ?>          
          <td class="<? if ($anzahlTage >= 29) {echo(getStatusString($zimmer_id,29,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 29) {printRes($zimmer_id,29,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
         </tr>
		 <tr>
		  <td class="<? if ($anzahlTage >= 30) {echo(getStatusString($zimmer_id,30,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 30) {printRes($zimmer_id,30,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
          <td class="<? if ($anzahlTage >= 31) {echo(getStatusString($zimmer_id,31,$month,$year,$saAktiviert,$link)); } else {echo"tableColor";} ?>"><?php if ($anzahlTage >= 31) {printRes($zimmer_id,31,$month,$year,$saAktiviert,$link);} else {echo("&nbsp;");} ?></td>
		  <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
          <td class="tableColor">&nbsp;</td>
		 </tr>
		</table><?php
	  } //ende if sonntag
	
	}//ende funktion	


?>