<?php session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan rezervi			
			author: christian osterrieder utilo.eu						

*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);

if (isset($_POST["hintergrund"]))
	$hintergrund = $_POST["hintergrund"];
else
	$hintergrund = "";	
if (isset($_POST["font_family"]))
	$font_family = $_POST["font_family"];
else
	$font_family = "";
if (isset($_POST["font_size"]))
	$font_size = $_POST["font_size"];
else
	$font_size = "";
if (isset($_POST["font_style"]))
	$font_style = $_POST["font_style"];
else
	$font_style = "";
if (isset($_POST["font_weight"]))
	$font_weight = $_POST["font_weight"];
else
	$font_weight = "";
if (isset($_POST["text_align"]))
	$text_align = $_POST["text_align"];
else
	$text_align = "";	
if (isset($_POST["color"]))
	$color = $_POST["color"];
else
	$color = "";
if (isset($_POST["border"]))
	$border = $_POST["border"];
else
	$border = "";	
if (isset($_POST["border_color"]))
	$border_color = $_POST["border_color"];
else
	$border_color = "";	
if (isset($_POST["background_color"]))
	$background_color = $_POST["background_color"];
else
	$background_color = "";	
if (isset($_POST["height"]))
	$height = $_POST["height"];
else
	$height = "";	
if (isset($_POST["width"]))
	$width = $_POST["width"];
else
	$width = "";
if (isset($_POST["stylesheet"]))
	$stylesheet = $_POST["stylesheet"];
else
	$stylesheet = "";
	
$sprache = getSessionWert(SPRACHE);

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
//uebersetzer einfuegen:
include_once("../../include/uebersetzer.php");	
include_once("./stylesHelper.php");
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php		
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ 
	
	$designFuer = "";
	if ($stylesheet == "ueberschrift"){
		$designFuer = "Überschrift";
	}
	else if ($stylesheet == "standardSchrift"){
		$designFuer = "Standard-Schrift";
	}
	else if ($stylesheet == "hintergrund"){
		$designFuer = "Hintergrund";
	}
	else if ($stylesheet == "markierteSchrift"){
		$designFuer = "markierte Schrift";
	}
	else if ($stylesheet == "buttonA"){
		$designFuer = "Button";
	}
	else if ($stylesheet == "buttonB"){
		$designFuer = "Rollover-Button";
	}
	else if ($stylesheet == "tabelle"){
		$designFuer = "Tabelle";
	}
	else if ($stylesheet == "tabelleColor"){
		$designFuer = "färbige Tabelle";
	}
	else if ($stylesheet == "belegt"){
		$designFuer = "belegt";
	}
	else if ($stylesheet == "frei"){
		$designFuer = "frei";
	}
	else if ($stylesheet == "samstagFrei"){
		$designFuer = "freie Samstage";
	}
	else if ($stylesheet == "reserviert"){
		$designFuer = "reserviert";
	}
	else if ($stylesheet == "samstagReserviert"){
		$designFuer = "reservierte Samstage";
	}	
	else if ($stylesheet == "samstagBelegt"){
		$designFuer = "belegte Samstage";
	}
	else if ($stylesheet == "samstagReserviert"){
		$designFuer = "reservierte Samstage";
	}

?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("Design bearbeiten",$sprache,$link)); ?></p>

