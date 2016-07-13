<? session_start();
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
	include_once("../../include/zimmerFunctions.php");	
	include_once("../templates/components.php"); 

	//variablen intitialisieren:
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	$benutzername = getSessionWert(BENUTZERNAME);
	$passwort = getSessionWert(PASSWORT);
	$sprache = getSessionWert(SPRACHE);
	$limit = 5; //limit wie viele bilder pro seite anzeigen
	if (isset($_POST["index"]) && $_POST["index"] != ""){
		$index = $_POST["index"];
	}
	else{
		$index = 0;
	}
			
?>

<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<script language="JavaScript">
	<!--
	    function sicher(){
	    	return confirm('<?php echo(getUebersetzung("Bild wirklich löschen?",$sprache,$link)); ?>'); 	    
	    }
	    //-->
</script>
<?php //passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){		
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
		<td>
			<table cellpadding="0" cellspacing="2" border="0">
			  <tr>
					<td><?php echo(getUebersetzung("Bild",$sprache,$link)); ?></td>
					<td><?php echo(getUebersetzung("Zimmer",$sprache,$link)); ?></td>
					<td><?php echo(getUebersetzung("Beschreibung",$sprache,$link)); ?></td>
					<td><div align="center"><?php echo(getUebersetzung("löschen",$sprache,$link)); ?></div></td>
				</tr>
			<?php 
				$res = getAllPicturesFromUnterkunftWithLimit($unterkunft_id,$limit,$index,$link);
				while ($d=mysql_fetch_array($res)){
					$bild = $d["Pfad"];
					$zimmer = $d["Zimmernr"];
					$description = $d["Beschreibung"];
			?>
			  	  <tr>
					  <td><img src="<?php echo($bild); ?>" /></td>
					  <td><?php echo($zimmer); ?></td>
					   <td><?php echo($description); ?></td>
					  <td><form action="./bilderLoeschenDurchf.php" 
					  			method="post" name="zimmerloeschen<?php echo($d["PK_ID"]); ?>" 
								target="_self" onSubmit="return sicher()" 
								enctype="multipart/form-data">
			  				<input type="hidden" name="bilder_id" value="<?php echo($d["PK_ID"]); ?>"/>
			  				<input type="hidden" name="index" value="<?php echo($index); ?>"/>
			  				<input name="Submit" type="submit" id="Submit" class="button200pxA" 
								onMouseOver="this.className='button200pxB';"
       							onMouseOut="this.className='button200pxA';"
								value="<?php echo(getUebersetzung("Bild löschen",$sprache,$link)); ?>">
						 </form>
					  </td>
				  </tr>			
			<?php
			}
			?>
			  </table>
		</td>
    </tr>
	<tr> 
      <td>
		<table>
			<tr>
			<?php
			if (($index - $limit) > -1){
			?>
				<td>
					<form action="./bilderLoeschen.php" method="post" name="zurueck" target="_self" enctype="multipart/form-data">
					<input name="index" type="hidden" value="<?php echo($index-$limit); ?>"/>
					<?php 
	  					showSubmitButton(getUebersetzung("zurückblättern",$sprache,$link));
					?>
					</form>
				</td>
			<?php
			}
			if (($index + $limit) < getAnzahlBilder($unterkunft_id,$link)){
			?>
				<td><form action="./bilderLoeschen.php" method="post" name="weiter" target="_self" enctype="multipart/form-data">
					<input name="index" type="hidden" value="<?php echo($index+$limit); ?>"/>
					<?php 
	  					showSubmitButton(getUebersetzung("weiterblättern",$sprache,$link));
					?>
					</form>
				</td>
			<?php
			}
			?>
			</tr>
		</table>
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
