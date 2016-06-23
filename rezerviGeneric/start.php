<?php  
/**
	date: 3.4.06
	author: christian osterrieder utilo.net						
*/
	 if (!isset($nachricht)){
		 session_start();
		 $root = ".";
		 
		 // Send modified header for session-problem of ie:
		 // @see http://de.php.net/session
		 header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
	 }
 
	 //datenbank öffnen:
 include_once($root."/conf/rdbmsConfig.inc.php");
 //conf file öffnen:
 include_once($root."/conf/conf.inc.php");
 //uebersetzer öffnen:
 include_once($root."/include/uebersetzer.inc.php");
 include_once($root."/include/sessionFunctions.inc.php");
 include_once($root."/include/cssFunctions.inc.php"); 
 include_once($root."/include/vermieterFunctions.inc.php"); 
 include_once($root."/include/mietobjektFunctions.inc.php");
 include_once($root."/include/datumFunctions.inc.php");
 include_once($root."/include/reservierungFunctions.inc.php");
 include_once($root."/templates/constants.inc.php");
	
//als erstes pruefen ob per get oder post diverse variablen uebergeben wurden
//vermieter?
if (isset($_GET["vermieter_id"])){
	$vermieter_id = $_GET["vermieter_id"];
}
else if (isset($_POST["vermieter_id"])){
	$vermieter_id = $_POST["vermieter_id"];	
}
else{
	$vermieter_id = 1;
}
//sprache?
$temp = getSessionWert(SPRACHE);
if (isset($_GET["sprache"])){
	$sprache = $_GET["sprache"];	
}
else if (isset($_POST["sprache"])){
	$sprache = $_POST["sprache"];	
}
else if (!empty($temp)){
	$sprache = getSessionWert(SPRACHE);
}
else{
	$sprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
}
$temp = getSessionWert(SPRACHE);
if (empty($temp) && !empty($sprache)){
	setSessionWert(SPRACHE,$sprache);
}	
//mietobjekt?
if (isset($_GET["mietobjekt_id"])){
	$mietobjekt_id = $_GET["mietobjekt_id"];
}
else if (isset($_POST["mietobjekt_id"])){
	$mietobjekt_id = $_POST["mietobjekt_id"];	
}
else{
	$mietobjekt_id = getFirstMietobjektId($vermieter_id);	
}
//alte session werte löschen:
destroyInactiveSessions();
//werte in session speichern:
setSessionWert(VERMIETER_ID,$vermieter_id);
setSessionWert(SPRACHE,$sprache);

//header einfuegen:
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Rezervi Generic Booking System - Rezervi Generic Buchungssystem - utilo.net</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
  <?php include_once($root."/templates/stylesheets.php"); ?>
