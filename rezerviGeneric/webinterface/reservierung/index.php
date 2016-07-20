<?php $root = "../..";

/*   
	date: 20.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/templates/constants.inc.php");
	
	//falls keine mietobjekt_id ausgew�hlt wurde, das erste gefundene zimmer nehmen:
	if (isset($_POST["mietobjekt_id"])) {
		$mietobjekt_id = $_POST["mietobjekt_id"];
	}
	else{
		$mietobjekt_id = getFirstMietobjektId($vermieter_id);
	}
	
	//falls kein jahr ausgew�hlt wurde, das aktuelle jahr verwenden:
	if (isset($_POST["datumAnsicht"])){
		$jahr = getJahrFromDatePicker($_POST["datumAnsicht"]);
	}
	else if (isset($_POST["jahr"])){
		$jahr = $_POST["jahr"];
	}
	else{
		$jahr = getTodayYear();
	}
	
	if (isset($_POST["minute"])){
		$minute = $_POST["minute"];
	}
	else{
		$minute = getTodayMinute();
	}
	
	if (isset($_POST["stunde"])){
		$stunde = $_POST["stunde"];
	}
	else{
		$stunde = getTodayStunde();
	}
	
	if (isset($_POST["datumAnsicht"])){
		$monat = getMonatFromDatePicker($_POST["datumAnsicht"]);
	}
	else if (isset($_POST["monat"])){
		$monat = $_POST["monat"];
	}	
	else{
		$monat = getTodayMonth();
	}	
	
	if (isset($_POST["datumAnsicht"])){
		$tag = getTagFromDatePicker($_POST["datumAnsicht"]);
	}
	else if (isset($_POST["tag"])){
		$tag = $_POST["tag"];
	}	
	else{
		$tag = getTodayDay();
	}
	
	if (isset($_POST["ansicht"])){
		$ansicht = $_POST["ansicht"];
	}
	else{
		$ansicht = getVermieterEigenschaftenWert(STANDARDANSICHT,$vermieter_id);
	}
	
	if (isset($_POST["vonMinute"])){
		$vonMinute = $_POST["vonMinute"];
	}
	else{
		$vonMinute = getTodayMinute();
	}
	if (isset($_POST["bisMinute"])){
		$bisMinute = $_POST["bisMinute"];
	}
	else{
		$bisMinute = getTodayMinute();
	}
	if (isset($_POST["bisStunde"])){
		$bisStunde = $_POST["bisStunde"];
	}
	else{
		$bisStunde = getTodayStunde();
	}
	if (isset($_POST["vonStunde"])){
		$vonStunde = $_POST["vonStunde"];
	}
	else{
		$vonStunde = getTodayStunde();
	}
	
	if (isset($_POST["vonTag"])){
		$vonTag = $_POST["vonTag"];
	}
	else{
		$vonTag = getTodayDay();
	}
	if (isset($_POST["bisTag"])){
		$bisTag = $_POST["bisTag"];
	}
	else{
		$bisTag = getTodayDay();
	}
	if (isset($_POST["vonMonat"])){
		$vonMonat = $_POST["vonMonat"];
	}
	else{
		$vonMonat = getTodayMonth();
	}
	if (isset($_POST["bisMonat"])){
		$bisMonat = $_POST["bisMonat"];
	}
	else{
		$bisMonat = getTodayMonth();
	}
	if (isset($_POST["vonJahr"])){
		$vonJahr = $_POST["vonJahr"];
	}
	else{
		$vonJahr = getTodayYear();
	}
	if (isset($_POST["bisJahr"])){
		$bisJahr = $_POST["bisJahr"];
	}
	else{
		$bisJahr = getTodayYear();
	}
	
	$startdatumDP = $tag."/".$monat."/".$jahr;
	$enddatumDP =   $startdatumDP;
				
?>
<script language="JavaScript" type="text/javascript" src="./leftJS.js">
</script>
<script type="text/javascript" src="<?php echo $root ?>/templates/calendarDateInput.inc.php?root=<?php echo $root ?>">
	/***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/	
</script>
<table>
  <tr>
	<td valign="top">
	<!-- linke seite - navigation: -->		
	<form action="./index.php" method="post" name="reservierung">
		<table border="0" class="<?php echo TABLE_STANDARD ?>">		
		  <tr>
		    <td>		      
		        <table border="0" cellspacing="3" cellpadding="0">
		        	<tr>
			        	<td colspan="2">
			        		<span class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
			        			<?php echo getUebersetzung("Ansicht f�r Datum") ?>:
			          		</span>
			          	</td>
			        </tr>
			        <tr>
			        	<td colspan="2">
							<script>DateInput('datumAnsicht', true, 'DD/MM/YYYY','<?php echo $startdatumDP  ?>')</script>
			          	</td>
			        </tr>
		          <tr>
		            <td colspan="2">
		            	<span class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
		            		<?php echo getUebersetzungVermieter(getVermieterMietobjektEz($vermieter_id),$sprache,$vermieter_id) ?>:
		            	</span>
		            </td>
		          </tr>
		          <tr>  
		            <td colspan="2">
		                <select name="mietobjekt_id"  id="mietobjekt_id" onchange="submit()">
		                  <?php
		  					$res = getMietobjekteOfVermieter($vermieter_id);
			 				while($d = mysqli_fetch_array($res)) { ?>
		                  		<option value="<?php echo $d["MIETOBJEKT_ID"] ?>"<?php if ($mietobjekt_id == $d["MIETOBJEKT_ID"]) {echo(" selected=\"selected\"");} ?>><?php echo $d["BEZEICHNUNG"] ?></option>
		                  <?php } ?>
		                </select>
		            </td>
		          </tr>
		        </table>
		      </td>
		  </tr>
		  <tr>
		    <td><span class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Ansicht w�hlen")); ?>:</span></td>
		  </tr>
		  <tr>
		    <td>
		        <div align="left">
		          <select name="ansicht" onchange="submit()">
		          <?php foreach ($ansicht_array as $ans){ ?>
		            <option value="<?php echo $ans ?>" <?php if ($ansicht == $ans) {?> selected="selected" <?php } ?>><?php echo(getUebersetzung($ans)); ?></option>
		 		  <?php } ?>
		 		  </select>
		        </div>
			</td>
		  </tr>
		  <tr>
		  	<td colspan ="2">
		  		<input name="ansichtWechseln" type="submit" 
		  			class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		      		onMouseOut="this.className='<?php echo BUTTON ?>';" 
		      		id="ansichtWechseln" 
		      		value="<?php echo(getUebersetzung("anzeigen")); ?>">
		    </td>
		  </tr>		  
		  </table>
	  </form>
	  <br/>
	  <form action="<?php echo $root ?>/webinterface/reservierung/resAendern.php" method="post" name="resAendern">
	  <input type="hidden" name="ansicht" value="<?php echo $ansicht ?>"/>
	  <input type="hidden" name="mietobjekt_id" value="<?php echo $mietobjekt_id ?>"/>
		<table border="0" class="<?php echo TABLE_STANDARD ?>">		  
		  <tr>
		    <td>
		        <span class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Reservierung �ndern")); ?>:</span>
		        <table>
		          <tr>
		            <td width="1" class="<?php echo BELEGT ?>">
		              <label>
		              	<input name="status" type="radio" value="<?php echo STATUS_BELEGT ?>" checked="checked">
		              </label></td>
		            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("belegt")); ?></td>
		          </tr>
		          <tr>
		            <td width="1" class="<?php echo FREI ?>">
		              <label>
		              	<input name="status" type="radio" value="<?php echo STATUS_FREI ?>">
		              </label></td>
		            <td class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("frei")); ?></td>
		          </tr>
		        </table>
		        <table>
		        <tr>
		        	<td colspan = "2">
		        		<span class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
		        			<?php echo(getUebersetzung("von")); ?>:
		          		</span>
		          	</td>
		        </tr>
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
		        <table>
		        <tr>
		        	<td colspan = "2">
		        		<span class="<?php echo STANDARD_SCHRIFT_BOLD ?>">
		        			<?php echo(getUebersetzung("bis")); ?>:
		          		</span>
		          	</td>
		        </tr>
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

		        <p>
		          <input name="reservierungAendern" type="submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		      		 onMouseOut="this.className='<?php echo BUTTON ?>';" id="reservierungAbsenden2" value="<?php echo(getUebersetzung("Reservierung �ndern")); ?>">
		        </p>
		        
		     </td>
		  </tr>
		</table>
	</form>
		<!-- ende linke seite - menue -->
		</td>
		<td valign="top">
		<!-- rechte seite - plan -->
		<?php
			if ($ansicht == JAHRESUEBERSICHT){
				include_once("./jahresuebersicht.php");
			}
			else if ($ansicht == TAGESANSICHT){
				include_once("./tagesuebersicht.php");			
			}
			else if ($ansicht == WOCHENANSICHT){
				include_once("./wochenuebersicht.php");
			}
			else{
				$ansicht == MONATSUEBERSICHT;
				include_once("./monatsuebersicht.php");
			}
		?>
		<!-- ende rechte seite plan -->
		</td>
	</tr>
</table>
<?php 
include_once($root."/webinterface/templates/footer.inc.php");
?>
