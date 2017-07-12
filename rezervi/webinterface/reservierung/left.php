<?php
//$root = "../..";
// Set flag that this is a parent file
/*define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");*/
/*   
	reservierungsplan
	steuerung des kalenders und reservierung für den gast
	author: christian osterrieder utilo.eu
	
	dieser seite kann optional übergeben werden:
	Zimmer PK_ID ($zimmer_id)
	Jahr ($jahr)
	Monat ($monat)
	
	dieser seite muss übergeben werden:
	Unterkunft PK_ID ($unterkunft_id)
*/

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
//include_once("../../conf/rdbmsConfig.php");
/*//datums-funktionen einbinden:
include_once("../../include/datumFunctions.php");
include_once("../../include/benutzerFunctions.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/propertiesFunctions.php");
include_once("../../include/reseller/reseller.php");*/

//falls keine zimmer_id ausgewählt wurde, das erste gefundene zimmer nehmen:
if (!isset($zimmer_id) || $zimmer_id == "" || empty($zimmer_id)) {
    $query = "
			select 
			PK_ID 
			from
			Rezervi_Zimmer
			where
			FK_Unterkunft_ID = '$unterkunft_id' 
			ORDER BY 
			Zimmernr";

    $res = mysqli_query($link, $query);
    if (!$res) {
        echo("Anfrage $query scheitert.");
    }

    $d = mysqli_fetch_array($res);
    $zimmer_id = $d["PK_ID"];
}

//falls kein jahr ausgewählt wurde, das aktuelle jahr verwenden:
if (!isset($jahr) || $jahr == "" || empty($jahr)) {
    $jahr = getTodayYear();
}

//falls kein monat ausgewählt wurde, das aktuelle monat verwenden:
if (!isset($monat) || $monat == "" || empty($monat)) {
    $monat = getTodayMonth();
}
//should the reservation state be shown?
$showReservation = getPropertyValue(SHOW_RESERVATION_STATE, $unterkunft_id, $link);
if ($showReservation != "true") {
    $showReservation = false;
}

