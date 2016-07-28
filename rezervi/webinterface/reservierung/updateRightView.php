<?php
//session_save_path('/Users/emreerden/Desktop/temp');
//session_start();
//header('Access-Control-Allow-Origin: *');
/**
 * Created by PhpStorm.
 * User: emreerden
 * Date: 26.07.16
 * Time: 10:35
 */
//function updateRightView()
//{
define('_JEXEC', 1);
$root = "../..";
include_once($root . "/include/sessionFunctions.inc.php");
include_once("../../conf/rdbmsConfig.php");
include_once("../../include/einstellungenFunctions.php");

include_once("./rightHelper.php");
include_once("../../leftHelper.php");
include_once("../../include/datumFunctions.php");
include_once("../../include/propertiesFunctions.php");
include_once("../../include/reservierungFunctions.php");
include_once("../../include/gastFunctions.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/uebersetzer.php");


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

$saAktiviert = getPropertyValue(SHOW_OTHER_COLOR_FOR_SA, $unterkunft_id, $link);

//anzahl der tage des monats:
$anzahlTage = getNumberOfDays($month, $year);

$response = "";


for ($i = 1; $i <= $anzahlTage; $i++) {
    $res_id = getReservierungID($zimmer_id, $i, $month, $year, $link);
    $statusString = getStatusString($zimmer_id, $i, $month, $year, $saAktiviert, $link);
    $gast_id = -1;

    $response .= "<div class=\"row\">";
    $response .= "<div class=\"col-sm-1\">";
    $response .= "<label class=\"control-label\">";
    $response .= getUebersetzung(getDayName($i, $month, $year), $sprache, $link);
    $response .= "</label>";
    $response .= "</div>";
    $response .= "<div class=\"col-sm-1 ";
    $response .= $statusString;
    $response .= "\">";
    $response .= "<label class=\"control-label\">";
    $response .= printResAdminAJAX($zimmer_id, $i, $month, $year, $saAktiviert, $link,$unterkunft_id);
    $response .= "</label>";
    $response .= "</div>";
    $response .= "<div class=\"col-sm-3\">";
    if ($statusString != "frei") {
        $gast_ids = getReservierungGastIDs($zimmer_id, $i, $month, $year, $link);
        while ($h = mysqli_fetch_array($gast_ids)) {
            $gast_id = $h["FK_Gast_ID"];
            //if child rooms available, check also childs:
            if (($gast_id == 1 || empty($gast_id)) && getPropertyValue(RES_HOUSE, $unterkunft_id, $link) == "true" && hasChildRooms($zimmer_id)) {
                //if room is a parent, check if the child has another status:
                $childs = getChildRooms($zimmer_id);
                while ($c = mysqli_fetch_array($childs)) {
                    $child_zi_id = $c['PK_ID'];
                    $gast_id = getReservierungGastID($child_zi_id, $i, $month, $year, $link);
                    if ($gast_id != 1 && $gast_id != "") {
                        break;
                    }
                }
            }
            //gast-namen ausgeben:
            if ($gast_id != 1 && $gast_id != "") {
                $response .= '<a href="./gastInfo/index.php?gast_id='.$gast_id.'&zimmer_id='.$zimmer_id .'&jahr='. $year. '&monat=' . $month . '">';
                $response .= getGuestNachname($gast_id, $link);
                $response .= "</a>, ";
                $response .= getGuestOrt($gast_id, $link);
                $response .= ", EW " . getErwachsene($res_id, $link) . ", K " . getKinder($res_id, $link) . ", " . getPension($res_id, $link);

            } else if ($gast_id == "") {
                $response .=":(";
            } else {
                $response .= getUebersetzung("anonymer Gast", $sprache, $link);
            }
        }
    } else {
        $response .= "&nbsp;";
    }

$response .="</div>";
$response .="</div>";
} //ende for
echo $response;




