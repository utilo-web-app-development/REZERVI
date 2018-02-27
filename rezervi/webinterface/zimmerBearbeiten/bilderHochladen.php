<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");

/*   
			reservierungsplan
			hochladen eines bilder fuer ein zimmer
			author: coster
			date: 18.8.05
*/

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/einstellungenFunctions.php");
include_once("../../include/zimmerFunctions.php");
include_once("../templates/components.php");

//variablen intitialisieren:
$unterkunft_id   = getSessionWert(UNTERKUNFT_ID);
$benutzername    = getSessionWert(BENUTZERNAME);
$passwort        = getSessionWert(PASSWORT);
$zimmer_id       = $_POST["zimmer_id"];
$sprache         = getSessionWert(SPRACHE);
$standardsprache = getStandardSprache($unterkunft_id, $link);

if (!is_writable($root . "/upload")) {
    $nachricht
               = "Achtung! Das Verzeichnis 'upload' ist nicht beschreibbar, Sie können erst Bilder hochladen wenn Sie diesem Verzeichnis Schreibrechte zuweisen!";
    $nachricht = getUebersetzung($nachricht, $sprache, $link);
    $fehler    = true;
}

$nachricht_alert = $_POST['nachricht_alert'];
$fehler_alert = $_POST['fehler_alert'];


//variablen initialisieren:
if (isset($_POST["ben"]) && isset($_POST["pass"]))
{
    $ben  = $_POST["ben"];
    $pass = $_POST["pass"];
}
else
{
    //aufruf kam innerhalb des webinterface:
    $ben  = getSessionWert(BENUTZERNAME);
    $pass = getSessionWert(PASSWORT);
}

$benutzer_id = -1;
if (isset($ben) && isset($pass))
{
    $benutzer_id = checkPassword($ben, $pass, $link);
}
if ($benutzer_id == -1)
{
    //passwortprüfung fehlgeschlagen, auf index-seite zurück:
    $fehlgeschlagen = true;
    header("Location: " . $URL . "webinterface/index.php?fehlgeschlagen=true"); /* Redirect browser */
    exit();
    //include_once("./index.php");
    //exit;
}
else
{
    $benutzername = $ben;
    $passwort     = $pass;
    setSessionWert(BENUTZERNAME, $benutzername);
    setSessionWert(PASSWORT, $passwort);

    //unterkunft-id holen:
    $unterkunft_id = getUnterkunftID($benutzer_id, $link);
    setSessionWert(UNTERKUNFT_ID, $unterkunft_id);
    setSessionWert(BENUTZER_ID, $benutzer_id);
}

?>

<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>

<?php //passwortprüfung:	
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>
                <?php echo(getUebersetzung(
                    "Bilder für Zimmer/Appartement/Wohnung/etc. hochladen",
                    $sprache, $link
                )); ?>
            </h2>
            <h4>
                <?php echo(getUebersetzung(
                    "Bitte füllen Sie die untenstehenden Felder aus.", $sprache,
                    $link
                )); ?>
                <?php echo(getUebersetzung(
                    "Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden",
                    $sprache, $link
                )); ?>!
            </h4>
        </div>
        <div class="panel-body">

            <?php
            if (isset($nachricht) && $nachricht != ""){
            ?>

            <div role="alert" class="alert
                            <?php
            if ($fehler_alert == true) {
            ?>
                                alert-danger"
                <?php
                }
                else {
                ?>
                 alert-success"
            <?php
            }
            ?>
            >
            <?php echo($nachricht); ?>
        </div>

        <?php
        }
        ?>

        <?php
            if (isset($nachricht_alert) && $nachricht_alert != ""){
            ?>

            <div class="alert
                            <?php
            if ($fehler == true) {
            ?>
                                alert-danger"
                <?php
                }
                else {
                ?>
                 alert-success"
            <?php
            }
            ?>
            >
            <?php echo($nachricht_alert); ?>
        </div>

        <?php
        }
        ?>

        <form action="./bilderHochladenDurchfuehren.php" method="post"
              class="form-horizontal" name="zimmerEintragen" target="_self"
              enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-sm-2">
                    <label>
                        <?php echo(getUebersetzung(
                            "Zimmer", $sprache, $link
                        )); ?>*
                    </label>
                </div>
                <div class="col-sm-10">
                    <select name="zimmer_id" id="zimmer_id"
                            class="form-control">
                        <?php
                        $res = getZimmer($unterkunft_id, $link);
                        //zimmer ausgeben:
                        while ($d = mysqli_fetch_array($res)) {
                            $ziArt = getUebersetzungUnterkunft(
                                $d["Zimmerart"], $sprache, $unterkunft_id, $link
                            );
                            $ziNr  = getUebersetzungUnterkunft(
                                $d["Zimmernr"], $sprache, $unterkunft_id, $link
                            );
                            ?>
                            <option value="<?php echo($d["PK_ID"]); ?>"
                                <?php if (isset($zimmer_id)
                                    && ($zimmer_id == $d["PK_ID"])
                                ) {
                                    ?>
                                    selected="selected"
                                    <?php
                                }
                                ?>
                            ><?php echo($ziArt . " " . $ziNr); ?>
                            </option>
                            <?php
                        } //ende while
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <label>
                        <?php echo(getUebersetzung("Bild", $sprache, $link)); ?>
                        *
                    </label>
                </div>
                <div class="col-sm-10">
                    <input name="bild" type="file" class="form-control" enctype="multipart/form-data">
                </div>
            </div>
            <?php
            $spr = getSprachenForBelegungsplan($link);
            while ($s = mysqli_fetch_array($spr)) {
                ?>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
                            <?php echo(getUebersetzung(
                                "Beschreibung", $sprache, $link
                            )); ?>&nbsp;
                            <?php echo getUebersetzung(
                                $s['Bezeichnung'], $sprache, $link
                            ) ?>
                            <?php if ($s['Sprache_ID'] == $standardsprache) { ?>
                                *
                            <?php } ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <textarea class="form-control"
                                  name="beschreibung_<?php echo $s['Sprache_ID'] ?>"
                                  cols="50" rows="3"></textarea>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="form-group">
                <div class="col-sm-12" style="text-align: right;">
                    <button name="Submit" type="submit" id="Submit"
                            class="btn btn-success">
                        <span class="glyphicon glyphicon-cloud-upload"></span>
                        <?php echo(getUebersetzung(
                            "Bild hochladen", $sprache, $link
                        )); ?>
                    </button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12" style="text-align: right;">
                    <a href="../inhalt.php" name="home" id="home"
                       class="btn btn-primary">
                        <span class="glyphicon glyphicon-home"></span>
                        <?php echo(getUebersetzung(
                            "Hauptmenü", $sprache, $link
                        )); ?>
                    </a>
                    <a href="./index.php" name="back" id="back"
                       class="btn btn-default">
                        <?php echo(getUebersetzung(
                            "Zurück", $sprache, $link
                        )); ?>
                    </a>
                </div>
            </div>

        </form>


    </div>
    <?php
} //ende if passwortprüfung
else {
    $fehlgeschlagen = true;
    header(
        "Location: " . $URL . "webinterface/index.php?fehlgeschlagen=true"
    ); /* Redirect browser */
    exit();
    //echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
}
?>
<?php include_once("../templates/end.php"); ?>
