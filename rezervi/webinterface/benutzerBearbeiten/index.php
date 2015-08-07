<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan rezervi
			author: christian osterrieder utilo.eu						

*/

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

	//datenbank �ffnen:
	include_once("../../conf/rdbmsConfig.php");
	
	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once("../../include/unterkunftFunctions.php");
	//uebersetzer einfuegen:
	include_once("../../include/uebersetzer.php");

			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php //passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>

<form action="./benutzerAendern.php" method="post" name="zimmerAendern" target="_self">
  <table border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td><p class="standardSchriftBold"><?php echo(getUebersetzung("Benutzer bearbeiten",$sprache,$link)); ?>
			<br />        
        <span class="standardSchrift"><?php echo(getUebersetzung("Bitte w�hlen Sie den zu ver�ndernden Benutzer aus",$sprache,$link)); ?>:</span></p></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><select name="id" size="5" id="id">
          <?php
		
		//benutzer auslesen:
		$query = "select 
				  PK_ID, Name
				  from 
				  Rezervi_Benutzer
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				  ORDER BY 
				  Name";
	
		 $res = mysql_query($query, $link);
		 if (!$res){
			echo("die Anfrage $query scheitert.");
		 }
		 else{
		  //benutzer ausgeben:
		  $i = 0;
			  while($d = mysql_fetch_array($res)) {?>
          		<option value="<?php echo($d["PK_ID"]); ?>" 
          			<?php if ($i == 0) echo(" selected"); $i++; ?>> 
          			<?php echo($d["Name"]); ?> </option>
          	  <?php
			  } //ende while
			} //ende else
		 //ende benutzer ausgeben    
		 ?>
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input name="benutzerAendern" type="submit" id="benutzerAendern" class="button200pxA" onMouseOver="this.className='button200pxB';"
		   onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Benutzer �ndern",$sprache,$link)); ?>"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php
//-------------ende benutzer �ndern
/*
//-------------benutzer l�schen
pr�fen ob benutzer �berhaupt vorhanden sind 
*/
if (getAnzahlVorhandeneBenutzer($unterkunft_id,$link) > 1){
?>
<form action="./benutzerLoeschenBestaetigen.php" method="post" name="benutzerLoeschen" target="_self">
  <table border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td><p class="standardSchriftBold"><?php echo(getUebersetzung("Benutzer l�schen",$sprache,$link)); ?><br/>
          <span class="standardSchrift"><?php echo(getUebersetzung("Bitte w�hlen Sie den zu l�schenden Benutzer aus",$sprache,$link)); ?>. 
		  <?php echo(getUebersetzung("Sie k�nnen mehrere Benutzer zugleich ausw�hlen und l�schen indem Sie die [STRG]-Taste gedr�ckt halten und auf die Benutzernamen klicken",$sprache,$link)); ?>.</span></p></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><select name="id[]" size="5" multiple id="select">
          <?php 
		  		//benutzer auslesen:
		$query = "select 
				  PK_ID, Name, Passwort
				  from 
				  Rezervi_Benutzer
				  where
				  FK_Unterkunft_ID = '$unterkunft_id'
				  ORDER BY 
				  Name";
	
		 $res = mysql_query($query, $link);
		 if (!$res)
			echo("die Anfrage $query scheitert.");
		 else{     
		  	$i = 0;
			  while($d = mysql_fetch_array($res)) {
			  //selbst nicht loeschen!
			  if ($d["Name"] == $benutzername && $d["Passwort"] == $passwort){
			  	continue;
			  }	
			  ?>
          		<option value="<?php echo($d["PK_ID"]); ?>" 
          			<?php if ($i == 0) echo(" selected"); $i++; ?>> 
          			<?php echo($d["Name"]); ?></option>
          	  <?php
			  } //ende while
		  }	  
		 ?>
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input name="benutzerLoeschen" type="submit" id="benutzerLoeschen" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Benutzer l�schen",$sprache,$link)); ?>"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php
} //ende anzahlBenutzer ist ok
?>
<form action="./benutzerAnlegen.php" method="post" name="benutzerAnlegen" target="_self">
  <table border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Benutzer anlegen",$sprache,$link)); ?></span><br/>
        <?php echo(getUebersetzung("Klicken Sie auf den Button [Benutzer anlegen] um einen neuen Benutzer hinzuzuf�gen",$sprache,$link)); ?>.</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input name="benutzerAnlegenButton" type="submit" id="benutzerAnlegenButton" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Benutzer anlegen",$sprache,$link)); ?>"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
        <input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmen�",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table>
<p> </p>
<p>
  <?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
	}
 ?>
</body>
</html>
