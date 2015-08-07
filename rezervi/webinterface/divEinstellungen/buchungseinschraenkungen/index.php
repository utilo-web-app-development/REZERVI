<? session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

/*   
	date: 5.11.05
	author: christian osterrieder utilo.eu						
*/

//datenbank öffnen:
include_once($root."/conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once($root."/include/benutzerFunctions.php");
include_once($root."/include/zimmerFunctions.php");
include_once($root."/include/buchungseinschraenkung.php");
include_once($root."/include/unterkunftFunctions.php");
include_once($root."/include/einstellungenFunctions.php");
include_once($root."/include/datumFunctions.php");
include_once($root."/include/uebersetzer.php");	
include_once($root."/webinterface/templates/components.php"); 

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);
$standardsprache = getStandardSprache($unterkunft_id,$link);
			
?>
<?php include_once($root."/webinterface/templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<script language="JavaScript" type="text/javascript" src="./updateDate.js">
</script>
<?php include_once($root."/webinterface/templates/headerB.php"); ?>
<?php include_once($root."/webinterface/templates/bodyA.php"); ?>
<?php 
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("Einschränken von Buchungen innerhalb eines bestimmten Zeitraumes",$sprache,$link)); ?>.</p>
<table  border="0" cellpadding="0" cellspacing="3" class="table">
  <tr>
    <td><?php echo(getUebersetzung("Einschränken von Buchungen innerhalb eines bestimmten Zeitraumes",$sprache,$link)); ?>:</td>
  </tr>
