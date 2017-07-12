<?php session_start();
$root = "..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");

//einstiegsseite wenn nicht direkt ein Zimmer ausgewaehlt wurde
//dem benutzer wird vorab die Möglichkeit geboten ein Zimmer auszuwählen.
//uebergebene variable ist die sprache und unterkunft_id

//variablen initialisieren:
$keineSprache = $_POST["keineSprache"];
//wenn keineSprache = true ist dann wurde die suche aus left.php aufgerufen
//also daten aus der session holen:
if ($keineSprache == true)
{
	$sprache       = getSessionWert(SPRACHE);
	$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
} //sonst aus get holen:
else
{
	$unterkunft_id = $_GET["unterkunft_id"];
	$sprache       = $_GET["sprache"];
}

//datenbank öffnen:
include_once("../conf/rdbmsConfig.php");
//unterkunft-funktionen
include_once("../include/unterkunftFunctions.php");
include_once("../include/zimmerFunctions.php");
include_once("../include/datumFunctions.php");
//spezielle funktionen fuer suche:
include_once("./sucheFunctions.php");
include_once("../include/propertiesFunctions.php");
include_once("../include/einstellungenFunctions.php");
//uebersetzer einfügen:
include_once("../include/uebersetzer.php");
include_once($root . "/include/buchungseinschraenkung.php");

//testdaten falls keine unterkunft uebergeben wurde:
if (!isset($unterkunft_id) || $unterkunft_id == "")
{
	$unterkunft_id = "1";
}

//wenn keine sprache Übergeben, deutsch nehmen:	
if (!isset($sprache) || $sprache == "")
{
	$sprache = "de";
}

//sprache und unterkunft in session speichern:
setSessionWert(SPRACHE, $sprache);
setSessionWert(UNTERKUNFT_ID, $unterkunft_id);

$startdatumDP = getTodayDay() . "/" . parseMonthNumber(getTodayMonth()) . "/" . getTodayYear();
$enddatumDP   = $startdatumDP;
if (isset($_POST['datumVon']) && !empty($_POST['datumVon']))
{
	$startdatumDP = $_POST['datumVon'];
}
if (isset($_POST['datumBis']) && !empty($_POST['datumBis']))
{
	$enddatumDP = $_POST['datumBis'];
}

//headerA einfügen:
include_once("../templates/headerA.php");
//stylesheets einfgen:
?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<script type="text/javascript" src="<?php echo($root); ?>/templates/calendarDateInput.php">
    /***********************************************
     * Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
     * Script featured on and available at http://www.dynamicdrive.com
     * Keep this notice intact for use.
     ***********************************************/
