<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
	reservierungsplan
	steuerung des kalenders und reservierung f�r den gast
	author: christian osterrieder utilo.eu
	
	dieser seite kann optional �bergeben werden:
	Zimmer PK_ID ($zimmer_id)
	Jahr ($jahr)
	Monat ($monat)
	
	dieser seite muss �bergeben werden:
	Unterkunft PK_ID ($unterkunft_id)
*/

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

//datenbank �ffnen:
include_once("../../conf/rdbmsConfig.php");
//datums-funktionen einbinden:
include_once("../../include/datumFunctions.php");
include_once("../../include/benutzerFunctions.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/propertiesFunctions.php");
include_once("../../include/reseller/reseller.php");
	
	//falls keine zimmer_id ausgew�hlt wurde, das erste gefundene zimmer nehmen:
	if (!isset($zimmer_id) || $zimmer_id == "" || empty($zimmer_id)) {
		$query = "
			select 
			PK_ID 
			from
			Rezervi_Zimmer
			where
			FK_Unterkunft_ID = '$unterkunft_id' 
			ORDER BY 
			Zimmernr";

  		$res = mysql_query($query, $link);
  		if (!$res){
  			echo("Anfrage $query scheitert.");
  		}
  		
		$d = mysql_fetch_array($res);
		$zimmer_id = $d["PK_ID"];
	}
	
	//falls kein jahr ausgew�hlt wurde, das aktuelle jahr verwenden:
	if (!isset($jahr) || $jahr == "" || empty($jahr)){
		$jahr = getTodayYear();
	}
	
	//falls kein monat ausgew�hlt wurde, das aktuelle monat verwenden:
	if (!isset($monat) || $monat == "" || empty($monat)){
		$monat = getTodayMonth();
	}	
	//should the reservation state be shown?
	$showReservation = getPropertyValue(SHOW_RESERVATION_STATE,$unterkunft_id,$link);
	if ($showReservation != "true"){
		$showReservation = false;
	}			
?>
<div class="panel panel-default">
  <div class="panel-body">
  	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Rezervi</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<!-- dynamisches update der anzahl der tage f�r ein gewisses monat mit java-script: -->
<script language="JavaScript" type="text/javascript" src="../../templates/changeForms.js">
</script>
<script language="JavaScript" type="text/javascript" src="./leftJS.js">
</script>
</head>


  	
  	
<!-- <body class="backgroundColor"> -->
<?php		
	//passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ ?>
		
