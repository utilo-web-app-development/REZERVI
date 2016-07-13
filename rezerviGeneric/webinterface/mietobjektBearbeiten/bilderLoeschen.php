<?php $root = "../..";

/*   
	date: 4.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/webinterface/templates/components.inc.php"); 
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
	    	return confirm('<?php echo(getUebersetzung("Bild wirklich löschen?")); ?>'); 	    
	    }
	    //-->
</script>

  <table border="0" cellpadding="0" cellspacing="3">
    <tr> 
      <td>
	  	<p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Bilder von Mietobjekten löschen")); ?><br/>
          </p>
      </td>
    </tr>
 	<tr>
		<td>
			<table cellpadding="0" cellspacing="2" border="0"  class="<?php echo STANDARD_SCHRIFT ?>">
			  <tr>
					<th><div align="left"><?php echo getUebersetzung("Bild") ?></div></th>
					<th><div align="left"><?php echo getUebersetzung("Mietobjekt") ?></div></th>
					<th><div align="center"><?php echo getUebersetzung("löschen") ?></div></th>
				</tr>
			<?php 
				$res = getAllPicturesFromVermieterWithLimit($vermieter_id,$limit,$index);
				while ($d=mysql_fetch_array($res)){
					$bilder_id = $d["BILDER_ID"];
					$bezeichnung = $d["BEZEICHNUNG"];
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
								value="<?php echo(getUebersetzung("Bild löschen")); ?>">
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
	  					showSubmitButton(getUebersetzung("zurückblättern"));
					?>
					</form>
				</td>
			<?php
			}
			if (($index + $limit) < getAnzahlBilderOfVermieter($vermieter_id)){
			?>
				<td><form action="./bilderLoeschen.php" method="post" name="weiter" target="_self" enctype="multipart/form-data">
					<input name="index" type="hidden" value="<?php echo($index+$limit); ?>"/>
					<?php 
	  					showSubmitButton(getUebersetzung("weiterblättern"));
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
	  //-----buttons um zurück zu gelangen: 
	  showSubmitButtonWithForm("./index.php",getUebersetzung("zurück"));
include_once($root."/webinterface/templates/footer.inc.php");
?>
