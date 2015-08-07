<?  
$root = "../.."; 
$ueberschrift = "Tischkarten bearbeiten";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Tischkarten", "tischkarten/index.php");
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
<table>
	<tr height="30">
    	<td><a href="<?=$root ?>/backoffice/tischkarten/design/index.php"><?php echo(getUebersetzung("Tischkarten Design")); ?></a></td>
    	<td> - </td>
    	<td><?= getUebersetzung("Design der Tischkarten festlegen") ?>.</td>
	</tr>
	<tr height="30">
	    <td><a href="<?=$root ?>/backoffice/tischkarten/print/index.php"><?= getUebersetzung("Tischkarten drucken") ?></a></td>
    	<td> - </td>
	    <td><?= getUebersetzung("Tischkarten für das ausgewählte Datum drucken") ?>.</td>
	</tr>
	<tr height="30">
	    <td><a href="<?=$root ?>/backoffice/tischkarten/resUebersicht/index.php"><?= getUebersetzung("Übersicht drucken") ?></a></td>
    	<td> - </td>
	    <td><?= getUebersetzung("Reservierungsübersicht für das ausgewählte Datum drucken") ?>.</td>
	</tr>
</table>
<?php 
include_once($root."/backoffice/templates/footer.inc.php");
?>