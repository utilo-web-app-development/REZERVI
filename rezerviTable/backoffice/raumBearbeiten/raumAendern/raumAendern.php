<?php  
$root = "../../.."; 
$ueberschrift = "Raum bearbeiten";
$unterschrift = "Ändern";

/*   
	date: 23.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");


//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/bildFunctions.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
$standardsprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
if ($standardsprache == false || $standardsprache == ""){
	$standardsprache = "en";
}

$raum_id = $_POST["raum_id"];

if (!isset($fehler) || $fehler != true){		
	$bez_mietobj= getRaumBezeichnung($raum_id);
	$bes_mietobj = getRaumBeschreibung($raum_id);
}
else{
	$bez_mietobj=$defaultBezeichnung;
	$bes_mietobj=$defaultBeschreibung;
}

include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Raum", "raumBearbeiten/index.php",
								$unterschrift, "raumBearbeiten/raumAendern/index.php",
								$bez_mietobj, "");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 	
?>
<h2><?php echo(getUebersetzung("Raum ändern")); ?></h2>
<form action="./raumAendernDurchfuehren.php" method="post" 
	name="raumAendernDurchfuehren" target="_self" enctype="multipart/form-data">
  <table>
    <tr>
      <td colspan="2"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
          <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden")); ?>! </td>      
    </tr>
    <tr> 
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <?php
    $res = getActivtedSprachenOfVermieter($gastro_id);
    while ($d = $res->FetchNextObject()){
    	$sprache_id = $d->SPRACHE_ID;
    	$bezeichnung= $d->BEZEICHNUNG;
       	if (empty($bez_mietobj) && !empty($_POST["bezeichnung_".$sprache_id])){
    		$bez_mietobj = $_POST["bezeichnung_".$sprache_id];
    	}
    	$bez= getUebersetzungGastro($bez_mietobj,$sprache_id,$gastro_id); 
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
	   <td><input name="bezeichnung_<?php echo $sprache_id ?>" type="text" value="<?php echo $bez ?>" maxlength="255">
	   	  <?php if ($standardsprache == $sprache_id){ ?>
	      	*
	      <?php } ?>
	   </td>
	</tr>
	<?php
    }
	?>	    
    <tr> 
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <?php
    $res = getActivtedSprachenOfVermieter($gastro_id);
    while ($d = $res->FetchNextObject()){
    	$sprache_id = $d->SPRACHE_ID;
    	$bezeichnung= $d->BEZEICHNUNG;
    	if (empty($bes_mietobj) && !empty($_POST["beschreibung_".$sprache_id])){
    		$bes_mietobj = $_POST["beschreibung_".$sprache_id];
    	}
    	$bes= getUebersetzungGastro($bes_mietobj,$sprache_id,$gastro_id); 
    ?>
	    <tr> 
	      <td><?php echo(getUebersetzung("Beschreibung")); ?> 
	      (<?php echo(getUebersetzung($bezeichnung)); ?>)<br/>	       
	      <?php if ($standardsprache != $sprache_id){ ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.")); ?>)
	      <?php
	      	}
	      ?></td>
	      <td><textarea name="beschreibung_<?php echo $sprache_id ?>"><?php echo $bes ?></textarea></td>
	    </tr>
	<?php
    }
	?>	    
    <tr> 
      <td height="10" colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2">
      	<!-- bild ausgeben -->
      	<?php 
      		$bilder_id = getBildOfRaum($raum_id); 
      		$width_pic = getBildBreite($bilder_id);
      		$height_pic= getBildHoehe($bilder_id);
      	?>
      	<img src="<?php echo $root."/templates/picture.php?bilder_id=".$bilder_id ?>" 
      		width="<?php echo $width_pic/$height_pic*200 ?>" 
      		height="<?php echo 200 ?>"/>
      </td>
    </tr>
    <tr>
    	<td><?php echo getUebersetzung("Bild des Raumes") ?></td>
    	<td><input name="bild" type="file"/></td>
    </tr>
    <tr> 
      <td colspan="2">
        <input name="raum_id" type="hidden" id="raum_id" value="<?php echo($raum_id); ?>">
        <input name="Submit" type="submit" id="Submit" class="button" 
       		value="<?php echo(getUebersetzung("Ändern")); ?>"></td>
    </tr>
    </form>
  </table>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>
