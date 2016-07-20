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
?>
<div class="panel panel-default">
<div class="panel-heading">
    <h2>
        <?php echo getUebersetzung("Preise hinzufügen, ändern, löschen",$sprache,$link) ?>.
    </h2>
</div>
  <div class="panel-body">
<?php
//passwortprüfung:	
if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){
	
//generiert das heutige datum für den date picker:
$startdatumDP = getTodayDay()."/".parseMonthNumber(getTodayMonth())."/".getTodayYear();

$sizeRoomSelectBox = getAnzahlVorhandeneZimmer($unterkunft_id,$link);
if ($sizeRoomSelectBox > 5){
	$sizeRoomSelectBox = 5;
}
?>

        <?php
        if (isset($nachricht) && $nachricht != ""){
        ?>
        <div class="alert alert-info" role="alert"
                <?php if (isset($fehler) && $fehler == false) {echo("class=\"frei\""); }
                    else {echo("class=\"belegt\"");} ?>>
                    <?php echo $nachricht ?>
        </div>

<?php 
}
?>
<form role="form" action="./preisAendern.inc.php" method="post" target="_self" class="form-horizontal">
<table border="0" cellpadding="0" cellspacing="3" class="table">
	<tr>
		<td>
			<?php echo getUebersetzung("gültig von",$sprache,$link) ?>
		</td>
		<td>
			<?php echo getUebersetzung("gültig bis",$sprache,$link) ?>
		</td>
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
	$res = getPrices($unterkunft_id,$link);
	while ($d = mysqli_fetch_array($res)){
		$valid_from = $d["gueltig_von"];
		$tag = getTagFromSQLDate($valid_from);
		if (strlen($tag)<2){ $tag = "0".$tag; }
		$monat=getMonatFromSQLDate($valid_from);
		if (strlen($monat)<2){ $monat = "0".$monat; }
		$jahr =getJahrFromSQLDate($valid_from);
		$valid_from = $tag."/".$monat."/".$jahr;
		$valid_to =   $d["gueltig_bis"];
		$tag = getTagFromSQLDate($valid_to);
		if (strlen($tag)<2){ $tag = "0".$tag; }
		$monat=getMonatFromSQLDate($valid_to);
		if (strlen($monat)<2){ $monat = "0".$monat; }
		$jahr =getJahrFromSQLDate($valid_to);
		$valid_to = $tag."/".$monat."/".$jahr;
		$preis_id 	= $d["PK_ID"];
		$preis		= $d["Preis"];
		$standard 	= $d["Standard"];
		if ($standard == 0 || $standard == "0"){
			$standard = true;
		}
		else{
			$standard = false;
		}
?>
		<tr>
			<td>
				<script>
					DateInput('valid_from_<?php echo $preis_id ?>', true, 'DD/MM/YYYY','<?php
						echo($valid_from);
					?>')
				</script>
			</td>
			<td>
				<script>
					DateInput('valid_to_<?php echo $preis_id ?>', true, 'DD/MM/YYYY','<?php
						echo($valid_to);
					?>')
				</script>
			</td>
			<td>
				<input type="text" class="form-control" name="preis_<?php echo $preis_id ?>" value="<?php echo $preis ?>"/>
			</td>
			<td>
			<select class="form-control" name="zimmer_<?php echo $preis_id ?>[]" size="<?php echo $sizeRoomSelectBox ?>"
				multiple="multiple" id="zimmer_<?php echo $preis_id ?>">
          	<?php
          	 $res3 = getZimmer($unterkunft_id,$link);
				  while($g = mysqli_fetch_array($res3)) {
					$ziArt = getUebersetzungUnterkunft($g["Zimmerart"],$sprache,$unterkunft_id,$link);
					$ziNr  = getUebersetzungUnterkunft($g["Zimmernr"],$sprache,$unterkunft_id,$link);
					?>
					<option value="<?php echo $g["PK_ID"] ?>"
						<?php
						$res2 = getZimmerForPrice($preis_id);
						while($r = mysqli_fetch_array($res2)) {
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
			    <input name="loeschen_<?php echo $preis_id ?>" type="submit" id="loeschen_<?php echo $preis_id ?>" style="width: 100%;"
      				class="btn btn-danger"  value="<?php echo(getUebersetzung("löschen",$sprache,$link)); ?>" />
			</td>
		</tr>
<?php
	} //ende while attribute
?>
	<tr valign="top">
		<td>				
			<script>
				DateInput('valid_from_neu', true, 'DD/MM/YYYY','<?php 
					if (isset($valid_from_neu)){
					 echo($valid_from_neu);
					}
					else{
						echo($startdatumDP); 
					}?>')
			</script>
		</td>
		<td>				
			<script>
				DateInput('valid_to_neu', true, 'DD/MM/YYYY','<?php 
					if (isset($valid_to_neu)){
					 echo($valid_to_neu);
					}
					else{
						echo($startdatumDP); 
					}?>')
			</script>
		</td>
		<td>				
			<input type="text" name="preis_neu" class="form-control" />
		</td>
		<td>				
		<select  class="form-control" name="zimmer_id_neu[]" size="<?php echo $sizeRoomSelectBox ?>"
			multiple="multiple" id="zimmer_id_neu">
          <?php
			 $res = getZimmer($unterkunft_id,$link);
			  //zimmer ausgeben:
			  $i = 0;
				  while($d = mysqli_fetch_array($res)) {
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
		    <input  name="hinzufuegen" type="submit" id="hinzufuegen"  class="btn btn-success" style="width: 100%;"
   				value="<?php echo(getUebersetzung("hinzufügen",$sprache,$link)); ?>" />
		</td>
	</tr>
</table>
<div class="form-group">
<div class="col-sm-offset-9 col-sm-3" style="text-align: right;">
    <input name="aendern" type="submit" id="aendern"
  		   class="btn btn-success"
   		   value="<?php echo(getUebersetzung("speichern",$sprache,$link)); ?>" />
<!--   		   Zurück-->
   		   <a class="btn btn-primary" href="./index.php">
<!--  	<span class="glyphicon glyphicon-menu-left" ></span>-->
  	<?php echo(getUebersetzung("Abbrechen",$sprache,$link)); ?>
  	</a>
</div>

</div>
<table border="0" cellpadding="0" cellspacing="3" class="tableColor">
	<tr>
		<td colspan="3">

		</td>
	</tr>
</table>
</form>

<?php
}
else {
	echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
}
?>
</div>
</div>

<?php include_once("../templates/end.php"); ?>
