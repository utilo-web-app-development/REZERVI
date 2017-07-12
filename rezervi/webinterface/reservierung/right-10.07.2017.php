<?php
/*$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");*/
/*   
	reservierungsplan
	anzeige des kalenders
	author: christian osterrieder utilo.eu		
	
	dieser seite muss übergeben werden:
	Unterkunft PK_ID ($unterkunft_id)
*/

/*//funktions einbinden:
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/datumFunctions.php");
include_once("../../include/reservierungFunctions.php");
include_once("../../include/gastFunctions.php");
include_once("../../include/benutzerFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("./rightHelper.php");	
include_once("../../leftHelper.php");
include_once("../../include/propertiesFunctions.php");*/

//variablen initialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

if (isset($_POST["zimmer_id"])) {
    $zimmer_id = $_POST["zimmer_id"];
} else {
    $zimmer_id = getFirstRoom($unterkunft_id, $link);
}
if (isset($_POST["monat"])) {
    $monat = $_POST["monat"];
} else {
    $monat = parseMonthNumber(getTodayMonth());
}
if (isset($_POST["jahr"])) {
    $jahr = $_POST["jahr"];
} else {
    $jahr = getTodayYear();
}
//ich brauche für jahr einen integer:
$jahr += 1;
$jahr -= 1;
//und fürs monat einen integer
$monat -= 1;
$monat += 1;

$sprache = getSessionWert(SPRACHE);
$saAktiviert = getPropertyValue(SHOW_OTHER_COLOR_FOR_SA, $unterkunft_id, $link);

setSessionWert(ZIMMER_ID, $zimmer_id);
//include_once("rightJS.js.php");
?>
<div class="panel panel-default" id="rightView">
    <div class="panel-heading">
        <?php echo(getUebersetzung("Belegungsplan", $sprache, $link)); ?> <?php echo($monat . "-" . $jahr); ?>,
        <?php echo(getUebersetzung("für", $sprache, $link)); ?> <?php echo(getUebersetzungUnterkunft(getZimmerArt($unterkunft_id, $zimmer_id, $link), $sprache, $unterkunft_id, $link)); ?>
        -<?php echo(getUebersetzungUnterkunft(getZimmerNr($unterkunft_id, $zimmer_id, $link), $sprache, $unterkunft_id, $link)); ?>
    </div>
    <div class="panel-body">
        <?php
        //passwortprüfung:
        if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
            ?>

            <div id="monthView">
                <?php
                //kontrolle ob monat nicht 0 oder 13:
                if ($monat > 12) {
                    $monat = 1;
                    $jahr = $jahr + 1;
                } elseif ($monat < 1) {
                    $monat = 12;
                    $jahr = $jahr - 1;
                }
                //monat ausgeben:
                showMonth($monat, $jahr, $unterkunft_id, $zimmer_id, $sprache, $saAktiviert, $link);
                ?>
            </div>

            <div class="form-group">
                <hr>
            </div>
            <div id="NPButtons">
                <div id="monthViewButtons" ng-show="show">
                    <div class="row">
                        <div class="col-sm-offset-1 col-sm-3">
                            <?php
                            $mon = $monat - 1;
                            $jah = $jahr;
                            if ($mon < 1) {
                                $mon = 12;
                                $jah = $jah - 1;
                            }
                            ?>
                            <input name="zimmer_id_right" type="hidden" id="zimmer_id_right" ng-model="zimmer_id_right"
                                   value="<?php echo $zimmer_id ?>">
                            <input name="monat_right" type="hidden" id="monat_right" value="<?php echo($mon); ?>">
                            <input name="jahr_right" type="hidden" id="jahr_right" value="<?php echo($jah); ?>">
                            <input name="zurueck" type="button" class="btn btn-primary" ng-model="getpreviousMonth"
                                   ng-click="previousMonth();"
                                   id="zurueck"
                                   value="<?php echo(getUebersetzung("einen Monat zurück", $sprache, $link)); ?>">
                        </div>

                        <div class="col-sm-offset-4 col-sm-3">
                            <?php
                            $mon = $monat + 1;
                            $jah = $jahr;
                            if ($mon > 12) {
                                $mon = 1;
                                $jah = $jah + 1;
                            }
                            ?>
                            <input name="weiter" type="button" class="btn btn-primary" ng-model="getnextMonth"
                                   ng-click="nextMonth();"
                                   id="weiter"
                                   value="<?php echo(getUebersetzung("einen Monat weiter", $sprache, $link)); ?>">
                        </div>
                    </div>
                </div>
                <div id="yearViewButtons" ng-show="!show">
                    <div class="row">
                        <div class="col-sm-offset-1 col-sm-3">
                            <input name="zurueckyear" type="button" class="btn btn-primary"
                                   ng-show="showzurueckyear"
                                   ng-click="previousYear();"
                                   id="zurueckyear"
                                   value="<?php echo(getUebersetzung("ein Jahr zurück",$sprache,$link)); ?>">
                        </div>
                        <div class="col-sm-offset-4 col-sm-3">
                            <input name="weiteryear" type="button" class="btn btn-primary"
                                   ng-show="showweiteryear"
                                   ng-click="nextYear();"
                                   id="weiteryear"
                                   value="<?php echo(getUebersetzung("ein Jahr weiter",$sprache,$link)); ?>">
                        </div>
                    </div>
                </div>

            </div>

            <?php
        } //ende passwortprüfung
        else {
            echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
        }
        ?>
    </div>
</div>
