<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung des designs
			author: christian osterrieder utilo.eu						
*/

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort      = getSessionWert(PASSWORT);
$benutzername  = getSessionWert(BENUTZERNAME);
$sprache       = getSessionWert(SPRACHE);

//message
$message = $_GET["message"];
$error   = $_GET["error"];

if ($error == true)
{
	$message = str_replace("-", " ", $message);
}

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/einstellungenFunctions.php");

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

//initialisieren der variablen:
//nur wenn seite neu aufgerufen wurde:
if (!isset($fehler) || $fehler != true)
{
	$strasse     = getUnterkunftStrasse($unterkunft_id, $link);
	$plz         = getUnterkunftPlz($unterkunft_id, $link);
	$ort         = getUnterkunftOrt($unterkunft_id, $link);
	$email       = getUnterkunftEmail($unterkunft_id, $link);
	$tel         = getUnterkunftTel($unterkunft_id, $link);
	$tel2        = getUnterkunftTel2($unterkunft_id, $link);
	$fax         = getUnterkunftFax($unterkunft_id, $link);
	$kindesalter = getKindesalter($unterkunft_id, $link);
	$waehrung    = getWaehrung($unterkunft_id);

	$name    = getUnterkunftName($unterkunft_id, $link);
	$name_de = getUebersetzungUnterkunft($name, "de", $unterkunft_id, $link);
	$name_en = getUebersetzungUnterkunft($name, "en", $unterkunft_id, $link);
	$name_fr = getUebersetzungUnterkunft($name, "fr", $unterkunft_id, $link);
	$name_it = getUebersetzungUnterkunft($name, "it", $unterkunft_id, $link);
	$name_nl = getUebersetzungUnterkunft($name, "nl", $unterkunft_id, $link);
	$name_es = getUebersetzungUnterkunft($name, "es", $unterkunft_id, $link);
	$name_sp = getUebersetzungUnterkunft($name, "sp", $unterkunft_id, $link);

	$land    = getUnterkunftLand($unterkunft_id, $link);
	$land_de = getUebersetzungUnterkunft($land, "de", $unterkunft_id, $link);
	$land_en = getUebersetzungUnterkunft($land, "en", $unterkunft_id, $link);
	$land_fr = getUebersetzungUnterkunft($land, "fr", $unterkunft_id, $link);
	$land_it = getUebersetzungUnterkunft($land, "it", $unterkunft_id, $link);
	$land_nl = getUebersetzungUnterkunft($land, "nl", $unterkunft_id, $link);
	$land_es = getUebersetzungUnterkunft($land, "es", $unterkunft_id, $link);
	$land_sp = getUebersetzungUnterkunft($land, "sp", $unterkunft_id, $link);

	$art    = getUnterkunftArt($unterkunft_id, $link);
	$art_de = getUebersetzungUnterkunft($art, "de", $unterkunft_id, $link);
	$art_en = getUebersetzungUnterkunft($art, "en", $unterkunft_id, $link);
	$art_fr = getUebersetzungUnterkunft($art, "fr", $unterkunft_id, $link);
	$art_it = getUebersetzungUnterkunft($art, "it", $unterkunft_id, $link);
	$art_nl = getUebersetzungUnterkunft($art, "nl", $unterkunft_id, $link);
	$art_es = getUebersetzungUnterkunft($art, "es", $unterkunft_id, $link);
	$art_sp = getUebersetzungUnterkunft($art, "sp", $unterkunft_id, $link);

	$zimmerart    = getZimmerart_EZ($unterkunft_id, $link);
	$zimmerart_de = getUebersetzungUnterkunft($zimmerart, "de", $unterkunft_id, $link);
	$zimmerart_en = getUebersetzungUnterkunft($zimmerart, "en", $unterkunft_id, $link);
	$zimmerart_fr = getUebersetzungUnterkunft($zimmerart, "fr", $unterkunft_id, $link);
	$zimmerart_it = getUebersetzungUnterkunft($zimmerart, "it", $unterkunft_id, $link);
	$zimmerart_nl = getUebersetzungUnterkunft($zimmerart, "nl", $unterkunft_id, $link);
	$zimmerart_sp = getUebersetzungUnterkunft($zimmerart, "sp", $unterkunft_id, $link);
	$zimmerart_es = getUebersetzungUnterkunft($zimmerart, "es", $unterkunft_id, $link);

	$zimmerart_mz    = getZimmerart_MZ($unterkunft_id, $link);
	$zimmerart_mz_de = getUebersetzungUnterkunft($zimmerart_mz, "de", $unterkunft_id, $link);
	$zimmerart_mz_en = getUebersetzungUnterkunft($zimmerart_mz, "en", $unterkunft_id, $link);
	$zimmerart_mz_fr = getUebersetzungUnterkunft($zimmerart_mz, "fr", $unterkunft_id, $link);
	$zimmerart_mz_it = getUebersetzungUnterkunft($zimmerart_mz, "it", $unterkunft_id, $link);
	$zimmerart_mz_nl = getUebersetzungUnterkunft($zimmerart_mz, "nl", $unterkunft_id, $link);
	$zimmerart_mz_sp = getUebersetzungUnterkunft($zimmerart_mz, "sp", $unterkunft_id, $link);
	$zimmerart_mz_es = getUebersetzungUnterkunft($zimmerart_mz, "es", $unterkunft_id, $link);

} //ende if kein fehler
$standardsprache = getStandardSprache($unterkunft_id, $link);

