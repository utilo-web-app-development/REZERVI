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

		if (isset($status) && (sizeof($status)>1)){

			if(!(getDayName($i,$month,$year) == "SA" && $saAktiviert)){		
			
			?>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td class="<?php echo(parseStatus($status[0])); ?>" align="right" width="50%"><?php echo $i; ?></td>
						<td class="<?php echo(parseStatus($status[1])); ?>" align="right" width="50%">&nbsp;</td>
					</tr>
				</table>
			<?php		
			}
			else{

			?>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td class="<?php echo("samstagBelegt"); ?>" align="right" width="50%"><?php echo $i; ?></td>
						<td class="<?php echo("samstagBelegt"); ?>" align="right" width="50%">&nbsp;</td>
					</tr>
				</table>
			<?php	
			}		
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
				while ($c = mysqli_fetch_array($childs)){
					$child_zi_id = $c['PK_ID'];
					$nStatus = getStatus($child_zi_id,$nTag,$nMonat,$nJahr,$link);	
					if (sizeof($nStatus)>0){
						break;
					}
				}
			}			

			if (sizeof($nStatus) == 0){				
				//am nächsten tag ist es frei:		
				if(getDayName($i,$month,$year) == "SA" && $saAktiviert){						
				?>
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td class="samstagBelegt" align="right" width="50%">&nbsp;</td>
							<td class="samstagFrei" align="right" width="50%"><?php echo $i; ?></td>
						</tr>
					</table>
				<?php
				}
				else{

				?>
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td class="<?php echo(parseStatus($status[0])); ?>" align="right" width="50%">&nbsp;</td>
							<td class="frei" align="right" width="50%"><?php echo $i; ?></td>
						</tr>
					</table>
				<?php
				}
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
					if(getDayName($i,$month,$year) == "SA" && $saAktiviert){	
					?>
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
							<tr>
								<td class="samstagFrei" align="right" width="50%"><?php echo $i; ?></td>
								<td class="samstagBelegt" align="right" width="50%">&nbsp;</td>
							</tr>
						</table>
					<?php
					}
					else{
					?>
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
							<tr>
								<td class="frei" align="right" width="50%"><?php echo $i; ?></td>
								<td class="<?php echo(parseStatus($status[0])); ?>" align="right" width="50%">&nbsp;</td>
							</tr>
						</table>
					<?php
					}

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
	
	
	
	//falls keine zimmer_id ausgewählt wurde, das erste gefundene zimmer anzeigen:
	if (empty($zimmer_id) || $zimmer_id == "") {	
	$query = "
			select 
			PK_ID 
			from
			Rezervi_Zimmer
			where
			FK_Unterkunft_ID = '$unterkunft_id' 
			ORDER BY 
			Zimmernr";

  		$res = mysqli_query($link, $query);
  		if (!$res) {
  			echo("Anfrage $query scheitert.");
		}
		else {
			$d = mysqli_fetch_array($res);
			$zimmer_id = $d["PK_ID"];
		}
	}
	
	
	//falls kein jahr ausgewählt wurde, das aktuelle jahr verwenden:
	if ($jahr == "" || empty($jahr)){	
		$jahr = getTodayYear();	
		//ich brauche für jahr einen integer:
		$jahr+=1;$jahr-=1;
	}
	
//---------------------------------------------------------------
//funktion zum anzeigen eines kalendermonats:
function showYear($month,$year,$unterkunft_id,$zimmer_id,$sprache,$saAktiviert,$link){ ?>
		<table  border="0" cellspacing="0" cellpadding="0" class="tableColor">
		  <tr>
			<td class="tableColor"><?php echo(getUebersetzung("Januar",$sprache,$link)); ?></td>
			<?php for ($i=1; $i<=31; $i++){ ?>
			<td <?php $statusString = getStatusString($zimmer_id,$i,1,$year,$saAktiviert,$link);?> class="<?php echo($statusString); ?>" width="20"><?php printResAdmin($zimmer_id,$i,1,$year,$saAktiviert,$link); ?></td>
			<?php } ?>
		  </tr>
		  <tr> 
			<td class="tableColor"><?php echo(getUebersetzung("Februar",$sprache,$link)); ?></td>
			<?php 
				$schaltjahr = false;
				for ($i=1; $i<=getNumberOfDays(2,$year); $i++){ ?>
			<td <?php $statusString = getStatusString($zimmer_id,$i,2,$year,$saAktiviert,$link);?> class="<?php echo($statusString); ?>"><?php printResAdmin($zimmer_id,$i,2,$year,$saAktiviert,$link); ?></td>	
			<?php 
				if ($i == 29){
					$schaltjahr = true;
				}
			} 
			if (!$schaltjahr){
			?>
				 <td class="tableColor">&nbsp;</td>
				 <?php
				 }
				 ?>
				 <td class="tableColor">&nbsp;</td>
				 <td class="tableColor">&nbsp;</td>
		  </tr>		  
		  <tr>
			<td class="tableColor"><?php echo(getUebersetzung("März",$sprache,$link)); ?></td>
			<?php for ($i=1; $i<=31; $i++){ ?>
			<td <?php $statusString = getStatusString($zimmer_id,$i,3,$year,$saAktiviert,$link);?> class="<?php echo($statusString); ?>"><?php printResAdmin($zimmer_id,$i,3,$year,$saAktiviert,$link); ?></td>
			<?php } ?>
		  </tr>
		  <tr>
			<td class="tableColor"><?php echo(getUebersetzung("April",$sprache,$link)); ?></td>
			<?php for ($i=1; $i<=30; $i++){ ?>
			<td <?php $statusString = getStatusString($zimmer_id,$i,4,$year,$saAktiviert,$link);?> class="<?php echo($statusString); ?>"><?php printResAdmin($zimmer_id,$i,4,$year,$saAktiviert,$link); ?></td>
			<?php } ?>
			<td class="tableColor">&nbsp;</td>
		  </tr>
		  <tr>
			<td class="tableColor"><?php echo(getUebersetzung("Mai",$sprache,$link)); ?></td>
			<?php for ($i=1; $i<=31; $i++){ ?>
			<td <?php $statusString = getStatusString($zimmer_id,$i,5,$year,$saAktiviert,$link);?> class="<?php echo($statusString); ?>"><?php printResAdmin($zimmer_id,$i,5,$year,$saAktiviert,$link); ?></td>
			<?php } ?>
		  </tr>
		  <tr>
			<td class="tableColor"><?php echo(getUebersetzung("Juni",$sprache,$link)); ?></td>
			<?php for ($i=1; $i<=30; $i++){ ?>
			<td <?php $statusString = getStatusString($zimmer_id,$i,6,$year,$saAktiviert,$link);?> class="<?php echo($statusString); ?>"><?php printResAdmin($zimmer_id,$i,6,$year,$saAktiviert,$link); ?></td>
			<?php } ?>
			<td class="tableColor">&nbsp;</td>
		  </tr>
		  <tr>
			<td class="tableColor"><?php echo(getUebersetzung("Juli",$sprache,$link)); ?></td>
			<?php for ($i=1; $i<=31; $i++){ ?>
			<td <?php $statusString = getStatusString($zimmer_id,$i,7,$year,$saAktiviert,$link);?> class="<?php echo($statusString); ?>"><?php printResAdmin($zimmer_id,$i,7,$year,$saAktiviert,$link); ?></td>
			<?php } ?>
		  </tr>
		  <tr>
			<td class="tableColor"><?php echo(getUebersetzung("August",$sprache,$link)); ?></td>
			<?php for ($i=1; $i<=31; $i++){ ?>
			<td <?php $statusString = getStatusString($zimmer_id,$i,8,$year,$saAktiviert,$link);?> class="<?php echo($statusString); ?>"><?php printResAdmin($zimmer_id,$i,8,$year,$saAktiviert,$link); ?></td>
			<?php } ?>
		  </tr>
		  <tr>
			<td class="tableColor"><?php echo(getUebersetzung("September",$sprache,$link)); ?></td>
			<?php for ($i=1; $i<=30; $i++){ ?>
			<td <?php $statusString = getStatusString($zimmer_id,$i,9,$year,$saAktiviert,$link);?> class="<?php echo($statusString); ?>"><?php printResAdmin($zimmer_id,$i,9,$year,$saAktiviert,$link); ?></td>
			<?php } ?>
			<td class="tableColor">&nbsp;</td>
		  </tr>
		  <tr>
			<td class="tableColor"><?php echo(getUebersetzung("Oktober",$sprache,$link)); ?></td>
			<?php for ($i=1; $i<=31; $i++){ ?>
			<td <?php $statusString = getStatusString($zimmer_id,$i,10,$year,$saAktiviert,$link);?> class="<?php echo($statusString); ?>"><?php printResAdmin($zimmer_id,$i,10,$year,$saAktiviert,$link); ?></td>
			<?php } ?>
		  </tr>
		  <tr>
			<td class="tableColor"><?php echo(getUebersetzung("November",$sprache,$link)); ?></td>
			<?php for ($i=1; $i<=30; $i++){ ?>
			<td <?php $statusString = getStatusString($zimmer_id,$i,11,$year,$saAktiviert,$link);?> class="<?php echo($statusString); ?>"><?php printResAdmin($zimmer_id,$i,11,$year,$saAktiviert,$link); ?></td>
			<?php } ?>
			<td class="tableColor">&nbsp;</td>
		  </tr>
		  <tr>
			<td class="tableColor"><?php echo(getUebersetzung("Dezember",$sprache,$link)); ?></td>
			<?php for ($i=1; $i<=31; $i++){ ?>
			<td <?php $statusString = getStatusString($zimmer_id,$i,12,$year,$saAktiviert,$link);?> class="<?php echo($statusString); ?>"><?php printResAdmin($zimmer_id,$i,12,$year,$saAktiviert,$link); ?></td>
			<?php } ?>
		  </tr>
		</table>
<?php }//ende funktion  
?>
