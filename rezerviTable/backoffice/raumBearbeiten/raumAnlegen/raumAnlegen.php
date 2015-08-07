<?  
$root = "../../.."; 

$standardsprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
if ($standardsprache == false || $standardsprache == ""){
	$standardsprache = "en";
}

?>
<h2><?php echo(getUebersetzung("Einen neuen Raum anlegen")); ?></h2>
<table>
 <form action="./raumEintragen.php" method="post" name="raumEintragen" 
	target="_self" enctype="multipart/form-data">
    <tr>
      <td colspan="2"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
		  <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden")); ?>!</td>      
    </tr>
    <?php
    $res = getActivtedSprachenOfVermieter($gastro_id);
    while ($d = $res->FetchNextObject()){
    	$sprache_id = $d->SPRACHE_ID;
    	$bezeichnung= $d->BEZEICHNUNG;
    ?>
	<tr> 
	  <td><?php echo(getUebersetzung("Bezeichnung des Raumes")); ?> 
	  	   (<?php echo(getUebersetzung($bezeichnung)); ?>) 
	      <br/>	       
	      <?php if ($standardsprache != $sprache_id){ ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.")); ?>)
	      <?php
	      	}
	      ?>
	      </td>
	   <td><input name="bezeichnung_<?= $sprache_id ?>" type="text" value="<?php
	   		if ( isset( $_POST["bezeichnung_".$sprache_id] ) ){
	   			echo( $_POST["bezeichnung_".$sprache_id] );
	   		}
	   ?>" maxlength="255">
	   	  <?php if ($standardsprache == $sprache_id){ ?>
	      	*
	      <?php } ?>
	   </td>
	</tr>
	<?php
    }
    $res = getActivtedSprachenOfVermieter($gastro_id);
    while ($d = $res->FetchNextObject()){
    	$sprache_id = $d->SPRACHE_ID;
    	$bezeichnung= $d->BEZEICHNUNG;
    ?>
	    <tr> 
	      <td><?php echo(getUebersetzung("Beschreibung")); ?> 
	      (<?php echo(getUebersetzung($bezeichnung)); ?>)<br/>	       
	      <?php if ($standardsprache != $sprache_id){ ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.")); ?>)
	      <?php
	      	}
	      ?></td>
	      <td><textarea name="beschreibung_<?= $sprache_id ?>"><?php
	   		if ( isset( $_POST["beschreibung_".$sprache_id] ) ){
	   			echo( $_POST["beschreibung_".$sprache_id] );
	   		}
	   	   ?></textarea></td>
	    </tr>
	<?php
    }
    if(isset($bild_id)){
	?>    
	<tr> 
      <td colspan="2">
      	<!-- bild ausgeben -->
      	<?php 
      		$width_pic = getBildBreite($bild_id);
      		$height_pic= getBildHoehe($bild_id);
      	?>
      	<img src="<?= $root."/templates/picture.php?bilder_id=".$bild_id ?>" 
      		width="<?= $width_pic/$height_pic*200 ?>" 
      		height="<?= 200 ?>"/>
      </td>
    </tr>
    <?php
    }
	?>    
    <tr>
    	<td colspan="2">
	    	<table><tr>
	    	<td><?= getUebersetzung("Bild des Raumes") ?></td>
	    	<td><input name="bild" type="file"/></td>
	    	</tr></table>
    	</td>
    </tr>  
     <tr> 
      <td colspan="2"><input name="Submit" type="submit" id="Submit" class="button" value="<?php echo(getUebersetzung("speichern")); ?>"></td>
    </tr>
	</form>	
  </table>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>