</table>
<br/>
<?php 
if (isset($nachricht) && $nachricht != ""){
?>
	<table  border="0" cellpadding="0" cellspacing="3" class="tableColor">
	  <tr>
		<td <?php if (isset($fehler) && $fehler == false) {echo("class=\"frei\""); } else {echo("class=\"belegt\"");} ?>><?php echo($nachricht) ?></td>
	  </tr>
	</table>
	<br/>
<?php 
}
?>
<table  border="0" cellpadding="0" cellspacing="3" class="table">
  <form action="./aendern.php" method="post" target="_self" name="reservierung">
  <tr>
    <td colspan="2">
 	 <?= 
	  getUebersetzung("Zeitraum (z. B. Saison):",$sprache,$link);
	 ?>
	</td>
  </tr>
  <tr>
    <td colspan="2">
		<table class="tableColor" >
			<tr>
				<td><?= getUebersetzungUnterkunft(getZimmerart_EZ($unterkunft_id,$link),$sprache,$unterkunft_id,$link); ?></td>
				<td><?= getUebersetzung("Tag von",$sprache,$link); ?></td>
				<td><?= getUebersetzung("Tag bis",$sprache,$link); ?></td>
				<td><?= getUebersetzung("Datum von",$sprache,$link); ?></td>
				<td><?= getUebersetzung("Datum bis",$sprache,$link); ?></td>
				<td><?= getUebersetzung("löschen/hinzufügen",$sprache,$link); ?></td>
			</tr>
			<?php			
			
			$res = getBuchungseinschraenkungen($unterkunft_id);
			while ($d=mysql_fetch_array($res)){
				$von = $d["Tag_von"];
				$bis = $d["Tag_bis"];
				$datum_von = $d["Datum_von"];
				$datum_bis = $d["Datum_bis"];
				$id = $d["PK_ID"];
				$zimmer_id = $d["FK_Zimmer_ID"];
				$zimmer = getZimmerNr($unterkunft_id,$zimmer_id,$link);
				$zimmerart = getZimmerArt($unterkunft_id,$zimmer_id,$link);
					 
				?>
				<tr>
					<td><?= $zimmerart . " " . $zimmer ?></td>
					<td><?= $von ?></td>
					<td><?= $bis ?></td>
					<td><?= $datum_von ?></td>
					<td><?= $datum_bis ?></td>
					<td>
						<input name="loeschen#<?= $id ?>" 
							   type="submit" 
							   class="button200pxA" 
							   onMouseOver="this.className='button200pxB';"
       						   onMouseOut="this.className='button200pxA';" 
							   value="<?= getUebersetzung("löschen",$sprache,$link); ?>"/>
					</td>
				</tr>
			<?php
			}
			?>
				<!-- neuen eintrag hinzufuegen: -->
				<tr>
					<td>
						<select name="zimmer_id">
							<?
							$res = getZimmer($unterkunft_id,$link);
							while ($d = mysql_fetch_array($res)){
								$zimmer_id = $d["PK_ID"];
								$zimmer = getZimmerNr($unterkunft_id,$zimmer_id,$link);
								$zimmerart = getZimmerArt($unterkunft_id,$zimmer_id,$link);
							?>
							<option value="<?= $zimmer_id ?>"><?= $zimmerart . " " . $zimmer ?></option>
							<?
							} //ende while
							?>
						</select>
					</td>
					<td><select name="von_wochentag">
							<?
							$res = getWochentage();
							foreach ($res as $wochentag){
							?>
							<option value="<?= $wochentag ?>"><?= $wochentag ?></option>
							<?
							} //ende while
							?>
						</select></td>
					<td><select name="bis_wochentag">
							<?
							$res = getWochentage();
							foreach ($res as $wochentag){
							?>
							<option value="<?= $wochentag ?>"><?= $wochentag ?></option>
							<?
							} //ende while
							?>
						</select></td>
					<td>         
						  <select name="vonTag" class="tableColor" id="select">
				            <?php for ($i=1; $i<=31; $i++) { ?>
				            <option value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) echo(" selected"); ?>><?php echo($i); ?></option>
				            <?php } ?>
				          </select>
				          <!--  heutiges monat selectiert anzeigen: -->
				          <select name="vonMonat" class="tableColor" id="vonMonat" onChange="chkDays(0)">
				            <option value="1"<?php if (getTodayMonth() == "Januar") echo " selected"; ?>><?php echo(getUebersetzung("Januar",$sprache,$link)); ?></option>
				            <option value="2"<?php if (getTodayMonth() == "Februar") echo " selected"; ?>><?php echo(getUebersetzung("Februar",$sprache,$link)); ?></option>
				            <option value="3"<?php if (getTodayMonth() == "März") echo " selected"; ?>><?php echo(getUebersetzung("März",$sprache,$link)); ?></option>
				            <option value="4"<?php if (getTodayMonth() == "April") echo " selected"; ?>><?php echo(getUebersetzung("April",$sprache,$link)); ?></option>
				            <option value="5"<?php if (getTodayMonth() == "Mai") echo " selected"; ?>><?php echo(getUebersetzung("Mai",$sprache,$link)); ?></option>
				            <option value="6"<?php if (getTodayMonth() == "Juni") echo " selected"; ?>><?php echo(getUebersetzung("Juni",$sprache,$link)); ?></option>
				            <option value="7"<?php if (getTodayMonth() == "Juli") echo " selected"; ?>><?php echo(getUebersetzung("Juli",$sprache,$link)); ?></option>
				            <option value="8"<?php if (getTodayMonth() == "August") echo " selected"; ?>><?php echo(getUebersetzung("August",$sprache,$link)); ?></option>
				            <option value="9"<?php if (getTodayMonth() == "September") echo " selected"; ?>><?php echo(getUebersetzung("September",$sprache,$link)); ?></option>
				            <option value="10"<?php if (getTodayMonth() == "Oktober") echo " selected"; ?>><?php echo(getUebersetzung("Oktober",$sprache,$link)); ?></option>
				            <option value="11"<?php if (getTodayMonth() == "November") echo " selected"; ?>><?php echo(getUebersetzung("November",$sprache,$link)); ?></option>
				            <option value="12"<?php if (getTodayMonth() == "Dezember") echo " selected"; ?>><?php echo(getUebersetzung("Dezember",$sprache,$link)); ?></option>
				          </select>
				          <!--  heutiges jahr selectiert anzeigen: -->
				          <select name="vonJahr" class="tableColor" id="vonJahr" onChange="chkDays(0)">
				            <?php				
								for ($l=getTodayYear(); $l < (getTodayYear()+4); $l++){ ?>
				            <option value="<?php echo $l ?>"<?php if ($l == getTodayYear()) echo(" selected"); ?>><?php echo $l ?></option>
				            <?php } ?>
				          </select>
					</td>
					<td>          
					  <select name="bisTag" class="tableColor" id="select4">
			            <!--  heutigen tag selectiert anzeigen: -->
			            <?php	$anzahlTage = getNumberOfDays(parseMonthNumber($monat),$jahr);
			             for ($i=1; $i<=$anzahlTage; $i++) { ?>
			            <option value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) echo " selected"; ?>><?php echo($i); ?></option>
			            <?php } ?>
			          </select>
			          <!--  heutiges monat selectiert anzeigen: -->
			          <select name="bisMonat" class="tableColor" id="bisMonat" onChange="chkDays(1)">
			            <option value="1"<?php if (getTodayMonth() == "Januar") echo " selected"; ?>><?php echo(getUebersetzung("Januar",$sprache,$link)); ?></option>
			            <option value="2"<?php if (getTodayMonth() == "Februar") echo " selected"; ?>><?php echo(getUebersetzung("Februar",$sprache,$link)); ?></option>
			            <option value="3"<?php if (getTodayMonth() == "März") echo " selected"; ?>><?php echo(getUebersetzung("März",$sprache,$link)); ?></option>
			            <option value="4"<?php if (getTodayMonth() == "April") echo " selected"; ?>><?php echo(getUebersetzung("April",$sprache,$link)); ?></option>
			            <option value="5"<?php if (getTodayMonth() == "Mai") echo " selected"; ?>><?php echo(getUebersetzung("Mai",$sprache,$link)); ?></option>
			            <option value="6"<?php if (getTodayMonth() == "Juni") echo " selected"; ?>><?php echo(getUebersetzung("Juni",$sprache,$link)); ?></option>
			            <option value="7"<?php if (getTodayMonth() == "Juli") echo " selected"; ?>><?php echo(getUebersetzung("Juli",$sprache,$link)); ?></option>
			            <option value="8"<?php if (getTodayMonth() == "August") echo " selected"; ?>><?php echo(getUebersetzung("August",$sprache,$link)); ?></option>
			            <option value="9"<?php if (getTodayMonth() == "September") echo " selected"; ?>><?php echo(getUebersetzung("September",$sprache,$link)); ?></option>
			            <option value="10"<?php if (getTodayMonth() == "Oktober") echo " selected"; ?>><?php echo(getUebersetzung("Oktober",$sprache,$link)); ?></option>
			            <option value="11"<?php if (getTodayMonth() == "November") echo " selected"; ?>><?php echo(getUebersetzung("November",$sprache,$link)); ?></option>
			            <option value="12"<?php if (getTodayMonth() == "Dezember") echo " selected"; ?>><?php echo(getUebersetzung("Dezember",$sprache,$link)); ?></option>
			          </select>
			          <!--  heutiges jahr selectiert anzeigen: -->
			          <select name="bisJahr" class="tableColor" id="bisJahr" onChange="chkDays(1)">
			            <?php				
							for ($l=getTodayYear()-4; $l < (getTodayYear()+4); $l++){ ?>
			            <option value="<?php echo($l); ?>"<?php if ($l == getTodayYear()) echo(" selected"); ?>><?php echo($l); ?></option>
			            <?php } ?>
			          </select>
					</td>
					<td>
						<input name="add" 
							   type="submit" 
							   class="button200pxA" 
							   onMouseOver="this.className='button200pxB';"
       						   onMouseOut="this.className='button200pxA';" 
							   value="<?= getUebersetzung("hinzufügen",$sprache,$link); ?>"/>
					</td>
				</tr>
				<!-- ende neuen eintrag hinzufuegen -->
		</table>
	</td>
  </tr>  
  </form>
</table>
<br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zurück",$sprache,$link));
?>
<br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../../inhalt.php",getUebersetzung("Hauptmenü",$sprache,$link));
?>
<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>
 <?php include_once("../../templates/end.php"); ?>