<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");

/*   
	reservierungsplan
	startseite zur wartung der zimmer
	author: christian osterrieder utilo.eu						
	
	dieser seite muss übergeben werden:
	Benutzer PK_ID $benutzer_id
*/

//variablen:
$sprache = getSessionWert(SPRACHE);
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/propertiesFunctions.php");
include_once("../templates/components.php");

?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php //passwortprüfung:	
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)){
?>
<?php /*
		zimmer Ändern:
		nur wenn bereits zimmer angelegt wurden:
		*/
$anzahlVorhandenerZimmer = getAnzahlVorhandeneZimmer($unterkunft_id, $link);
if ($anzahlVorhandenerZimmer > 0){
?>
<?php
if (isset($nachricht) && $nachricht != "") {
    ?>
    <table class="<?php if (isset($fehler) && $fehler == true) {
        echo("belegt");
    } else {
        echo("standardSchriftBold");
    }
    ?>">
        <tr>
            <td><?php echo($nachricht); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <br/>
    <?php
}
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Zimmer/Appartement/Wohnung/etc. anlegen/bearbeiten/löschen", $sprache, $link)); ?></h2>
    </div>
    <div class="panel-body">
        <form action="./zimmerAendern.php" method="post" name="immerAnlegen" target="_self" class="form-horizontal">
            <div class="row">
                <label class="control-label col-sm-6" style="text-align: left;">
                    <?php echo(getUebersetzung("Bitte wählen Sie das zu verändernde Zimmer/Appartement/Wohnung/etc. aus", $sprache, $link)); ?>:
                </label>
                <div class="col-sm-3">
                    <select name="zimmer_id" type="text" id="zimmer_id" value="" class="form-control">
                        <?php
                        $res = getZimmer($unterkunft_id, $link);
                        //zimmer ausgeben:
                        $i = 0;
                        while ($d = mysql_fetch_array($res)) {
                            $ziArt = getUebersetzungUnterkunft($d["Zimmerart"], $sprache, $unterkunft_id, $link);
                            $ziNr = getUebersetzungUnterkunft($d["Zimmernr"], $sprache, $unterkunft_id, $link);
                            ?>
                            <option value="<?php echo $d["PK_ID"] ?>"<?php
                            if ($i == 0) {
                                ?>
                                selected="selected"
                                <?php
                            }
                            $i++;
                            ?>
                            >
                                <?php echo $ziArt . " " . $ziNr ?>
                            </option>
                            <?php
                        } //ende while
                        //ende zimmer ausgeben
                        ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input name="submit" type="submit" id="submit" class="btn btn-primary" style="width: 100%;"
                           value="<?php echo(getUebersetzung("Zimmer ändern", $sprache, $link)); ?>">
                </div>
            </div>
        </form>
        <div class="row">
            <hr>
        </div>
        <?php
        //-------------ende zimmer ändern
        /*
        //-------------Zimmer löschen
        prüfen ob zimmer überhaupt vorhanden sind übernimmt prüfung bei zimmerändern
        */
        ?>
        <form action="./zimmerLoeschenBestaetigen.php" method="post" name="zimmerLoeschenBestaetigen" target="_self" class="form-horizontal">
            <div class="row">
                <label class="control-label col-sm-6" style="text-align: left">
                    <?php echo(getUebersetzung("Bitte wählen Sie die zu löschenden Zimmer/Appartement/Wohnung/etc. aus", $sprache, $link)); ?>.
                    <?php echo(getUebersetzung("Sie können mehrere Zimmer/Appartements/Wohnungen/etc. zugleich auswählen und löschen indem Sie die [STRG]-Taste gedrückt halten und auf die Bezeichnung klicken", $sprache, $link)); ?>.
                </label>

                <div class="col-sm-3">
                    <select name="zimmer_id[]" type="text" id="zimmer_id[]" value="" class="form-control">

                        <?php
                        $res = getZimmer($unterkunft_id, $link);
                        //zimmer ausgeben:
                        $i = 0;
                        while ($d = mysql_fetch_array($res)) {
                            $ziArt = getUebersetzungUnterkunft($d["Zimmerart"], $sprache, $unterkunft_id, $link);
                            $ziNr = getUebersetzungUnterkunft($d["Zimmernr"], $sprache, $unterkunft_id, $link);
                            ?>
                            <option value="<?php echo $d["PK_ID"] ?>"<?php
                            if ($i == 0) {
                                ?>
                                selected="selected"
                                <?php
                            }
                            $i++;
                            ?>
                            >
                                <?php echo $ziArt . " " . $ziNr ?>
                            </option>
                            <?php
                        } //ende while
                        //ende zimmer ausgeben
                        ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input name="submit" type="submit" id="submit" class="btn btn-danger" style="width: 100%;"
                           value="<?php echo(getUebersetzung("Zimmer löschen", $sprache, $link)); ?>">
                </div>
            </div>
        </form>

        <?php
        } //ende anzahlVorhandenerZimmer ist ok
        ?>
        <div class="row">
            <hr>
        </div>
        <?php
        /*
        //---zimmer anlegen:
        prüfen ob noch weitere zimmer angelegt werden können:
        */
        $anzahlZimmer = getAnzahlZimmer($unterkunft_id, $link);
        if ($anzahlVorhandenerZimmer < $anzahlZimmer) {
            ?>
                <div class="row">
                    <label class="control-label col-sm-9" style="text-align: left;">
                        <?php echo(getUebersetzung("Zimmer/Appartement/Wohnung/etc. anlegen", $sprache, $link)); ?>.
                    </label>
                    <div class="col-sm-3">
                        <a class="btn btn-primary" href="./zimmerAnlegen.php" style="width: 100%;">
                            <span class="glyphicon glyphicon-plus-sign"  aria-hidden="true"></span>&nbsp;
                            <?php echo(getUebersetzung("Zimmer anlegen", $sprache, $link)); ?>
                        </a>
                    </div>
                </div>
            <div class="row">
                <hr>
            </div>
            <?php
            //hochladen von bildern, falls dies aktiviert wurde
            $active = getPropertyValue(ZIMMER_THUMBS_ACTIV, $unterkunft_id, $link);
            $active2 = getPropertyValue(ZIMMER_THUMBS_AV_OV, $unterkunft_id, $link);
            if ($active != "true") {
                $active = false;
            } else {
                $active = true;
            }
            if ($active2 != "true") {
                $active2 = false;
            } else {
                $active2 = true;
            }
            if ($active || $active2) {
                ?>
                <form action="./bilderHochladen.php" method="post" name="bilder" id="bilder" target="_self" class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-9">
                            <label class="control-label">
                                <?php echo(getUebersetzung("Bilder für Zimmer/Appartement/Wohnung/etc. hochladen", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <input name="hochladen" type="submit" class="btn btn-primary" id="hochladen" style="width: 100%;"
                                   value="<?php echo(getUebersetzung("Bilder hochladen", $sprache, $link)); ?>">
                        </div>
                    </div>
                </form>
                <form action="./bilderLoeschen.php" method="post" name="bilder" target="_self" id="bilder">
                    <div class="row">
                        <div class="col-sm-9">
                            <label class="control-label">
                                <?php echo(getUebersetzung("Bilder für Zimmer/Appartement/Wohnung/etc. löschen", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <input name="hochladen" type="submit" class="btn btn-primary" id="hochladen" style="width: 100%;"
                                   value="<?php echo(getUebersetzung("Bilder löschen", $sprache, $link)); ?>">
                        </div>
                    </div>
                </form>
                <?php
            } //ende bilder hochladen
            ?>
            <?php
        } //ende zimmer anlegen
        if ($anzahlVorhandenerZimmer > 0) {
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <label class="control-label">
                        <?php echo(getUebersetzung("Preise hinzufügen, ändern, löschen", $sprache, $link)); ?>
                        <?php echo(getUebersetzung("Der Standardpreis ist gültig wenn zum ausgewählten Zeitpunkt " + "kein Saisonpreis angegeben wurde.", $sprache, $link)); ?>
                    </label>
                </div>
                <div class="col-sm-3">
                    <!-- preise definieren -->
                        <a class="btn btn-primary" href="./preis.php" style="width: 100%;" target="_self">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;
                            <?php echo(getUebersetzung("Saisonpreise bearbeiten", $sprache, $link)); ?>
                        </a>
                </div>
                <div class="col-sm-3">
                    <!-- standardpreis definieren -->
                        <a class="btn btn-primary" href="./standardpreis.php" style="width: 100%;" target="_self">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;
                            <?php echo(getUebersetzung("Standardpreise bearbeiten", $sprache, $link)); ?>
                        </a>
                </div>
            </div>
            <div class="row">
                <hr>
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <label class="control-label">
                        <?php echo(getUebersetzung("Falls Sie ein Haus mit mehreren Zimmern vermieten und die Zimmer des " .
                            "Hauses und das Haus selbst vermieten wollen, können Sie hier die Zimmer zum Haus " .
                            "festlegen. Das Haus und die Zimmer müssen vorher angelegt worden sein.", $sprache, $link)); ?>
                    </label>
                </div>
                <div class="col-sm-3">
                    <!-- end preise definieren -->
                    <!-- zusammenfassen von zimmern zu haus -->
                        <a class="btn btn-primary" href="./mergeRooms/index.php" style="width: 100%;" target="_self"><span
                                class="glyphicon glyphicon-pencil"
                                aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("Zimmer zusammenfassen", $sprache, $link)); ?>
                        </a>
                </div>
            </div>
            <!-- end zusammenfassen von zimmern zu haus -->
        <?php }//ende wenn zimmer vorhanden
        ?>
        <div class="row">
            <hr>
        </div>
        <!-- hinzufügen von weiteren attributen für zimmer -->
        <div class="row">
            <div class="col-sm-9">
                <label class="control-label">
                    <?php echo(getUebersetzung("Weitere Attribute für Zimmer/Appartement/Wohnung/etc. bearbeiten", $sprache, $link)); ?>
                </label>
            </div>
            <div class="col-sm-3">
                    <a class="btn btn-primary" href="./attributeHinzufuegen.php" style="width: 100%;" target="_self">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;
                        <?php echo(getUebersetzung("Attribute ändern", $sprache, $link)); ?>
                    </a>
            </div>
        </div>
        <!-- end hinzufügen von weiteren attributen für zimmer -->
        <?php
        } //ende if passwortprüfung
        else {
            echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
        }
        ?>
    </div>
</div>
<?php include_once("../templates/end.php"); ?>
