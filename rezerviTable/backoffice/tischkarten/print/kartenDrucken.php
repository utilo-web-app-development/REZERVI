<?php 
$root = "../../..";
$ueberschrift = "Tischkarten bearbeiten";

/*
 * Created on 30.11.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria
 * Ausgabe aller Tischkarten
 *  
 */
 
function createPage($pdf, $image_url, $zeitraum, $gastname, $headingText, $fontText,$fontTextStyle,$fontTextSize, $fontHeading,$fontHeadingStyle,$fontHeadingSize, $root, $x, $y) {			
	$pdf->AddPage();	
	$pdf->SetFont($fontHeading,$fontHeadingStyle,$fontHeadingSize);
	$pdf->Image($image_url,0,0,$x/3);
				
	$pdf->SetXY($x/3,0.0);
	$pdf->Cell(($x/3)*2,($y/4),$headingText);
	$pdf->SetFont($fontText,$fontTextStyle,$fontTextSize);
	$pdf->SetXY($x/3,$y/4+$fontTextSize); 
	$pdf->Cell(0,0,$gastname);	
	
	$pdf->SetXY($x/3,$y/4+1); 		
	$pdf->SetXY($x/3,$y/4+$fontTextSize*2); 			  
	$pdf->Cell(0,0,$zeitraum);
	return $pdf;
} //end function


$sessId = session_id();
if (empty($sessId)){
	session_start();
}
 
include_once($root."/include/rdbmsConfig.inc.php");
include_once($root.'/include/tischkartenFunctions.inc.php');
include_once($root."/include/sessionFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
require_once($root.'/include/fpdf153/fpdf.php');
include_once($root."/include/uebersetzer.inc.php");
include_once($root."/include/bildFunctions.inc.php");
include_once($root."/include/cssFunctions.inc.php");

$choice_date = $_POST["date1"];
$tag = substr($choice_date, 0, 2);
$monate = substr($choice_date, 3, 2);
$jahr = substr($choice_date, 6, 4);
$sprache = getSessionWert(SPRACHE);
$gastro_id = getSessionWert(GASTRO_ID);

$tischs = getAllTische($gastro_id);
$anzahlRes = 0;
while($tisch=$tischs->FetchNextObject()){
	$anzahlRes += countReservierungIDs($tisch->TISCHNUMMER,0,0,$tag,$monate,$jahr,59,23,$tag,$monate,$jahr);				
}
if($choice_date == null && hasVermieterReservations($gastro_id,  STATUS_BELEGT)){
	$anzahlRes = 1;
}
if($anzahlRes <= 0){
	$fehler = true;
	$nachricht = "Keine Reservierung an diesem Zeitram vorhanden";
	include_once("./index.php");
}else{
	$res = getTableCards();
	$tableCardId = $res->fields["TISCHKARTE_ID"];
	if ( isset( $tableCardId) ) {	
		
		$x = getTableCardProperty(TC_CUSTOM_FORMAT_X,$tableCardId); //Breite
		$y = getTableCardProperty(TC_CUSTOM_FORMAT_Y,$tableCardId); //Höhe
		$fontHeading = getTableCardProperty(TC_FONT_HEADING,$tableCardId); //Schriftart Überschrift
		$fontText = getTableCardProperty(TC_FONT_TEXT,$tableCardId); //Schriftart Text
		$fontTextStyle = getTableCardProperty(TC_FONT_TEXT_STYLE,$tableCardId); //Schriftstil Text
		$fontHeadingStyle = getTableCardProperty(TC_FONT_HEADING_STYLE,$tableCardId); //Schriftstil Überschrift
		$fontHeadingSize = getTableCardProperty(TC_FONT_HEADING_SIZE,$tableCardId); //Schriftgröße Überschrift
		$fontTextSize    = getTableCardProperty(TC_FONT_TEXT_SIZE,$tableCardId); //Schriftgröße Text"
		$headingText	 = getTableCardProperty(TC_HEADING_TEXT,$tableCardId); //Text Überschrift
		
			
		$r = getTableCard($tableCardId);
		$bild_id = $r->fields("BILDER_ID");	
		$image = getBild($bild_id)->fields("BILD"); //get Bild
		$temp_url = "/backoffice/tischkarten/print/_temp.jpg";
		$f_image= fopen($root.$temp_url, "w");
	 	fwrite($f_image,$image);
	  	fclose($f_image);
	
		
		$showName = getTableCardProperty(TC_TEXT_SHOW_NAME,$tableCardId); //Name anzeigen
		if ($showName == "true"){
			$showName = true;
		}else{
			$showName = false;
		}
		$showTime = getTableCardProperty(TC_TEXT_SHOW_TIME,$tableCardId); //Zeit anzeigen
		if ($showTime == "true"){
			$showTime = true;
		}else{
			$showTime = false;
		}
			
		$sprache = getSessionWert(SPRACHE);
		$gastro_id = getSessionWert(GASTRO_ID);
		
		
		//create a new pdf object:
		$pageOrientation = getTableCardProperty(TC_PAGE_ORIENTATION,$tableCardId);
		$measureUnit = getTableCardProperty(TC_MEASURE_UNIT,$tableCardId);
		$dimension = getTableCardProperty(TC_DIMENSION,$tableCardId);
	
		if ($dimension == TC_CUSTOM_FORMAT){
			$size = array();	
			$size[]= $y;$size[]= $x;		
		}else{
			$size = $dimension;
		}
		//create the pdf with constructor:
		$pdf=new FPDF($pageOrientation, $measureUnit, $size);
		if ($showName || $showTime){
			//get the confirmed booking
			$res = getReservationsOfVermieter($gastro_id, STATUS_BELEGT);
			while($d = $res->FetchNextObject()){
				
				$reservierungs_id = $d->RESERVIERUNG_ID;
					
				$gast_id = $d->GAST_ID;
				$gast = getMieterVorname($gast_id)." ".getNachnameOfMieter($gast_id);
				
				$date = getDatumVonOfReservierung($reservierungs_id);
				$year = getYearFromBooklineDate($date);
				$month = getMonthFromBooklineDate($date);
				$day = getDayFromBooklineDate($date);	
				if($choice_date == null){
					createPage($pdf,
							   $root.$temp_url,
							   getUebersetzungGastro("Zeit",$sprache,$gastro_id).": ".$year."-".$month."-".$day." ".getHourFromBooklineDate($date).":".getMinuteFromBooklineDate($date)." ".getUebersetzungGastro("bis",$sprache,$gastro_id)." ",
							   getUebersetzungGastro("Name",$sprache,$gastro_id).": ".$gast,
								$headingText, $fontText,$fontTextStyle,$fontTextSize, $fontHeading,$fontHeadingStyle,$fontHeadingSize, $root, $x, $y);
				}else if($choice_date == $day."/".$month."/".$year){
					createPage($pdf,
							   $root.$temp_url,
							   getUebersetzungGastro("Zeit",$sprache,$gastro_id).": ".$year."-".$month."-".$day." ".getHourFromBooklineDate($date).":".getMinuteFromBooklineDate($date)." ".getUebersetzungGastro("bis",$sprache,$gastro_id)." ",
							   getUebersetzungGastro("Name",$sprache,$gastro_id).": ".$gast,
								$headingText, $fontText,$fontTextStyle,$fontTextSize, $fontHeading,$fontHeadingStyle,$fontHeadingSize, $root, $x, $y);
				}
			}
		}	
		$pdf->Output();
	} //end if tableCardId exists
}
?>