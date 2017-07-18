<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define('_JEXEC', 1);
include_once($root . "/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung der reservierung für den benutzer
			author: christian osterrieder utilo.eu						
			
			dieser seite muss übergeben werden:
			Benutzer PK_ID $benutzer_id
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort      = getSessionWert(PASSWORT);
$benutzername  = getSessionWert(BENUTZERNAME);
if (isset($_POST["hintergrund"]))
{
	$hintergrund = $_POST["hintergrund"];
}
else
{
	$hintergrund = "0";
}
if (isset($_POST["font_family"]))
{
	$font_family = $_POST["font_family"];
}
else
{
	$font_family = "0";
}
if (isset($_POST["font_size"]))
{
	$font_size = $_POST["font_size"];
}
else
{
	$font_size = "0";
}
if (isset($_POST["font_style"]))
{
	$font_style = $_POST["font_style"];
}
else
{
	$font_style = "0";
}
if (isset($_POST["font_weight"]))
{
	$font_weight = $_POST["font_weight"];
}
else
{
	$font_weight = "0";
}
if (isset($_POST["text_align"]))
{
	$text_align = $_POST["text_align"];
}
else
{
	$text_align = "0";
}
if (isset($_POST["color"]))
{
	$color = $_POST["color"];
}
else
{
	$color = "0";
}
if (isset($_POST["border"]))
{
	$border = $_POST["border"];
}
else
{
	$border = "0";
}
if (isset($_POST["border_color"]))
{
	$border_color = $_POST["border_color"];
}
else
{
	$border_color = "0";
}
if (isset($_POST["background_color"]))
{
	$background_color = $_POST["background_color"];
}
else
{
	$background_color = "0";
}
if (isset($_POST["height"]))
{
	$height = $_POST["height"];
}
else
{
	$height = "0";
}
if (isset($_POST["width"]))
{
	$width = $_POST["width"];
}
else
{
	$width = "0";
}
$stylesheet = $_POST["stylesheet"];
$sprache    = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");
include_once("./stylesHelper.php");

include_once("../templates/auth.php");

?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css" xmlns="http://www.w3.org/1999/html">
    <?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<link href="<?php echo($root) ?>/libs/bootstrap-colorPicker/css/bootstrap-colorpicker.css" rel="stylesheet">
<script src="<?php echo($root) ?>/libs/bootstrap-colorPicker/js/bootstrap-colorpicker.js"></script>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>

<?php
//stylesheets für farben erzeugen:
echo("<style type=\"text/css\"> \n");
echo("<!-- \n");
$hex = array("00", "33", "66", "99", "CC", "FF");
for ($r = 0; $r < count($hex); $r++)
{ //the red colors loop
	for ($g = 0; $g < count($hex); $g++)
	{ //the green colors loop
		for ($b = 0; $b < count($hex); $b++)
		{ //iterate through the six blue colors
			$col = $hex[$r] . $hex[$g] . $hex[$b];
			//At this point we decide what font color to use
			if ($hex[$r] <= "99" && $hex[$g] <= "99" && $hex[$b] <= "99")
			{
				echo((".x") . ($col) . (" { \n background-color: ") . ("#") . ($col) . ("; \n color: #FFFFFF; \n } \n"));
			}
			else
			{
				echo((".x") . ($col) . (" { \n background-color: ") . ("#") . ($col) . ("; \n color: #000000; \n } \n"));
			}
		} //End of b-blue innermost loop
	} //End of g-green loop
} //End of r-red outermost loop
/*
unnamed1 {
   color: #0033CC;
 }
*/
echo("--> \n");
echo("</style> \n");

//ueberschrift erzeugen:
$designFuer = "";
if ($stylesheet == "ueberschrift")
{
	$designFuer = "Überschrift";
	$auslesen   = "ueberschrift";
}
else if ($stylesheet == "standardSchrift")
{
	$designFuer = "Standard-Schrift";
	$auslesen   = "standardSchrift";
}
else if ($stylesheet == "hintergrund")
{
	$designFuer = "Hintergrund";
	$auslesen   = "backgroundColor";
}
else if ($stylesheet == "markierteSchrift")
{
	$designFuer = "makierte Schrift";
	$auslesen   = "standardSchriftBold";
}
else if ($stylesheet == "buttonA")
{
	$designFuer = "Button";
	$auslesen   = "button200pxA";
}
else if ($stylesheet == "buttonB")
{
	$designFuer = "Rollover-Button";
	$auslesen   = "button200pxB";
}
else if ($stylesheet == "tabelle")
{
	$designFuer = "Tabelle";
	$auslesen   = "tableStandard";
}
else if ($stylesheet == "tabelleColor")
{
	$designFuer = "färbige Tabelle";
	$auslesen   = "tableColor";
}
else if ($stylesheet == "belegt")
{
	$designFuer = "belegt";
	$auslesen   = "belegt";
}
else if ($stylesheet == "frei")
{
	$designFuer = "frei";
	$auslesen   = "frei";
}
else if ($stylesheet == "samstagFrei")
{
	$designFuer = "freie Samstage";
	$auslesen   = "samstagFrei";
}
else if ($stylesheet == "reserviert")
{
	$designFuer = "reserviert";
	$auslesen   = "reserviert";
}
else if ($stylesheet == "samstagReserviert")
{
	$designFuer = "reservierte Samstage";
	$auslesen   = "samstagReserviert";
}
else if ($stylesheet == "samstagBelegt")
{
	$designFuer = "belegte Samstage";
	$auslesen   = "samstagBelegt";
}
else if ($stylesheet == "samstagReserviert")
{
	$designFuer = "reservierte Samstage";
	$auslesen   = "samstagReserviert";
}
//uebersetzen:
$designFuer = getUebersetzung($designFuer, $sprache, $link);

//vorherigen style aus datenbank auslesen:
$query = ("SELECT " . ($auslesen) . "  
					FROM
					Rezervi_CSS
					WHERE
					FK_Unterkunft_ID = '$unterkunft_id'
					");

$res = mysqli_query($link, $query);
if (!$res)
	echo("die Anfrage $query scheitert");

$d     = mysqli_fetch_array($res);
$style = $d[$auslesen];
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2><?php echo(getUebersetzung("Design für", $sprache, $link)); ?> "<?php echo($designFuer); ?>"
			<?php echo(getUebersetzung("bearbeiten", $sprache, $link)); ?></h2>
    </div>
    <div class="panel-body">
	    <?php include_once("../templates/message.php"); ?>
		<?php
		//passwortprüfung:
		if (checkPass($benutzername, $passwort, $unterkunft_id, $link))
		{ ?>

            <form action="styleAendern.php" method="post" name="styles" target="_self" id="styles">
                <input name="stylesheet" type="hidden" value="<?php echo($stylesheet); ?>">
				<?php if ($font_family == "1")
				{
					$standard = getFontFamily($style); ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">
								<?php echo(getUebersetzung("Schriftart", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <select name="font_family" class="form-control">
                                <option
                                        value="Arial, Helvetica, sans-serif" <?php if ($standard == "Arial, Helvetica, sans-serif") echo(" selected"); ?>>
                                    Arial
                                </option>
                                <option
                                        value="Times New Roman, Times, serif" <?php if ($standard == "Times New Roman, Times, serif") echo(" selected"); ?>>
                                    Times New Roman
                                </option>
                                <option
                                        value="Courier New, Courier, mono" <?php if ($standard == "Courier New, Courier, mono") echo(" selected"); ?>>
                                    Courier
                                </option>
                                <option
                                        value="Georgia, Times New Roman, Times, serif" <?php if ($standard == "Georgia, Times New Roman, Times, serif") echo(" selected"); ?>>
                                    Georgia
                                </option>
                                <option
                                        value="Verdana, Arial, Helvetica, sans-serif" <?php if ($standard == "Verdana, Arial, Helvetica, sans-serif") echo(" selected"); ?>>
                                    Verdana
                                </option>
                                <option
                                        value="Geneva, Arial, Helvetica, sans-serif" <?php if ($standard == "Geneva, Arial, Helvetica, sans-serif") echo(" selected"); ?>>
                                    Geneva
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-offset-4 col-sm-3">
                            <div class="alert alert-info" style="width: auto;">
                                <label class="control-label">
									<?php echo(getUebersetzung("vorheriger Wert", $sprache, $link)); ?>:
                                </label>
								<?php
								if ($standard == "Arial, Helvetica, sans-serif") echo("Arial");
								else if ($standard == "Times New Roman, Times, serif") echo("Times New Roman");
								else if ($standard == "Courier New, Courier, mono") echo("Courier");
								else if ($standard == "Georgia, Times New Roman, Times, serif") echo("Georgia");
								else if ($standard == "Verdana, Arial, Helvetica, sans-serif") echo("Verdana");
								else if ($standard == "Geneva, Arial, Helvetica, sans-serif") echo("Geneva");
								?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
				<?php } ?>
				<?php if ($font_size == "1")
				{ ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">
								<?php echo(getUebersetzung("Schriftgrösse", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <select name="font_size" class="form-control">
								<?php for ($i = 4; $i <= 30; $i++)
								{ ?>
                                    <option
                                            value="<?php echo(($i) . ("px")); ?>" <?php if (($i) . ("px") == getFontSize($style)) echo(" selected"); ?>><?php echo(($i) . (" px")); ?></option>
								<?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-offset-4 col-sm-3">
                            <div class="alert alert-info" style="width: auto;">
                                <label class="control-label">
									<?php echo(getUebersetzung("vorheriger Wert", $sprache, $link)); ?>:
                                </label>
								<?php echo(getFontSize($style)); ?>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <hr>
                    </div>
				<?php } ?>
				<?php if ($font_style == "1")
				{ ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">
								<?php echo(getUebersetzung("Schriftstil", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <select name="font_style" class="form-control">
                                <option
                                        value="normal" <?php if (getFontStyle($style) == "normal") echo(" selected"); ?>><?php echo(getUebersetzung("standard", $sprache, $link)); ?></option>
                                <option
                                        value="italic" <?php if (getFontStyle($style) == "italic") echo(" selected"); ?>><?php echo(getUebersetzung("kursiv", $sprache, $link)); ?></option>
                            </select>
                        </div>
                        <div class="col-sm-offset-4 col-sm-3">
                            <div class="alert alert-info" style="width: auto;">
                                <label class="control-label">
									<?php echo(getUebersetzung("vorheriger Wert", $sprache, $link)); ?>:
                                </label>
								<?php if (getFontStyle($style) == "normal") echo(getUebersetzung("standard", $sprache, $link));
								else if (getFontStyle($style) == "italic") echo(getUebersetzung("kursiv", $sprache, $link));
								?>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <hr>
                    </div>
				<?php } ?>
				<?php if ($font_weight == "1")
				{ ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">
								<?php echo(getUebersetzung("Schriftstärke", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <select name="font_weight" class="form-control">
                                <option
                                        value="normal" <?php if (getFontWeight($style) == "normal") echo(" selected"); ?>><?php echo(getUebersetzung("standard", $sprache, $link)); ?></option>
                                <option
                                        value="bold" <?php if (getFontWeight($style) == "bold") echo(" selected"); ?>><?php echo(getUebersetzung("fett", $sprache, $link)); ?></option>
                                <option
                                        value="bolder" <?php if (getFontWeight($style) == "bolder") echo(" selected"); ?>><?php echo(getUebersetzung("fetter", $sprache, $link)); ?></option>
                            </select>
                        </div>
                        <div class="col-sm-offset-4 col-sm-3">
                            <div class="alert alert-info" style="width: auto;">
                                <label class="control-label">
									<?php echo(getUebersetzung("vorheriger Wert", $sprache, $link)); ?>:
                                </label>
								<?php if (getFontWeight($style) == "normal") echo(getUebersetzung("standard", $sprache, $link));
								else if (getFontWeight($style) == "bold") echo(getUebersetzung("fett", $sprache, $link));
								else if (getFontWeight($style) == "bolder") echo(getUebersetzung("fetter", $sprache, $link));
								?>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <hr>
                    </div>
				<?php } ?>
				<?php if ($text_align == "1")
				{ ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">
								<?php echo(getUebersetzung("Textausrichtung", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <select name="text_align" class="form-control">
                                <option
                                        value="left" <?php if (getFontVariant($style) == "left") echo(" selected"); ?>><?php echo(getUebersetzung("links", $sprache, $link)); ?></option>
                                <option
                                        value="right" <?php if (getFontVariant($style) == "right") echo(" selected"); ?>><?php echo(getUebersetzung("rechts", $sprache, $link)); ?></option>
                                <option
                                        value="center" <?php if (getFontVariant($style) == "center") echo(" selected"); ?>><?php echo(getUebersetzung("zentriert", $sprache, $link)); ?></option>
                                <option
                                        value="justify" <?php if (getFontVariant($style) == "justify") echo(" selected"); ?>><?php echo(getUebersetzung("Blocksatz", $sprache, $link)); ?></option>
                            </select>
                        </div>
                        <div class="col-sm-offset-4 col-sm-3">
                            <div class="alert alert-info" style="width: auto;">
                                <label class="control-label">
									<?php echo(getUebersetzung("vorheriger Wert", $sprache, $link)); ?>:
                                </label>
								<?php
								if (getFontVariant($style) == "left") echo(getUebersetzung("links", $sprache, $link));
								else if (getFontVariant($style) == "right") echo(getUebersetzung("rechts", $sprache, $link));
								else if (getFontVariant($style) == "center") echo(getUebersetzung("zentriert", $sprache, $link));
								else if (getFontVariant($style) == "justify") echo(getUebersetzung("Blocksatz", $sprache, $link));
								?>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <hr>
                    </div>
				<?php } ?>
				<?php if ($color == "1")
				{ ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">
								<?php echo(getUebersetzung("Schriftfarbe", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control" name="color" id="color"

                                   value="<?php echo(getColor($style)); ?>">
                            <script>
                                $(function () {
                                    $('#color').colorpicker().on('changeColor', function (e) {
                                        $('body').css({color: e.color.toHex()});
                                    });
                                });
                            </script>
                            <!--<select name="color" size="4">
                                <?php
							/*                                getColorTable(getColor($style));
															*/ ?>
                            </select>-->
                        </div>
                        <div class="col-sm-offset-4 col-sm-3">
                            <div class="alert alert-info" style="width: auto;">
                                <label class="control-label">
									<?php echo(getUebersetzung("vorheriger Wert", $sprache, $link)); ?>:
                                </label>
								<?php echo(getColor($style)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
				<?php } ?>
				<?php if ($border == "1")
				{ ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">
								<?php echo(getUebersetzung("Rahmenstärke", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <select name="border" class="form-control">
								<?php for ($i = 0; $i <= 10; $i++)
								{ ?>
                                    <option
                                            value="<?php echo(($i) . ("px")); ?>" <?php if (($i) . ("px") == getBorder($style)) echo(" selected"); ?>><?php echo(($i) . (" px")); ?></option>
								<?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-offset-4 col-sm-3">
                            <div class="alert alert-info" style="width: auto;">
                                <label class="control-label">
									<?php echo(getUebersetzung("vorheriger Wert", $sprache, $link)); ?>:
                                </label>
								<?php echo(getBorder($style)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
				<?php } ?>
				<?php if ($border_color == "1")
				{ ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">
								<?php echo(getUebersetzung("Rahmenfarbe", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control" name="border_color" id="border_color"

                                   value="<?php echo(getBorderColor($style)); ?>">
                            <script>
                                $(function () {
                                    $('#border_color').colorpicker().on('changeColor', function (e) {
                                        // $('body').css({color:e.color.toHex()});
                                    });
                                });
                            </script>

                        </div>
                        <div class="col-sm-offset-4 col-sm-3">
                            <div class="alert alert-info" style="width: auto;">
                                <label class="control-label">
									<?php echo(getUebersetzung("vorheriger Wert", $sprache, $link)); ?>:
                                </label>
								<?php echo(getBorderColor($style)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
				<?php } ?>
				<?php if ($background_color == "1")
				{ ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">
								<?php echo(getUebersetzung("Hintergrundfarbe", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control" name="background_color" id="background_color"

                                   value="<?php echo(getBackgroundColor($style)); ?>">
                            <script>
                                $(function () {
                                    $('#background_color').colorpicker().on('changeColor', function (e) {
                                        $('body')[0].style.backgroundColor = e.color.toHex();
                                    });
                                });
                            </script>

                        </div>
                        <div class="col-sm-offset-4 col-sm-3">
                            <div class="alert alert-info" style="width: auto;">
                                <label class="control-label">
									<?php echo(getUebersetzung("vorheriger Wert", $sprache, $link)); ?>:
                                </label>
								<?php echo(getBackgroundColor($style)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
				<?php } ?>
				<?php if ($height == "1")
				{ ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">
								<?php echo(getUebersetzung("Höhe", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <select name="height" class="form-control">
								<?php for ($i = 10; $i <= 40; $i++)
								{ ?>
                                    <option
                                            value="<?php echo(($i) . ("px")); ?>" <?php if (($i) . ("px") == getHeight($style)) echo(" selected"); ?>><?php echo(($i) . (" px")); ?></option>
								<?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-offset-4 col-sm-3">
                            <div class="alert alert-info" style="width: auto;">
                                <label class="control-label">
									<?php echo(getUebersetzung("vorheriger Wert", $sprache, $link)); ?>:
                                </label>
								<?php echo(getHeight($style)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
				<?php } ?>
				<?php if ($width == "1")
				{ ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="control-label">
								<?php echo(getUebersetzung("Breite", $sprache, $link)); ?>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <select name="width" class="form-control">
								<?php for ($i = 100; $i <= 400; $i = $i + 10)
								{ ?>
                                    <option
                                            value="<?php echo(($i) . ("px")); ?>"<?php if (($i) . ("px") == getWidth($style)) echo(" selected"); ?>><?php echo(($i) . (" px")); ?></option>
								<?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-offset-4 col-sm-3">
                            <div class="alert alert-info" style="width: auto;">
                                <label class="control-label">
									<?php echo(getUebersetzung("vorheriger Wert", $sprache, $link)); ?>:
                                </label>
								<?php echo(getWidth($style)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
				<?php } ?>

                <div class="row">

                    <div class=" col-sm-2" style="text-align: left;">
                        <form action="../inhalt.php" method="post" name="styles" target="_self" id="styles">

                            <button type="submit" name="Submit3" class="btn btn-primary">
                                <span class="glyphicon glyphicon-home"></span>
								<?php echo(getUebersetzung("Hauptmenü", $sprache, $link)); ?>
                            </button>
                        </form>
                    </div>


                    <div class="col-sm-10" style="text-align: right;">

                        <button name="submit4" type="submit" class="btn btn-success" id="submit4">
                            <span class="glyphicon glyphicon-wrench"></span>
							<?php echo(getUebersetzung("Design ändern", $sprache, $link)); ?>
                        </button>
                        <a class="btn btn-primary" href="./index.php">
                            <!--                            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;-->
							<?php echo(getUebersetzung("zurück", $sprache, $link)); ?>
                        </a>

                    </div>
                </div>

            </form>


		<?php } //ende else
		?>

    </div>
</div>
</body>
</html>