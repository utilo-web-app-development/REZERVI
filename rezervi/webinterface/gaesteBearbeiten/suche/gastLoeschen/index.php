<?php session_start();
$root = "../../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
	/*   
			reservierungsplan
			gast-infos anzeigen und evt. ändern:
			author: christian osterrieder utilo.eu
					
			dieser seite muss übergeben werden:
			Gast PK_ID $gast_id
			$unterkunft_id
		*/

	//datenbank öffnen:
	include_once("../../../../conf/rdbmsConfig.php");
	
	//funktions einbinden:
	include_once("../../../../include/unterkunftFunctions.php");
	//include_once("../../../../webinterface/gaesteBearbeiten/include/zimmerFunctions.php");	
	//include_once("../../../../include/reservierungFunctions.php");
	include_once("../../../../include/gastFunctions.php");
	include_once("../../../../include/benutzerFunctions.php");	
	
?>
<?php include_once("../../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../../templates/headerB.php"); ?>
<?php include_once("../../../templates/bodyA.php"); ?>
<?php		
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ 	
	?>

<p class="ueberschrift"><?php echo (getUnterkunftName($unterkunft_id,$link)) ?></p>
<?php //prüfen ob noch reservierungen oder sowas für diesen gast vorhanden sind:
		$query = ("SELECT		 
				   PK_ID
				   FROM
				   Rezervi_Reservierung
				   WHERE				
				   FK_Gast_ID = '$gast_id'
				  ");

  		$res = mysql_query($query, $link);
		if (!$res)  
			echo("die Anfrage scheitert"); 
		if($d = mysql_fetch_array($res)){
		 // es ist noch eine offene res vorhanden!
		 ?>
		<table width="100%" border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><p>Der Gast kann nicht gel&ouml;scht werden, da Reservierungen oder offene 
        Reservierungsanfragen f&uuml;r diesen Gast eingetragen sind!</p>
      <form action="../../../../webinterface/gaesteBearbeiten/suche/index.php" method="post" name="ok" target="_self" id="ok">
        <input type="submit" name="Submit" class="button200pxA" id="zurueck" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="OK">
        <input name="benutzer_id" type="hidden" id="benutzer_id" value="<?php echo($benutzer_id); ?>">
        <input name="unterkunft_id" type="hidden" id="unterkunft_id23" value="<?php echo($unterkunft_id); ?>">
        <input name="anrede_val" type="hidden" id="anrede_val2" value="<?php echo($anrede_val); ?>">
        <input name="vorname_val" type="hidden" id="vorname_val2" value="<?php echo($vorname_val); ?>">
        <input name="nachname_val" type="hidden" id="nachname_val2" value="<?php echo($nachname_val); ?>">
        <input name="strasse_val" type="hidden" id="strasse_val2" value="<?php echo($strasse_val); ?>">
        <input name="ort_val" type="hidden" id="ort_val2" value="<?php echo($ort_val); ?>">
        <input name="land_val" type="hidden" id="land_val2" value="<?php echo($land_val); ?>">
        <input name="email_val" type="hidden" id="email_val2" value="<?php echo($email_val); ?>">
        <input name="tel_val" type="hidden" id="tel_val2" value="<?php echo($tel_val); ?>">
        <input name="fax_val" type="hidden" id="anrede_val2" value="<?php echo($fax_val); ?>">
        <input name="anmerkung_val" type="hidden" id="anrede_val2" value="<?php echo($anmerkung_val); ?>">
      </form>      
    </td>
  </tr>
</table>
		
		<?php }//ende if
		else { //keine reservierungen mehr vorhanden, gast rausschmeissen:
			$query = "DELETE FROM
						Rezervi_Gast	
						WHERE
						PK_ID = '$gast_id'";
			$res = mysql_query($query, $link);
			if (!$res){ 
				echo("die Anfrage scheitert"); 
			}
			else{
			
		?>
<table width="100%" border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><p>Der Gast wurde erfolgreich aus der G&auml;steliste entfernt!</p>
      <form action="../../../../webinterface/gaesteBearbeiten/suche/index.php" method="post" name="ok" target="_self" id="ok">
        <input type="submit" name="Submit" class="button200pxA" id="zurueck" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="OK">
        <input name="benutzer_id" type="hidden" id="benutzer_id" value="<?php echo($benutzer_id); ?>">
        <input name="unterkunft_id" type="hidden" id="unterkunft_id23" value="<?php echo($unterkunft_id); ?>">
        <input name="anrede_val" type="hidden" id="anrede_val" value="<?php echo($anrede_val); ?>">
        <input name="vorname_val" type="hidden" id="vorname_val" value="<?php echo($vorname_val); ?>">
        <input name="nachname_val" type="hidden" id="nachname_val" value="<?php echo($nachname_val); ?>">
        <input name="strasse_val" type="hidden" id="strasse_val" value="<?php echo($strasse_val); ?>">
        <input name="ort_val" type="hidden" id="ort_val" value="<?php echo($ort_val); ?>">
        <input name="land_val" type="hidden" id="land_val" value="<?php echo($land_val); ?>">
        <input name="email_val" type="hidden" id="email_val" value="<?php echo($email_val); ?>">
        <input name="tel_val" type="hidden" id="tel_val" value="<?php echo($tel_val); ?>">
        <input name="fax_val" type="hidden" id="anrede_val" value="<?php echo($fax_val); ?>">
        <input name="anmerkung_val" type="hidden" id="anrede_val" value="<?php echo($anmerkung_val); ?>">
      </form>      
    </td>
  </tr>
</table>
<?php 			} //ende else	
			} //ende else
		} //ende passwortprüfung 
	else{
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
		}
?>
</body>
</html>
