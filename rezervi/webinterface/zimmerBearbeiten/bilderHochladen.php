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
	include_once("../../include/einstellungenFunctions.php");
	include_once("../../include/zimmerFunctions.php");	
	include_once("../templates/components.php"); 

	//variablen intitialisieren:
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
	$benutzername = getSessionWert(BENUTZERNAME);
	$passwort = getSessionWert(PASSWORT);
	$zimmer_id = $_POST["zimmer_id"];
	$sprache = getSessionWert(SPRACHE);
	$standardsprache = getStandardSprache($unterkunft_id,$link);
	
	if (!is_writable($root."/upload")){
		$nachricht = "Achtung! Das Verzeichnis 'upload' ist nicht beschreibbar, Sie können erst Bilder hochladen wenn Sie diesem Verzeichnis Schreibrechte zuweisen!";
		$nachricht = getUebersetzung($nachricht,$sprache,$link);
		$fehler = true;
	}	
			
?>

<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>

<?php //passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){		
?>

<form action="./bilderHochladenDurchfuehren.php" method="post" name="zimmerEintragen" target="_self" enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="3" class="table">
    <tr class="table"> 
      <td colspan="2"><p class="standardSchriftBold"><?php echo(getUebersetzung("Bilder für Zimmer/Appartement/Wohnung/etc. hochladen",$sprache,$link)); ?><br/>
          <span class="standardSchrift"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.",$sprache,$link)); ?> 
          <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden",$sprache,$link)); ?>!</span></p>
      </td>
    </tr>
	<?php
	if (isset($nachricht) && $nachricht != ""){
	?>
	<tr> 
      <td height="30" colspan="2" 
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
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
 	<tr>
		<td><span class="standardSchrift"><?php echo(getUebersetzung("Zimmer",$sprache,$link)); ?>*</span></td>
		<td><select name="zimmer_id" id="zimmer_id">
          <?php	
			 $res = getZimmer($unterkunft_id,$link);
			  //zimmer ausgeben:
			  while($d = mysql_fetch_array($res)) {
				$ziArt = getUebersetzungUnterkunft($d["Zimmerart"],$sprache,$unterkunft_id,$link);
				$ziNr  = getUebersetzungUnterkunft($d["Zimmernr"],$sprache,$unterkunft_id,$link);
				?>
					<option value="<?php echo($d["PK_ID"]); ?>" 
							<?php if (isset($zimmer_id) && ($zimmer_id == $d["PK_ID"])){
							?>
								selected="selected"
							<?php
							}
							?>
							><?php echo($ziArt." ".$ziNr); ?>
							</option>
				<?php 
			  } //ende while 
			 ?>
        </select></td>
	</tr>
	<tr>
		<td><span class="standardSchrift"><?php echo(getUebersetzung("Bild",$sprache,$link)); ?>*</span></td>
		<td><input name="bild" type="file"></td>
	</tr>
	<?php
	$spr = getSprachenForBelegungsplan($link);
	while ($s = mysql_fetch_array($spr)){
	?>
	<tr>
		<td>
			<span class="standardSchrift">
				<?php echo(getUebersetzung("Beschreibung",$sprache,$link)); ?>&nbsp;
				<?= getUebersetzung($s['Bezeichnung'],$sprache,$link) ?>
				<?php if ($s['Sprache_ID'] == $standardsprache) { ?> 
					*
				<?php } ?>
			</span>
		</td>
		<td>
			<textarea name="beschreibung_<?= $s['Sprache_ID'] ?>" cols="50" rows="3"></textarea>
		</td>
	</tr>
	<?php
	}
	?>
    <tr class="table"> 
      <td colspan="2">
        <input name="Submit" type="submit" id="Submit" class="button200pxA" onMouseOver="this.className='button200pxB';"
       onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Bild hochladen",$sprache,$link)); ?>"></td>
    </tr>
  </table>
</form>
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
