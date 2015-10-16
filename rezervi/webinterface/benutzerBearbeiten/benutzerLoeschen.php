<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			best�tigung zum l�schen von zimmern von benutzer einholen!
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
//$id = $_POST["id"];
$sprache = getSessionWert(SPRACHE);

	//datenbank �ffnen:
	include_once("../../conf/rdbmsConfig.php");
	
	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once("../../include/unterkunftFunctions.php");
	include_once("../../include/gastFunctions.php");
	include_once("../../include/reservierungFunctions.php");
	include_once("../../include/zimmerFunctions.php");
	//uebersetzer einfuegen:
	include_once("../../include/uebersetzer.php");
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<h3><?php echo(getUebersetzung("Löschung bestätigen",$sprache,$link)); ?></h3>
 <?php //passwortpr�fung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
		$benutzer_id = getUserId($benutzername,$passwort,$link);
?>
<div class="panel panel-default">
  <div class="panel-body">
<a class="btn btn-primary" href="./index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
</div>
</div>

<div class="panel panel-default">
  <div class="panel-body">

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
		  
		   while($d = mysql_fetch_array($res)) {
	 		
			if ($d["PK_ID"] == $benutzer_id) continue;
			if ($d["PK_ID"] == 1 && DEMO == true) continue;
						
			if (isset($_POST["user_".$d["PK_ID"]])){
			
				$query = ("DELETE FROM 
							Rezervi_Benutzer
	           			 	WHERE
	           				PK_ID = ".$d["PK_ID"]);          
	
				$res = mysql_query($query, $link);
				if (!$res) { 
					echo("die Anfrage $query scheitert"); 
				}	
			
			}		
		} //ende for
		
    }
	?>
	
	<div class="alert alert-success" role="alert">
		<?php echo(getUebersetzung("Der Benutzer wurde aus der Datenbank gelöscht!",$sprache,$link)); ?></p>
	</div>
	
	

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
	?>
		<div class="alert alert-danger" role="alert">
		<?php echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link)); ?>
		</div>		
 <?php	}
 ?>
</body>
</html>
