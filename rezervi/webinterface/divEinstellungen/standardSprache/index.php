<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung des designs
			author: christian osterrieder utilo.eu						
*/

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../templates/components.php");
include_once("../../templates/auth.php");

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort      = getSessionWert(PASSWORT);
$benutzername  = getSessionWert(BENUTZERNAME);
$sprache       = getSessionWert(SPRACHE);
//standard-sprache aus datenbank auslesen:
$standard              = getStandardSprache($unterkunft_id, $link);
$standardBelegungsplan = getStandardSpracheBelegungsplan($unterkunft_id, $link);

?>
<?php include_once("../../templates/headerA.php"); ?>
    <style type="text/css">
        <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
    </style>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
    <div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Ändern der Standard-Sprache", $sprache, $link)); ?>.</h2>
    </div>
    <div class="panel-body">
<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
{
	?>

    <!-- Show message if there is -->
	<?php include_once("../../templates/message.php"); ?>

    <p class="lead">
		<?php echo(getUebersetzung("Bitte wählen sie die Standard-Sprache ihres Belegungsplanes", $sprache, $link)); ?>.
    </p>
    <p class="lead">
		<?php echo(getUebersetzung("Es werden hier nur Sprachen angeboten die unter dem Menüpunkt [Sprachen] ausgewählt wurden", $sprache, $link)); ?>
        .
    </p>

    <form action="./spracheAendern.php" method="post" target="_self">

        <div class="well">
			<?php

			$res = getSprachen($unterkunft_id, $link);
			while ($d = mysqli_fetch_array($res))
			{
				$spracheID   = $d["Sprache_ID"];
				$bezeichnung = getBezeichnungOfSpracheID($spracheID, $link);
				?>
                <div class="row">
                    <div class="col-sm-4">
                        <label class="label-control">
                            <?php echo(getUebersetzung($bezeichnung, $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-1">
                        <input type="radio" name="standardspracheBelegungsplan" value="<?php echo($spracheID); ?>"
							<?php if ($standardBelegungsplan == $spracheID)
							{
								echo(" checked");
							} ?>>
                    </div>

                </div>
				<?php
			} //ende foreach
			?>
        </div>
        <p class="lead">
			<?php echo(getUebersetzung("Bitte wählen sie die Standard-Sprache ihres Webinterfaces", $sprache, $link)); ?>
            .
        </p>

        <div class="well">
			<?php
			$res = getSprachenForWebinterface($link);
			while ($d = mysqli_fetch_array($res))
			{
				$bezeichnung = $d["Bezeichnung"];
				$spracheID   = $d["Sprache_ID"];
				?>
                <div class="row">
                    <div class="col-sm-4">
                        <label
                                class="label-control">
							<?php echo(getUebersetzung($bezeichnung, $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-1">
                        <input type="radio" name="standardsprache" value="<?php echo($spracheID); ?>"
							<?php if ($standard == $spracheID)
							{
								echo(" checked");
							} ?>>
                    </div>
                </div>

				<?php
			} //ende foreach
			?>

        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="label-control">
					<?php echo(getUebersetzung("Zur ausgewählten Sprache wechseln", $sprache, $link)); ?>.
                </label>
            </div>
            <div class="col-sm-1">
                <input type="checkbox" name="jetztWechseln" value="true" checked>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" style="text-align: right;">
                <button name="aendern" type="submit" class="btn btn-success" id="aendern">
                    <span class="glyphicon glyphicon-wrench"></span>
					<?php echo(getUebersetzung("Ändern", $sprache, $link)); ?>
                </button>
                <a href="../index.php" class="btn btn-primary">
					<?php echo(getUebersetzung("Zurück", $sprache, $link)); ?>
                </a>
            </div>
        </div>

    </form>
    <br/>

	<?php
} //ende if passwortprüfung
else
{
	echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
}
?>
<?php include_once("../../templates/end.php"); ?>