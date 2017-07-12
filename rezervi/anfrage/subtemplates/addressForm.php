<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */
?>
<form action="./send.php" method="post" class="form-horizontal"
      name="adresseForm" target="_self"
      id="adresseForm" onSubmit="return chkFormular()">
    <div class="well">
        <?php

        function removeChildRooms($zimmer_ids)
        {
            $newArr = array();
            //is room with child rooms in array?
            $parentInArray = false;
            foreach ($zimmer_ids as $id) {
                if (hasChildRooms($id)) {
                    $parentInArray = true;
                }
            }
            if ($parentInArray) {
                foreach ($zimmer_ids as $id) {

                    if (hasRoomParentRooms($id) && in_array($id, $zimmer_ids)) {
                        //tu nix
                    }
                    else {

                        $newArr[] = $id;
                    }
                }

                return $newArr;
            }

            return $zimmer_ids;
        }

        $zimmer_ids = removeChildRooms($zimmer_ids);
        //wenn aus suche aufgerufen:
        if (isset($zimmer_ids)) {
            ?>
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        <?php echo(getUebersetzung(
                            "Reservierungs-Anfrage für ", $sprache, $link
                        )); ?>
                    </label>
                </div>
            </div>
            <?php


            foreach ($zimmer_ids as $zi_id) {
                ?>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input name="zimmer_ids[]" type="checkbox"
                               value="<?php echo($zi_id); ?>" checked="checked">
                        <?php
                        echo(getUebersetzungUnterkunft(
                                getZimmerArt($unterkunft_id, $zi_id, $link),
                                $sprache, $unterkunft_id, $link
                            ) . " " . (getUebersetzungUnterkunft(
                                getZimmernr($unterkunft_id, $zi_id, $link),
                                $sprache, $unterkunft_id, $link
                            )));
                        ?>
                    </div>
                </div>

                <?php
            }
        }
        else {
            //aus belegungsplan aufgerufen:
            ?>
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        <?php
                        echo(getUebersetzung(
                                "Reservierungs-Anfrage für ", $sprache, $link
                            ) . " ");
                        $ziA = getZimmerArt($unterkunft_id, $zimmer_id, $link);
                        echo(getUebersetzungUnterkunft(
                            $ziA, $sprache, $unterkunft_id, $link
                        ));

                        ?>: <?php echo(getUebersetzungUnterkunft(
                            getZimmernr($unterkunft_id, $zimmer_id, $link),
                            $sprache, $unterkunft_id, $link
                        ));
                        ?>
                    </label>
                </div>
            </div>
            <?php

        }//ende von belegungsplan aufgerufen.
        ?>
        <div class="form-group">
            <div class="col-sm-1">
                <?php echo(getUebersetzung("von", $sprache, $link)); ?>:
            </div>
            <div class="col-sm-11">
                <label>
                    <?php echo($vonTag); ?>.<?php echo($vonMonat); ?>
                    .<?php echo($vonJahr); ?>
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-1">
                <?php echo(getUebersetzung("bis", $sprache, $link)); ?>:
            </div>
            <div class="col-sm-11">
                <label>
                    <?php echo($bisTag); ?>.<?php echo($bisMonat); ?>
                    .<?php echo($bisJahr); ?>
                </label>
            </div>
        </div>

    </div>


    <div class="well">

        <div class="form-group">
            <div class="col-sm-12">
                <label>
                    <?php echo(getUebersetzung(
                        "Wir benötigen noch folgende Daten von Ihnen", $sprache,
                        $link
                    )); ?>:
                </label>
            </div>
        </div>

            <div class="form-group">
                <div class="col-sm-2">
                    <label>
                        <?php echo(getUebersetzung(
                            "Anrede", $sprache, $link
                        )); ?>
                    </label>
                </div>
                <div class="col-sm-10">
                    <select name="anrede" id="anrede" class="form-control">
                        <option><?php echo(getUebersetzung(
                                "Familie", $sprache, $link
                            )); ?></option>
                        <option><?php echo(getUebersetzung(
                                "Frau", $sprache, $link
                            )); ?></option>
                        <option><?php echo(getUebersetzung(
                                "Herr", $sprache, $link
                            )); ?></option>
                        <option><?php echo(getUebersetzung(
                                "Firma", $sprache, $link
                            )); ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label>
                        <?php echo(getUebersetzung(
                            "Vorname", $sprache, $link
                        )); ?>*
                    </label>
                </div>
                <div class="col-sm-10">
                    <input name="vorname" type="text" id="vorname"
                           class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label>
                        <?php echo(getUebersetzung(
                            "Nachname", $sprache, $link
                        )); ?>*
                    </label>
                </div>
                <div class="col-sm-10">
                    <input name="nachname" type="text" id="nachname"
                           class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label>
                        <?php echo(getUebersetzung(
                            "Straße/Hausnummer", $sprache, $link
                        )); ?>*
                    </label>
                </div>
                <div class="col-sm-10">
                    <input name="strasse" type="text" id="strasse"
                           class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label>
                        <?php echo(getUebersetzung("PLZ", $sprache, $link)); ?>*
                    </label>
                </div>
                <div class="col-sm-10">
                    <input name="plz" type="text" id="plz" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label>
                        <?php echo(getUebersetzung("Ort", $sprache, $link)); ?>*
                    </label>
                </div>
                <div class="col-sm-10">
                    <input name="ort" type="text" id="ort" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label>
                        <?php echo(getUebersetzung(
                            "Land", $sprache, $link
                        )); ?>
                    </label>
                </div>
                <div class="col-sm-10">
                    <input name="land" type="text" id="land"
                           class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label>
                        <?php echo(getUebersetzung(
                            "E-Mail-Adresse", $sprache, $link
                        )); ?>*
                    </label>
                </div>
                <div class="col-sm-10">
                    <input name="email" type="text" id="email"
                           class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label>
                        <?php echo(getUebersetzung(
                            "Telefonnummer", $sprache, $link
                        )); ?>
                    </label>
                </div>
                <div class="col-sm-10">
                    <input name="tel" type="text" id="tel" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label>
                        <?php echo(getUebersetzung(
                            "Faxnummer", $sprache, $link
                        )); ?>
                    </label>
                </div>
                <div class="col-sm-10">
                     <input name="fax" type="text" id="fax" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label>
                        <?php echo(getUebersetzung(
                            "Anmerkungen/Fragen", $sprache, $link
                        )); ?>
                    </label>
                </div>
                <div class="col-sm-10">
                    <textarea name="anmerkung" id="anmerkung"
                              class="form-control"></textarea>
                </div>
            </div>
            <?php
            //wenn die anfrage aus der suche kommt, hier keine Auswahl mehr erlauben:
            if (isset($anzahlErwachsene) && $anzahlErwachsene != false
                && $anzahlErwachsene > -1
            ) {
                ?>
                <input name="anzahlErwachsene" type="hidden"
                       value="<?php echo($anzahlErwachsene); ?>">
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
                            <?php echo(getUebersetzung(
                                "Anzahl Erwachsene", $sprache, $link
                            )); ?>
                        </label>
                    </div>
                    <div class="col-sm-1">
                        <span class="badge">
                            <?php echo($anzahlErwachsene); ?>
                        </span>
                    </div>
                </div>
                <?php
            }
            else {
                ?>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
                            <?php echo(getUebersetzung(
                                "Anzahl Erwachsene", $sprache, $link
                            )); ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <select name="anzahlErwachsene" id="anzahlErwachsene" class="form-control">
                            <?php
                            //es können nur soviele ausgewählt werden wie betten im zimmer
                            //vorhanden sind:
                            $anzahlBetten = getBetten(
                                $unterkunft_id, $zimmer_id, $link
                            );
                            $anzahlBetten += 1;
                            $anzahlBetten -= 1; //integer!
                            $anzahlKinderBetten = getBettenKinder(
                                $unterkunft_id, $zimmer_id, $link
                            );
                            $st = 1;
                            if ($anzahlKinderBetten > 0) {
                                $st = 0;
                            }
                            for ($i = $st; $i <= $anzahlBetten; $i++) { ?>
                                <option value="<?php echo($i); ?>" <?php if ($i
                                    == 2
                                ) {
                                    echo("selected");
                                } ?>><?php echo($i); ?></option>
                                <?php
                            } //ende for schleife
                            ?>
                        </select>
                    </div>
                </div>
                <?php
            } //ende else anfrage kommt aus suche
            //KINDER
            $res = getPropertiesSuche(
                $unterkunft_id, $link
            ); //Methode in einstellungenFunctions.php definiert
            while ($d = mysqli_fetch_array($res)) {
                if ($d["Name"] == 'Kinder') {
                    $name = $d["Name"];
                    //falls Option schon aktiviert ist, ist die Checkbox bereits bei den Auswahlmöglichkeiten "angehackelt"
                    $aktiviert = isPropertyShown(
                        $unterkunft_id, $name, $link
                    ); //Methode in einstellungenFunctions.php definiert

                    if ($aktiviert == 'true') {
                        if (isset($anzahlKinder)) {
                            //anfrage kommt aus suche:
                            if ($anzahlKinder > -1) {
                                ?>
                                <input name="anzahlKinder" type="hidden"
                                       value="<?php echo($anzahlKinder); ?>">
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <label>
                                            <?php echo(getUebersetzung(
                                                "Anzahl Kinder unter", $sprache,
                                                $link
                                            )); ?><?php echo(getKindesalter(
                                                $unterkunft_id, $link
                                            )); ?>
                                            <?php echo(getUebersetzung(
                                                "Jahren", $sprache, $link
                                            )); ?>
                                        </label>
                                    </div>
                                    <div class="col-sm-1">
                                        <span class="badge">
                                            <?php echo($anzahlKinder); ?>
                                        </span>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        else {
                            if ($anzahlKinderBetten > 0) {
                                ?>
                                <div class="standardSchrift">
                                    <div class="col-sm-2">
                                        <label>
                                            <?php echo(getUebersetzung(
                                                "Anzahl Kinder unter", $sprache,
                                                $link
                                            )); ?><?php echo(getKindesalter(
                                                $unterkunft_id, $link
                                            )); ?>
                                            <?php echo(getUebersetzung(
                                                "Jahren", $sprache, $link
                                            )); ?>
                                        </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select name="anzahlKinder"
                                                id="anzahlKinder"
                                        class="form-control">
                                            <?php
                                            for (
                                                $i = 0;
                                                $i <= ($anzahlKinderBetten);
                                                $i++
                                            ) {
                                                ?>
                                                <option value="<?php echo($i); ?>" <?php if ($i
                                                    == 0
                                                ) {
                                                    echo("selected");
                                                } ?>><?php echo($i); ?></option>
                                                <?php
                                            }//ende for schleife
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            } //ende if ($anzahlKinderBetten > 0)
                        }//ende else-loop
                    }//ende if($d["Name"] == 'Kinder')
                }//ende if($aktiviert)
            }//end while

            //HAUSTIERE
            $res = getPropertiesSuche(
                $unterkunft_id, $link
            ); //Methode in einstellungenFunctions.php definiert
            while ($d = mysqli_fetch_array($res)) {
                if ($d["Name"] == 'Haustiere') {
                    $name = $d["Name"];
                    //falls Option schon aktiviert ist, ist die Checkbox bereits bei den Auswahlmöglichkeiten "angehackelt"
                    $aktiviert = isPropertyShown(
                        $unterkunft_id, $name, $link
                    ); //Methode in einstellungenFunctions.php definiert

                    if ($aktiviert) {
                        if (isset($haustiere)) {
                            //anfrage kommt aus suche:
                            if ($haustiere == 'true') {
                                ?>
                                <input name="Haustiere" type="hidden"
                                       value="<?php echo($haustiere); ?>">
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <label>
                                            <?php
                                            echo(getUebersetzung(
                                                "Haustiere", $sprache, $link
                                            ));
                                            ?>
                                        </label>
                                    </div>
                                    <div class="col-sm-1">
                                        <?php
                                        echo(getUebersetzung(
                                            "Ja", $sprache, $link
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        else {
                            //anfrage kommt aus belegungsplan:
                            ?>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label>
                                        <?php echo(getUebersetzung(
                                            $name, $sprache, $link
                                        ));
                                        ?>
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <input name="<?php echo($name); ?>"
                                           type="checkbox"
                                           id="<?php echo($name); ?>"
                                           value="true">
                                </div>
                            </div>
                            <?php
                        } //end else-loop
                    }//end if($aktiviert)
                }//end if($d["Name"] == 'Haustiere')
            }//end while-loop
            ?>
            <?php
            if (getPropertyValue(PENSION_UEBERNACHTUNG, $unterkunft_id, $link)
                == "true"
            ) {
                ?>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
                            <?php
                            echo(getUebersetzung("Übernachtung", $sprache, $link));
                            ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="zusatz" type="radio" value="Uebernachtung"
                               checked="checked"/>
                    </div>
                </div>
                <?php
            }
            if (getPropertyValue(PENSION_FRUEHSTUECK, $unterkunft_id, $link)
                == "true"
            ) {
                ?>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
                            <?php
                            echo(getUebersetzung("Frühstück", $sprache, $link));
                            ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="zusatz" type="radio" value="Fruehstueck"
                               checked="checked"/>
                    </div>
                </div>
                <?php
            }
            if (getPropertyValue(PENSION_HALB, $unterkunft_id, $link)
                == "true"
            ) {
                ?>
                <div class="form-group">
                    <div class="col-sm-2">
                       <label>
                           <?php
                           echo(getUebersetzung("Halbpension", $sprache, $link));
                           ?>
                       </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="zusatz" type="radio" value="Halbpension"
                               checked="checked"/>
                    </div>
                </div>
                <?php
            }
            if (getPropertyValue(PENSION_VOLL, $unterkunft_id, $link)
                == "true"
            ) {
                ?>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
                            <?php
                            echo(getUebersetzung("Vollpension", $sprache, $link));
                            ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <input name="zusatz" type="radio" value="Vollpension"
                               checked="checked"/>
                    </div>
                </div>
                <?php
            }
            //PREIS anzeigen falls einer vorhanden ist:
            if ($preis > 0) {
                ?>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
                            <?php
                            echo(getUebersetzung("Gesamtpreis", $sprache, $link));
                            ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <?php echo $preis ?> <?php echo getWaehrung(
                            $unterkunft_id
                        ) ?>
                        <input type="hidden" name="preis"
                               value="<?php echo $preis ?>"/>
                    </div>
                </div>
                <?php
            }
            ?>

        <div class="form-group">
            <div class="col-sm-12">
                <label>
                    (<?php echo(getUebersetzung(
                        "Die mit * gekennzeichneten Felder müssen ausgefüllt werden!",
                        $sprache, $link
                    )); ?>)
                    <?php if (!isset($zimmer_ids)) {
                        ?>
                        <input name="zimmer_id" type="hidden" id="zimmer_id"
                               value="<?php echo $zimmer_id ?>">
                    <?php }
                    ?>
                    <input name="vonTag" type="hidden" id="vonTag"
                           value="<?php echo $vonTag ?>">
                    <input name="bisTag" type="hidden" id="bisTag"
                           value="<?php echo $bisTag ?>">
                    <input name="vonMonat" type="hidden" id="vonMonat"
                           value="<?php echo $vonMonat ?>">
                    <input name="bisMonat" type="hidden" id="bisMonat"
                           value="<?php echo $bisMonat ?>">
                    <input name="vonJahr" type="hidden" id="vonJahr"
                           value="<?php echo $vonJahr ?>">
                    <input name="bisJahr" type="hidden" id="bisJahr"
                           value="<?php echo $bisJahr ?>">
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <label>
                    <?php echo(getUebersetzung(
                        "Hinweis: Es handelt sich hierbei um eine Reservierungs-Anfrage.",
                        $sprache, $link
                    ));
                    echo(getUebersetzung(
                        "Der Vermieter wird sich mit Ihnen in Verbindung setzen um gegebenenfalls die Reservierung zu bestätigen.",
                        $sprache, $link
                    )); ?>
                </label>
            </div>
        </div>

    </div>

    <div class="form-group">
        <div class="col-sm-12" style="text-align: right;">
                    <input name="send" type="submit" class="btn btn-primary"
                           id="send"
                           value="<?php echo(getUebersetzung(
                               "Absenden", $sprache, $link
                           )); ?>">

        </div>
    </div>
</form>
