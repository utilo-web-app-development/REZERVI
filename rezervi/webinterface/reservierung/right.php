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

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo(getUebersetzung("Belegungsplan", $sprache, $link)); ?> <?php echo($monat . "-" . $jahr); ?>,
        <?php echo(getUebersetzung("für", $sprache, $link)); ?> <?php echo(getUebersetzungUnterkunft(getZimmerArt($unterkunft_id, $zimmer_id, $link), $sprache, $unterkunft_id, $link)); ?>
        <?php echo(getUebersetzungUnterkunft(getZimmerNr($unterkunft_id, $zimmer_id, $link), $sprache, $unterkunft_id, $link)); ?>
    </div>
    <div class="panel-body">
        <?php
        //passwortprüfung:
        if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
            ?>

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

<div class="form-group">
    <hr>
</div>
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
                    <form action="./right.php" method="post" name="monatZurueck" target="_self" id="monatZurueck">

                            <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo $zimmer_id ?>">
                            <input name="monat" type="hidden" id="monat" value="<?php echo($mon); ?>">
                            <input name="jahr" type="hidden" id="jahr" value="<?php echo($jah); ?>">
                            <input name="zurueck" type="submit" class="btn btn-primary"
                                   onClick="updateLeft(<?php echo (($mon) . "," . ($jah)) . "," . ($zimmer_id); ?>,0);"
                                   id="zurueck"
                                   value="<?php echo(getUebersetzung("einen Monat zurück", $sprache, $link)); ?>">

                    </form>
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
                    <form action="./right.php" method="post" name="monatWeiter" target="_self" id="monatWeiter">
                        <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo $zimmer_id ?>">
                        <input name="monat" type="hidden" id="monat" value="<?php echo($mon); ?>">
                        <input name="jahr" type="hidden" id="jahr" value="<?php echo($jah); ?>">
                        <input name="weiter" type="submit" class="btn btn-primary"
                               onClick="updateLeft(<?php echo(($mon) . "," . ($jah) . "," . ($zimmer_id)); ?>,1);"
                               id="weiter"
                               value="<?php echo(getUebersetzung("einen Monat weiter", $sprache, $link)); ?>">
                    </form>
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
