<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

//variablen initialisieren:
if (isset($_POST["ansichtWechsel"])){
	$ansichtWechsel = $_POST["ansichtWechsel"];
}

if (isset($ansichtWechsel) && $ansichtWechsel == 0){
	$ansicht = 0;
	setSessionWert(ANSICHT_WI,'0');
}
else if (isset($ansichtWechsel) && $ansichtWechsel == 1){
	$ansicht = 1;
	setSessionWert(ANSICHT_WI,'1');
}
else {
	$ansicht = getSessionWert(ANSICHT_WI);
}
	
//script waehlt die korrekte ansicht aus:
//die letzte ansicht wird in der session-veriable ansicht gespeichert
// 0 = right.php
// 1 = jahresuebersicht
if (isset($ansicht) && $ansicht != ""){
	switch($ansicht){
		case 0:
			include_once("./right.php");
			break;
		case 1:
			include_once("./jahresuebersicht.php");
			break;	
		default:
			include_once("./right.php");
			break;
	} //ende switch
}//ende if
else{
	include_once("./right.php");
}
?>