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
} else {
    $anzahlKinder = false;
}
if (isset($_POST["haustiere"]) && $_POST["haustiere"] > 0) {
    $haustiere = $_POST["haustiere"];
} else {
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
            //headerB einfügen:


            //prüfen ob datum korrekt:
            if (!isDatumEarlier(
                $vonTag, $vonMonat, $vonJahr, $bisTag, $bisMonat, $bisJahr
            )
            ) {
                $fehlgeschlagen = true;
                ?>
                <form action="./index.php" id="fehlerRedirectForm">
                    <input type="hidden" name="messageDanger"
                           value="Das Reservierungs-Datum wurde nicht korrekt angegeben!"/>
                    <input type="hidden" name="messageWarning"
                           value="Bitte korrigieren Sie das Datum Ihrer Anfrage!"/>
                    <input type="hidden" name="sprache"
                           value="<?php echo $sprache; ?>"/>
                    <input type="hidden" name="fehlgeschlagen"
                           value="<?php echo $fehlgeschlagen; ?>"/>
                </form>
                <script>
                    $("#fehlerRedirectForm").submit();
                </script>

            <?php
            } //ende if is datum früher
            else {
            if (isDatumAbgelaufen(
                $vonTag, $vonMonat, $vonJahr, $bisTag, $bisMonat, $bisJahr
            )) {
            $fehlgeschlagen = true;
            ?>
                <form action="./index.php" id="fehlerRedirectForm">
                    <input type="hidden" name="messageDanger"
                           value="Das gewählte Datum ist bereits abgelaufen."/>
                    <input type="hidden" name="messageWarning"
                           value="Bitte korrigieren Sie das Datum Ihrer Anfrage!"/>
                    <input type="hidden" name="sprache"
                           value="<?php echo $sprache; ?>"/>
                    <input type="hidden" name="fehlgeschlagen"
                           value="<?php echo $fehlgeschlagen; ?>"/>
                </form>
                <script>
                    $("#fehlerRedirectForm").submit();
                </script>
            <?php
            } else {
            if ($anzahlTage < 1) {
            $fehlgeschlagen = true;
            ?>
                <form action="./index.php" id="fehlerRedirectForm">
                    <input type="hidden" name="messageDanger"
                           value="Es ist mindestens eine Übernachtung erforderlich"/>
                    <input type="hidden" name="messageWarning"
                           value="Bitte korrigieren Sie das Datum Ihrer Anfrage!"/>
                    <input type="hidden" name="sprache"
                           value="<?php echo $sprache; ?>"/>
                    <input type="hidden" name="fehlgeschlagen"
                           value="<?php echo $fehlgeschlagen; ?>"/>
                </form>
                <script>
                    $("#fehlerRedirectForm").submit();
                </script>

            <?php
            } else {
            ?>
                <div class="well">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>
                                <?php echo(getUebersetzung(
                                    "Suchanfrage für:", $sprache, $link
                                )); ?>
                            </h3>
                        </div>
                    </div>
                    <?php if ($anzahlErwachsene > -1) {
                        ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>
                                    <span class="badge"><?php echo($anzahlErwachsene); ?></span>
                                    &nbsp;<?php echo(getUebersetzung(
                                        "Erwachsene", $sprache, $link
                                    )); ?>
                                </label>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if ($anzahlKinder > -1) { ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>
                                    <span class="badge"><?php echo($anzahlKinder); ?></span>
                                    <?php echo(getUebersetzung(
                                        "Kinder", $sprache, $link
                                    )); ?>
                                </label>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if ($anzahlZimmer > -1) { ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>
                                    <?php
                                    if (isset($zimmerIdsParents)
                                        && count(
                                            $zimmerIdsParents
                                        ) > 0
                                    ) {
                                        foreach (
                                            $zimmerIdsParents as $par
                                        ) {
                                            $temp = getZimmerArt(
                                                $unterkunft_id, $par,
                                                $link
                                            );
                                            $temp2
                                                  = getZimmerNr(
                                                $unterkunft_id, $par,
                                                $link
                                            );
                                            $temp3
                                                  = getUebersetzungUnterkunft(
                                                $temp, $sprache,
                                                $unterkunft_id, $link
                                            );
                                            $temp4
                                                  = getUebersetzungUnterkunft(
                                                $temp2, $sprache,
                                                $unterkunft_id,
                                                $link
                                            );
                                            $zimmerbezeichnung
                                                  = ($temp3)
                                                . ("&nbsp;")
                                                . ($temp4);
                                            echo($zimmerbezeichnung);
                                        }
                                    } else {
                                        if ($anzahlZimmer < 2) {
                                            ?>
                                            <span class="badge">
                                                <?php echo($anzahlZimmer); ?>
                                            </span>
                                            <?php echo(getUebersetzungUnterkunft(
                                                getZimmerart_EZ(
                                                    $unterkunft_id,
                                                    $link
                                                ), $sprache,
                                                $unterkunft_id,
                                                $link
                                            ));
                                        } else {
                                            ?>
                                            <span class="badge">
                                                    <?php
                                                    echo($anzahlZimmer); ?>
                                            </span>
                                            <?php echo(getUebersetzungUnterkunft(
                                                getZimmerart_MZ(
                                                    $unterkunft_id,
                                                    $link
                                                ), $sprache,
                                                $unterkunft_id,
                                                $link
                                            ));
                                        }
                                    } ?>
                                </label>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if ($haustiere == 'true') { ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>
                                    <?php
                                    //Neu für die Option HAUSTIERE
                                    if ($haustiere == 'true') { ?>
                                        <?php echo(getUebersetzung(
                                            "Haustiere", $sprache, $link
                                        )); ?>
                                    <?php }
                                    ?>
                                </label>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <label>
                                <?php echo(getUebersetzung(
                                    "von", $sprache, $link
                                )); ?>:
                            </label>
                            <?php echo($vonTag); ?>
                            .<?php echo($vonMonat); ?>
                            .<?php echo($vonJahr); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label>
                                <?php echo(getUebersetzung(
                                    "bis", $sprache, $link
                                )); ?>:
                            </label>
                            <?php echo($bisTag); ?>
                            .<?php echo($bisMonat); ?>
                            .<?php echo($bisJahr); ?>

                        </div>
                    </div>
                </div>

                <?php
                $freieZimmer = getFreieZimmer(
                    $unterkunft_id, $anzahlErwachsene, $anzahlKinder,
                    $anzahlZimmer, $haustiere, $vonTag, $vonMonat,
                    $vonJahr,
                    $bisTag, $bisMonat, $bisJahr, $link
                );
            if ($freieZimmer[0] == -1
            ) {
                //es sind nicht genug plaetze fuer die erwachsenen frei!
                ?>

                <div class="alert alert-warning" role="alert">
                    <?php echo(getUebersetzung(
                        "Leider haben wir nicht mehr genug ",
                        $sprache, $link
                    ));
                    echo(getUebersetzungUnterkunft(
                        getZimmerart_MZ(
                            $unterkunft_id, $link
                        ),
                        $sprache, $unterkunft_id, $link
                    ));
                    echo(getUebersetzung(
                            "für", $sprache, $link
                        )
                        . " ");
                    ?>
                    <span class="badge">
                        <?php
                        echo($anzahlErwachsene);
                        ?>
                    </span>
                    <?php
                    echo(getUebersetzung(
                        " Erwachsene im gewünschten Zeitraum frei.",
                        $sprache, $link
                    )); ?>
                </div>

                <?php
            } else {
            if ($freieZimmer[0] == -2
            ) {
                //es sind nicht genug plaetze fuer die kinder frei!
                ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo(getUebersetzung(
                        "Leider haben wir nicht mehr genug ",
                        $sprache, $link
                    ));
                    echo(getUebersetzungUnterkunft(
                        getZimmerart_MZ(
                            $unterkunft_id, $link
                        ),
                        $sprache, $unterkunft_id, $link
                    ));
                    echo(getUebersetzung(
                            "für", $sprache, $link
                        )
                        . " ");
                    ?>
                    <span class="badge">
                        <?php
                        echo($anzahlKinder);
                        ?>
                </span>
                    <?php
                    echo(getUebersetzung(
                        " Kinder im gewünschten Zeitraum frei.",
                        $sprache, $link
                    ));
                    ?>
                </div>

                <?php
            } else {
            if ($freieZimmer[0] == -3
            ) {
                //es sind nicht genug zimmer frei
                ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo(getUebersetzung(
                        "Leider haben wir nicht mehr genug ",
                        $sprache, $link
                    ));
                    echo(getUebersetzungUnterkunft(
                        getZimmerart_MZ($unterkunft_id, $link), $sprache,
                        $unterkunft_id, $link
                    ));
                    echo("&nbsp;" . getUebersetzung(
                            "im gewünschten Zeitraum frei.",
                            $sprache, $link
                        ));
                    ?>
                </div>
                <?php
            } else {
                $zaehle                 = 0;
                $zaehleEinschraenkungen = 0;
                foreach ($freieZimmer as $zimmer_id) {
                    if (isset($zimmerIdsParents)
                        && count(
                            $zimmerIdsParents
                        ) > 0
                    ) {
                        foreach ($zimmerIdsParents as $par) {
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
                ?>
                <form action="../anfrage/index.php"
                      class="form-horizontal"
                      method="post" name="reservierung"
                      target="_self"
                      id="reservierung">
                    <input name="anzahlErwachsene"
                           type="hidden"
                           value="<?php echo($anzahlErwachsene); ?>"/>
                    <input name="anzahlKinder"
                           type="hidden"
                           value="<?php echo($anzahlKinder); ?>"/>
                    <input name="datumVon" type="hidden"
                           value="<?php echo($datumDPv); ?>"/>
                    <input name="datumBis" type="hidden"
                           value="<?php echo($datumDPb); ?>"/>
                    <input name="anzahlZimmer"
                           type="hidden"
                           value="<?php echo($anzahlZimmer); ?>"/>
                    <input name="haustiere"
                           type="hidden"
                           value="<?php echo($haustiere); ?>"/>
                    <br/>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label>
                                <?php echo(getUebersetzung(
                                        "Freie",
                                        $sprache,
                                        $link
                                    ) . " ");
                                echo(getUebersetzungUnterkunft(
                                    getZimmerart_MZ(
                                        $unterkunft_id,
                                        $link
                                    ), $sprache,
                                    $unterkunft_id,
                                    $link
                                ));
                                echo(" "
                                    . getUebersetzung(
                                        "im gewünschten Zeitraum",
                                        $sprache,
                                        $link
                                    ) . ":");
                                ?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <?php
                            if (count(
                                    $freieZimmer
                                ) > 1
                            ) {
                                echo(getUebersetzung(
                                        "Bitte wählen Sie die gewünschten",
                                        $sprache,
                                        $link
                                    ) . " ");
                                echo(getUebersetzungUnterkunft(
                                    getZimmerart_MZ(
                                        $unterkunft_id,
                                        $link
                                    ), $sprache,
                                    $unterkunft_id,
                                    $link
                                ));
                                echo(" "
                                    . getUebersetzung(
                                        "aus",
                                        $sprache,
                                        $link
                                    ) . ".");
                            } else {
                                echo(getUebersetzung(
                                        "Bitte wählen Sie das gewünschte",
                                        $sprache,
                                        $link
                                    ) . " ");
                                echo(getUebersetzungUnterkunft(
                                    getZimmerart_EZ(
                                        $unterkunft_id,
                                        $link
                                    ), $sprache,
                                    $unterkunft_id,
                                    $link
                                ));
                                echo(" "
                                    . getUebersetzung(
                                        "aus",
                                        $sprache,
                                        $link
                                    ) . ".");
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    $zaehle                 = 0;
                    $zaehleEinschraenkungen = 0;
                    foreach ($freieZimmer as $zimmer_id) {
                        if (isset($zimmerIdsParents)
                            && count($zimmerIdsParents) > 0
                        ) {
                            foreach ($zimmerIdsParents as $par) {
                                if ($zimmer_id != $par) {
                                    //echo("continue: freies zimmer:".$zimmer_id);
                                    continue 2;
                                }
                            }
                        }
                        $zaehle++;
                        ?>



                            <?php
                            //bilder anzeigen, falls vorhanden und gewünscht:
                            if (isPropertyShown( $unterkunft_id, ZIMMER_THUMBS_ACTIV, $link )) {
                                ?>

                                        <?php
                                        if (hasZimmerBilder(
                                            $zimmer_id, $link
                                        )) {
                                            $result = getBilderOfZimmer(
                                                $zimmer_id, $link
                                            );
                                            while ($z = mysqli_fetch_array(
                                                $result
                                            )) {
                                                $pfad   = $z["Pfad"];
                                                $pfad   = substr(
                                                    $pfad, 3, strlen($pfad)
                                                );
                                                $width  = $z["Width"];
                                                $height = $z["Height"];
                                                ?>
                                                <div class="form-group">
                                                <div class="col-sm-12">
                                                <img src="<?php echo($pfad); ?>"
                                                     class="img-responsive"/>&nbsp;
                                                </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>

                                <?php
                            }
                            ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php
                                    //pruefe ob fuer das zimmer eine buchungseinschraenkung besteht.
                                    //wenn ja dann kann es nicht ausgewaehlt werden
                                    //und es wird ein infotext ausgegeben.
                                    if (isset($zi_temp)) {
                                        unset($zi_temp);
                                    }
                                    $zi_temp
                                        = array();
                                    $zi_temp[0]
                                        = $zimmer_id;

                                    if (hasActualBuchungsbeschraenkungen(
                                            $unterkunft_id
                                        )
                                        && !checkBuchungseinschraenkung(
                                            $vonTag,
                                            $vonMonat,
                                            $vonJahr,
                                            $bisTag,
                                            $bisMonat,
                                            $bisJahr,
                                            $zi_temp
                                        )
                                    ) {
                                        echo(getBuchungseinschraenkungText(
                                            $vonTag,
                                            $vonMonat,
                                            $vonJahr,
                                            $bisTag,
                                            $bisMonat,
                                            $bisJahr,
                                            $zi_temp
                                        ));
                                        echo(": ");
                                        $zaehleEinschraenkungen++;
                                    }
                                    else {
                                        ?>
                                        <input name="zimmer_ids[]" type="checkbox" value="<?php echo($zimmer_id); ?>"
                                            <?php
                                            if ($zaehle <= $anzahlZimmer ) {
                                                echo("checked=\"checked\"");
                                            }
                                            ?>/>
                                </div>
                            </div>
                                    <?php }

                                    //checking if Link should be activated
                                    $res = getPropertiesSuche( $unterkunft_id, $link ); //Methode in einstellungenFunctions.php definiert
                                    while ($d = mysqli_fetch_array( $res ))
                                    {
                                        if ($d["Name"] == LINK_SUCHE)
                                        {
                                        $name = $d["Name"];

                                    //falls Option schon aktiviert ist, ist die Checkbox bereits bei den Auswahlmöglichkeiten "angehackelt"
                                    $aktiviert = isPropertyShown( $unterkunft_id, $name, $link ); //Methode in einstellungenFunctions.php definiert
                                    if ($aktiviert == 'true')
                                    {
                                        ?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <?php
                                    $uri  = getLink( $unterkunft_id, $zimmer_id, $link );
                                    if ($uri != "")
                                    {
                                    ?>
                                    <a href="<?php echo($uri); ?>" class="standardSchrift">
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        echo((getZimmerArt(
                                                $unterkunft_id,
                                                $zimmer_id,
                                                $link
                                            ))
                                            . " "
                                            . (getZimmerNr(
                                                $unterkunft_id,
                                                $zimmer_id,
                                                $link
                                            ))); ?>
                                        <?php
                                        if ($uri != "") {
                                        ?>
                                    </a>
                                        <?php
                                        }
                                        ?>
                                </div>
                            </div>
                        <?php
                        }
                        else {
                                        ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php
                                    echo((getZimmerArt(
                                            $unterkunft_id,
                                            $zimmer_id,
                                            $link
                                        )) . " "
                                        . (getZimmerNr(
                                            $unterkunft_id,
                                            $zimmer_id,
                                            $link
                                        ))); ?>
                                </div>
                            </div>
                            <?php
                        }
                        }
                        } ?>


                        <?php
                        //button nur anzeigen wenn es auch zimmer ohne einschraenkungen gibt:
                    }
                    ?>





                        <?php
                        if ($zaehleEinschraenkungen
                            < $zaehle
                        ) {
                            ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                            <input
                                            name="reservierungAbsenden"
                                            type="submit"
                                            class="btn btn-default"
                                            id="reservierungAbsenden"
                                            value="<?php echo(getUebersetzung(
                                                "Reservierung starten...",
                                                $sprache,
                                                $link
                                            )); ?>">
                            </div>
                        </div>
                            <?php
                        } else {
                            $freieZimmer[0] = -1;
                        }
                        ?>

                </form>
                <table border="0" class="table">
                    <tr>
                        <td>
                            <form action="./index.php"
                                  method="post"
                                  name="sucheWiederholen"
                                  target="_self">
                                <input name="anzahlErwachsene"
                                       type="hidden"
                                       value="<?php echo($anzahlErwachsene); ?>"/>
                                <input name="anzahlKinder"
                                       type="hidden"
                                       value="<?php echo($anzahlKinder); ?>"/>
                                <input name="datumVon"
                                       type="hidden"
                                       value="<?php echo($datumDPv); ?>"/>
                                <input name="datumBis"
                                       type="hidden"
                                       value="<?php echo($datumDPb); ?>"/>
                                <input name="anzahlZimmer"
                                       type="hidden"
                                       value="<?php echo($anzahlZimmer); ?>"/>
                                <input name="haustiere"
                                       type="hidden"
                                       value="<?php echo($haustiere); ?>"/>
                                <input name="keineSprache"
                                       type="hidden"
                                       value="true"/>
                                <?php
                                if (isset($zimmerIdsParents)
                                    && count(
                                        $zimmerIdsParents
                                    ) > 0
                                ) {
                                    ?>
                                    <input name="zimmerIdsParents"
                                           type="hidden"
                                           value="<?php
                                           foreach (
                                               $zimmerIdsParents
                                               as
                                               $ziidpa
                                           ) {
                                               echo($ziidpa
                                                   . ",");
                                           }
                                           ?>"/>
                                    <?php
                                }
                                ?>
                                <input type="submit"
                                       name="Submit"
                                       class="btn btn-default"
                                       value="<?php echo(getUebersetzung(
                                           "Suche wiederholen",
                                           $sprache,
                                           $link
                                       )); ?>"/>
                            </form>
                        </td>
                    </tr>
                </table>
                <?php
            } else {
                $freieZimmer[0] = -1;
            }
            }
            }
            }
            if ($freieZimmer[0] == -1 || $freieZimmer[0] == -2
                || $freieZimmer[0] == -3
            ) {
                ?>
            <br/>
                <table border="0" class="table">
                    <tr>
                        <td>
                            <b>
                                <?php echo(getUebersetzung(
                                    "Leider haben wir nicht mehr genug ",
                                    $sprache, $link
                                ));
                                echo(getUebersetzungUnterkunft(
                                    getZimmerart_MZ(
                                        $unterkunft_id, $link
                                    ),
                                    $sprache, $unterkunft_id, $link
                                ));
                                echo("&nbsp;" . getUebersetzung(
                                        "im gewünschten Zeitraum frei.",
                                        $sprache, $link
                                    ));
                                ?>
                                <br/><br/>
                                <?php echo(getUebersetzung(
                                    "Bitte wiederholen sie die Suche mit geänderten Anforderungen <br/>	oder wählen Sie aus dem Belegungsplan den gewünschten Zeitraum aus.",
                                    $sprache, $link
                                )); ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td><?php if (isset($keineSprache)
                            && ($keineSprache == "true"))
                            { ?>
                            <form action="../start.php"
                                  method="post"
                                  name="belegungsplanAnzeigen"
                                  target="_self">
                                <?php }
                                else
                                {
                                ?>
                                <form action="../right.php"
                                      method="post"
                                      name="belegungsplanAnzeigen"
                                      target="_self">
                                    <?php }
                                    ?>
                                    <input name="zimmer_id"
                                           type="hidden"
                                           id="zimmer_id"
                                           value="<?php echo($zimmer_id); ?>">
                                    <input name="monat"
                                           type="hidden"
                                           value="<?php echo($vonMonat); ?>">
                                    <input name="jahr" type="hidden"
                                           value="<?php echo($vonJahr); ?>">
                                    <input type="submit"
                                           name="Submit"
                                           class="btn btn-default"
                                           value="<?php echo(getUebersetzung(
                                               "Belegungsplan anzeigen",
                                               $sprache,
                                               $link
                                           )); ?>">
                                </form>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <form action="./index.php" method="post"
                                  name="sucheWiederholen"
                                  target="_self">
                                <input name="anzahlErwachsene"
                                       type="hidden"
                                       value="<?php echo($anzahlErwachsene); ?>"/>
                                <input name="anzahlKinder"
                                       type="hidden"
                                       value="<?php echo($anzahlKinder); ?>"/>
                                <input name="datumVon" type="hidden"
                                       value="<?php echo($datumDPv); ?>"/>
                                <input name="datumBis" type="hidden"
                                       value="<?php echo($datumDPb); ?>"/>
                                <input name="anzahlZimmer"
                                       type="hidden"
                                       value="<?php echo($anzahlZimmer); ?>"/>
                                <input name="haustiere"
                                       type="hidden"
                                       value="<?php echo($haustiere); ?>"/>
                                <input name="keineSprache"
                                       type="hidden"
                                       value="true"/>
                                <?php
                                if (isset($zimmerIdsParents)
                                    && count(
                                        $zimmerIdsParents
                                    ) > 0
                                ) {
                                    ?>
                                    <input name="zimmerIdsParents"
                                           type="hidden"
                                           value="<?php
                                           foreach (
                                               $zimmerIdsParents as
                                               $ziidpa
                                           ) {
                                               echo($ziidpa . ",");
                                           }
                                           ?>"/>
                                    <?php
                                }
                                ?>
                                <input type="submit" name="Submit"
                                       class="btn btn-default"
                                       value="<?php echo(getUebersetzung(
                                           "Suche wiederholen",
                                           $sprache, $link
                                       )); ?>">
                            </form>
                        </td>
                    </tr>
                </table>
                <?php
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
