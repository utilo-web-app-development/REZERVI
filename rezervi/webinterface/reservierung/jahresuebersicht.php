<?php //session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
//include_once($root."/include/sessionFunctions.inc.php");
/*   
	reservierungsplan
	anzeige des kalenders
	author: christian osterrieder utilo.eu		
	
	dieser seite muss übergeben werden:
	Unterkunft PK_ID ($unterkunft_id)
*/

$data = json_decode(file_get_contents("php://input"));

$unterkunft_id = $data->unterkunft_id;


$sprache = $data->sprache;

if (isset($data->zimmer_id)) {
    $zimmer_id = $data->zimmer_id;
} else {
    $zimmer_id = getFirstRoom($unterkunft_id, $link);
}
if (isset($data->month)) {
    $month = $data->month;
} else {
    $month = parseMonthNumber(getTodayMonth());
}
if (isset($data->year)) {
    $year = $data->year;
} else {
    $year = getTodayYear();
}
//ich brauche für jahr einen integer:
$year += 1;
$year -= 1;
//und fürs monat einen integer
$month -= 1;
$month += 1;

$month = 1;

//setSessionWert(ZIMMER_ID,$zimmer_id);

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//funktions einbinden:
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/datumFunctions.php");
include_once("../../include/reservierungFunctions.php");
include_once("../../include/gastFunctions.php");
include_once("../../include/benutzerFunctions.php");
include_once("../../include/uebersetzer.php");
//helper-funktionen einfügen:
include_once("./jahresuebersichtHelper.php");

	include_once("../../include/propertiesFunctions.php");
	$saAktiviert = getPropertyValue(SHOW_OTHER_COLOR_FOR_SA,$unterkunft_id,$link);

$response = "";

$response .= showYear(1,$year,$unterkunft_id,$zimmer_id,$sprache,$saAktiviert,$link);
echo $response;
?>