<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			daten des gastes aufnehmen
			author: christian osterrieder utilo.eu					
			
			dieser seite muss übergeben werden:
			Unterkunft PK_ID ($unterkunft_id)
			Zimmer PK_ID ($zimmer_id)
			Datum: $vonTag,$vonMonat,$vonJahr
				   $bisTag,$bisMonat,$bisJahr			
			
			die seite verwendet anfrage/send.php um das ausgefüllte
			formular zu versenden
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort      = getSessionWert(PASSWORT);
$benutzername  = getSessionWert(BENUTZERNAME);
$status        = $_POST["status"];
$vonTag        = $_POST["vonTag"];
$bisTag        = $_POST["bisTag"];
$vonMonat      = $_POST["vonMonat"];
$bisMonat      = $_POST["bisMonat"];
$vonJahr       = $_POST["vonJahr"];
$bisJahr       = $_POST["bisJahr"];
$zimmer_id     = $_POST["zimmer_id"];
if (isset($_POST["gast_id"]))
{
	$gast_id = $_POST["gast_id"];
}
$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");
//Unterkunft-funktionen einbeziehen:
include_once("../../../include/unterkunftFunctions.php");
//zimmer-funktionen einbeziehen:
include_once("../../../include/zimmerFunctions.php");
//datum-funktionen einbeziehen:
include_once("../../../include/datumFunctions.php");
//gast-funktionen einbinden:
include_once("../../../include/gastFunctions.php");
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/reservierungFunctions.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once($root . "/include/propertiesFunctions.php");
include_once($root . "/suche/sucheFunctions.php");

//variablen initialisieren:
if (isset($_POST["ben"]) && isset($_POST["pass"])) {
	$ben = $_POST["ben"];
	$pass = $_POST["pass"];
} else {
	//aufruf kam innerhalb des webinterface:
	$ben = getSessionWert(BENUTZERNAME);
	$pass = getSessionWert(PASSWORT);
}

$benutzer_id = -1;
if (isset($ben) && isset($pass)) {
	$benutzer_id = checkPassword($ben, $pass, $link);
}
if ($benutzer_id == -1) {
	//passwortprüfung fehlgeschlagen, auf index-seite zurück:
	$fehlgeschlagen = true;
	header("Location: ".$URL."webinterface/index.php?fehlgeschlagen=true"); /* Redirect browser */
	exit();
	//include_once("./index.php");
	//exit;
} else {
	$benutzername = $ben;
	$passwort = $pass;
	setSessionWert(BENUTZERNAME, $benutzername);
	setSessionWert(PASSWORT, $passwort);

	//unterkunft-id holen:
	$unterkunft_id = getUnterkunftID($benutzer_id, $link);
	setSessionWert(UNTERKUNFT_ID, $unterkunft_id);
	setSessionWert(BENUTZER_ID, $benutzer_id);
}

