<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
/*   
			reservierungsplan
			startseite zur wartung der reservierung f�r den benutzer
			author: christian osterrieder utilo.eu						
			
			dieser seite muss �bergeben werden:
			Benutzer PK_ID $benutzer_id
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
if (isset($_POST["hintergrund"])){
	$hintergrund = $_POST["hintergrund"];
}
else{
	$hintergrund = "0";
}
if (isset($_POST["font_family"])){
	$font_family = $_POST["font_family"];
}
else{
	$font_family = "0";
}
if (isset($_POST["font_size"])){
	$font_size = $_POST["font_size"];
}
else{
	$font_size = "0";
}
if (isset($_POST["font_style"])){
	$font_style = $_POST["font_style"];
}
else{
	$font_style = "0";
}
if (isset($_POST["font_weight"])){
	$font_weight = $_POST["font_weight"];
}
else{
	$font_weight = "0";
}
if (isset($_POST["text_align"])){
	$text_align = $_POST["text_align"];
}
else{
	$text_align = "0";
}	
if (isset($_POST["color"])){
	$color = $_POST["color"];
}
else{
	$color = "0";
}
if (isset($_POST["border"])){
	$border = $_POST["border"];
}
else{
	$border = "0";
}
if (isset($_POST["border_color"])){
	$border_color = $_POST["border_color"];
}
else{
	$border_color = "0";
}
if (isset($_POST["background_color"])){
	$background_color = $_POST["background_color"];
}
else{
	$background_color = "0";
}
if (isset($_POST["height"])){
	$height = $_POST["height"];
}
else{
	$height = "0";
}
if (isset($_POST["width"])){
	$width = $_POST["width"];
}
else{
	$width = "0";
}
$stylesheet = $_POST["stylesheet"];
$sprache = getSessionWert(SPRACHE);

//datenbank �ffnen:
include_once("../../conf/rdbmsConfig.php");

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
	//stylesheets f�r farben erzeugen:
	echo("<style type=\"text/css\"> \n");
	echo("<!-- \n");
				$hex = array("00", "33", "66", "99", "CC", "FF");
				for ($r=0; $r<count($hex); $r++){ //the red colors loop
				  for ($g=0; $g<count($hex); $g++){ //the green colors loop
					for ($b=0; $b<count($hex); $b++){ //iterate through the six blue colors
					  $col = $hex[$r].$hex[$g].$hex[$b];
					  //At this point we decide what font color to use
					  if ($hex[$r] <= "99" && $hex[$g] <= "99" && $hex[$b] <= "99"){
						echo((".x").($col).(" { \n background-color: ").("#").($col).("; \n color: #FFFFFF; \n } \n")); 
					  } else {
						echo((".x").($col).(" { \n background-color: ").("#").($col).("; \n color: #000000; \n } \n")); 
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
	if ($stylesheet == "ueberschrift"){
		$designFuer = "�berschrift";
		$auslesen = "ueberschrift";
	}
	else if ($stylesheet == "standardSchrift"){
		$designFuer = "Standard-Schrift";
		$auslesen = "standardSchrift";
	}
	else if ($stylesheet == "hintergrund"){
		$designFuer = "Hintergrund";
		$auslesen = "backgroundColor";
	}
	else if ($stylesheet == "markierteSchrift"){
		$designFuer = "makierte Schrift";
		$auslesen = "standardSchriftBold";
	}
	else if ($stylesheet == "buttonA"){
		$designFuer = "Button";
		$auslesen = "button200pxA";
	}
	else if ($stylesheet == "buttonB"){
		$designFuer = "Rollover-Button";
		$auslesen = "button200pxB";
	}
	else if ($stylesheet == "tabelle"){
		$designFuer = "Tabelle";
		$auslesen = "tableStandard";
	}
	else if ($stylesheet == "tabelleColor"){
		$designFuer = "f�rbige Tabelle";
		$auslesen = "tableColor";
	}
	else if ($stylesheet == "belegt"){
		$designFuer = "belegt";
		$auslesen = "belegt";
	}
	else if ($stylesheet == "frei"){
		$designFuer = "frei";
		$auslesen = "frei";
	}
	else if ($stylesheet == "samstagFrei"){
		$designFuer = "freie Samstage";
		$auslesen = "samstagFrei";
	}
	else if ($stylesheet == "reserviert"){
		$designFuer = "reserviert";
		$auslesen = "reserviert";
	}
	else if ($stylesheet == "samstagReserviert"){
		$designFuer = "reservierte Samstage";
		$auslesen = "samstagReserviert";
	}	
	else if ($stylesheet == "samstagBelegt"){
		$designFuer = "belegte Samstage";
		$auslesen = "samstagBelegt";
	}
	else if ($stylesheet == "samstagReserviert"){
		$designFuer = "reservierte Samstage";
		$auslesen = "samstagReserviert";
	}
	//uebersetzen:
	$designFuer = getUebersetzung($designFuer,$sprache,$link);
	
	//vorherigen style aus datenbank auslesen:
		$query = ("SELECT ".($auslesen)."  
					FROM
					Rezervi_CSS
					WHERE
					FK_Unterkunft_ID = '$unterkunft_id'
					");
	
		$res = mysql_query($query, $link);
		if (!$res)  
			echo("die Anfrage $query scheitert");
			
		$d = mysql_fetch_array($res);
		$style = $d[$auslesen];
	
//passwortpr�fung:	
if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ ?>
<p class="standardSchriftBold"><?php echo(getUebersetzung("Design für",$sprache,$link)); ?> "<?php echo($designFuer); ?>" <?php echo(getUebersetzung("bearbeiten",$sprache,$link)); ?></p>
<br/>
<form action="styleAendern.php" method="post" name="styles" target="_self" id="styles">
  <input name="stylesheet" type="hidden" value="<?php echo($stylesheet); ?>">
  <table border="0" cellpadding="0" cellspacing="3" class="table">
    <tr>
      <td><table width="100%"  border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><?php echo(getUebersetzung("vorheriger Wert",$sprache,$link)); ?>:</td>
        </tr>
          <?php if ($font_family == "1"){ 
		  	$standard = getFontFamily($style);
		  ?>
          <tr>
            <td><?php echo(getUebersetzung("Schriftart",$sprache,$link)); ?></td>
            <td><select name="font_family">
                <option value="Arial, Helvetica, sans-serif" <?php if ($standard == "Arial, Helvetica, sans-serif") echo(" selected"); ?>>Arial</option>
                <option value="Times New Roman, Times, serif" <?php if ($standard == "Times New Roman, Times, serif") echo(" selected"); ?>>Times New Roman</option>
                <option value="Courier New, Courier, mono" <?php if ($standard == "Courier New, Courier, mono") echo(" selected"); ?>>Courier</option>
                <option value="Georgia, Times New Roman, Times, serif" <?php if ($standard == "Georgia, Times New Roman, Times, serif") echo(" selected"); ?>>Georgia</option>
                <option value="Verdana, Arial, Helvetica, sans-serif" <?php if ($standard == "Verdana, Arial, Helvetica, sans-serif") echo(" selected"); ?>>Verdana</option>
                <option value="Geneva, Arial, Helvetica, sans-serif" <?php if ($standard == "Geneva, Arial, Helvetica, sans-serif") echo(" selected"); ?>>Geneva</option>
              </select></td>
            <td><?php 
				if ($standard == "Arial, Helvetica, sans-serif") echo("Arial"); 
				else if ($standard == "Times New Roman, Times, serif") echo("Times New Roman"); 
				else if ($standard == "Courier New, Courier, mono") echo("Courier");
				else if ($standard == "Georgia, Times New Roman, Times, serif") echo("Georgia");
				else if ($standard == "Verdana, Arial, Helvetica, sans-serif") echo("Verdana"); 
				else if ($standard == "Geneva, Arial, Helvetica, sans-serif") echo("Geneva"); 
			?></td>
          </tr>
          <?php } ?>
          <?php if ($font_size == "1"){ ?>
          <tr>
            <td><?php echo(getUebersetzung("Schriftgr�sse",$sprache,$link)); ?></td>
            <td><select name="font_size">
                <?php for ($i = 4; $i<=30; $i++){ ?>
                <option value="<?php echo(($i).("px")); ?>" <?php if (($i).("px") == getFontSize($style)) echo(" selected"); ?>><?php echo(($i).(" px")); ?></option>
                <?php } ?>
              </select></td>
            <td><?php echo(getFontSize($style)); ?></td>
          </tr>
          <?php } ?>
          <?php if ($font_style == "1"){ ?>
          <tr>
            <td><?php echo(getUebersetzung("Schriftstil",$sprache,$link)); ?></td>
            <td><select name="font_style">
                <option value="normal" <?php if (getFontStyle($style) == "normal") echo(" selected"); ?>><?php echo(getUebersetzung("standard",$sprache,$link)); ?></option>
                <option value="italic" <?php if (getFontStyle($style) == "italic") echo(" selected"); ?>><?php echo(getUebersetzung("kursiv",$sprache,$link)); ?></option>
              </select></td>
            <td><?php if (getFontStyle($style) == "normal") echo(getUebersetzung("standard",$sprache,$link)); 
					  else if (getFontStyle($style) == "italic") echo(getUebersetzung("kursiv",$sprache,$link)); 
			?></td>
          </tr>
          <?php } ?>
          <?php if ($font_weight == "1"){ ?>
          <tr>
            <td><?php echo(getUebersetzung("Schriftst�rke",$sprache,$link)); ?></td>
            <td><select name="font_weight">
                <option value="normal" <?php if (getFontWeight($style) == "normal") echo(" selected"); ?>><?php echo(getUebersetzung("standard",$sprache,$link)); ?></option>
                <option value="bold" <?php if (getFontWeight($style) == "bold") echo(" selected"); ?>><?php echo(getUebersetzung("fett",$sprache,$link)); ?></option>
                <option value="bolder" <?php if (getFontWeight($style) == "bolder") echo(" selected"); ?>><?php echo(getUebersetzung("fetter",$sprache,$link)); ?></option>
              </select></td>
            <td><?php if (getFontWeight($style) == "normal") echo(getUebersetzung("standard",$sprache,$link)); 
					  else if (getFontWeight($style) == "bold") echo(getUebersetzung("fett",$sprache,$link)); 
					  else if (getFontWeight($style) == "bolder") echo(getUebersetzung("fetter",$sprache,$link));			
			?></td>
          </tr>
          <?php } ?>
          <?php if ($text_align == "1"){ ?>
          <tr>
            <td><?php echo(getUebersetzung("Textausrichtung",$sprache,$link)); ?></td>
            <td><select name="text_align">
                <option value="left" <?php if (getFontVariant($style) == "left") echo(" selected"); ?>><?php echo(getUebersetzung("links",$sprache,$link)); ?></option>
                <option value="right" <?php if (getFontVariant($style) == "right") echo(" selected"); ?>><?php echo(getUebersetzung("rechts",$sprache,$link)); ?></option>
                <option value="center" <?php if (getFontVariant($style) == "center") echo(" selected"); ?>><?php echo(getUebersetzung("zentriert",$sprache,$link)); ?></option>
                <option value="justify" <?php if (getFontVariant($style) == "justify") echo(" selected"); ?>><?php echo(getUebersetzung("Blocksatz",$sprache,$link)); ?></option>
              </select></td>
            <td><?php 
			if (getFontVariant($style) == "left") echo(getUebersetzung("links",$sprache,$link)); 
			else if (getFontVariant($style) == "right") echo(getUebersetzung("rechts",$sprache,$link)); 
			else if (getFontVariant($style) == "center") echo(getUebersetzung("zentriert",$sprache,$link)); 
			else if (getFontVariant($style) == "justify") echo(getUebersetzung("Blocksatz",$sprache,$link)); 
			?></td>
          </tr>
          <?php } ?>
          <?php if ($color == "1"){ ?>
          <tr>
            <td><?php echo(getUebersetzung("Schriftfarbe",$sprache,$link)); ?></td>
            <td><select name="color" size="4">
                <?php
					getColorTable(getColor($style));
				?>
            </select></td>
            <td><?php echo(getColor($style)); ?></td>
          </tr>
          <?php } ?>
          <?php if ($border == "1"){ ?>
          <tr>
            <td><?php echo(getUebersetzung("Rahmenst�rke",$sprache,$link)); ?></td>
            <td><select name="border">
                <?php for ($i = 0; $i<=10; $i++){ ?>
                <option value="<?php echo(($i).("px")); ?>" <?php if (($i).("px") == getBorder($style)) echo(" selected"); ?>><?php echo(($i).(" px")); ?></option>
                <?php } ?>
              </select></td>
            <td><?php echo(getBorder($style)); ?></td>
          </tr>
          <?php } ?>
          <?php if ($border_color == "1"){ ?>
          <tr>
            <td><?php echo(getUebersetzung("Rahmenfarbe",$sprache,$link)); ?></td>
            <td><select name="border_color" size="4">
                <?php
					getColorTable(getBorderColor($style));
				?>
            </select></td>
            <td><?php echo(getBorderColor($style)); ?></td>
          </tr>
          <?php } ?>
          <?php if ($background_color == "1"){ ?>
          <tr>
            <td><?php echo(getUebersetzung("Hintergrundfarbe",$sprache,$link)); ?></td>
            <td><select name="background_color" size="4">
                <?php
					getColorTable(getBackgroundColor($style));
				?>
            </select></td>
            <td><?php echo(getBackgroundColor($style)); ?></td>
          </tr>
          <?php } ?>
          <?php if ($height == "1"){ ?>
          <tr>
            <td><?php echo(getUebersetzung("H�he",$sprache,$link)); ?></td>
            <td><select name="height">
                <?php for ($i = 10; $i<=40; $i++){ ?>
                <option value="<?php echo(($i).("px")); ?>" <?php if (($i).("px") == getHeight($style)) echo(" selected"); ?>><?php echo(($i).(" px")); ?></option>
                <?php } ?>
              </select></td>
            <td><?php echo(getHeight($style)); ?></td>
          </tr>
          <?php } ?>
          <?php if ($width == "1"){ ?>
          <tr>
            <td><?php echo(getUebersetzung("Breite",$sprache,$link)); ?></td>
            <td><select name="width">
                <?php for ($i = 100; $i<=400; $i=$i+10){ ?>
                <option value="<?php echo(($i).("px")); ?>"<?php if (($i).("px") == getWidth($style)) echo(" selected"); ?>><?php echo(($i).(" px")); ?></option>
                <?php } ?>
              </select></td>
            <td><?php echo(getWidth($style)); ?></td>
          </tr>
		  <?php } ?>
        </table></td>
    </tr>
  </table>
  <br/>
  <table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td>
        <input type="submit" name="Submit4" value="<?php echo(getUebersetzung("Design ändern",$sprache,$link)); ?>" class="btn btn-primary" 			
    </td>
  </tr>
</table>
<br/>
</form>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td>
    	<a class="btn btn-primary" href="./index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;<?php echo(getUebersetzung("zurück",$sprache,$link)); ?></a>
	<!-- <form action="./index.php" method="post" name="form1" target="_self">
        <input type="submit" name="Submit3" value="<?php echo(getUebersetzung("zur�ck",$sprache,$link)); ?>" class="button200pxA" 
			onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';">
      </form> -->
    </td>
  </tr>
</table>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="form1" target="_self">
        <input type="submit" name="Submit3" value="<?php echo(getUebersetzung("Hauptmen�",$sprache,$link)); ?>" class="button200pxA" 
			onMouseOver="this.className='button200pxB';"
       		onMouseOut="this.className='button200pxA';">
      </form></td>
  </tr>
</table>
<?php } //ende else
 ?>
</body>
</html>