<? 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";
$unterschrift = "Übersetzungen";
$unterschrift1 = "Ändern";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
			
include_once($root."/backoffice/templates/components.inc.php"); 
include_once($root."/include/vermieterFunctions.inc.php");


if (isset($_POST["abbrechen"])){
	$info = true;
	$nachricht = "Die Änderung der Übersetzungen wurde beendet!";
	include_once("./index.php");
	exit;
}
		
$changeSprache = $_POST["changeSprache"];
if (isset($_POST["indexVorherigeSeite"]) && isset($_POST["vorherige"]) && $_POST["vorherige"]==getUebersetzung("speichern und vorherige Seite")){
	$index = $_POST["indexVorherigeSeite"];
}
else if(isset($_POST["indexNaechsteSeite"]) && isset($_POST["naechste"]) && $_POST["naechste"]==getUebersetzung("speichern und nächste Seite")){
	$index = $_POST["indexNaechsteSeite"];
}
else{
	$index = 0;
}
if ($index < 0){
	$index = 0;
}

$standardsprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
if ($standardsprache == false || $standardsprache == ""){
	$standardsprache = "en";
}

if (isset($_POST["uebersetzungs_ids"])){
	
	$ueb_id_array = explode("#", $_POST["uebersetzungs_ids"]);
	//aenderungen durchfuehren:
	//alle ids holen und schauen ob die verändert wurden:
	foreach ($ueb_id_array as $ueb_id){
		if (empty($ueb_id)){
			continue;
		}	
		$uebersetzung_neu = $_POST[("uebersetzung_id_".$ueb_id)];
		$stText = getTextFromUebersetzung($ueb_id);
		
		if ($standardsprache == $changeSprache){
			changeStandardsprache($ueb_id,$uebersetzung_neu);
			continue;
		}
		else if (isUebersetzungVorhanden($stText,$changeSprache)){
			changeUebersetzung($stText,$uebersetzung_neu,$changeSprache);
			continue;
		}
		else{
			setUebersetzungVermieter($uebersetzung_neu,$stText,$changeSprache);	
			continue;
		}		
	}
}
if (isset($_POST["zurueck"]) && $_POST["zurueck"] == getUebersetzung("speichern und zurück")){
	$info = true;
	$nachricht = "Die Übersetzungen wurden erfolgreich geändert!";
	include_once("./index.php");
	exit;
}

$uebersetzungs_ids = "";
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, $ueberschrift, "divEinstellungen/index.php",
							$unterschrift, "divEinstellungen/uebersetzungen/index.php",
							$unterschrift1, "");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
$res = getAllUebersetzungenWithIndex($index,$standardsprache);
?>

<h2><?php echo(getUebersetzung("Ändern der angezeigten Übersetzungen")); ?>.</h2>
<form action="./uebersetzungAendern.php" method="post" target="_self">
<input name="changeSprache" type="hidden" value="<?php echo($changeSprache); ?>"/>
<table width="90%" class="moduletable_line ">
  <tr>
	<th width="45%"><?= getUebersetzung("Standardtext in ")." ".getBezeichnungOfSpracheID($standardsprache); ?></th>
	<th width="45%">
		<?= getUebersetzung("Uebersetzung in")." ".getBezeichnungOfSpracheID($changeSprache); ?>
	</th>
  </tr>
  <?php
  while ($d=$res->FetchNextObject()){
  	$standardtext = $d->TEXT_STANDARD;
  	$uebersetzungs_id = $d->UEBERSETZUNGS_ID;
  	//hole nun dazu die uebersetzung der changeSprache:
  	$r =  getUebersetzungFromSprache($standardtext,$changeSprache);
  	if (empty($r)){
	  	//wenn nicht vorhanden, dann nimm die uebersetzung des standardtextes:
	  	$text = $standardtext;
  	}
  	else{
  		$text = $r;
  	}
  	$uebersetzungs_ids.=($uebersetzungs_id."#");
  ?>
	  <tr>
		<td><?= $standardtext ?></td>
		<td><textarea style="width:100%;" name="uebersetzung_id_<?= $uebersetzungs_id ?>"><?= $text ?></textarea></td>
	  </tr>
  <?php
  }
  ?>
</table>
<table width="90%">
	<tr>
		<td>
			<div  align="right"><?
		if (($index - LIMIT_UEBERSETZUNGEN) > -1){
			?>
			<input name="indexVorherigeSeite" type="hidden" value="<?php echo($index - LIMIT_UEBERSETZUNGEN); ?>"/>
			<input type="submit" name="vorherige" value="<?php echo(getUebersetzung("speichern und vorherige Seite")); ?>" class="button">
			<?
		}else{
			?>
			<input type="submit" name="vorherige" value="<?php echo(getUebersetzung("speichern und vorherige Seite")); ?>" class="button_nolink">
			<?
		}
		?>
			</div>
		</td>
		<td>
			<div  align="left">
		<?
		if (($index + LIMIT_UEBERSETZUNGEN) < getAnzahlUebersetzungen($standardsprache)){
			?>
			<input name="indexNaechsteSeite" type="hidden" value="<?php echo($index + LIMIT_UEBERSETZUNGEN); ?>"/>
			<input type="submit" name="naechste" value="<?php echo(getUebersetzung("speichern und nächste Seite")); ?>" class="button">
			<?	
		}else{
			?>
			<input type="submit" name="naechste" value="<?php echo(getUebersetzung("speichern und nächste Seite")); ?>" class="button_nolink">
			<?
		}	?>
			</div>
		</td>
	</tr>
</table>
	<input name="uebersetzungs_ids" type="hidden" value="<?php echo($uebersetzungs_ids); ?>"/>
	<br/>
	<input type="submit" name="zurueck" value="<?php echo(getUebersetzung("speichern und zurück")); ?>" class="button">
	<br/>
	<input type="submit" name="abbrechen" value="<?php echo(getUebersetzung("abbrechen")); ?>" class="button">
</form>
<?php 
	  
include_once($root."/backoffice/templates/footer.inc.php");

?>