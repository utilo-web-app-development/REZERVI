<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */
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
            }
            else {
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
            && count($zimmerIdsParents)
            > 0
        ) {
            foreach (
                $zimmerIdsParents as
                $par
            ) {
                if ($zimmer_id
                    != $par
                ) {
                    //echo("continue: freies zimmer:".$zimmer_id);
                    continue 2;
                }
            }
        }
        $zaehle++;
        ?>


        <?php
        //bilder anzeigen, falls vorhanden und gewünscht:
        if (isPropertyShown(
            $unterkunft_id,
            ZIMMER_THUMBS_ACTIV, $link
        )) {
            ?>

            <?php
            if (hasZimmerBilder(
                $zimmer_id, $link
            )) {
                $result
                    = getBilderOfZimmer(
                    $zimmer_id, $link
                );
                while ($z
                    = mysqli_fetch_array(
                    $result
                )) {
                    $pfad = $z["Pfad"];
                    $pfad = substr(
                        $pfad, 3,
                        strlen($pfad)
                    );
                    $width
                          = $z["Width"];
                    $height
                          = $z["Height"];
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

            <input name="zimmer_ids[]"
                   type="checkbox"
                   value="<?php echo($zimmer_id); ?>"
                <?php
                if ($zaehle
                    <= $anzahlZimmer
                ) {
                    echo("checked=\"checked\"");
                }
                ?>/>

        <?php }

        //checking if Link should be activated
        $res = getPropertiesSuche(
            $unterkunft_id, $link
        ); //Methode in einstellungenFunctions.php definiert
        while ($d = mysqli_fetch_array(
            $res
        )) {
            if ($d["Name"] == LINK_SUCHE) {
                $name = $d["Name"];

                //falls Option schon aktiviert ist, ist die Checkbox bereits bei den Auswahlmöglichkeiten "angehackelt"
                $aktiviert
                    = isPropertyShown(
                    $unterkunft_id,
                    $name, $link
                ); //Methode in einstellungenFunctions.php definiert
                if ($aktiviert
                    == 'true'
                ) {
                    ?>

                            <?php
                            $uri
                                = getLink(
                                $unterkunft_id,
                                $zimmer_id,
                                $link
                            );
                            if ($uri
                            != "")
                            {
                            ?>
                            <a href="<?php echo($uri); ?>"
                               class="standardSchrift">
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
                                if ($uri
                                != "") {
                                ?>
                            </a>
                        <?php
                        }
                        ?>

                    <?php
                }
                else {
                    ?>

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

                    <?php
                }
            }
        } ?>

        </div>
        </div>
        <?php
        //button nur anzeigen wenn es auch zimmer ohne einschraenkungen gibt:
    }
    ?>

</form>

<form action="./index.php"
      method="post"
      name="sucheWiederholen"
      id="sucheWiederholen"
      target="_self">
    <div class="form-group">
        <div class="col-sm-12" style="text-align: right;">
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

    </div>
</div>
</form>

<?php
if ($zaehleEinschraenkungen < $zaehle ) {
    ?>
    <div class="form-group">
        <div class="col-sm-12" style="text-align: right;">
            <button
                    name="reservierungAbsenden"
                    type="submit"
                    class="btn btn-success"
                    id="reservierungAbsenden"
                    onclick="submitReservierungForm();"
                    >
                <?php echo(getUebersetzung(
                    "Reservierung starten...",
                    $sprache,
                    $link
                )); ?>
            </button>

            <button type="submit" name="Submit" class="btn btn-default" onclick="submitSucheWiederholenForm();">
                <?php echo(getUebersetzung(
                    "Suche wiederholen",
                    $sprache,
                    $link
                )); ?>
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </div>
    </div>
    <script>
        function submitReservierungForm() {
            $('#reservierung').submit();
        }
        function submitSucheWiederholenForm() {
            $('#sucheWiederholen').submit();
        }
    </script>
    <?php
}
else {
    $freieZimmer[0] = -1;
}
?>
