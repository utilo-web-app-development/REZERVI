<?php

/*
 * Created on 20.11.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria
 * zeigt einen einzelnen tag 
 * */

function showDayDetail($ansicht,$tag,$monate,$jahr,$raum_id,$gastro_id,$modus){		
		
	global $root;
	include_once($root."/include/reservierungFunctions.inc.php");
	include_once($root."/include/mieterFunctions.inc.php");
	include_once($root."/include/oeffnungszeitenFunktions.inc.php");?>
	
	<table class="moduletable_reservierung" id="show">
		<tr>
		<th width=80 scope="col" onclick="javascript:newload(0, 0, 0, 0, 0, 0)"> &nbsp;<?php echo getRaumBezeichnung($raum_id); ?>&nbsp; </th>
	  	<?php
	  	$time = getOeffnungszeit(1)->FetchNextObject();
	  	$timeVon = 7;
	  	$timeBis = 23;
	  	$lang = $timeBis - $timeVon+2;
	  	for ($i=$timeVon; $i<=$timeBis; $i++) {?>
	  		 <th scope="col" colspan="2" onclick="javascript:newload(0, 0, 0, 0, 0, 0)">
	  		 	<?php echo($i);
	  		 ?></th><?php
		}  ?>
  		</tr> <?php
  		//get tables to the room:
		$res = getTische($raum_id);
		while($d = $res->FetchNextObject()) { ?>
  		<tr>
    		<td align="middle" scope="row" onclick="javascript:newload(0, 0, 0, 0, 0, 0)" > &nbsp;
    		<?php echo(getUebersetzung("Tisch")." ".($tisch_id = $d->TISCHNUMMER)); ?></td><?php
    		for ($i=$timeVon; $i<=$timeBis+0.5; $i=$i+0.5) {
    			$colspan = 1;
    			$vonStunde = (int)$i;
    			$vonMinute = ($i-$vonStunde)*60;
    			$isFree = true;
    			if(isBlock($raum_id, $tisch_id,$vonMinute,$vonStunde,$tag,$monate,$jahr,$vonMinute+29,$vonStunde,$tag,$monate,$jahr)){
			 		?><td id="<?php echo getID("2", $tisch_id, $vonStunde, $vonMinute);?>" scope="col" colspan="<?php echo $colspan ?>" class="block"
			 				onclick="javascript:newload(2, 0, 0, 0, 0, 0)" >
					</td> <?php	
					$isFree = false;						
    			}else{
		    		$status = getStatus($tisch_id,$vonMinute,$vonStunde,$tag,$monate,$jahr,$vonMinute+29,$vonStunde,$tag,$monate,$jahr);
					if (isset($status) && (sizeof($status)>=1)){
						$statusString = BELEGT;
						$resId = getReservierungID($tisch_id,$vonMinute+15,$vonStunde,$tag,$monate,$jahr);	
						$colspan = getDurationOfReservierung($resId)/0.5;	
						if ($colspan > 0){	
							$isFree = false;					
							$i = $i+$colspan/2-0.5;
				 			?><td id="<?php echo getID("1", $tisch_id, $vonStunde, $vonMinute+15);?>" title="<?php echo showInfo($resId)?>" scope="col" colspan="<?php echo $colspan ?>" class="<?php echo $statusString ?>"
				 				onclick="javascript:newload(this.id, <?php echo$gastro_id?>, <?php echo$raum_id?>, <?php echo$tag?>, <?php echo$monate?>, <?php echo$jahr?>)" >
							</td> <?php				
						}
						else{
							$isFree = true;
						}
				}
					
				if ($isFree){
						$statusString = FREI;
						?><td id="<?php echo getID("0", $tisch_id, $vonStunde, $vonMinute);?>" scope="col" colspan="<?php echo $colspan ?>" class="<?php echo $statusString ?>"
								onclick="javascript:newload(this.id, <?php echo$gastro_id?>, <?php echo$raum_id?>, <?php echo$tag?>, <?php echo$monate?>, <?php echo$jahr?>)" >
							
						</td><?php
					}?>	<?php
    			}
			}
  		?>
  		<?php 
  		}
		?></tr>
  		<div id="panel1">
			<div id="panel1_hd" class="hd"></div>
			<div id="panel1_bd" class="bd" style="height:0px">
			</div>
		</div>
  </table>
  <table  width="100%">
  <tr> 
    <td> 
      <?php 		
      	$newTag1 = $tag-1;		
		$mon = $monate;
		$jah = $jahr;
		if ($newTag1 < 1){
			$newTag1 = getNumberOfDaysOfMonth($mon-1,$jahr);
			$mon = $mon - 1;
		}	
		if ($mon < 1){
			$mon = 12;
			$jah = $jah-1;
		}																		 																			
		?>
      <form action="./index.php" method="post" name="tagZurueck" target="_self" id="monatZurueck">
        <div align="right">           
          <input name="raum_id" type="hidden" id="raum_id" value="<?php echo $raum_id ?>">
          <input name="tag" type="hidden" id="tag" value="<?php echo $newTag1 ?>">
          <input name="monat" type="hidden" id="monat" value="<?php echo $mon ?>">
          <input name="ansicht" type="hidden" id="monat" value="<?php echo TAGESANSICHT ?>">
          <input name="jahr" type="hidden" id="jahr" value="<?php echo $jah ?>">
          <input name="zurueck" type="submit"  class="button"
       		id="zurueck" value="<?php echo(getUebersetzung("einen Tag zurück")); ?>">
        </div>
      </form>
	</td>
    <td> 
		<div  align="middle"> 
      	<?php echo getFullDayName($tag,$monate,$jahr).", ".$tag.".".$monate.".".$jahr; ?>
        </div>
	</td>
    <td> 
      <?php		
      	$newTag2 = $tag+1;
		$mon = $monate;
		$jah = $jahr;
		if ($newTag2 > getNumberOfDaysOfMonth($monate,$jahr)){
			$mon = $mon+1;		
			$newTag2 = 1;	
		}	
		if ($mon > 12){
			$mon = 1;
			$jah = $jah + 1;
		}																													
		?>
      <form action="./index.php" method="post" name="tagWeiter" target="_self" id="monatWeiter">
        <input name="raum_id" type="hidden" id="raum_id" value="<?php echo $raum_id ?>">
        <input name="tag" type="hidden" id="tag" value="<?php echo $newTag2 ?>">
        <input name="monat" type="hidden" id="monat" value="<?php echo $mon ?>">
        <input name="ansicht" type="hidden" id="monat" value="<?php echo TAGESANSICHT ?>">
        <input name="jahr" type="hidden" id="jahr" value="<?php echo $jah ?>">
        <input name="weiter" type="submit"  class="button"
       		id="weiter" value="<?php echo(getUebersetzung("einen Tag weiter")); ?>">
      </form></td>
  </tr>   
</table>
 <?php
} //end funcation showDayDetail

