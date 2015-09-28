<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung der reservierung f�r den benutzer
			author: christian osterrieder utilo.eu						
			
			dieser seite muss �bergeben werden:
			Benutzer PK_ID $benutzer_id
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
include_once("../../include/gastFunctions.php");
include_once("../../include/reservierungFunctions.php");
include_once("../../include/propertiesFunctions.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/autoResponseFunctions.php");
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<script language="JavaScript">
	<!--
	    function sicher(){
	    	return confirm("<?php echo(getUebersetzung("Anfrage wirklich löschen?",$sprache,$link)); ?>"); 	    
	    }
	//-->
</script>
<?php include_once("../templates/bodyA.php"); ?>
<?php //passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
<div class="panel panel-default">
  <div class="panel-body">
  	
<h1><?php echo(getUebersetzung("Reservierungsanfragen von Gästen bestätigen/löschen",$sprache,$link)); ?></h1>
<table width="100%" border="0" cellpadding="0" cellspacing="3" class="tableColor">
  <tr>
    <td><p><?php echo(getUebersetzung("Hier sehen Sie die Liste mit noch nicht bestätigten bzw. gelöschten Reservierungsanfragen.",$sprache,$link)); ?><br/>
        <?php echo(getUebersetzung("Falls Sie eine Reservierungsanfrage bestätigen wird diese als belegt im Reservierungsplan eingetragen, der Gast wird darüber nur informiert wenn die automatischen E-Mails aktiviert wurden.",$sprache,$link)); ?><br/>
        <?php echo(getUebersetzung("Bei Löschung einer Reservierungsanfrage bleiben die Informationen des Gastes in der Datenbank erhalten, wollen Sie auch den Gast löschen, bestätigen Sie dies bitte mit dem entsprechenden Feld.",$sprache,$link)); ?>
		<?php echo(getUebersetzung("Ein Gast kann nur gelöscht werden, falls es keine anderen Reservierungen für diesen Gast gibt.",$sprache,$link)); ?>
    </td>
  </tr>
