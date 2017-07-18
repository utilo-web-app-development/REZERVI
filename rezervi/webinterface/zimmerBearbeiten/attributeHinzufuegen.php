<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
<html>
<body>
<?php
/**
 * Created on 31.08.2006
 *
 * @author coster
 * add, edit or delete attributes of rooms
 */

session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
include_once("../../conf/rdbmsConfig.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/zimmerAttributes.inc.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/benutzerFunctions.php");
include_once($root . "/include/propertiesFunctions.php");

//variablen initialisieren:
if (isset($_POST["ben"]) && isset($_POST["pass"])) {
    $ben  = $_POST["ben"];
    $pass = $_POST["pass"];
}
else {
    //aufruf kam innerhalb des webinterface:
    $ben  = getSessionWert(BENUTZERNAME);
    $pass = getSessionWert(PASSWORT);
}

$benutzer_id = -1;
if (isset($ben) && isset($pass)) {
    $benutzer_id = checkPassword($ben, $pass, $link);
}
if ($benutzer_id == -1) {
    //passwortprüfung fehlgeschlagen, auf index-seite zurück:
    $fehlgeschlagen = true;
    header(
        "Location: " . $URL . "webinterface/index.php?fehlgeschlagen=true"
    ); /* Redirect browser */
    exit();
    //include_once("./index.php");
    //exit;
}
else {
    $benutzername = $ben;
    $passwort     = $pass;
    setSessionWert(BENUTZERNAME, $benutzername);
    setSessionWert(PASSWORT, $passwort);

    //unterkunft-id holen:
    $unterkunft_id = getUnterkunftID($benutzer_id, $link);
    setSessionWert(UNTERKUNFT_ID, $unterkunft_id);
    setSessionWert(BENUTZER_ID, $benutzer_id);
}


//variablen intitialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$benutzername  = getSessionWert(BENUTZERNAME);
$passwort      = getSessionWert(PASSWORT);
$sprache       = getSessionWert(SPRACHE);

include_once("../templates/headerA.php");
?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php
include_once("../templates/headerB.php");
include_once("../templates/bodyA.php");
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>
            <?php echo getUebersetzung(
                "Weitere Attribute für Zimmer/Appartement/Wohnung/etc. bearbeiten",
                $sprache, $link
            ) ?>
            .
        </h2>
    </div>
    <div class="panel-body">
        <?php
        //passwortprüfung:
        if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {

            ?>

            <?php
            if (isset($nachricht) && $nachricht != "") {
                ?>
                <div role="alert" class="alert alert-info

                <?php if (isset($fehler) && $fehler == false) {
                    echo("frei");
                }
                else {
                    echo("belegt");
                } ?> ">
                    <?php echo $nachricht ?>
                </div>
                <?php
            }
            ?>
            <form action="./attributeAendern.inc.php" method="post"
                  target="_self">
                <div class="well">
                    <div class="row">
                        <div class="col-sm-5">
                            <label
                                    class="control-label">  <?php echo getUebersetzung(
                                    "Bezeichnung", $sprache, $link
                                ) ?></label>
                        </div>
                        <div class="col-sm-5">
                            <label
                                    class="control-label"> <?php echo getUebersetzung(
                                    "Beschreibung", $sprache, $link
                                ) ?></label>
                        </div>
                    </div>
                    <?php
                    //alle bestehenden attribute auslesen:
                    $res = getAttributes();
                    while ($d = mysqli_fetch_array($res)) {
                        $bezeichnung  = $d["Bezeichnung"];
                        $beschreibung = $d["Beschreibung"];
                        $att_id       = $d["PK_ID"];
                        ?>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="text"
                                       name="bezeichnung_<?php echo $att_id ?>"
                                       value="<?php echo $bezeichnung ?>">
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control" type="text"
                                       name="beschreibung_<?php echo $att_id ?>"
                                       value="<?php echo $beschreibung ?>">
                            </div>
                            <div class="col-sm-2">
                                <input name="loeschen_<?php echo $att_id ?>"
                                       type="submit"
                                       id="loeschen_<?php echo $att_id ?>"
                                       class="btn btn-danger"
                                       style="width: 100%;"
                                       value="<?php echo(getUebersetzung(
                                           "löschen", $sprache, $link
                                       )); ?>"/>
                            </div>
                        </div>
                        <br>
                        <?php
                    } //ende while attribute
                    ?>
                    <br>
                    <div class="row">
                        <div class="col-sm-5">
                            <input class="form-control" type="text"
                                   name="bezeichnung_neu">
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="text"
                                   name="beschreibung_neu">
                        </div>
                        <div class="col-sm-2">
                            <input name="hinzufuegen" type="submit"
                                   id="hinzufuegen" class="btn btn-success"
                                   style="width: 100%;"
                                   value="<?php echo(getUebersetzung(
                                       "hinzufügen", $sprache, $link
                                   )); ?>"/>
                        </div>
                    </div>
                    <input type="hidden" name="att_id"
                           value="<?php echo $att_id ?>"/>
                    <h4>
                        <?php echo getUebersetzung(
                            "Attribute anzeigen", $sprache, $link
                        ) ?>:
                    </h4>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="label-control">
                                <?php echo getUebersetzung(
                                    "Gesamtübersicht", $sprache, $link
                                ) ?>
                            </label>
                        </div>
                        <div class="col-sm-1">
                            <input type="checkbox" name="showInGesamtuebersicht"
                                   value="true"
                                <?php
                                $show = getPropertyValue(
                                    SHOW_ZIMMER_ATTRIBUTE_GESAMTUEBERSICHT,
                                    $unterkunft_id, $link
                                );
                                if ($show == "true") {
                                    ?> checked="checked" <?php
                                }
                                ?>
                            />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-9 col-sm-3"
                         style="text-align: right;">
                        <input name="aendern" type="submit" id="aendern"
                               class="btn btn-success"
                               value="<?php echo(getUebersetzung(
                                   "ändern", $sprache, $link
                               )); ?>"/>
                        <a class="btn btn-primary" href="./index.php">
                            <!--                            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;-->
                            <?php echo(getUebersetzung(
                                "zurück", $sprache, $link
                            )); ?>
                        </a>
                    </div>
                </div>
            </form>
            <?php
        }
        else {
            echo(getUebersetzung(
                "Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",
                $sprache, $link
            ));
        }
        ?>
    </div>
</div>
</body>
</html>

