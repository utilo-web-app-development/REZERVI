<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			bestätigung zum löschen von zimmern von benutzer einholen!
*/

	//variablen intitialisieren:
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	$benutzername = getSessionWert(BENUTZERNAME);
	$passwort = getSessionWert(PASSWORT);
	$zimmer_id = $_POST["zimmer_id"];
	$sprache = getSessionWert(SPRACHE);

	//datenbank öffnen:
	include_once("../../conf/rdbmsConfig.php");
	
	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once("../../include/unterkunftFunctions.php");
	include_once("../../include/gastFunctions.php");
	include_once("../../include/reservierungFunctions.php");
	include_once("../../include/zimmerFunctions.php");
	include_once("../../include/uebersetzer.php");
	
		//wurde auch ein zimmer ausgewählt?
	if (!isset($zimmer_id) || $zimmer_id == ""){
		$fehler = true;
		$nachricht = "Bitte wählen sie ein Zimmer aus!";
		$nachricht = getUebersetzung($nachricht,$sprache,$link);
		include_once("./index.php");
		exit;
	}
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>

<!-- <p class="standardSchriftBold"><?php echo(getUebersetzung("Löschung bestätigen",$sprache,$link)); ?></p> -->
<h1><?php echo(getUebersetzung("Löschung bestätigen",$sprache,$link)); ?></h4>
<!-- <form action="./zimmerLoeschen.php" method="post" name="zimmerLoeschen" target="_self" id="zimmerLoeschen">	 -->
	<div class="panel panel-default">
  <div class="panel-body">
	 <a class="btn btn-primary" href="./index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
	</div>
	</div>
	<div class="panel panel-default">
  <div class="panel-body">
  	<form action="./zimmerLoeschen.php" method="post" name="zimmerLoeschen" target="_self" onSubmit="return chkFormular();" class="form-horizontal">
  		
<h4><?php echo(getUebersetzung("Folgende Zimmer/Appartements/Wohnungen/etc. werden aus der Datenbank entfernt",$sprache,$link)); ?>.</h4>
<h5><?php echo(getUebersetzung("Bitte beachten Sie, dass damit auch alle Reservierungen die diese(s) Zimmer/Appartement/Wohnung/etc. betreffen ebenfalls entfernt werden",$sprache,$link)); ?>!</h5>

	      <!-- <select name="zimmer_pk_id[]" size="5" multiple>
		  	<?php 
				$anzahl = count($zimmer_id);				
	  			for($i = 0; $i < $anzahl; $i++){ 
				$temp = $zimmer_id[$i];
				?>
            <option value="<? echo($temp); ?>" selected><?php echo(getUebersetzungUnterkunft(getZimmerNr($unterkunft_id,$temp,$link),$sprache,$unterkunft_id,$link)); 
            ?></option>
			<?php 
				} //ende for
			?>
          </select> -->
          <select name="zimmer_pk_id[]" type="text" id="zimmer_pk_id[]"  class="form-control">
          	<?php 
				$anzahl = count($zimmer_id);				
	  			for($i = 0; $i < $anzahl; $i++){ 
				$temp = $zimmer_id[$i];
				?>
            <option value="<? echo($temp); ?>" selected><?php echo(getUebersetzungUnterkunft(getZimmerNr($unterkunft_id,$temp,$link),$sprache,$unterkunft_id,$link)); 
            ?></option>
			<?php 
				} //ende for
			?>
		 </select>
          
	  </p>
        <p><?php echo(getUebersetzung("Nur die hier selektierten Zimmer/Appartements/Wohnungen/etc. werden gelöscht.",$sprache,$link)); ?> 
		<?php echo(getUebersetzung("Entfernen Sie die Markierungen (mit [STRG] und Mausklick) die nicht gelöscht werden sollen!",$sprache,$link)); ?></p>
		         
       <input name="retour" type="submit" class="btn btn-success" id="retour" value="<?php echo(getUebersetzung("weiter",$sprache,$link)); ?>">         
        		



</form>
<br/>
    	<!-- <form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">
<input name="retour2" type="submit" class="button200pxA" id="retour2" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
      </form></td> -->
       





 <!-- <form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">

        <input name="retour2" type="submit" class="button200pxA" id="retour2" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>">
      </form></td> -->
  

</body>
</html>
