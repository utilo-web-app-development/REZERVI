<?php 
$root = "../..";
$ueberschrift = "Design bearbeiten";
$unterschrift = "Stile ändern";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Design", "designBearbeiten/index.php",
							$unterschrift, "designBearbeiten/styles.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/include/cssFunctions.inc.php"); 
include_once("./stylesHelper.php");
?>
<h2><?php echo(getUebersetzung($unterschrift)); ?></h2>
<table>
  <tr valign="middle">
    <td><form action="./styles.php" method="post" target="_self">
	   <input name="hintergrund" type="submit" class="button_nav" id="resEingebenAendern" value="<?php echo(getUebersetzung("Hintergrund"));?>">
	   <input name="font_family" type="hidden" value="0">
	   <input name="font_size" type="hidden" value="0">
	   <input name="font_style" type="hidden" value="0">
	   <input name="font_weight" type="hidden" value="0">
	   <input name="text_align" type="hidden" value="0">
	   <input name="color" type="hidden" value="0">
	   <input name="border" type="hidden" value="0">
	   <input name="border_color" type="hidden" value="0">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo BACKGROUND_COLOR ?>">
    </form></td>
    <td><form action="./styles.php" method="post" target="_self">
	<input name="resEingebenAendern" type="submit" class="button_nav"
			id="resEingebenAendern" value="<?php echo(getUebersetzung("Schrift")); ?>">
	   <input name="font_family" type="hidden" value="1">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="0">
	   <input name="border_color" type="hidden" value="0">
	   <input name="background_color" type="hidden" value="0">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo STANDARD_SCHRIFT ?>">
    </form></td>
    <td><form action="./styles.php" method="post" target="_self">
	<input name="ueberschrift" type="submit" class="button_nav" 
		id="resEingebenAendern" value="<?php echo(getUebersetzung("Überschrift")); ?>">
	   <input name="font_family" type="hidden" value="1">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="0">
	   <input name="border_color" type="hidden" value="0">
	   <input name="background_color" type="hidden" value="0">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo UEBERSCHRIFT ?>">
    </form></td>
    <td><form action="./styles.php" method="post" target="_self">
	<input name="markierteSchrift" type="submit" class="button_nav" 
			id="resEingebenAendern" value="<?php echo(getUebersetzung("Markierte Schrift")); ?>">
	   <input name="font_family" type="hidden" value="1">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="0">
	   <input name="border_color" type="hidden" value="0">
	   <input name="background_color" type="hidden" value="0">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo STANDARD_SCHRIFT_BOLD ?>">
    </form></td>
    <td><form action="./styles.php" method="post" target="_self">
	<input name="buttonA" type="submit" class="button_nav" 
			id="resEingebenAendern" value="<?php echo(getUebersetzung("Button")); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="1">
	   <input name="width" type="hidden" value="1">
	   <input name="stylesheet" type="hidden" value="<?php echo BUTTON ?>">
    </form></td>
  </tr> 
  <tr valign="middle">
    <td><form action="./styles.php" method="post" target="_self">
		<input name="buttonB" type="submit" class="button_nav" 
			id="resEingebenAendern" value="<?php echo(getUebersetzung("Button rollover")); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="1">
	   <input name="width" type="hidden" value="1">
	   <input name="stylesheet" type="hidden" value="<?php echo BUTTON_HOVER ?>">
	   </form>
    </td>
    <td><form action="./styles.php" method="post" target="_self">
		<input name="tabelle" type="submit" class="button_nav" 
			id="resEingebenAendern" value="<?php echo(getUebersetzung("Tabelle")); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo TABLE_STANDARD ?>">
	   </form>
    </td>
    <td><form action="./styles.php" method="post" target="_self">
	<input name="tabelleColor" type="submit" class="button_nav" 
			id="resEingebenAendern" value="<?php echo(getUebersetzung("Färbige Tabelle")); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo TABLE_COLOR ?>">
	   </form>
    </td>
    <td><form action="./styles.php" method="post" target="_self">
	<input name="belegt" type="submit"  class="button_nav" 
			id="resEingebenAendern" value="<?php echo(getUebersetzung("Stil für Belegt")); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo BELEGT ?>">
	   </form>
    </td>
    <td><form action="./styles.php" method="post" target="_self">
	<input name="frei" type="submit"  class="button_nav" 
			id="resEingebenAendern" value="<?php echo(getUebersetzung("Stil für Frei")); ?>">
	   <input name="font_size" type="hidden" value="1">
	   <input name="font_style" type="hidden" value="1">
	   <input name="font_weight" type="hidden" value="1">
	   <input name="text_align" type="hidden" value="1">
	   <input name="color" type="hidden" value="1">
	   <input name="border" type="hidden" value="1">
	   <input name="border_color" type="hidden" value="1">
	   <input name="background_color" type="hidden" value="1">
	   <input name="height" type="hidden" value="0">
	   <input name="width" type="hidden" value="0">
	   <input name="stylesheet" type="hidden" value="<?php echo FREI ?>">
	   </form>
    </td>
  </tr>
