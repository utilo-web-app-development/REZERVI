<?php session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once("../../../include/sessionFunctions.inc.php");

/*   
	date: 5.11.05
	author: christian osterrieder utilo.eu						
*/

//datenbank öffnen:
include_once("../../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../../include/benutzerFunctions.php");
include_once("../../../include/zimmerFunctions.php");
include_once("../../../include/buchungseinschraenkung.php");
include_once("../../../include/unterkunftFunctions.php");
include_once("../../../include/einstellungenFunctions.php");
include_once("../../../include/datumFunctions.php");
include_once("../../../include/uebersetzer.php");
include_once("../../../webinterface/templates/components.php");

include_once("../../templates/auth.php");

//variablen:
$unterkunft_id   = getSessionWert(UNTERKUNFT_ID);
$passwort        = getSessionWert(PASSWORT);
$benutzername    = getSessionWert(BENUTZERNAME);
$sprache         = getSessionWert(SPRACHE);
$standardsprache = getStandardSprache($unterkunft_id, $link);

?>
<?php include_once("../../templates/headerA.php"); ?>
    <style type="text/css">
        <?php include_once("../../../templates/stylesheetsIE9.php"); ?>
    </style>
    <script language="JavaScript" type="text/javascript" src="./updateDate.js">
    </script>
