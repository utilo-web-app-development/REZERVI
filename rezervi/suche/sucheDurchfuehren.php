<?php session_start();
$root = "..";
// Set flag that this is a parent file
define('_JEXEC', 1);

include_once($root . "/include/sessionFunctions.inc.php");

//datenbank öffnen:
include_once($root . "/conf/rdbmsConfig.php");
//spezielle funktionen fuer suche:
include_once("./sucheFunctions.php");
//funktionen zum anzeigen der zimmer-infos:
include_once($root . "/include/zimmerFunctions.php");
//reservierungs-funktionen:
include_once($root . "/include/datumFunctions.php");
//unterkunfts-funktionen:
include_once($root . "/include/unterkunftFunctions.php");
//uebersetzung:
include_once($root . "/include/uebersetzer.php");
include_once($root . "/include/propertiesFunctions.php");
include_once($root . "/include/bildFunctions.php");
include_once($root . "/include/buchungseinschraenkung.php");

//variablen initialisieren:
$sprache          = getSessionWert(SPRACHE);
$unterkunft_id    = getSessionWert(UNTERKUNFT_ID);
$datumDPv         = $_POST["datumVon"];
$datumDPb         = $_POST["datumBis"];
$datumVAr         = convertDatePickerDate($datumDPv);
$datumBAr         = convertDatePickerDate($datumDPb);
$vonTag           = $datumVAr[0];
$vonMonat         = $datumVAr[1];
$vonJahr          = $datumVAr[2];
$bisTag           = $datumBAr[0];
$bisMonat         = $datumBAr[1];
$bisJahr          = $datumBAr[2];
$anzahlZimmer     = $_POST["anzahlZimmer"];
$anzahlErwachsene = $_POST["anzahlErwachsene"];
if (isset($_POST["anzahlKinder"]) && $_POST["anzahlKinder"] > 0) {
    $anzahlKinder = $_POST["anzahlKinder"];
}
else {
    $anzahlKinder = false;
}
if (isset($_POST["haustiere"]) && $_POST["haustiere"] > 0) {
    $haustiere = $_POST["haustiere"];
}
else {
    $haustiere = false;
}
$zimmer_id  = getSessionWert(ZIMMER_ID);
$zi_ids     = $zimmer_id;
$anzahlTage = numberOfDays(
    $vonMonat, $vonTag, $vonJahr, $bisMonat, $bisTag, $bisJahr
);

if (hasParentRooms($unterkunft_id)
    && getPropertyValue(
        SEARCH_SHOW_PARENT_ROOM, $unterkunft_id, $link
    ) == "true"
) {
    $parentsRes       = getParentRooms();
    $zimmerIdsParents = array();
    while ($p = mysqli_fetch_array($parentsRes)) {
        $i = $p["PK_ID"];
        if ($_POST['parent_room_' . $i]
            && $_POST['parent_room_' . $i] == "true"
        ) {
            $zimmerIdsParents[] = $i;
        }//end if post parent room
    }//end while parent rooms
    if (count($zimmerIdsParents) > 0) {
        $zi_ids = $zimmerIdsParents;
    }
}//end if has parent rooms

//testdaten falls keine unterkunft uebergeben wurde:
if (!isset($unterkunft_id) || $unterkunft_id == "") {
    $unterkunft_id = "1";
}
//Übergebene sprache in session speichern:
//wenn keine sprache übergeben, deutsch nehmen:
if (!isset($sprache) || $sprache == "") {
    $sprache = "de";
}

//headerA einfügen:
include_once("../templates/headerA.php");
//stylesheets einfügen:
?>

<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<!--<!-- Bootstrap -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"  crossorigin="anonymous">-->
<!-- Bootstrap ende -->
<?php
include_once("../templates/headerB.php");
?>
<div class="container" style="margin-top:70px;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>
                <?php echo(getUebersetzung(
                    "Zimmer Suchen!", $sprache, $link
                )); ?>
            </h2>
        </div>
        <div class="panel-body">

            <?php

            //prüfen ob datum korrekt:
            if (!isDatumEarlier(
                $vonTag, $vonMonat, $vonJahr, $bisTag, $bisMonat, $bisJahr
            )
            ) {
                include_once("./subtemplates/isDateCorrect.php");
            } //ende if is datum früher
            else {
                if (isDatumAbgelaufen(
                    $vonTag, $vonMonat, $vonJahr, $bisTag, $bisMonat, $bisJahr
                )) {
                    include_once("./subtemplates/isDateExpired.php");
                }
                else {
                    if ($anzahlTage < 1) {
                        include_once("./subtemplates/stayOneDay.php");
                    }
                    else {
                        include_once("./subtemplates/searchRequestFor.php");

                        $freieZimmer = getFreieZimmer(
                            $unterkunft_id, $anzahlErwachsene, $anzahlKinder,
                            $anzahlZimmer, $haustiere, $vonTag, $vonMonat,
                            $vonJahr,
                            $bisTag, $bisMonat, $bisJahr, $link
                        );
                        if ($freieZimmer[0] == -1
                        ) {
                            //es sind nicht genug plaetze fuer die erwachsenen frei!
                            include_once("./subtemplates/noRoomForAdult.php");
                        }
                        else {
                            if ($freieZimmer[0] == -2) {
                                //es sind nicht genug plaetze fuer die kinder frei!
                                include_once("./subtemplates/noRoomForKids.php");
                            }
                            else {
                                if ($freieZimmer[0] == -3) {
                                    //es sind nicht genug zimmer frei
                                    include_once("./subtemplates/noRoom.php");
                                }
                                else {
                                    $zaehle                 = 0;
                                    $zaehleEinschraenkungen = 0;
                                    foreach ($freieZimmer as $zimmer_id) {
                                        if (isset($zimmerIdsParents)
                                            && count(
                                                $zimmerIdsParents
                                            ) > 0
                                        ) {
                                            foreach ($zimmerIdsParents as $par)
                                            {
                                                if ($zimmer_id != $par) {
                                                    //echo("continue: freies zimmer:".$zimmer_id);
                                                    continue 2;
                                                }
                                            }
                                        }
                                        $zaehle++;
                                    }
                                    if ($zaehle > 0
                                    ) {
                                        //es sind zimmer zur verfügung:
                                        include_once("./subtemplates/formForListOfRooms.php");
                                    }
                                    else {
                                        $freieZimmer[0] = -1;
                                    }
                                }
                            }
                        }
                    }
                }
            } //ende datum ist nicht früher
            ?>
        </div>
    </div>
</div>
</body>
</html>