</table>
<?php 
if (isset($_POST["hintergrund"])){
	$hintergrund = $_POST["hintergrund"];
}else{
	$hintergrund = false;
}
if (isset($_POST["font_family"])){
	$font_family = $_POST["font_family"];
}else{
	$font_family = false;
}
if (isset($_POST["font_size"])){
	$font_size = $_POST["font_size"];
}else{
	$font_size = false;
}
if (isset($_POST["font_style"])){
	$font_style = $_POST["font_style"];
}else{
	$font_style = false;
}
if (isset($_POST["font_weight"])){
	$font_weight = $_POST["font_weight"];
}else{
	$font_weight = false;
}
if (isset($_POST["text_align"])){
	$text_align = $_POST["text_align"];
}else{
	$text_align = false;
}
if (isset($_POST["color"])){
	$color = $_POST["color"];
}else{
	$color = false;
}
if (isset($_POST["border"])){
	$border = $_POST["border"];
}else{
	$border = false;
}
if (isset($_POST["border_color"])){
	$border_color = $_POST["border_color"];
}else{
	$border_color = false;
}
if (isset($_POST["background_color"])){
	$background_color = $_POST["background_color"];
}else{
	$background_color = false;
}
if (isset($_POST["height"])){
	$height = $_POST["height"];
}else{
	$height = false;
}
if (isset($_POST["width"])){
	$width = $_POST["width"];
}else{
	$width = false;
}
if (isset($_POST["stylesheet"])){
	$stylesheet = $_POST["stylesheet"];
}else{
	$stylesheet = false;
}
if (!empty($info)){
	exit;
}		
	//stylesheets für farben erzeugen:
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
	echo("--> \n");
	echo("</style> \n");
	
	//ueberschrift erzeugen:
	$designFuer = "";
	
	if ($stylesheet == UEBERSCHRIFT){
		$designFuer = "Überschrift";
	}
	else if ($stylesheet == STANDARD_SCHRIFT){
		$designFuer = "Standard-Schrift";
	}
	else if ($stylesheet == BACKGROUND_COLOR){
		$designFuer = "Hintergrund";
	}
	else if ($stylesheet == STANDARD_SCHRIFT_BOLD){
		$designFuer = "makierte Schrift";
	}
	else if ($stylesheet == BUTTON){
		$designFuer = "Button";
	}
	else if ($stylesheet == BUTTON_HOVER){
		$designFuer = "Rollover-Button";
	}
	else if ($stylesheet == TABLE_STANDARD){
		$designFuer = "Tabelle";
	}
	else if ($stylesheet == TABLE_COLOR){
		$designFuer = "Färbige Tabelle";
	}
	else if ($stylesheet == BELEGT){
		$designFuer = "Stil für Belegt";
	}
	else if ($stylesheet == FREI){
		$designFuer = "Stil für Frei";
	}
	if($designFuer==""){
		include_once($root."/backoffice/templates/footer.inc.php");
		exit;
	}
	//uebersetzen:
	$designFuer = getUebersetzung($designFuer); 
	
	//vorherigen style aus datenbank auslesen:
	$style = getStyle($stylesheet,$gastro_id);
?>

