<?php 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";
$unterschrift = "Übersetzungen";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, $ueberschrift, "divEinstellungen/index.php",
							$unterschrift, "divEinstellungen/uebersetzungen/index.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 

$standardsprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
if ($standardsprache == false || $standardsprache == ""){
	$standardsprache = "en";
}
			
include_once($root."/backoffice/templates/components.inc.php"); 		
?>
<h2><?php echo(getUebersetzung("Ändern der angezeigten Übersetzungen")); ?>.</h2>
<form action="./uebersetzungAendern.php" method="post" target="_self">
<table>
  <tr>
    <td><?php echo(getUebersetzung("Wählen sie die Sprache die sie ändern wollen")); ?>:</td>
  </tr>
  <tr>
	  <td>
	  	<select type="select" name="changeSprache">
		    <?php
		    //sprachen anzeigen die aktiviert sind: 
		  	$res = getActivtedSprachenOfVermieter($gastro_id);
		  	while($d = $res->FetchNextObject()){
		  		$bezeichnung = $d->BEZEICHNUNG;
		  		$spracheID   = $d->SPRACHE_ID;       
		    ?>  
			<option value="<?php echo $spracheID ?>"><?php echo getUebersetzung($bezeichnung); ?></option>
			<?php
		  	}
		  	?> 
	  	</input>
	  </td>
  </tr> 
  <tr>
    <td>
 	 <?php 
	  showSubmitButton(getUebersetzung("Ändern"));
	?>
	</td>
  </tr>
</form>
</table>
<?php	  
include_once($root."/backoffice/templates/footer.inc.php");
?>