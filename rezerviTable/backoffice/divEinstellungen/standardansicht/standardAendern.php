<?php 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/templates/constants.inc.php");	
include_once($root."/backoffice/templates/components.inc.php"); 		

//variablen initialisieren:
$standard = $_POST["standard"];
$countAnzeigen = 0;
foreach ($ansicht_array as $ans){
	
	if (isset($_POST[$ans."_anzeigen"]) && $_POST[$ans."_anzeigen"] == "true"){
		$countAnzeigen++;
		if ($ans == JAHRESUEBERSICHT){
      		setGastroProperty(JAHRESUEBERSICHT_ANZEIGEN,"true",$gastro_id);
      	}
      	else if($ans == MONATSUEBERSICHT){
      		setGastroProperty(MONATSUEBERSICHT_ANZEIGEN,"true",$gastro_id);
      	}
      	else if($ans == WOCHENANSICHT) {
      		setGastroProperty(WOCHENANSICHT_ANZEIGEN,"true",$gastro_id);
      	}
      	else if($ans == TAGESANSICHT ){
      		setGastroProperty(TAGESANSICHT_ANZEIGEN,"true",$gastro_id);
      	}
	}
	else{
		if ($ans == JAHRESUEBERSICHT){
      		setGastroProperty(JAHRESUEBERSICHT_ANZEIGEN,"false",$gastro_id);
      	}
      	else if($ans == MONATSUEBERSICHT){
      		setGastroProperty(MONATSUEBERSICHT_ANZEIGEN,"false",$gastro_id);
      	}
      	else if($ans == WOCHENANSICHT) {
      		setGastroProperty(WOCHENANSICHT_ANZEIGEN,"false",$gastro_id);
      	}
      	else if($ans == TAGESANSICHT ){
      		setGastroProperty(TAGESANSICHT_ANZEIGEN,"false",$gastro_id);
      	}
	}
}

if ($countAnzeigen<=0){
	$message = "Sie müssen mindestens eine Anzeige auswählen";
	$nachricht = getUebersetzung($message);
	$fehler = true;
	include_once("./index.php");
	exit;
}

$standardFehler = false;
if ($standard == JAHRESUEBERSICHT && getGastroProperty(JAHRESUEBERSICHT_ANZEIGEN,$gastro_id) != "true"){
	$standardFehler = true;
}
else if($standard == MONATSUEBERSICHT && getGastroProperty(MONATSUEBERSICHT_ANZEIGEN,$gastro_id) != "true"){
	$standardFehler = true;
}
else if($standard == WOCHENANSICHT && getGastroProperty(WOCHENANSICHT_ANZEIGEN,$gastro_id) != "true") {
	$standardFehler = true;
}
else if($standard == TAGESANSICHT && getGastroProperty(TAGESANSICHT_ANZEIGEN,$gastro_id) != "true"){
	$standardFehler = true;
}

if ($standardFehler === true){
	$message = "Die Standardansicht muss auch angezeigt werden.";
	$nachricht = getUebersetzung($message);
	$fehler = true;
	include_once("./index.php");
	exit;
}

include_once($root."/backoffice/templates/bodyStart.inc.php"); 

	//zuerst alle alten eintraege löschen:
	setGastroProperty(STANDARDANSICHT,$standard,$gastro_id);

?>

<p class="standardschrift"><?php echo(getUebersetzung("Ändern der angezeigten Sprachen")); ?>.</p>

	<table  border="0" cellpadding="0" cellspacing="3" class="<?php echo FREI ?>">
	  <tr>
		<td><?php echo  getUebersetzung("Die Standardansicht wurde erfolgreich geändert!"); ?></td>
	  </tr>
	</table>
	<br/><br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zurück"));
	  
include_once($root."/backoffice/templates/footer.inc.php");
?>