<h2 style="margin-top:10px;"><?php echo(getUebersetzung("Design für")); ?> "<?php echo($designFuer); ?>" <?php echo(getUebersetzung("bearbeiten")); ?></h2>
<form action="styleAendern.php" method="post" name="styles" target="_self" id="styles">
  <input name="stylesheet" type="hidden" value="<?php echo($stylesheet); ?>">
	<table  class="moduletable_line">
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><?php echo(getUebersetzung("vorheriger Wert")); ?>:</td>
        </tr>
          <?php if ($font_family == "1"){ 
		  	$standard = getFontFamily($style);
		  ?>
          <tr>
            <td><?php echo(getUebersetzung("Schriftart")); ?></td>
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
            <td><?php echo(getUebersetzung("Schriftgrösse")); ?></td>
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
            <td><?php echo(getUebersetzung("Schriftstil")); ?></td>
            <td><select name="font_style">
                <option value="normal" <?php if (getFontStyle($style) == "normal") echo(" selected"); ?>><?php echo(getUebersetzung("standard")); ?></option>
                <option value="italic" <?php if (getFontStyle($style) == "italic") echo(" selected"); ?>><?php echo(getUebersetzung("kursiv")); ?></option>
              </select></td>
            <td><?php if (getFontStyle($style) == "normal") echo(getUebersetzung("standard")); 
					  else if (getFontStyle($style) == "italic") echo(getUebersetzung("kursiv")); 
			?></td>
          </tr>
          <?php } ?>
          <?php if ($font_weight == "1"){ ?>
          <tr>
            <td><?php echo(getUebersetzung("Schriftstärke")); ?></td>
            <td><select name="font_weight">
                <option value="normal" <?php if (getFontWeight($style) == "normal") echo(" selected"); ?>><?php echo(getUebersetzung("standard")); ?></option>
                <option value="bold" <?php if (getFontWeight($style) == "bold") echo(" selected"); ?>><?php echo(getUebersetzung("fett")); ?></option>
                <option value="bolder" <?php if (getFontWeight($style) == "bolder") echo(" selected"); ?>><?php echo(getUebersetzung("fetter")); ?></option>
              </select></td>
            <td><?php if (getFontWeight($style) == "normal") echo(getUebersetzung("standard")); 
					  else if (getFontWeight($style) == "bold") echo(getUebersetzung("fett")); 
					  else if (getFontWeight($style) == "bolder") echo(getUebersetzung("fetter"));			
			?></td>
          </tr>
          <?php } ?>
          <?php if ($text_align == "1"){ ?>
          <tr>
            <td><?php echo(getUebersetzung("Textausrichtung")); ?></td>
            <td><select name="text_align">
                <option value="left" <?php if (getFontVariant($style) == "left") echo(" selected"); ?>><?php echo(getUebersetzung("links")); ?></option>
                <option value="right" <?php if (getFontVariant($style) == "right") echo(" selected"); ?>><?php echo(getUebersetzung("rechts")); ?></option>
                <option value="center" <?php if (getFontVariant($style) == "center") echo(" selected"); ?>><?php echo(getUebersetzung("zentriert")); ?></option>
                <option value="justify" <?php if (getFontVariant($style) == "justify") echo(" selected"); ?>><?php echo(getUebersetzung("Blocksatz")); ?></option>
              </select></td>
            <td><?php 
			if (getFontVariant($style) == "left") { echo(getUebersetzung("links"));} 
			else if (getFontVariant($style) == "right") echo(getUebersetzung("rechts")); 
			else if (getFontVariant($style) == "center") echo(getUebersetzung("zentriert")); 
			else if (getFontVariant($style) == "justify") echo(getUebersetzung("Blocksatz")); 
			?></td>
          </tr>
          <?php } ?>
          <?php if ($color == "1"){ ?>
          <tr>
            <td><?php echo(getUebersetzung("Schriftfarbe")); ?></td>
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
            <td><?php echo(getUebersetzung("Rahmenstärke")); ?></td>
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
            <td><?php echo(getUebersetzung("Rahmenfarbe")); ?></td>
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
            <td><?php echo(getUebersetzung("Hintergrundfarbe")); ?></td>
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
            <td><?php echo(getUebersetzung("Höhe")); ?></td>
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
            <td><?php echo(getUebersetzung("Breite")); ?></td>
            <td><select name="width">
                <?php for ($i = 100; $i<=400; $i=$i+10){ ?>
                <option value="<?php echo(($i).("px")); ?>"<?php if (($i).("px") == getWidth($style)) echo(" selected"); ?>><?php echo(($i).(" px")); ?></option>
                <?php } ?>
              </select></td>
            <td><?php echo(getWidth($style)); ?></td>
          </tr>
		  <?php } ?>
        </table>
  <br/>
  <table>
  <tr>
    <td>
        <input type="submit" name="Submit4" value="<?php echo(getUebersetzung("ändern")); ?>"  class="button">
      </td>
  </tr>
  </form>
</table>
<?php 
include_once($root."/backoffice/templates/footer.inc.php");
?>