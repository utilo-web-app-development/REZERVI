<?php
/**
 * Created on 19.01.2007
 *
 * @author coster
 * preise hinzufügen löschen ändern
 */

session_start();
$root = "../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
include_once($root . "/conf/rdbmsConfig.php");
include_once($root . "/include/uebersetzer.php");
include_once($root . "/include/zimmerFunctions.php");
include_once($root . "/include/unterkunftFunctions.php");
include_once($root . "/include/benutzerFunctions.php");
include_once($root . "/include/propertiesFunctions.php");
include_once($root . "/include/datumFunctions.php");

//variablen intitialisieren:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$benutzername  = getSessionWert(BENUTZERNAME);
$passwort      = getSessionWert(PASSWORT);
$sprache       = getSessionWert(SPRACHE);

$house = false;
if (isset($_POST['house']) && !empty($_POST['house']))
{
	$house = $_POST['house'];
}

if (isset($_POST['aendern']) && $_POST['aendern'] == getUebersetzung("speichern", $sprache, $link))
{
	//andern button ausgeloest
	include_once('./aendern.inc.php');
}

include_once($root . "/webinterface/templates/headerA.php");
?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php
include_once($root . "/webinterface/templates/headerB.php");
include_once($root . "/webinterface/templates/bodyA.php");

//wurde irgend eine zuweisung gelöscht?
$res = getAllRoomsWithChilds($unterkunft_id);
while ($d = mysqli_fetch_array($res))
{
	$zimmer_id = $d['Parent_ID'];
	if (
		isset($_POST['loeschen_' . $zimmer_id]) &&
		$_POST['loeschen_' . $zimmer_id] == getUebersetzung("löschen", $sprache, $link)
	)
	{
		deleteChildRooms($zimmer_id);
	}
}
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>
			<?php echo getUebersetzung("Zimmer zusammenfassen", $sprache, $link) ?>.
        </h2>
    </div>
    <div class="panel-body">
		<?php
		//passwortprüfung:
		if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
		{

			?>
            <p class="lead">
				<?php
				$text = "Falls Sie ein Haus mit mehreren Zimmern vermieten und die Zimmer des " .
					"Hauses und das Haus selbst vermieten wollen, können Sie hier die Zimmer zum Haus " .
					"festlegen. Das Haus und die Zimmer müssen vorher angelegt worden sein."
				?>
				<?php echo getUebersetzung($text, $sprache, $link) ?>
            </p>
			<?php
			if (isset($nachricht) && $nachricht != "")
			{
				?>
                <div class="alert alert-info" role="alert"
					<?php if (isset($fehler) && $fehler == false)
					{
						echo("class=\"frei\"");
					}
					else
					{
						echo("class=\"belegt\"");
					} ?>>
					<?php echo $nachricht ?>
                </div>


				<?php
			}
			?>
            <form action="./index.php" method="post" target="_self">

				<?php
				if (hasParentRooms($unterkunft_id))
				{
					?>
                    <div class="well">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">
									<?php $text = "Bestehende Zuweisungen:"; ?>
									<?php echo getUebersetzung($text, $sprache, $link) ?>
                                </label>
                            </div>
                        </div>

						<?php
						$res = getAllRoomsWithChilds($unterkunft_id);
						while ($d = mysqli_fetch_array($res))
						{
							$zimmer_id = $d['Parent_ID'];
							$ziArt     = getUebersetzungUnterkunft(getZimmerArt($unterkunft_id, $zimmer_id, $link), $sprache, $unterkunft_id, $link);
							$ziNr      = getUebersetzungUnterkunft(getZimmerNr($unterkunft_id, $zimmer_id, $link), $sprache, $unterkunft_id, $link);
							?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="control-label">
										<?php echo $ziArt . " " . $ziNr ?>
                                    </label>
                                </div>
                                <div class="col-sm-6">
									<?php
									$res2 = getChildRooms($zimmer_id);
									while ($r = mysqli_fetch_array($res2))
									{
										$ziArt = getUebersetzungUnterkunft($r["Zimmerart"], $sprache, $unterkunft_id, $link);
										$ziNr  = getUebersetzungUnterkunft($r["Zimmernr"], $sprache, $unterkunft_id, $link);
										?>
										<?php echo $ziArt . " " . $ziNr ?>
                                        <br/>
										<?php
									}
									?>
                                </div>
                                <div class="col-sm-2">
                                    <input name="loeschen_<?php echo $zimmer_id ?>" type="submit" id="aendern"
                                           class="btn btn-danger"
                                           style="text-align: right;"
                                           value="<?php echo(getUebersetzung("löschen", $sprache, $link)); ?>"/>
                                </div>
                            </div>
							<?php
						}
						?>

                    </div>

					<?php
				}
				?>
                <div class="row">
                    <hr>
                </div>
                <div class="well">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="control-label">
								<?php $text = "Neue Zuweisungen:"; ?>
								<?php echo getUebersetzung($text, $sprache, $link) ?>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <hr style=" border-top: 1px solid rgba(99, 91, 91, 0.63);">
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <label class="control-label">
								<?php echo getUebersetzung("Haus", $sprache, $link) ?>
                            </label>
                        </div>
                        <div class="col-sm-4">
                            <select name="house" onChange="submit()" class="form-control">
								<?php
								$res = getZimmer($unterkunft_id, $link);
								while ($g = mysqli_fetch_array($res))
								{
									$ziArt = getUebersetzungUnterkunft($g["Zimmerart"], $sprache, $unterkunft_id, $link);
									$ziNr  = getUebersetzungUnterkunft($g["Zimmernr"], $sprache, $unterkunft_id, $link);
									?>
                                    <option value="<?php echo $g['PK_ID'] ?>"
										<?php
										if ($house == $g['PK_ID'])
										{
											?>
                                            selected="selected"
											<?php
										}
										?>
                                    ><?php echo $ziArt . " " . $ziNr ?></option>
									<?php
								}
								?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <hr style=" border-top: 1px solid rgba(99, 91, 91, 0.63);">
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <label class="control-label">
								<?php $text = "Folgende Zimmer gehören zum ausgewählten Haus"
								?>
								<?php echo getUebersetzung($text, $sprache, $link) ?>:
                            </label>
                        </div>
                        <div class="col-sm-7">
							<?php
							$res = getZimmer($unterkunft_id, $link);
							while ($g = mysqli_fetch_array($res))
							{
								$ziArt = getUebersetzungUnterkunft($g["Zimmerart"], $sprache, $unterkunft_id, $link);
								$ziNr  = getUebersetzungUnterkunft($g["Zimmernr"], $sprache, $unterkunft_id, $link);
								if ($house == $g['PK_ID'])
								{
									continue;
								}
								?>
                                <div class="row">
                                    <div class="col-sm-6">

										<?php echo $ziArt . " " . $ziNr ?>

                                    </div>
                                    <div class="col-sm-1">
                                        <input type="checkbox"
                                               value="<?php echo $g['PK_ID'] ?>"
                                               name="zimmer[]"/>
                                    </div>
                                </div>
								<?php
							}
							?>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-offset-9 col-sm-3" style="text-align: right;">
                        <input name="aendern" type="submit" id="aendern" class="btn btn-success"
                               value="<?php echo(getUebersetzung("Speichern", $sprache, $link)); ?>"/>

                        <a class="btn btn-primary" href="../index.php">
                            <!--						<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;-->
							<?php echo(getUebersetzung("zurück", $sprache, $link)); ?></a>
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
