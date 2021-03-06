<?php 
$root = "../..";
$ueberschrift = "Design Bearbeiten";
$unterschrift = "Stile ändern";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/cssFunctions.inc.php"); 

$hintergrund = false;
$font_family = false;
$font_size = false;
$font_style = false;
$font_weight = false;
$text_align = false;
$color = false;
$border = false;
$border_color = false;
$background_color = false;
$height = false;
$width = false;
$stylesheet = false;

if (isset($_POST["hintergrund"])){
	$hintergrund = $_POST["hintergrund"];
}
if (isset($_POST["font_family"])){
	$font_family = $_POST["font_family"];
}
if (isset($_POST["font_size"])){
	$font_size = $_POST["font_size"];
}
if (isset($_POST["font_style"])){
	$font_style = $_POST["font_style"];
}
if (isset($_POST["font_weight"])){
	$font_weight = $_POST["font_weight"];
}
if (isset($_POST["text_align"])){
	$text_align = $_POST["text_align"];
}
if (isset($_POST["color"])){
	$color = $_POST["color"];
}
if (isset($_POST["border"])){
	$border = $_POST["border"];
}
if (isset($_POST["border_color"])){
	$border_color = $_POST["border_color"];
}
if (isset($_POST["background_color"])){
	$background_color = $_POST["background_color"];
}
if (isset($_POST["height"])){
	$height = $_POST["height"];
}
if (isset($_POST["width"])){
	$width = $_POST["width"];
}
if (isset($_POST["stylesheet"])){
	$stylesheet = $_POST["stylesheet"];
}
include_once("./stylesHelper.php");

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
setStyle($stylesheet,trim($style),$gastro_id);					
$info = true;
$nachricht = "Das Design des ausgewählen Elementes wurde erfolgreich geändert!";
include_once("./styles.php");
?>