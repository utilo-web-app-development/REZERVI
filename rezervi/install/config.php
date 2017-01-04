<?php
session_start();
$root = "..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/conf/rdbmsConfig.php");
include_once($root . "/layouts/header.php");

?>
<title>Installation Rezervi</title>
<?php include_once($root . "/layouts/headerEnd.php"); ?>

<body class="backgroundColor" data-pinterest-extension-installed="cr1.39.1">
<div class="container" style="margin-top:20px;">
    <div class="panel panel-default" ng-app="rezerviApp" ng-controller="MainController">

        <div class="panel-heading">
            <h2>
                <?php
                if ($_POST["sprache"] == "de") {
                    ?>
                    Rezervi Belegungsplan und Kundendatenbank
                    <?php
                } else {
                    ?>
                    Rezervi availability overview and guest database
                    <?php
                }
                ?>
            </h2>
        </div>
        <div class="panel-body">

            <form action="install.php" method="post" class="form-horizontal" id="formConfig" name="formConfig"
                  target="_self" >


                <div class="form-group">
                    <label for="anrede" class="col-sm-4">
                        <?php
                        if ($_POST["sprache"] == "de") {
                            ?>
                            Name ihrer Unterkunft
                            <?php
                        } else {
                            ?>
                            Name of your accomodation
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-8">
                        <input name="unterkunft_name" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="anrede" class="col-sm-4 ">
                        <?php
                        if ($_POST["sprache"] == "de") {
                            ?>
                            Art ihrer Unterkunft (z. B. Hotel)
                            <?php
                        } else {
                            ?>
                            Type of your accomodation (eg. Hotel)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-8">
                        <input name="art" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="anrede" class="col-sm-4 ">
                        <?php
                        if ($_POST["sprache"] == "de") {
                            ?>
                            Bezeichnung ihres Mietobjektes - Einzahl (z. B. Zimmer, Appartement)
                            <?php
                        } else {
                            ?>
                            Name of your object to rent - singular (eg. room, apartement)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-8">
                        <input name="mietobjekt_ez" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="anrede" class="col-sm-4 ">
                        <?php
                        if ($_POST["sprache"] == "de") {
                            ?>
                            Bezeichnung ihres Mietobjektes - Mehrzahl (z. B. Zimmer, Appartements)
                            <?php
                        } else {
                            ?>
                            Name of your object to rent - plural (eg. rooms, apartements)
                            <?php
                        }
                        ?>
                    </label>
                    <div class="col-sm-8">
                        <input name="mietobjekt_mz" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-offset-10 col-md-2">
                    <input name="Submit" type="submit" class="btn btn-success" ng-disabled="!formConfig.$valid" value="<?php
                    if ($_POST["sprache"] == "de") {
                        ?>Weiter<?php
                    } else {
                        ?>Continue<?php
                    }
                    ?>">
                </div>
        </div>
    </div>
    </form>

</div>
<script>
    var rezervi = angular.module('rezerviApp', []);

    rezervi.controller('MainController', function($scope) {

    });
</script>
</body>
</html>