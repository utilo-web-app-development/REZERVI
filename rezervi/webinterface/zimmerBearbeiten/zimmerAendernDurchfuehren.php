<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");

/*   
			reservierungsplan
			ein neues zimmer anlegen.
*/
//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/einstellungenFunctions.php");
include_once("../../include/zimmerFunctions.php");
include_once($root . "/include/zimmerAttributes.inc.php");
include_once($root . "/include/propertiesFunctions.php");

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
$zimmer_id     = $_POST["zimmer_id"];
if (isset($_POST["zimmernr"]))
{
	$zimmernr = $_POST["zimmernr"];
}
else
{
	$zimmernr = false;
}
if (isset($_POST["zimmernr_en"]))
{
	$zimmernr_en = $_POST["zimmernr_en"];
}
else
{
	$zimmernr_en = false;
}
if (isset($_POST["zimmernr_fr"]))
{
	$zimmernr_fr = $_POST["zimmernr_fr"];
}
else
{
	$zimmernr_fr = false;
}
if (isset($_POST["zimmernr_it"]))
{
	$zimmernr_it = $_POST["zimmernr_it"];
}
else
{
	$zimmernr_it = false;
}
if (isset($_POST["zimmernr_nl"]))
{
	$zimmernr_nl = $_POST["zimmernr_nl"];
}
else
{
	$zimmernr_nl = false;
}
if (isset($_POST["zimmernr_sp"]))
{
	$zimmernr_sp = $_POST["zimmernr_sp"];
}
else
{
	$zimmernr_sp = false;
}
if (isset($_POST["zimmernr_es"]))
{
	$zimmernr_es = $_POST["zimmernr_es"];
}
else
{
	$zimmernr_es = false;
}

if (isset($_POST["zimmerart"]))
{
	$zimmerart = $_POST["zimmerart"];
}
else
{
	$zimmerart = false;
}
if (isset($_POST["zimmerart_en"]))
{
	$zimmerart_en = $_POST["zimmerart_en"];
}
else
{
	$zimmerart_en = false;
}
if (isset($_POST["zimmerart_fr"]))
{
	$zimmerart_fr = $_POST["zimmerart_fr"];
}
else
{
	$zimmerart_fr = false;
}
if (isset($_POST["zimmerart_en"]))
{
	$zimmerart_en = $_POST["zimmerart_en"];
}
else
{
	$zimmerart_en = false;
}
if (isset($_POST["zimmerart_sp"]))
{
	$zimmerart_sp = $_POST["zimmerart_sp"];
}
else
{
	$zimmerart_sp = false;
}
if (isset($_POST["zimmerart_es"]))
{
	$zimmerart_es = $_POST["zimmerart_es"];
}
else
{
	$zimmerart_es = false;
}
$betten          = $_POST["betten"];
$bettenKinder    = $_POST["bettenKinder"];
$linkName        = $_POST["linkName"];
$haustiere       = $_POST["Haustiere"];
$sprache         = getSessionWert(SPRACHE);
$standardsprache = getStandardSprache($unterkunft_id, $link);

