<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

    $fehlgeschlagen = true;
    ?>
    <form action="./index.php" method="post" id="fehlerRedirectForm">
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

?>