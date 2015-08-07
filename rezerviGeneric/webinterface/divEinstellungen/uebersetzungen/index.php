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

<p class="<?= STANDARD_SCHRIFT_BOLD ?>">
	<?php echo(getUebersetzung("�ndern der angezeigten �bersetzungen")); ?>.
</p>
<form action="./uebersetzungAendern.php" method="post" target="_self">
<table  border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td><?php echo(getUebersetzung("W�hlen sie die Sprache die sie �ndern wollen")); ?>:</td>
  </tr>
  <tr>
	  <td>
	  	<select type="select" name="changeSprache">
		    <?php
		    //sprachen anzeigen die aktiviert sind: 
		  	$res = getActivtedSprachenOfVermieter($vermieter_id);
		  	while($d = mysql_fetch_array($res)){
		  		$bezeichnung = $d["BEZEICHNUNG"];
		  		$spracheID   = $d["SPRACHE_ID"];       
		    ?>  
			<option value="<?= $spracheID ?>"><?= getUebersetzung($bezeichnung); ?></option>
			<?php
		  	}
		  	?> 
	  	</input>
	  </td>
  </tr> 
  <tr>
    <td>
    <br/>
 	 <?php 
	  showSubmitButton(getUebersetzung("�ndern"));
	?>
	</td>
  </tr>
</table>
</form>
<br/>
<?php 
	  //-----buttons um zur�ck zum menue zu gelangen: 
	  showSubmitButtonWithForm("../index.php",getUebersetzung("zur�ck"));
	  
include_once($root."/webinterface/templates/footer.inc.php");
?>