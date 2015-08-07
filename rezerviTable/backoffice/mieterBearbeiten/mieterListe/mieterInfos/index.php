<? 
$root = "../../../..";
$ueberschrift = "Gäste bearbeiten";
$unterschrift = "Gästeliste";
$unterschrift1= "Reservierungs-Info";

/*   
	date: 14.10.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");
include_once($root."/backoffice/templates/components.inc.php"); 

$gast_id = $_POST["mieter_id"];
$index = $_POST["index"];

if(!hasMieterReservations($gast_id)){
	$fehler = true;
	$nachricht = "Es liegen noch keine Reservierungen für den gewählten Mieter vor.";
	$_POST["root"] = $root;
	include_once($root."/backoffice/mieterBearbeiten/mieterListe/index.php");
	exit;
}

include_once($root."/backoffice/templates/breadcrumps.inc.php");;
$breadcrumps = erzeugenBC($root, "Gäste", "mieterBearbeiten/index.php",
							$unterschrift, "mieterBearbeiten/mieterListe/index.php",
							$unterschrift1, "");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
if(hasMieterReservations($gast_id)){
?>
<table>
	<tr>
		<td><?php echo(getUebersetzung("Es liegen folgende Reservierungen für den Gast vor")); ?>:
		</td>
	</tr>
</table>
<br/><br/>
<table class="moduletable_line">
  <tr>
	<td><?php echo(getUebersetzung("Reservierung von")); ?></td>
	<td><?php echo(getUebersetzung("bis")); ?></td>
	<td><?php echo(getUebersetzung("für")); ?></td>
  </tr>
	<!-- ausgeben der reservierungen: -->
	<?php
		$res = getReservationsOfMieter($gast_id);
		while($d = $res->FetchNextObject()){
			//variablen auslesen:
			$tisch_id =$d->TISCH_ID;
			$raum_id = getRaumOfTisch($tisch_id);
			$bezeichnung = getRaumBezeichnung($raum_id)." ".$tisch_id;
			$datumVon = getFormatedDateFromBooklineDate($d->VON);
			$datumBis = getFormatedDateFromBooklineDate($d->BIS);
	 ?>
              <tr>
                <td><?php echo($datumVon); ?></td>
                <td><?php echo($datumBis); ?></td>
                <td><?php echo($bezeichnung); ?></td>
  			  </tr>
		<?php 
			} //ende while
		?>
</table>
<?
}
include_once($root."/backoffice/templates/footer.inc.php");
?>