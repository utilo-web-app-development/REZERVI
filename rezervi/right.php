<?php session_start();		
$root = ".";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/* 
	reservierungsplan
	anzeige des kalenders
	author: christian osterrieder utilo.eu
	
	dieser seite kann optional �bergeben werden:
	Zimmer PK_ID ($zimmer_id)
	Jahr ($jahr)
	Monat ($monat)
	
	dieser seite muss �bergeben werden:
	Unterkunft PK_ID ($unterkunft_id)
*/

	//datenbank �ffnen:
	include_once("./conf/rdbmsConfig.php");
	
	//funktions einbinden:
	include_once("./include/unterkunftFunctions.php");
	include_once("./include/zimmerFunctions.php");
	include_once("./include/datumFunctions.php");
	include_once("./include/reservierungFunctions.php");
	include_once("./include/uebersetzer.php");
	
	
	include_once("./rightHelper.php");	
	include_once("./leftHelper.php");
	
	include_once("./include/propertiesFunctions.php");
		
	//variablen initialisieren:
	//unset($zimmer_id);
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	$sprache = getSessionWert(SPRACHE);
	if (isset($_GET["vonStart"]) && $_GET["vonStart"] == "true"){
		$zimmer_id = getSessionWert(ZIMMER_ID);
	}
	else{
		$zimmer_id = $_POST["zimmer_id"];
	}
	//falls keine zimmer_id ausgew�hlt wurde, das erste gefundene zimmer nehmen:
	if (!isset($zimmer_id) || $zimmer_id == "" || empty($zimmer_id)) {
		$zimmer_id = getFirstRoom($unterkunft_id,$link);		
	}
	if (isset($_POST["monat"])){
		$monat = $_POST["monat"];
	}
	if (isset( $_POST["jahr"])){
		$jahr = $_POST["jahr"];
	}	
	setSessionWert(ZIMMER_ID,$zimmer_id);
 	
	$saAktiviert = getPropertyValue(SHOW_OTHER_COLOR_FOR_SA,$unterkunft_id,$link);
	
	$showPic = getPropertyValue(ZIMMER_THUMBS_AV_OV,$unterkunft_id,$link);
	if ($showPic != "true"){
		$showPic = false;
	}
	else{
		$showPic = true;
	}	
	
	//falls kein jahr ausgew�hlt wurde, das aktuelle jahr verwenden:
	if (!isset($jahr) || $jahr == "" || empty($jahr)){
		$jahr = getTodayYear();
	}
	//ich brauche f�r jahr einen integer:
	$jahr+=1;$jahr-=1;
	
	//falls kein monat ausgew�hlt wurde, das aktuelle monat verwenden:
	if (!isset($monat) || $monat == "" || empty($monat)){
		$monat = parseMonthNumber(getTodayMonth());
	}
	//und f�rs monat einen integer
	$monat-=1;$monat+=1;
		
