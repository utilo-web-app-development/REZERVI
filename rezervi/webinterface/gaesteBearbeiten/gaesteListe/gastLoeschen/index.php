<?php session_start();
$root = "../../../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
	reservierungsplan
	gast-infos anzeigen und evt. ändern:
	author: christian osterrieder utilo.eu
			
	dieser seite muss übergeben werden:
	Gast PK_ID $gast_id
	$unterkunft_id
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort      = getSessionWert(PASSWORT);
$benutzername  = getSessionWert(BENUTZERNAME);
$anrede_val    = $_POST["anrede_val"];
$vorname_val   = $_POST["vorname_val"];
$nachname_val  = $_POST["nachname_val"];
$strasse_val   = $_POST["strasse_val"];
$plz_val       = $_POST["plz_val"];
$ort_val       = $_POST["ort_val"];
$land_val      = $_POST["land_val"];
$email_val     = $_POST["email_val"];
$tel_val       = $_POST["tel_val"];
$fax_val       = $_POST["fax_val"];
$sprache_val   = $_POST["anmerkung_val"];
$anmerkung_val = $_POST["anmerkung_val"];
$gast_id       = $_POST["gast_id"];
$sprache       = getSessionWert(SPRACHE);
$index         = $_POST["index"];

//datenbank öffnen:
include_once("../../../../conf/rdbmsConfig.php");

//funktions einbinden:
include_once("../../../../include/unterkunftFunctions.php");
//uebersetzer einfuegen:
include_once("../../../../include/uebersetzer.php");
include_once("../../../../include/gastFunctions.php");
include_once("../../../../include/benutzerFunctions.php");

