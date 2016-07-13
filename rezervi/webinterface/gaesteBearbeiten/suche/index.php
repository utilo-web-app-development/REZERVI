<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan			
			author: christian osterrieder utilo.eu		
			
			dieser seite muss übergeben werden:
			Unterkunft PK_ID ($unterkunft_id)
		*/
 
	//datenbank öffnen:
	include_once("../../../conf/rdbmsConfig.php");
	include_once("../../../include/unterkunftFunctions.php");
	include_once("../../../include/benutzerFunctions.php");	
?>	
<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<script language="JavaScript">
	<!--
	    function sicher(){
	    return confirm("Gast wirklich löschen?"); 	    
	    }
	    //-->
</script>
<?php include_once("../../templates/bodyA.php"); ?>
<?php		
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ ?>
<table width="100%" border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td>G&auml;ste suchen und bearbeiten</td>
  </tr>
</table>
<br/>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr> 
    <td><?php 
	//gästeliste ausgeben:	
	$query = ("SELECT 
				PK_ID, Anrede, Vorname, Nachname, Strasse, PLZ, Ort, Land, EMail, Tel, Fax, Anmerkung
				FROM
				Rezervi_Gast
				WHERE
				FK_Unterkunft_ID = '$unterkunft_id'
				ORDER BY
				Nachname
				");

  	$res = mysql_query($query, $link);
	if (!$res)  
		echo("die Anfrage scheitert");
		
	while ($d = mysql_fetch_array($res)){
		$gast_id = $d["PK_ID"];
		$vorname = $d["Vorname"];
		$nachname = $d["Nachname"];
		$strasse = $d["Strasse"];
		$plz = $d["PLZ"];
		$ort = $d["Ort"];
		$land = $d["Land"];
		$email = $d["EMail"];
		$tel = $d["Tel"];
		$fax = $d["Fax"];
		$anmerkung = $d["Anmerkung"];
		$anrede = $d["Anrede"];	
	
	?>
      <table width="100%" border="0" cellspacing="1" cellpadding="0" class="table">
        <tr>
		<?php if ($anrede_val == "true"){ ?>  
          <td>Anrede</td>
		<?php } 
			  if ($vorname_val == "true"){ ?>
          <td>Vorname</td>
		 <?php } 
			  if ($nachname_val == "true"){ ?> 
          <td>Nachname</td>
		 <?php } 
			  if ($strasse_val == "true"){ ?>
          <td>Stra&szlig;e</td>
		 <?php } 
			  if ($ort_val == "true"){ ?>
          <td>Ort</td>
		  <?php } 
			  if ($land_val == "true"){ ?>
          <td>Land</td>
		  <?php } 
			  if ($email_val == "true"){ ?>
          <td>E-Mail</td>
		  <?php } 
			  if ($tel_val == "true"){ ?>
          <td>Telefon</td>
		  <?php } 
			  if ($fax_val == "true"){ ?>
          <td>Fax</td>
		  <?php } 
			  if ($anmerkung_val == "true"){ ?>
          <td>Anmerkungen</td>
		  <?php } 
			   ?>
        </tr>
        <tr> 
		<?php if ($anrede_val == "true"){ ?>
          <td><?php echo($anrede); ?></td>
		  <?php } 
			  if ($vorname_val == "true"){ ?>
          <td><?php echo($vorname); ?></td>
		  <?php } 
			  if ($nachname_val == "true"){ ?>
          <td><?php echo($nachname); ?></td>
		  <?php } 
			  if ($strasse_val == "true"){ ?>
          <td><?php echo($strasse); ?></td>
		  <?php } 
			  if ($ort_val == "true"){ ?>
          <td><?php echo($ort); ?></td>
		  <?php } 
			  if ($land_val == "true"){ ?>
          <td><?php echo($land); ?></td>
		  <?php } 
			  if ($email_val == "true"){ ?>
          <td><?php echo($email); ?></td>
		  <?php } 
			  if ($tel_val == "true"){ ?>
          <td><?php echo($tel); ?></td>
		  <?php } 
			  if ($fax_val == "true"){ ?>
          <td><?php echo($fax); ?></td>
		  <?php } 
			  if ($anmerkung_val == "true"){ ?>
          <td><?php echo($anmerkung); ?></td>
		  <?php } 
			  ?>
        </tr>
        <tr> 
          <td colspan="10">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td><form action="../../../webinterface/gaesteBearbeiten/suche/gastBearbeiten/index.php" method="post" name="gastBearbeiten" target="_self">
                    <div align="right">
                      <input name="anrede_val" type="hidden" id="anrede_var" value="<?php echo($anrede_val); ?>">
                      <input name="vorname_val" type="hidden" id="vorname_var3" value="<?php echo($vorname_val); ?>">
                      <input name="nachname_val" type="hidden" id="anrede_var4" value="<?php echo($nachname_val); ?>">
                      <input name="strasse_val" type="hidden" id="anrede_var5" value="<?php echo($strasse_val); ?>">
                      <input name="ort_val" type="hidden" id="anrede_var6" value="<?php echo($ort_val); ?>">
                      <input name="land_val" type="hidden" id="anrede_var7" value="<?php echo($land_val); ?>">
                      <input name="email_val" type="hidden" id="anrede_var8" value="<?php echo($email_val); ?>">
                      <input name="tel_val" type="hidden" id="anrede_var9" value="<?php echo($tel_val); ?>">
                      <input name="fax_val" type="hidden" id="anrede_var" value="<?php echo($fax_val); ?>">
					  <input name="anmerkung_val" type="hidden" id="anrede_var" value="<?php echo($anmerkung_val); ?>">
                      <input name="gastBearbeiten" type="submit" id="gastBearbeiten" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="Gast bearbeiten">
                      <input name="unterkunft_id" type="hidden" id="unterkunft_id" value="<?php echo($unterkunft_id); ?>">
                      <input name="benutzer_id" type="hidden" id="benutzer_id" value="<?php echo($benutzer_id); ?>">
                      <input name="gast_id" type="hidden" id="gast_id" value="<?php echo($gast_id); ?>">
                    </div>
                  </form></td>
                  <td width="1"><form action="../../../webinterface/gaesteBearbeiten/suche/gastLoeschen/index.php" method="post" name="gastLoeschen" target="_self" onSubmit="return sicher()">
                    <div align="right">
                      <input name="gastLoeschen" type="submit" id="gastLoeschen" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="Gast l&ouml;schen">
                      <input name="anrede_val" type="hidden" id="anrede_var10" value="<?php echo($anrede_val); ?>">
                      <input name="vorname_val" type="hidden" id="vorname_var" value="<?php echo($vorname_val); ?>">
                      <input name="nachname_val" type="hidden" id="nachname_var" value="<?php echo($nachname_val); ?>">
                      <input name="strasse_val" type="hidden" id="strasse_var" value="<?php echo($strasse_val); ?>">
                      <input name="ort_val" type="hidden" id="ort_var" value="<?php echo($ort_val); ?>">
                      <input name="land_val" type="hidden" id="land_var" value="<?php echo($land_val); ?>">
                      <input name="email_val" type="hidden" id="email_var" value="<?php echo($email_val); ?>">
                      <input name="tel_val" type="hidden" id="tel_var" value="<?php echo($tel_val); ?>">
                      <input name="fax_val" type="hidden" id="anrede_var10" value="<?php echo($fax_val); ?>">
                      <input name="anmerkung_val" type="hidden" id="anrede_var10" value="<?php echo($anmerkung_val); ?>">
                      <input name="benutzer_id" type="hidden" id="benutzer_id" value="<?php echo($benutzer_id); ?>">
                      <input name="unterkunft_id" type="hidden" id="unterkunft_id23" value="<?php echo($unterkunft_id); ?>">
                      <input name="gast_id" type="hidden" id="gast_id" value="<?php echo ($gast_id); ?>">
                    </div>
                  </form> </td>
                </tr>
              </table>
            </td>
        </tr>
      </table>
      <br/>
      <?php } //ende while#
	?>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="3" cellpadding="0" class="table">
  <tr> 
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="1"><form action="../../../webinterface/inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
              
                <input name="benutzername" type="hidden" value="<?php echo($benutzername); ?>">
                <input name="passwort" type="hidden" value="<?php echo($passwort); ?>">
                <input type="submit" name="Submit3" value="Hauptmenü" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';">
             
        </form>
          </td>
          <td><form action="../../../webinterface/gaesteBearbeiten/index.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
             
                <input name="zurueck" type="submit" class="button200pxA" id="zurueck" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="zur&uuml;ck">
                <input name="benutzer_id" type="hidden" id="benutzer_id" value="<?php echo($benutzer_id); ?>">
              <input name="unterkunft_id" type="hidden" id="unterkunft_id" value="<?php echo($unterkunft_id); ?>">
            </form></td>
        </tr>
      </table>
      </td>
  </tr>
</table>
<?php } //ende passwortprüfung 
	else{
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
		}
?>
</body>
</html>
