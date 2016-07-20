<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			bestätigung zum löschen von zimmern von benutzer einholen!
*/

//variablen intitialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$benutzername = getSessionWert(BENUTZERNAME);
$passwort = getSessionWert(PASSWORT);
$zimmer_pk_id = $_POST["zimmer_pk_id"];
$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/gastFunctions.php");
include_once("../../include/reservierungFunctions.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/uebersetzer.php");

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
<div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Löschung durchführen", $sprache, $link)); ?></h2>
    </div>
    <div class="panel-body">

        <form action="./zimmerLoeschen.php" method="post" name="zimmerLoeschen" target="_self" id="zimmerLoeschen">


            <div class="alert alert-danger" role="alert">
                <?php

                //Reservierungen und Zimmer löschen:
                $anzahl = count($zimmer_pk_id);
                $demoNotPossible = false;
                if (DEMO == true && $anzahl > 1){
                    $anzahl--;
                    $demoNotPossible = true;
                    for ($i = 0; $i < $anzahl; $i++) {
                        //zuerst mal die reservierungen raushauen:
                        $query = ("DELETE FROM 
							Rezervi_Reservierung
	           			 	WHERE
	           				FK_Zimmer_ID = '$zimmer_pk_id[$i]'
			    ");

                        $res = mysqli_query($link, $query);
                        if (!$res) {
                            echo("die Anfrage $query scheitert");
                        }
                        //dann die zimmer
                        $query = ("DELETE FROM 
							Rezervi_Zimmer
	           			 	WHERE
	           				PK_ID = '$zimmer_pk_id[$i]'
							and
							FK_Unterkunft_ID = '$unterkunft_id'
			    ");

                        $res = mysqli_query($link, $query);
                        if (!$res) {
                            echo("die Anfrage $query scheitert");
                        }
                    } //ende for
                    echo(getUebersetzung("Im Demo Modus kann das letzte Zimmer nicht gelöscht " .
                        "werden", $sprache, $link));
                }
                else if (DEMO == true && $anzahl <= 1){
                    echo(getUebersetzung("Im Demo Modus kann das letzte Zimmer nicht gelöscht " .
                        "werden", $sprache, $link));
                }
                else if (DEMO != true){
                for ($i = 0;
                $i < $anzahl;
                $i++){
                //zuerst mal die reservierungen raushauen:
                $query = ("DELETE FROM 
							Rezervi_Reservierung
	           			 	WHERE
	           				FK_Zimmer_ID = '$zimmer_pk_id[$i]'
			    "); ?>
            </div>
            <div class="alert alert-success" role="alert">
                <?php

                $res = mysqli_query($link, $query);
                if (!$res) {
                    echo("die Anfrage $query scheitert");
                }
                //dann die zimmer
                $query = ("DELETE FROM 
							Rezervi_Zimmer
	           			 	WHERE
	           				PK_ID = '$zimmer_pk_id[$i]'
							and
							FK_Unterkunft_ID = '$unterkunft_id'
			    ");

                $res = mysqli_query($link, $query);
                if (!$res) {
                    echo("die Anfrage $query scheitert");
                }
                } //ende for
                echo(getUebersetzung("Der/die/das Zimmer/Appartement/Wohnung/etc. " .
                    "wurde samt seinen Reservierungen aus der Datenbank gelöscht", $sprache, $link));
                }
                ?>!
            </div>
        </form>
        <div class="row">
            <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                <a class="btn btn-primary" href="./index.php">
                    <!--            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp-->
                    <?php echo(getUebersetzung("Zurück", $sprache, $link)); ?>
                </a>
            </div>
        </div>

        <?php
        } //ende if passwortprüfung
        else {
            echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
        }
        ?>
    </div>
</div>
</body>
</html>