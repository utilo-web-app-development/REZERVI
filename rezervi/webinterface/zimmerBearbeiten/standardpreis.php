<?php
/**
 * Created on 19.01.2007
 *
 * @author coster
 * preise hinzufügen löschen ändern
 */

session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
include_once("../../conf/rdbmsConfig.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/priceFunctions.inc.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/benutzerFunctions.php");
include_once($root."/include/propertiesFunctions.php");
include_once($root."/include/datumFunctions.php");

//variablen intitialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$benutzername = getSessionWert(BENUTZERNAME);
$passwort = getSessionWert(PASSWORT);
$sprache = getSessionWert(SPRACHE);

include_once("../templates/headerA.php");
?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<script type="text/javascript" src="<?php echo($root); ?>/templates/calendarDateInput.inc.php?root=<?php echo $root ?>&sprache="<?php echo $sprache ?>">
	/***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/
</script>
<?php
include_once("../templates/headerB.php");
include_once("../templates/bodyA.php");

//passwortprüfung:	
if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){

//generiert das heutige datum für den date picker:
$startdatumDP = getTodayDay()."/".parseMonthNumber(getTodayMonth())."/".getTodayYear();

$sizeRoomSelectBox = getAnzahlVorhandeneZimmer($unterkunft_id,$link);
if ($sizeRoomSelectBox > 5){
	$sizeRoomSelectBox = 5;
}
?>
<div class="panel panel-default">
  <div class="panel-body">
  	<a class="btn btn-primary" href="./index.php">
	<span class="glyphicon glyphicon-menu-left" ></span>
	<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>
	</a>
 </div>
</div>
   <div class="panel panel-default">
  <div class="panel-body">

<h1>
<?php echo getUebersetzung("Preise hinzufügen, ändern, löschen",$sprache,$link) ?>.
</h1>
<h4>
	<?php
	$text = "Definieren sie hier für jedes Mietobjekt einen Standardpreis. Wird " .
			"bei der Berechnung des Preises kein Preis für eine Saison gefunden, dann " .
			"wird dieser Preis zur Preisberechnung herangezogen.";
	?>
	<?php echo getUebersetzung($text,$sprache,$link) ?>
</h4>
</br>
</br>
<?php
if (isset($nachricht) && $nachricht != ""){
?>
<div class="alert alert-info" role="alert"

	  <?php if (isset($fehler) && $fehler == false) {echo("class=\"frei\""); }
			else {echo("class=\"belegt\"");} ?>>
				<?php echo $nachricht ?>

</div>
	<br/>
<?php
}
?>
<form action="./standardPreisAendern.inc.php" method="post" target="_self">
<table border="0" cellpadding="0" cellspacing="3" class="table">
	<tr>
		<td>
			<?php echo getUebersetzung("Preis",$sprache,$link) ?>
		</td>
		<td>
			<?php echo getUebersetzung("Mietobjekt",$sprache,$link) ?>
		</td>
		<td>
		</td>
	</tr>
<?php
	//alle bestehenden attribute auslesen:
	$res = getStandardPrices($unterkunft_id,$link);
	while ($d = mysql_fetch_array($res)){
		$preis_id 	= $d["PK_ID"];
		$preis		= $d["Preis"];
?>
		<tr>
			<td>
				<input class="form-control" type="text" name="preis_<?php echo $preis_id ?>" value="<?php echo $preis ?>"/>
			</td>
			<td>
			<select class="form-control" name="zimmer_<?php echo $preis_id ?>[]" size="<?php echo $sizeRoomSelectBox ?>"
				multiple="multiple" id="zimmer_<?php echo $preis_id ?>">
          	<?php
          	 $res3 = getZimmer($unterkunft_id,$link);
				  while($g = mysql_fetch_array($res3)) {
					$ziArt = getUebersetzungUnterkunft($g["Zimmerart"],$sprache,$unterkunft_id,$link);
					$ziNr  = getUebersetzungUnterkunft($g["Zimmernr"],$sprache,$unterkunft_id,$link);
					?>
					<option value="<?php echo $g["PK_ID"] ?>"
						<?php
						$res2 = getZimmerForPrice($preis_id);
						while($r = mysql_fetch_array($res2)) {
							if ($r["PK_ID"] == $g["PK_ID"]){
						?>
							selected="selected"
						<?php
							}
					    }
						?>
					>
						<?php echo $ziArt." ".$ziNr ?>
					</option>
					<?php
				  } //ende while
			 ?>
        	</select>
			</td>
			<td>
			    <input  name="loeschen_<?php echo $preis_id ?>"
                    type="submit" id="loeschen_<?php echo $preis_id ?>"
      				class="btn btn-danger"
       				value="<?php echo(getUebersetzung("löschen",$sprache,$link)); ?>" />
			</td>
		</tr>
<?php
	} //ende while attribute
?>
	<tr valign="top">
		<td>
			<input class="form-control" type="text" name="preis_neu" />
		</td>
		<td>
		<select class="form-control" name="zimmer_id_neu[]" size="<?php echo $sizeRoomSelectBox ?>"
			multiple="multiple" id="zimmer_id_neu">
          <?php
			 $res = getZimmer($unterkunft_id,$link);
			  //zimmer ausgeben:
			  $i = 0;
				  while($d = mysql_fetch_array($res)) {
					$ziArt = getUebersetzungUnterkunft($d["Zimmerart"],$sprache,$unterkunft_id,$link);
					$ziNr  = getUebersetzungUnterkunft($d["Zimmernr"],$sprache,$unterkunft_id,$link);
					?>
					<option value="<?php echo $d["PK_ID"] ?>"<?php
						if ($i == 0){
						?>
							selected="selected"
						<?php
						}
						$i++;
						?>
						>
						<?php echo $ziArt." ".$ziNr ?>
					</option>
					<?php
				  } //ende while
			 //ende zimmer ausgeben
			 ?>
        </select>
		</td>
		<td>
		    <input
  				name="hinzufuegen" type="submit" id="hinzufuegen"
  				class="btn btn-success"
   				value="<?php echo(getUebersetzung("hinzufügen",$sprache,$link)); ?>" />
		</td>
	</tr>
</table>

                    <div class="form-group">
                        <div class="col-sm-offset-10 col-sm-2" style="margin-left: 86.333333%;">
                            <input
                                    name="aendern" type="submit" id="aendern"
                                    class="btn btn-success"
                                    value="<?php echo(getUebersetzung("speichern",$sprache,$link)); ?>" />
                        </div>
                    </div>



</form>
</br>

     	<!-- <form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">
		<input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 	onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
  		</form> -->


<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <!-- <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">
	<input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>">
  </form></td> -->
  </tr>
</table>
<?php
}
else {
	echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
}
?>
</body>
</html>
