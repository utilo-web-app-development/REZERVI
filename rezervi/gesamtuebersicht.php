<? 
/**
 * author: coster
 * date: 30.8.06
 * ansicht zeigt alle zimmer einer unterkunft, jeweils ein monat in einer zeile
 * 
 * */
session_start();
$root = ".";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");	

//variablen initialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
if (isset($_POST["monat"])){
	$monat = $_POST["monat"];
}
else{
	$monat = false;
}
if (isset($_POST["jahr"])){
	$jahr = $_POST["jahr"];
}
else{
	$jahr = false;
}

//datenbank oeffnen:
include_once("./conf/rdbmsConfig.php");

//funktions einbinden:
include_once("./include/unterkunftFunctions.php");
include_once("./include/zimmerFunctions.php");
include_once("./include/datumFunctions.php");
include_once("./include/reservierungFunctions.php");
include_once("./include/gastFunctions.php");
include_once("./include/benutzerFunctions.php");
include_once("./include/uebersetzer.php");
include_once("./include/propertiesFunctions.php");
//hilfsfunktionen einbinden:
include_once("./gesamtuebersichtHelper.php");
include_once($root."/include/zimmerAttributes.inc.php");
include_once($root."/leftHelper.php");

$saAktiviert = getPropertyValue(SHOW_OTHER_COLOR_FOR_SA,$unterkunft_id,$link);	
$zimmer_id = getFirstRoom($unterkunft_id,$link);
	
//falls kein jahr ausgew�hlt wurde, das aktuelle jahr verwenden:
if ($jahr == false){	
	$jahr = getTodayYear();	
	//ich brauche f�r jahr einen integer:
	$jahr+=1;$jahr-=1;
}
//falls kein monat ausgew�hlt wurde, das aktuelle monat verwenden:
if ($monat == false){
	$monat = parseMonthNumber(getTodayMonth());
}
//und f�rs monat einen integer
$monat-=1;$monat+=1;

//seitenheader:	
include_once("./templates/headerA.php");

//stylesheets einf�gen:
?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<script language="JavaScript" type="text/javascript" src="./rightJS.js">
</script>
<?php 
include_once("./templates/headerB.php");
?>
<table width="100%" border="0" class="tableColor">
  <tr>
    <td class="standardSchriftBold">
    	<?= getUebersetzung("Belegungsplan",$sprache,$link) ?> 
    	<?php echo((getUebersetzung(parseMonthName($monat),$sprache,$link))." ".($jahr)); ?>
    </td>
  </tr>
</table>
<br/>
<table width="100%" border="0" class="table">
  <tr>
    <td colspan="2">
    <?php			
		//tabelle mit allen zimmern anzeigen:
		showAllRooms($monat,$jahr,$unterkunft_id,$link,$saAktiviert,$sprache);			
	?>
    </td>
  </tr>
  <tr>
    <td><?php 
		//wenn jahr zu klein, button nicht anzeigen:		
		 $mon = $monat-1;															
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
      <form action="./gesamtuebersicht.php" method="post" name="monatZurueck" target="_self" id="monatZurueck">
        <div align="right">          
          <input name="monat" type="hidden" id="monat" value="<? echo($mon); ?>">
          <input name="jahr" type="hidden" id="jahr" value="<? echo($jah); ?>">
          <input name="zurueck" type="submit" class="btn btn-primary"
       onMouseOut="this.className='button200pxA';" onClick="updateLeft(<?php echo(($mon).",".($jah).",".($zimmer_id)); ?>,0);" id="zurueck" 
	   value="<?php echo(getUebersetzung("einen Monat zur�ck",$sprache,$link)); ?>">
        </div>
      </form>
      <?php }
	   ?>
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
      <form action="./gesamtuebersicht.php" method="post" name="monatWeiter" target="_self" id="monatWeiter">        
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
      <?php } ?>
     </td>
  </tr>  
</table>
</body>
</html>