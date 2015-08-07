<?  
$root = "../../.."; 
$ueberschrift = "Tischkarten bearbeiten";
$unterschrift = "Übersicht";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");;
$breadcrumps = erzeugenBC($root, "Tischkarten", "tischkarten/index.php",
							$unterschrift, "tischkarten/resUebersicht/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php"); 
include_once($root."/include/datumFunctions.inc.php");

if (isset($_POST["tag"]) ){
	$tag = $_POST["tag"];
}else{
	$tag =  getTodayDay();
}
if (isset($_POST["monate"])){
	$monate = $_POST["monate"];
}else{
	$monate = getTodayMonth();	
}
if (isset($_POST["jahr"])){
	$jahr = $_POST["jahr"];
}else{
	$jahr =  getTodayYear();
}
$startdatumDP = $tag."/".$monate."/".$jahr;
?>
<script type="text/javascript" src="<?= $root ?>/templates/calendarDateInput.inc.php?root=<?= $root ?>">
	/***********************************************
	* Jason's Date Input Calendar- By Jason Moon http://www.jasonmoon.net/
	* Script featured on and available at http://www.dynamicdrive.com
	* Keep this notice intact for use.
	***********************************************/	
</script>
<h2><?= getUebersetzung("Übersicht drucken") ?></h2>
<table>	  	
  <tr>
	<form action="./uebersicht.php" method="post" target="_self"> 	
    	<td><script>DateInput('date2', false, 'DD/MM/YYYY','<?= $startdatumDP  ?>')</script></td>
	  	<td>
	  		<?php showSubmitButton(getUebersetzung("drucken")); ?>
	  	</td>	  	
	  	<td>
	  		<?= getUebersetzung("Reservierungsübersicht für das ausgewählte Datum drucken") ?>
	  	</td> 
  	</form> 	
  </tr>	  	  
</table>

<?php 
include_once($root."/backoffice/templates/footer.inc.php");
?>