</script>
<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      crossorigin="anonymous">
<!-- Bootstrap ende -->
<?php
//headerB einfügen:
include_once("../templates/headerB.php");
?>
<div class="container" style="margin-top:70px;">


    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>
				<?php echo(getUebersetzung(getUnterkunftName($unterkunft_id, $link), $sprache, $link)); ?>
            </h2>
        </div>
        <div class="panel-body">

            <?php include_once("./subtemplates/showMessages.php");?>
            <!-- Flaggen Sprachen -->

			<?php
			if (isset($keineSprache) && ($keineSprache == "true"))
			{
				//es soll die sprachauswahl nicht angezeigt werden, wenn
				//keineSprache == True uebergeben wird
			}
			else
			{
				?>
                <div class="row">
                    <div class="col-sm-12" style="text-align: right;">
                        <ul class="list-inline">
							<?php
							//laender ausgeben die in den einstellungen definiert wurden:
							if (isEnglishShown($unterkunft_id, $link) && $sprache != "en")
							{
								?>
                                <li class="list-inline">

                                    <div align="left">
                                        <a style="text-decoration-line: none;" href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=en"
                                           target="_self" class="standardSchrift">
                                            <img src="../fahneEN.gif" width="25" height="16">
                                            &nbsp&nbsp;English
                                        </a>
                                    </div>

                                </li>
								<?php
							}
							if (isFrenchShown($unterkunft_id, $link) && $sprache != "fr")
							{
								?>
                                <li class="list-inline">

                                    <div align="left">
                                        <a style="text-decoration-line: none;" href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=fr"
                                           target="_self" class="standardSchrift">
                                            <img src="../fahneFR.gif" width="25" height="16">&nbsp;&nbsp;Francais
                                        </a>
                                    </div>

                                </li>
								<?php
							}
							if (isGermanShown($unterkunft_id, $link) && $sprache != "de")
							{
								?>
                                <li class="list-inline">

                                    <div align="left">
                                        <a style="text-decoration-line: none;" href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=de"
                                           target="_self" class="standardSchrift">
                                            <img src="../fahneDE.gif" width="25" height="16">
                                            &nbsp;&nbsp;Deutsch
                                        </a>
                                    </div>

                                </li>
								<?php
							}
							if (isItalianShown($unterkunft_id, $link) && $sprache != "it")
							{
								?>
                                <li class="list-inline">

                                    <div align="left">
                                        <a style="text-decoration-line: none;"
                                                href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=it"
                                                target="_self" class="standardSchrift">
                                            <img src="../fahneIT.gif" width="25" height="16">
                                            &nbsp;&nbsp;Italia
                                        </a>
                                    </div>
                                    <
                                </li>
								<?php
							}
							if (isNetherlandsShown($unterkunft_id, $link) && $sprache != "nl")
							{
								?>
                                <li class="list-inline">
                                    <div align="left">
                                        <a style="text-decoration-line: none;" href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=nl"
                                           target="_self" class="standardSchrift">
                                            <img src="../fahneNL.gif" width="25" height="16">
                                            &nbsp;&nbsp;Nederlands
                                        </a>
                                    </div>

                                </li>
								<?php
							}
							if (isEspaniaShown($unterkunft_id, $link) && $sprache != "sp")
							{
								?>
                                <li class="list-inline">

                                    <div align="left">
                                        <a style="text-decoration-line: none;" href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=sp"
                                           target="_self" class="standardSchrift">
                                            <img src="../fahneSP.gif" width="25" height="16">
                                            &nbsp;&nbsp;España
                                        </a>
                                    </div>

                                </li>
								<?php
							}
							if (isEstoniaShown($unterkunft_id, $link) && $sprache != "es")
							{
								?>
                                <li>

                                    <div align="left">
                                        <a style="text-decoration-line: none;" href="./index.php?unterkunft_id=<?php echo($unterkunft_id); ?>&sprache=es"
                                           target="_self" class="standardSchrift">
                                            <img src="../fahneES.gif" width="25" height="16">
                                            &nbsp;&nbsp;Estonia
                                        </a>
                                    </div>

                                </li>
								<?php
							} //ende estonia
							?>
                        </ul>
                    </div>
                </div>

				<?php
			} //ende sprache soll angezeigt werden
			?>


            <p class="lead">
				<?php
				//$zimmerart = getUebersetzungUnterkunft(getZimmerArten($unterkunft_id,$link),$sprache,$unterkunft_id,$link);
				$zimmerart_mz = getUebersetzungUnterkunft(getZimmerart_MZ($unterkunft_id, $link), $sprache, $unterkunft_id, $link);
				echo(getUebersetzung("Sie können den Belegungsplan betrachten, indem Sie eine Auswahl treffen und auf [Belegungsplan anzeigen] klicken...", $sprache, $link));
				?>
            </p>


            <form action="../start.php" method="post" name="form1" class="form-horizontal"
				<?php
				if (isset($keineSprache) && ($keineSprache == "true"))
				{ ?>
                    target="_parent"
				<?php }
				else
				{ ?>
                    target="_self"
				<?php } ?>
            >
                <input name="keineSprache" type="hidden" value="true">
                <input name="monat" type="hidden" value="<?php echo(parseMonthNumber(getTodayMonth())); ?>">
                <input name="jahr" type="hidden" value="<?php echo(getTodayYear()); ?>">

                <div class="form-group">
                    <div class="col-sm-2">
                        <label>
                            <!--Belegungsplan-->
							<?php echo(getUebersetzung("Belegungsplan für:", $sprache, $link)); ?>
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <!-- Select Box  -->

						<?php

						//es sollte die liste auf keinen fall groesser als 10 werden:
						$zimmeranzahl = getAnzahlVorhandeneZimmer($unterkunft_id, $link);
						if ($zimmeranzahl > 10) $zimmeranzahl = 10; ?>
                        <select class="form-control" name="zimmer_id" size="<?php echo($zimmeranzahl); ?>">
          <?php
						$res     = getZimmer($unterkunft_id, $link);
						$zaehler = 0;
						while ($d = mysqli_fetch_array($res))
						{

						$zaehler++;
						$temp              = $d["Zimmerart"];
						$temp2             = $d["Zimmernr"];
						$temp3             = getUebersetzungUnterkunft($temp, $sprache, $unterkunft_id, $link);
						$temp4             = getUebersetzungUnterkunft($temp2, $sprache, $unterkunft_id, $link);
						$zimmerbezeichnung = ($temp3) . (" ") . ($temp4);
						$von               = "";
						$bis               = "";
						$hallo             = getZimmerBuchungseinschraenkung($d["PK_ID"]);
						while ($ergebnis = mysqli_fetch_array($hallo))
						{
						$von      = $ergebnis["Tag_von"];
						$bis      = $ergebnis["Tag_bis"];
						$monatVon = $ergebnis["Datum_von"];
						$monatBis = $ergebnis["Datum_bis"];

						$uebersetzung1 = getUebersetzung("Im Zeitraum von", $sprache, $link);
						$uebersetzung2 = getUebersetzung("bis", $sprache, $link);
						$uebersetzung3 = getUebersetzung("buchbar von", $sprache, $link);

						?>

		                <option value="<?php echo($d['PK_ID']); ?>"
                    <?php if ($zaehler == 1) echo("selected"); ?>>
                    <?php echo($zimmerbezeichnung); ?>
                         <?php echo(" (" . $uebersetzung1 . " " . $monatVon . " " . $uebersetzung2 . " " . $monatBis . " " . $uebersetzung3 . " " . $von . " " . $uebersetzung2 . " " . $bis . ".)"); ?>
                        </option>
					<?php
					}//end while-loop
					if ($von == "" && $bis == "")
					{
						?>
                        <option value="<?php echo($d["PK_ID"]); ?>"<?php if ($zaehler == 1) echo("selected"); ?>><?php echo($zimmerbezeichnung); ?></option>
					<?php }//end if-loop
					}//end while-loop
					?>
                        </select>
                    </div>
                </div>
                <!-- Button -->
                <div class="form-group">
                    <div class="col-sm-offset-9 col-sm-3" style="text-align: right;">
                        <input type="submit" name="Submit" class="btn btn-default"
                               value="<?php echo(getUebersetzung("Belegungsplan anzeigen", $sprache, $link)); ?>">
                    </div>
                </div>
                <!-- Ende Button -->

            </form>
            <div class="row">
                <div class="col-sm-12">
                    <span>

				<?php
				echo(getUebersetzung("...oder eine automatische Suche durchführen, indem sie unterstehende Daten angeben und [Suche starten] klicken.", $sprache, $link));
				?>

                    </span>
                </div>
            </div>

            <form action="../suche/sucheDurchfuehren.php" class="form-horizontal" method="post" name="suchen"
                  target="_self" id="suchen">

                <div class="form-group">
                    <div class="col-sm-12">
						<?php echo(getUebersetzung("Freie", $sprache, $link) . " ");
						echo($zimmerart_mz);
						echo(" " . getUebersetzung("suchen", $sprache, $link));
						?>
                    </div>
                </div>
                <div class="form-group">
                    <!--<div class="col-sm-1">
			            <label>
                            <?php /*echo(getUebersetzung("von", $sprache, $link)); */ ?>:
                        </label>
                    </div>-->
                    <div class="col-sm-10">
                        <div class="input-daterange input-group" id="datepicker">
                            <span class="input-group-addon"><?php echo(getUebersetzung("von", $sprache, $link)); ?></span>
                            <input type="text" class="input-sm form-control" id="datumVon" name="datumVon"  />
                            <span class="input-group-addon"><?php echo(getUebersetzung("bis", $sprache, $link)); ?></span>
                            <input type="text" class="input-sm form-control" id="datumBis" name="datumBis"  />
                        </div>
                        <script>
                            $('#datepicker').datepicker({
                                language: "<?php echo $sprache?>",
                                weekStart: 1,
                                format:"dd/mm/yyyy",
                                autoclose:true
                            }).on('change', function(e) {

                            });
                            $('#datumVon').val("<?php echo($startdatumDP); ?>");
                            $('#datumBis').val("<?php echo($enddatumDP); ?>");
                            // DateInput('datumVon', true, 'DD/MM/YYYY', '<?php //echo($startdatumDP); ?>');
                        </script>
                    </div>
                </div>
                <!--<div class="form-group">
                    <div class="col-sm-1">
                        <label>
	                        <?php /*echo(getUebersetzung("bis", $sprache, $link)); */ ?>:
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <script>DateInput('datumBis', true, 'DD/MM/YYYY', '<?php /*echo($enddatumDP); */ ?>')</script>
                    </div>
                </div>-->


				<?php
				//wenn die anzahl der zimmer mehr als 1 ist, nur dann anzeigen:
				if ($zimmeranzahl > 1)
				{
					if (hasParentRooms($unterkunft_id) && getPropertyValue(SEARCH_SHOW_PARENT_ROOM, $unterkunft_id, $link) == "true")
					{
						$parentsRes = getParentRooms();
						while ($p = mysqli_fetch_array($parentsRes))
						{
							$temp              = $p["Zimmerart"];
							$temp2             = $p["Zimmernr"];
							$temp3             = getUebersetzungUnterkunft($temp, $sprache, $unterkunft_id, $link);
							$temp4             = getUebersetzungUnterkunft($temp2, $sprache, $unterkunft_id, $link);
							$zimmerbezeichnung = ($temp3) . ("&nbsp;") . ($temp4);
							?>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label>
										<?php echo $zimmerbezeichnung ?>
                                    </label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="checkbox" name="parent_room_<?php echo $p["PK_ID"] ?>" value="true"
										<?php
										if (isset($_POST['zimmerIdsParents']) && !empty($_POST['zimmerIdsParents']))
										{
											$parArr = explode(",", $_POST['zimmerIdsParents']);
											foreach ($parArr as $paItem)
											{
												if ($paItem == $p["PK_ID"])
												{
													?>
                                                    checked="checked"
													<?php
												}
											}
										}
										?>/>
                                </div>
                            </div>
							<?php
						} //end while parents
					} //end if parents
					?>
                    <!-- Anzahl Zimmer -->
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label>
								<?php echo(getUebersetzung("Anzahl der ", $sprache, $link) . getUebersetzungUnterkunft(getZimmerart_MZ($unterkunft_id, $link), $sprache, $unterkunft_id, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="anzahlZimmer">
								<?php
								$anz_zi = getAnzahlVorhandeneZimmer($unterkunft_id, $link);
								//without parent rooms (eg. houses)
								$anz_zi = $anz_zi - countParentRooms($unterkunft_id);
								for ($i = 1; $i <= $anz_zi; $i++)
								{
									?>
                                    <option value="<?php echo($i); ?>" <?php
									if ($_POST['anzahlZimmer'] && !empty($_POST['anzahlZimmer']) && $_POST['anzahlZimmer'] == $i)
									{
										?>
                                        selected="selected"
										<?php
									}
									?>><?php echo($i); ?></option>
									<?php
								}
								?>
                            </select>
                        </div>
                    </div>
					<?php
				}
				else
				{
					?>
                    <input name="anzahlZimmer" type="hidden" value="1">
					<?php
				}
				?>
                <!-- Ende Anzahl Zimmer -->
				<?php
				$erwachseneAnzahl = getAnzahlErwachsene($unterkunft_id, $link);
				if ($erwachseneAnzahl > 0)
				{
					?>
                    <!-- Anzahl Erwachsene -->
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label>
								<?php echo(getUebersetzung("Anzahl Erwachsene ", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="anzahlErwachsene">
								<?php
								for ($i = 1; $i <= $erwachseneAnzahl; $i++)
								{
									?>
                                    <option value="<?php echo($i); ?>" <?php
									if (isset($_POST['anzahlErwachsene']) && !empty($_POST['anzahlErwachsene']) && $_POST['anzahlErwachsene'] == $i)
									{
										?>
                                        selected="selected"
										<?php
									}
									else if ((!isset($_POST['anzahlErwachsene']) || empty($_POST['anzahlErwachsene'])) && $i == 2)
									{
										?>
                                        selected="selected"
										<?php
									}
									?>><?php echo($i); ?></option>
									<?php
								}
								?>
                            </select>
                        </div>
                    </div>

					<?php
				}
				else
				{
					?>

                    <input name="anzahlErwachsene" type="hidden" value="-1">
					<?php
				}
				?>

                <!-- Ende Anzahl Erwachsene -->
				<?php
				//Check which opportunities were chosen in the webinterface
				//if(getInformationKinder($unterkunft_id,$link)=='true')

				if (getPropertyValue(KINDER_SUCHE, $unterkunft_id, $link) == "true")
				{
					$kinderAnzahl = getAnzahlKinder($unterkunft_id, $link);

					if ($kinderAnzahl > 0)
					{
						?>

                        <!-- Anzahl Kinder -->
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label>
									<?php echo(getUebersetzung("Anzahl Kinder unter", $sprache, $link)); ?>

									<?php echo(getKindesalter($unterkunft_id, $link)); ?>

									<?php echo(getUebersetzung("Jahren", $sprache, $link)); ?>
                                </label>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="anzahlKinder">
									<?php
									for ($i = 0; $i <= $kinderAnzahl; $i++)
									{
										?>
                                        <option value="<?php echo($i); ?>" <?php
										if (isset($_POST['anzahlKinder']) && !empty($_POST['anzahlKinder']) && $_POST['anzahlKinder'] == $i)
										{
											?>
                                            selected="selected"
											<?php
										}
										else if ((!isset($_POST['anzahlKinder']) || empty($_POST['anzahlKinder'])) && $i == 0)
										{
											?>
                                            selected="selected"
											<?php
										}
										?>><?php echo($i); ?></option>
										<?php
									}
									?>
                                </select>
                            </div>
                        </div>

						<?php
					}
					else
					{
						?>
                        <input name="anzahlKinder" type="hidden" value="-1">
						<?php
					}
					?>
                    <!-- Ende Anzahl Kinder -->
					<?php
					//echo("<td><h3>getInformationKinder() ist 'true'</h3></td>");
				}//end if-loop Kinder

				//the option "show children" is deactivated by the user
				else
				{
				}

				//Check which opportunities were chosen in the webinterface
				//function getInformationKinder() defined in sucheFunctions.php
				//if(getInformationHaustiere($unterkunft_id,$link)=='true')
				if (getPropertyValue(HAUSTIERE_ALLOWED, $unterkunft_id, $link) == "true")
				{
					?>


                    <!-- Haustiere -->
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label>
								<?php echo(getUebersetzung("Haustiere", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-2">
                            <input name="haustiere" type="checkbox" value="true">
                        </div>
                    </div>

					<?php
					//echo("<td><h3>getInformationHaustiere() ist 'true'</h3></td>");
				}//end if-loop Haustiere

				//the option "show haustiere" is deactivated by the user
				else
				{
					?>
                    <input name="haustiere" type="hidden" value="-1">
					<?php
				}
				?>
                <!-- Ende Haustiere -->

                <!-- Button Suche starten -->
                <div class="form-group">
                    <div class="col-sm-12" style="text-align: right;">
                        <input name="sucheStarten" type="submit" class="btn btn-default" id="sucheStarten"
                               value="<?php echo(getUebersetzung("Suche starten...", $sprache, $link)); ?>">
                    </div>
                </div>

                <!-- Ende Button -->

            </form>

        </div>
    </div>
</div>
</body>
</html>