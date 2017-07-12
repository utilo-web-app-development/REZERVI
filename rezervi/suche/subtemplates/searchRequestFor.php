<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */
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
                    }
                    else {
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
                        }
                        else {
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