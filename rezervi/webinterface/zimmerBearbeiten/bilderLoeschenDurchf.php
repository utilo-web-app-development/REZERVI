<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

/*   
			reservierungsplan
			hochladen eines bilder fuer ein zimmer
			author: coster
			date: 18.8.05
*/

	//datenbank öffnen:
	include_once("../../conf/rdbmsConfig.php");
	
	//andere funktionen importieren:
	include_once("../../include/benutzerFunctions.php");
	include_once("../../include/unterkunftFunctions.php");
	include_once("../../include/uebersetzer.php");
	include_once("../../include/bildFunctions.php");
	include_once("../templates/components.php"); 

	//variablen intitialisieren:
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	$benutzername = getSessionWert(BENUTZERNAME);
	$passwort = getSessionWert(PASSWORT);
	$sprache = getSessionWert(SPRACHE);
	$index = $_POST["index"];
	$bilder_id = $_POST["bilder_id"];
			
?>

<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>

<?php //passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){		
		
		$pfad = getBildPfad($bilder_id,$link);	
		deleteBild($bilder_id,$link);
		$fehler = true;
		$nachricht = "Das Bild konnte nicht gelöscht werden.";
		
		if (file_exists ( $pfad )){
			unlink($pfad);
			$nachricht = "Das Bild wurde erfolgreich gelöscht.";
			$fehler = false;
		}
		
		$nachricht = getUebersetzung($nachricht,$sprache,$link);
	
?>
  <table border="0" cellpadding="0" cellspacing="3" class="table">
    <tr class="table"> 
      <td>
	  	<p class="standardSchriftBold"><?php echo(getUebersetzung("Bilder für Zimmer/Appartement/Wohnung/etc. löschen",$sprache,$link)); ?><br/>
          </p>
      </td>
    </tr>
	<?php
	if (isset($nachricht) && $nachricht != ""){
	?>
	<tr> 
      <td height="30"  
	  <?php 
	  	if ($fehler == true) {
	  ?>
	  	class="belegt"
	  <?php		
	  	}
	  else { 
	  ?>
	  	class="frei"
	  <?php
	  } 
	  ?>
	  ><?php echo($nachricht); ?>
	  </td>
    </tr>
    <?php
	}
	?>
	<tr> 
      <td><form action="./bilderLoeschen.php" method="post" name="weiter" target="_self" enctype="multipart/form-data">
			<input name="index" type="hidden" value="<?php echo($index); ?>"/>
			<?php 
				showSubmitButton(getUebersetzung("weitere Bilder löschen",$sprache,$link));
			?>
		  </form>
      </td>
    </tr>
  </table>
<br/>
<?php 
	  //-----buttons um zurück zu gelangen: 
	  showSubmitButtonWithForm("./index.php",getUebersetzung("zurück",$sprache,$link));
?>
<br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../inhalt.php",getUebersetzung("Hauptmenü",$sprache,$link));
?>
<p></td> </tr> </table> </p>  
<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>   
 <?php include_once("../templates/end.php"); ?>
