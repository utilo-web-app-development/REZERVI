<?php
/**
 * @package     ${NAMESPACE}
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

$messageDanger = $_POST["messageDanger"];
$messageWarning = $_POST["messageWarning"];

if(isset($messageDanger)){
    ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo $messageDanger; ?>
    </div>
<?php
}
?>
<?php
if(isset($messageWarning)){
    ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo $messageWarning; ?>
    </div>
    <?php
}
?>

