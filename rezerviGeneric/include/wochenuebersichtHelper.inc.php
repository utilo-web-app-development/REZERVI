<?php

/**
 * author:coster
 * date:21.10.05
 * zeigt ein einzelnes monat für das webinterface in einer tabelle
 * */
function showWeek($day,$month,$year,$vermieter_id,$mietobjekt_id,$modus){
		
		global $root;
		global $ansicht;
		//anzahl der tage des monats:
		$anzahlTage = getNumberOfDaysOfMonth($month,$year);
		include_once($root."/include/reservierungFunctions.inc.php");
		include_once($root."/include/mieterFunctions.inc.php");
		
		$lastDayOfWeek = getLastDayOfWeek($day,$month,$year);
		$lastDayMonth = $month;
		$lastDayYear = $year;
		if ($lastDayOfWeek < $day){
			$lastDayMonth++; 
		}
		if ($lastDayMonth > 12){
			$lastDayMonth = 1;
			$lastDayYear++;
		}
		$firstDayOfWeek = getFirstDayOfWeek($day,$month,$year);
		$firstDayMonth = $month;
		$firstDayYear = $year;
		if ($firstDayOfWeek > $day){
			$firstDayMonth--; 
		}
		if ($firstDayMonth < 1){
			$firstDayMonth = 12;
			$firstDayYear--;
		}
	
		?>
			<table border="0" width="100%" cellspacing="1" cellpadding="0" class="<?= TABLE_COLOR ?>">
			<?php 
	
				$status = getStatus($mietobjekt_id,0,0,$day,$month,$year,59,23,$day,$month,$year);
				if (isset($status) && (sizeof($status)>=1)){
					$statusString = BELEGT;
				}
				else{
					$statusString = FREI;
				}
				$mieter_id = -1;
				?>
					<tr class="<?= TABLE_COLOR ?>"> 
						<!-- wochentag anzeigen -->
						<td class="<?= TABLE_COLOR ?>" valign="left" class="<?= TABLE_STANDARD ?>">
							<?php 
								echo(getUebersetzung("Woche")." ");
								echo(getUebersetzung("von")." ");
								echo(getUebersetzung(getDayName($firstDayOfWeek,$firstDayMonth,$firstDayYear)));																																		
				 			?>
				 		</td>
						<!-- datum anzeigen -->
						<td class="<?= TABLE_COLOR ?>" valign="left" class="<?= TABLE_STANDARD ?>">
							<?php echo($firstDayOfWeek.".");echo($firstDayMonth.".");echo($firstDayYear); ?>
						</td>	
						<td class="<?= TABLE_COLOR ?>" valign="left" class="<?= TABLE_STANDARD ?>">
							<?php 
								echo(getUebersetzung("bis")." ");
								echo(getUebersetzung(getDayName($lastDayOfWeek,$lastDayMonth,$lastDayYear)));																																		
				 			?>
				 		</td>
						<!-- datum anzeigen -->
						<td class="<?= TABLE_COLOR ?>" valign="left" class="<?= TABLE_STANDARD ?>">
							<?php echo($lastDayOfWeek.".");echo($lastDayMonth.".");echo($lastDayYear); ?>
						</td>							
						<!-- grafische reservierung anzeigen -->
						<td class="<?= TABLE_COLOR ?>" class="<?= TABLE_STANDARD ?>">
							<?php
								//wie viele reservierungen sind in dieser Woche?
								$resIds = getReservierungIDs($mietobjekt_id,0,0,$firstDayOfWeek,$firstDayMonth,$firstDayYear,59,23,$lastDayOfWeek,$lastDayMonth,$lastDayYear);
								$anzahlRes = mysql_num_rows($resIds);
							?>					
						  <table cellpadding="0" cellspacing="0" border="0">
						    <tr>
						    	<td width="5" class="<?= FREI ?>">&nbsp;</td>
							    <?php 
							    	for ($l=0;$l<$anzahlRes;$l++){
							    ?>
							      <td width="5" class="<?= BELEGT ?>">&nbsp;</td>
							    <?php
							    	}
							    ?>
						    </tr>
						  </table>
						</td>
					</tr>
			</table>
			<br/>	
			<table cellpadding="0" cellspacing="1" border="0" class="<?= TABLE ?>" width="100%">
			<tr>
				<th>Tag</th>
				<th>Datum</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>		
			<?php 
			//anzeige der einzelnen wochentage:
			for ($iz = $firstDayOfWeek; $iz<$firstDayOfWeek+7; $iz++){
				$i_month=$firstDayMonth;
				$i_year =$firstDayYear;
				$i_day = $iz;
				if ($i_day > getNumberOfDaysOfMonth($firstDayMonth,$firstDayYear)){
					$i_month++;
					$i_day = $iz-getNumberOfDaysOfMonth($firstDayMonth,$firstDayYear);
				}
				if ($i_month > 12){
					$i_year++;
				}
				
				$anzahlResOnDayI = countReservierungIDs($mietobjekt_id,0,0,$i_day,$i_month,$i_year,59,23,$i_day,$i_month,$i_year);

				if ($anzahlResOnDayI > 0) {
						$resIds = getReservierungIDs($mietobjekt_id,0,0,$i_day,$i_month,$i_year,59,23,$i_day,$i_month,$i_year);
						while ($d=mysql_fetch_array($resIds)){
							$reservierungs_id = $d["RESERVIERUNG_ID"];
							$mieter_id = getMieterIdOfReservierung($reservierungs_id);
							$mietdauer = getNumberOfDaysOfReservation($reservierungs_id);
							$isFirstDay = isFirstDayOfReservation($reservierungs_id,$i_day,$i_month,$i_year);
							$isLastDay = isLastDayOfReservation($reservierungs_id,$i_day,$i_month,$i_year);
							$timeVon = getTimeVonOfReservierung($reservierungs_id);
							$timeBis = getTimeBisOfReservierung($reservierungs_id);
							$allDay = false;
							if ($mietdauer > 1 && !$isFirstDay && !$isLastDay){
								$allDay = true;
							}
							else if($timeVon == "00:00" && $timeBis == "24:00"){
								$allDay = true;
							}
						?>
						<form action="./mieterInfos/index.php" method="post" name="form<?php echo($day); ?>" target="_self">
						<input type="hidden" name="mietobjekt_id" value="<?= $mietobjekt_id ?>" />
						<input type="hidden" name="monat" value="<?= $month ?>" />
						<input type="hidden" name="jahr" value="<?= $year ?>" />
						<input type="hidden" name="tag" value="<?= $day ?>" />
						<input type="hidden" name="ansicht" value="<?= $ansicht ?>" />
						<tr>
							<!-- wochentag anzeigen -->
							<td class="<?= TABLE_STANDARD ?>" valign="left" class="<?= TABLE_STANDARD ?>">
								<?php 
									echo(getUebersetzung(getDayName($i_day,$i_month,$i_year)));																																		
					 			?>
					 		</td>
							<!-- datum anzeigen -->
							<td class="<?= TABLE_STANDARD ?>" valign="left" class="<?= TABLE_STANDARD ?>">
								<?php echo($i_day.".");echo($i_month.".");echo($i_year); ?>
							</td>	
							<!-- grafische reservierung anzeigen -->
							<td class="<?= TABLE_STANDARD ?>">				
							  <table cellpadding="0" cellspacing="0" border="0">
							    <tr>
							    	<?php
							    	if (!$allDay){
							    	?>
							    	<td width="5" class="<?= FREI ?>">&nbsp;</td>
								    <?php 
							    	}
								    	for ($z=0;$z<$anzahlResOnDayI;$z++){
								    ?>
								      <td width="5" class="<?= BELEGT ?>">&nbsp;</td>
								    <?php
								    	}
								    ?>
							    </tr>
							  </table>
							</td>
							<!-- text -->
							<?php 
							if ($modus == MODUS_WEBINTERFACE){
							?>
							<td class="<?= TABLE_STANDARD ?>">
								<input name="mieter_id" type="hidden" value="<?php echo($mieter_id); ?>">						  
								 <?php
								//gast-namen ausgeben:
								if ($mieter_id != ANONYMER_MIETER_ID){
									echo(getNachnameOfMieter($mieter_id));echo(", ");echo(getMieterOrt($mieter_id));					
								}
								else{
									echo(getUebersetzung("anonymer Mieter"));
								}
								?>
							</td>
							<?php
							}
							else if ($modus == MODUS_BELEGUNGSPLAN){
							?>
							<td class="<?= TABLE_STANDARD ?>">
								<?= getUebersetzung("reserviert") ?>
							</td>
							<?php	
							}
							if ($modus == MODUS_BELEGUNGSPLAN && $mieter_id != ANONYMER_MIETER_ID){
							?>
							<td class="<?= TABLE_STANDARD ?>">
							<?php
							}
							else{
							?>
							<td class="<?= TABLE_STANDARD ?>" colspan="2">
							<?php
							}
								//zeit ausgeben:
								//wenn mietdauer mehr als 3 tage, braucht nur bei 
								//tag 1 und tag 3 die zeit ausgegeben werden:
								if ($mietdauer >= 2){
									if ( $isFirstDay ){
										echo($timeVon." - 24:00 ".getUebersetzung("Uhr"));
									}
									else if( $isLastDay ){
										echo("00:00 - ".$timeBis." ".getUebersetzung("Uhr"));
									}	
									else{
										?>
										00:00 - 24:00 <?= getUebersetzung("Uhr") ?>
										<?php
									}								
								}
								?>
							</td>
							<?php 
							if ($modus == MODUS_WEBINTERFACE){
							?>
							<td class="<?= TABLE_STANDARD ?>">
								<?php
								//button für mieter infos  ausgeben:
								if ($mieter_id != ANONYMER_MIETER_ID){
								?>
								<input type="submit" name="Submit" class="<?= BUTTON ?>" 
									onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
			   						onMouseOut="this.className='<?= BUTTON ?>';" 
			   						value="<?php echo(getUebersetzung("Mieter-Info")); ?>"/>
		   						<?php
								}
								?>
							</td>
							<?php
							} //ende wenn modus webinterface
							?>
						</tr>
						</form>	
						<?php
						}
						?>				
					<?php
					} // ende anzahl res < 0
					else{
						?>
							<tr>
								<!-- wochentag anzeigen -->
								<td class="<?= TABLE_STANDARD ?>" valign="left" class="<?= TABLE_STANDARD ?>">
									<?php 
										echo(getUebersetzung(getDayName($i_day,$i_month,$i_year)));																																		
						 			?>
						 		</td>					 		
								<!-- datum anzeigen -->
								<td valign="left" class="<?= TABLE_STANDARD ?>" class="<?= TABLE_STANDARD ?>">
									<?php echo($i_day.".");echo($i_month.".");echo($i_year); ?>
								</td>	
								<!-- grafische reservierung anzeigen -->
								<td class="<?= TABLE_STANDARD ?>">				
								  <table cellpadding="0" cellspacing="0" border="0">
								    <tr>
								    	<td width="5" class="<?= FREI ?>">&nbsp;</td>
								    </tr>
								  </table>
								</td>
								<td colspan="3" class="<?= TABLE_STANDARD ?>"><?= getUebersetzung("Keine Reservierung an diesem Tag vorhanden") ?>.</td>	
							</tr>
						<?php
					} //ende anzahl reservierungen < 0
			} //ende for alle tage der woche
			?>	
			</table>
<?php 	
}//ende funktion  
?>
