<?php

/**
 * author:coster
 * date:21.10.05
 * zeigt ein einzelnes monat für das webinterface in einer tabelle
 * */
function showMonth($month,$year,$vermieter_id,$mietobjekt_id,$modus){
	
		global $root;
		global $ansicht;
		include_once($root."/include/reservierungFunctions.inc.php");
		include_once($root."/include/mieterFunctions.inc.php");
		include_once($root."/include/datumFunctions.inc.php");
		
		//anzahl der tage des monats:
		$anzahlTage = getNumberOfDaysOfMonth($month,$year);
		?>
		<table border="0" cellspacing="1" cellpadding="0" class="<?= TABLE_COLOR ?>">
		<?php 
		for ($i = 1; $i <= $anzahlTage; $i++) { 
			$status = getStatus($mietobjekt_id,0,0,$i,$month,$year,59,23,$i,$month,$year);
			if (isset($status) && (sizeof($status)>=1)){
				$statusString = BELEGT;
			}
			else{
				$statusString = FREI;
			}
			$mieter_id = -1;
			?>
			<tr> 
				<!-- wochentag anzeigen -->
				<td valign="middle" class="<?= TABLE_STANDARD ?>">
					<?= getUebersetzung(getDayName($i,$month,$year)) ?>
		 		</td>
				<!-- datum anzeigen -->
				<td valign="middle" class="<?= TABLE_STANDARD ?>">
					<?php echo($i.".");echo($month.".");echo($year); ?>
				</td>	
				<!-- grafische reservierung anzeigen -->
				<td class="<?= TABLE_STANDARD ?>">
					<?php
						//wie viele reservierungen sind an diesem tag?
						$resIds = getReservierungIDs($mietobjekt_id,0,0,$i,$month,$year,59,23,$i,$month,$year);
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
				<!-- mieter anzeigen -->
				<td valign="middle" class="<?= TABLE_STANDARD ?>">
					<?php if ($statusString != FREI) {
						//gast-id auslesen:
					?>
					<table cellpadding="3" cellspacing="0" border="0" class="<?= STANDARD_SCHRIFT ?>">
						<?php
						while ($d=mysql_fetch_array($resIds)){
							$reservierungs_id = $d["RESERVIERUNG_ID"];
							$mieter_id = getMieterIdOfReservierung($reservierungs_id);
							$mietdauer = getNumberOfDaysOfReservation($reservierungs_id);
							$isFirstDay = isFirstDayOfReservation($reservierungs_id,$i,$month,$year);
							$isLastDay = isLastDayOfReservation($reservierungs_id,$i,$month,$year);
							$timeVon = getTimeVonOfReservierung($reservierungs_id);
							$timeBis = getTimeBisOfReservierung($reservierungs_id);
						?>
						<form action="./mieterInfos/index.php" method="post" name="form<?php echo($i); ?>" target="_self">
						<input type="hidden" name="mietobjekt_id" value="<?= $mietobjekt_id ?>" />
						<input type="hidden" name="monat" value="<?= $month ?>" />
						<input type="hidden" name="jahr" value="<?= $year ?>" />
						<input type="hidden" name="tag" value="<?= $i ?>" />
						<input type="hidden" name="ansicht" value="<?= $ansicht ?>" />
						<tr>
							<td>
								<input name="mieter_id" type="hidden" value="<?php echo($mieter_id); ?>">						  
								 <?php
								//gast-namen ausgeben:
								if ($modus == MODUS_WEBINTERFACE && $mieter_id != ANONYMER_MIETER_ID){
									echo(getNachnameOfMieter($mieter_id));echo(", ");echo(getMieterOrt($mieter_id));					
								}
								else if ($modus == MODUS_WEBINTERFACE){
									echo(getUebersetzung("anonymer Mieter"));
								}
								else if($modus == MODUS_BELEGUNGSPLAN){
									echo(getUebersetzung("reserviert"));
								}
								?>
							</td>
							<td>
								<?php
								//zeit ausgeben:
								//wenn mietdauer mehr als 3 tage, braucht nur bei 
								//tag 1 und tag 3 die zeit ausgegeben werden:
								$mietdauer = getNumberOfDaysOfReservation($reservierungs_id);
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
								else{
									echo(getTimeVonOfReservierung($reservierungs_id)." - ".getTimeBisOfReservierung($reservierungs_id));
								} //ende else
								?>
							</td>
							<td>
								<?php
								//button für mieter infos  ausgeben:
								if ($mieter_id != ANONYMER_MIETER_ID && $modus == MODUS_WEBINTERFACE){
								?>
								<input type="submit" name="Submit" class="<?= BUTTON ?>" 
									onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
			   						onMouseOut="this.className='<?= BUTTON ?>';" 
			   						value="<?php echo(getUebersetzung("Mieter-Info")); ?>"/>
		   						<?php
								}
								?>
							</td>
						</tr>
						</form>
						<?php
						}
						?>
					</table>
					<?php
					} //ende if nicht frei 
					else {
						//keine reservierung vorhanden -> leerzeichen ausgeben:
						echo("&nbsp;");
					}
					?>
				</td>			
			</tr>
			<?php } //ende for
		?>		
		</table>	
<?php 	
}//ende funktion  
?>
