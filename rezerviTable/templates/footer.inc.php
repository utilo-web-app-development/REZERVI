		<?php
		/*
		 * Created on 10.09.2005
		 * update: 26.5.08
		 * author: coster
		 */
		?>		
		</div><!-- ende content -->	
		<div name="footer" id="footer" class="<?= SCHRIFT_KLEIN ?>"
			 
			align="center">
			<a href="http://www.utilo.eu/" class="<?= SCHRIFT_KLEIN ?>">
				Rezervi Table V 0.1 &copy; UTILO 2008 
			</a>
		</div>
		<?php
					 //fuer jeden tisch einen eigenen layer vorbereiten:
					 $res  = getTische($raum_id);
					 while($d = $res->FetchNextObject()) {
						$id = $d->TISCHNUMMER;
						$beschreibung = $d->BESCHREIBUNG;
						$maxBelegung  = $d->MAXIMALE_BELEGUNG;
						$minBelegung  = $d->MINIMALE_BELEGUNG;
					?>
						<div name="tischInfo_<?= $id ?>" id="tischInfo_<?= $id ?>" 
							style="visibility:hidden;z-index:<?= $zindex++ ?>;width:200px;">
							
							<table celspacing="0" cellpadding="0" border="0" class="<?= TABLE_COLOR ?>">
								<tr style="background-color:#ccc;">
									<td>
										<div align="left" style="position:relative;float:left" 
										class="<?= STANDARD_SCHRIFT_BOLD ?>">
											<?= getUebersetzung("Tisch Nr."); ?> <?= $id ?>
										</div>
										<div align="right" onMouseDown="exitTischInfo('<?= $id ?>');"
											style="font-size:12px;font-weight:bolder;font-family: Arial">
											<img src="<?= $root ?>/templates/img/close.gif" border="0"/>
										</div>
									</td>
								</tr>
								<?php
								if (!empty($beschreibung)){
								?>
								<tr>
									<td>
										<?= $beschreibung ?>
									</td>
								</tr>
								<?php
								}
								?>
								<?php
								if (!empty($maxBelegung)){
								?>
								<tr>
									<td>
										<?= getUebersetzung("Maximal") ?> <?= $maxBelegung ?> <?= getUebersetzung("Personen") ?>
									</td>
								</tr>
								<?php
								}
								?>	
								<?php
								if (!empty($minBelegung)){
								?>
								<tr>
									<td>
										<?= getUebersetzung("Minimal") ?> <?= $minBelegung ?> <?= getUebersetzung("Personen") ?>
									</td>
								</tr>
								<?php
								}
								?>	
								<?php
								
								$belegt = isMietobjektTaken($id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);			
								if ($belegt){
									$reservierungen = 
										getReservierungIDs($id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);
									if (!empty($reservierungen)){
										while($g = $reservierungen->FetchNextObject()) {
											$res_id = $g->RESERVIERUNG_ID;	
											$timeVon = getTimeVonOfReservierung($res_id);
											$timeBis = getTimeBisOfReservierung($res_id);
										?>
											<tr>
												<td>
													<?= getUebersetzung("Reserviert von") ?> <?= $timeVon ?> <?= getUebersetzung("bis") ?> <?= $timeBis ?> <?= getUebersetzung("Uhr") ?>
												</td>
											</tr>
										<?php
										} //ende while reservierungen
									}//ende if not empty reservierungen
								}
								//reservierungs button anzeigen wenn tisch verfuegbar:
								else {
								?>
								<tr>
									<td>
										<input type="button" 
											name="tischgebucht_<?= $id ?>" 
											onClick="addTisch('<?= $id ?>');"
											class="<?= BUTTON ?>" 
						  					onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
				       						onMouseOut="this.className='<?= BUTTON ?>';"											
											value="<?= getUebersetzung("reservieren") ?>" />										
									</td>
								</tr>
								<?php
								}
								?>	
							</table>
							
						</div>
					<?php
					 }
					?>
	</body>
</html>
<?php
include_once($root."/include/closeDB.inc.php");//datenbank schliessen
?>