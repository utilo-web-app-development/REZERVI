<div class="panel panel-default">
  <div class="panel-body">
  	<?php session_start();
$root = ".";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");	
/*   
	reservierungsplan
	anzeige des kalenders
	author: christian osterrieder utilo.eu		
	
	dieser seite muss übergeben werden:
	Unterkunft PK_ID ($unterkunft_id)

*/

//variablen initialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
if (isset($_POST["zimmer_id"])){
	$zimmer_id = $_POST["zimmer_id"];
}
else{
	$zimmer_id = false;
}
if (isset($_POST["jahr"])){
	$jahr = $_POST["jahr"];
}
else{
	$jahr = false;
}
setSessionWert(ZIMMER_ID,$zimmer_id);

//datenbank öffnen:
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
	$saAktiviert = getPropertyValue(SHOW_OTHER_COLOR_FOR_SA,$unterkunft_id,$link);
	
	$showPic = getPropertyValue(ZIMMER_THUMBS_AV_OV,$unterkunft_id,$link);
	if ($showPic != "true"){
		$showPic = false;
	}
	else{
		$showPic = true;
	}		

//hilfsfunktionen einbinden:
include_once("./jahresuebersichtHelper.php");
	
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
	if ($jahr == false){	
		$jahr = getTodayYear();	
		//ich brauche für jahr einen integer:
		$jahr+=1;$jahr-=1;
	}
	
include_once("./templates/headerA.php");
//stylesheets einfügen:
?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<script language="JavaScript" type="text/javascript" src="./rightJS.js">
</script>
<?php include_once("./templates/headerB.php");
?>


   <?php echo(getUebersetzung("Belegungsplan",$sprache,$link)); ?> <?php echo($jahr) ?>,
      <?php	$art = getUebersetzungUnterkunft(getZimmerArt($unterkunft_id,$zimmer_id,$link),$sprache,$unterkunft_id,$link);
			$nummer = getUebersetzungUnterkunft(getZimmerNr($unterkunft_id,$zimmer_id,$link),$sprache,$unterkunft_id,$link);
			//wenn zimmernummer und zimmerart gleich sind nur eines ausgeben!
			if ($art != $nummer){
				echo($art);	
			}								   									
            echo(" ").($nummer); ?>
 
		
		
				<?php
			//show pic of the room if activated and pic available:
			if ($showPic){	
				include_once($root."/include/bildFunctions.php");
				  if (hasZimmerBilder($zimmer_id,$link)){	  
					$result = getBilderOfZimmer($zimmer_id,$link);
					while ($z = mysqli_fetch_array($result)){
					?><?php
						$pfad = $z["Pfad"];
						$pfad = substr($pfad,6,strlen($pfad));
						$width = $z["Width"];
						$height= $z["Height"];
						$description = $z["Beschreibung"];
						$description = getUebersetzungUnterkunft($description,$sprache,$unterkunft_id,$link);
					  ?>
					  <img src="<?php echo($pfad); ?>"/>&nbsp;
					  
					 
					  	<?php echo $description ?>
					  <
					  <?php
					}
				  }			
			}
			?>
			
		
	

<br/>
<table width="100%" border="0" class="table">
  <tr>
    <td colspan="2"><?php			
			//monat ausgeben:
			showYear(1,$jahr,$unterkunft_id,$zimmer_id,$link,$saAktiviert,$sprache);			
		?>
    </td>
  </tr>
  <tr valign="middle">
    <td width="50%"><?php		
		$jah = $jahr-1;
		if (!($jah < getTodayYear())){																					 																			
		?>
      <form action="./jahresuebersicht.php" method="post" name="monatZurueck" target="_self" id="monatZurueck">
        <div align="right">
          <input name="monat" type="hidden" id="monat" value="1">
          <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo($zimmer_id); ?>">
          <input name="jahr" type="hidden" id="jahr" value="<?php echo($jah); ?>">
          <input name="zurueck" type="submit" class="btn btn-primary" onClick="updateLeft(<?php echo(($monat).",".($jah)).",".($zimmer_id); ?>,0);" id="zurueck" value="<?php 
							echo(getUebersetzung("ein Jahr zurück",$sprache,$link)); ?>">
        </div>
      </form>
      <?php } //ende if jahr 
	  ?></td>
    <td width="50%"><?php		
		$jah = $jahr+1;
		if (!($jah >= getTodayYear()+4)){																															
		?>
      <form action="./jahresuebersicht.php" method="post" name="monatWeiter" target="_self" id="monatWeiter">
        <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo($zimmer_id); ?>">
        <input name="jahr" type="hidden" id="jahr" value="<?php echo ($jah); ?>">
        <input name="monat" type="hidden" id="monat" value="1">
        <input name="weiter" type="submit" class="btn btn-primary"
        onClick="updateLeft(<?php echo(($monat).",".($jah)).",".($zimmer_id); ?>,1);" id="weiter" value="<?php 
							echo(getUebersetzung("ein Jahr weiter",$sprache,$link)); ?>">
      </form>
      <?php } //ende if jahr 
	  ?></td>
  </tr>
</table>
</body>
</html>