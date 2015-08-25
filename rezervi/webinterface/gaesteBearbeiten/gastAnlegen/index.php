<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
	reservierungsplan
	gast-infos anzeigen und evt. �ndern:
	author: christian osterrieder utilo.eu
			
	dieser seite muss �bergeben werden:
	Gast PK_ID $gast_id
	$unterkunft_id
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

//datenbank �ffnen:
include_once("../../../conf/rdbmsConfig.php");

//funktions einbinden:
include_once("../../../include/unterkunftFunctions.php");
//uebersetzer einfuegen:
include_once("../../../include/uebersetzer.php");
include_once("../../../include/reservierungFunctions.php");
include_once("../../../include/gastFunctions.php");
include_once("../../../include/benutzerFunctions.php");	
include_once("../../../include/einstellungenFunctions.php");	
	
?>

<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<script language="JavaScript" type="text/javascript" src="formPruefen.php">
</script>
<?php include_once("../../templates/bodyA.php"); ?>
<?php		
	//passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ ?>

<p class="ueberschrift"><?php echo(getUebersetzung("Anlegen eines neuen Gastes",$sprache,$link)); ?>:</p>
<form action="./anlegen.php" method="post" name="adresseForm" target="_self" onSubmit="return chkFormular();" class="form-horizontal">
	
	<div class="form-group">
		<label for="anrede" class="col-sm-2 control-label"><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></label>
		<div class="col-sm-10">
			<input name="anrede" type="text" id="anrede" value="" class="form-control">
		</div>
	</div>

</form>
	
  <table border="0" cellpadding="0" cellspacing="0" class="table">
    <tr>
      <td><table border="0" cellspacing="3" cellpadding="0">
          <tr> 
            <td class="standardSchrift"></td>
            <td>  
            </td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Vorname",$sprache,$link)); ?></td>
            <td><input name="vorname" type="text" id="vorname" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Nachname",$sprache,$link)); ?></td>
            <td><input name="nachname" type="text" id="nachname" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Straße/Hausnummer",$sprache,$link)); ?></td>
            <td><input name="strasse" type="text" id="strasse" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("PLZ",$sprache,$link)); ?></td>
            <td><input name="plz" type="text" id="plz" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Ort",$sprache,$link)); ?></td>
            <td><input name="ort" type="text" id="ort" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Land",$sprache,$link)); ?></td>
            <td><input name="land" type="text" id="land" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("E-Mail-Adresse",$sprache,$link)); ?></td>
            <td><input name="email" type="text" id="email" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Telefonnummer",$sprache,$link)); ?></td>
            <td><input name="tel" type="text" id="tel" ></td>
            <td></td>
          </tr>
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("Faxnummer",$sprache,$link)); ?></td>
            <td><input name="fax" type="text" id="fax" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("bevorzugte Sprache",$sprache,$link)); ?></td>
            <td><select name="speech" id="speech">
            	<?php
            	//sprachen des belegungsplanes anzeigen:
            	$stdSpr= getStandardSprache($unterkunft_id,$link);
            	$res = getSprachen($unterkunft_id,$link);
            	while ($d = mysql_fetch_array($res)){
				 	$spr = $d["Sprache_ID"];
					$bezeichnung = getBezeichnungOfSpracheID($spr,$link);
            	?>
                	<option value="<?php echo($spr); ?>" <?php if ($stdSpr == $spr) echo("selected"); ?>><?php echo(getUebersetzung($bezeichnung,$sprache,$link)); ?></option>
                <?php
				}
				?>
            </select></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Anmerkungen",$sprache,$link)); ?></td>
            <td><textarea name="anmerkungen" id="anmerkungen"></textarea></td>
            <td></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p>
    <input type="submit" name="anlegen" class="btn btn-success" value="<?php echo(getUebersetzung("Gast anlegen",$sprache,$link)); ?>">
  </p>

<form action="./anlegen.php" method="post" name="adresseForm" target="_self" onSubmit="return chkFormular();">
  <table border="0" cellpadding="0" cellspacing="0" class="table">
    <tr>
      <td><table border="0" cellspacing="3" cellpadding="0">
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Anrede",$sprache,$link)); ?></td>
            <td> <input name="anrede" type="text" id="anrede" value="" > 
            </td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Vorname",$sprache,$link)); ?></td>
            <td><input name="vorname" type="text" id="vorname" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Nachname",$sprache,$link)); ?></td>
            <td><input name="nachname" type="text" id="nachname" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Straße/Hausnummer",$sprache,$link)); ?></td>
            <td><input name="strasse" type="text" id="strasse" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("PLZ",$sprache,$link)); ?></td>
            <td><input name="plz" type="text" id="plz" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Ort",$sprache,$link)); ?></td>
            <td><input name="ort" type="text" id="ort" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Land",$sprache,$link)); ?></td>
            <td><input name="land" type="text" id="land" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("E-Mail-Adresse",$sprache,$link)); ?></td>
            <td><input name="email" type="text" id="email" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Telefonnummer",$sprache,$link)); ?></td>
            <td><input name="tel" type="text" id="tel" ></td>
            <td></td>
          </tr>
          <tr>
            <td class="standardSchrift"><?php echo(getUebersetzung("Faxnummer",$sprache,$link)); ?></td>
            <td><input name="fax" type="text" id="fax" ></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("bevorzugte Sprache",$sprache,$link)); ?></td>
            <td><select name="speech" id="speech">
            	<?php
            	//sprachen des belegungsplanes anzeigen:
            	$stdSpr= getStandardSprache($unterkunft_id,$link);
            	$res = getSprachen($unterkunft_id,$link);
            	while ($d = mysql_fetch_array($res)){
				 	$spr = $d["Sprache_ID"];
					$bezeichnung = getBezeichnungOfSpracheID($spr,$link);
            	?>
                	<option value="<?php echo($spr); ?>" <?php if ($stdSpr == $spr) echo("selected"); ?>><?php echo(getUebersetzung($bezeichnung,$sprache,$link)); ?></option>
                <?php
				}
				?>
            </select></td>
            <td></td>
          </tr>
          <tr> 
            <td class="standardSchrift"><?php echo(getUebersetzung("Anmerkungen",$sprache,$link)); ?></td>
            <td><textarea name="anmerkungen" id="anmerkungen"></textarea></td>
            <td></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p>
    <input type="submit" name="anlegen" class="btn btn-success" value="<?php echo(getUebersetzung("Gast anlegen",$sprache,$link)); ?>">
  </p>
</form>

<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td>
    	<!-- <form action="../index.php" method="post" name="form1" target="_self">
        <input name="zurueck" type="submit" class="button200pxA" id="zurueck" 
			onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zur�ck",$sprache,$link)); ?>"> </form> -->
       <a class="btn btn-primary" href="../index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
    </td>
  </tr>
</table>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><form action="../../inhalt.php" method="post" name="form1" target="_self">
        <input type="submit" name="Submit3" value="<?php echo(getUebersetzung("Hauptmen�",$sprache,$link)); ?>" class="button200pxA" 
			onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';">
    </form></td>
  </tr>
</table>
<?php } //ende passwortpr�fung 
	else{
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
		}
?>
</body>
</html>
