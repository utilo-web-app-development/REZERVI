<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

?>
<div class="row">
    <div class="col-sm-12" style="text-align: right;">
        <form action="../suche/sucheDurchfuehren.php" method="post" name="form1" target="_self">
            <!--<form action="../ansichtWaehlen.php" method="post" name="form1" target="_self">-->
            <input name="zimmer_id" type="hidden" value="<?php echo($zimmer_id); ?>">
            <input name="jahr" type="hidden" value="<?php echo($vonJahr); ?>">
            <input name="monat" type="hidden" value="<?php echo($vonMonat); ?>">
            <input type="submit" name="Submit" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>" class="btn btn-default" >
        </form>
    </div>
</div>