</style>
<script type="text/javascript" src="<?= $root ?>/templates/calendarDateInput.inc.php?root=<?= $root ?>">
	/***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/	
</script>  
</head>
<?php
include_once($root."/templates/bodyStart.inc.php"); 
	
	//falls kein jahr ausgewählt wurde, das aktuelle jahr verwenden:
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
<table cellpadding="3">
  <tr>
	<td valign="top">
	<!-- linke seite - navigation: -->		
	<form action="./start.php" method="post" name="reservierung">
		<table border="0" class="<?= TABLE_STANDARD ?>">		
		  <tr>
		    <td>		      
		        <table border="0" cellspacing="3" cellpadding="0">
		        	<tr>
			        	<td colspan="2">
			        		<span class="<?= STANDARD_SCHRIFT_BOLD ?>">
			        			<?= getUebersetzung("Ansicht für Datum") ?>:
			          		</span>
			          	</td>
			        </tr>
			        <tr>
			        	<td colspan="2">
							<script>DateInput('datumAnsicht', true, 'DD/MM/YYYY','<?= $startdatumDP  ?>')</script>
			          	</td>
			        </tr>
		          <tr>
		            <td colspan="2">
		            	<span class="<?= STANDARD_SCHRIFT_BOLD ?>">
		            		<?= getUebersetzungVermieter(getVermieterMietobjektEz($vermieter_id),$sprache,$vermieter_id) ?>:
		            	</span>
		            </td>
		          </tr>
		          <tr>  
		            <td colspan="2">
		                <select name="mietobjekt_id"  id="mietobjekt_id" onChange="submit()">
		                  <?
		  					$res = getMietobjekteOfVermieter($vermieter_id);
		  					$anzahlMietobjekte = mysql_num_rows($res);
		  					$hasMietobjekte = true;
		  					if ($anzahlMietobjekte<=0){
		  						$hasMietobjekte = false;
		  					}
			 				while($d = mysql_fetch_array($res)) { ?>
		                  		<option value="<? echo $d["MIETOBJEKT_ID"] ?>"<? if ($mietobjekt_id == $d["MIETOBJEKT_ID"]) {echo(" selected=\"selected\"");} ?>><? echo $d["BEZEICHNUNG"] ?></option>
		                  <? } ?>
		                </select>
		            </td>
		          </tr>
		        </table>
		      </td>
		  </tr>
		  <tr>
		    <td><span class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Ansicht wählen")); ?>:</span></td>
		  </tr>
		  <tr>
		    <td>
		        <div align="left">
		          <select name="ansicht" onChange="submit()">
		          <?php 
		          	$jaAnz = getVermieterEigenschaftenWert(JAHRESUEBERSICHT_ANZEIGEN,$vermieter_id);
		          	$moAnz = getVermieterEigenschaftenWert(MONATSUEBERSICHT_ANZEIGEN,$vermieter_id);
		          	$woAnz = getVermieterEigenschaftenWert(WOCHENANSICHT_ANZEIGEN,$vermieter_id);
		          	$taAnz = getVermieterEigenschaftenWert(TAGESANSICHT_ANZEIGEN,$vermieter_id);
		          	
		          	foreach ($ansicht_array as $ans){ 
			          	$anzeigen = false;	
			            if ($ans == JAHRESUEBERSICHT && $jaAnz == "true"){
			          		$anzeigen = true;	
			            }
			            if ($ans == MONATSUEBERSICHT && $moAnz == "true"){
			            	$anzeigen = true;
			            }
			            if ($ans == WOCHENANSICHT && $woAnz == "true"){
			            	$anzeigen = true;
			            }
			            if ($ans == TAGESANSICHT && $taAnz == "true"){
			            	$anzeigen = true;
			            }
			            if ($anzeigen === true){
			          ?>
			            <option value="<?= $ans ?>" <?php if ($ansicht == $ans) {?> selected="selected" <?php } ?>><?php echo(getUebersetzung($ans)); ?></option>
			 		  <?php 
			            }//ende if anzeigen
		 		  } //ende foreach 
		 		  ?>
		 		  </select>
		        </div>
			</td>
		  </tr>
		  <tr>
		  	<td colspan ="2">
		  		<input name="ansichtWechseln" type="submit" 
		  			class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
		      		onMouseOut="this.className='<?= BUTTON ?>';" 
		      		id="ansichtWechseln" 
		      		value="<?php echo(getUebersetzung("anzeigen")); ?>">
		    </td>
		  </tr>		  
		  </table>
	  </form>

	  <!-- begin Suche --> 
	  <?php 
	  $sucheAktiv = getVermieterEigenschaftenWert(SUCHFUNKTION_AKTIV,$vermieter_id);
		if ($sucheAktiv == "true"){
			$sucheAktiv = true;
		}
		else{
			$sucheAktiv = false;
		}
	  if ($sucheAktiv){
	  ?>
	  <form action="./belegungsplan/suche/index.php" method="post" name="suche">
		  <table border="0" class="<?= TABLE_STANDARD ?>">
		    <tr>
			    <td>		      
			        <input name="keineSprache" type="hidden" value="true">
			        <div align="center">
			          <input name="suche" type="submit" id="suche" value="<?= getUebersetzung("Suchformular öffnen") ?>" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
					   onMouseOut="this.className='<?= BUTTON ?>';">  
			        </div>		     
			     </td>
			  </tr>
			</table>
		</form>
		<?php
	  }
		?>
	  <!-- ende Suche -->

	  <!-- anzeige belegt, frei -->
	  <form>
		  <table border="0" class="<?= TABLE_STANDARD ?>">
		    <tr>
			    <td><table width="100%" border="0" class="<?= TABLE_COLOR ?>">
			        <tr>
			          <td width="23" height="23" class="<?= BELEGT ?>">&nbsp;</td>
			          <td><?php echo(getUebersetzung("belegt")); ?></td>
			        </tr>
			        <tr>
			          <td width="23" height="23" class="<?= FREI ?>">&nbsp;</td>
			          <td><?php echo(getUebersetzung("frei")); ?></td>
			        </tr>
			      </table></td>
			  </tr>
		  </table>
	  </form>
	  
	  <!-- ende anzeige belegt, frei -->
	  <form action="<?= $root ?>/belegungsplan/anfrage/index.php" method="post" name="resAendern">
		  <input type="hidden" name="ansicht" value="<?= $ansicht ?>"/>
		  <input type="hidden" name="mietobjekt_id" value="<?= $mietobjekt_id ?>"/>
			<?php include_once($root."/templates/datumVonDatumBis.inc.php"); ?>
			        <p>
			          <input name="reservierungAendern" type="submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
			      		 onMouseOut="this.className='<?= BUTTON ?>';" id="reservierungAbsenden2" value="<?php echo(getUebersetzung("Reservierung starten")); ?>">
			        </p>			        
			     </td>
			  </tr>
			</table>
		  </form>
		  <!-- begin Anfrage per Mail --> 
		  <form action="<?= $root ?>/belegungsplan/anfrage/anfragePerEMail.php" method="post" name="suche">
			  <table border="0" class="<?= TABLE_STANDARD ?>">
			    <tr>
				    <td>		      
				        <div align="center">
				          <input name="suche" type="submit" id="suche" 
				          	value="<?php echo(getUebersetzung("Anfrage per E-Mail")); ?>" 
				          	class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
						    onMouseOut="this.className='<?= BUTTON ?>';">
				          <input name="jahr" type="hidden" id="jahr" value="<?= $jahr ?>"/>
				          <input name="monat" type="hidden" id="monat" value="<?= $monat ?>"/>	
				          <input name="tag" type="hidden" id="monat" value="<?= $tag ?>"/>
				          <input name="ansicht" type="hidden" id="ansicht" value="<?= $ansicht ?>"/>
				          <input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?= $mietobjekt_id ?>"/>	  
				        </div>		     
				     </td>
				  </tr>
				</table>
			</form>
		  <!-- ende Anfrage per Mail -->		
		<!-- ende linke seite - menue -->
		</td>
		<td valign="top">
		<!-- rechte seite - plan -->
		<?php
			if ($hasMietobjekte && $ansicht == JAHRESUEBERSICHT){
				include_once($root."/belegungsplan/jahresuebersicht.inc.php");
			}
			else if ($hasMietobjekte && $ansicht == TAGESANSICHT){
				include_once($root."/belegungsplan/tagesuebersicht.inc.php");			
			}
			else if ($hasMietobjekte && $ansicht == WOCHENANSICHT){
				include_once($root."/belegungsplan/wochenuebersicht.inc.php");
			}
			else if ($hasMietobjekte && $ansicht == MONATSUEBERSICHT){				
				include_once($root."/belegungsplan/monatsuebersicht.inc.php");
			}
			else if(!$hasMietobjekte){
				?>
				<table width="100%" border="0" class="<?= TABLE_STANDARD ?>">
				  <tr> 
				    <td>
				    	<? $temp = "Es wurden noch keine Mietobjekte angelegt. " .
				    			"Bitte öffnen sie das Webinterface \"/webinterface/index.php\" und " .
				    			"geben sie ihre Mietobjekte ein."; 
				    	   echo(getUebersetzung($temp));
				    	   ?>
				    	   <br/><br/>
				    	   <form action="<?= $root ?>/webinterface/index.php" method="post" name="wi">
					    	   <input name="webinterface" type="submit" id="webinterface" 
					          		value="<?php echo(getUebersetzung("Webinterface öffnen")); ?>" 
					          		class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
								    onMouseOut="this.className='<?= BUTTON ?>';">
						   </form>
					</td>
				  </tr>
				</table> 
				<?	
			}
		?>
		<!-- ende rechte seite plan -->
		</td>
	</tr>
</table>
<?php
include_once($root."/templates/footer.inc.php");
?>
