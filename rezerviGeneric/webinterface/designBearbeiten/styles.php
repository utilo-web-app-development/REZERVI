<?php $root = "../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/include/cssFunctions.inc.php"); 

if (isset($_POST["hintergrund"])){
	$hintergrund = $_POST["hintergrund"];
}
else{
	$hintergrund = false;
}
if (isset($_POST["font_family"])){
	$font_family = $_POST["font_family"];
}
else{
	$font_family = false;
}
if (isset($_POST["font_size"])){
	$font_size = $_POST["font_size"];
}
else{
	$font_size = false;
}
if (isset($_POST["font_style"])){
	$font_style = $_POST["font_style"];
}
else{
	$font_style = false;
}
if (isset($_POST["font_weight"])){
	$font_weight = $_POST["font_weight"];
}
else{
	$font_weight = false;
}
if (isset($_POST["text_align"])){
	$text_align = $_POST["text_align"];
}
else{
	$text_align = false;
}
if (isset($_POST["color"])){
	$color = $_POST["color"];
}
else{
	$color = false;
}
if (isset($_POST["border"])){
	$border = $_POST["border"];
}
else{
	$border = false;
}
if (isset($_POST["border_color"])){
	$border_color = $_POST["border_color"];
}
else{
	$border_color = false;
}
if (isset($_POST["background_color"])){
	$background_color = $_POST["background_color"];
}
else{
	$background_color = false;
}
if (isset($_POST["height"])){
	$height = $_POST["height"];
}
else{
	$height = false;
}
if (isset($_POST["width"])){
	$width = $_POST["width"];
}
else{
	$width = false;
}
if (isset($_POST["stylesheet"])){
	$stylesheet = $_POST["stylesheet"];
}
else{
	$stylesheet = false;
}

include_once("./stylesHelper.php");
			
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
	echo("--> \n");
	echo("</style> \n");
	
	//ueberschrift erzeugen:
	$designFuer = "";
	
	if ($stylesheet == UEBERSCHRIFT){
		$designFuer = "�berschrift";
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
		$designFuer = "f�rbige Tabelle";
	}
	else if ($stylesheet == BELEGT){
		$designFuer = "belegt";
	}
	else if ($stylesheet == FREI){
		$designFuer = "frei";
	}

	//uebersetzen:
	$designFuer = getUebersetzung($designFuer);
	
	//vorherigen style aus datenbank auslesen:
	$style = getStyle($stylesheet,$vermieter_id);
?>

<p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Design f�r")); ?> "<?php echo($designFuer); ?>" <?php echo(getUebersetzung("bearbeiten")); ?></p>
<br/>
<form action="styleAendern.php" method="post" name="styles" target="_self" id="styles">
  <input name="stylesheet" type="hidden" value="<?php echo($stylesheet); ?>">
	<table border="0" cellspacing="2" cellpadding="0" class="<?php echo TABLE_STANDARD ?>">
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
            <td><?php echo(getUebersetzung("Schriftgr�sse")); ?></td>
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
            <td><?php echo(getUebersetzung("Schriftst�rke")); ?></td>
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
			if (getFontVariant($style) == "left") echo(getUebersetzung("links")); 
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
            <td><?php echo(getUebersetzung("Rahmenst�rke")); ?></td>
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
            <td><?php echo(getUebersetzung("H�he")); ?></td>
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
  <table border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td>
        <input type="submit" name="Submit4" value="<?php echo(getUebersetzung("Design �ndern")); ?>" class="<?php echo BUTTON ?>" 
			onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?php echo BUTTON ?>';">
      </td>
  </tr>
</table>
<br/>
</form>
<table border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td>
	<form action="./index.php" method="post" name="form1" target="_self">
        <input type="submit" name="Submit3" value="<?php echo(getUebersetzung("zur�ck")); ?>" class="<?php echo BUTTON ?>" 
			onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?php echo BUTTON ?>';">
      </form>
    </td>
  </tr>
</table>
<?php 
include_once($root."/webinterface/templates/footer.inc.php");
?>