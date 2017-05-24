<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
	reservierungsplan
	eintragen einer reservierung
	author: christian osterrieder utilo.eu
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort      = getSessionWert(PASSWORT);
$benutzername  = getSessionWert(BENUTZERNAME);
$sprache       = getSessionWert(SPRACHE);
$gast_id       = $_POST["gast_id"];
$zimmer_id     = $_POST["zimmer_id"];
$status        = $_POST["status"];
$vonTag        = $_POST["vonTag"];
$bisTag        = $_POST["bisTag"];
$vonMonat      = $_POST["vonMonat"];
$bisMonat      = $_POST["bisMonat"];
$vonJahr       = $_POST["vonJahr"];
$bisJahr       = $_POST["bisJahr"];

if ($gast_id != 1)
{ //1= anonymer gast

	$pension          = $_POST["zusatz"];
	$anzahlErwachsene = $_POST["anzahlErwachsene"];
	$anzahlKinder     = $_POST["anzahlKinder"];
	$anrede           = $_POST["anrede"];
	$vorname          = $_POST["vorname"];
	$nachname         = $_POST["nachname"];
	$strasse          = $_POST["strasse"];
	$plz              = $_POST["plz"];
	$ort              = $_POST["ort"];
	$land             = $_POST["land"];
	$email            = $_POST["email"];
	$tel              = $_POST["tel"];
	$fax              = $_POST["fax"];
	//$mob = $_POST["mob"];
	$speech    = $_POST["speech"];
	$anmerkung = $_POST["anmerkungen"];

}
else
{
	$anzahlErwachsene = 1;
	$anzahlKinder     = 0;
	$pension          = "";
}

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");
//andere "include_onces" einfügen:
include_once("../../../include/gastFunctions.php");
include_once("../../../include/reservierungFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/uebersetzer.php");

?>
<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
<div class="panel panel-default">
    <div class="panel-body">


		<?php
		//passwortprüfung:
		if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
		{ ?>
			<?php

			//anonymen gast eintragen:
			if ($gast_id == 1)
			{
				//do nothing
			} //2. gast ist neu:
			else if ($gast_id == -1)
			{
				$gast_id = insertGuest($unterkunft_id, $anrede, $vorname, $nachname, $strasse, $plz, $ort, $land, $email, $tel, $fax, $anmerkung, $speech, $link);
			}
			else
			{//3. gast ist bereits vorhanden und wurde gändert
				updateGuest($gast_id, $anrede, $vorname, $nachname, $strasse, $plz, $ort, $land, $email, $tel, $fax, $anmerkung, $speech, $link);
			}

			//reservierung eintragen:
			//wenn bereits eine reservierung in dem geforderten zeitraum vorhanden ist,
			//muss diese upgedatet werden!
			//mach mas so: zuerst alle reservierungen in diesem zeitraum vernichten und
			//dann einfach neu eintragen...wird alles von funktion insertReservation erledigt:
			insertReservation($zimmer_id, $gast_id, $vonTag, $vonMonat, $vonJahr, $bisTag, $bisMonat, $bisJahr, $status, $anzahlErwachsene, $anzahlKinder, $pension, $link);

			?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success">
						<?php echo(getUebersetzung("Die Reservierung/Belegung wurde erfolgreich geändert", $sprache, $link)); ?>
                        !
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-sm-2">
                    <label>
	                    <?php echo(getUebersetzung("eingetragenes Datum", $sprache, $link)); ?>:
                    </label>
                </div>
                <div class="col-sm-10">
					<?php echo(getUebersetzung("von", $sprache, $link)); ?>
                    <label>
						<?php echo($vonTag . "." . $vonMonat . "." . $vonJahr); ?>
                    </label>

					<?php echo(getUebersetzung("bis", $sprache, $link)); ?>
                    <label>
						<?php echo($bisTag . "." . $bisMonat . "." . $bisJahr); ?>
                    </label>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <label>
						<?php echo(getUebersetzung("Status", $sprache, $link)); ?>:
                    </label>
                </div>
                <div class="col-sm-1">

                    <div class="alert <?php
					//status = 0: frei
					//status = 1: reserviert
					//status = 2: belegt
					if ($status == 0)
						echo("frei");
                    elseif ($status == 1)
						echo("reserviert");
                    elseif ($status == 2)
						echo("belegt");
					?>" style="padding: 2px;">
						<?php if ($status == 0)
							echo(getUebersetzung("frei", $sprache, $link));
                        elseif ($status == 1)
							echo(getUebersetzung("reserviert", $sprache, $link));
						else
							echo(getUebersetzung("belegt", $sprache, $link));
						?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <label>
	                    <?php echo(getUebersetzung("Gast", $sprache, $link)); ?>:
                    </label>
                </div>
                <div class="col-sm-10">
					<?php echo(getGuestNachname($gast_id, $link)); ?>
                </div>
            </div>

            <form action="../index.php" method="post" name="form1" target="_self" class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                        <input name="monat" type="hidden" id="monat" value="<?php echo($vonMonat); ?>">
                        <input name="jahr" type="hidden" id="jahr" value="<?php echo($vonJahr) ?>">
                        <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo($zimmer_id); ?>">
                        <input type="submit" name="Submit" class="btn btn-primary"
                               value="<?php echo(getUebersetzung("zurück", $sprache, $link)); ?>">
                    </div>
                </div>
            </form>
			<?php
		} //ende passwortprüfung
		else
		{
			echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
		}
		?>
    </div>
</div>
</body>
</html>
