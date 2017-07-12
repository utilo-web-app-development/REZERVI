<?php
session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung der reservierung für den benutzer
			author: christian osterrieder utilo.eu						
			
			dieser seite muss übergeben werden:
			Benutzer PK_ID $benutzer_id
*/
//funktionen zum versenden von e-mails:
include_once($root . "/include/mail.inc.php");

//variablen:
$unterkunft_id    = getSessionWert(UNTERKUNFT_ID);
$passwort         = getSessionWert(PASSWORT);
$benutzername     = getSessionWert(BENUTZERNAME);
$reservierungs_id = $_POST["reservierungs_id"];
$reservierungen   = explode(",", $reservierungs_id);

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

if (isset ($_POST["gastEntfernen"])) {
    $gastEntfernen = $_POST["gastEntfernen"];
}
else {
    $gastEntfernen = false;
}
if (isset ($_POST["antwort"])) {
    $antwort = $_POST["antwort"];
}
else {
    $antwort = false;
}
$art     = $_POST["art"];
$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/gastFunctions.php");
include_once("../../include/reservierungFunctions.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/propertiesFunctions.php");
include_once("../../include/autoResponseFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../templates/components.php");

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


//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link)) {
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>
                <?php echo(getUebersetzung(
                    "Reservierungsanfragen von Gästen löschen", $sprache, $link
                )); ?>
            </h2>
        </div>
        <div class="panel-body">
            <?php


            $gast_id  = "";
            $vonDatum = "";
            $bisDatum = "";

            foreach ($reservierungen as $res_id) {

                $vonDatum  = getDatumVon($res_id, $link);
                $bisDatum  = getDatumBis($res_id, $link);
                $gast_id   = getGastID($res_id, $link);
                $zimmer_id = getZimmerID($res_id, $link);
                deleteReservation($res_id, $link);
                //wenn room child rooms hat auch diese löschen:
                $resu = getChildRooms($zimmer_id);
                if (!empty ($resu)) {
                    while ($d = mysqli_fetch_array($resu)) {
                        $child = $d['PK_ID'];
                        deleteReservationWithDate(
                            $child, $vonDatum, $bisDatum, $link
                        );
                    }
                }

            }

            if ($gastEntfernen == "true") {
                //gast soll auch gelöscht werden:
                $query = ("SELECT
							FK_Gast_ID
						    FROM	
					   		Rezervi_Reservierung
					  		WHERE
					   		FK_Gast_ID = '$gast_id'
					   	  ");

                $res = mysqli_query($link, $query);
                if (!$res) {
                    echo("die Anfrage $query scheitert");
                    echo(mysqli_error($link));
                } //ende if
                else {
                    $d    = mysqli_fetch_array($res);
                    $temp = $d["FK_Gast_ID"];
                    if ($temp == "") {
                        //gast kann gelöscht werden, es sind keine weiteren reservierungen vorhanden:
                        $query = ("DELETE FROM	
							   				Rezervi_Gast
							   				WHERE
							   				PK_ID = '$gast_id'
							   			  ");

                        $res = mysqli_query($link, $query);
                        if (!$res) {
                            echo("die Anfrage $query scheitert");
                            echo(mysqli_error($link));
                        }
                        else {
                            ?>
                            <div class="alert alert-info">
                                <?php echo(getUebersetzung(
                                    "Der Gast wurde aus der Datenbank entfernt",
                                    $sprache, $link
                                )); ?>
                            </div>
                            <?php

                        } // ende if
                    } //ende if
                    else {
                        //der gast kann nicht entfernt werden
                        ?>
                        <div class="alert alert-danger">
                            <?php echo(getUebersetzung(
                                "Der Gast kann nicht entfernt werden, es sind weitere Belegungen/Reservierungen für diesen Gast eingetragen",
                                $sprache, $link
                            )); ?>!
                        </div>

                        <?php
                    }
                } //ende else
            } //ende if gastEntfernen
            ?>



                <div class="alert alert-info">
                    <?php echo(getUebersetzung(
                        "Die Reservierungsanfrage", $sprache, $link
                    )); ?>
                    <?php echo(getGuestVorname($gast_id, $link) . " "
                        . getGuestNachname($gast_id, $link)); ?>

                    <?php echo(getUebersetzung("von", $sprache, $link)); ?>
                    <strong><?php echo($vonDatum); ?></strong>
                    <?php echo(getUebersetzung("bis", $sprache, $link)); ?>
                    <strong><?php echo($bisDatum); ?></strong>
                    <?php echo(getUebersetzung(
                        "wurde erfolgreich entfernt", $sprache, $link
                    )); ?>.
                </div>

                <?php if ($antwort == "true")
                {

                $speech   = getGuestSprache($gast_id, $link);
                $gastName = getGuestNachname($gast_id, $link);
                $an       = getGuestEmail($gast_id, $link);
                $von      = getUnterkunftEmail($unterkunft_id, $link);
                $subject  = getUebersetzungUnterkunft(
                    getMessageSubject($unterkunft_id, $art, $link), $speech,
                    $unterkunft_id, $link
                );
                $anr      = getUebersetzungUnterkunft(
                    getMessageAnrede($unterkunft_id, $art, $link), $speech,
                    $unterkunft_id, $link
                );
                $message  = $anr . (" ") . ($gastName) . ("!\n\n");
                $bod      = getUebersetzungUnterkunft(
                    getMessageBody($unterkunft_id, $art, $link), $speech,
                    $unterkunft_id, $link
                );
                $message  .= $bod . ("\n\n");

                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <label>
                            <?php echo(getUebersetzung(
                                "Die folgende Mitteilung wird per E-Mail an Ihren Gast gesendet. Sie haben hier die Möglichkeiten noch Korrekturen vorzunehmen",
                                $sprache, $link
                            )); ?>
                            :
                        </label>
                    </div>
                </div>
                <form action="./bestaetigungSenden.php" method="post"
                      name="bestaetigungSenden" target="_self"
                      class="form-horizontal">
                    <input name="an" type="hidden" value="<?php echo($an); ?>">
                    <input name="von" type="hidden"
                           value="<?php echo($von); ?>">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label>
                                <?php echo(getUebersetzung(
                                    "Betreff", $sprache, $link
                                )); ?>
                            </label>
                            <div class="col-sm-10">
                                <input name="subject" type="text"
                                       class="form-control" id="subject_de"
                                       value="<?php echo($subject); ?>"
                                       size="100">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label>
                                <?php echo(getUebersetzung(
                                    "Text", $sprache, $link
                                )); ?>
                            </label>
                        </div>
                        <div class="col-sm-10">
                            <textarea name="message" cols="100"
                                      rows="10" class="form-control"
                                      id="text_de"><?php echo($message); ?>
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12" style="text-align: right;">
                            <button class="btn btn-primary">
                                <?php
                                //-----buttons um zurück zum menue zu gelangen:
                                echo getUebersetzung(
                                    "absenden", $sprache, $link
                                );
                                ?>
                            </button>
                        </div>
                    </div>

                </form>
            <?php  } //ende if ?>

                <div class="row">
                    <div class="col-sm-12" style="text-align: right;">
                        <a href="./index.php" class="btn btn-default">
                            <?php echo getUebersetzung(
                                "zurück", $sprache, $link
                            ); ?>
                        </a>
                        <a href="../inhalt.php" class="btn btn-primary">
                            <span class="glyphicon glyphicon-home"></span>
                            <?php echo getUebersetzung(
                                "Hauptmenü", $sprache, $link
                            ); ?>
                        </a>
                    </div>
                </div>

                <?php
                /*                        showSubmitButtonWithForm("./index.php", getUebersetzung("zurück", $sprache, $link));
                                        */
                ?><!--
                        <br/>
                        --><?php
                /*                        showSubmitButtonWithForm("../inhalt.php", getUebersetzung("Hauptmenü", $sprache, $link));
                                        */
                ?>


        </div>
    </div>

    <?php

} //ende if passwortprüfung
else {
    $fehlgeschlagen = true;
    header(
        "Location: " . $URL . "webinterface/index.php?fehlgeschlagen=true"
    ); /* Redirect browser */
    exit();
    //echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}
?>
<?php include_once("../templates/end.php"); ?>