?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php
//passwortprüfung:
if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
{
?>
<?php
if (isset($fehler) && $fehler == true)
{
	?>

    <br/>
	<?php
}
?>

<?php if ($error == true)
{ ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="alert alert-success">
				<?php echo $message; ?>
            </div>
        </div>
    </div>
<?php }
else if ($error == false && $error != null)
{
	?>
    <div class="panel panel-danger">
        <div class="panel-body">
            <div class="alert alert-success">
				<?php echo $message; ?>
            </div>
        </div>
    </div>
	<?php
} ?>

<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-heading">
            <h3 class="panel-title">
				<?php echo(getUebersetzung("Unterkunft Bearbeiten", $sprache, $link)); ?>
            </h3>
        </div>
    </div>
    <div class="panel-body">

        <form action="./unterkunftAendern.php" method="post" name="form" target="_self" onSubmit="return chkFormular();"
              class="form-horizontal">
			<?php
			if (isGermanShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="name_de"
                           class="col-sm-3 "><?php echo(getUebersetzung("Name der Unterkunft in Deutsch", $sprache, $link)); ?>
						<?php if ($standardsprache == "de")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>            </label>
                    <div class="col-sm-5">

                    </div>
                    <div class="col-sm-4">
                        <input name="name_de" type="text" id="name" value="<?php echo($name_de) ?>"
                               class="form-control">
                    </div>
                </div>

				<?php
			}
			if (isEnglishShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="name_en"
                           class="col-sm-8 "><?php echo(getUebersetzung("Name der Unterkunft in Englisch", $sprache, $link)); ?>
						<?php if ($standardsprache == "en")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>            </label>

                    <div class="col-sm-4">
                        <input name="name_en" type="text" id="name_en" value="<?php echo($name_en) ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isFrenchShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="name_fr"
                           class="col-sm-8 "><?php echo(getUebersetzung("Name der Unterkunft in Französisch", $sprache, $link)); ?>
						<?php if ($standardsprache == "fr")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>            </label>
                    <div class="col-sm-4">
                        <input name="name_fr" type="text" id="name_fr" value="<?php echo($name_fr) ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isItalianShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="name_it"
                           class="col-sm-8 "><?php echo(getUebersetzung("Name der Unterkunft in Italienisch", $sprache, $link)); ?>
						<?php if ($standardsprache == "it")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>            </label>
                    <div class="col-sm-4">
                        <input name="name_it" type="text" id="name_it" value="<?php echo($name_it) ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isNetherlandsShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="name_nl"
                           class="col-sm-8 "><?php echo(getUebersetzung("Name der Unterkunft in Holländisch", $sprache, $link)); ?>
						<?php if ($standardsprache == "nl")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>            </label>
                    <div class="col-sm-4">
                        <input name="name_nl" type="text" id="name_nl" value="<?php echo($name_nl) ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isEspaniaShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="name_sp"
                           class="col-sm-8 "><?php echo(getUebersetzung("Name der Unterkunft in Spanisch", $sprache, $link)); ?>
						<?php if ($standardsprache == "sp")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>            </label>
                    <div class="col-sm-4">
                        <input name="name_sp" type="text" id="name_sp" value="<?php echo($name_sp) ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isEstoniaShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="name_es"
                           class="col-sm-8 "><?php echo(getUebersetzung("Name der Unterkunft in Estnisch", $sprache, $link)); ?>
						<?php if ($standardsprache == "es")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>            </label>
                    <div class="col-sm-4">
                        <input name="name_es" type="text" id="name_es" value="<?php echo($name_es) ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}

			?>
            <div class="form-group">
                <label for="strasse"
                       class="col-sm-2 "><?php echo(getUebersetzung("Straße/Hausnummer", $sprache, $link)); ?></label>
                <div class="col-sm-10">
                    <input name="strasse" type="text" id="strasse" value="<?php echo($strasse) ?>" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="ort"
                       class="col-sm-2 "><?php echo(getUebersetzung("Ort", $sprache, $link)); ?></label>
                <div class="col-sm-10">
                    <input name="ort" type="text" id="ort" value="<?php echo($ort) ?>" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="plz"
                       class="col-sm-2 "><?php echo(getUebersetzung("PLZ", $sprache, $link)); ?></label>
                <div class="col-sm-10">
                    <input name="plz" type="text" id="plz" value="<?php echo($plz) ?>" class="form-control">
                </div>
            </div>

			<?php
			if (isGermanShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="land_de"
                           class="col-sm-2 "><?php echo(getUebersetzung("Land auf Deutsch", $sprache, $link));
						if ($standardsprache != "de")
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>
                    </label>
                    <div class="col-sm-10">
                        <input name="land_de" type="text" id="land" value="<?php echo($land_de) ?>"
                               class="form-control">
                    </div>
                </div>

				<?php
			}
			if (isEnglishShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="land_en"
                           class="col-sm-8 "><?php echo(getUebersetzung("Land auf Englisch", $sprache, $link));
						if ($standardsprache != "en")
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>
                    </label>
                    <div class="col-sm-4">
                        <input name="land_en" type="text" id="land_en" value="<?php echo($land_en) ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isFrenchShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="land_fr"
                           class="col-sm-8 "><?php echo(getUebersetzung("Land auf Französisch", $sprache, $link));
						if ($standardsprache != "fr")
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>
                    </label>
                    <div class="col-sm-4">
                        <input name="land_fr" type="text" id="land_fr" value="<?php echo($land_fr) ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isItalianShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="land_it"
                           class="col-sm-8 "><?php echo(getUebersetzung("Land auf Italienisch", $sprache, $link));
						if ($standardsprache != "it")
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>
                    </label>
                    <div class="col-sm-4">
                        <input name="land_it" type="text" id="land_it" value="<?php echo($land_it) ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isNetherlandsShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="land_nl"
                           class="col-sm-8 "><?php echo(getUebersetzung("Land auf Holländisch", $sprache, $link));
						if ($standardsprache != "nl")
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>
                    </label>
                    <div class="col-sm-4">
                        <input name="land_nl" type="text" id="land_nl" value="<?php echo($land_nl) ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isEspaniaShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="land_sp"
                           class="col-sm-8 "><?php echo(getUebersetzung("Land auf Spanisch", $sprache, $link));
						if ($standardsprache != "sp")
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>
                    </label>
                    <div class="col-sm-4">
                        <input name="land_sp" type="text" id="land_sp" value="<?php echo($land_sp) ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isEstoniaShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="land_es"
                           class="col-sm-8 "><?php echo(getUebersetzung("Land auf Estnisch", $sprache, $link));
						if ($standardsprache != "es")
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>
                    </label>
                    <div class="col-sm-4">
                        <input name="land_es" type="text" id="land_es" value="<?php echo($land_es) ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			?>

            <div class="form-group">
                <label for="email"
                       class="col-sm-3 "><?php echo(getUebersetzung("E-Mail-Adresse", $sprache, $link)); ?>
                    *</label>
                <div class="col-sm-9">
                    <input name="email" type="text" id="email" value="<?php echo($email) ?>" class="form-control">
                </div>
            </div>


            <div class="form-group">
                <label for="tel"
                       class="col-sm-3 "><?php echo(getUebersetzung("Telefonnummer", $sprache, $link)); ?></label>
                <div class="col-sm-9">
                    <input name="tel" type="text" id="tel" value="<?php echo($tel); ?>" class="form-control">
                </div>
            </div>


            <div class="form-group">
                <label for="tel2"
                       class="col-sm-3 ">2. <?php echo(getUebersetzung("Telefonnummer", $sprache, $link)); ?></label>
                <div class="col-sm-9">
                    <input name="tel2" type="text" id="tel2" value="<?php echo($tel2); ?>" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="fax"
                       class="col-sm-3 "><?php echo(getUebersetzung("Faxnummer", $sprache, $link)); ?></label>
                <div class="col-sm-9">
                    <input name="fax" type="text" id="fax" value="<?php echo($fax); ?>" class="form-control">
                </div>
            </div>


            <div class="form-group">
                <label for="waehrung"
                       class="col-sm-3 "><?php echo(getUebersetzung("Währung ihrer Preisangaben", $sprache, $link)); ?>
                    *</label>
                <div class="col-sm-9">
                    <input name="waehrung" type="text" id="waehrung" value="<?php echo($waehrung); ?>"
                           class="form-control">
                </div>
            </div>


			<?php
			if (isGermanShown($unterkunft_id, $link))
			{
				?>


                <div class="form-group">
                    <label for="art_de"
                           class="col-sm-8 "><?php echo(getUebersetzung("Art der Unterkunft in Deutsch (z. B. Hotel, Pension, ...)", $sprache, $link)); ?>
						<?php if ($standardsprache == "de")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="art_de" type="text" id="art_de" value="<?php echo($art_de); ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isEnglishShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="art_en"
                           class="col-sm-8 "><?php echo(getUebersetzung("Art der Unterkunft in Englisch (z. B. Hotel, Pension, ...)", $sprache, $link)); ?>
                        .
						<?php if ($standardsprache == "en")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="art_en" type="text" id="art_en" value="<?php echo($art_en); ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isFrenchShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="art_fr"
                           class="col-sm-8 "><?php echo(getUebersetzung("Art der Unterkunft in Französisch (z. B. Hotel, Pension, ...)", $sprache, $link)); ?>
                        .

						<?php if ($standardsprache == "fr")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="art_fr" type="text" id="art_fr" value="<?php echo($art_fr); ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isItalianShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="art_it"
                           class="col-sm-8 "><?php echo(getUebersetzung("Art der Unterkunft in Italienisch (z. B. Hotel, Pension, ...)", $sprache, $link)); ?>
                        .
						<?php if ($standardsprache == "it")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="art_it" type="text" id="art_it" value="<?php echo($art_it); ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isNetherlandsShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="art_nl"
                           class="col-sm-8 "><?php echo(getUebersetzung("Art der Unterkunft in Holländisch (z. B. Hotel, Pension, ...)", $sprache, $link)); ?>
                        .
						<?php if ($standardsprache == "nl")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="art_nl" type="text" id="art_nl" value="<?php echo($art_nl); ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isEspaniaShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="art_nl"
                           class="col-sm-8 "><?php echo(getUebersetzung("Art der Unterkunft in Holländisch (z. B. Hotel, Pension, ...)", $sprache, $link)); ?>
                        .
						<?php if ($standardsprache == "nl")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="art_nl" type="text" id="art_nl" value="<?php echo($art_nl); ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isEstoniaShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="art_es"
                           class="col-sm-8 "><?php echo(getUebersetzung("Art der Unterkunft in Estnisch (z. B. Hotel, Pension, ...)", $sprache, $link)); ?>
                        .
						<?php if ($standardsprache == "es")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>
                        ?></label>
                    <div class="col-sm-4">
                        <input name="art_es" type="text" id="art_es" value="<?php echo($art_es); ?>"
                               class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isGermanShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="zimmerart"
                           class="col-sm-8 "><?php echo(getUebersetzung("Bezeichnung der Zimmer in Deutsch", $sprache, $link)); ?>
						<?php echo(getUebersetzung("(z. B. Ferienwohnung, Ferienhaus, Zimmer, Appartement)", $sprache, $link)); ?>
						<?php if ($standardsprache == "de")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?>
                    </label>
                    <div class="col-sm-4">
                        <input name="zimmerart_de" type="text" id="zimmerart" value="<?php echo($zimmerart); ?>"
                               class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="zimmerart_mz_de"
                           class="col-sm-8 "><?php echo(getUebersetzung("Bezeichnung der Zimmer in Deutsch - Mehrzahl", $sprache, $link)); ?>
						<?php if ($standardsprache == "de")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="zimmerart_mz_de" type="text" id="zimmerart_mz_de"
                               value="<?php echo($zimmerart_mz_de); ?>" class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isEnglishShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="zimmerart_en"
                           class="col-sm-8 "><?php echo(getUebersetzung("Bezeichnung der Zimmer in Englisch", $sprache, $link)); ?>
                        .
						<?php echo(getUebersetzung("(z. B. Ferienwohnung, Ferienhaus, Zimmer, Appartement)", $sprache, $link)); ?>
						<?php if ($standardsprache == "en")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="zimmerart_en" type="text" id="zimmerart_en" value="<?php echo($zimmerart_en); ?>"
                               class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="zimmerart_en"
                           class="col-sm-8 "><?php echo(getUebersetzung("Bezeichnung der Zimmer in Englisch - Mehrzahl", $sprache, $link)); ?>
						<?php if ($standardsprache == "en")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="zimmerart_en" type="text" id="zimmerart_en"
                               value="<?php echo($zimmerart_mz_en); ?>" class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isFrenchShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="zimmerart_fr"
                           class="col-sm-8 "><?php echo(getUebersetzung("Bezeichnung der Zimmer in Französisch", $sprache, $link)); ?>
                        .
						<?php echo(getUebersetzung("(z. B. Ferienwohnung, Ferienhaus, Zimmer, Appartement)", $sprache, $link)); ?>
						<?php if ($standardsprache == "fr")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="zimmerart_fr" type="text" id="zimmerart_fr" value="<?php echo($zimmerart_fr); ?>"
                               class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="zimmerart_mz_fr"
                           class="col-sm-8 "><?php echo(getUebersetzung("Bezeichnung der Zimmer in Französisch - Mehrzahl", $sprache, $link)); ?>
						<?php if ($standardsprache == "fr")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="zimmerart_mz_fr" type="text" id="zimmerart_mz_fr"
                               value="<?php echo($zimmerart_mz_fr); ?>" class="form-control">
                    </div>
                </div>

				<?php
			}
			if (isItalianShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="zimmerart_it"
                           class="col-sm-8 "><?php echo(getUebersetzung("Bezeichnung der Zimmer in Italienisch", $sprache, $link)); ?>
                        .
						<?php echo(getUebersetzung("(z. B. Ferienwohnung, Ferienhaus, Zimmer, Appartement)", $sprache, $link)); ?>
						<?php if ($standardsprache == "it")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="zimmerart_it" type="text" id="zimmerart_it" value="<?php echo($zimmerart_it); ?>"
                               class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="zimmerart_it_mz"
                           class="col-sm-8 "><?php echo(getUebersetzung("Bezeichnung der Zimmer in Italienisch - Mehrzahl", $sprache, $link)); ?>
						<?php if ($standardsprache == "it")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="zimmerart_it_mz" type="text" id="zimmerart_it_mz"
                               value="<?php echo($zimmerart_mz_it); ?>" class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isNetherlandsShown($unterkunft_id, $link))
			{
				?>


                <div class="form-group">
                    <label for="zimmerart_nl"
                           class="col-sm-8 "><?php echo(getUebersetzung("Bezeichnung der Zimmer in Holländisch", $sprache, $link)); ?>
                        .
						<?php echo(getUebersetzung("(z. B. Ferienwohnung, Ferienhaus, Zimmer, Appartement)", $sprache, $link)); ?>
						<?php if ($standardsprache == "nl")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="zimmerart_nl" type="text" id="zimmerart_nl" value="<?php echo($zimmerart_nl); ?>"
                               class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="zimmerart_nl"
                           class="col-sm-8 "><?php echo(getUebersetzung("Bezeichnung der Zimmer in Holländisch - Mehrzahl", $sprache, $link)); ?>
						<?php if ($standardsprache == "nl")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="zimmerart_nl" type="text" id="zimmerart_nl"
                               value="<?php echo($zimmerart_mz_nl); ?>" class="form-control">
                    </div>
                </div>
				<?php
			}
			if (isEspaniaShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="zimmerart_sp"
                           class="col-sm-8 "><?php echo(getUebersetzung("Bezeichnung der Zimmer in Spanisch", $sprache, $link)); ?>
                        .
						<?php echo(getUebersetzung("(z. B. Ferienwohnung, Ferienhaus, Zimmer, Appartement)", $sprache, $link)); ?>
						<?php if ($standardsprache == "sp")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="zimmerart_sp" type="text" id="zimmerart_sp" value="<?php echo($zimmerart_sp); ?>"
                               class="form-control">
                    </div>
                </div>


				<?php
			}
			if (isEstoniaShown($unterkunft_id, $link))
			{
				?>

                <div class="form-group">
                    <label for="zimmerart_mz_sp" class="col-sm-8 "
					       <?php echo(getUebersetzung("Bezeichnung der Zimmer in Estnisch", $sprache, $link)); ?>.
						<?php echo(getUebersetzung("(z. B. Ferienwohnung, Ferienhaus, Zimmer, Appartement)", $sprache, $link)); ?>
						<?php if ($standardsprache == "es")
						{
							echo("*");
						}
						else
						{
						?>
                           (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
					<?php
					}
					?></label>
                    <div class="col-sm-4">
                        <input name="zimmerart_es" type="text" id="zimmerart_es" value="<?php echo($zimmerart_es); ?>"
                               class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="zimmerart_mz_sp"
                           class="col-sm-8 "><?php echo(getUebersetzung("Bezeichnung der Zimmer in Estnisch - Mehrzahl", $sprache, $link)); ?>
						<?php if ($standardsprache == "es")
						{
							echo("*");
						}
						else
						{
							?>
                            (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.", $sprache, $link)); ?>)
							<?php
						}
						?></label>
                    <div class="col-sm-4">
                        <input name="zimmerart_mz_es" type="text" id="zimmerart_mz_es"
                               value="<?php echo($zimmerart_mz_es); ?>" class="form-control">
                    </div>
                </div>
				<?php
			}
			?>
            <div class="form-group">
                <label for="kindesalter" class="col-sm-8 ">
					<?php echo(getUebersetzung("Bis zu welchem Alter erhalten Kinder in Ihrer Unterkunft eine Ermäßigung", $sprache, $link)); ?>
                    ?
                </label>
                <div class="col-sm-2 ">
                    <select class="form-control" name="kindesalter" type="text" id="kindesalter"> <?php
						for ($i = 0; $i <= 23; $i++)
						{
							?>
                            <option
                                    value="<?php echo($i); ?>" <?php if ($kindesalter == $i) echo("selected"); ?>><?php echo($i); ?></option>
							<?php
						}
						?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <input type="submit" name="Submit" class="btn btn-primary" id="retour"
                           value="<?php echo(getUebersetzung("Unterkunft ändern", $sprache, $link)); ?>">
                    <a class="btn btn-primary" href="../inhalt.php">
		                <?php echo(getUebersetzung("Abbrechen", $sprache, $link)); ?>
                    </a>
                </div>
            </div>

        </form>

		<?php
		} //ende if passwortprüfung
		else
		{
			echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
		}
		?>

		<?php include_once("../templates/end.php"); ?>
