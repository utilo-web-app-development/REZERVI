<? session_start();
$root = ".";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
include_once($root."/include/propertiesFunctions.php");

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);	
//variablen initialisieren:
if (isset($_POST["ansichtWechsel"])){
	$ansicht = $_POST["ansichtWechsel"];
	setSessionWert(ANSICHT,$ansicht);
}
else{
	$ansicht = getSessionWert(ANSICHT);
}

//script waehlt die korrekte ansicht aus:
//die letzte ansicht wird in der session-veriable ansicht gespeichert
// 0 = right.php
// 1 = jahresuebersicht
// 2 = alle Zimmer
if (isset($ansicht) && $ansicht != ""){
	setSessionWert(ANSICHT,$ansicht);
	switch($ansicht){
		case 0:
			include_once("./right.php");
			break;
		case 1:
			include_once("./jahresuebersicht.php");
			break;
		case 2:
			include_once("./gesamtuebersicht.php");
			break;	
		default:
			include_once("./right.php");
			break;
	} //ende switch
}//ende if
else{
 
 $showMonatsansicht = getPropertyValue(SHOW_MONATSANSICHT,$unterkunft_id,$link);
 $showJahresansicht = getPropertyValue(SHOW_JAHRESANSICHT,$unterkunft_id,$link);
 $showGesamtansicht = getPropertyValue(SHOW_GESAMTANSICHT,$unterkunft_id,$link);
	
	if ($showMonatsansicht == "true"){
		include_once("./right.php");
		exit;
	}
	if ($showJahresansicht == "true"){
		include_once("./jahresuebersicht.php");
		exit;
	}
	if ($showGesamtansicht == "true"){
		include_once("./gesamtuebersicht.php");
		exit;
	}	
}
?>