include_once("../templates/headerA.php");
?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php
include_once("../templates/headerB.php");
include_once("../templates/bodyA.php");
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2> <?php echo(getUebersetzung("Zimmer Änderung!", $sprache, $link)); ?></h2>
    </div>
    <div class="panel-body">
		<?php
		//prüfung ob alle pflicht-felder eingegeben wurden:
		if ((($standardsprache == "de") && ($zimmernr == false || !isset($zimmernr))) ||
			(($standardsprache == "en") && ($zimmernr_en == false || !isset($zimmernr_en))) ||
			(($standardsprache == "fr") && ($zimmernr_fr == false || !isset($zimmernr_fr))) ||
			(($standardsprache == "it") && ($zimmernr_it == false || !isset($zimmernr_it))) ||
			(($standardsprache == "nl") && ($zimmernr_nl == false || !isset($zimmernr_nl))) ||
			(($standardsprache == "sp") && ($zimmernr_sp == false || !isset($zimmernr_sp))) ||
			(($standardsprache == "es") && ($zimmernr_es == false || !isset($zimmernr_es)))
		)
		{
			?>

            <div class="alert alert-danger" role="alert">
				<?php echo(getUebersetzung("Bitte geben Sie die Zimmernummer ihrer Standardsprache ein!", $sprache, $link)); ?>
            </div>


			<?php
			include_once("./zimmerAendern.php");
		}
		else if ((($standardsprache == "en") && ($zimmerart == false || !isset($zimmerart))) ||
			(($standardsprache == "en") && ($zimmerart_en == false || !isset($zimmerart_en))) ||
			(($standardsprache == "fr") && ($zimmerart_fr == false || !isset($zimmerart_fr))) ||
			(($standardsprache == "it") && ($zimmerart_it == false || !isset($zimmerart_it))) ||
			(($standardsprache == "nl") && ($zimmerart_nl == false || !isset($zimmerart_nl))) ||
			(($standardsprache == "sp") && ($zimmerart_sp == false || !isset($zimmerart_sp))) ||
			(($standardsprache == "es") && ($zimmerart_es == false || !isset($zimmerart_es)))
		)
		{
			?>

            <div class="alert alert-danger" role="alert">
				<?php echo(getUebersetzung("Bitte geben Sie die Zimmerart ein!", $sprache, $link)); ?>
            </div>

			<?php
			include_once("./zimmerAendern.php");
		}


		if ($standardsprache == "de")
		{
			$defaultZimmerNr = $zimmernr;
			$defaultZimmerAr = $zimmerart;
		}
		else if ($standardsprache == "en")
		{
			$defaultZimmerNr = $zimmernr_en;
			$defaultZimmerAr = $zimmerart_en;
		}
		else if ($standardsprache == "fr")
		{
			$defaultZimmerNr = $zimmernr_fr;
			$defaultZimmerAr = $zimmerart_fr;
		}
		else if ($standardsprache == "it")
		{
			$defaultZimmerNr = $zimmernr_it;
			$defaultZimmerAr = $zimmerart_it;
		}
		else if ($standardsprache == "nl")
		{
			$defaultZimmerNr = $zimmernr_nl;
			$defaultZimmerAr = $zimmerart_nl;
		}
		else if ($standardsprache == "sp")
		{
			$defaultZimmerNr = $zimmernr_sp;
			$defaultZimmerAr = $zimmerart_sp;
		}
		else if ($standardsprache == "es")
		{
			$defaultZimmerNr = $zimmernr_es;
			$defaultZimmerAr = $zimmerart_es;
		}

		//alles korrekt eingegeben ->
		//falls eine sprache leer ist, standardsprache eingeben:
		if (!isset($zimmernr) || $zimmernr == false)
		{
			$zimmernr = $defaultZimmerNr;
		}
		if (!isset($zimmernr_en) || $zimmernr_en == false)
		{
			$zimmernr_en = $defaultZimmerNr;
		}
		if (!isset($zimmernr_fr) || $zimmernr_fr == false)
		{
			$zimmernr_fr = $defaultZimmerNr;
		}
		if (!isset($zimmernr_it) || $zimmernr_it == false)
		{
			$zimmernr_it = $defaultZimmerNr;
		}
		if (!isset($zimmernr_nl) || $zimmernr_nl == false)
		{
			$zimmernr_nl = $defaultZimmerNr;
		}
		if (!isset($zimmernr_sp) || $zimmernr_sp == false)
		{
			$zimmernr_sp = $defaultZimmerNr;
		}
		if (!isset($zimmernr_es) || $zimmernr_es == false)
		{
			$zimmernr_es = $defaultZimmerNr;
		}

		//das gleiche mit der zimmerart:
		if (!isset($zimmerart_en) || $zimmerart_en == false)
		{
			$zimmerart_en = $defaultZimmerAr;
		}
		if (!isset($zimmerart_fr) || $zimmerart_fr == false)
		{
			$zimmerart_fr = $defaultZimmerAr;
		}
		if (!isset($zimmerart) || $zimmerart == false)
		{
			$zimmerart = $defaultZimmerAr;
		}
		if (!isset($zimmerart_it) || $zimmerart_it == false)
		{
			$zimmerart_it = $defaultZimmerAr;
		}
		if (!isset($zimmerart_nl) || $zimmerart_nl == false)
		{
			$zimmerart_nl = $defaultZimmerAr;
		}
		if (!isset($zimmerart_sp) || $zimmerart_sp == false)
		{
			$zimmerart_sp = $defaultZimmerAr;
		}
		if (!isset($zimmerart_es) || $zimmerart_es == false)
		{
			$zimmerart_es = $defaultZimmerAr;
		}

		?>

		<?php //passwortprüfung:
		if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
		{

			if (updateZimmer($zimmer_id, $unterkunft_id, $zimmernr, $betten, $bettenKinder, $zimmerart, $linkName, $haustiere, $link))
			{

				//sollen auch noch weitere attribute angezeigt werden?
				if (getPropertyValue(SHOW_ZIMMER_ATTRIBUTE_GESAMTUEBERSICHT, $unterkunft_id, $link) == "true")
				{
					$res = getAttributes();
					while ($d = mysqli_fetch_array($res))
					{
						$att_id = $d["PK_ID"];
						if (isset($_POST["attWert_" . $att_id]))
						{
							$wert = $_POST["attWert_" . $att_id];
							setAttributWert($zimmer_id, $att_id, $wert);
						}
					}
				}

				?>

                <div class="alert alert-success" role="alert">
					<?php echo(getUebersetzung("Die Änderung wurde erfolgreich durchgeführt", $sprache, $link)); ?>.
                </div>


				<?php
			}
			else
			{
				?>

                <div class="alert alert-danger" role="alert">
					<?php echo(getUebersetzung("Die Änderung konnte nicht erfolgreich durchgeführt werden, versuchen sie es bitte nochmals", $sprache, $link)); ?>
                    .
                </div>


				<?php
			}

			setUebersetzungUnterkunft($zimmernr, $defaultZimmerNr, "de", $standardsprache, $unterkunft_id, $link);
			setUebersetzungUnterkunft($zimmernr_en, $defaultZimmerNr, "en", $standardsprache, $unterkunft_id, $link);
			setUebersetzungUnterkunft($zimmernr_fr, $defaultZimmerNr, "fr", $standardsprache, $unterkunft_id, $link);
			setUebersetzungUnterkunft($zimmernr_it, $defaultZimmerNr, "it", $standardsprache, $unterkunft_id, $link);
			setUebersetzungUnterkunft($zimmernr_nl, $defaultZimmerNr, "nl", $standardsprache, $unterkunft_id, $link);
			setUebersetzungUnterkunft($zimmernr_sp, $defaultZimmerNr, "sp", $standardsprache, $unterkunft_id, $link);
			setUebersetzungUnterkunft($zimmernr_es, $defaultZimmerNr, "es", $standardsprache, $unterkunft_id, $link);
			setUebersetzungUnterkunft($zimmerart, $defaultZimmerAr, "de", $standardsprache, $unterkunft_id, $link);
			setUebersetzungUnterkunft($zimmerart_en, $defaultZimmerAr, "en", $standardsprache, $unterkunft_id, $link);
			setUebersetzungUnterkunft($zimmerart_fr, $defaultZimmerAr, "fr", $standardsprache, $unterkunft_id, $link);
			setUebersetzungUnterkunft($zimmerart_it, $defaultZimmerAr, "it", $standardsprache, $unterkunft_id, $link);
			setUebersetzungUnterkunft($zimmerart_nl, $defaultZimmerAr, "nl", $standardsprache, $unterkunft_id, $link);
			setUebersetzungUnterkunft($zimmerart_sp, $defaultZimmerAr, "sp", $standardsprache, $unterkunft_id, $link);
			setUebersetzungUnterkunft($zimmerart_es, $defaultZimmerAr, "es", $standardsprache, $unterkunft_id, $link);
			?>

            <div class="row">


<!--                <div class="col-sm-2">-->
<!--                    <form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">-->
<!---->
<!--                        <input name="retour" type="submit" class="btn btn-success" id="retour"-->
<!---->
<!--                               value="--><?php //echo(getUebersetzung("Hauptmenü", $sprache, $link)); ?><!--">-->
<!---->
<!--                    </form>-->
<!--                </div>-->
                <div class="col-sm-1" style="text-align: right;">
                    <form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">
                        <input name="retour" type="submit" class="btn btn-default" id="retour"
                               value="<?php echo(getUebersetzung("Zurück", $sprache, $link)); ?>">
                    </form>
                </div>


            </div>


			<?php
		} //ende if passwortprüfung
		else
		{
			echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
		}
		?>
    </div>
</div>

</body>
</html>