function showReservierungen($vonMinute, $bisMinute, $vonStunde, $bisStunde, $tag,$monate,$jahr,$gastro_id,$tisch_id,$modus, $showDelete=true, $url, $zustand, $raum_id, $datumVon, $ansicht){
	
	global $root;
	include_once($root."/include/datumFunctions.inc.php");
	include_once($root."/include/reservierungFunctions.inc.php");
	include_once($root."/include/mieterFunctions.inc.php");
	
	$hasRes = "false";
	//anzahl der tage des monats:
	$anzahlTage = getNumberOfDaysOfMonth($monate,$jahr);
	$status = getStatus($tisch_id,0,0,$tag,$monate,$jahr,59,23,$tag,$monate,$jahr);
	if (isset($status) && (sizeof($status)>=1)){
		$statusString = BELEGT;
	}else{
		$statusString = FREI;
	}
	$gast_id = -1;
	$resIds = getReservierungIDs($tisch_id,$vonMinute,$vonStunde,$tag,$monate,$jahr,$bisMinute,$bisStunde,$tag,$monate,$jahr);
	?>
	<table width="100%">
		<?php	
		while ($d = $resIds->FetchNextObject()){
			$hasRes = "true";
			$reservierungs_id = $d->RESERVIERUNG_ID;
			$gast_id = getMieterIdOfReservierung($reservierungs_id);
			$mietdauer = getNumberOfDaysOfReservation($reservierungs_id);
			$isFirstDay = isFirstDayOfReservation($reservierungs_id,$tag,$monate,$jahr);
			$isLastDay = isLastDayOfReservation($reservierungs_id,$tag,$monate,$jahr);
			$timeVon = getTimeVonOfReservierung($reservierungs_id);
			$timeBis = getTimeBisOfReservierung($reservierungs_id);	?>
		<tr>						
			<form action="./mieterInfos/index.php" method="post" name="form<?php echo($tag); ?>" target="_self">
			  <td width=150>					  
				<?php
				//gast-namen ausgeben:
				if ($gast_id != ANONYMER_GAST_ID){
					echo getNachnameOfMieter($gast_id);					
				}else{
					echo(getUebersetzung("anonymer Gast"));
				}	?>
			  </td>
			<td width=130>
			<?php
			//zeit ausgeben:
			//wenn mietdauer mehr als 3 tage, braucht nur bei 
			//tag 1 und tag 3 die zeit ausgegeben werden:
			if ($mietdauer >= 2){
				if ( $isFirstDay ){
					echo($timeVon." - 24:00 ".getUebersetzung("Uhr"));
				}else if( $isLastDay ){
					echo("00:00 - ".$timeBis." ".getUebersetzung("Uhr"));
				}else{?>
					00:00 - 24:00 <?php echo getUebersetzung("Uhr") ?>	<?php
				}								
			}else{
				echo(getTimeVonOfReservierung($reservierungs_id)." - ".getTimeBisOfReservierung($reservierungs_id));
			} //ende else	
			?>
			</td>
			
			<td align="right">
				<input type="hidden" name="reservierung_id" value="<?php echo $d->RESERVIERUNG_ID ?>" />
				<input name="gast_id" type="hidden" value="<?php echo($gast_id); ?>">		
				<input type="hidden" name="monat" value="<?php echo $monate ?>" />
				<input type="hidden" name="jahr" value="<?php echo $jahr ?>" />
				<input type="hidden" name="tag" value="<?php echo $tag ?>" />
				<?php //button für Gast infos ausgeben:
				if ($gast_id != ANONYMER_GAST_ID){
				?>
				<input type="submit" name="Submit"  class="button"
						value="<?php echo(getUebersetzung("Gast-Info")); ?>"/> <?php
				} ?>
			</td></form>
			<?php 
			if($showDelete){ ?>
				<form action="./resEntfernen_Einzel.php" method="post" name="form<?php echo($tag); ?>" target="_self">
				<td align="left">
					<input name="reservierung_id" type="hidden" value="<?php echo($d->RESERVIERUNG_ID) ?>">	
					<input name="bisMinute" type="hidden" value="<?php echo $bisMinute ?>">
					<input name="vonMinute" type="hidden" value="<?php echo $vonMinute ?>">
					<input name="vonStunde" type="hidden" value="<?php echo $vonStunde ?>">
					<input name="bisStunde" type="hidden" value="<?php echo $bisStunde ?>">
					<input name="table_id" type="hidden" value="<?php echo $tisch_id ?>">
					<input name="raum_id" type="hidden" value="<?php echo $raum_id ?>">
					<input name="datumVon" type="hidden" value="<?php echo $datumVon ?>">
					<input name="ansicht" type="hidden" value="<?php echo  $ansicht ?>">					
					<input name="url" type="hidden" value="<?php echo  $url ?>">
					<input type="submit" name="Submit"  class="button"
							value="<?php echo(getUebersetzung("Löschen")); ?>"/>						
				</td></form>
			<?php 
			}	?>
		</tr> <?php 
			}	?>
	</table> 
<?php 	
	return $hasRes;
}//ende funktion showReservierungen

