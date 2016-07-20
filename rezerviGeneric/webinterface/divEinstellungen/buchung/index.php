<?php $root = "../../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/webinterface/templates/components.inc.php"); 
include_once($root."/include/buchungseinschraenkung.inc.php");
include_once($root."/include/datumFunctions.inc.php");

$mietobjekt_einzahl = getMietobjekt_EZ($vermieter_id);
$mietobjekt_einzahl = getUebersetzungVermieter($mietobjekt_einzahl,$sprache,$vermieter_id); 
?>
<script type="text/javascript" src="<?php echo $root ?>/templates/calendarDateInput.inc.php?root=<?php echo $root ?>">
	/***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/	
</script>
<p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo getUebersetzung("Buchungen nur zu bestimmten Zeiten erlauben") ?>.</p>
<table class="<?php echo TABLE_STANDARD ?>">	  	
  <tr>
  	<td class="<?php echo STANDARD_SCHRIFT_BOLD ?>" colspan="2">
  		<?php echo getUebersetzung("Keine Buchungen möglich in der Uhrzeit"); ?>:
  	<td>
  <tr>
  <tr>
	<th>
		<div align="left">
			<?php echo $mietobjekt_einzahl ?> 
		</div>
	</th>		  		
	<th>
		<div align="left">
			<?php echo getUebersetzung("von") ?> 
		</div>
	</th>
	<th>
		<div align="left">
			<?php echo getUebersetzung("bis") ?> 
		</div>
	</th>	
	<th>
		<div align="left">
			<?php echo getUebersetzung("löschen/hinzufügen") ?> 
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
  $res = getBuchungseinschraenkungen($vermieter_id,$typ);
  while ($d = mysqli_fetch_array($res)){
	$einschraenkungs_id = $d["EINSCHRAENKUNGS_ID"];
  	$mietobjekt_id = $d["MIETOBJEKT_ID"];
  	$moBez = getMietobjektBezeichnung($mietobjekt_id);
  	$moBez = getUebersetzungVermieter($moBez,$sprache,$vermieter_id);  
  	$vonStunde = getVonStundeOfBuchungseinschraenkung($einschraenkungs_id);
  	$vonMinute = getVonMinuteOfBuchungseinschraenkung($einschraenkungs_id);
  	$bisStunde = getBisStundeOfBuchungseinschraenkung($einschraenkungs_id);
  	$bisMinute = getBisMinuteOfBuchungseinschraenkung($einschraenkungs_id);
  ?>
  <form action="./buchungseinschraenkungLoeschen.inc.php" method="post" target="_self">
  <input type="hidden" name="einschraenkungs_id" value="<?php echo $einschraenkungs_id ?>" />
  <tr>
  	<td>
		<?php echo $moBez ?>
  	</td>
  	<td>
		<?php echo $vonStunde ?>:<?php echo $vonMinute ?> <?php echo getUebersetzung("Uhr"); ?> 
	</td>
	<td>
	    <?php echo $bisStunde ?>:<?php echo $bisMinute ?> <?php echo getUebersetzung("Uhr"); ?>
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
  <input type="hidden" name="typ" value="<?php echo BE_TYP_ZEIT ?>"/>
  <tr>
  	<td>
		<select name="moId" id="moId">
				<option value="alle">alle</option>
				<?php
				$mobj = getMietobjekte($vermieter_id);
				while ($l = mysqli_fetch_array($mobj)){
					$moBez = $l["BEZEICHNUNG"];
					$moBez = getUebersetzungVermieter($moBez,$sprache,$vermieter_id);
					$mietobjekt_id = $l["MIETOBJEKT_ID"];
					?>
					<option value="<?php echo $mietobjekt_id ?>"><?php echo $moBez ?></option>			  						
					<?php		
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
	            <option value="<?php echo $l ?>"<?php if ($str == $vonStunde) echo(" selected=\"selected\""); ?>><?php echo $str ?></option>
	            <?php } ?>
	          </select>:
	          <select name="vonMinute"  id="vonMinute">
	            <?php				
				for ($l=1; $l < 60; $l++){ 
						$str = $l;
						if ($l<10 && $l>-1){
							$str="0".$l;
						} 
				?>
	            <option value="<?php echo $l ?>"<?php if ($str == $vonMinute) echo(" selected=\"selected\""); ?>><?php echo $str ?></option>
	            <?php } ?>
	          </select> 
	          <span class="<?php echo STANDARD_SCHRIFT ?>">
	          	<?php echo getUebersetzung("Uhr"); ?></span> 
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
	            <option value="<?php echo $l ?>"<?php if ($str == $bisStunde) echo(" selected=\"selected\""); ?>><?php echo $str ?></option>
	            <?php } ?>
	          </select>:
	          <select name="bisMinute"  id="bisMinute">
	            <?php				
				for ($l=1; $l < 60; $l++){ 
						$str = $l;
						if ($l<10 && $l>-1){
							$str="0".$l;
						} 
				?>
	            <option value="<?php echo $l ?>"<?php if ($str == $bisMinute) echo(" selected=\"selected\""); ?>><?php echo $str ?></option>
	            <?php } ?>
	          </select> 
	          <span class="<?php echo STANDARD_SCHRIFT ?>">
	          	<?php echo getUebersetzung("Uhr"); ?></span>
  	</td>
  	<td><?php showSubmitButton(getUebersetzung("hinzufügen")); ?></td>
  </tr>   
  </form> 
<!-- ende uhrzeit -->
</table>
<br/>
<table class="<?php echo TABLE_STANDARD ?>">	 
<!-- start tage   -->
	<tr>
		<td class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
			<?php echo getUebersetzung("Keine Buchungen möglich an folgenden Tagen"); ?>:
		<td>
		  <tr>
		  <tr>
		<td>
			<table class="<?php echo STANDARD_SCHRIFT ?>">	 	
				<tr>
					<th>
						<div align="left">
							<?php echo $mietobjekt_einzahl ?> 
						</div>
					</th>
			  		<th>
			  			<div align="left">
		  				 <?php echo getUebersetzung("Montag") ?> 
		  				</div>
		  			</th>
			  		<th>
			  			<div align="left">
		  				 <?php echo getUebersetzung("Dienstag") ?> 
		  				</div>
		  			</th>
		  			<th>
		  				<div align="left">
		  				 <?php echo getUebersetzung("Mittwoch") ?> 
		  				</div>
		  			</th>
			  		<th>
			  			<div align="left">
		  				 <?php echo getUebersetzung("Donnerstag") ?> 
		  				</div>
		  			</th>
			  		<th>
			  			<div align="left">
		  				 <?php echo getUebersetzung("Freitag") ?> 
		  				</div>
		  			</th>
			  		<th>
			  			<div align="left">
		  				 <?php echo getUebersetzung("Samstag") ?>
		  				</div>
		  			</th>
			  		<th>
			  			<div align="left">
		  				 <?php echo getUebersetzung("Sonntag") ?> 
		  				</div>
		  			</th>	
					<th>
						<div align="left">
							<?php echo getUebersetzung("löschen/hinzufügen") ?> 
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
			  $res = getMietobjekteWithBuchungseinschraenkungen($vermieter_id,$typ);
			  $anzahl = mysqli_num_rows($res);
			  $anzahlMietobjekte = getAnzahlMietobjekteOfVermieter($vermieter_id);
			  $alleMietobjekte = false;
			  if ($anzahl == $anzahlMietobjekte){
			  	$alleMietobjekte = true;
			  }
			  while ($d = mysqli_fetch_array($res)){
			  	$mietobjekt_id = $d["MIETOBJEKT_ID"];
			  	$moBez = getMietobjektBezeichnung($mietobjekt_id);
			  	$moBez = getUebersetzungVermieter($moBez,$sprache,$vermieter_id);  
			  	$monday = isMondayEingeschraenkt($mietobjekt_id);
			  	$tuesday = isTuesdayEingeschraenkt($mietobjekt_id);
			  	$wednesday = isWednesdayEingeschraenkt($mietobjekt_id);
			  	$thursday = isThursdayEingeschraenkt($mietobjekt_id);
			  	$friday = isFridayEingeschraenkt($mietobjekt_id);
			  	$saturday = isSaturdayEingeschraenkt($mietobjekt_id);
			  	$sunday = isSundayEingeschraenkt($mietobjekt_id);
			  ?>
			  <form action="./buchungseinschraenkungLoeschen.inc.php" method="post" target="_self">
			  <input type="hidden" name="mietobjekt_id" value="<?php echo $mietobjekt_id ?>" /> 
		  		<tr>
		  			<td>
		  				<?php
		  				if ($alleMietobjekte){
		  					echo("Alle");
		  				}
		  				else{
		  					echo($moBez);
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
					if ($alleMietobjekte){
						break;
					}
			    }
			    ?>
			    
			    <form action="./buchungseinschraenkungHinzufuegen.inc.php" method="post" target="_self">
			  	<input type="hidden" name="typ" value="<?php echo BE_TYP_TAG ?>"/>
			  	<tr>
		  			<td>
  						<select name="moId" id="moId">
								<option value="alle">alle</option>
								<?php
								$mobj = getMietobjekte($vermieter_id);
								while ($l = mysqli_fetch_array($mobj)){
									$moBez = $l["BEZEICHNUNG"];
									$moBez = getUebersetzungVermieter($moBez,$sprach,$vermieter_id);
									$mietobjekt_id = $l["MIETOBJEKT_ID"];
									?>
									<option value="<?php echo $mietobjekt_id ?>"><?php echo $moBez ?></option>			  						
									<?php		
								}
								?>
						</select> 
		  			</td>
			  		<td>
			  			<div align="center">
		  					<input type="checkbox" name="tage[]" value="<?php echo KURZFORM_MONTAG ?>"/>  
		  				</div>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<input type="checkbox" name="tage[]" value="<?php echo KURZFORM_DIENSTAG ?>"/> 
		  				</div>
		  			</td>
		  			<td>
		  				<div align="center">
		  					<input type="checkbox" name="tage[]" value="<?php echo KURZFORM_MITTWOCH ?>"/> 
		  				</div>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<input type="checkbox" name="tage[]" value="<?php echo KURZFORM_DONNERSTAG ?>"/>  
		  				</div>
		  			</td>
			  		<td><div align="center">
		  					<input type="checkbox" name="tage[]" value="<?php echo KURZFORM_FREITAG ?>"/> 
		  				</div>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<input type="checkbox" name="tage[]" value="<?php echo KURZFORM_SAMSTAG ?>"/>  
		  				</div>
		  			</td>
			  		<td>
			  			<div align="center">
		  					<input type="checkbox" name="tage[]" value="<?php echo KURZFORM_SONNTAG ?>"/>  
		  				</div>
		  			</td>	
		  			<td>
		  				<?php showSubmitButton(getUebersetzung("hinzufügen")); ?>	  
		  			</td>					  					  					  			
				</tr>
				</form>
			</table>
		<td>
	</tr>
</table>
<!-- ende tage -->
<br/>
<table border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
  <!-- start datum -->
  <tr>
  	<td class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
  		<?php echo getUebersetzung("Keine Buchungen möglich zu folgendem Datum"); ?>:
  	<td>
  <tr>
  <tr>
  	<td>
  		<table class="<?php echo STANDARD_SCHRIFT ?>">	  	
		  		<tr>
			  		<th>
			  			<div align="left">
		  					<?php echo $mietobjekt_einzahl ?> 
		  				</div>
		  			</th>		  		
			  		<th>
			  			<div align="left">
		  					<?php echo getUebersetzung("Datum von") ?> 
		  				</div>
		  			</th>
			  		<th>
			  			<div align="left">
		  					<?php echo getUebersetzung("Datum bis") ?> 
		  				</div>
		  			</th>
		  			<th>
		  				<div align="left">
		  					<?php echo getUebersetzung("löschen/hinzufügen") ?> 
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
				  $res = getMietobjekteWithBuchungseinschraenkungen($vermieter_id,$typ);
				  while ($d = mysqli_fetch_array($res)){
				  	$mietobjekt_id = $d["MIETOBJEKT_ID"];
				  	$moBez = getMietobjektBezeichnung($mietobjekt_id);
					$moBez = getUebersetzungVermieter($moBez,$sprache,$vermieter_id);  
				  	$res2 = getBuchungseinschraenkungenOfMietobjekt($mietobjekt_id,$typ);
				  	while ($r = mysqli_fetch_array($res2)){
					  	$einschrVon = $r["VON"];
					  	$einschrVon = parseMySqlTimestamp($einschrVon,true,true,true,true,true);
					  	$einschrBis = $r["BIS"];
					  	$einschrBis = parseMySqlTimestamp($einschrBis,true,true,true,true,true);
					  	$einschr_id = $r["EINSCHRAENKUNGS_ID"];
					?>
			  			<form action="./buchungseinschraenkungLoeschen.inc.php" method="post" target="_self">
			  			<input type="hidden" name="einschraenkungs_id" value="<?php echo $einschr_id ?>" />	
				  		<tr>
				  			<td>
				  				<?php echo $moBez ?> 
				  			</td>
					  		<td>
				  				<?php echo $einschrVon ?> <?php echo getUebersetzung("Uhr"); ?>
				  			</td>
					  		<td>
				  				<?php echo $einschrBis ?> <?php echo getUebersetzung("Uhr"); ?> 
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
	  		<input type="hidden" name="typ" value="<?php echo $typ ?>" />
  			<tr>
  				<td valign="top">
  					<select name="moId" id="moId">
  							<option value="alle">alle</option>
		  					<?php
		  					$mobj = getMietobjekte($vermieter_id);
		  					while ($l = mysqli_fetch_array($mobj)){
		  						$moBez = $l["BEZEICHNUNG"];
		  						$moBez = getUebersetzungVermieter($moBez,$sprach,$vermieter_id);
		  						$mietobjekt_id = $l["MIETOBJEKT_ID"];
		  						?>
		  						<option value="<?php echo $mietobjekt_id ?>"><?php echo $moBez ?></option>			  						
		  						<?php		
		  					}
		  					?>
  					</select>
			  </td>
		  		<td valign="top">
		        <table cellpadding="0" cellspacing="0" border="0">
			        <tr>
			        	<td colspan = "2">
							<script>DateInput('datumVon', true, 'DD/MM/YYYY','<?php echo $startdatumDP  ?>')</script>
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
				          </select>:
				          <select name="vonMinute"  id="vonMinute">
				            <?php				
							for ($l=0; $l < 60; $l++){ 
									if ($l<10){$l="0".$l;} ?>
				            <option value="<?php echo $l ?>"<?php if ($l == $vonMinute) echo(" selected=\"selected\""); ?>><?php echo $l ?></option>
				            <?php } ?>
				          </select> <span class="<?php echo STANDARD_SCHRIFT ?>">
				          	<?php echo getUebersetzung("Uhr"); ?></span></td>
			        </tr>
		        </table>
		    </td>
		    <td valign="top">
		        <table cellpadding="0" cellspacing="0" border="0">
			        <tr>
			        	<td colspan = "2">
							<script>DateInput('datumBis', true, 'DD/MM/YYYY','<?php echo $enddatumDP  ?>')</script>
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
				          </select>:
				          <select name="bisMinute"  id="bisMinute">
				            <?php				
							for ($l=0; $l < 60; $l++){ 
								if ($l<10){$l="0".$l;}		
							?>
				            <option value="<?php echo $l ?>"<?php if ($l == $bisMinute) echo(" selected=\"selected\""); ?>><?php echo $l ?></option>
				            <?php } ?>
				          </select> <span class="<?php echo STANDARD_SCHRIFT ?>">
				          	<?php echo getUebersetzung("Uhr"); ?></span></td>
			        </tr>
		        </table>
  			  </td>
		  		<td valign="top">
	  				<?php showSubmitButton(getUebersetzung("hinzufügen")); ?> 
	  			</td>	  					  					  					  			
  			</tr>
  			</form>
	  </table>
  	<td>
  </tr>	     
</table>
</form>
<br/>
<?php 
//-----buttons um zurück zum menue zu gelangen: 
showSubmitButtonWithForm("../index.php",getUebersetzung("zurück"));
include_once($root."/webinterface/templates/footer.inc.php");
?>