<? $root = "../../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");

$standardsprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
if ($standardsprache == false || $standardsprache == ""){
	$standardsprache = "en";
}
			
include_once($root."/webinterface/templates/components.inc.php"); 		

$res = getSprachen();
$zaehle = 0; //zur kontrolle ob ueberhaupt eine sprache ausgewaehlt wurde
$standard = $_POST["standard"];
//zuerst alte sprachen rauslöschen, dann neu setzen:
deleteAllActivtedSprachenOfVermieter($vermieter_id);

while($d = mysql_fetch_array($res)){
	$bezeichnung = $d["BEZEICHNUNG"];
	$spracheID   = $d["SPRACHE_ID"];       

	//variablen initialisieren:
	$cur_sprache_id = false;
	if (isset($_POST[$spracheID])){
		$cur_sprache_id	= $_POST[$spracheID];
	}	

	if (($standard == $spracheID && $cur_sprache_id == false)){
		$nachricht = "Die Standardsprache muss auch ausgewählt werden!";
		$nachricht = getUebersetzung($nachricht);
		$fehler = true;
		include_once("./sprachen.php");
		exit;
	}
	
	if ($cur_sprache_id != false){
		setActivtedSpracheOfVermieter($vermieter_id,$cur_sprache_id);
	}
	
	$zaehle++;

}

//kontrolle ob überhaupt eine sprache ausgewählt wurde:
if ($zaehle <= 0){
	$nachricht = "Sie müssen mindestens eine Sprache auswählen!";
	$nachricht = getUebersetzung($nachricht);
	$fehler = true;
	include_once("./sprachen.php");
	exit;
}

include_once($root."/webinterface/templates/bodyStart.inc.php"); 

setVermieterEigenschaftenWert(STANDARDSPRACHE,$standard,$vermieter_id);	

?>

<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Ändern der angezeigten Sprachen")); ?>.</p>

	<table  border="0" cellpadding="0" cellspacing="3" class="<?= FREI ?>">
	  <tr>
		<td><?=  getUebersetzung("Die angezeigten Sprachen wurden erfolgreich geändert!"); ?></td>
	  </tr>
	</table>

<br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zurück"));
	  
include_once($root."/webinterface/templates/footer.inc.php");
?>