<? session_start(); 
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			daten des gastes aufnehmen
			author: christian osterrieder utilo.eu					
			
			dieser seite muss �bergeben werden:
			Unterkunft PK_ID ($unterkunft_id)
			Zimmer PK_ID ($zimmer_id)
			Datum: $vonTag,$vonMonat,$vonJahr
				   $bisTag,$bisMonat,$bisJahr			
			
			die seite verwendet anfrage/send.php um das ausgef�llte
			formular zu versenden
*/ 	

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME); 
$status = $_POST["status"];
$vonTag = $_POST["vonTag"];
$bisTag = $_POST["bisTag"];
$vonMonat = $_POST["vonMonat"];
$bisMonat = $_POST["bisMonat"];
$vonJahr = $_POST["vonJahr"];
$bisJahr = $_POST["bisJahr"];
$zimmer_id = $_POST["zimmer_id"];
if (isset($_POST["gast_id"])){
	$gast_id = $_POST["gast_id"];
}
$sprache = getSessionWert(SPRACHE);
        
//datenbank �ffnen:
include_once("../../../conf/rdbmsConfig.php");
//Unterkunft-funktionen einbeziehen:
include_once("../../../include/unterkunftFunctions.php");
//zimmer-funktionen einbeziehen:
include_once("../../../include/zimmerFunctions.php");
//datum-funktionen einbeziehen:
include_once("../../../include/datumFunctions.php");
//gast-funktionen einbinden:
include_once("../../../include/gastFunctions.php");
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/reservierungFunctions.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once($root."/include/propertiesFunctions.php");
include_once($root."/suche/sucheFunctions.php");

//falls die gast_id nicht angegeben wurde auf -1 setzen:
if (empty($gast_id) || $gast_id == ""){
	$gast_id = -1;
}
?>
<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<!-- checken ob formular korrekt ausgef�llt wurde: -->
<script src="./checkForm.php" type="text/javascript">
</script>
<?php include_once("../../templates/bodyA.php"); ?>
<?php		
	//passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ ?>
