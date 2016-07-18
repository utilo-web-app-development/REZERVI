<?php
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
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

    $res = mysql_query($query, $link);
    if (!$res) {
        echo("Anfrage $query scheitert.");
    }

    $d = mysql_fetch_array($res);
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
?>
<div class="panel panel-default">
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


                <div class="form-group">
                    <label for="jahr" class="col-sm-2 control-label">
                        <?php echo(getUebersetzung("Jahr", $sprache, $link)); ?>
                    </label>
                    <div class="col-sm-4">
                        <select name="jahr" class="form-control" id="jahr" value=""
                                onChange="zimmerNrFormJahrChanged()">
                            <?php
                            for ($l = getTodayYear() - 4; $l < (getTodayYear() + 4); $l++) { ?>
                                <option
                                    value="<?php echo($l); ?>"<?php if ($l == $jahr) echo(" selected"); ?>><?php echo($l); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <label class="col-sm-2 control-label">
                        <?php echo(getUebersetzung("Monat", $sprache, $link)); ?>
                    </label>

                    <div class="col-sm-4">
                        <select name="monat" class="form-control" id="monat"
                                onChange="zimmerNrFormJahrChanged()">
                            <?php
                            for ($i = 1; $i <= 12; $i++) { ?>
                                <option
                                    value="<?php echo $i ?>"<?php if ($i == parseMonthNumber(getTodayMonth())) echo(" selected"); ?>>
                                    <?php echo(getUebersetzung(parseMonthName($i, "de"), $sprache, $link)); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">

                    <label class="col-sm-2 control-label" control-label">
                    <?php echo getZimmerArten($unterkunft_id, $link) ?>
                    </label>

                    <div class="col-sm-3">
                        <select name="zimmer_id" class="form-control" id="zimmer_id"
                                onChange="zimmerNrFormJahrChanged()">
                            <?php
                            $query = "
						select
						Zimmernr, PK_ID
						from
						Rezervi_Zimmer 
						where 
						FK_Unterkunft_ID = '$unterkunft_id'" .
                                " order by Zimmernr
						";

                            $res = mysql_query($query, $link);
                            if (!$res)
                                echo("Anfrage $query scheitert.");
                            while ($d = mysql_fetch_array($res)) { ?>
                                <option value="<?php echo $d["PK_ID"] ?>"<?php if ($zimmer_id == $d["PK_ID"]) {
                                    echo(" selected");
                                } ?>><?php echo(getUebersetzungUnterkunft($d["Zimmernr"], $sprache, $unterkunft_id, $link)); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

            </form>
            <h4>  <?php echo(getUebersetzung("Ansicht wählen", $sprache, $link)); ?>:
            </h4>
            <form action="./ansichtWaehlen.php" method="post" id="ansichtWaehlen" name="ansichtWaehlen" target="kalender">

                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <?php echo(getUebersetzung("Monat/Jahr", $sprache, $link)); ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a
                               onclick="
                                   $('#ansichtWaehlen').submit();
                               "><?php echo(getUebersetzung("Monatsübersicht", $sprache, $link)); ?></a>
                        </li>
                        <li><a
                                onclick="
                                   $('#ansichtWaehlen').submit();
                               "><?php echo(getUebersetzung("Jahresübersicht", $sprache, $link)); ?></a>
                        </li>
                    </ul>
                </div>

                <!--<select name="ansichtWechsel" onChange="submit()" class="btn btn-primary">
                                <option value="0"><?php /*echo(getUebersetzung("Monatsübersicht", $sprache, $link)); */ ?></option>
                                <option value="1"><?php /*echo(getUebersetzung("Jahresübersicht", $sprache, $link)); */ ?></option>
                            </select>-->
                <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo($zimmer_id); ?>">
                <input name="jahr" type="hidden" id="jahr" value="<?php echo($jahr); ?>">
                <input name="monat" type="hidden" id="monat"
                       value="<?php echo(parseMonthNumber($monat)); ?>">

            </form>



                    <form action="./resAendern/resAendern.php" method="post" name="reservierung" target="kalender" class="form-horizontal"
                          id="reservierung">
                        <h4> <?php echo(getUebersetzung("Reservierung ändern", $sprache, $link)); ?>:
                        </h4>

                           <label class="control-label">
                                        <?php
                                        //status = 0: frei
                                        //status = 1: reserviert
                                        //status = 2: belegt
                                        ?>
                                        <input name="status" type="radio" value="2" checked/>
                                    </label>
                             <?php echo(getUebersetzung("belegt", $sprache, $link)); ?>

                            <?php
                            if ($showReservation) {
                                ?>


                                        <label class="control-label">
                                            <input name="status" type="radio" value="1"/>

                                        <?php echo(getUebersetzung("reserviert", $sprache, $link)); ?>
                        </label>

                                <?php
                            }
                            ?>

                                 <label>
                                        <input name="status" type="radio" value="0"/>

                                <?php echo(getUebersetzung("frei", $sprache, $link)); ?>
                                 </label>

                        <div class="form-group">
                            <label class="control-label col-sm-2"><?php echo(getUebersetzung("von", $sprache, $link)); ?>: </label>
                            <div class="col-sm-3">
                                <!--  heutigen tag selectiert anzeigen: -->
                                <select name="vonTag" class="form-control " id="select">
                                    <?php for ($i = 1; $i <= 31; $i++) { ?>
                                        <option
                                            value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) echo(" selected"); ?>><?php echo($i); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <!--  heutiges monat selectiert anzeigen: -->
                                <select name="vonMonat" class="form-control  "s id="vonMonat" onChange="chkDays(0)">
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
                                <select name="vonJahr" class="form-control " id="vonJahr" onChange="chkDays(0)">
                                    <?php
                                    for ($l = getTodayYear() - 4; $l < (getTodayYear() + 4); $l++) { ?>
                                        <option
                                            value="<?php echo $l ?>"<?php if ($l == $jahr) echo(" selected"); ?>><?php echo $l ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>


                             <div class="form-group">
                                 <label class="control-label col-sm-2"><?php echo(getUebersetzung("bis", $sprache, $link)); ?>: </label>
                                 <div class="col-sm-3">
                                     <select name="bisTag" class="form-control" id="select4">
                                         <?php for ($i = 1; $i <= 31; $i++) { ?>
                                             <option
                                                 value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) echo " selected"; ?>><?php echo($i); ?></option>
                                         <?php } ?>
                                     </select>
                                 </div>
                                 <div class="col-sm-3">
                                     <!--  heutiges monat selectiert anzeigen: -->
                                     <select name="bisMonat" class="form-control" id="bisMonat" onChange="chkDays(1)">
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

                        <div class="form-group">
                            <div class="col-sm-offset-6 col-sm-3" >
                                <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo $zimmer_id ?>">
                                <input name="reservierungAendern" type="submit" class="btn btn-primary"
                                       id="reservierungAbsenden2"
                                       value="<?php echo(getUebersetzung("Reservierung ändern", $sprache, $link)); ?>">
                            </div>
                        </div>

                    </form>
                <div class="form-group">
                    <form action="../inhalt.php" method="post" name="hauptmenue" target="_parent">
                        <input type="submit" name="Submit3"
                               value="<?php echo(getUebersetzung("Hauptmenü", $sprache, $link)); ?>"
                               class="btn btn-success"   >
                    </form>
                </div>



                    <span >
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