function isBlock($raum_id, $tisch_id, $vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr){
	global $gastro_id;
	global $root;
	include_once($root."/include/buchungseinschraenkung.inc.php");
	include_once($root."/include/mietobjektFunctions.inc.php");
	
	if(getStatusOfTisch($tisch_id) == "Tisch gesperrt"){
		return true;	
	}
	//Keine Reservierungen möglich in der Uhrzeit
	$typ = BE_TYP_ZEIT;
	$res = getBuchungseinschraenkungen($gastro_id,$typ);
	while ($d = $res->FetchNextObject()){
		$einschraenkungs_id = $d->RESERVIERUNGSEINSCHRAENKUNG_ID;
		if(	$tisch_id == $d->TISCHNUMMER &&	$raum_id  == getRaumOfTisch($d->TISCHNUMMER)){
			$vonZeit = $vonStunde*60 + $vonMinute;
			$bisZeit = $bisStunde*60 + $bisMinute;
			$vonZeitSchr = getVonStundeOfBuchungseinschraenkung($einschraenkungs_id)*60 
							+ getVonMinuteOfBuchungseinschraenkung($einschraenkungs_id);
			$bisZeitSchr = getBisStundeOfBuchungseinschraenkung($einschraenkungs_id)*60 
							+ getBisMinuteOfBuchungseinschraenkung($einschraenkungs_id);
			
     		if($vonZeit >= $vonZeitSchr	&& $vonZeit < $bisZeitSchr){
     			return true;
     		}else if($bisZeit >= $vonZeitSchr && $bisZeit < $bisZeitSchr){
     			return true;
     		}else if($bisZeit >= $bisZeitSchr && $vonZeit <= $vonZeitSchr){
     			return true;
     		}
		}
	}
	
	//Keine Reservierungen möglich an folgenden Tagen
	if(isDayEingeschraenkt($tisch_id, getDayName($vonTag,$vonMonat,$vonJahr))){
		return true;
	}
	
	//Keine Reservierungen möglich zu folgendem Datum
	$typ = BE_TYP_DATUM_VON_BIS;
	$res = getBuchungseinschraenkungenOfTisch($tisch_id,$typ);
	while ($d = $res->FetchNextObject()){
		$einschraenkungs_id = $d->RESERVIERUNGSEINSCHRAENKUNG_ID;
		$einschrVon = $d->VON;
		$einschrBis = $d->BIS;
		if(($vonJahr >= getYearFromBooklineDate($einschrVon) && $vonJahr <= getYearFromBooklineDate($einschrBis))
			&& ($vonMonat >= getMonthFromBooklineDate($einschrVon) && $vonMonat <= getMonthFromBooklineDate($einschrBis))
			&& ($vonTag >= getDayFromBooklineDate($einschrVon) && $vonTag <= getDayFromBooklineDate($einschrBis))){
						$vonZeit = $vonStunde*60 + $vonMinute;
			$bisZeit = $bisStunde*60 + $bisMinute;
			$vonZeitSchr = getHourFromBooklineDate($einschrVon)*60 
							+ getMinuteFromBooklineDate($einschrVon);
			$bisZeitSchr = getHourFromBooklineDate($einschrBis)*60 
							+ getMinuteFromBooklineDate($einschrBis);
			
     		if($vonZeit >= $vonZeitSchr	&& $vonZeit < $bisZeitSchr){
     			return true;
     		}else if($bisZeit >= $vonZeitSchr && $bisZeit < $bisZeitSchr){
     			return true;
     		}
		}		  						
	}
	return false;
}

function showInfo($reservierungs_id){
	$gast_id = getMieterIdOfReservierung($reservierungs_id);
	if ($gast_id != ANONYMER_GAST_ID){
		$gastName = getNachnameOfMieter($gast_id);					
	}else{
		$gastName = (getUebersetzung("anonymer Gast"));
	}
	return $gastName.' '.getTimeVonOfReservierung($reservierungs_id)." - ".getTimeBisOfReservierung($reservierungs_id);
}

function pageAendern($root, $gastro_id, $raum_id, $tisch_id, $vonStunde, $vonMinute, $tag,$monate,$jahr){
	require("./dispAendern.php"); 
}

function pageHinfuegen($root, $gastro_id, $raum_id, $tisch_id, $vonStunde, $vonMinute, $tag,$monate,$jahr){
	require("./dispHinfuegen.php"); 
}

function pageInfo(){
	include("./dispInfo.php");
}

function getID($status, $tisch_id, $vonStunde, $vonMinute){
	if ($vonStunde<10){
		$vonStunde="0".$vonStunde;
	}
	if ($vonMinute<10){
		$vonMinute="0".$vonMinute;
	}
	return $status.$tisch_id.$vonStunde.$vonMinute;
}
?>
