<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */
?>

<div class="alert alert-warning"
     role="alert">
    <?php echo(getUebersetzung(
        "Leider haben wir nicht mehr genug ",
        $sprache, $link
    ));
    echo(getUebersetzungUnterkunft(
        getZimmerart_MZ(
            $unterkunft_id, $link
        ), $sprache,
        $unterkunft_id, $link
    ));
    echo("&nbsp;" . getUebersetzung(
            "im gewünschten Zeitraum frei.",
            $sprache, $link
        ));
    ?>
</div>
