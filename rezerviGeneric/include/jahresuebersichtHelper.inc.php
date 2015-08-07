<?php	
/**
* author:coster
* date: 30. 01.06
* durchlaufe die monate und zeige status
*/
function showYear($month,$year,$vermieter_id,$mietobjekt_id){ 
	
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
?>
		<table border="0" cellspacing="0" cellpadding="0" class="<?= TABLE_COLOR ?>">
		<?php
		for ($month = 1; $month <= 12; $month++){
		?>
		  <tr>
			<td><?= getUebersetzung(parseMonthName($month)) ?></td>
			<?php 
			for ($i=1; $i<=getNumberOfDaysOfMonth($month,$year); $i++){ 
				$fullDayBooked = isFullDayBooked($mietobjekt_id,$i,$month,$year);
				$fullDayFree   = isFullDayFree($mietobjekt_id,$i,$month,$year);
			?>
			<td <?php if ($fullDayBooked === true){?> 
						class="<?= BELEGT ?>"<?php 
					} 
					else if ($fullDayFree === true){
					?>
						class="<?= FREI ?>"
					<?php
					} ?>>
						<?php
						if ($fullDayBooked === false && $fullDayFree === false){
							
							$j = $i+1;
							$jM= $month;
							$jY= $year;
							if ($j > getNumberOfDaysOfMonth($month,$year)){
								$j=1;
								$jM++;
							}
							if ($jM>12){
								$jM=1;
								$jY++;
							}
							$l = $i-1;
							$lM= $month;
							$lY= $year;
							if ($l < 1){
								$l=1;
								$lM--;
							}
							if ($lM<1){
								$lM=1;
								$lY--;
							}
							//wenn der vorherige tag voll gebucht ist:
						if (isFullDayBooked($mietobjekt_id,$j,$jM,$jY) === true){
						?>					
						  <table cellpadding="0" cellspacing="0" border="0">
						    <tr>
						    	<td  class="<?= FREI ?>">&nbsp;</td>
							    <td  class="<?= BELEGT ?>"><?= $i ?></td>
						    </tr>
						  </table>
						<?php
						}
						else if (isFullDayBooked($mietobjekt_id,$l,$lM,$lY) === true){
						?>
						  <table cellpadding="0" cellspacing="0" border="0">
						    <tr>
						    	<td  class="<?= BELEGT ?>"><?= $i ?></td>
						    	<td  class="<?= FREI ?>">&nbsp;</td>
						    </tr>
						  </table>				  
						<?
						}
						else{
						?>
						  <table cellpadding="0" cellspacing="0" border="0">
						    <tr>
						    	<td  class="<?= FREI ?>">&nbsp;</td>
						    	<td  class="<?= BELEGT ?>"><?= $i ?></td>
						    	<td  class="<?= FREI ?>">&nbsp;</td>
						    </tr>
						  </table>	
						<?php
						}
				}
				else{
					if ($i<10){
						$m = "&nbsp;".$i;
					}
					else{
						$m = $i;
					}
					//anzeige des tages:
					echo($m);
				}
				?>
			</td>
			<?php 
			} //ende zeige tage
			?>
			<?php
			//zeige restlichen tage auf 31 tage als leeres feld:
			for ($i=getNumberOfDaysOfMonth($month,$year);$i<=31;$i++){
			?>
				<td>&nbsp;</td>
			<?php
			}
			?>
		  </tr>
		  <?php
		  } //ende zeige monate
		  ?>
		</table>
		
<?php }//ende funktion  
?>
