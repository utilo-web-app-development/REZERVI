<?php $root = "../../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/templates/constants.inc.php");	
include_once($root."/webinterface/templates/components.inc.php"); 		

//variablen initialisieren:
$standard = $_POST["standard"];
$countAnzeigen = 0;
foreach ($ansicht_array as $ans){
	
	if (isset($_POST[$ans."_anzeigen"]) && $_POST[$ans."_anzeigen"] == "true"){
		$countAnzeigen++;
		if ($ans == JAHRESUEBERSICHT){
      		setVermieterEigenschaftenWert(JAHRESUEBERSICHT_ANZEIGEN,"true",$vermieter_id);
      	}
      	else if($ans == MONATSUEBERSICHT){
      		setVermieterEigenschaftenWert(MONATSUEBERSICHT_ANZEIGEN,"true",$vermieter_id);
      	}
      	else if($ans == WOCHENANSICHT) {
      		setVermieterEigenschaftenWert(WOCHENANSICHT_ANZEIGEN,"true",$vermieter_id);
      	}
      	else if($ans == TAGESANSICHT ){
      		setVermieterEigenschaftenWert(TAGESANSICHT_ANZEIGEN,"true",$vermieter_id);
      	}
	}
	else{
		if ($ans == JAHRESUEBERSICHT){
      		setVermieterEigenschaftenWert(JAHRESUEBERSICHT_ANZEIGEN,"false",$vermieter_id);
      	}
      	else if($ans == MONATSUEBERSICHT){
      		setVermieterEigenschaftenWert(MONATSUEBERSICHT_ANZEIGEN,"false",$vermieter_id);
      	}
      	else if($ans == WOCHENANSICHT) {
      		setVermieterEigenschaftenWert(WOCHENANSICHT_ANZEIGEN,"false",$vermieter_id);
      	}
      	else if($ans == TAGESANSICHT ){
      		setVermieterEigenschaftenWert(TAGESANSICHT_ANZEIGEN,"false",$vermieter_id);
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
if ($standard == JAHRESUEBERSICHT && getVermieterEigenschaftenWert(JAHRESUEBERSICHT_ANZEIGEN,$vermieter_id) != "true"){
	$standardFehler = true;
}
else if($standard == MONATSUEBERSICHT && getVermieterEigenschaftenWert(MONATSUEBERSICHT_ANZEIGEN,$vermieter_id) != "true"){
	$standardFehler = true;
}
else if($standard == WOCHENANSICHT && getVermieterEigenschaftenWert(WOCHENANSICHT_ANZEIGEN,$vermieter_id) != "true") {
	$standardFehler = true;
}
else if($standard == TAGESANSICHT && getVermieterEigenschaftenWert(TAGESANSICHT_ANZEIGEN,$vermieter_id) != "true"){
	$standardFehler = true;
}

if ($standardFehler === true){
	$message = "Die Standardansicht muss auch angezeigt werden.";
	$nachricht = getUebersetzung($message);
	$fehler = true;
	include_once("./index.php");
	exit;
}

include_once($root."/webinterface/templates/bodyStart.inc.php"); 

	//zuerst alle alten eintraege löschen:
	setVermieterEigenschaftenWert(STANDARDANSICHT,$standard,$vermieter_id);

?>

<p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Ändern der angezeigten Sprachen")); ?>.</p>

	<table  border="0" cellpadding="0" cellspacing="3" class="<?php echo FREI ?>">
	  <tr>
		<td><?php echo  getUebersetzung("Die Standardansicht wurde erfolgreich geändert!"); ?></td>
	  </tr>
	</table>
	<br/><br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zurück"));
	  
include_once($root."/webinterface/templates/footer.inc.php");
?>