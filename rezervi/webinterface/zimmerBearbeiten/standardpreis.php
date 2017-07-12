<?php
/**
 * Created on 19.01.2007
 *
 * @author coster
 * preise hinzufügen löschen ändern
 */

session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
include_once("../../conf/rdbmsConfig.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/zimmerFunctions.php");
include_once("../../include/priceFunctions.inc.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/benutzerFunctions.php");
include_once($root . "/include/propertiesFunctions.php");
include_once($root . "/include/datumFunctions.php");

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

//variablen intitialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$benutzername  = getSessionWert(BENUTZERNAME);
$passwort      = getSessionWert(PASSWORT);
$sprache       = getSessionWert(SPRACHE);

include_once("../templates/headerA.php");
?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<script type="text/javascript"
        src="<?php echo($root); ?>/templates/calendarDateInput.inc.php?root=<?php echo $root ?>&sprache=<?php echo $sprache ?>">
    /***********************************************
     * Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
     * Script featured on and available at http://www.dynamicdrive.com
     * Keep this notice intact for use.
     ***********************************************/
</script>
<?php
include_once("../templates/headerB.php");
include_once("../templates/bodyA.php");
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>
			<?php echo getUebersetzung("Preise hinzufügen, ändern, löschen", $sprache, $link) ?>.
        </h2>
    </div>
    <div class="panel-body">
		<?php
		//passwortprüfung:
		if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
		{

//generiert das heutige datum für den date picker:
			$startdatumDP = getTodayDay() . "/" . parseMonthNumber(getTodayMonth()) . "/" . getTodayYear();

			$sizeRoomSelectBox = getAnzahlVorhandeneZimmer($unterkunft_id, $link);
			if ($sizeRoomSelectBox > 5)
			{
				$sizeRoomSelectBox = 5;
			}
			?>

            <p class="lead">
				<?php
				$text = "Definieren sie hier für jedes Mietobjekt einen Standardpreis. Wird " .
					"bei der Berechnung des Preises kein Preis für eine Saison gefunden, dann " .
					"wird dieser Preis zur Preisberechnung herangezogen.";
				?>
				<?php echo getUebersetzung($text, $sprache, $link) ?>
            </p>

			<?php
			if (isset($nachricht) && $nachricht != "")
			{
				?>
                <div role="alert" class="alert alert-info

                    <?php if (isset($fehler) && $fehler == false)
				{
					echo("frei");
				}
				else
				{
					echo("belegt");
				} ?>">
					<?php echo $nachricht ?>

                </div>

				<?php
			}
			?>
            <form action="./standardPreisAendern.inc.php" method="post" target="_self">
                <div class="well">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="control-label">
								<?php echo getUebersetzung("Preis", $sprache, $link) ?>
                            </label>
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label">
								<?php echo getUebersetzung("Mietobjekt", $sprache, $link) ?>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <hr style=" border-top: 0.5px solid rgba(99, 91, 91, 0.63);">
                    </div>


					<?php
					//alle bestehenden attribute auslesen:
					$res = getStandardPrices($unterkunft_id, $link);
					while ($d = mysqli_fetch_array($res))
					{
						$preis_id = $d["PK_ID"];
						$preis    = $d["Preis"];
						?>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label">
                                    <input class="form-control" type="number" step="0.5"
                                           name="preis_<?php echo $preis_id ?>"
                                           value="<?php echo $preis ?>"/>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="zimmer_<?php echo $preis_id ?>[]"
                                        size="<?php echo $sizeRoomSelectBox ?>"
                                        multiple="multiple" id="zimmer_<?php echo $preis_id ?>">
									<?php
									$res3 = getZimmer($unterkunft_id, $link);
									while ($g = mysqli_fetch_array($res3))
									{
										$ziArt = getUebersetzungUnterkunft($g["Zimmerart"], $sprache, $unterkunft_id, $link);
										$ziNr  = getUebersetzungUnterkunft($g["Zimmernr"], $sprache, $unterkunft_id, $link);
										?>
                                        <option value="<?php echo $g["PK_ID"] ?>"
											<?php
											$res2 = getZimmerForPrice($preis_id);
											while ($r = mysqli_fetch_array($res2))
											{
												if ($r["PK_ID"] == $g["PK_ID"])
												{
													?>
                                                    selected="selected"
													<?php
												}
											}
											?>
                                        >
											<?php echo $ziArt . " " . $ziNr ?>
                                        </option>
										<?php
									} //ende while
									?>
                                </select>
                            </div>
                            <div class="col-sm-4" >
                                <input name="loeschen_<?php echo $preis_id ?>"
                                       type="submit" id="loeschen_<?php echo $preis_id ?>"
                                       class="btn btn-danger"
                                       style="float:right;"
                                       value="<?php echo(getUebersetzung("löschen", $sprache, $link)); ?>"/>
                            </div>
                        </div>
                        <div class="row">
                            <hr style=" border-top: 0.5px solid rgba(99, 91, 91, 0.63);">
                        </div>
						<?php
					} //ende while attribute
					?>

                    <div class="row">
                        <div class="col-sm-4">
                            <label class="control-label">
                                <input class="form-control" type="number" step="0.5" name="preis_neu"/>
                            </label>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control" name="zimmer_id_neu[]" size="<?php echo $sizeRoomSelectBox ?>"
                                    multiple="multiple" id="zimmer_id_neu">
								<?php
								$res = getZimmer($unterkunft_id, $link);
								//zimmer ausgeben:
								$i = 0;
								while ($d = mysqli_fetch_array($res))
								{
									$ziArt = getUebersetzungUnterkunft($d["Zimmerart"], $sprache, $unterkunft_id, $link);
									$ziNr  = getUebersetzungUnterkunft($d["Zimmernr"], $sprache, $unterkunft_id, $link);
									?>
                                    <option value="<?php echo $d["PK_ID"] ?>"<?php
									if ($i == 0)
									{
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
                        <div class="col-sm-4">
                            <input name="hinzufuegen" type="submit" id="hinzufuegen" class="btn btn-success"
                                   style="float:right;"
                                   value="<?php echo(getUebersetzung("hinzufügen", $sprache, $link)); ?>"/>
                        </div>
                    </div>
                    <div class="row">
                        <hr style=" border-top: 0.5px solid rgba(99, 91, 91, 0.63);">
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-9 col-sm-3" style="text-align:right;">
                            <input name="aendern" type="submit" id="aendern" class="btn btn-success"
                                   value="<?php echo(getUebersetzung("Speichern", $sprache, $link)); ?>"/>
                            <a class="btn btn-primary" href="./index.php">
                                <!--	<span class="glyphicon glyphicon-menu-left" ></span> -->
								<?php echo(getUebersetzung("Abbrechen", $sprache, $link)); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
			<?php
		}
		else
		{
			echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
		}
		?>
    </div>
</div>
</body>
</html>
