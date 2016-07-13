<?php 
$root = "../../..";
$ueberschrift = "Tisch bearbeiten";
$unterschrift = "Anlegen";

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

if (!(isset($fehler) && $fehler != true)){
	$maximaleBelegung = 2;
	$minimaleBelegung = 1;
	$status = TISCH_BUCHBAR;
}

$raum_id = $_POST["raum_id"];
if(isset($_POST["minimaleBelegung"])){
	$minimaleBelegung = $_POST["minimaleBelegung"];
}
if(isset($_POST["maximaleBelegung"])){
	$maximaleBelegung = $_POST["maximaleBelegung"];
}
if(isset($_POST["status"])){
	$status = $_POST["status"];
}
if(isset($_POST["gruppenname"])){
	$gruppenname = $_POST["gruppenname"];
}else{
	$gruppenname = "";
}
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Tisch", "tischBearbeiten/index.php",
								$unterschrift, "tischBearbeiten/tischAnlegen/index.php",
								getUebersetzung("neuer Tisch"), "");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
?>
<form action="./tischEintragen.php" method="post" name="tischEintragen" target="_self" enctype="multipart/form-data">
  <table>
    <h2><?php echo(getUebersetzung("Einen neuen Tisch anlegen")); ?></h2>
    <tr>
      <td colspan="2"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
		  	<?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden")); ?>!</td>      
    </tr>
    <tr> 
      <td height="30" colspan="2">&nbsp;</td>
    </tr>   <?php
    $res = getActivtedSprachenOfVermieter($gastro_id);
    while ($d = $res->FetchNextObject()){
    	$sprache_id = $d->SPRACHE_ID;
    	$bezeichnung= $d->BEZEICHNUNG;    ?>
	<tr> 
	  <td><?php echo(getUebersetzung("Tischnummer")); ?> 
	  	   (<?php echo(getUebersetzung($bezeichnung)); ?>) 
	      <br/>	       
	      <?php if ($standardsprache != $sprache_id){ ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.")); ?>)
	      <?php
	      	}
	      ?>
	      </td>
	   <td><input name="bezeichnung_<?php echo $sprache_id ?>" type="text" value="" maxlength="255">
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
    	if (isset($_POST["bezeichnung_".$sprache_id])){
			$bezeichnung = $_POST["bezeichnung_".$sprache_id];
		}
		$beschreibung = "";
		if (isset($_POST["beschreibung_".$sprache_id])){
			$beschreibung =  $_POST["beschreibung_".$sprache_id];
		}
    ?>
	    <tr> 
	      <td><?php echo(getUebersetzung("Beschreibung")); ?> 
	      (<?php echo(getUebersetzung($bezeichnung)); ?>)<br/>	       
	      <?php if ($standardsprache != $sprache_id){ ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.")); ?>)
	      <?php
	      	}
	      ?></td>
	      <td><textarea name="beschreibung_<?php echo $sprache_id ?>"><?php echo $beschreibung ?></textarea></td>
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
		    	<option value="<?php echo $i ?>" <?php if($i == $minimaleBelegung) { echo("selected='selected'"); } ?>><?php echo $i ?></option>
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
		    	<option value="<?php echo $i ?>" <?php if($i == $maximaleBelegung) { echo("selected='selected'"); } ?>><?php echo $i ?></option>
		    <?php
		    }
		    ?>
		  </select>  
      </td>
    </tr>
	<tr> 
      <td><?php echo(getUebersetzung("Status")); ?></td>
      <td>      	
		  <select name="status">   <?php 
		  	foreach ($status_array as $stat){    ?>
		    	<option value="<?php echo $stat ?>" <?php if($status == $stat) { 
		    		echo("selected='selected'"); } ?>><?php echo $stat ?>
		    	</option>    <?php
		    }   ?>
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
		    	<option value="<?php echo $name ?>" <?php if($gruppenname == $name) { 
		    		echo("selected='selected'"); } ?>><?php echo $name ?>
		    	</option>    <?php
		    }    ?>
		  </select>  
      </td>
    </tr> 
 
    if(isset($bild_id) && !empty($bild_id)){ ?>    
    <tr> 
      <td height="10" colspan="2">&nbsp;</td>
    </tr>
    <tr> 
    <tr> 
      <td colspan="2">
      	<!-- bild ausgeben -->
      	<?php 
      		$width_pic = getBildBreite($bild_id);
      		$height_pic= getBildHoehe($bild_id);
      	?>
      	<img src="<?php echo $root."/templates/picture.php?bilder_id=".$bild_id ?>" 
      		width="<?php echo $width_pic/$height_pic*200 ?>" 
      		height="<?php echo 200 ?>"/>
      </td>
    </tr>
    <?php
    } 	   
    <tr>
    	<td><?php echo getUebersetzung("Bild des Tisches") ?></td>
	    <td><input name="bild" type="file"/></td>
    </tr>  
 */ 
	?> 
     <tr> 
      <td colspan="2">
      	<input type="hidden" name="raum_id" value="<?php echo $raum_id ?>"/>
  		<input name="Submit" type="submit" id="Submit" class="button" value="<?php echo(getUebersetzung("Speichern")); ?>"></td>
    </tr>
	</form> 
</table>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>