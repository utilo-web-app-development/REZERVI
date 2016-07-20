<?php

	function printResAdmin($zimmer_id,$i,$month,$year,$saAktiviert,$link){

		global $unterkunft_id;

		$status = getStatus($zimmer_id,$i,$month,$year,$link);
		if (sizeof($status) < 1 && hasChildRooms($zimmer_id) && getPropertyValue(RES_HOUSE,$unterkunft_id,$link) == "true"){
			//if room is a parent, check if the child has another status:
			$childs = getChildRooms($zimmer_id);
			while ($c = mysqli_fetch_array($childs)){
				$child_zi_id = $c['PK_ID'];
				$status = getStatus($child_zi_id,$i,$month,$year,$link);	
				if (sizeof($status)>0){
					break;
				}
			}
		}
		
		if (getDayName($i,$month,$year) == "SA" && $saAktiviert){
			$isSamstag = true;
		}
		else{
			$isSamstag = false;
		}
		
		if (isset($status) && (sizeof($status)>1)){
			//an diesem tag ist ein urlauberwechsel:				
			?>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td class="<?php echo parseStatus($status[0],$isSamstag) ?>" 
							align="right" width="50%">
								<?php echo $i ?>
						</td>
						<td class="<?php echo parseStatus($status[1],$isSamstag) ?>" 
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
			//echo("nächster Tag: ");var_dump($nStatus);
			if (sizeof($nStatus) < 1 && getPropertyValue(RES_HOUSE,$unterkunft_id,$link) == "true" && hasChildRooms($zimmer_id)){
				//if room is a parent, check if the child has another status:
				$childs = getChildRooms($zimmer_id);
				while ($c = mysqli_fetch_array($childs)){
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
							<td class="<?php echo parseStatus($status[0],$isSamstag) ?>" align="right" width="50%">&nbsp;</td>
							<td class="frei" align="right" width="50%"><?php echo $i; ?></td>
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
					while ($c = mysqli_fetch_array($childs)){
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
								<td class="frei" align="right" width="50%"><?php echo $i; ?></td>
								<td class="<?php echo(parseStatus($status[0],$isSamstag)); ?>" 
									align="right" width="50%">&nbsp;</td>
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
function showMonth($month,$year,$unterkunft_id,$zimmer_id,$sprache,$saAktiviert,$link){
	
		//anzahl der tage des monats:
		$anzahlTage = getNumberOfDays($month,$year);
		
		?>

		<?php 
		for ($i = 1; $i <= $anzahlTage; $i++) { 
			$res_id = getReservierungID($zimmer_id,$i,$month,$year,$link);
			$statusString = getStatusString($zimmer_id,$i,$month,$year,$saAktiviert,$link);
			$gast_id = -1;
			?>
            <div class="row">
				<!-- wochentag anzeigen -->
				<div class="col-sm-1">
					<label class="control-label">
						<?php echo(getUebersetzung(getDayName($i,$month,$year),$sprache,$link));?>
					</label>
				</div>
				<!-- datum anzeigen -->
				<div class="col-sm-1 <?php echo($statusString); ?>">
                    <label class="control-label">
                        <?php printResAdmin($zimmer_id,$i,$month,$year,$saAktiviert,$link); ?>
                    </label>
                </div>
				<!-- gast anzeigen -->
				<div class="col-sm-3">
					<?php if ($statusString != "frei") { ?>
							<?php
							//gast-id auslesen:
							//$gast_id = getReservierungGastID($zimmer_id,$i,$month,$year,$link);
							$gast_ids = getReservierungGastIDs($zimmer_id,$i,$month,$year,$link);	
							while ($h = mysqli_fetch_array($gast_ids)){
								$gast_id = $h["FK_Gast_ID"];
								//if child rooms available, check also childs:
								if ( ( $gast_id == 1 || empty($gast_id) ) && getPropertyValue(RES_HOUSE,$unterkunft_id,$link) == "true" && hasChildRooms($zimmer_id)){
									//if room is a parent, check if the child has another status:
									$childs = getChildRooms($zimmer_id);
									while ($c = mysqli_fetch_array($childs)){
										$child_zi_id = $c['PK_ID'];
										$gast_id = getReservierungGastID($child_zi_id,$i,$month,$year,$link);	
										if ($gast_id != 1 && $gast_id != ""){
											break;
										}
									}
								}							
								//gast-namen ausgeben:
								if ($gast_id != 1 && $gast_id != ""){							
									?>
									  <a href="./gastInfo/index.php?gast_id=<?php echo $gast_id ?>&zimmer_id=<?php echo $zimmer_id ?>&jahr=<?php echo $year ?>&monat=<?php echo $month ?>"><?php 
										echo(getGuestNachname($gast_id,$link));?></a><?php echo(", ");echo(getGuestOrt($gast_id,$link));echo(", EW ".getErwachsene($res_id,$link).", K ".getKinder($res_id,$link)).", ".getPension($res_id,$link);					
								}
								else if($gast_id == ""){
								
								}
								else{
									echo(getUebersetzung("anonymer Gast",$sprache,$link));
								}
							}//ende while gast ids
					} //ende if nicht frei 
					else {
						echo("&nbsp;");
					}
					?>
					</div>
                </div>
			<?php } //ende for
		?>
<?php 	
}//ende funktion  
?>