<div class="panel panel-default">
  <div class="panel-body">
  
    <h3><?php echo(getUebersetzung("Belegungsplan",$sprache,$link)); ?></h3>
    
      	
      <!-- <form action="./ansichtWaehlen.php" method="post" id="ZimmerNrForm" name="ZimmerNrForm" target="kalender"> -->
      	
       
          <form action="./ansichtWaehlen.php" method="post" name="ZimmerNrForm" target="kalender" class="form-horizontal">
            <h4><?php echo(getUebersetzung("Ansicht für",$sprache,$link)); ?>:</h4>
            
            
			<div class="form-group">
				<label for="anrede" class="col-sm-2 control-label"><?php echo(getUebersetzung("Jahr",$sprache,$link)); ?></label>
				<div class="col-sm-10">
					<select name="jahr" class="form-control" id="jahr" value="" onChange="zimmerNrFormJahrChanged()">
                  <?php				
				for ($l=getTodayYear()-4; $l < (getTodayYear()+4); $l++){ ?>
                  <option  value="<?php echo($l); ?>"<?php if ($l == $jahr) echo(" selected"); ?>><?php echo($l); ?></option>
                  <?php } ?>
                </select>
				</div>
			</div>			
			
			
			
            <!-- <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Jahr",$sprache,$link)); ?></span> </td>
            <td><div align="right">
                <select name="jahr" class="table" id="jahr" onChange="zimmerNrFormJahrChanged()">
                  <?php				
				for ($l=getTodayYear()-4; $l < (getTodayYear()+4); $l++){ ?>
                  <option  value="<?php echo($l); ?>"<?php if ($l == $jahr) echo(" selected"); ?>><?php echo($l); ?></option>
                  <?php } ?>
                </select>
              </div></td>
          </tr> -->
          <tr>
            <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Monat",$sprache,$link)); ?></span></td>
            <td><div align="right">
              <select name="monat" class="tableColor" id="monat" onChange="zimmerNrFormJahrChanged()">
                  <?php
				for ($i=1; $i<=12; $i++) { ?>
                  <option value="<? echo $i ?>"<? if ($i == parseMonthNumber(getTodayMonth())) echo(" selected"); ?>><? echo(getUebersetzung(parseMonthName($i,"de"),$sprache,$link)); ?></option>
                  <? } ?>
                </select>
            </div></td>
          </tr>
          <tr>
            <td><span class="standardSchriftBold">
            		<?= getZimmerArten($unterkunft_id,$link) ?>            
            	</span>
            </td>
            <td><div align="right">
                <select name="zimmer_id" class="tableColor" id="zimmer_id" onChange="zimmerNrFormJahrChanged()">
                  <?
					$query = "
						select
						Zimmernr, PK_ID
						from
						Rezervi_Zimmer 
						where 
						FK_Unterkunft_ID = '$unterkunft_id'" .
								" order by Zimmernr
						";

  					$res = mysql_query($query, $link);
  					if (!$res)
  						echo("Anfrage $query scheitert.");	
	 				while($d = mysql_fetch_array($res)) { ?>
                  <option value="<? echo $d["PK_ID"] ?>"<? if ($zimmer_id == $d["PK_ID"]) {echo(" selected");} ?>><? echo (getUebersetzungUnterkunft($d["Zimmernr"],$sprache,$unterkunft_id,$link)); ?></option>
                  <? } ?>
                </select>
              </div></td>
          </tr>
        </table>
      </form></td>
  </tr>  <tr>
    <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Ansicht wählen",$sprache,$link)); ?>:</span></td>
  </tr>
  <tr>
    <td>
		<form action="./ansichtWaehlen.php" method="post" name="ansichtWaehlen" target="kalender">
        <div align="left">
          <select name="ansichtWechsel" onChange="submit()" class="btn btn-primary">
            <option value="0"><?php echo(getUebersetzung("Monatsübersicht",$sprache,$link)); ?></option>
            <option value="1"><?php echo(getUebersetzung("Jahresübersicht",$sprache,$link)); ?></option>
          </select>
          <input name="zimmer_id" type="hidden" id="zimmer_id" value="<? echo($zimmer_id); ?>">
          <input name="jahr" type="hidden" id="jahr" value="<? echo($jahr); ?>">
          <input name="monat" type="hidden" id="monat" value="<? echo(parseMonthNumber($monat)); ?>">
        </div>
      </form>
