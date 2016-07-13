<?php 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";
$unterschrift = "Sprachen";

/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

$sessId = session_id();
if (empty($sessId)){
	session_start();
}
include_once($root."/include/rdbmsConfig.inc.php");
include_once($root."/include/uebersetzer.inc.php");
include_once($root."/include/sessionFunctions.inc.php");
include_once($root."/include/cssFunctions.inc.php");

$sprache = getSessionWert(SPRACHE);
$gastro_id = getSessionWert(GASTRO_ID);


//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, $ueberschrift, "divEinstellungen/index.php",
							$unterschrift, "divEinstellungen/sprachen/sprachen.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/include/bildFunctions.inc.php");

$standardsprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
if ($standardsprache == false || $standardsprache == ""){
	$standardsprache = "en";
}
			
include_once($root."/backoffice/templates/components.inc.php"); 		
?>
<h2><?php echo(getUebersetzung("Ändern der angezeigten Sprachen")); ?></h2>

<table>
  	<form name="formname" action="" method="post" target="_self">
    <tr>
    	<td colspan="4"><?php echo(getUebersetzung("Markieren Sie die Sprachen")); ?>:</td>
  	</tr>
    <tr>
    	<td colspan="3"><?php echo(getUebersetzung("Vorhandene Sprache")); ?></td>
    	<td>
      		<?php echo(getUebersetzung("Standardsprache")); ?>
		</td>
		<td></td>
  	</tr>
  <?php
  //sprachen anzeigen die aktiviert sind: 
  	$res = getSprachen();
  	while($d = $res->FetchNextObject()){
  		$bezeichnung = $d->BEZEICHNUNG;
  		$spracheID   = $d->SPRACHE_ID;
  		$aktiviert   = isSpracheOfVermieterActiv($spracheID,$gastro_id);       
    ?>  
  <tr>
    <td><input name="<?php echo($spracheID); ?>" type="checkbox" id="<?php echo($spracheID); ?>" value="<?php echo($spracheID); ?>" 
    	<?php if($aktiviert){ echo(" checked"); } ?>><?php 
		$bilder_id = getBilderIDOfSpracheID($spracheID);
		if (!empty($bilder_id)){ 
			$width_pic = getBildBreite($bilder_id);
			$height_pic= getBildHoehe($bilder_id); 	?>
			<img src="<?php echo $root."/templates/picture.php?bilder_id=".$bilder_id ?>" 
				width="<?php echo $width_pic ?>" 
				height="<?php echo $height_pic ?>"/><?php
		}?>
	</td>    
    <td colspan="2"><?php echo(getUebersetzung($bezeichnung)); ?></td>
    <td align="middle">
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
    <td>
 	 	<input name="save" 
 	 			type="submit" class="button" id="save" 
		 		onclick="javascript:go('./sprachenAendern.php')"
		 		value="<?php echo(getUebersetzung("Speichern")); ?>">
	</td>
	<td><?php 
		$message = getUebersetzung("Wollen Sie die ausgewählten Sprachen wirklich löschen?"); 
		?>
		<input name="loeschen" type="hidden" value="true">	
		<input type="submit" name="loeschen" class="button" 
				onclick="javascript:del('<?php echo $message ?>','./spracheEntfernen.php')"
				value="<?php echo(utf8_encode(getUebersetzung("loeschen"))); ?>"/>		
	</td></form>
	<form action="./spracheHinfuegen.php" method="post" name="spracheHinfuegen" target="_self">
	<td>
		<input type="submit" name="hinfuegen" class="button" 
			value="<?php echo(utf8_encode(getUebersetzung("hinfuegen"))); ?>"/>						
	</td></form>
  </tr>
</table>
<?php 	  
include_once($root."/backoffice/templates/footer.inc.php");
?>

<script  language="JavaScript" type="text/JavaScript">  
	function go(url)   {  
        formname.action=url;  
        formname.submit();  
  	}   
	function del(message, url){  
		if(confirm(message)){  
			formname.action=url;
        	formname.submit();  
		}else{
			formname.action=url+"?status=false";
        	formname.submit();  
		}
	}   
</script> 