<table border="0" cellspacing="2" cellpadding="0" class="frei">         
          <tr>            
            <td><?php 
				//string fuer das style zusammenstellen:
				$style = "";
				if (isset($font_family) && $font_family != ""){
					$style = $style.("font-family: ");
					$style = $style.($font_family);
					$style = $style.(";");
				}
				if (isset($font_size) && $font_size != ""){
					$style = $style.("font-size: ");
					$style = $style.($font_size);
					$style = $style.(";");
				}
				if (isset($font_style) && $font_style != ""){
					$style = $style.("font-style: ");
					$style = $style.($font_style);
					$style = $style.(";");
				}
				if (isset($text_align) && $text_align != ""){
					$style = $style.("text-align: ");
					$style = $style.($text_align);
					$style = $style.(";");
				}
				if (isset($font_weight) && $font_weight != ""){
					$style = $style.("font-weight: ");
					$style = $style.($font_weight);
					$style = $style.(";");
				}
				if (isset($color) && $color != ""){
					$style = $style.("color: ");
					$style = $style.($color);
					$style = $style.(";");
				}
				if (isset($border) && $border != ""){
					$style = $style.("border: ");
					$style = $style.($border).(" ridge ").($border_color);
					$style = $style.(";");
				}
				if (isset($background_color) && $background_color != ""){
					$style = $style.("background-color: ");
					$style = $style.($background_color);
					$style = $style.(";");
				}
				if (isset($height) && $height != ""){
					$style = $style.("height: ");
					$style = $style.($height);
					$style = $style.(";");
				}
				if (isset($width) && $width != ""){
					$style = $style.("width: ");
					$style = $style.($width);
					$style = $style.(";");
				}
				
				//stylesheet in datenbank eintragen:
				$query = "";
				$query1 = ("UPDATE Rezervi_CSS SET ");
				$query2 = trim(" = '$style'
						   WHERE
						   FK_Unterkunft_ID = $unterkunft_id; ");				
				
	if ($stylesheet == "ueberschrift"){
		$query = $query1.("ueberschrift").$query2;
	}
	else if ($stylesheet == "standardSchrift"){
		$query = $query1.("standardSchrift").$query2;
	}
	else if ($stylesheet == "hintergrund"){
		$query = $query1.("backgroundColor").$query2;
	}
	else if ($stylesheet == "markierteSchrift"){
		$query = $query1.("standardSchriftBold").$query2;
	}
	else if ($stylesheet == "buttonA"){
		$query = $query1.("button200pxA").$query2;
	}
	else if ($stylesheet == "buttonB"){
		$query = $query1.("button200pxB").$query2;
	}
	else if ($stylesheet == "tabelle"){
		$query = $query1.("tableStandard").$query2;
	}
	else if ($stylesheet == "tabelleColor"){
		$query = $query1.("tableColor").$query2;
	}
	else if ($stylesheet == "belegt"){
		$query = $query1.("belegt").$query2;
	}
	else if ($stylesheet == "frei"){
		$query = $query1.("frei").$query2;
	}
	else if ($stylesheet == "samstagFrei"){
		$query = $query1.("samstagFrei").$query2;
	}
	else if ($stylesheet == "reserviert"){
		$query = $query1.("reserviert").$query2;
	}
	else if ($stylesheet == "samstagReserviert"){
		$query = $query1.("samstagReserviert").$query2;
	}	
	else if ($stylesheet == "samstagBelegt"){
		$query = $query1.("samstagBelegt").$query2;
	}
	else if ($stylesheet == "samstagReserviert"){
		$query = $query1.("samstagReserviert").$query2;
	}
	
	//query absetzen:
	$res = mysql_query($query, $link);
  	if (!$res) {
		echo(mysql_error($link));
  		echo("Anfrage $query scheitert.");
  		
	}
	else{		
			?>
			<?php echo(getUebersetzung("Das Design des ausgewählen Elementes wurde erfolgreich geändert",$sprache,$link)); ?>!
			</td>
          <?php } ?></tr>
		 </table>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><form action="./index.php" method="post" name="form1" target="_self">
        <input type="submit" name="Submit3" value="<?php echo(getUebersetzung("zurck",$sprache,$link)); ?>" class="button200pxA" 
			onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';">
      </form></td>
  </tr>
</table>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="form1" target="_self">
        <input type="submit" name="Submit3" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>" class="button200pxA" 
			onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';">
      </form></td>
  </tr>
</table>
<?php } //ende else
 ?>
</body>
</html>