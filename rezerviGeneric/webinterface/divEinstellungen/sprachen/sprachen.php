<? $root = "../../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 

$standardsprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
if ($standardsprache == false || $standardsprache == ""){
	$standardsprache = "en";
}
			
include_once($root."/webinterface/templates/components.inc.php"); 		
?>

<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Ändern der angezeigten Sprachen")); ?>.</p>
<br/>
<table  border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
  <form action="./sprachenAendern.php" method="post" target="_self">
    <tr>
    	<td colspan="3"><?php echo(getUebersetzung("Markieren sie die Sprachen, die auf ihrem Belegungsplan zur Auswahl angeboten werden sollen")); ?>:</td>
  	</tr>
    <tr>
    <td colspan="2"><?php echo(getUebersetzung("Sprache")); ?></td>
    <td>
      <?php echo(getUebersetzung("Standardsprache")); ?>
	</td>
  </tr>
  <?php
  //sprachen anzeigen die aktiviert sind: 
  	$res = getSprachen();
  	while($d = mysql_fetch_array($res)){
  		$bezeichnung = $d["BEZEICHNUNG"];
  		$spracheID   = $d["SPRACHE_ID"];
  		$aktiviert   = isSpracheOfVermieterActiv($spracheID,$vermieter_id);       
    ?>  
  <tr>
    <td><input name="<?php echo($spracheID); ?>" type="checkbox" id="<?php echo($spracheID); ?>" value="<?php echo($spracheID); ?>" 
    	<?php if($aktiviert){ echo(" checked"); } ?>></td>
    <td><?php echo(getUebersetzung($bezeichnung)); ?></td>
    <td>
      <input type="radio" name="standard" value="<?php echo($spracheID); ?>"
      <?php
      	if ($standardsprache == $spracheID){
      		echo("checked=\"checked\"");
      	}
      ?>
      >
	</td>
  </tr>
	<?php
  	}
  	?>  
  <tr>
    <td colspan="3">
 	 <?php 
	  showSubmitButton(getUebersetzung("Ändern"));
	?>
	</td>
  </tr>
  </form>
</table>
<br/>
<?php 
	  //-----buttons um zurück zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zurück"));
	  
include_once($root."/webinterface/templates/footer.inc.php");
?>