?>
<?php include_once("./templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<script language="JavaScript" type="text/javascript" src="./rightJS.js">
</script>
<?php include_once("./templates/headerB.php"); ?>
<?php //kontrolle ob das monat noch g�ltig ist:
	if ($monat < parseMonthNumber(getTodayMonth()) && $jahr <= getTodayYear()){ ?>
		<table width="100%" border="0" class="tableColor">
		  <tr>
			<td class="standardSchriftBold"><?php echo(getUebersetzung("<p>Das gewählte Monat ist bereits abgelaufen!</p><p>Bitte korrigieren Sie Ihre Anfrage!</p>",$sprache,$link)); ?></td>
		  </tr>
		</table>
<?php } //ende if monat zu klein
	else { ?>
<table width="100%" border="0" class="tableColor">
  <tr>
    <td class="standardSchriftBold"><?php echo(getUebersetzung("Belegungsplan",$sprache,$link)); ?> <?php echo($jahr) ?>,
      <?php	$art = getUebersetzungUnterkunft(getZimmerArt($unterkunft_id,$zimmer_id,$link),$sprache,$unterkunft_id,$link);
			$nummer = getUebersetzungUnterkunft(getZimmerNr($unterkunft_id,$zimmer_id,$link),$sprache,$unterkunft_id,$link);
			//wenn zimmernummer und zimmerart gleich sind nur eines ausgeben!
			if ($art != $nummer){
				echo($art);	
			}								   									
            echo(" ").($nummer); ?></td>
  </tr>
  <tr>
    <td class="standardSchriftBold">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<?php
			//show pic of the room if activated and pic available:
			if ($showPic){	
				include_once($root."/include/bildFunctions.php");
				  if (hasZimmerBilder($zimmer_id,$link)){	  
					$result = getBilderOfZimmer($zimmer_id,$link);
					while ($z = mysql_fetch_array($result)){
					?><td><?php
						$pfad = $z["Pfad"];
						$pfad = substr($pfad,6,strlen($pfad));
						$width = $z["Width"];
						$height= $z["Height"];
						$description = $z["Beschreibung"];
						$description = getUebersetzungUnterkunft($description,$sprache,$unterkunft_id,$link);
					  ?>
					  <img src="<?php echo($pfad); ?>"/>&nbsp;
					  </td>
					  <td>
					  	<?= $description ?>
					  </td>
					  <?php
					}
				  }			
			}
			?>
			</tr>
		</table>
	</td>
  </tr>    
</table>
<br/>
<table width="100%" border="0" class="table">
  <tr>
    <td><?php
			//kontrolle ob monat nicht 0 oder 13:
			if ($monat > 12){
				$monat = 1;
				$jahr+=1;
			} 
			elseif ($monat < 1){
				$monat = 12;
				$jahr-=1;
			}
			//monat ausgeben:
			showMonth($monat,$jahr,$unterkunft_id,$zimmer_id,$link,$saAktiviert,$sprache);
			//monat erh�hen f�r n�chste ausgabe:
			$monat+=1;
		?></td>
    <td><?php
			//kontrolle ob monat nicht 0 oder 13:
			if ($monat > 12){
				$monat = 1;
				$jahr+=1;
			} 
			elseif ($monat < 1){
				$monat = 12;
				$jahr-=1;
			}
			//monat ausgeben:
			showMonth($monat,$jahr,$unterkunft_id,$zimmer_id,$link,$saAktiviert,$sprache);
			//monat erh�hen f�r n�chste ausgabe:
			$monat+=1;
		?></td>
  </tr>
  <tr>
    <td><?php
			//kontrolle ob monat nicht 0 oder 13:
			if ($monat > 12){
				$monat = 1;
				$jahr+=1;
			} 
			elseif ($monat < 1){
				$monat = 12;
				$jahr-=1;
			}
			//monat ausgeben:
			showMonth($monat,$jahr,$unterkunft_id,$zimmer_id,$link,$saAktiviert,$sprache);
			//monat erh�hen f�r n�chste ausgabe:
			$monat+=1;
		?></td>
    <td><?php
			//kontrolle ob monat nicht 0 oder 13:
			if ($monat > 12){
				$monat = 1;
				$jahr+=1;
			} 
			elseif ($monat < 1){
				$monat = 12;
				$jahr-=1;
			}
			//monat ausgeben:
			showMonth($monat,$jahr,$unterkunft_id,$zimmer_id,$link,$saAktiviert,$sprache);			
		?></td>
  </tr>
  <tr valign="middle">
    <td><?php 
		//wenn jahr zu klein, button nicht anzeigen:		
		$mon = $monat-7;
//		echo($mon);																
		 $jah = $jahr;
		 switch ($mon){
			case 0:
				$mon = 12;
				$jah = $jah-1;
				break;
			case -1:
				$mon = 11;
				$jah = $jah-1;
				break;
			case -2:
				$mon = 10;
				$jah = $jah-1;
				break;
			case -3:
				$mon = 9;
				$jah = $jah-1;
				break;
			case -4:
				$mon = 8;
				$jah = $jah-1;
				break;
			case -5:
				$mon = 7;
				$jah = $jah-1;
				break;
			case -6:
				$mon = 6;
				$jah = $jah-1;
				break;	
		 }
		 if ($jah < 	getTodayYear() || ($jah <= getTodayYear()  && $mon+1 <= parseMonthNumber(getTodayMonth()))){
				$jah = getTodayYear();
		 }																	 																
		 else {														 																			
		?>
      <form action="./right.php" method="post" name="monatZurueck" target="_self" id="monatZurueck">
        <div align="right">          
          <input name="zimmer_id" type="hidden" id="zimmer_id" value="<? echo $zimmer_id ?>">
          <input name="monat" type="hidden" id="monat" value="<? echo($mon); ?>">
          <input name="jahr" type="hidden" id="jahr" value="<? echo($jah); ?>">
          <input name="zurueck" type="submit" class="btn btn-primary" ;" onClick="updateLeft(<?php echo(($mon).",".($jah).",".($zimmer_id)); ?>,0);" id="zurueck" 
	   value="<?php echo(getUebersetzung("einen Monat zurück",$sprache,$link)); ?>">
        </div>
      </form>
      <?php }
	   ?></td>
    <td><?php
		//wenn jahr zu gross wird, button nicht mehr anzeigen:
		$mo = $monat+1;
		$ja = $jahr;
		//bis 4 jahre in die future anzeigen:
		if ($ja > (getTodayYear()+4)){
		 	$ja = (getTodayYear()+4);
			$mo = 8;
		}		
		else { 																													
		?>
      <form action="./right.php" method="post" name="monatWeiter" target="_self" id="monatWeiter">        
        <input name="zimmer_id" type="hidden" id="zimmer_id" value="<? echo $zimmer_id ?>">
        <input name="monat" type="hidden" id="monat" value="<? 
		  														if ($mo > 12){
																	$mo = 1;
																	$ja +=1;
																} 
																echo($mo); 
																?>">
        <input name="jahr" type="hidden" id="jahr" value="<? echo ($ja); ?>">
        <input name="weiter" type="submit" class="btn btn-primary" onClick="updateLeft(<?php echo(($mo).",".($ja)).",".($zimmer_id); ?>,1);" id="weiter" 
	   value="<?php echo(getUebersetzung("einen Monat weiter",$sprache,$link)); ?>">
      </form>
      <?php } ?></td>
  </tr>
</table>
<?php } //ende else monat zu klein ?>
</body>
</html>
