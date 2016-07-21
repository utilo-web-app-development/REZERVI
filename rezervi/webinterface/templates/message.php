<?php
/**
 * Created by PhpStorm.
 * User: emreerden
 * Date: 20.07.16
 * Time: 16:59
 */

    if (isset($nachricht) && $nachricht != "") {
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert <?php
                if (isset($fehler) && $fehler == false) {
                    echo("alert-success");
                } else {
                    echo("alert-danger");
                }
                ?>">
                    <?php echo($nachricht) ?>
                </div>
            </div>
        </div>
        <?php
    }
    ?>