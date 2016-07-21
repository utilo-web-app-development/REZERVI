<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");

//datenbank öffnen:
include_once($root . "/conf/rdbmsConfig.php");
include_once($root . "/include/buchungseinschraenkung.php");
include_once($root . "/include/uebersetzer.php");
include_once($root . "/include/benutzerFunctions.php");
include_once($root . "/include/unterkunftFunctions.php");
include_once($root . "/webinterface/templates/components.php");
$sprache = getSessionWert(SPRACHE);
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$loeschen = false;
$hinzufuegen = false;
$bu_id = -1;
if (isset($_POST["add"]) && $_POST["add"] == getUebersetzung("hinzufügen", $sprache, $link)) {
    $hinzufuegen = true;
} else {
    $res = getBuchungseinschraenkungen($unterkunft_id);
    while ($d = mysqli_fetch_array($res)) {
        $id = $d["PK_ID"];
        //welche id soll gelöscht werden?
        if (isset($_POST["loeschen#" . $id])
            && $_POST["loeschen#" . $id] == getUebersetzung("löschen", $sprache, $link)
        ) {
            $bu_id = $id;
            $loeschen = true;
            break;
        }
    }
}

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$sprache = getSessionWert(SPRACHE);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

?>
<?php

    //löschen oder hinzufuegen:
    if ($loeschen && !$hinzufuegen) {
        removeBuchungseinschraenkung($bu_id);
        $nachricht = "Der Datensatz wurde erfolgreich entfernt";
        $nachricht = getUebersetzung($nachricht, $sprache, $link);
        $fehler = false;
    } else if ($hinzufuegen && !$loeschen) {
        $von_wochentag = $_POST["von_wochentag"];
        $zimmer_id = $_POST["zimmer_id"];
        $bis_wochentag = $_POST["bis_wochentag"];
        $vonTag = $_POST["vonTag"];
        $bisTag = $_POST["bisTag"];
        $vonMonat = $_POST["vonMonat"];
        $bisMonat = $_POST["bisMonat"];
        $vonJahr = $_POST["vonJahr"];
        $bisJahr = $_POST["bisJahr"];
        //pruefen ob sich die buchungseinschränkung eh
        //nicht mit einer bereits bestehenden überschneidet:
        if (hasBuchungseinschraenkung($vonTag, $vonMonat, $vonJahr, $bisTag, $bisMonat, $bisJahr, $zimmer_id)) {
            $fehler = true;
            $nachricht = "Die Buchungseinschränkung überschneidet sich mit einer bereits existierenden!";
            $nachricht = getUebersetzung($nachricht, $sprache, $link);
        } else {
            $fehler = false;
            setBuchungseinschraenkung($zimmer_id, $von_wochentag, $bis_wochentag, $vonTag, $vonMonat, $vonJahr, $bisTag, $bisMonat, $bisJahr);
            $nachricht = "Der Datensatz wurde erfolgreich hinzugefögt";
            $nachricht = getUebersetzung($nachricht, $sprache, $link);
        }
    }

    include_once("index.php");

    ?>