<?php include_once("../../templates/headerB.php"); ?>
<?php include_once("../../templates/bodyA.php"); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>
				<?php echo(getUebersetzung("Einschränken von Buchungen innerhalb eines bestimmten Zeitraumes", $sprache, $link)); ?>
                .
            </h2>
        </div>

        <div class="panel-body">
			<?php
			//passwortprüfung:
			if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
			{
				?>

                <!-- Show message if there is -->
				<?php include_once("../../templates/message.php"); ?>
                <form class="form-inline" action="./aendern.php" method="post" name="reservierung"
                      target="_self">
                    <p class="lead"> <?php echo getUebersetzung("Zeitraum (z. B. Saison):", $sprache, $link); ?></p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>
									<?php echo getUebersetzungUnterkunft(getZimmerart_EZ($unterkunft_id, $link), $sprache, $unterkunft_id, $link); ?>
                                </th>
                                <th>
									<?php echo getUebersetzung("Tag von", $sprache, $link); ?>
                                </th>
                                <th>
									<?php echo getUebersetzung("Tag bis", $sprache, $link); ?>
                                </th>
                                <th>
									<?php echo getUebersetzung("Datum von", $sprache, $link); ?>
                                </th>
                                <th>
									<?php echo getUebersetzung("Datum bis", $sprache, $link); ?>
                                </th>
                                <th>
									<?php echo getUebersetzung("löschen/hinzufügen", $sprache, $link); ?>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
							<?php

							$res = getBuchungseinschraenkungen($unterkunft_id);
							while ($d = mysqli_fetch_array($res))
							{
								$von       = $d["Tag_von"];
								$bis       = $d["Tag_bis"];
								$datum_von = $d["Datum_von"];
								$datum_bis = $d["Datum_bis"];
								$id        = $d["PK_ID"];
								$zimmer_id = $d["FK_Zimmer_ID"];
								$zimmer    = getZimmerNr($unterkunft_id, $zimmer_id, $link);
								$zimmerart = getZimmerArt($unterkunft_id, $zimmer_id, $link);

								?>

                                <tr>

                                    <td class="label-control col-sm-1">
										<?php echo $zimmerart . " " . $zimmer ?>
                                    </td>

                                    <td class="label-control col-sm-1" style="width: 10%;">
										<?php echo $von ?>
                                    </td>


                                    <td class="label-control col-sm-1" style="width: 10%;">
										<?php echo $bis ?>
                                    </td>


                                    <td class="label-control col-sm-3">
										<?php echo $datum_von ?>
                                    </td>


                                    <td class="label-control col-sm-3">
										<?php echo $datum_bis ?>
                                    </td>


                                    <td class="label-control col-sm-2">

                                        <input type="submit" class="btn btn-danger" name="loeschen#<?php echo $id ?>"
                                               value="<?php echo getUebersetzung("Löschen", $sprache, $link); ?>"/>
                                    </td>

                                </tr>

								<?php
							}
							?>

                            <tr>
                                <td>
                                    <select name="zimmer_id" class="form-control">
										<?php
										$res = getZimmer($unterkunft_id, $link);
										while ($d = mysqli_fetch_array($res))
										{
											$zimmer_id = $d["PK_ID"];
											$zimmer    = getZimmerNr($unterkunft_id, $zimmer_id, $link);
											$zimmerart = getZimmerArt($unterkunft_id, $zimmer_id, $link);
											?>
                                            <option
                                                    value="<?php echo $zimmer_id ?>"><?php echo $zimmerart . " " . $zimmer ?></option>
											<?php
										} //ende while
										?>
                                    </select>
                                </td>


                                <td>
                                    <select name="von_wochentag" class="form-control">
										<?php
										$res = getWochentage();
										foreach ($res as $wochentag)
										{
											?>
                                            <option value="<?php echo $wochentag ?>"><?php echo $wochentag ?></option>
											<?php
										} //ende while
										?>
                                    </select>
                                </td>


                                <td>
                                    <select name="bis_wochentag" class="form-control">
										<?php
										$res = getWochentage();
										foreach ($res as $wochentag)
										{
											?>
                                            <option value="<?php echo $wochentag ?>"><?php echo $wochentag ?></option>
											<?php
										} //ende while
										?>
                                    </select>
                                </td>


                                <td>
                                    <div class="row">
                                        <select name="vonTag" class="col-sm-4 form-control" id="select">
											<?php for ($i = 1; $i <= 31; $i++)
											{ ?>
                                                <option
                                                        value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) echo(" selected"); ?>><?php echo($i); ?></option>
											<?php } ?>
                                        </select>
                                        <!--  heutiges monat selectiert anzeigen: -->
                                        <select name="vonMonat" class="col-sm-4 form-control" id="vonMonat"
                                                onChange="chkDays(0)">
                                            <option
                                                    value="1"<?php if (getTodayMonth() == "Januar") echo " selected"; ?>><?php echo(getUebersetzung("Januar", $sprache, $link)); ?></option>
                                            <option
                                                    value="2"<?php if (getTodayMonth() == "Februar") echo " selected"; ?>><?php echo(getUebersetzung("Februar", $sprache, $link)); ?></option>
                                            <option
                                                    value="3"<?php if (getTodayMonth() == "März") echo " selected"; ?>><?php echo(getUebersetzung("März", $sprache, $link)); ?></option>
                                            <option
                                                    value="4"<?php if (getTodayMonth() == "April") echo " selected"; ?>><?php echo(getUebersetzung("April", $sprache, $link)); ?></option>
                                            <option
                                                    value="5"<?php if (getTodayMonth() == "Mai") echo " selected"; ?>><?php echo(getUebersetzung("Mai", $sprache, $link)); ?></option>
                                            <option
                                                    value="6"<?php if (getTodayMonth() == "Juni") echo " selected"; ?>><?php echo(getUebersetzung("Juni", $sprache, $link)); ?></option>
                                            <option
                                                    value="7"<?php if (getTodayMonth() == "Juli") echo " selected"; ?>><?php echo(getUebersetzung("Juli", $sprache, $link)); ?></option>
                                            <option
                                                    value="8"<?php if (getTodayMonth() == "August") echo " selected"; ?>><?php echo(getUebersetzung("August", $sprache, $link)); ?></option>
                                            <option
                                                    value="9"<?php if (getTodayMonth() == "September") echo " selected"; ?>><?php echo(getUebersetzung("September", $sprache, $link)); ?></option>
                                            <option
                                                    value="10"<?php if (getTodayMonth() == "Oktober") echo " selected"; ?>><?php echo(getUebersetzung("Oktober", $sprache, $link)); ?></option>
                                            <option
                                                    value="11"<?php if (getTodayMonth() == "November") echo " selected"; ?>><?php echo(getUebersetzung("November", $sprache, $link)); ?></option>
                                            <option
                                                    value="12"<?php if (getTodayMonth() == "Dezember") echo " selected"; ?>><?php echo(getUebersetzung("Dezember", $sprache, $link)); ?></option>
                                        </select>
                                        <!--  heutiges jahr selectiert anzeigen: -->
                                        <select name="vonJahr" class="col-sm-4 form-control" id="vonJahr"
                                                onChange="chkDays(0)">
											<?php
											for ($l = getTodayYear(); $l < (getTodayYear() + 4); $l++)
											{ ?>
                                                <option
                                                        value="<?php echo $l ?>"<?php if ($l == getTodayYear()) echo(" selected"); ?>><?php echo $l ?></option>
											<?php } ?>
                                        </select>
                                    </div>

                                </td>


                                <td>
                                    <select class="col-sm-4 form-control" name="bisTag" id="select4">
                                        <!--  heutigen tag selectiert anzeigen: -->
										<?php $anzahlTage = getNumberOfDays(parseMonthNumber($monat), $jahr);
										for ($i = 1; $i <= $anzahlTage; $i++)
										{ ?>
                                            <option
                                                    value="<?php echo($i); ?>"<?php if (getTodayDay() == $i) echo " selected"; ?>><?php echo($i); ?></option>
										<?php } ?>
                                    </select>
                                    <!--  heutiges monat selectiert anzeigen: -->
                                    <select class="col-sm-4 form-control" name="bisMonat" id="bisMonat"
                                            onChange="chkDays(1)">
                                        <option
                                                value="1"<?php if (getTodayMonth() == "Januar") echo " selected"; ?>><?php echo(getUebersetzung("Januar", $sprache, $link)); ?></option>
                                        <option
                                                value="2"<?php if (getTodayMonth() == "Februar") echo " selected"; ?>><?php echo(getUebersetzung("Februar", $sprache, $link)); ?></option>
                                        <option
                                                value="3"<?php if (getTodayMonth() == "März") echo " selected"; ?>><?php echo(getUebersetzung("März", $sprache, $link)); ?></option>
                                        <option
                                                value="4"<?php if (getTodayMonth() == "April") echo " selected"; ?>><?php echo(getUebersetzung("April", $sprache, $link)); ?></option>
                                        <option
                                                value="5"<?php if (getTodayMonth() == "Mai") echo " selected"; ?>><?php echo(getUebersetzung("Mai", $sprache, $link)); ?></option>
                                        <option
                                                value="6"<?php if (getTodayMonth() == "Juni") echo " selected"; ?>><?php echo(getUebersetzung("Juni", $sprache, $link)); ?></option>
                                        <option
                                                value="7"<?php if (getTodayMonth() == "Juli") echo " selected"; ?>><?php echo(getUebersetzung("Juli", $sprache, $link)); ?></option>
                                        <option
                                                value="8"<?php if (getTodayMonth() == "August") echo " selected"; ?>><?php echo(getUebersetzung("August", $sprache, $link)); ?></option>
                                        <option
                                                value="9"<?php if (getTodayMonth() == "September") echo " selected"; ?>><?php echo(getUebersetzung("September", $sprache, $link)); ?></option>
                                        <option
                                                value="10"<?php if (getTodayMonth() == "Oktober") echo " selected"; ?>><?php echo(getUebersetzung("Oktober", $sprache, $link)); ?></option>
                                        <option
                                                value="11"<?php if (getTodayMonth() == "November") echo " selected"; ?>><?php echo(getUebersetzung("November", $sprache, $link)); ?></option>
                                        <option
                                                value="12"<?php if (getTodayMonth() == "Dezember") echo " selected"; ?>><?php echo(getUebersetzung("Dezember", $sprache, $link)); ?></option>
                                    </select>
                                    <!--  heutiges jahr selectiert anzeigen: -->
                                    <select class="col-sm-4 form-control" name="bisJahr"id="bisJahr"
                                            onChange="chkDays(1)">
										<?php
										for ($l = getTodayYear() - 4; $l < (getTodayYear() + 4); $l++)
										{ ?>
                                            <option value="<?php echo($l); ?>"<?php if ($l == getTodayYear()) echo(" selected"); ?>>
												<?php echo($l); ?>
                                            </option>
										<?php } ?>
                                    </select>
                                </td>

                                <td>
                                    <input type="submit" name="add" class="btn btn-success"
                                           value="<?php echo getUebersetzung("Hinzufügen", $sprache, $link); ?>"/>

                                </td>

                            </tr>

                            </tbody>
                        </table>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-12" style="text-align: right;">
                        <a href="../index.php" class="btn btn-default">
                            <?php echo(getUebersetzung("Zurück", $sprache, $link)); ?>
                        </a>
                    </div>
                </div>
				<?php
			} //ende if passwortprüfung
			else
			{
				echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!", $sprache, $link));
			}
			?>
<?php include_once("../../templates/end.php"); ?>