<?php
 	//zuerst mal pr�fen ob datum und so passt:
	//variableninitialisierungen:
	$datumVon = parseDateFormular($vonTag,$vonMonat,$vonJahr);
	$datumBis = parseDateFormular($bisTag,$bisMonat,$bisJahr);

	//das datum ist nicht korrekt, das von-datum "h�her" als bis-datum
	if (isDatumEarlier($vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr) == FALSE) {
				
?>
<div class="alert alert-info" role="alert"
 <h4><?php echo(getUebersetzung("Das Reservierungs-Datum wurde nicht korrekt angegeben",$sprache,$link)); ?>!</h4>
 <h4><?php echo(getUebersetzung("Bitte korrigieren Sie das Datum",$sprache,$link)); ?>!</h4>
</div>
 
  
  <form action="../ansichtWaehlen.php" method="post" name="adresseForm" target="_self" id="adresseForm" >
          <input name="zimmer_id" type="hidden" id="zimmer_id8" value="<?php echo $zimmer_id ?>">
          <input name="monat" type="hidden" id="vonMonat2" value="<?php echo $vonMonat ?>">
          <input name="jahr" type="hidden" id="vonJahr2" value="<?php echo $vonJahr ?>">
		  <input type="submit" name="Submit" class="btn btn-primary" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>"></form></td>
 
  <?php
	}//ende if datum
	//zimmer ist zu dieser zeit belegt:
	else if (isRoomTaken($zimmer_id,$vonTag,$vonMonat,$vonJahr,$bisTag,$bisMonat,$bisJahr,$link) && ($status == 2)){
	?>
	<div class="alert alert-info" role="alert"
		 
			<h4><?php echo(getUebersetzung("Zu diesem Datum existiert bereits eine Reservierung oder die Reservierungen überschneiden sich",$sprache,$link)); ?>!</h4>
		  	<h4><?php echo(getUebersetzung("Bitte korrigieren Sie das Datum oder löschen Sie die bereits vorhandene Reservierung",$sprache,$link)); ?>!</h4>
	</div>
	    
	 
	<table border="0" cellspacing="3" cellpadding="0" class="table">
    <tr>
      <td><form action="../ansichtWaehlen.php" method="post" name="adresseForm" target="_self" id="adresseForm" >
          <input name="zimmer_id" type="hidden" id="zimmer_id8" value="<?php echo $zimmer_id ?>">
          <input name="monat" type="hidden" id="vonMonat2" value="<?php echo $vonMonat ?>">
          <input name="jahr" type="hidden" id="vonJahr2" value="<?php echo $vonJahr ?>">
		  <input type="submit" name="Submit" class="btn btn-primary"  value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>"></form></td>
    </tr>
  </table>
<?php
	}
	//wenn datum ok:
	else{
?>

<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><p><?php echo(getUebersetzung("Reservierungs-Anderung für",$sprache,$link)); ?> <?php echo(getUebersetzungUnterkunft(getZimmerArt($unterkunft_id,$zimmer_id,$link),$sprache,$unterkunft_id,$link)); ?>: <?php echo(getUebersetzungUnterkunft(getZimmerNr($unterkunft_id,$zimmer_id,$link),$sprache,$unterkunft_id,$link)); ?><br/>
        <?php echo(getUebersetzung("von",$sprache,$link)); ?>:<span class="standardSchriftBold"> <?php echo $vonTag ?>. <?php echo $vonMonat ?>. 
        <?php echo $vonJahr ?></span><br/>
        <?php echo(getUebersetzung("bis",$sprache,$link)); ?>:<span class="standardSchriftBold"> <?php echo $bisTag ?>. <?php echo $bisMonat ?>. 
        <?php echo $bisJahr ?></span><br/><?php echo(getUebersetzung("Status",$sprache,$link)); ?>: 
        <span class="<?php 
					//status = 0: frei
					//status = 1: reserviert
					//status = 2: belegt
					if ($status == 0){
						echo("frei");
					}
					elseif ($status == 1){
						echo("reserviert");
					}
					elseif ($status == 2){
						echo("belegt");
					}
				?>"><?php 
					//status = 0: frei
					//status = 1: reserviert
					//status = 2: belegt
					if ($status == 0){
						echo(getUebersetzung("frei",$sprache,$link));
					}
					elseif ($status == 1){
						echo(getUebersetzung("reserviert",$sprache,$link));
					}
					elseif ($status == 2){
						echo(getUebersetzung("belegt",$sprache,$link));
					}
				?></span></p>
      </td>
  </tr>
</table>
<?php 
//wenn belegt oder reserviert eingabe des gastes fordern:
if ($status != 0) { ?>
  <br/>	
  <form action="./resEintragen.php" method="post" name="noAdressForm" target="_self" id="noAdressForm">
  <table border="0" cellspacing="0" cellpadding="3" class="table">
    <tr>
  		<td>
  			<?php echo(getUebersetzung("Wenn sie keinen Gast eingeben wird die Reservierung f�r einen anonymen Gast gespeichert",$sprache,$link)); ?>.
  		</td>
  	</tr>
  	<tr>
  		<td>
  		  <input name="gast_id" type="hidden" id="gast_id" value="1">
  		  <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo($zimmer_id); ?>">
      	  <input name="vonTag" type="hidden" id="vonTag" value="<?php echo $vonTag ?>">
          <input name="bisTag" type="hidden" id="bisTag" value="<?php echo $bisTag ?>">
          <input name="vonMonat" type="hidden" id="vonMonat" value="<?php echo $vonMonat ?>">
          <input name="bisMonat" type="hidden" id="bisMonat" value="<?php echo $bisMonat ?>">
          <input name="vonJahr" type="hidden" id="vonJahr" value="<?php echo $vonJahr ?>">
          <input name="bisJahr" type="hidden" id="bisJahr" value="<?php echo $bisJahr ?>">
		  <input name="status" type="hidden" id="status" value="<?php echo $status ?>">
          <input name="monat" type="hidden" id="vonMonat2" value="<?php echo $vonMonat ?>">
          <input name="jahr" type="hidden" id="vonJahr2" value="<?php echo $vonJahr ?>">
          <input name="send" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" id="send" value="<?php echo(getUebersetzung("keinen Gast eingeben",$sprache,$link)); ?>">
  		</td>
  	</tr>
  </table>
  </form>
  <br/>
<table border="0" cellspacing="0" cellpadding="0" class="table">
  <tr>
    <td><p class="standardSchrift"><?php echo(getUebersetzung("Bitte geben Sie hier den Gast ein, oder w�hlen Sie einen bereits vorhanden Gast aus der Liste aus",$sprache,$link)); ?>:</p>
      <form action="./resAendern.php" method="post" name="gastWaehlen" target="_self">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Gast ausw�hlen",$sprache,$link)); ?></td>
            <td><select name="gast_id" id="select" onChange="submit()">
                <option value="-1" selected><?php echo(getUebersetzung("neuer Gast",$sprache,$link)); ?></option>
                <?php //alle g�ste dieser unterkunft vorschlagen:
		  	$query = ("SELECT 
					   PK_ID,Vorname,Nachname,Ort
					   FROM
					   Rezervi_Gast
					   WHERE					   
					   FK_Unterkunft_ID = '$unterkunft_id'					   
					   ORDER BY	
					   Nachname
				 ");

  			$res = mysql_query($query, $link);
			if (!$res) { 
				echo("die Anfrage scheitert");
			} //ende if
			else {
				while($d = mysql_fetch_array($res)) {
					?>
                <option value="<?php echo($d["PK_ID"]); ?>" <?php if ($d["PK_ID"] == $gast_id) echo("selected"); ?>><?php echo($d["Nachname"]." ".$d["Vorname"].", ".$d["Ort"]); ?></option>
                <?php				
				} //ende while				
			} //ende else		
			?>
              </select></td>
            <td>&nbsp;</td>
          </tr>
        </table>        
        <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo $zimmer_id ?>">
        <input name="vonTag" type="hidden" id="vonTag" value="<?php echo $vonTag ?>">
        <input name="bisTag" type="hidden" id="bisTag" value="<?php echo $bisTag ?>">
        <input name="vonMonat" type="hidden" id="vonMonat" value="<?php echo $vonMonat ?>">
        <input name="bisMonat" type="hidden" id="bisMonat" value="<?php echo $bisMonat ?>">
        <input name="vonJahr" type="hidden" id="vonJahr" value="<?php echo $vonJahr ?>">
        <input name="bisJahr" type="hidden" id="bisJahr" value="<?php echo $bisJahr ?>">
        <input name="monat" type="hidden" id="vonMonat" value="<?php echo $vonMonat ?>">
        <input name="jahr" type="hidden" id="vonJahr" value="<?php echo $vonJahr ?>">
        <input name="status" type="hidden" id="status" value="<?php echo $status ?>">
      </form>
      
      <form action="./resEintragen.php" method="post" name="adresseForm" target="_self" id="adresseForm" onSubmit="return chkFormular()">
     
	    <table border="0" cellspacing="0" cellpadding="3">
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("neuer Gast/Gast �ndern",$sprache,$link)); ?>:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
            <td> <select name="anrede" id="select2">
                <?php if (!(empty($gast_id))) 
				$anrede = getGuestAnrede($gast_id,$link); ?>
                <option<?php if ((!(empty($anrede))) && ($anrede == "Familie")) echo(" selected"); ?>><?php echo(getUebersetzung("Familie",$sprache,$link)); ?></option>
                <option<?php if ((!(empty($anrede))) && ($anrede == "Frau")) echo(" selected"); ?>><?php echo(getUebersetzung("Frau",$sprache,$link)); ?></option>
                <option<?php if ((!(empty($anrede))) && ($anrede == "Herr")) echo(" selected"); ?>><?php echo(getUebersetzung("Herr",$sprache,$link)); ?></option>
                <option<?php if ((!(empty($anrede))) && ($anrede == "Firma")) echo(" selected"); ?>><?php echo(getUebersetzung("Firma",$sprache,$link)); ?></option>
              </select> </td>
            <td>&nbsp;</td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Vorname",$sprache,$link)); ?>*</td>
            <td><input name="vorname" type="text" id="vorname2" <?php if (!(empty($gast_id))){
																echo("value=\"".getGuestVorname($gast_id,$link)."\"");	
															  } ?>></td>
            <td>&nbsp;</td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Nachname",$sprache,$link)); ?>*</td>
            <td><input name="nachname" type="text" id="nachname2" <?php if (!(empty($gast_id))){
																echo("value=\"".getGuestNachname($gast_id,$link)."\"");	
															  } ?>></td>
            <td>&nbsp;</td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Stra�e/Hausnummer",$sprache,$link)); ?>*</td>
            <td><input name="strasse" type="text" id="strasse2" <?php if (!(empty($gast_id))){
																echo("value=\"".getGuestStrasse($gast_id,$link)."\"");	
															  } ?>></td>
            <td>&nbsp;</td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Postleitzahl",$sprache,$link)); ?>*</td>
            <td><input name="plz" type="text" id="plz2" <?php if (!(empty($gast_id))){
																echo("value=\"".getGuestPLZ($gast_id,$link)."\"");	
															  } ?>></td>
            <td>&nbsp;</td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Ort",$sprache,$link)); ?>*</td>
            <td><input name="ort" type="text" id="ort2" <?php if (!(empty($gast_id))){
																echo("value=\"".getGuestOrt($gast_id,$link)."\"");	
															  } ?>></td>
            <td>&nbsp;</td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Land",$sprache,$link)); ?></td>
            <td><input name="land" type="text" id="land2" <?php if (!(empty($gast_id))){
																echo("value=\"".getGuestLand($gast_id,$link)."\"");	
															  } ?>></td>
            <td>&nbsp;</td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("E-Mail-Adresse",$sprache,$link)); ?>*</td>
            <td><input name="email" type="text" id="email2" <?php if (!(empty($gast_id))){
																echo("value=\"".getGuestEmail($gast_id,$link)."\"");	
															  } ?>></td>
            <td>&nbsp;</td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Telefonnummer",$sprache,$link)); ?></td>
            <td><input name="tel" type="text" id="tel" <?php if (!(empty($gast_id))){
																echo("value=\"".getGuestTel($gast_id,$link)."\"");	
															  } ?>></td>
            <td>&nbsp;</td>
          </tr>
          <tr class="standardSchrift">
            <td><?php echo(getUebersetzung("Faxnummer",$sprache,$link)); ?></td>
            <td><input name="fax" type="text" id="fax2" <?php if (!(empty($gast_id))){
																echo("value=\"".getGuestFax($gast_id,$link)."\"");	
															  } ?>></td>
            <td>&nbsp;</td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("bevorzugte Sprache",$sprache,$link)); ?></td>
            <td><?php 
				if (!(empty($gast_id))){
					$gastSprache = getGuestSprache($gast_id,$link); 
				} 
				else{
					$gastSprache = "de";
				}
				?>	
				<table cellpadding="0" cellspacing="0" border="0">
				<?php  
            	$res = getSprachen($unterkunft_id,$link);
            	while ($d = mysql_fetch_array($res)){
				 	$spracheID = $d["Sprache_ID"];
		  			$bezeichnung = getBezeichnungOfSpracheID($spracheID,$link);
				  ?>
				  <tr class="standardSchrift">
				    <td><input type="radio" name="speech" value="<?php echo($spracheID); ?>"
				    	<?php if( (isset($gastSprache) && $gastSprache == $spracheID) || ($sprache == $spracheID) ){ echo(" checked"); } ?>>
				    	<?php echo(getUebersetzung($bezeichnung,$sprache,$link)); ?>
				    </td>
				  </tr>
				  <?php
				  } //ende foreach 
				  ?> 
				  </table> 			  
	  		</td>
	  		<td>&nbsp;</td>
	  	 </tr>       
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Anmerkungen",$sprache,$link)); ?></td>
            <td><textarea name="anmerkungen" id="textarea" >
            	<?php if (!(empty($gast_id))){
					echo(getGuestAnmerkung($gast_id,$link));	
				} ?></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr class="standardSchrift"> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="standardSchrift"> 
            <td colspan="3"><?php echo(getUebersetzung("Bitte geben Sie hier die Anzahl der G�ste f�r die Reservierung/Belegung ein",$sprache,$link)); ?>:</td>
          </tr>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Anzahl Erwachsene",$sprache,$link)); ?></td>
            <td><select name="anzahlErwachsene" id="anzahlErwachsene">
						<?php
							$anzahlBetten = getBetten($unterkunft_id,$zimmer_id,$link);
							$anzahlBetten+=1;$anzahlBetten-=1; //integer!
							for ($i = 0; $i <= $anzahlBetten; $i++){ ?>
								<option value="<?php echo($i); ?>" <?php if ($i == 2) echo("selected"); ?>><?php echo($i); ?></option>
						<?php 
							} //ende for schleife
						?>
              </select></td>
            <td>&nbsp;</td>
          </tr>
		  <?php
		  $anzahlKinderBetten = getAnzahlKinder($unterkunft_id,$link);
		  if (!empty($anzahlKinderBetten) && $anzahlKinderBetten > 0){
		  ?>
          <tr class="standardSchrift"> 
            <td><?php echo(getUebersetzung("Anzahl Kinder unter",$sprache,$link)); ?> <?php echo(getKindesalter($unterkunft_id,$link)); ?> <?php echo(getUebersetzung("Jahren",$sprache,$link)); ?></td>
            <td><select name="anzahlKinder" id="anzahlKinder">
					<?php
					for ($i = 0; $i <= ($anzahlKinderBetten); $i++)
					{ 
					   ?>
					   <option value="<?php echo($i); ?>" <?php if ($i == 0) echo("selected"); ?>><?php echo($i); ?></option>
					   <?php 
					}//ende for schleife
					?>
              </select></td>
            <td>&nbsp;</td>
          </tr>
  			<?php 
			}
  			if (getPropertyValue(PENSION_UEBERNACHTUNG,$unterkunft_id,$link) == "true"){
  			?>
              <tr class="standardSchrift">
                <td>
                  <?php
                  	echo(getUebersetzung("�bernachtung",$sprache,$link));
                  ?>
                </td>
			    <td>
			      <input name="zusatz" type="radio" value="Uebernachtung" checked="checked"/>
                </td>
              </tr>
              <?
  			  }
  			  if (getPropertyValue(PENSION_FRUEHSTUECK,$unterkunft_id,$link) == "true"){
              ?>
			  <tr class="standardSchrift">
                <td>
                  <?php
                  	echo(getUebersetzung("Fr�hst�ck",$sprache,$link));
                  ?>
                </td>
			    <td>
			      <input name="zusatz" type="radio" value="Fruehstueck" checked="checked"/>
                </td>
              </tr>
              <?
  			  }
  			  if (getPropertyValue(PENSION_HALB,$unterkunft_id,$link) == "true"){
              ?>
			  <tr class="standardSchrift">
                <td>
                  <?php
                  	echo(getUebersetzung("Halbpension",$sprache,$link));
                  ?>
                </td>
			    <td>
			      <input name="zusatz" type="radio" value="Halbpension" checked="checked"/>
                </td>
              </tr>
              <?
  			  }
  			  if (getPropertyValue(PENSION_VOLL,$unterkunft_id,$link) == "true"){
              ?>                      
			  <tr class="standardSchrift">
                <td>
                  <?php
                  	echo(getUebersetzung("Vollpension",$sprache,$link));
                  ?>
                </td>
			    <td>
			      <input name="zusatz" type="radio" value="Vollpension" checked="checked"/>
                </td>
              </tr>
			  <?php
  			  }
  			  ?>
        </table>
        <p>(<?php echo(getUebersetzung("Die mit * gekennzeichneten Felder m�ssen ausgef�llt werden",$sprache,$link)); ?>!) 
         
		  <input name="gast_id" type="hidden" id="gast_id" value="<?php echo $gast_id ?>">
        </p>        
        <p> 
		  
          <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo $zimmer_id ?>">
          <input name="vonTag" type="hidden" id="vonTag" value="<?php echo $vonTag ?>">
          <input name="bisTag" type="hidden" id="bisTag" value="<?php echo $bisTag ?>">
          <input name="vonMonat" type="hidden" id="vonMonat" value="<?php echo $vonMonat ?>">
          <input name="bisMonat" type="hidden" id="bisMonat" value="<?php echo $bisMonat ?>">
          <input name="vonJahr" type="hidden" id="vonJahr" value="<?php echo $vonJahr ?>">
          <input name="bisJahr" type="hidden" id="bisJahr" value="<?php echo $bisJahr ?>">
		  <input name="status" type="hidden" id="status" value="<?php echo $status ?>">
          <input name="monat" type="hidden" id="vonMonat2" value="<?php echo $vonMonat ?>">
          <input name="jahr" type="hidden" id="vonJahr2" value="<?php echo $vonJahr ?>">
          <input name="send" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" id="send" value="<?php echo(getUebersetzung("weiter",$sprache,$link)); ?>">
          
	    </p>
	  </form>
          <?php } //ende if status != frei
	  		else { //wenn nur frei dann daten l�schen und nur ok-button anzeigen:
			?>
			<br/>
			<table cellspacing="0" cellpadding="0" class="belegt">
			<?php
			//alle Reservierungen ausgeben die gel�scht werden, wenn auf ok gedrueckt wird:
			$vonDatum = parseDateFormular($vonTag,$vonMonat,$vonJahr);
			$bisDatum = parseDateFormular($bisTag,$bisMonat,$bisJahr);
			$result = getReservationWithDate($zimmer_id,$vonDatum,$bisDatum,$link);
			$first = true;
			while($d = mysql_fetch_array($result)){
				if ($first){ ?>					
					  <tr><td class="standardSchrift">
					  <?php echo(getUebersetzung("Folgende Reservierungen werden gel�scht",$sprache,$link)); ?>:
					  </td></tr>						 
				<?php }
				$first = false;
				$pk_id = $d["PK_ID"];
				$gast_id = getGastID($pk_id,$link);
				$datumV = getDatumVon($pk_id,$link);
				$datumB = getDatumBis($pk_id,$link);
				$gast_nn = getGuestNachname($gast_id,$link);
			?>
				<tr><td class="standardSchrift">
				<?php
				echo(getUebersetzung("Reservierung von",$sprache,$link)." ".$datumV." ".getUebersetzung("bis",$sprache,$link)." ".$datumB.", ".getUebersetzung("Gast",$sprache,$link).": ".$gast_nn);
				?>
				</td></tr>
			<?php 
			} //ende while reservierungen anzeigen
			?>
			</table>
			<br/>
			<form name="zimmerFrei" method="post" action="./resEntfernen.php" target="_self">			
          	<input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo $zimmer_id ?>">
          	<input name="vonTag" type="hidden" id="vonTag" value="<?php echo $vonTag ?>">
          	<input name="bisTag" type="hidden" id="bisTag" value="<?php echo $bisTag ?>">
          	<input name="vonMonat" type="hidden" id="vonMonat" value="<?php echo $vonMonat ?>">
          	<input name="bisMonat" type="hidden" id="bisMonat" value="<?php echo $bisMonat ?>">
          	<input name="vonJahr" type="hidden" id="vonJahr" value="<?php echo $vonJahr ?>">
          	<input name="bisJahr" type="hidden" id="bisJahr" value="<?php echo $bisJahr ?>">
			<input name="monat" type="hidden" id="vonMonat2" value="<?php echo $vonMonat ?>">
            <input name="jahr" type="hidden" id="vonJahr2" value="<?php echo $vonJahr ?>">
      		<input name="status" type="hidden" id="status" value="<?php echo $status ?>">
      		<input name="send2" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" id="send2" value="<?php echo(getUebersetzung("weiter",$sprache,$link)); ?>">       
      		</form> 
			<form action="../ansichtWaehlen.php" method="post" name="adresseForm" target="_self" id="adresseForm" >     
			  <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo($zimmer_id); ?>">
			  <input name="monat" type="hidden" id="monat" value="<?php echo($vonMonat); ?>">
			  <input name="jahr" type="hidden" id="jahr" value="<?php echo($vonJahr); ?>">
			  <input name="abbrechen" type="submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       		 	onMouseOut="this.className='button200pxA';" id="abbrechen" value="<?php echo(getUebersetzung("abbrechen",$sprache,$link)); ?>">
			 </form>
      <?php } 
	  	} //ende else - datum ok 
	  ?>
    </td>
  </tr>
</table>
<?php } //ende passwortpr�fung 
	else{
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
		}
?>
</body>
</html>
