<? 
$root = "../../..";
$ueberschrift = "Tisch bearbeiten";
$unterschrift = "Ändern";

/*   
	date: 23.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/templates/constants.inc.php"); 

//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/bildFunctions.inc.php");
$standardsprache = getGastroProperty(STANDARDSPRACHE,$gastro_id);
if ($standardsprache == false || $standardsprache == ""){
	$standardsprache = "en";
}

$tisch_id = $_POST["tisch_id"];

if (!isset($fehler) || $fehler != true){		
	$bez_mietobj= $tisch_id;
	$bes_mietobj = getTischBeschreibung($tisch_id);
	$minimaleBelegung = getMinimaleBelegungOfTisch($tisch_id);
	$maximaleBelegung = getMaximaleBelegungOfTisch($tisch_id);
	$status = getStatusOfTisch($tisch_id);
	$gruppenname = getGruppeOfTisch($tisch_id);
}
else{
	$bez_mietobj=$defaultBezeichnung;
	$bes_mietobj=$defaultBeschreibung;
}

include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Tisch", "tischBearbeiten/index.php",
							$unterschrift, "tischBearbeiten/tischAendern/index.php",
							$bez_mietobj, "");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 	
?>

<form action="./tischAendernDurchfuehren.php" method="post" name="tischAendernDurchfuehren" target="_self" enctype="multipart/form-data">
  <table>
    <h2><?php echo(getUebersetzung("Tisch bearbeiten")); ?></h2>
    <tr>
      <td colspan="2"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
          	<?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden")); ?>!</td>      
    </tr>
    <tr> 
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <?php
    $res = getActivtedSprachenOfVermieter($gastro_id);
    while ($d = $res->FetchNextObject()){
    	$sprache_id = $d->SPRACHE_ID;
    	$bezeichnung= $d->BEZEICHNUNG;
    	$bez= getUebersetzungGastro($bez_mietobj,$sprache_id,$gastro_id); 
    ?>
	<tr> 
	  <td><?php echo(getUebersetzung("Bezeichnung des Tisches")); ?> 
	  	   (<?php echo(getUebersetzung($bezeichnung)); ?>) 
	      <br/>	       
	      <?php if ($standardsprache != $sprache_id){ ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.")); ?>)
	      <?php
	      	}
	      ?>
	      </td>
	   <td><input name="bezeichnung_<?= $sprache_id ?>" type="text" value="<?= $bez ?>" maxlength="255">
	   	  <?php if ($standardsprache == $sprache_id){ ?>
	      	*
	      <?php } ?>
	   </td>
	</tr>
	<?php
    }
	?>	    
    <tr> 
      <td height="20" colspan="2">&nbsp;</td>
    </tr>
    <?php
    $res = getActivtedSprachenOfVermieter($gastro_id);
    while ($d = $res->FetchNextObject()){
    	$sprache_id = $d->SPRACHE_ID;
    	$bezeichnung= $d->BEZEICHNUNG;
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
	      <td><textarea name="beschreibung_<?= $sprache_id ?>"><?= $bes ?></textarea></td>
	    </tr>
	<?php
    }
	?>	    
    <tr> 
      <td><?php echo(getUebersetzung("Minimale Belegung")); ?></td>
      <td>
		  <select name="minimaleBelegung">
		    <?php for ($i = 1; $i<=100; $i++){
		    ?>
		    	<option value="<?= $i ?>" <?php if($i == $minimaleBelegung) { echo("selected='selected'"); } ?>><?= $i ?></option>
		    <?php
		    }
		    ?>
		  </select>  
      </td>
    </tr>
	<tr> 
      <td><?php echo(getUebersetzung("Maximale Belegung")); ?></td>
      <td>      	
		  <select name="maximaleBelegung">
		    <?php for ($i = 1; $i<=100; $i++){
		    ?>
		    	<option value="<?= $i ?>" <?php if($i == $maximaleBelegung) { echo("selected='selected'"); } ?>><?= $i ?></option>
		    <?php
		    }
		    ?>
		  </select>  
      </td>
    </tr>
	<tr> 
      <td><?php echo(getUebersetzung("Status")); ?></td>
      <td>      	
		  <select name="status">
		    <?php foreach ($status_array as $stat){
		    ?>
		    	<option value="<?= $stat ?>" <?php if($status == $stat) { 
		    		echo("selected='selected'"); } ?>><?= $stat ?>
		    	</option>
		    <?php
		    }
		    ?>
		  </select>  
      </td>
    </tr> 
	<?php /*     
	<tr> 
      <td><?php echo(getUebersetzung("Gruppe")); ?></td>
      <td>      	
		  <select name="gruppenname"><?php 
			$res = getGruppen($gastro_id);
   			while ($d = $res->FetchNextObject()){
   				$name = $d->GRUPPENBEZEICHNUNG;   ?>
		    	<option value="<?= $name ?>" <?php if($gruppenname == $name) { 
		    		echo("selected='selected'"); } ?>><?= $name ?>
		    	</option>    <?php
		    }    ?>
		  </select>  
      </td>
    </tr>    
    <tr> 
      <td height="10" colspan="2">&nbsp;</td>
    </tr>
	<tr> 
      <td colspan="2">
      	<!-- bild ausgeben -->
      	<?php 
      		$bilder_id = getBildOfTisch($tisch_id); 
      		$width_pic = getBildBreite($bilder_id);
      		$height_pic= getBildHoehe($bilder_id);
      	?>
      	<img src="<?= $root."/templates/picture.php?bilder_id=".$bilder_id ?>" 
      		width="<?= $width_pic/$height_pic*200 ?>" 
      		height="<?= 200 ?>"/>
      </td>
    </tr>
    <tr>
    	<td><?= getUebersetzung("Bild des Tisches") ?></td>
    	<td><input name="bild" type="file"/></td>
    </tr>
	*/ ?>
    <tr> 
      <td colspan="2">
        <input name="tisch_id" type="hidden" id="tisch_id" value="<?php echo($tisch_id); ?>">
        <input name="Submit" type="submit" id="Submit" class="button" value="<?php echo(getUebersetzung("Ändern")); ?>"></td>
    </tr>
  </table>
</form>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>