include_once("leftJS.js.php");
?>
<div class="panel panel-default" id="leftView">
    <div class="panel-heading">
        <?php echo(getUebersetzung("Belegungsplan", $sprache, $link)); ?>
    </div>
    <div class="panel-body">
        <?php
        //passwortprüfung:
        if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) { ?>


            <form action="./ansichtWaehlen.php" method="post" name="ZimmerNrForm" target="kalender"
                  class="form-horizontal">
                <h4><?php echo(getUebersetzung("Ansicht für", $sprache, $link)); ?>:</h4>
                <input ng-model="language" name="language" id="language" type="hidden"
                       ng-value="<?php echo $sprache ?>">
                <div class="form-group">
                    <div class="col-sm-2 ">
                        <label for="jahr" class="control-label">
                            <?php echo(getUebersetzung("Jahr", $sprache, $link)); ?>
                        </label>
                    </div>

                    <div class="col-sm-4">
                        <select name="year" class="form-control"
                                id="year"
                                value=""
                                ng-model="year"
                                ng-change="yearChanged();"
                                ng-options="item.year as item.year for item in years"
                        >

                        </select>
                    </div>

                    <div class="col-sm-2">
                        <label class="control-label">
                            <?php echo(getUebersetzung("Monat", $sprache, $link)); ?>
                        </label>
                    </div>


                    <div class="col-sm-4">
                        <select name="month" class="form-control"
                                id="month"
                                value=""
                                ng-model="month"
                                ng-change="monthChanged();"
                                ng-options="item.monthIndex as item.month for item in months"
                        >

                        </select>
                    </div>
                </div>

                <div class="form-group">

                    <div class="col-sm-6">
                        <label class="control-label">
                            <?php //echo getZimmerArten($unterkunft_id, $link) ?>
                            <?php echo(getUebersetzung("Zimmer Art-Zimmer Nummer", $sprache, §link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <select name="zimmer_id" class="form-control" id="zimmer_id"
                                ng-model="zimmer_id"
                                ng-change="zimmer_idChanged();"
                                ng-options="item.zimmerid as item.zimmerartnr for item in zimmers"
                        >
                        </select>
                    </div>
                </div>

                <div class="row">
                    <hr>
                </div>

            </form>
            <h4>
                <?php echo(getUebersetzung("Ansicht wählen", $sprache, $link)); ?>:
            </h4>

            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <?php echo(getUebersetzung("Monat/Jahr", $sprache, $link)); ?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a ng-click="changeView(0);">
                            <?php echo(getUebersetzung("Monatsübersicht", $sprache, $link)); ?>
                        </a>
                    </li>
                    <li>
                        <a ng-click="changeView(1);">
                            <?php echo(getUebersetzung("Jahresübersicht", $sprache, $link)); ?>
                        </a>
                    </li>
                </ul>
            </div>

            <input name="zimmer_id_left" type="hidden" id="zimmer_id_left" ng-model="zimmer_id_left" value="{{zimmer_id_left}}">
            <input name="jahr_left" type="hidden" ng-model="jahr_left" id="jahr_left" value="{{jahr_left}}">
            <input name="monat_left" type="hidden" id="monat_left" ng-model="monat_left" value="{{monat_left}}">
            <input name="view" type="hidden" id="view" ng-model="view" value="0">

            <div class="row">
                <hr>
            </div>

            <form action="./resAendern/resAendern.php" method="post"  name="reservierung" target="_blank"
                  class="form-horizontal"
                  id="reservierung">
                <h4>
                    <?php echo(getUebersetzung("Reservierung ändern", $sprache, $link)); ?>:
                </h4>
                <?php
                //status = 0: frei
                //status = 1: reserviert
                //status = 2: belegt
                ?>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-danger active">
                                <input type="radio" name="status" id="belegt" autocomplete="off" value="2" > <?php echo(getUebersetzung("belegt", $sprache, $link)); ?>
                            </label>
                            <?php
                            if ($showReservation) {
                                ?>
                                <label class="btn btn-success">
                                    <input type="radio" name="status" id="reserviert" autocomplete="off" value="1"> <?php echo(getUebersetzung("reserviert", $sprache, $link)); ?>
                                </label>
                                <?php
                            }
                            ?>
                            <label class="btn btn-primary">
                                <input type="radio" name="status" id="frei" autocomplete="off" value="0" checked> <?php echo(getUebersetzung("frei", $sprache, $link)); ?>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2"><?php echo(getUebersetzung("von", $sprache, $link)); ?>
                        : </label>
                    <div class="col-sm-3">
                        <!--  heutigen tag selectiert anzeigen: -->
                        <select name="vonTag" class="form-control " id="vonTag">
                            <?php for ($i = 1; $i <= 31; $i++) { ?>
                                <option
                                        value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) echo(" selected"); ?>><?php echo($i); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <!--  heutiges monat selectiert anzeigen: -->
                        <select name="vonMonat" class="form-control" id="vonMonat" onChange="chkDays(0)">
                            <option
                                    value="1"<?php if (getTodayMonth() == "Januar") echo " selected"; ?>><?php echo(getUebersetzung("Januar", $sprache, $link)); ?></option>
                            <option
                                    value="2"<?php if (getTodayMonth() == "Februar") echo " selected"; ?>><?php echo(getUebersetzung("Februar", $sprache, $link)); ?></option>
                            <option
                                    value="3"<?php if (getTodayMonth() == "März") echo " selected"; ?>><?php echo(getUebersetzung("März", $sprache, $link)); ?></option>
                            <option
                                    value="4"<?php if (getTodayMonth() == "April") echo " selected"; ?>><?php echo(getUebersetzung("April", $sprache, $link)); ?></option>
                            <option
                                    value="5"<?php if (getTodayMonth() == "Mai") echo " selected"; ?>><?php echo(getUebersetzung("Mai", $sprache, $link)); ?></option>
                            <option
                                    value="6"<?php if (getTodayMonth() == "Juni") echo " selected"; ?>><?php echo(getUebersetzung("Juni", $sprache, $link)); ?></option>
                            <option
                                    value="7"<?php if (getTodayMonth() == "Juli") echo " selected"; ?>><?php echo(getUebersetzung("Juli", $sprache, $link)); ?></option>
                            <option
                                    value="8"<?php if (getTodayMonth() == "August") echo " selected"; ?>><?php echo(getUebersetzung("August", $sprache, $link)); ?></option>
                            <option
                                    value="9"<?php if (getTodayMonth() == "September") echo " selected"; ?>><?php echo(getUebersetzung("September", $sprache, $link)); ?></option>
                            <option
                                    value="10"<?php if (getTodayMonth() == "Oktober") echo " selected"; ?>><?php echo(getUebersetzung("Oktober", $sprache, $link)); ?></option>
                            <option
                                    value="11"<?php if (getTodayMonth() == "November") echo " selected"; ?>><?php echo(getUebersetzung("November", $sprache, $link)); ?></option>
                            <option
                                    value="12"<?php if (getTodayMonth() == "Dezember") echo " selected"; ?>><?php echo(getUebersetzung("Dezember", $sprache, $link)); ?></option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <!--  heutiges jahr selectiert anzeigen: -->
                        <select name="vonJahr" class="form-control "  id="vonJahr" onChange="chkDays(0)">
                            <?php
                            for ($l = getTodayYear() - 4; $l < (getTodayYear() + 4); $l++) { ?>
                                <option
                                        value="<?php echo $l ?>"<?php if ($l == $jahr) echo(" selected"); ?>><?php echo $l ?></option>
                            <?php } ?>
                        </select>
                    </div>

                </div>


                <div class="form-group">
                    <label class="control-label col-sm-2"><?php echo(getUebersetzung("bis", $sprache, $link)); ?>
                        : </label>
                    <div class="col-sm-3">
                        <select name="bisTag" class="form-control" id="bisTag">
                            <?php for ($i = 1; $i <= 31; $i++) { ?>
                                <option value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) echo " selected"; ?>><?php echo($i); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <!--  heutiges monat selectiert anzeigen: -->
                        <select name="bisMonat"  class="form-control" id="bisMonat"  onChange="chkDays(1)">
                            <option
                                    value="1"<?php if (getTodayMonth() == "Januar") echo " selected"; ?>><?php echo(getUebersetzung("Januar", $sprache, $link)); ?></option>
                            <option
                                    value="2"<?php if (getTodayMonth() == "Februar") echo " selected"; ?>><?php echo(getUebersetzung("Februar", $sprache, $link)); ?></option>
                            <option
                                    value="3"<?php if (getTodayMonth() == "März") echo " selected"; ?>><?php echo(getUebersetzung("März", $sprache, $link)); ?></option>
                            <option
                                    value="4"<?php if (getTodayMonth() == "April") echo " selected"; ?>><?php echo(getUebersetzung("April", $sprache, $link)); ?></option>
                            <option
                                    value="5"<?php if (getTodayMonth() == "Mai") echo " selected"; ?>><?php echo(getUebersetzung("Mai", $sprache, $link)); ?></option>
                            <option
                                    value="6"<?php if (getTodayMonth() == "Juni") echo " selected"; ?>><?php echo(getUebersetzung("Juni", $sprache, $link)); ?></option>
                            <option
                                    value="7"<?php if (getTodayMonth() == "Juli") echo " selected"; ?>><?php echo(getUebersetzung("Juli", $sprache, $link)); ?></option>
                            <option
                                    value="8"<?php if (getTodayMonth() == "August") echo " selected"; ?>><?php echo(getUebersetzung("August", $sprache, $link)); ?></option>
                            <option
                                    value="9"<?php if (getTodayMonth() == "September") echo " selected"; ?>><?php echo(getUebersetzung("September", $sprache, $link)); ?></option>
                            <option
                                    value="10"<?php if (getTodayMonth() == "Oktober") echo " selected"; ?>><?php echo(getUebersetzung("Oktober", $sprache, $link)); ?></option>
                            <option
                                    value="11"<?php if (getTodayMonth() == "November") echo " selected"; ?>><?php echo(getUebersetzung("November", $sprache, $link)); ?></option>
                            <option
                                    value="12"<?php if (getTodayMonth() == "Dezember") echo " selected"; ?>><?php echo(getUebersetzung("Dezember", $sprache, $link)); ?></option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <!--  heutiges jahr selectiert anzeigen: -->
                        <select name="bisJahr" class="form-control" id="bisJahr" onChange="chkDays(1)">
                            <?php
                            for ($l = getTodayYear() - 4; $l < (getTodayYear() + 4); $l++) { ?>
                                <option
                                        value="<?php echo($l); ?>"<?php if ($l == $jahr) echo(" selected"); ?>><?php echo($l); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-offset-6 col-sm-6" style="text-align: right;">
                        <input name="zimmer_id" type="hidden" id="zimmer_id_reservierung_aendern" ng-model="zimmer_id_reservierung_aendern" value="{{zimmer_id_reservierung_aendern}}">
                        <button name="reservierungAendern" type="submit" class="btn btn-primary"
                                id="reservierungAbsenden2">
                            <span class="glyphicon glyphicon-wrench"></span>
                            <?php echo(getUebersetzung("Reservierung ändern", $sprache, $link)); ?>
                        </button>
                    </div>
                </div>

            </form>

            <div class="row">
                <hr>
            </div>
            <div class="form-group">
                <form action="../inhalt.php" method="post" name="hauptmenue" target="_parent">
                    <button type="submit" name="Submit3" class="btn btn-success">
                        <span class="glyphicon glyphicon-home"></span>
                        <?php echo(getUebersetzung("Hauptmenü", $sprache, $link)); ?>
                    </button>

                </form>
            </div>


            <span>
                        <?php if ($isReseller) { ?>
                            <font size="2">&copy;
                                <a href="<?php echo $resellerUrl ?>" target="_parent"><?php echo $resellerName ?></a>
                        </font>
                        <?php } else { ?>
                            <font size="2">&copy;
                                <a href="http://www.utilo.eu" target="_parent">utilo.eu</a>
                        </font>
                        <?php } ?>
                    </span>

        <?php } //ende passwortprüfung
        else {
            echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
        }
        ?>
    </div>
</div>
