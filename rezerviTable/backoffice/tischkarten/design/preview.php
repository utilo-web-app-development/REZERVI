<?php 
session_start();
$root = "../../..";
$ueberschrift = "Tischkarten bearbeiten";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria
	save or preview of a table card						
*/

if ( isset( $_GET['tableCardId'] ) ) {

//function to generate a table card:
include_once($root.'/include/tischkartenFunctions.inc.php');

$tableCardId = $_GET['tableCardId'];
$x = $_GET['x'];
$y = $_GET['y'];
$fontHeading = $_GET['font_heading'];
$fontText = $_GET['font_text'];
$fontTextStyle = $_GET['font_text_style'];
if ($fontTextStyle == TC_FONT_STYLE_NORMAL || empty($fontTextStyle)){
	$fontTextStyle = "";
}
$fontHeadingStyle = $_GET['font_heading_style'];
if ($fontHeadingStyle == TC_FONT_STYLE_NORMAL || empty($fontHeadingStyle)){
	$fontHeadingStyle = "";
}
$fontHeadingSize = $_GET['font_size_heading'];
$fontTextSize    = $_GET['font_size_text'];

$headingText	 = $_GET['heading_text'];

$showName = $_GET['show_name'];
if ($showName == "true"){
	$showName = true;
}
else{
	$showName = false;
}
$showTime = $_GET['show_time'];
if ($showTime == "true"){
	$showTime = true;
}
else{
	$showTime = false;
}

//include the pdf class:
require_once($root.'/include/fpdf153/fpdf.php');
include_once($root."/include/rdbmsConfig.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/sessionFunctions.inc.php");
include_once($root."/include/uebersetzer.inc.php");

$sprache = getSessionWert(SPRACHE);
$gastro_id = getSessionWert(GASTRO_ID);

//create a new pdf object:
$pageOrientation = getTableCardProperty(TC_PAGE_ORIENTATION,$tableCardId);
if (!$pageOrientation){
	//set default properties if 
	setTableCardDefaultProperties($tableCardId);
	$pageOrientation = getTableCardProperty(TC_PAGE_ORIENTATION,$tableCardId);
}
$measureUnit = getTableCardProperty(TC_MEASURE_UNIT,$tableCardId);
$dimension = getTableCardProperty(TC_DIMENSION,$tableCardId);

if ($dimension == TC_CUSTOM_FORMAT){
	$size = array();	
	//$size[]= getTableCardProperty(TC_CUSTOM_FORMAT_Y,$tableCardId);
	//$size[]= getTableCardProperty(TC_CUSTOM_FORMAT_X,$tableCardId);
	$size[]= $y;$size[]= $x;
	
}
else{
	$size = $dimension;
}

//create the pdf with constructor:
$pdf=new FPDF($pageOrientation,$measureUnit,$size);

$pdf->AddPage();
//raender setzen: $pdf->SetMargins(float left, float top [, float right])
//$pdf->SetMargins(5.0, 5.0);
//SetFont(string family [, string style [, float size]])
/*
# Courier (fixed-width)
# Helvetica or Arial (synonymous; sans serif)
# Times (serif) 
Font style. Possible values are (case insensitive):

    * empty string: regular
    * B: bold
    * I: italic
    * U: underline 
    * 
    * Font size in points. 
* */

$pdf->SetFont($fontHeading,$fontHeadingStyle,$fontHeadingSize);
//zelle ähnlich frame: Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, int fill [, mixed link]]]]]]])
$pdf->Image("./test.jpg",0,0,$x/3);
$pdf->SetXY($x/3,0.0); //1/3 einruecken 
$pdf->Cell(($x/3)*2,($y/4),$headingText);
$pdf->SetFont($fontText,$fontTextStyle,$fontTextSize);
if ($showName){
	$pdf->SetXY($x/3,$y/4+$fontTextSize); //1/3 einruecken, 1/4 von oben  
	$pdf->Cell(0,0,'Name: Max Muster');	
}
if ($showTime){
	$pdf->SetXY($x/3,$y/4+1); //1/3 einruecken, 1/4 von oben
	if ($showName){
		//zeilenumbruch:
		$pdf->SetXY($x/3,$y/4+$fontTextSize*2); //1/3 einruecken, 1/4 von oben
	}
	  
	$pdf->Cell(0,0,'Zeit: 20:00 Uhr');	
}
$pdf->Output();
} //end if tableCardId exists
?>