</table>
<p>
  <?php 
  	  //sodala, nun alle reservierungen mit status=1 auslesen, wenn
	  //keine vorhanden dann hinweis an benutzer geben:
	  $query = ("SELECT 
					r.*
					FROM
					Rezervi_Reservierung r, Rezervi_Zimmer z
					WHERE
					z.FK_Unterkunft_ID = '$unterkunft_id' and
					z.PK_ID = r.FK_Zimmer_ID and
					r.Status = 1" .
							" order by r.Datum_von				
				");

  	$res = mysql_query($query, $link);
	if (!$res) {
		echo("die Anfrage scheitert");
	}
	else {
		$leer = true;	
		//array to store reservierungs ids that are already taken:
		$idArray = array();
		while($d = mysql_fetch_array($res)){
			$leer = false;
			$reservierungs_id = $d["PK_ID"];
			$gast_id = getGastID($reservierungs_id,$link);
			//wenn zimmer einen parent hat nicht anzeigen -> parent wird ja bereits angezeigt:
			$zi_id = getZimmerID($reservierungs_id,$link);
			if (hasParentSameReservation($reservierungs_id)){
				continue;
			}
			//check if this reservation already printed:
			foreach ($idArray as $idTaken){
				if ($idTaken == $reservierungs_id){
					continue 2;
				}
			}
			$reservierungen = "".$reservierungs_id;			
	?>
</p>
<table border="0" cellspacing="0" cellpadding="0" class="tableColor">
        <tr>
          <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Anfrage von",$sprache,$link)); ?>:</span> <?php echo(getGuestVorname($gast_id,$link)." ".getGuestNachname($gast_id,$link)); ?></td>
        </tr>
        <tr>
          <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Zeitraum",$sprache,$link)); ?>:</span> von <?php echo(getDatumVon($reservierungs_id,$link)); ?> bis <?php echo(getDatumBis($reservierungs_id,$link)); ?></td>
        </tr>
         <?php
          //print all rooms with this reservation:
          $query2 = ("SELECT 
					r.PK_ID
					FROM
					Rezervi_Reservierung r, Rezervi_Zimmer z
					WHERE
					z.FK_Unterkunft_ID = '$unterkunft_id' and
					z.PK_ID = r.FK_Zimmer_ID and
					r.Status = 1 and " .
							" r.FK_Gast_ID = '".$d["FK_Gast_ID"]."' and " .
							" r.Datum_von = '".$d["Datum_von"]."' and " .
							" r.Datum_bis = '".$d["Datum_bis"]."' and " .
							" r.ANFRAGEDATUM = '".$d["ANFRAGEDATUM"]."'");

	  	$res2 = mysql_query($query2, $link);
		if (!$res2) {
			echo("die Anfrage scheitert");
			echo(mysql_error());
			echo($query);
		}
		else {	
			while($d2 = mysql_fetch_array($res2)){
				$reservierungs_id2 = $d2["PK_ID"];
				if (hasParentSameReservation($reservierungs_id2)){
					continue;
				}	
				//check if this reservation already printed:
				foreach ($idArray as $idTaken){
					if ($idTaken == $reservierungs_id2){
						continue 2;
					}
				}
				$idArray[] = $reservierungs_id2;
				
				$gast_id2 = getGastID($reservierungs_id2,$link);
				//wenn zimmer einen parent hat nicht anzeigen -> parent wird ja bereits angezeigt:
				$zi_id2 = getZimmerID($reservierungs_id2,$link);
				if ($reservierungs_id2 != $reservierungs_id){
					$reservierungen .= ",".$reservierungs_id2;
				}
	        ?>
	        <tr>
	          <td>
	          	<span class="standardSchriftBold">
	          		<?php echo(getUebersetzungUnterkunft(getZimmerArt($unterkunft_id,getZimmerID($reservierungs_id2,$link),$link),$sprache,$unterkunft_id,$link)); ?>:
	          	</span> 
	          	<?php echo(getZimmerNr($unterkunft_id,getZimmerID($reservierungs_id2,$link),$link)); ?>
	          </td>
	        </tr>
	        <?php
			}
		}
        ?>
        <tr>
          <td><span class="standardSchriftBold"><?php echo(getUebersetzung("Personen",$sprache,$link)); ?>:</span> <?php echo(getUebersetzung("Erwachsene",$sprache,$link)); ?>:<?php echo(getErwachsene($reservierungs_id,$link)); ?> <?php echo(getUebersetzung("Kinder",$sprache,$link)); ?>: <?php echo(getKinder($reservierungs_id,$link)); ?></td>
        </tr>
        <?php
        if (getPropertyValue(PENSION_FRUEHSTUECK,$unterkunft_id,$link) == "true"
        	||
        	getPropertyValue(PENSION_UEBERNACHTUNG,$unterkunft_id,$link) == "true"
        	||
        	getPropertyValue(PENSION_VOLL,$unterkunft_id,$link) == "true"
        	||
        	getPropertyValue(PENSION_HALB,$unterkunft_id,$link) == "true"
        ){
        ?>
        <tr>
          <td><span class="standardSchriftBold">Pension: </span><?= getPension($reservierungs_id,$link) ?></td>
        </tr>	
        <?php
		}
		?>	
        <form action="./gastInfo/index.php" method="post" name="gastInfos" target="_self" id="gastInfos">
          <tr>
            <td><input name="gast_id" type="hidden" value="<?php echo($gast_id); ?>">
              <input name="gastInfos" type="submit" id="gastInfos" value="<?php echo(getUebersetzung("Gast-Infos anzeigen",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';"></td>
          </tr>
        </form>
        <form action="./anfrageLoeschen.php" method="post" name="reservierungEntfernen" target="_self" id="reservierungEntfernen" onSubmit="return sicher()">
          <tr>
            <td><input name="gast_id" type="hidden" value="<?php echo($gast_id); ?>">
              <input name="reservierungs_id" type="hidden" value="<?php echo($reservierungen); ?>">
              <input name="entfernen" type="submit" id="entfernen" value="<?php echo(getUebersetzung("Anfrage l�schen",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';">
              <input name="gastEntfernen" type="checkbox" id="gastEntfernen" value="true">
              <?php echo(getUebersetzung("Gast aus Datenbank l�schen",$sprache,$link)); ?>
              <?php
			  //automatische absage mu� hier nochmals best�tigt werden,
			  //allerdings nur wenn sie auch aktiv ist:
			  if (isMessageActive($unterkunft_id,"ablehnung",$link)){
			  ?>
				  <input name="antwort" type="checkbox" id="antwort" value="true" checked>
				  <input name="art" type="hidden" value="ablehnung">
				  <?php echo(getUebersetzung("automatische Absage senden",$sprache,$link)); ?>
              <?php
			  }
			  ?>
            </td>
          </tr>
        </form>
        <form action="./anfrageBestaetigen.php" method="post" name="reservierungBestaetigen" target="_self" id="reservierungBestaetigen">
          <tr>
            <td><input name="reservierungs_id" type="hidden" value="<?php echo($reservierungen); ?>">
              <input type="submit" name="submit" value="<?php echo(getUebersetzung("Anfrage best�tigen",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';">
              <?php
               if (isMessageActive($unterkunft_id,"bestaetigung",$link)){
			  ?>
				  <input name="antwort" type="checkbox" id="antwort" value="true" checked>
				  <input name="art" type="hidden" value="bestaetigung">
				  <?php echo(getUebersetzung("automatische Best�tigung senden",$sprache,$link)); ?>
              <?php
			  }
			  ?>
            </td>
          </tr>
        </form>
      </table>
<?php	
		$idArray[] = $reservierungs_id;
		}//ende while
	}//ende else
	?>
<?php
//es sind keine anfragen vorhanden:
if ($leer == true){  ?>
<table width="100%" border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><p><?php echo(getUebersetzung("Es sind keine offenen Reservierungsanfragen vorhanden",$sprache,$link)); ?>!</p>
      <!-- <form action="../inhalt.php" method="post" name="form1" target="_self">
        <input type="submit" name="Submit" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';"> -->
       <a class="btn btn-primary" href="../inhalt.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
     
      </form></td>
  </tr>
</table>
<?php } 
	else { //zur�ck-button anzeigen: 
?>
<br/>
<table width="100%" border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="form1" target="_self">
        <input type="submit" name="Submit3" value="<?php echo(getUebersetzung("Hauptmen�",$sprache,$link)); ?>" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';">
      </form></td>
  </tr>
</table>
<?php } //ende else
 ?>
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
	}
?>
</body>
</html>