function printResAdminAJAX($zimmer_id, $i, $month, $year, $saAktiviert, $link, $unterkunft_id)
{

    //global $unterkunft_id;
    $response="";

    $status = getStatus($zimmer_id, $i, $month, $year, $link);
    if (sizeof($status) < 1 && hasChildRooms($zimmer_id) && getPropertyValue(RES_HOUSE, $unterkunft_id, $link) == "true") {
        //if room is a parent, check if the child has another status:
        $childs = getChildRooms($zimmer_id);
        while ($c = mysqli_fetch_array($childs)) {
            $child_zi_id = $c['PK_ID'];
            $status = getStatus($child_zi_id, $i, $month, $year, $link);
            if (sizeof($status) > 0) {
                break;
            }
        }
    }

    if (getDayName($i, $month, $year) == "SA" && $saAktiviert) {
        $isSamstag = true;
    } else {
        $isSamstag = false;
    }

    if (isset($status) && (sizeof($status) > 1)) {
        //an diesem tag ist ein urlauberwechsel:
        $response.="<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">";
        $response.="<tr>";
        $response.="<td class=\"".parseStatus($status[0], $isSamstag)."\" align=\"right\" width=\"50%\">";
        $response.=$i;
        $response.="</td>";
        $response.="<td class=\"".parseStatus($status[1], $isSamstag)."\" align=\"right\" width=\"50%\">&nbsp;";
        $response.="</td>";
        $response.="</tr>";
        $response.="</table>";

    } //ende if "an diesem tag ist urlauberwechsel"
    else if (isset($status) && (sizeof($status) == 1)) {

        //schauen ob der letzte tag halb-frei ist:
        $nTag = $i + 1;
        $nMonat = $month;
        $nJahr = $year;
        $anzahlTage = getNumberOfDays($month, $year);
        if ($nTag > $anzahlTage) {
            $nTag = 1;
            $nMonat = $month + 1;
        } //ende if tag zu gross
        if ($nMonat > 12) {
            $nMonat = 1;
            $nJahr = $year + 1;
        } //ende if monat zu gross

        $nStatus = getStatus($zimmer_id, $nTag, $nMonat, $nJahr, $link);
        //echo("nächster Tag: ");var_dump($nStatus);
        if (sizeof($nStatus) < 1 && getPropertyValue(RES_HOUSE, $unterkunft_id, $link) == "true" && hasChildRooms($zimmer_id)) {
            //if room is a parent, check if the child has another status:
            $childs = getChildRooms($zimmer_id);
            while ($c = mysqli_fetch_array($childs)) {
                $child_zi_id = $c['PK_ID'];
                $nStatus = getStatus($child_zi_id, $nTag, $nMonat, $nJahr, $link);
                if (sizeof($nStatus) > 0) {
                    break;
                }
            }
        }

        if (sizeof($nStatus) == 0) {
            $response.="<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">";
            $response.="<tr>";
            $response.="<td class=\"".parseStatus($status[0], $isSamstag)."\" align=\"right\" width=\"50%\">";
            $response.="</td>";
            $response.="<td class=\"frei\" align=\"right\" width=\"50%\">&nbsp;";
            $response.=$i;
            $response.="</td>";
            $response.="</tr>";
            $response.="</table>";

        } //ende if nächster tag frei
        else {
            //schauen ob der tag vorher frei ist:
            $vTag = $i - 1;
            $vMonat = $month;
            $vJahr = $year;
            if ($vTag < 1) {
                $vMonat = $month - 1;
                if ($vMonat < 1) {
                    $vMonat = 12;
                    $vJahr = $year - 1;
                } //ende if monat zu klein
                $vTag = getNumberOfDays($vMonat, $vJahr);
            } //ende if tag zu klein

            $vStatus = getStatus($zimmer_id, $vTag, $vMonat, $vJahr, $link);
            if (sizeof($vStatus) < 1 && hasChildRooms($zimmer_id) && getPropertyValue(RES_HOUSE, $unterkunft_id, $link) == "true") {
                //if room is a parent, check if the child has another status:
                $childs = getChildRooms($zimmer_id);
                while ($c = mysqli_fetch_array($childs)) {
                    $child_zi_id = $c['PK_ID'];
                    $vStatus = getStatus($child_zi_id, $vTag, $vMonat, $vJahr, $link);
                    if (sizeof($vStatus) > 0) {
                        break;
                    }
                }
            }

            if (sizeof($vStatus) == 0) {
                //am vorherigen tag ist es frei:
                $response.="<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">";
                $response.="<tr>";
                $response.="<td class=\"frei\" align=\"right\" width=\"50%\">";
                $response.=$i;
                $response.="</td>";
                $response.="<td class=\"".parseStatus($status[0], $isSamstag)."\" align=\"right\" width=\"50%\">&nbsp;";
                $response.="</td>";
                $response.="</tr>";
                $response.="</table>";

            } //ende if tag vorher frei
            else {
                $response.=$i;
            }
        }//ende else schauen ob tag vorher frei
    } //ende else
    else { //tag ausgeben:
        $response.=$i;
    } //ende else tag ausgeben

    return $response;
}//ende printRes
?>