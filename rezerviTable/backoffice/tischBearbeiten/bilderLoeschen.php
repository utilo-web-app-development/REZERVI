<?php 
$root = "../..";
$ueberschrift = "Tisch bearbeiten";

/*   
	date: 4.10.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php"); 
include_once($root."/include/bildFunctions.inc.php"); 
include_once($root."/templates/constants.inc.php"); 

	$limit = 5; //limit wie viele bilder pro seite anzeigen
	if (isset($_POST["index"]) && $_POST["index"] != ""){
		$index = $_POST["index"];
	}
	else{
		$index = 0;
	}
			
?>


<script language="JavaScript">
	<!--
	    function sicher(){
	    	return confirm('<?php echo(getUebersetzung("Bild wirklich l�schen?")); ?>'); 	    
	    }
	    //-->
</script>

  <table border="0" cellpadding="0" cellspacing="3">
    <tr> 
      <td>
	  	<p class="standardschrift"><?php echo(getUebersetzung("Bilder von Mietobjekten l�schen")); ?><br/>
          </p>
      </td>
    </tr>
 	<tr>
		<td>
			<table cellpadding="0" cellspacing="2" border="0">
			  <tr>
					<th><div align="left"><?php echo getUebersetzung("Bild") ?></div></th>
					<th><div align="left"><?php echo getUebersetzung("Mietobjekt") ?></div></th>
					<th><div align="center"><?php echo getUebersetzung("l�schen") ?></div></th>
				</tr>
			<?php 
				$res = getAllPicturesFromVermieterWithLimit($gastro_id,$limit,$index);
				while ($d=$res->FetchNextObject()){
					$bilder_id = $d->BILDER_ID;
					$bezeichnung = $d->BEZEICHNUNG;
			?>
			  	  <tr>
					  <td><img src="<?php echo $root."/templates/picture.php?bilder_id=".$bilder_id ?>" /></td>
					  <td><?php echo($bezeichnung); ?></td> 
					  <td><form action="./bilderLoeschenDurchf.php" 
					  			method="post" name="zimmerloeschen<?php echo $bilder_id ?>" 
								target="_self" onSubmit="return sicher()" 
								enctype="multipart/form-data">
			  				<input type="hidden" name="bilder_id" value="<?php echo $bilder_id ?>"/>
			  				<input type="hidden" name="index" value="<?php echo($index); ?>"/>
			  				<input name="Submit" type="submit" id="Submit" class="<?php echo BUTTON ?>" 
								onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       							onMouseOut="this.className='<?php echo BUTTON ?>';"
								value="<?php echo(getUebersetzung("Bild l�schen")); ?>">
						 </form>
					  </td>
				  </tr>			
			<?php
			}
			?>
			  </table>
		</td>
    </tr>
	<tr> 
      <td>
		<table>
			<tr>
			<?php
			if (($index - $limit) > -1){
			?>
				<td>
					<form action="./bilderLoeschen.php" method="post" name="zurueck" target="_self" enctype="multipart/form-data">
					<input name="index" type="hidden" value="<?php echo($index-$limit); ?>"/>
					<?php 
	  					showSubmitButton(getUebersetzung("zur�ckbl�ttern"));
					?>
					</form>
				</td>
			<?php
			}
			if (($index + $limit) < getAnzahlBilderOfRaum($gastro_id)){
			?>
				<td><form action="./bilderLoeschen.php" method="post" name="weiter" target="_self" enctype="multipart/form-data">
					<input name="index" type="hidden" value="<?php echo($index+$limit); ?>"/>
					<?php 
	  					showSubmitButton(getUebersetzung("weiterbl�ttern"));
					?>
					</form>
				</td>
			<?php
			}
			?>
			</tr>
		</table>
      </td>
    </tr>
  </table>
<br/>
<?php 
	  //-----buttons um zur�ck zu gelangen: 
	  showSubmitButtonWithForm("./index.php",getUebersetzung("zurück"));
include_once($root."/backoffice/templates/footer.inc.php");
?>
