		<?php
		/*
		 * Created on 10.09.2005
		 * update: 26.5.08
		 * author: coster
		 */
		?>		
		</div><!-- ende content -->	
		<div name="footer" id="footer" class="<?php echo SCHRIFT_KLEIN ?>"
			 
			align="center">
			<a href="http://www.utilo.eu/" class="<?php echo SCHRIFT_KLEIN ?>">
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
						<div name="tischInfo_<?php echo $id ?>" id="tischInfo_<?php echo $id ?>" 
							style="visibility:hidden;z-index:<?php echo $zindex++ ?>;width:200px;">
							
							<table celspacing="0" cellpadding="0" border="0" class="<?php echo TABLE_COLOR ?>">
								<tr style="background-color:#ccc;">
									<td>
										<div align="left" style="position:relative;float:left" 
										class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
											<?php echo getUebersetzung("Tisch Nr."); ?> <?php echo $id ?>
										</div>
										<div align="right" onMouseDown="exitTischInfo('<?php echo $id ?>');"
											style="font-size:12px;font-weight:bolder;font-family: Arial">
											<img src="<?php echo $root ?>/templates/img/close.gif" border="0"/>
										</div>
									</td>
								</tr>
								<?php
								if (!empty($beschreibung)){
								?>
								<tr>
									<td>
										<?php echo $beschreibung ?>
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
										<?php echo getUebersetzung("Maximal") ?> <?php echo $maxBelegung ?> <?php echo getUebersetzung("Personen") ?>
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
										<?php echo getUebersetzung("Minimal") ?> <?php echo $minBelegung ?> <?php echo getUebersetzung("Personen") ?>
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
													<?php echo getUebersetzung("Reserviert von") ?> <?php echo $timeVon ?> <?php echo getUebersetzung("bis") ?> <?php echo $timeBis ?> <?php echo getUebersetzung("Uhr") ?>
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
											name="tischgebucht_<?php echo $id ?>" 
											onClick="addTisch('<?php echo $id ?>');"
											class="<?php echo BUTTON ?>" 
						  					onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
				       						onMouseOut="this.className='<?php echo BUTTON ?>';"											
											value="<?php echo getUebersetzung("reservieren") ?>" />										
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