//falls die gast_id nicht angegeben wurde auf -1 setzen:
if (empty($gast_id) || $gast_id == "")
{
	$gast_id = -1;
}
?>
<?php include_once("../../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../templates/headerB.php"); ?>
<!-- checken ob formular korrekt ausgefüllt wurde: -->
<script src="./checkForm.php" type="text/javascript">
</script>
<?php include_once("../../templates/bodyA.php"); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
			<?php echo(getUebersetzung("Reservierung Ändern", $sprache, $link)); ?>
        </h3>
    </div>
    <div class="panel-body">

		<?php
		//passwortprüfung:
		if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
		{ ?>
			<?php
			//zuerst mal prüfen ob datum und so passt:
			//variableninitialisierungen:
			$datumVon = parseDateFormular($vonTag, $vonMonat, $vonJahr);
			$datumBis = parseDateFormular($bisTag, $bisMonat, $bisJahr);

			//das datum ist nicht korrekt, das von-datum "höher" als bis-datum
			if (isDatumEarlier($vonTag, $vonMonat, $vonJahr, $bisTag, $bisMonat, $bisJahr) == false)
			{

				?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-danger" role="alert">
                            <h4>
								<?php echo(getUebersetzung("Das Reservierungs-Datum wurde nicht korrekt angegeben", $sprache, $link)); ?>
                                !
                            </h4>
                            <h4>
								<?php echo(getUebersetzung("Bitte korrigieren Sie das Datum", $sprache, $link)); ?>
                                !
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-11 col-sm-1">
                        <form action="index.php" method="post" name="adresseForm" target="_self"
                              id="adresseForm">
                            <input name="zimmer_id" type="hidden" id="zimmer_id8" value="<?php echo $zimmer_id ?>">
                            <input name="monat" type="hidden" id="vonMonat2" value="<?php echo $vonMonat ?>">
                            <input name="jahr" type="hidden" id="vonJahr2" value="<?php echo $vonJahr ?>">
                            <input type="submit" name="Submit" class="btn btn-primary"
                                   value="<?php echo(getUebersetzung("zurück", $sprache, $link)); ?>"></form>
                    </div>
                </div>
                <div class="row">
                    <hr>
                </div>

				<?php
			}//ende if datum
			//zimmer ist zu dieser zeit belegt:
			else if (isRoomTaken($zimmer_id, $vonTag, $vonMonat, $vonJahr, $bisTag, $bisMonat, $bisJahr, $link) && ($status == 2))
			{
				?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-warning" role="alert">
                            <h4><?php echo(getUebersetzung("Zu diesem Datum existiert bereits eine Reservierung oder die Reservierungen überschneiden sich", $sprache, $link)); ?>
                                !</h4>
                            <h4><?php echo(getUebersetzung("Bitte korrigieren Sie das Datum oder löschen Sie die bereits vorhandene Reservierung", $sprache, $link)); ?>
                                !</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                        <form action="../ansichtWaehlen.php" method="post" name="adresseForm" target="_self"
                              id="adresseForm">
                            <input name="zimmer_id" type="hidden" id="zimmer_id8" value="<?php echo $zimmer_id ?>">
                            <input name="monat" type="hidden" id="vonMonat2" value="<?php echo $vonMonat ?>">
                            <input name="jahr" type="hidden" id="vonJahr2" value="<?php echo $vonJahr ?>">
                            <input type="submit" name="Submit" class="btn btn-primary"
                                   value="<?php echo(getUebersetzung("zurück", $sprache, $link)); ?>">
                        </form>
                    </div>
                </div>
                <div class="row">
                    <hr>
                </div>
				<?php
			} //wenn datum ok:
			else
			{
				?>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="well">
							<?php echo(getUebersetzung("Reservierungs-Anderung für", $sprache, $link)); ?>
							<?php echo(getUebersetzungUnterkunft(getZimmerArt($unterkunft_id, $zimmer_id, $link), $sprache, $unterkunft_id, $link)); ?>
                            : <?php echo(getUebersetzungUnterkunft(getZimmerNr($unterkunft_id, $zimmer_id, $link), $sprache, $unterkunft_id, $link)); ?>

                        </div>


                        <div class="row">
                            <label class="control-label col-sm-2">
								<?php echo(getUebersetzung("von", $sprache, $link)); ?>:
                            </label>
                            <label class="col-sm-10">
								<?php echo $vonTag ?>.<?php echo $vonMonat ?>.<?php echo $vonJahr ?>
                            </label>
                        </div>

                        <div class="row">
                            <label class="control-label col-sm-2">
								<?php echo(getUebersetzung("bis", $sprache, $link)); ?>:
                            </label>

                            <label class="col-sm-10">
								<?php echo $bisTag ?>.<?php echo $bisMonat ?>.<?php echo $bisJahr ?>
                            </label>
                        </div>
                        <div class="row">
                            <label class="col-sm-2">
	                            <?php echo(getUebersetzung("Status", $sprache, $link)); ?>:
                            </label>

                            <div class="alert col-sm-1
                            <?php
                            //status = 0: frei
                            //status = 1: reserviert
                            //status = 2: belegt
                            if ($status == 0)
                            {
	                            echo("frei");
                            }
                            elseif ($status == 1)
                            {
	                            echo("reserviert");
                            }
                            elseif ($status == 2)
                            {
	                            echo("belegt");
                            }
                            ?>" style="padding:2px;">
	                            <?php
	                            //status = 0: frei
	                            //status = 1: reserviert
	                            //status = 2: belegt
	                            if ($status == 0)
	                            {
		                            echo(getUebersetzung("frei", $sprache, $link));
	                            }
                                elseif ($status == 1)
	                            {
		                            echo(getUebersetzung("reserviert", $sprache, $link));
	                            }
                                elseif ($status == 2)
	                            {
		                            echo(getUebersetzung("belegt", $sprache, $link));
	                            }
	                            ?>
                            </div>
                            <!--<span class="<?php
/*							//status = 0: frei
							//status = 1: reserviert
							//status = 2: belegt
							if ($status == 0)
							{
								echo("frei");
							}
                            elseif ($status == 1)
							{
								echo("reserviert");
							}
                            elseif ($status == 2)
							{
								echo("belegt");
							}
							*/?>">
                                <?php
/*								//status = 0: frei
								//status = 1: reserviert
								//status = 2: belegt
								if ($status == 0)
								{
									echo(getUebersetzung("frei", $sprache, $link));
								}
                                elseif ($status == 1)
								{
									echo(getUebersetzung("reserviert", $sprache, $link));
								}
                                elseif ($status == 2)
								{
									echo(getUebersetzung("belegt", $sprache, $link));
								}
								*/?>
                            </span>-->
                        </div>

                    </div>
                </div>
                <div class="row">
                    <hr>
                </div>

				<?php
//wenn belegt oder reserviert eingabe des gastes fordern:
				if ($status != 0)
				{ ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-warning">
								<?php echo(getUebersetzung("Wenn sie keinen Gast eingeben wird die Reservierung für einen anonymen Gast gespeichert", $sprache, $link)); ?>
                                .
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-9 col-sm-3" style="text-align: right;">
                            <form action="./resEintragen.php" method="post" name="noAdressForm" target="_self"
                                  id="noAdressForm">
                                <input name="gast_id" type="hidden" id="gast_id" value="1">
                                <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo($zimmer_id); ?>">
                                <input name="vonTag" type="hidden" id="vonTag" value="<?php echo $vonTag ?>">
                                <input name="bisTag" type="hidden" id="bisTag" value="<?php echo $bisTag ?>">
                                <input name="vonMonat" type="hidden" id="vonMonat" value="<?php echo $vonMonat ?>">
                                <input name="bisMonat" type="hidden" id="bisMonat" value="<?php echo $bisMonat ?>">
                                <input name="vonJahr" type="hidden" id="vonJahr" value="<?php echo $vonJahr ?>">
                                <input name="bisJahr" type="hidden" id="bisJahr" value="<?php echo $bisJahr ?>">
                                <input name="status" type="hidden" id="status" value="<?php echo $status ?>">
                                <input name="monat" type="hidden" id="vonMonat2" value="<?php echo $vonMonat ?>">
                                <input name="jahr" type="hidden" id="vonJahr2" value="<?php echo $vonJahr ?>">
                                <button name="send" type="submit" class="btn btn-success" id="send">
                                    <span class="glyphicon glyphicon-send"></span>
									<?php echo(getUebersetzung("keinen Gast eingeben", $sprache, $link)); ?>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <p>
								<?php echo(getUebersetzung("Bitte geben Sie hier den Gast ein, oder wählen Sie einen bereits vorhanden Gast aus der Liste aus", $sprache, $link)); ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="control-label">
								<?php echo(getUebersetzung("Gast auswählen", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-4">
                            <form action="./resAendern.php" method="post" name="gastWaehlen" target="_self">
                                <select name="gast_id" id="select" onChange="submit();" class="form-control">
                                    <option value="-1" selected>
                                        <?php echo(getUebersetzung("neuer Gast", $sprache, $link)); ?>
                                    </option>
									<?php //alle gäste dieser unterkunft vorschlagen:
									$query = ("SELECT 
                                           PK_ID,Vorname,Nachname,Ort
                                           FROM
                                           Rezervi_Gast
                                           WHERE					   
                                           FK_Unterkunft_ID = '$unterkunft_id'					   
                                           ORDER BY	
                                           Nachname
                                     ");

									$res = mysqli_query($link, $query);
									if (!$res)
									{
										echo("die Anfrage scheitert");
									} //ende if
									else
									{
										while ($d = mysqli_fetch_array($res))
										{
											?>
                                            <option
                                                    value="<?php echo($d["PK_ID"]); ?>" <?php if ($d["PK_ID"] == $gast_id) echo("selected"); ?>><?php echo($d["Nachname"] . " " . $d["Vorname"] . ", " . $d["Ort"]); ?></option>
											<?php
										} //ende while
									} //ende else
									?>
                                </select>
                                <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo $zimmer_id ?>">
                                <input name="vonTag" type="hidden" id="vonTag" value="<?php echo $vonTag ?>">
                                <input name="bisTag" type="hidden" id="bisTag" value="<?php echo $bisTag ?>">
                                <input name="vonMonat" type="hidden" id="vonMonat" value="<?php echo $vonMonat ?>">
                                <input name="bisMonat" type="hidden" id="bisMonat" value="<?php echo $bisMonat ?>">
                                <input name="vonJahr" type="hidden" id="vonJahr" value="<?php echo $vonJahr ?>">
                                <input name="bisJahr" type="hidden" id="bisJahr" value="<?php echo $bisJahr ?>">
                                <input name="monat" type="hidden" id="vonMonat" value="<?php echo $vonMonat ?>">
                                <input name="jahr" type="hidden" id="vonJahr" value="<?php echo $vonJahr ?>">
                                <input name="status" type="hidden" id="status" value="<?php echo $status ?>">
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <hr>
                    </div>


                    <form action="./resEintragen.php" method="post" name="resEintragen" target="_self"
                          class="form-horizontal"
                          id="resEintragen">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("neuer Gast/Gast ändern", $sprache, $link)); ?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("Anrede", $sprache, $link)); ?>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <select name="anrede" id="select2" class="form-control">
									<?php if (!(empty($gast_id)))
										$anrede = getGuestAnrede($gast_id, $link); ?>
                                    <option<?php if ((!(empty($anrede))) && ($anrede == "Familie")) echo(" selected"); ?>><?php echo(getUebersetzung("Familie", $sprache, $link)); ?></option>
                                    <option<?php if ((!(empty($anrede))) && ($anrede == "Frau")) echo(" selected"); ?>><?php echo(getUebersetzung("Frau", $sprache, $link)); ?></option>
                                    <option<?php if ((!(empty($anrede))) && ($anrede == "Herr")) echo(" selected"); ?>><?php echo(getUebersetzung("Herr", $sprache, $link)); ?></option>
                                    <option<?php if ((!(empty($anrede))) && ($anrede == "Firma")) echo(" selected"); ?>><?php echo(getUebersetzung("Firma", $sprache, $link)); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("Vorname", $sprache, $link)); ?>*
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <input name="vorname" type="text" id="vorname2" class="form-control"
                                       required="required" <?php if (!(empty($gast_id)))
								{
									echo("value=\"" . getGuestVorname($gast_id, $link) . "\"");
								} ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("Nachname", $sprache, $link)); ?>*
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <input name="nachname" type="text" id="nachname2" class="form-control"
                                       required="required" <?php if (!(empty($gast_id)))
								{
									echo("value=\"" . getGuestNachname($gast_id, $link) . "\"");
								} ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("Straße/Hausnummer", $sprache, $link)); ?>*
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <input name="strasse" type="text" id="strasse2" class="form-control"
                                       required="required" <?php if (!(empty($gast_id)))
								{
									echo("value=\"" . getGuestStrasse($gast_id, $link) . "\"");
								} ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("Postleitzahl", $sprache, $link)); ?>*
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <input name="plz" type="text" id="plz2" class="form-control"
                                       required="required" <?php if (!(empty($gast_id)))
								{
									echo("value=\"" . getGuestPLZ($gast_id, $link) . "\"");
								} ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("Ort", $sprache, $link)); ?>*
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <input name="ort" type="text" id="ort2" class="form-control"
                                       required="required" <?php if (!(empty($gast_id)))
								{
									echo("value=\"" . getGuestOrt($gast_id, $link) . "\"");
								} ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("Land", $sprache, $link)); ?>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <input name="land" type="text" class="form-control"
                                       id="land2" <?php if (!(empty($gast_id)))
								{
									echo("value=\"" . getGuestLand($gast_id, $link) . "\"");
								} ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("E-Mail-Adresse", $sprache, $link)); ?>*
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <input name="email" type="text" id="email2" class="form-control"
                                       required="required" <?php if (!(empty($gast_id)))
								{
									echo("value=\"" . getGuestEmail($gast_id, $link) . "\"");
								} ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("Telefonnummer", $sprache, $link)); ?>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <input name="tel" type="text" id="tel"
                                       class="form-control" <?php if (!(empty($gast_id)))
								{
									echo("value=\"" . getGuestTel($gast_id, $link) . "\"");
								} ?>>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("Faxnummer", $sprache, $link)); ?>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <input name="fax" type="text" id="fax2"
                                       class="form-control" <?php if (!(empty($gast_id)))
								{
									echo("value=\"" . getGuestFax($gast_id, $link) . "\"");
								} ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("bevorzugte Sprache", $sprache, $link)); ?>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <select name="speech" id="speech" class="form-control">
									<?php
									//sprachen des belegungsplanes anzeigen:
									$res = getSprachen($unterkunft_id, $link);
									while ($d = mysqli_fetch_array($res))
									{
										$spr         = $d["Sprache_ID"];
										$bezeichnung = getBezeichnungOfSpracheID($spr, $link);
										?>
                                        <option
                                                value="<?php echo($spr); ?>" <?php if (getGuestSprache($gast_id, $link) == $spr) echo("selected"); ?>><?php echo(getUebersetzung($bezeichnung, $sprache, $link)); ?></option>
										<?php
									}
									?>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("Anmerkungen", $sprache, $link)); ?>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <textarea name="anmerkungen" id="textarea" class="form-control">
                                    <?php if (!(empty($gast_id)))
                                    {
	                                    echo(getGuestAnmerkung($gast_id, $link));
                                    } ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <p>
									<?php echo(getUebersetzung("Bitte geben Sie hier die Anzahl der Gäste für die Reservierung/Belegung ein", $sprache, $link)); ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php echo(getUebersetzung("Anzahl Erwachsene", $sprache, $link)); ?>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <select name="anzahlErwachsene" id="anzahlErwachsene" class="form-control">
									<?php
									$anzahlBetten = getBetten($unterkunft_id, $zimmer_id, $link);
									$anzahlBetten += 1;
									$anzahlBetten -= 1; //integer!
									for ($i = 0; $i <= $anzahlBetten; $i++)
									{ ?>
                                        <option
                                                value="<?php echo($i + 1); ?>" <?php if ($i == 2) echo("selected"); ?>><?php echo($i + 1); ?></option>
										<?php
									} //ende for schleife
									?>
                                </select>
                            </div>
                        </div>
						<?php $anzahlKinderBetten = getAnzahlKinder($unterkunft_id, $link);
						if (!empty($anzahlKinderBetten) && $anzahlKinderBetten > 0)
						{
							?>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label class="control-label">
										<?php echo(getUebersetzung("Anzahl Kinder unter", $sprache, $link)); ?><?php echo(getKindesalter($unterkunft_id, $link)); ?><?php echo(getUebersetzung("Jahren", $sprache, $link)); ?>
                                    </label>
                                </div>
                                <div class="col-sm-4">
                                    <select name="anzahlKinder" id="anzahlKinder" class="form-control">
										<?php
										for ($i = 0; $i <= ($anzahlKinderBetten); $i++)
										{
											?>
                                            <option
                                                    value="<?php echo($i); ?>" <?php if ($i == 0) echo("selected"); ?>><?php echo($i); ?></option>
											<?php
										}//ende for schleife
										?>
                                    </select>
                                </div>
                            </div>
							<?php
						}
						if (getPropertyValue(PENSION_UEBERNACHTUNG, $unterkunft_id, $link) == "true")
						{
							?>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label class="control-label">
										<?php
										echo(getUebersetzung("Übernachtung", $sprache, $link));
										?>
                                    </label>
                                </div>
                                <div class="col-sm-4">
                                    <input name="zusatz" type="checkbox" value="Uebernachtung" checked="checked"/>
                                </div>
                            </div>

							<?php
						}
						?>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">
									<?php
									if (getPropertyValue(PENSION_FRUEHSTUECK, $unterkunft_id, $link) == "true")
									{
										echo(getUebersetzung("Frühstück / ", $sprache, $link));
									}
									if (getPropertyValue(PENSION_HALB, $unterkunft_id, $link) == "true")
									{

										echo(getUebersetzung("Halbpension / ", $sprache, $link));
									}
									if (getPropertyValue(PENSION_VOLL, $unterkunft_id, $link) == "true")
									{

										echo(getUebersetzung("Vollpension", $sprache, $link));
									}
									?>

                                </label>
                            </div>
                            <div class="col-sm-4">
                                <div class="btn-group" data-toggle="buttons">
									<?php if (getPropertyValue(PENSION_FRUEHSTUECK, $unterkunft_id, $link) == "true")
									{
										?>
                                        <label class="btn btn-danger active">
                                            <input type="radio" name="zusatz" id="fruehstueck" autocomplete="off"
                                                   value="Fruehstueck"> <?php echo(getUebersetzung("Frühstück", $sprache, $link)); ?>
                                        </label>
									<?php } ?>
									<?php
									if (getPropertyValue(PENSION_HALB, $unterkunft_id, $link) == "true")
									{
										?>
                                        <label class="btn btn-success">
                                            <input type="radio" name="zusatz" id="halbpension" autocomplete="off"
                                                   value="Halbpension"> <?php echo(getUebersetzung("Halbpension", $sprache, $link)); ?>
                                        </label>
										<?php
									}
									if (getPropertyValue(PENSION_VOLL, $unterkunft_id, $link) == "true")
									{
										?>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="zusatz" id="vollpension" autocomplete="off"
                                                   value="Vollpension"
                                                   checked> <?php echo(getUebersetzung("Vollpension", $sprache, $link)); ?>
                                        </label>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <!--                    --><?php
						//                        if (getPropertyValue(PENSION_FRUEHSTUECK, $unterkunft_id, $link) == "true") {
						//                            ?>
                        <!---->
                        <!--                            <div class="form-group">-->
                        <!--                                <div class="col-sm-4">-->
                        <!--                                    <label class="control-label">-->
                        <!--                                        --><?php
						//                                        echo(getUebersetzung("Frühstück", $sprache, $link));
						//                                        ?>
                        <!--                                    </label>-->
                        <!--                                </div>-->
                        <!--                                <div class="col-sm-4">-->
                        <!--                                    <input name="zusatz" type="radio" value="Fruehstueck" />-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        --><?php //}
						//                        if (getPropertyValue(PENSION_HALB, $unterkunft_id, $link) == "true") {
						//                            ?>
                        <!--                            <div class="form-group">-->
                        <!--                                <div class="col-sm-4">-->
                        <!--                                    <label class="control-label">-->
                        <!--                                        --><?php
						//                                        echo(getUebersetzung("Halbpension", $sprache, $link));
						//                                        ?>
                        <!--                                    </label>-->
                        <!--                                </div>-->
                        <!--                                <div class="col-sm-4">-->
                        <!--                                    <input name="zusatz" type="radio" value="Halbpension" />-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        --><?php //}
						//                        if (getPropertyValue(PENSION_VOLL, $unterkunft_id, $link) == "true") {
						//                            ?>
                        <!--                            <div class="form-group">-->
                        <!--                                <div class="col-sm-4">-->
                        <!--                                    <label class="control-label">-->
                        <!--                                        --><?php
						//                                        echo(getUebersetzung("Vollpension", $sprache, $link));
						//                                        ?>
                        <!--                                    </label>-->
                        <!--                                </div>-->
                        <!--                                <div class="col-sm-4">-->
                        <!--                                    <input name="zusatz" type="radio" value="Vollpension" checked="checked"/>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        --><?php //}
						//                        ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="alert alert-warning">
									<?php echo(getUebersetzung("Die mit * gekennzeichneten Felder müssen ausgefüllt werden", $sprache, $link)); ?>
                                    !
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-offset-10 col-sm-2" style="text-align: right;">
                                <input name="gast_id" type="hidden" id="gast_id" value="<?php echo $gast_id ?>">
                                <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo $zimmer_id ?>">
                                <input name="vonTag" type="hidden" id="vonTag" value="<?php echo $vonTag ?>">
                                <input name="bisTag" type="hidden" id="bisTag" value="<?php echo $bisTag ?>">
                                <input name="vonMonat" type="hidden" id="vonMonat" value="<?php echo $vonMonat ?>">
                                <input name="bisMonat" type="hidden" id="bisMonat" value="<?php echo $bisMonat ?>">
                                <input name="vonJahr" type="hidden" id="vonJahr" value="<?php echo $vonJahr ?>">
                                <input name="bisJahr" type="hidden" id="bisJahr" value="<?php echo $bisJahr ?>">
                                <input name="status" type="hidden" id="status" value="<?php echo $status ?>">
                                <input name="monat" type="hidden" id="vonMonat2" value="<?php echo $vonMonat ?>">
                                <input name="jahr" type="hidden" id="vonJahr2" value="<?php echo $vonJahr ?>">
                                <button name="send" type="submit" class="btn btn-success" id="send">
                                    <span class="glyphicon glyphicon-send"></span>
									<?php echo(getUebersetzung("weiter", $sprache, $link)); ?>
                                </button>
                            </div>
                        </div>

                    </form>
				<?php } //ende if status != frei
				else
				{ //wenn nur frei dann daten löschen und nur ok-button anzeigen:
					?>
					<?php
					//alle Reservierungen ausgeben die gelöscht werden, wenn auf ok gedrueckt wird:
					$vonDatum = parseDateFormular($vonTag, $vonMonat, $vonJahr);
					$bisDatum = parseDateFormular($bisTag, $bisMonat, $bisJahr);
					$result   = getReservationWithDate($zimmer_id, $vonDatum, $bisDatum, $link);
					$first    = true;
					while ($d = mysqli_fetch_array($result))
					{
						if ($first)
						{ ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="alert alert-danger">
										<?php echo(getUebersetzung("Folgende Reservierungen werden gelöscht", $sprache, $link)); ?>
                                        !
                                    </div>
                                </div>
                            </div>
						<?php }
						$first   = false;
						$pk_id   = $d["PK_ID"];
						$gast_id = getGastID($pk_id, $link);
						$datumV  = getDatumVon($pk_id, $link);
						$datumB  = getDatumBis($pk_id, $link);
						$gast_nn = getGuestNachname($gast_id, $link);
						?>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">
									<?php
									echo(getUebersetzung("Reservierung von", $sprache, $link) . " " . $datumV . " " . getUebersetzung("bis", $sprache, $link) . " " . $datumB . ", " . getUebersetzung("Gast", $sprache, $link) . ": " . $gast_nn);
									?>
                                </label>
                            </div>
                        </div>
						<?php
					} //ende while reservierungen anzeigen
					?>

                    <div class="form-group">
                        <div class="col-sm-offset-8 col-sm-2" style="text-align: right;">
                            <form name="zimmerFrei" method="post" action="./resEntfernen.php" target="_self"
                                  class="form-horizontal">
                                <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo $zimmer_id ?>">
                                <input name="vonTag" type="hidden" id="vonTag" value="<?php echo $vonTag ?>">
                                <input name="bisTag" type="hidden" id="bisTag" value="<?php echo $bisTag ?>">
                                <input name="vonMonat" type="hidden" id="vonMonat" value="<?php echo $vonMonat ?>">
                                <input name="bisMonat" type="hidden" id="bisMonat" value="<?php echo $bisMonat ?>">
                                <input name="vonJahr" type="hidden" id="vonJahr" value="<?php echo $vonJahr ?>">
                                <input name="bisJahr" type="hidden" id="bisJahr" value="<?php echo $bisJahr ?>">
                                <input name="monat" type="hidden" id="vonMonat2" value="<?php echo $vonMonat ?>">
                                <input name="jahr" type="hidden" id="vonJahr2" value="<?php echo $vonJahr ?>">
                                <input name="status" type="hidden" id="status" value="<?php echo $status ?>">
                                <button name="send2" type="submit" class="btn btn-success" id="send2">
                                    <span class="glyphicon glyphicon-send"></span>
									<?php echo(getUebersetzung("weiter", $sprache, $link)); ?>
                                </button>
                            </form>
                        </div>
                        <div class="col-sm-2">
                            <form action="../ansichtWaehlen.php" method="post" name="adresseForm" target="_self"
                                  class="form-horizontal"
                                  id="adresseForm">
                                <input name="zimmer_id" type="hidden" id="zimmer_id" value="<?php echo($zimmer_id); ?>">
                                <input name="monat" type="hidden" id="monat" value="<?php echo($vonMonat); ?>">
                                <input name="jahr" type="hidden" id="jahr" value="<?php echo($vonJahr); ?>">
                                <input name="abbrechen" type="submit" class="btn btn-primary"
                                       id="abbrechen"
                                       value="<?php echo(getUebersetzung("Abbrechen", $sprache, $link)); ?>">
                            </form>
                        </div>
                    </div>


				<?php }
			} //ende else - datum ok
			?>
		<?php } //ende passwortprüfung
		else
		{
			echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
		}
		?>
    </div>
</div>
<?php include_once("./templates/end.php"); ?>
