<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */
?>
<?php
define('_JEXEC', 1);
$root = "../../..";
include_once("../../../include/sessionFunctions.inc.php");
//include_once("../../../conf/rdbmsConfig.php");

include_once("../../../include/uebersetzer.php");

$zimmer_id = $_POST['zimmer_id'];
$year = $_POST['year'];

$dateFrom = ($year)."-01-01";
$dateTo = ($year)."-12-31";


$response = array();
$reservation = null;

$query = "select 
				*
				from 
				Rezervi_Reservierung
				where 		
				FK_Zimmer_ID = '$zimmer_id' and
				('$dateFrom' <= Datum_von) and ('$dateTo' >= Datum_bis)				
				";

$res = mysqli_query($link, $query);

if ($res) {
    if($res->num_rows > 0){
        while ($row = mysqli_fetch_array($res)){

           $guest = getGuestInfo($row["FK_Gast_ID"],$link);
           $zimmer = getZimmerInfo($row["FK_Zimmer_ID"],$link);

            $reservation =[
                'zimmer_id' => $zimmer_id, 'date_from' => $row["Datum_von"], 'date_to' => $row["Datum_bis"],
                'adult' => $row["Erwachsene"], 'children' => $row["Kinder"], 'pension' => $row['Pension'],
                'status' => $row["Status"], 'date_from' => $row["Datum_von"], 'date_from' => $row["Datum_von"],
                'guest_id' => $guest['PK_ID'],
                'vorname'=> $guest['Vorname'], "nachname" => $guest["Nachname"],'email'=> $guest['Email'], "sprache" => $guest["Sprache"],
                'strasse'=> $guest['Strasse'], "plz" => $guest["PLZ"],'ort'=> $guest['Ort'], "land" => $guest["Land"], "tel" => $guest["Tel"],
                'zimmernr'=> $zimmer['Zimmernr'], "betten" => $zimmer["Betten"],'betten_kinder'=> $zimmer['Betten_Kinder'], "zimmerArt" => $zimmer["Zimmerart"], "link" => $zimmer["Link"],
            ];
            array_push($response,$reservation);
        }
    }
}
else{

}
header('Content-type:application/json;charset=utf-8');

echo json_encode($response);

//how many days the month has
//$anzahlTage = getNumberOfDays($month, $year);

function getZimmerInfo($zimmer_id, $link){
    $query
        = "select 
				*
				from 
				Rezervi_Zimmer
				where 		
				PK_ID = '$zimmer_id'		
				";

    $res = mysqli_query($link, $query);
    if ($res) {
        $d = mysqli_fetch_array($res);
    }

    return $d;
}
function getGuestInfo($guest_id, $link)
{
    $query
        = "select 
				*
				from 
				Rezervi_Gast
				where 		
				PK_ID = '$guest_id'		
				";

    $res = mysqli_query($link, $query);
    if ($res) {
        $d = mysqli_fetch_array($res);
    }

    return $d;
}
?>