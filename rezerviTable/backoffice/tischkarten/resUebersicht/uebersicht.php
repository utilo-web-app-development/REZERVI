<?php 
$root = "../../.."; 
$ueberschrift = "Tischkarten bearbeiten";

/*
 * Created on 24.09.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria
 * Erzeugung die Liste der Reservierung für die Verwalter
 *  
 */
 
function createPage($pdf, $d, $sprache, $gastro_id, $date, $cellWidth, $cellHigh){
	$gast_id = $d->GAST_ID;
	$gast = getMieterVorname($gast_id)." ".getNachnameOfMieter($gast_id);
	$pdf->Cell($cellWidth, $cellHigh, $gast, "LR");
		
	$tisch_id = $d->TISCH_ID;
	$raum_id = getRaumOfTisch($tisch_id);
	$position = getRaumBezeichnung($raum_id)."/".getUebersetzungGastro("Tisch",$sprache,$gastro_id)." ".$tisch_id;
	$position = utf8_decode($position);
	$pdf->Cell($cellWidth, $cellHigh, $position, "LR");
	
	$zeitraum = getYearFromBooklineDate($date)."-".getMonthFromBooklineDate($date)."-".getDayFromBooklineDate($date)." ".getHourFromBooklineDate($date).":"." ".getMinuteFromBooklineDate($date)
				." ".getUebersetzungGastro("bis",$sprache,$gastro_id)." ";
	$pdf->Cell($cellWidth, $cellHigh, $zeitraum, "LR", 1);	
	return $pdf;
}

$sessId = session_id();
if (empty($sessId)){
	session_start();
}

require_once($root.'/include/fpdf153/fpdf.php');
include_once($root."/include/rdbmsConfig.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/sessionFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/uebersetzer.inc.php");


$choice_date = $_POST["date2"];
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
	$nachricht = getUebersetzung("Keine Reservierung in diesem Zeitram vorhanden")."!"; 
	include_once("./index.php");
	exit;
}else{
	$cellHigh = 10;
	$cellWidth = 60; 
	$pageWidth = 180;
	
	$pdf=new FPDF("P", "mm", "A4");
	$pdf->SetCreator("Aplstein");
	$pdf->Open();
	$pdf->AddPage();
	
	$pdf->SetFont("Arial", "", 14);
	$pdf->Cell($pageWidth, $cellHigh, getUebersetzungGastro("Gastro_ID",$sprache,$gastro_id)." ".$gastro_id, 0, 1, "C");
	
	$pdf->SetFont("Arial", "", 10);
	$pdf->Cell($pageWidth, $cellHigh, getUebersetzungGastro("Reservierung",$sprache,$gastro_id)." ".getUebersetzungGastro("Liste",$sprache,$gastro_id), 1, 1, "C");
	$pdf->Cell($cellWidth, $cellHigh, getUebersetzungGastro("Gast",$sprache,$gastro_id).getUebersetzungGastro("Name",$sprache,$gastro_id), 1, 0, "C");
	$pdf->Cell($cellWidth, $cellHigh, getUebersetzungGastro("Raum",$sprache,$gastro_id)."/".getUebersetzungGastro("Tisch",$sprache,$gastro_id), 1, 0, "C");
	$pdf->Cell($cellWidth, $cellHigh, getUebersetzungGastro("Uhrzeit",$sprache,$gastro_id), 1, 1, "C");
	
	
	
	$pdf->Cell($pageWidth, $cellHigh, getUebersetzungGastro(utf8_decode("bestätigt"),$sprache,$gastro_id), 1, 1);
	$res = getReservationsOfVermieter($gastro_id, STATUS_BELEGT);
	while($d = $res->FetchNextObject()){
		
		$reservierungs_id = $d->RESERVIERUNG_ID;
		$date = getDatumVonOfReservierung($reservierungs_id);
		$year = getYearFromBooklineDate($date);
		$month = getMonthFromBooklineDate($date);
		$day = getDayFromBooklineDate($date);
		if($choice_date == null){
			$pdf = createPage($pdf, $d, $sprache, $gastro_id, $date, $cellWidth, $cellHigh);
		}else if($choice_date == $day."/".$month."/".$year){
			$pdf = createPage($pdf, $d, $sprache, $gastro_id, $date, $cellWidth, $cellHigh);
		}
	}
	
	$pdf->Cell($pageWidth, $cellHigh, getUebersetzungGastro("offen",$sprache,$gastro_id), 1, 1);
	$res = getReservationsOfVermieter($gastro_id,STATUS_RESERVIERT);
	while($d = $res->FetchNextObject()){
			
		$reservierungs_id = $d->RESERVIERUNG_ID;
		$date = getDatumVonOfReservierung($reservierungs_id);
		$year = getYearFromBooklineDate($date);
		$month = getMonthFromBooklineDate($date);
		$day = getDayFromBooklineDate($date);
		if($choice_date == null){
			$pdf = createPage($pdf, $d, $sprache, $gastro_id, $date, $cellWidth, $cellHigh);
		}else if($choice_date == $day."/".$month."/".$year){		
			$pdf = createPage($pdf, $d, $sprache, $gastro_id, $date, $cellWidth, $cellHigh);
		}
	}
	$pdf->Line($pdf->GetX(),$pdf->GetY(), $pdf->GetX()+180, $pdf->GetY());
	$pdf->Output();
}
?>