</td>
  </tr>
  <tr>
    <td><form action="./resAendern/resAendern.php" method="post" name="reservierung" target="kalender" id="reservierung">
        <p class="ueberschrift"><span class="standardSchriftBold"><?php echo(getUebersetzung("Reservierung ändern",$sprache,$link)); ?>:</span>
        </p>
        <table width="200">
          <tr>
            <td width="1" class="belegt"><label>
              <?php 
			//status = 0: frei
			//status = 1: reserviert
			//status = 2: belegt
			?>
              <input name="status" type="radio" value="2" checked/>
              </label></td>
            <td class="standardSchrift"><?php echo(getUebersetzung("belegt",$sprache,$link)); ?></td>
          </tr>
		  <?php
		  if ($showReservation){
		  ?>
          <tr>
            <td width="1" class="reserviert">
            	<label>
              		<input name="status" type="radio" value="1"/>
              	</label>
            </td>
            <td class="standardSchrift">
            	<?php echo(getUebersetzung("reserviert",$sprache,$link)); ?>
            </td>
          </tr> 
          <?php
		  }
		  ?>         
          <tr>
            <td width="1" class="frei"><label>
              <input name="status" type="radio" value="0"/>
              </label></td>
            <td class="standardSchrift"><?php echo(getUebersetzung("frei",$sprache,$link)); ?></td>
          </tr>
        </table>
        <p class="ueberschrift"><span class="standardSchriftBold"><?php echo(getUebersetzung("von",$sprache,$link)); ?>:<br/>
          </span>
          <!--  heutigen tag selectiert anzeigen: -->
          <select name="vonTag" class="tableColor" id="select">
            <?php for ($i=1; $i<=31; $i++) { ?>
            <option value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) echo(" selected"); ?>><?php echo($i); ?></option>
            <?php } ?>
          </select>
          <!--  heutiges monat selectiert anzeigen: -->
          <select name="vonMonat" class="tableColor" id="vonMonat" onChange="chkDays(0)">
            <option value="1"<?php if (getTodayMonth() == "Januar") echo " selected"; ?>><?php echo(getUebersetzung("Januar",$sprache,$link)); ?></option>
            <option value="2"<?php if (getTodayMonth() == "Februar") echo " selected"; ?>><?php echo(getUebersetzung("Februar",$sprache,$link)); ?></option>
            <option value="3"<?php if (getTodayMonth() == "M�rz") echo " selected"; ?>><?php echo(getUebersetzung("M�rz",$sprache,$link)); ?></option>
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
				for ($l=getTodayYear()-4; $l < (getTodayYear()+4); $l++){ ?>
            <option value="<?php echo $l ?>"<?php if ($l == $jahr) echo(" selected"); ?>><?php echo $l ?></option>
            <?php } ?>
          </select>
          <br/>
          <span class="standardSchriftBold"><?php echo(getUebersetzung("bis",$sprache,$link)); ?>:</span><br/>
          <select name="bisTag" class="tableColor" id="select4">
            <?php for ($i=1; $i<=31; $i++) { ?>
            <option value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) echo " selected"; ?>><?php echo($i); ?></option>
            <?php } ?>
          </select>
          <!--  heutiges monat selectiert anzeigen: -->
          <select name="bisMonat" class="tableColor" id="bisMonat" onChange="chkDays(1)">
            <option value="1"<?php if (getTodayMonth() == "Januar") echo " selected"; ?>><?php echo(getUebersetzung("Januar",$sprache,$link)); ?></option>
            <option value="2"<?php if (getTodayMonth() == "Februar") echo " selected"; ?>><?php echo(getUebersetzung("Februar",$sprache,$link)); ?></option>
            <option value="3"<?php if (getTodayMonth() == "M�rz") echo " selected"; ?>><?php echo(getUebersetzung("M�rz",$sprache,$link)); ?></option>
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
            <option value="<?php echo($l); ?>"<?php if ($l == $jahr) echo(" selected"); ?>><?php echo($l); ?></option>
            <?php } ?>
          </select>
        </p>
        <div align="left">
          <input name="zimmer_id" type="hidden" id="zimmer_id" value="<? echo $zimmer_id ?>">
          <input name="reservierungAendern" type="submit" class="btn btn-primary" id="reservierungAbsenden2" value="<?php echo(getUebersetzung("Reservierung ändern",$sprache,$link)); ?>">
        </div>
      </form></td>
  </tr>
  <tr>
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_parent">
        <input type="submit" name="Submit3" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       			onMouseOut="this.className='button200pxA';">
      </form></td>
  </tr>
  <tr>
    <td>
        <?php if ($isReseller) { ?>
        	<font size="2">&copy; 
    			<a href="<?= $resellerUrl ?>" target="_parent"><?= $resellerName ?></a>
    		</font>
		<?php } else { ?>
			<font size="2">&copy; 
	    		<a href="http://www.utilo.eu" target="_parent">utilo.eu</a>
	    	</font>
		<?php } ?>

    </td>
  </tr>
</table>
<?php } //ende passwortpr�fung 
	else{
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
		}
?>
</body>
</html>