?>
<?php include_once("../../../templates/headerA.php"); ?>
<style type="text/css">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../../../templates/headerB.php"); ?>
<?php include_once("../../../templates/bodyA.php"); ?>
<div class="panel panel-default">

    <div class="panel-body">


		<?php
		//passwortprüfung:
		if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
		{
			?>
			<?php //prüfen ob noch reservierungen oder sowas für diesen gast vorhanden sind:
			$query = ("SELECT		 
				   PK_ID
				   FROM
				   Rezervi_Reservierung
				   WHERE				
				   FK_Gast_ID = '$gast_id'
				  ");

			$res = mysqli_query($link, $query);
			if (!$res)
				echo("die Anfrage scheitert");
			if ($d = mysqli_fetch_array($res))
			{
				// es ist noch eine offene res vorhanden!
				?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
							<?php echo(getUebersetzung("Der Gast kann nicht gelöscht werden, da Reservierungen oder offene Reservierungsanfragen für diesen Gast eingetragen sind", $sprache, $link)); ?>
                            !
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <form action="../gastInfos/index.php" method="post" name="gastInfos" target="_self">
                            <button name="gastInfos" type="submit" id="gastInfos" class="btn btn-primary">
                                <span class="glyphicon glyphicon-info-sign"></span>
								<?php echo(getUebersetzung("Reservierungs-Informationen", $sprache, $link)); ?>
                            </button>
                            <input name="anrede_val" type="hidden" id="anrede_var10"
                                   value="<?php echo($anrede_val); ?>">
                            <input name="vorname_val" type="hidden" id="vorname_var"
                                   value="<?php echo($vorname_val); ?>">
                            <input name="nachname_val" type="hidden" id="nachname_var"
                                   value="<?php echo($nachname_val); ?>">
                            <input name="strasse_val" type="hidden" id="strasse_var"
                                   value="<?php echo($strasse_val); ?>">
                            <input name="ort_val" type="hidden" id="ort_var" value="<?php echo($ort_val); ?>">
                            <input name="land_val" type="hidden" id="land_var" value="<?php echo($land_val); ?>">
                            <input name="email_val" type="hidden" id="email_var" value="<?php echo($email_val); ?>">
                            <input name="tel_val" type="hidden" id="tel_var" value="<?php echo($tel_val); ?>">
                            <input name="fax_val" type="hidden" id="anrede_var10" value="<?php echo($fax_val); ?>">
                            <input name="anmerkung_val" type="hidden" id="anrede_var10"
                                   value="<?php echo($anmerkung_val); ?>">
                            <input name="plz_val" type="hidden" id="plz_val" value="<?php echo($plz_val); ?>">
                            <input name="sprache_val" type="hidden" id="plz_val" value="<?php echo($sprache_val); ?>">
                            <input name="gast_id" type="hidden" id="gast_id" value="<?php echo($gast_id); ?>">
                            <input name="index" type="hidden" value="<?php echo($index); ?>"/>
                        </form>
                    </div>
                    <div class="col-sm-2">
                        <form action="../index.php" method="post" name="ok" target="_self" id="ok">
                            <input type="submit" name="Submit" class="btn btn-primary" id="zurueck"
                                   value="<?php echo(getUebersetzung("zurück", $sprache, $link)); ?>">
                            <input name="anrede_val" type="hidden" id="anrede_val2" value="<?php echo($anrede_val); ?>">
                            <input name="vorname_val" type="hidden" id="vorname_val2"
                                   value="<?php echo($vorname_val); ?>">
                            <input name="nachname_val" type="hidden" id="nachname_val2"
                                   value="<?php echo($nachname_val); ?>">
                            <input name="strasse_val" type="hidden" id="strasse_val2"
                                   value="<?php echo($strasse_val); ?>">
                            <input name="ort_val" type="hidden" id="ort_val2" value="<?php echo($ort_val); ?>">
                            <input name="land_val" type="hidden" id="land_val2" value="<?php echo($land_val); ?>">
                            <input name="email_val" type="hidden" id="email_val2" value="<?php echo($email_val); ?>">
                            <input name="tel_val" type="hidden" id="tel_val2" value="<?php echo($tel_val); ?>">
                            <input name="fax_val" type="hidden" id="anrede_val2" value="<?php echo($fax_val); ?>">
                            <input name="anmerkung_val" type="hidden" id="anrede_val2"
                                   value="<?php echo($anmerkung_val); ?>">
                            <input name="sprache_val" type="hidden" id="anrede_var"
                                   value="<?php echo($sprache_val); ?>">
                            <input name="plz_val" type="hidden" id="plz_val" value="<?php echo($plz_val); ?>">
                            <input name="index" type="hidden" value="<?php echo($index); ?>"/>
                        </form>
                    </div>
                </div>

			<?php }//ende if
			else
			{ //keine reservierungen mehr vorhanden, gast rausschmeissen:
				$query = "DELETE FROM
						Rezervi_Gast	
						WHERE
						PK_ID = '$gast_id'";
				$res   = mysqli_query($link, $query);
				if (!$res)
				{
					echo("die Anfrage scheitert");
				}
				else
				{

					?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-success">
								<?php echo(getUebersetzung("Der Gast wurde erfolgreich aus der Gästeliste entfernt", $sprache, $link)); ?>
                                !
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-9 col-sm-2" style="text-align: right;">
                            <form action="<?php echo $URL . "webinterface/inhalt.php"; ?>" method="post"
                                  name="hauptmenue" target="_self"
                                  id="hauptmenue">
                                <button type="submit" name="Submit3" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-home"></span>
									<?php echo(getUebersetzung("Hauptmenü", $sprache, $link)); ?>
                                </button>
                            </form>
                        </div>
                        <div class="col-sm-1">
                            <form action="../index.php" method="post" name="ok" target="_self" id="ok">
                                <input type="submit" name="Submit" class="btn btn-primary" id="zurueck"
                                       value="<?php echo(getUebersetzung("Zurück", $sprache, $link)); ?>">
                                <input name="anrede_val" type="hidden" id="anrede_val"
                                       value="<?php echo($anrede_val); ?>">
                                <input name="vorname_val" type="hidden" id="vorname_val"
                                       value="<?php echo($vorname_val); ?>">
                                <input name="nachname_val" type="hidden" id="nachname_val"
                                       value="<?php echo($nachname_val); ?>">
                                <input name="strasse_val" type="hidden" id="strasse_val"
                                       value="<?php echo($strasse_val); ?>">
                                <input name="ort_val" type="hidden" id="ort_val" value="<?php echo($ort_val); ?>">
                                <input name="land_val" type="hidden" id="land_val" value="<?php echo($land_val); ?>">
                                <input name="email_val" type="hidden" id="email_val" value="<?php echo($email_val); ?>">
                                <input name="tel_val" type="hidden" id="tel_val" value="<?php echo($tel_val); ?>">
                                <input name="fax_val" type="hidden" id="anrede_val" value="<?php echo($fax_val); ?>">
                                <input name="anmerkung_val" type="hidden" id="anrede_val"
                                       value="<?php echo($anmerkung_val); ?>">
                                <input name="sprache_val" type="hidden" id="anrede_var"
                                       value="<?php echo($sprache_val); ?>">
                                <input name="plz_val" type="hidden" id="plz_val" value="<?php echo($plz_val); ?>">
                            </form>
                        </div>
                    </div>

				<?php } //ende else
			} //ende else
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
