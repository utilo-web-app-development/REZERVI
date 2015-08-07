<?php
/**
 * Created on 23.01.2007
 *
 * @author coster alpstein-austria
 * 
 * zeigt die navigation links vom bild des raumes
 */
?>
<!-- tabs fuer raeume anzeigen -->
<div name="raumplan" id="raumplan" style="float:left;" class="yui-content">
	<form action="./index.php" method="post" name="reservationForm" target="_self">
	<input type="hidden" name="raum_id" value="<?= $raum_id ?>"/>
	<table cellspacing="0" border="0" cellpadding="0">
		<tr valign="top">
			<td width="<?= BREITE_KALENDER ?>">
			<!-- linke seite menue mit kalender -->
				<table cellspacing="0" border="0" cellpadding="3" class="<?= STANDARD_SCHRIFT ?>">
				<tr>
					<td>						
						<?= getUebersetzung("Bitte wählen sie das Datum, die Uhrzeit und die " .
								"gewünschte Anzahl der Personen für ihre Tischreservierung.") ?>						
					</td>
				</tr>				
				<tr>
					<td>
						<script>
							DateInput('datum', true, 'DD/MM/YYYY','<?= $startdatumDP  ?>')
						</script>
					</td>
				</tr>
				<tr>
					<td>
						<select name="stunde"  id="stunde" class="<?= SELECT ?>">
							<?php				
							for ($l=0; $l < 24; $l++){ 
									if ($l<10){$l="0".$l;} ?>
								<option value="<?= $l ?>"<?php if ($l == $stunde) 
									echo(" selected=\"selected\""); ?>>
										<?= $l ?>
								</option>
							<?php } ?>
					  	</select>:
					  	<select name="minute"  id="minute" class="<?= SELECT ?>">
							<?php				
							for ($l=0; $l < 60; $l++){ 
									if ($l<10){$l="0".$l;} ?>
								<option value="<?= $l ?>"<?php if ($l == $minute) 
									echo(" selected=\"selected\""); ?>>
									<?= $l ?>
								</option>
							<?php } ?>
					  	</select> 
					  	<span class="<?= STANDARD_SCHRIFT ?>">
							<?= getUebersetzung("Uhr"); ?>
						</span>
					</td>
				</tr>
				<tr>
					<td>
						<select name="personen"  id="personen" class="<?= SELECT ?>">
							<?php				
							for ($l=$minAnzahlPersonen; $l <= $maxAnzahlPersonen; $l++){ 
								if ($l<10){$l="0".$l;} ?>
								<option value="<?= $l ?>"<?php if ($l == 2) 
									echo(" selected=\"selected\""); ?>><?= $l ?>
								</option>
							<?php } ?>
					  	</select> <?= getUebersetzung("Personen") ?>
					 </td>
				</tr>
				<tr>
					<td>
						<input 
							type="button" 
							name="changeReservations" 
							class="<?= BUTTON ?>" 
		  					onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       						onMouseOut="this.className='<?= BUTTON ?>';"
       						onClick="showReservations()"
							value="<?= getUebersetzung("Reservierungen anzeigen") ?>"
							/>
					 </td>
				</tr>	
				<tr>
					<td>
						
					 </td>
				</tr>
				<tr>
					<td>
						<div align="left" style="position:relative;float:left">
							<img src="<?= $root."/templates/picture.php?bilder_id=".getBildWithMarker(SYMBOL_TABLE_OCCUPIED) ?>" 
      							width="<?= getBildBreite(getBildWithMarker(SYMBOL_TABLE_OCCUPIED)) ?>" 
      							height="<?= getBildHoehe(getBildWithMarker(SYMBOL_TABLE_OCCUPIED)) ?>"/>
						</div>
						<div align="left" 
							class="<?= STANDARD_SCHRIFT ?>">
							<?= getUebersetzung("Tisch belegt") ?>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div align="left" style="position:relative;float:left">
							<img src="<?= $root."/templates/picture.php?bilder_id=".getBildWithMarker(SYMBOL_TABLE_FREE) ?>" 
      							width="<?= getBildBreite(getBildWithMarker(SYMBOL_TABLE_FREE)) ?>" 
      							height="<?= getBildHoehe(getBildWithMarker(SYMBOL_TABLE_FREE)) ?>"/>
						</div>
						<div align="left" 
							class="<?= STANDARD_SCHRIFT ?>">
							<?= getUebersetzung("Tisch verfügbar") ?>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div align="left" 
							class="<?= STANDARD_SCHRIFT ?>">
							<?= getUebersetzung("Ausgewählte Tische:") ?>
						</div>
					</td>
				</tr>					
				<tr>
					<td>
						<!-- select box fuer reservierte tische -->
						<div name="reservierungen" id="reservierungen">	                      
	                      <select name="tisch_ids[]" multiple="multiple" size="5" id="tische">	                      	
                          </select>	                      
						</div>
						<!-- ende select box fuer reservierte tische-->
					</td>
				</tr>
				<tr>
					<td>
						<input 
							type="reset" 
							name="reset" 
							class="<?= BUTTON ?>" 
		  					onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       						onMouseOut="this.className='<?= BUTTON ?>';"
       						onClick="removeAllTische();"
							value="<?= getUebersetzung("Auswahl löschen") ?>"
							/>
					 </td>
				</tr>	
				<tr>
					<td>
						<input 
							type="button" 
							name="reservierungsButton" 
							class="<?= BUTTON ?>" 
		  					onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       						onMouseOut="this.className='<?= BUTTON ?>';"
       						onClick="submitReservierung()"
							value="<?= getUebersetzung("Reservierung starten") ?>"
							/>
					 </td>
				</tr>				
			</table>
			</td>
			<td>
			<!-- rechte seite mit bild von raum -->
			<!-- bild ausgeben -->
			<div name="raum" id="raum" style="height:<?= $bildhoehe ?> px;overflow:hidden;">
				<?php
				//dann die tische anzeigen die bereits gesetzt sind oder noch zu setzen sind:
				$res  = getTische($raum_id);
				$zindex=7;
				
				define("SPACE_MINUTE",getGastroProperty(RESERVIERUNGSDAUER,$gastro_id));
				$vonMinute = $minute-SPACE_MINUTE;
				$vonStunde = $stunde;
				$vonTag =    $tag;
				$vonMonat=   $monat;
				$vonJahr=    $jahr;
				$bisMinute=  $minute+SPACE_MINUTE;
				$bisStunde=  $stunde;
				$bisTag=     $tag;
				$bisMonat=   $monat;
				$bisJahr=    $jahr;
				if ($vonMinute < 0){
					$vonMinute = 60 - $vonMinute;
					$vonStunde--;
				}
				if ($vonStunde < 0){
					$vonStunde = 24 - $vonStunde;
					$vonTag--;
				}
				if ($vonTag < 0){
					$vonTag = getNumberOfDaysOfMonth($monat,$jahr)-$vonTag;
					$vonMonat--;
				}
				if ($vonMonat<0){
					$vonMonat = 12-$vonMonat;
					$vonJahr--;
				}
				if ($bisMinute < 0){
					$bisMinute = 60 - $bisMinute;
					$bisStunde--;
				}
				if ($bisStunde < 0){
					$bisStunde = 24 - $bisStunde;
					$bisTag--;
				}
				if ($bisTag < 0){
					$bisTag = getNumberOfDaysOfMonth($monat,$jahr)-$bisTag;
					$bisMonat--;
				}
				if ($bisMonat<0){
					$bisMonat = 12-$bisMonat;
					$bisJahr--;
				}			
				
				while($d = $res->FetchNextObject()) {
						$id    = $d->TISCHNUMMER;	
						$lefts = getLeftPosOfTisch($id);
						$tops  = getTopPosOfTisch($id);
						$wi    = getWidthOfTisch($id);
						$hi    = getHeightOfTisch($id);
				?>
					
						<div id="tisch<?= $id ?>" style="z-index:<?= $zindex++ ?>;
							text-align: center; background-position:center center;
							width:<?= $wi ?>px;height:<?= $hi ?>px;">
							<a href="#">
								<? //wenn tisch frei
								   //dann zeige paralleles besteck
								   //sonst gekreuztes besteck:
								   $belegt = isMietobjektTaken($id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr);
								   if ($belegt == false){
								   	?>
									<img onClick="tischInfo('<?= $id ?>');" src="<?= $root."/templates/picture.php?bilder_id=".getBildWithMarker(SYMBOL_TABLE_FREE) ?>" 
	      								width="<?= getBildBreite(getBildWithMarker(SYMBOL_TABLE_FREE)) ?>" 
	      								height="<?= getBildHoehe(getBildWithMarker(SYMBOL_TABLE_FREE)) ?>"
										border="0"/>											
								   	<?php
								   }
								   else{
								   	?>
									<img onClick="tischInfo('<?= $id ?>');" src="<?= $root."/templates/picture.php?bilder_id=".getBildWithMarker(SYMBOL_TABLE_OCCUPIED) ?>" 
	      								width="<?= getBildBreite(getBildWithMarker(SYMBOL_TABLE_OCCUPIED)) ?>" 
	      								height="<?= getBildHoehe(getBildWithMarker(SYMBOL_TABLE_OCCUPIED)) ?>"
										border="0"/>																		
								   	<?php
								   }
								?>
							</a>
						</div>
					
				<?php
				} 
				?>
				<img id="raumbild" 
					src="<?= $root."/templates/picture.php?bilder_id=".$bilder_id ?>" 
					width="<?= $bildbreite ?>" 
					height="<?= $bildhoehe ?>" 
					style="z-index:6" 
					border="0" />				
					
			</div>		
			<!-- ende bild ausgeben -->
			</td>			
		</tr>
	</table>
	</div> <!-- ende div fuer tab styles -->
	</form>
</div>
<!-- ende tabs fuer raeume -->