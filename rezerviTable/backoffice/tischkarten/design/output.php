<?php 
session_start();
$root = "../../..";
$ueberschrift = "Tischkarten bearbeiten";
/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

if ( isset( $_GET['tableCardId'] ) ) {

$tableCardId = $_GET['tableCardId'];

//include the pdf class:
require_once($root.'/include/fpdf153/fpdf.php');
include_once($root."/include/rdbmsConfig.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/sessionFunctions.inc.php");
include_once($root."/include/uebersetzer.inc.php");

$sprache = getSessionWert(SPRACHE);
$gastro_id = getSessionWert(GASTRO_ID);

//function to generate a table card:
include_once($root.'/include/tischkartenFunctions.inc.php');



//create a new pdf object:
$pageOrientation = getTableCardProperty(TC_PAGE_ORIENTATION,$tableCardId);
$measureUnit = getTableCardProperty(TC_MEASURE_UNIT,$tableCardId);
$dimension = getTableCardProperty(TC_DIMENSION,$tableCardId);
if ($dimension == TC_CUSTOM_FORMAT){
	$size = array();	
	$size[]= getTableCardProperty(TC_CUSTOM_FORMAT_Y,$tableCardId);
	$size[]= getTableCardProperty(TC_CUSTOM_FORMAT_X,$tableCardId);
}
else{
	$size = $dimension;
}

//create the pdf with constructor:
$pdf=new FPDF($pageOrientation,$measureUnit,$size);


$pdf->AddPage();
//raender setzen: $pdf->SetMargins(float left, float top [, float right])
$pdf->SetMargins(5.0, 5.0);
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
$pdf->SetFont('Arial','B',16);
//zelle ähnlich frame: Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, int fill [, mixed link]]]]]]])
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();

} //end if tableCardId exists
?>