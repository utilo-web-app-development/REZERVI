<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

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
$sprache = getSessionWert(SPRACHE);

	//datenbank öffnen:
	include_once("../../../conf/rdbmsConfig.php");
	//Unterkunft-funktionen einbeziehen:
	include_once("../../../include/unterkunftFunctions.php");
	include_once("../../../include/benutzerFunctions.php");
	include_once("../../../include/reservierungFunctions.php");
	include_once("../../../include/zimmerFunctions.php");
	//datum-funktionen einbeziehen:
	include_once("../../../include/datumFunctions.php");
    include_once("../../../include/uebersetzer.php");

//passwortprüfung:	
if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ 
	
/*   
	reservierungsplan
	daten des gastes aufnehmen
	author: christian osterrieder utilo.eu					
	
	dieser seite muss übergeben werden:
	Unterkunft PK_ID ($unterkunft_id)
	Zimmer PK_ID ($zimmer_id)
	Datum: $vonTag,$vonMonat,$vonJahr
		   $bisTag,$bisMonat,$bisJahr			
	
	die seite verwendet anfrage/send.php um das ausgefüllte
	formular zu versenden
*/ 	 
	
	//alle reservierungen im angegebenen zeitraum entfernen,
	//auch jene die diesen zeitraum "Überschneiden":
	$vonDatum = parseDateFormular($vonTag,$vonMonat,$vonJahr);
	$bisDatum = parseDateFormular($bisTag,$bisMonat,$bisJahr);
	
	//alle eintraege in diesem zeitraum löschen:
	deleteReservationWithDate($zimmer_id,$vonDatum,$bisDatum,$link);
	$resu = getChildRooms($zimmer_id);
	if (!empty($resu)){
		while ($d = mysqli_fetch_array($resu)){
			$child = $d['PK_ID'];
			deleteReservationWithDate($child,$vonDatum,$bisDatum,$link);			
		}	
	}
				
 ?>
<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?php echo(getUebersetzung("Reservierung Entfernen", $sprache, $link)); ?>
            </h3>
        </div>
        <div class="panel-body">

        </div>
    </div>
<form action="index.php" method="post" name="adresseForm" target="_self" id="adresseForm" >
  <table  border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td>
          <p>
          <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo($zimmer_id); ?>">
          <input name="monat" type="hidden" id="monat" value="<?php echo($vonMonat); ?>"> 
          <input name="jahr" type="hidden" id="jahr" value="<?php echo($vonJahr) ?>">
          <span class="frei">
              <?php echo(getUebersetzung("Die Reservierungen/Belegungen im geforderten Zeitraum wurden erfolgreich entfernt",$sprache,$link)); ?>!
          </span>
          </p>
        <table border="0" cellpadding="0" cellspacing="0" class="tableColor">
          <tr> 
            <td><?php echo(getUebersetzung("eingetragenes Datum",$sprache,$link)); ?>:</td>
            <td><?php echo(getUebersetzung("von",$sprache,$link)); ?> <?php echo($vonTag.".".$vonMonat.".".$vonJahr); ?> <?php echo(getUebersetzung("bis",$sprache,$link)); ?> <?php echo($bisTag.".".$bisMonat.".".$bisJahr);?> 
            </td>
          </tr>
          <tr> 
            <td><?php echo(getUebersetzung("Status",$sprache,$link)); ?>:</td>
            <td>
                <span class="<?php
					//status = 0: frei
					//status = 1: reserviert
					//status = 2: belegt
					if ($status == 0)
						echo("frei");
					elseif ($status == 1)
						echo("reserviert");
					elseif ($status == 2)
						echo("belegt");
				?>"> 
              <?php if ($status == 0)
		  				echo(getUebersetzung("frei",$sprache,$link));
					elseif ($status == 1)
						echo(getUebersetzung("reserviert",$sprache,$link));
					else 
						echo(getUebersetzung("belegt",$sprache,$link));
				?>
              </span>
            </td>
          </tr>
        </table>
        
      </td>
    </tr>
  </table>
  <br/>
  <table  border="0" cellspacing="3" cellpadding="0" class="table">
    <tr>
      <td><input type="submit" name="Submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>"> </td>
    </tr>
  </table>
 
  </form> 

<?php } //ende passwortprüfung 
else {
	echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
?>
<?php include_once("./templates/end.php"); ?>
