<?php session_start();
$root = "../../../..";
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
$anrede_val = $_POST["anrede_val"];
$vorname_val = $_POST["vorname_val"];
$nachname_val = $_POST["nachname_val"];
$strasse_val = $_POST["strasse_val"];
$plz_val = $_POST["plz_val"];
$ort_val = $_POST["ort_val"];
$land_val = $_POST["land_val"];
$email_val = $_POST["email_val"];
$tel_val = $_POST["tel_val"];
$fax_val = $_POST["fax_val"];
$sprache_val = $_POST["anmerkung_val"];
$anmerkung_val = $_POST["anmerkung_val"];
$gast_id = $_POST["gast_id"];
$sprache = getSessionWert(SPRACHE);
$index = $_POST["index"];

//datenbank �ffnen:
include_once("../../../../conf/rdbmsConfig.php");

//funktions einbinden:
include_once("../../../../include/unterkunftFunctions.php");
//uebersetzer einfuegen:
include_once("../../../../include/uebersetzer.php");
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
//passwortpr�fung:	
if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ 	
?>
<?php //pr�fen ob noch reservierungen oder sowas f�r diesen gast vorhanden sind:
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
    <td><p><?php echo(getUebersetzung("Der Gast kann nicht gel�scht werden, da Reservierungen oder offene Reservierungsanfragen f�r diesen Gast eingetragen sind",$sprache,$link)); ?>!</p>
     <form action="../gastInfos/index.php" method="post" name="gastInfos" target="_self">
		  <input name="gastInfos" type="submit" id="gastInfos" class="button200pxA" onMouseOver="this.className='button200pxB';"
			onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Reservierungs-Informationen",$sprache,$link)); ?>">
		  <input name="anrede_val" type="hidden" id="anrede_var10" value="<? echo($anrede_val); ?>">
		  <input name="vorname_val" type="hidden" id="vorname_var" value="<? echo($vorname_val); ?>">
		  <input name="nachname_val" type="hidden" id="nachname_var" value="<? echo($nachname_val); ?>">
		  <input name="strasse_val" type="hidden" id="strasse_var" value="<? echo($strasse_val); ?>">
		  <input name="ort_val" type="hidden" id="ort_var" value="<? echo($ort_val); ?>">
		  <input name="land_val" type="hidden" id="land_var" value="<? echo($land_val); ?>">
		  <input name="email_val" type="hidden" id="email_var" value="<? echo($email_val); ?>">
		  <input name="tel_val" type="hidden" id="tel_var" value="<? echo($tel_val); ?>">
		  <input name="fax_val" type="hidden" id="anrede_var10" value="<? echo($fax_val); ?>">
		  <input name="anmerkung_val" type="hidden" id="anrede_var10" value="<? echo($anmerkung_val); ?>">
		  <input name="plz_val" type="hidden" id="plz_val" value="<? echo($plz_val); ?>">
		  <input name="sprache_val" type="hidden" id="plz_val" value="<? echo($sprache_val); ?>">
		  <input name="gast_id" type="hidden" id="gast_id" value="<? echo ($gast_id); ?>">
		  <input name="index" type="hidden" value="<?php echo($index); ?>"/>
      </form>

      <form action="../index.php" method="post" name="ok" target="_self" id="ok">
        <input type="submit" name="Submit" class="button200pxA" id="zurueck" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zur�ck",$sprache,$link)); ?>">
        <input name="anrede_val" type="hidden" id="anrede_val2" value="<? echo($anrede_val); ?>">
        <input name="vorname_val" type="hidden" id="vorname_val2" value="<? echo($vorname_val); ?>">
        <input name="nachname_val" type="hidden" id="nachname_val2" value="<? echo($nachname_val); ?>">
        <input name="strasse_val" type="hidden" id="strasse_val2" value="<? echo($strasse_val); ?>">
        <input name="ort_val" type="hidden" id="ort_val2" value="<? echo($ort_val); ?>">
        <input name="land_val" type="hidden" id="land_val2" value="<? echo($land_val); ?>">
        <input name="email_val" type="hidden" id="email_val2" value="<? echo($email_val); ?>">
        <input name="tel_val" type="hidden" id="tel_val2" value="<? echo($tel_val); ?>">
        <input name="fax_val" type="hidden" id="anrede_val2" value="<? echo($fax_val); ?>">
        <input name="anmerkung_val" type="hidden" id="anrede_val2" value="<? echo($anmerkung_val); ?>">
		<input name="sprache_val" type="hidden" id="anrede_var" value="<? echo($sprache_val); ?>"> 
        <input name="plz_val" type="hidden" id="plz_val" value="<? echo($plz_val); ?>">
		<input name="index" type="hidden" value="<?php echo($index); ?>"/>
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
    <td><p><?php echo(getUebersetzung("Der Gast wurde erfolgreich aus der G�steliste entfernt",$sprache,$link)); ?>!</p>
      <form action="../index.php" method="post" name="ok" target="_self" id="ok">
        <input type="submit" name="Submit" class="button200pxA" id="zurueck" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zur�ck",$sprache,$link)); ?>">
        <input name="anrede_val" type="hidden" id="anrede_val" value="<? echo($anrede_val); ?>">
        <input name="vorname_val" type="hidden" id="vorname_val" value="<? echo($vorname_val); ?>">
        <input name="nachname_val" type="hidden" id="nachname_val" value="<? echo($nachname_val); ?>">
        <input name="strasse_val" type="hidden" id="strasse_val" value="<? echo($strasse_val); ?>">
        <input name="ort_val" type="hidden" id="ort_val" value="<? echo($ort_val); ?>">
        <input name="land_val" type="hidden" id="land_val" value="<? echo($land_val); ?>">
        <input name="email_val" type="hidden" id="email_val" value="<? echo($email_val); ?>">
        <input name="tel_val" type="hidden" id="tel_val" value="<? echo($tel_val); ?>">
        <input name="fax_val" type="hidden" id="anrede_val" value="<? echo($fax_val); ?>">
        <input name="anmerkung_val" type="hidden" id="anrede_val" value="<? echo($anmerkung_val); ?>">
		<input name="sprache_val" type="hidden" id="anrede_var" value="<? echo($sprache_val); ?>"> 
        <input name="plz_val" type="hidden" id="plz_val" value="<? echo($plz_val); ?>">
      </form>      
    </td>
  </tr>
</table>
<br/>
<table width="100%" border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <form action="../../../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
      <td width="1"><input type="submit" name="Submit3" value="<?php echo(getUebersetzung("Hauptmen�",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';"></td>
    </form>
  </tr>
</table>
<?php 			} //ende else	
			} //ende else
		} //ende passwortpr�fung 
	else{
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
		}
?>
</body>
</html>
