<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			best�tigung zum l�schen von zimmern von benutzer einholen!
*/

	//variablen intitialisieren:
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	$benutzername = getSessionWert(BENUTZERNAME);
	$passwort = getSessionWert(PASSWORT);
	$zimmer_pk_id = $_POST["zimmer_pk_id"];
	$sprache = getSessionWert(SPRACHE);

	//datenbank �ffnen:
	include_once("../../conf/rdbmsConfig.php");
	
	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once("../../include/unterkunftFunctions.php");
	include_once("../../include/gastFunctions.php");
	include_once("../../include/reservierungFunctions.php");
	include_once("../../include/zimmerFunctions.php");
	include_once("../../include/uebersetzer.php");
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<h3><?php echo(getUebersetzung("Löschung durchführen",$sprache,$link)); ?></h3>
 <?php //passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
?>
<div class="panel panel-default">
  <div class="panel-body">
<a class="btn btn-primary" href="./index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
</div>
</div>

<div class="panel panel-default">
  <div class="panel-body">
  	
<form action="./zimmerLoeschen.php" method="post" name="zimmerLoeschen" target="_self" id="zimmerLoeschen">	
<table border="0" cellpadding="0" cellspacing="3" class="frei">
  <tr>
    <td><p> 
	<?php 		
	 			
		//Reservierungen und Zimmer l�schen:
		$anzahl = count($zimmer_pk_id);
		$demoNotPossible = false;
		if (DEMO == true && $anzahl > 1){
			$anzahl--;
			$demoNotPossible = true;
		 	for($i = 0; $i < $anzahl; $i++){
				//zuerst mal die reservierungen raushauen:
				$query = ("DELETE FROM 
							Rezervi_Reservierung
	           			 	WHERE
	           				FK_Zimmer_ID = '$zimmer_pk_id[$i]'
			    ");          
	
				$res = mysql_query($query, $link);
				if (!$res) { 
					echo("die Anfrage $query scheitert"); 
				}
				//dann die zimmer
				$query = ("DELETE FROM 
							Rezervi_Zimmer
	           			 	WHERE
	           				PK_ID = '$zimmer_pk_id[$i]'
							and
							FK_Unterkunft_ID = '$unterkunft_id'
			    ");          
	
				$res = mysql_query($query, $link);
				if (!$res) { 
					echo("die Anfrage $query scheitert"); 
				}			
			} //ende for
			echo(getUebersetzung("Im Demo Modus kann das letzte Zimmer nicht gel�scht " .
					"werden",$sprache,$link));
		}
		else if (DEMO == true && $anzahl <= 1){
			echo(getUebersetzung("Im Demo Modus kann das letzte Zimmer nicht gel�scht " .
					"werden",$sprache,$link));
		}
		else if (DEMO != true){
			for($i = 0; $i < $anzahl; $i++){
				//zuerst mal die reservierungen raushauen:
				$query = ("DELETE FROM 
							Rezervi_Reservierung
	           			 	WHERE
	           				FK_Zimmer_ID = '$zimmer_pk_id[$i]'
			    ");          
	
				$res = mysql_query($query, $link);
				if (!$res) { 
					echo("die Anfrage $query scheitert"); 
				}
				//dann die zimmer
				$query = ("DELETE FROM 
							Rezervi_Zimmer
	           			 	WHERE
	           				PK_ID = '$zimmer_pk_id[$i]'
							and
							FK_Unterkunft_ID = '$unterkunft_id'
			    ");          
	
				$res = mysql_query($query, $link);
				if (!$res) { 
					echo("die Anfrage $query scheitert"); 
				}			
			} //ende for
			echo(getUebersetzung("Der/die/das Zimmer/Appartement/Wohnung/etc. " .
				"wurde samt seinen Reservierungen aus der Datenbank gel�scht",$sprache,$link));
		} 
		?>!</p>
      </td>
  </tr>
</table>
</form>
<br/>
<!-- <table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr> 
    <td><form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">

        <input name="retour2" type="submit" class="button200pxA" id="retour2" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zur�ck",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr> 
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">

        <input name="retour2" type="submit" class="button200pxA" id="retour2" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmen�",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table> -->
<?php 
	} //ende if passwortpr�fung
	else {
		echo(getUebersetzung("Bitte Browser schlie�en und neu anmelden - Passwortpr�fung fehlgeschlagen!",$sprache,$link));
	}
 ?>
</body>
</html>