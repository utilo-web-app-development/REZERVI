<? 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";
$unterschrift = "Reservierungen";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, $ueberschrift, "divEinstellungen/index.php",
							$unterschrift, "divEinstellungen/buchung/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php"); 
include_once($root."/include/buchungseinschraenkung.inc.php");
include_once($root."/include/datumFunctions.inc.php");

?>
<script type="text/javascript" src="<?= $root ?>/templates/calendarDateInput.inc.php?root=<?= $root ?>">
	/***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/	
</script>
<h2><?php echo(getUebersetzung("Dauer einer einzelnen Reservierung")); ?></h2>
<?php
//dauer einer reservierung auslesen:
//in minuten
$dauer = getGastroProperty(RESERVIERUNGSDAUER,$gastro_id);
$vonDauerStunde = ($dauer - ($dauer % 60)) / 60;
$vonDauerMinute = $dauer-($vonDauerStunde*60);
?>
<form action="./setReservierungsdauer.inc.php" method="post" target="_self">
	<table>	  	
	  <tr>
	  	<td>
	  		<?= getUebersetzung("Reservierungsdauer") ?>:
	  	<td>
	  	<td>
	  		<select name="vonDauerStunde" id="vonDauerStunde">
	            <?php				
				for ($l=1; $l < 24; $l++){ 
						$str = $l;
						if ($l<10 && $l>-1){
							$str="0".$l;
						} 
				?>
	            <option value="<?= $l ?>"<?php if ($str == $vonDauerStunde){ 
	            									echo(" selected=\"selected\""); 
												}?>><?= $str ?></option>
	            <?php } ?>
		     </select>
		     <?= getUebersetzung("Stunden") ?>
	         <select name="vonDauerMinute"  id="vonDauerMinute">
	            <?php	
	            for ($l=0; $l < 2; $l++){ 
					$str = $l * 30;
					if($str == 0){
						$str="0".$str;
					}	
				?>
	            <option value="<?= $l ?>"<?php if ($str == $vonDauerMinute) {
	            								echo(" selected=\"selected\""); }
	            						  ?>><?= $str ?></option>
	            <?php } ?>
	         </select> 
	         <?= getUebersetzung("Minuten") ?>
	  	</td>
		<td><?php showSubmitButton(getUebersetzung("ändern")); ?></td>	  	
	  <tr>
	</table>
</form>

<br/><br/>
<h2><?php echo(getUebersetzung("Reservierungen nur zu bestimmten Zeiten erlauben")); ?></h2>
<table>	  	
  <tr>
  	<td colspan="4">
  		<?= getUebersetzung("Keine Reservierungen möglich in der Uhrzeit"); ?>:
  	<td>
  <tr>
  <tr>
	<th>
		<div align="left">
			<?= getUebersetzung("Raum/Tisch"); ?> 
		</div>
	</th>		  		
	<th>
		<div align="left">
			<?= getUebersetzung("von") ?> 
		</div>
	</th>
	<th>
		<div align="left">
			<?= getUebersetzung("bis") ?> 
		</div>
	</th>	
	<th>
		<div align="left">
			<?= getUebersetzung("löschen/hinzufügen") ?> 
		</div>
	</th> 			
  </tr>
  <tr>
	<td colspan="4">
		<hr/> 
	</td>	  					  					  					  			
  </tr>	    
  <?php
  $typ = BE_TYP_ZEIT;
  $res = getBuchungseinschraenkungen($gastro_id,$typ);
  $alleArr = array();
  while ($d = $res->FetchNextObject()){
	$einschraenkungs_id = $d->RESERVIERUNGSEINSCHRAENKUNG_ID;
	$all = false;
	$alle= "false";
  	$tisch_id = $d->TISCHNUMMER;
    $raum_id  = getRaumOfTisch($tisch_id);
    $raum_tisch = getRaumBezeichnung($raum_id)."/".$tisch_id;
     
  	$vonStunde = getVonStundeOfBuchungseinschraenkung($einschraenkungs_id);  	
  	$vonMinute = getVonMinuteOfBuchungseinschraenkung($einschraenkungs_id);
  	$bisStunde = getBisStundeOfBuchungseinschraenkung($einschraenkungs_id);
  	$bisMinute = getBisMinuteOfBuchungseinschraenkung($einschraenkungs_id);

  	//pruefe array mit einschraenkungen fuer alle tische
  	//ob die einschraenkung bereits angezeigt wurde.
  	for ($i = 0; $i<count($alleArr); $i++){
	  	if ($alleArr[$i]['vonStunde'] == $vonStunde 
				&&
				$alleArr[$i]['vonMinute'] == $vonMinute
				&&
				$alleArr[$i]['bisStunde'] == $bisStunde
				&&
				$alleArr[$i]['bisMinute'] == $bisMinute){
					continue(2);
		}  	
  	}
  	if (hasAllTablesSameLimitation($einschraenkungs_id)){
 
		$raum_tisch = "alle Tische";
		$raum_tisch = getUebersetzung($raum_tisch);
		$all = true;
		$alle = "true";
		$zeiten[] = array();
		$zeiten['vonStunde']=$vonStunde;
		$zeiten['vonMinute']=$vonMinute;
		$zeiten['bisStunde']=$bisStunde;
		$zeiten['bisMinute']=$bisMinute;
		$alleArr[] = $zeiten;
		
	}  
  ?>
  <form action="./buchungseinschraenkungLoeschen.inc.php" method="post" target="_self">
	  <input type="hidden" name="einschraenkungs_id" value="<?= $einschraenkungs_id ?>" />
	  <input type="hidden" name="typ" value="<?= $typ ?>" />
	  <input type="hidden" name="alle" value="<?= $alle ?>" />
	  <tr>
	  	<td>
			<?= $raum_tisch ?>
	  	</td>
	  	<td>
			<?= $vonStunde ?>:<?= $vonMinute ?> <?= getUebersetzung("Uhr"); ?> 
		</td>
		<td>
		    <?= $bisStunde ?>:<?= $bisMinute ?> <?= getUebersetzung("Uhr"); ?>
	  	</td>
	  	<td><?php showSubmitButton(getUebersetzung("löschen")); ?></td>
	  </tr>  
  </form>
  <tr>
	<td colspan="4">
		<hr/> 
	</td>	  					  					  					  			
  </tr>	  
  <?php 
  }
  $vonMinute = 1;
  $vonStunde = 1;
  $bisMinute = 1;
  $bisStunde = 1;
  ?>
  <form action="./buchungseinschraenkungHinzufuegen.inc.php" method="post" target="_self">
  <input type="hidden" name="typ" value="<?= BE_TYP_ZEIT ?>"/>
  <tr>
  	<td>
		<select name="moId" id="moId">
				<option value="alle"><?= getUebersetzung("alle") ?></option>
				<?php
				$raum_res = getRaeume($gastro_id);
				while ($l = $raum_res->FetchNextObject()){
					$raum_bez = $l->BEZEICHNUNG;
					$raum_id  = $l->RAUM_ID;
					$tisch_res = getTische($raum_id);
					while ($t = $tisch_res->FetchNextObject()){
						$tisch_id = $t->TISCHNUMMER;
						$raum_tisch = $raum_bez."/".$tisch_id;
						?>
						<option value="<?= $tisch_id ?>"><?= $raum_tisch ?></option>			  						
					<?php	
					}	
				}
				?>
		</select>
  	</td>
  	<td>
		<select name="vonStunde"  id="vonStunde">
	            <?php				
				for ($l=1; $l < 24; $l++){ 
						$str = $l;
						if ($l<10 && $l>-1){
							$str="0".$l;
						} 
				?>
	            <option value="<?php echo $l ?>"<?php if ($str == $vonStunde) echo(" selected=\"selected\""); ?>><?= $str ?></option>
	            <?php } ?>
	          </select>
	          <select name="vonMinute"  id="vonMinute">
	            <?php				
	            for ($l=0; $l < 2; $l++){ 
					$str = $l * 30;
					if($str == 0){
						$str="0".$str;
					}	
				?>
	            <option value="<?= $l ?>"<?php if ($str == $vonMinute) echo(" selected=\"selected\""); ?>><?= $str ?></option>
	            <?php } ?>
	          </select> 
	          <span>
	          	<?= getUebersetzung("Uhr"); ?></span> 
	  </td>
	  <td>
	          <select name="bisStunde"  id="bisStunde">
	            <?php				
				for ($l=1; $l < 24; $l++){ 
						$str = $l;
						if ($l<10 && $l>-1){
							$str="0".$l;
						}						
				?>
	            <option value="<?= $l ?>"<?php if ($str == $bisStunde) echo(" selected=\"selected\""); ?>><?= $str ?></option>
	            <?php } ?>
	          </select>
	          <select name="bisMinute"  id="bisMinute">
	            <?php				
	            for ($l=0; $l < 2; $l++){ 
					$str = $l * 30;
					if($str == 0){
						$str="0".$str;
					}	
				?>
	            <option value="<?= $l ?>"<?php if ($str == $bisMinute) echo(" selected=\"selected\""); ?>><?= $str ?></option>
	            <?php } ?>
	          </select> 
	          <span>
	          	<?= getUebersetzung("Uhr"); ?></span>
  	</td>
  	<td><?php showSubmitButton(getUebersetzung("hinzufügen")); ?></td>
  </tr>   
  </form> 
<!-- ende uhrzeit -->
</table>
<br/><br/>
<!-- start tage   -->
 
<h2><?= getUebersetzung("Keine Reservierungen möglich an folgenden Tagen"); ?>:</h2>
	<table>	 	
		<tr>
			<th>
				<div align="left">
					<?= getUebersetzung("Raum/Tisch"); ?>
				</div>
			</th>
	  		<th>
	  			<div align="left">
  				 <?= getUebersetzung("Montag") ?> 
  				</div>
  			</th>
	  		<th>
	  			<div align="left">
  				 <?= getUebersetzung("Dienstag") ?> 
  				</div>
  			</th>
  			<th>
  				<div align="left">
  				 <?= getUebersetzung("Mittwoch") ?> 
  				</div>
  			</th>
	  		<th>
	  			<div align="left">
  				 <?= getUebersetzung("Donnerstag") ?> 
  				</div>
  			</th>
	  		<th>
	  			<div align="left">
  				 <?= getUebersetzung("Freitag") ?> 
  				</div>
  			</th>
	  		<th>
	  			<div align="left">
	 				 <?= getUebersetzung("Samstag") ?>
				</div>
			</th>
	  		<th>
	  			<div align="left">
	 				 <?= getUebersetzung("Sonntag") ?> 
				</div>
			</th>	
			<th>
				<div align="left">
					<?= getUebersetzung("löschen/hinzufügen") ?> 
				</div>
			</th> 
		</tr>
		<tr>
			<td colspan="9">
				<hr/> 
		 	</td>	  					  					  					  			
	  	</tr>	
		<?php
		 $typ = BE_TYP_TAG;
		 $res = getTischeWithBuchungseinschraenkungen($gastro_id,$typ);
		 while ($d = $res->FetchNextObject()){
		 	$tisch_id = $d->TISCHNUMMER;
    		$raum_id  = getRaumOfTisch($tisch_id);
    			$raum_tisch = getRaumBezeichnung($raum_id)."/".$tisch_id;
			  	$monday = isMondayEingeschraenkt($tisch_id);
			  	$tuesday = isTuesdayEingeschraenkt($tisch_id);
			  	$wednesday = isWednesdayEingeschraenkt($tisch_id);
			  	$thursday = isThursdayEingeschraenkt($tisch_id);
			  	$friday = isFridayEingeschraenkt($tisch_id);
			  	$saturday = isSaturdayEingeschraenkt($tisch_id);
			  	$sunday = isSundayEingeschraenkt($tisch_id);
			  	$alle = hasAllTablesWithTypSameLimitation($tisch_id,$typ);
			  	if ($alle){
			  		$tisch_id = "alle";
			  	}
			  ?>
			  <form action="./buchungseinschraenkungLoeschen.inc.php" method="post" target="_self">
			  <input type="hidden" name="mietobjekt_id" value="<?= $tisch_id ?>" /> 
		  		<tr>
		  			<td>
		  				<?php
		  				if ($alle){
		  					echo(getUebersetzung("Alle Tische"));
		  				}
		  				else{
		  					echo($raum_tisch);
		  				}
		  				?> 
		  			</td>
			  		<td>
			  			<div align="center">
		  				 <?php if ($monday) { echo("&radic;"); } ?> 
		  				</div>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<?php if ($tuesday) { echo("&radic;"); } ?>
		  				</div>
		  			</td>
		  			<td>
		  				<div align="center">
		  					<?php if ($wednesday) { echo("&radic;"); } ?>
		  				</div>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<?php if ($thursday) { echo("&radic;"); } ?>
		  				</div>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<?php if ($friday) { echo("&radic;"); } ?>
		  				</div>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<?php if ($saturday) { echo("&radic;"); } ?> 
		  				</div>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<?php if ($sunday) { echo("&radic;"); } ?> 
		  				</div>
		  			</td>	
		  			<td>
		  				<?php showSubmitButton(getUebersetzung("löschen")); ?>	  
		  			</td>					  					  					  			
				</tr>
		  		<tr>
		  			<td colspan="9">
		  				<hr/> 
		  			</td>	  					  					  					  			
	  			</tr>					
				</form>
				<?php
					if ($alle){
						break;
					}
			    }
			    ?>
			    
			    <form action="./buchungseinschraenkungHinzufuegen.inc.php" method="post" target="_self">
			  	<input type="hidden" name="typ" value="<?= BE_TYP_TAG ?>"/>
			  	<tr>
		  			<td>
						<select name="moId" id="moId">
								<option value="alle"><?= getUebersetzung("alle") ?></option>
								<?php
								$raum_res = getRaeume($gastro_id);
								while ($l = $raum_res->FetchNextObject()){
									$raum_bez = $l->BEZEICHNUNG;
									$raum_id  = $l->RAUM_ID;
									$tisch_res = getTische($raum_id);
									while ($t = $tisch_res->FetchNextObject()){
										$tisch_id = $t->TISCHNUMMER;
										$raum_tisch = $raum_bez."/".$tisch_id;
										?>
										<option value="<?= $tisch_id ?>"><?= $raum_tisch ?></option>			  						
									<?php	
									}	
								}
								?>
						</select>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<input type="checkbox" name="tage[]" value="<?= KURZFORM_MONTAG ?>"/>  
		  				</div>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<input type="checkbox" name="tage[]" value="<?= KURZFORM_DIENSTAG ?>"/> 
		  				</div>
		  			</td>
		  			<td>
		  				<div align="center">
		  					<input type="checkbox" name="tage[]" value="<?= KURZFORM_MITTWOCH ?>"/> 
		  				</div>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<input type="checkbox" name="tage[]" value="<?= KURZFORM_DONNERSTAG ?>"/>  
		  				</div>
		  			</td>
			  		<td><div align="center">
		  					<input type="checkbox" name="tage[]" value="<?= KURZFORM_FREITAG ?>"/> 
		  				</div>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<input type="checkbox" name="tage[]" value="<?= KURZFORM_SAMSTAG ?>"/>  
		  				</div>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<input type="checkbox" name="tage[]" value="<?= KURZFORM_SONNTAG ?>"/>  
		  				</div>
		  			</td>	
		  			<td>
		  				<?php showSubmitButton(getUebersetzung("hinzufügen")); ?>	  
		  			</td>					  					  					  			
				</tr>
				</form>
			</table>
<!-- ende tage -->
<br/><br/>
  <!-- start datum -->
<h2><?= getUebersetzung("Keine Reservierungen möglich zu folgendem Datum"); ?>:</h2>
  		<table>	  	
		  		<tr>
			  		<th>
			  			<div align="left">
		  					<?= getUebersetzung("Raum/Tisch"); ?> 
		  				</div>
		  			</th>		  		
			  		<th>
			  			<div align="left">
		  					<?= getUebersetzung("Datum von") ?> 
		  				</div>
		  			</th>
			  		<th>
			  			<div align="left">
		  					<?= getUebersetzung("Datum bis") ?> 
		  				</div>
		  			</th>
		  			<th>
		  				<div align="left">
		  					<?= getUebersetzung("löschen/hinzufügen") ?> 
		  				</div>
		  			</th>
		  		</tr>
		  		<tr>
		  			<td colspan="4">
		  				<hr/> 
		  			</td>	  					  					  					  			
	  			</tr>			  		
				 <?php
				  $typ = BE_TYP_DATUM_VON_BIS;
				  $res = getTischeWithBuchungseinschraenkungen($gastro_id,$typ);
				  $alleArr = array();
				  while ($d = $res->FetchNextObject()){
				  	$tisch_id = $d->TISCHNUMMER;
	    			$raum_id  = getRaumOfTisch($tisch_id);
	    			$raum_tisch = getRaumBezeichnung($raum_id)."/".$tisch_id; 
				  	$res2 = getBuchungseinschraenkungenOfTisch($tisch_id,$typ);
				  	while ($r = $res2->FetchNextObject()){
				  		$einschraenkungs_id = $r->RESERVIERUNGSEINSCHRAENKUNG_ID;
					  	$einschrVon = $r->VON;
					  	$einschrVon = getFormatedDateFromBooklineDate($einschrVon);
					  	$einschrBis = $r->BIS;
					  	$einschrBis = getFormatedDateFromBooklineDate($einschrBis);
					  	$einschr_id = $r->RESERVIERUNGSEINSCHRAENKUNG_ID;
					  	$alle = "false";
					  						
					  	//pruefe array mit einschraenkungen fuer alle tische
					  	//ob die einschraenkung bereits angezeigt wurde.
					  	for ($i = 0; $i<count($alleArr); $i++){
						  	if ($alleArr[$i]['einschrVon'] == $einschrVon 
									&&
									$alleArr[$i]['einschrBis'] == $einschrBis
								){
									continue(2);
							}  	
					  	}
					  	if (hasAllTablesSameLimitation($einschraenkungs_id)){
					 
							$raum_tisch = "alle Tische";
							$raum_tisch = getUebersetzung($raum_tisch);
							$all = true;
							$alle = "true";
							$zeiten[] = array();
							$zeiten['einschrVon']=$einschrVon;
							$zeiten['einschrBis']=$einschrBis;
							$alleArr[] = $zeiten;
							
						}  
					  	
					?>
			  			<form action="./buchungseinschraenkungLoeschen.inc.php" method="post" target="_self">
			  			<input type="hidden" name="einschraenkungs_id" value="<?= $einschr_id ?>" />
			  			<input type="hidden" name="typ" value="<?= $typ ?>" />
	  					<input type="hidden" name="alle" value="<?= $alle ?>" />	
				  		<tr>
				  			<td>
				  				<?= $raum_tisch ?> 
				  			</td>
					  		<td>
				  				<?= $einschrVon ?> <?= getUebersetzung("Uhr"); ?>
				  			</td>
					  		<td>
				  				<?= $einschrBis ?> <?= getUebersetzung("Uhr"); ?> 
				  			</td>
					  		<td>
				  				<?php showSubmitButton(getUebersetzung("löschen")); ?> 
				  			</td>	  					  					  					  			
			  			</tr>
				  		<tr>
				  			<td colspan="4">
				  				<hr/> 
				  			</td>	  					  					  					  			
			  			</tr>	
			  			</form>  			
	  				<?php
			  	} //ende while
			} //ende while
			  include_once($root."/include/datumFunctions.inc.php");
			    
			 	if (!isset($vonMinute)){
					$vonMinute = getTodayMinute();
				}
				if (!isset($bisMinute)){
					$bisMinute = getTodayMinute();
				}
				if (!isset($bisStunde)){
					$bisStunde = getTodayStunde();
				}
				if (!isset($vonStunde)){
					$vonStunde = getTodayStunde();
				}	
				if (!isset($vonTag)){
					$vonTag = getTodayDay();
				}
				if (!isset($bisTag)){
					$bisTag = getTodayDay();
				}
				if (!isset($vonMonat)){
					$vonMonat = getTodayMonth();
				}
				if (!isset($bisMonat)){
					$bisMonat = getTodayMonth();
				}
				if (!isset($vonJahr)){
					$vonJahr = getTodayYear();
				}
				if (!isset($bisJahr)){
					$bisJahr = getTodayYear();
				}
				if (!isset($tag)){
					$tag = $vonTag;
				}
				if (!isset($monat)){
					$monat = $vonMonat;
				}
				if (!isset($jahr)){
					$jahr = $vonJahr;
				}
				
				$startdatumDP = $tag."/".$monat."/".$jahr;
				$enddatumDP =   $startdatumDP;
 
				?>
			<form action="./buchungseinschraenkungHinzufuegen.inc.php" method="post" target="_self">
	  		<input type="hidden" name="typ" value="<?= $typ ?>" />
  			<tr>
  				<td>
					<select name="moId" id="moId">
							<option value="alle"><?= getUebersetzung("alle") ?></option>
							<?php
							$raum_res = getRaeume($gastro_id);
							while ($l = $raum_res->FetchNextObject()){
								$raum_bez = $l->BEZEICHNUNG;
								$raum_id  = $l->RAUM_ID;
								$tisch_res = getTische($raum_id);
								while ($t = $tisch_res->FetchNextObject()){
									$tisch_id = $t->TISCHNUMMER;
									$raum_tisch = $raum_bez."/".$tisch_id;
									?>
									<option value="<?= $tisch_id ?>"><?= $raum_tisch ?></option>			  						
								<?php	
								}	
							}
							?>
					</select>
			  </td>
		  		<td valign="top">
		        <table>
			        <tr>
			        	<td colspan = "2">
							<script>DateInput('datumVon', true, 'DD/MM/YYYY','<?= $startdatumDP  ?>')</script>
			          	</td>
			        </tr>
			        <tr>
			        	<td width="20">
			          	</td>
			          	<td><select name="vonStunde"  id="vonStunde">
				            <?php				
							for ($l=0; $l < 24; $l++){ 
									if ($l<10){$l="0".$l;} ?>
				            <option value="<?php echo $l ?>"<?php if ($l == $vonStunde) echo(" selected=\"selected\""); ?>><?php echo $l ?></option>
				            <?php } ?>
				          </select>
				          <select name="vonMinute"  id="vonMinute">
				            <?php				
							for ($l=0; $l < 2; $l++){ 
								$str = $l * 30;
								if($str == 0){
									$str="0".$str;
								}	
 							?>
				            <option value="<?php echo $str ?>"<?php if ($str == $vonMinute) echo(" selected=\"selected\""); ?>><?php echo $str ?></option>
				            <?php } ?>
				          </select> <span>
				          	<?= getUebersetzung("Uhr"); ?></span></td>
			        </tr>
		        </table>
		    </td>
		    <td valign="top">
		        <table>
			        <tr>
			        	<td colspan = "2">
							<script>DateInput('datumBis', true, 'DD/MM/YYYY','<?= $enddatumDP  ?>')</script>
			          	</td>
			        </tr>
			        <tr>
			        	<td width="20">
			          	</td>
			          	<td><select name="bisStunde"  id="bisStunde">
				            <?php				
							for ($l=0; $l < 24; $l++){ 
								if ($l<10){$l="0".$l;}	
							?>
				            <option value="<?php echo $l ?>"<?php if ($l == $bisStunde) echo(" selected=\"selected\""); ?>><?php echo $l ?></option>
				            <?php } ?>
				          </select>
				          <select name="bisMinute"  id="bisMinute">
				            <?php				
	           				 for ($l=0; $l < 2; $l++){ 
								$str = $l * 30;
								if($str == 0){
									$str="0".$str;
								}	
							?>
				            <option value="<?php echo $str ?>"<?php if ($str == $bisMinute) echo(" selected=\"selected\""); ?>><?php echo $str ?></option>
				            <?php } ?>
				          </select> <span>
				          	<?= getUebersetzung("Uhr"); ?></span></td>
			        </tr>
		        </table>
  			  </td>
		  		<td valign="bottom">
	  				<?php showSubmitButton(getUebersetzung("hinzufügen")); ?> 
	  			</td>	  					  					  					  			
  			</tr>
  			</form>
	  </table>
<?php 
include_once($root."/backoffice/templates/footer.inc.php");
?>