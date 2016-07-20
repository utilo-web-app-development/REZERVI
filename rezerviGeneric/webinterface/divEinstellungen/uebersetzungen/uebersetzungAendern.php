<?php $root = "../../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
			
include_once($root."/webinterface/templates/components.inc.php"); 
include_once($root."/include/vermieterFunctions.inc.php");
		
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
		if (isUebersetzungVorhanden($stText,$changeSprache)){
			changeUebersetzung($stText,$uebersetzung_neu,$changeSprache);
		}
		else{
			setUebersetzung($uebersetzung_neu,$stText,$changeSprache);	
		}		
	}

}

if (isset($_POST["zurueck"]) && $_POST["zurueck"] == getUebersetzung("speichern und zurück")){
	include_once("index.php");
	exit;
}

$uebersetzungs_ids = "";
$standardsprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
$res = getAllUebersetzungenWithIndex($index,$standardsprache);

include_once($root."/webinterface/templates/bodyStart.inc.php"); 
$standardsprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
if ($standardsprache == false || $standardsprache == ""){
	$standardsprache = "en";
}
?>

<p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("ändern der angezeigten übersetzungen")); ?>.</p>
<form action="./uebersetzungAendern.php" method="post" target="_self">
<input name="changeSprache" type="hidden" value="<?php echo($changeSprache); ?>"/>
<table  border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
  <tr>
	<th><div align="left"><?php echo getUebersetzung("Standardtext"); ?></div></th>
	<th><div align="left"><?php echo getUebersetzung("Uebersetzung in")." ".getBezeichnungOfSpracheID($changeSprache); ?></div></th>
  </tr>
  <?php
  while ($d=mysqli_fetch_array($res)){
  	$standardtext = $d["TEXT_STANDARD"];
  	$uebersetzungs_id = $d["UEBERSETZUNGS_ID"];
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
		<td><?php echo $standardtext ?></td>
		<td><textarea name="uebersetzung_id_<?php echo $uebersetzungs_id ?>"><?php echo $text ?></textarea></td>
	  </tr>
  <?php
  }
  ?>
</table>
	<?php
		if (($index - LIMIT_UEBERSETZUNGEN) > -1){
			?>
			<input name="indexVorherigeSeite" type="hidden" value="<?php echo($index - LIMIT_UEBERSETZUNGEN); ?>"/>
			<input type="submit" name="vorherige" value="<?php echo(getUebersetzung("speichern und vorherige Seite")); ?>" class="<?php echo BUTTON ?>" 
				onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       			onMouseOut="this.className='<?php echo BUTTON ?>';">
			<?php
		}
		if (($index + LIMIT_UEBERSETZUNGEN) < getAnzahlUebersetzungen($standardsprache)){
			?>
			<input name="indexNaechsteSeite" type="hidden" value="<?php echo($index + LIMIT_UEBERSETZUNGEN); ?>"/>
			<input type="submit" name="naechste" value="<?php echo(getUebersetzung("speichern und nächste Seite")); ?>" class="<?php echo BUTTON ?>" 
				onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       			onMouseOut="this.className='<?php echo BUTTON ?>';">			
			<?php	
		}
	?>
	<input name="uebersetzungs_ids" type="hidden" value="<?php echo($uebersetzungs_ids); ?>"/>
	<br/><br/>
	<input type="submit" name="zurueck" value="<?php echo(getUebersetzung("speichern und zurück")); ?>" class="<?php echo BUTTON ?>" 
				onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       			onMouseOut="this.className='<?php echo BUTTON ?>';">
</form>
<?php 
	  
include_once($root."/webinterface/templates/footer.inc.php");

?>