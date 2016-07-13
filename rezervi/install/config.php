<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Installation Rezervi</title>
    <link href="../templates/stylesheets.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Bootstrap ende -->
    <script language="JavaScript" type="text/JavaScript">
        <!--
        function checkForm() {
            if (document.formConfig.unterkunft_name.value == "") {

                alert(<?php
                    if ($_POST["sprache"] == "de"){
                    ?>
                    "Bitte geben sie den Namen ihrer Unterkunfte in!"
                <?php
                }
                else{
                ?>
                "Please fill in the name of your accomodation!"
                <?php
                }
                ?>)
                ;

                return false;
            }

            if (document.formConfig.mietobjekt_ez.value == "") {
                alert(<?php
                    if ($_POST["sprache"] == "de"){
                    ?>
                    "Bitte geben sie den Namen ihres Mietobjektes ein (Einzahl)!"
                <?php
                }
                else{
                ?>
                "Please fill in the name of your object to rent (singular)!"
                <?php
                }
                ?>)
                ;
                return false;
            }

            if (document.formConfig.mietobjekt_mz.value == "") {
                alert(<?php
                    if ($_POST["sprache"] == "de"){
                    ?>
                    "Bitte geben sie den Namen ihres Mietobjektes ein (Mehrzahl)!"
                <?php
                }
                else{
                ?>
                "Please fill in the name of your object to rent (plural)!"
                <?php
                }
                ?>)
                ;
                return false;
            }

            if (document.formConfig.art.value == "") {
                alert(<?php
                    if ($_POST["sprache"] == "de"){
                    ?>
                    "Bitte geben sie den Art ihrer Unterkunft ein!"
                <?php
                }
                else{
                ?>
                "Please fill in the type of your accomodation!"
                <?php
                }
                ?>
            )
                ;
                return false;
            }

            return true;
        }
        -->
    </script>
</head>

<body class="backgroundColor" data-pinterest-extension-installed="cr1.39.1">
<div class="container" style="margin-top:70px;">

    <h1>Rezervi availability overview and guest database<br/>
        Rezervi Belegungsplan und Kundendatenbank</h1>
    <p <?php
    if (isset($fehler) && $fehler == true)
        echo("class=\"belegt\"");
    else
        echo("class=\"frei\"");
    ?>><?php
        if (isset($antwort))
            echo($antwort);
        ?></p>

    <!-- Neues Design -->

    <div class="panel panel-default">
        <div class="panel-body">

            <form action="install.php" method="post" class="form-horizontal" id="formConfig" name="formConfig"
                  target="_self" onSubmit="return checkForm();">
                <input type="hidden" name="sprache" value="<?= $_POST["sprache"] ?>"/>


                <div class="form-group">
                    <label for="anrede" class="col-sm-4 control-label">
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
                    <label for="anrede" class="col-sm-4 control-label">
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
                    <label for="anrede" class="col-sm-4 control-label">
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
                    <label for="anrede" class="col-sm-4 control-label">
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
                <div class="col-md-12">
                    <input name="Submit" type="submit" class="btn btn-default" value="ok">
                </div>
        </div>
    </div>
    </form>


</body>
</html>