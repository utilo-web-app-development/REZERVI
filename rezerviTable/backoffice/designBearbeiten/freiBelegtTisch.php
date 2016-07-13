<?php 
$root = "../..";
$ueberschrift = "Design bearbeiten";
$unterschrift = "Ändern der Symbole für freie und belegte Tische";

/**   
	@date: 31.07.2007
	@author: coster alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");	
$breadcrumps = erzeugenBC($root, "Design", "designBearbeiten/index.php",
							$unterschrift, "designBearbeiten/freiBelegtTisch.php");		
include_once($root."/backoffice/templates/bodyStart.inc.php"); 		
include_once($root."/backoffice/templates/components.inc.php");
include_once($root."/include/bildFunctions.inc.php");  

$breite =   getGastroProperty(MAX_BILDBREITE_BELEGT_FREI,$gastro_id);
$hoehe =    getGastroProperty(MAX_BILDHOEHE_BELEGT_FREI,$gastro_id);
$freiPic =  getBildWithMarker(SYMBOL_TABLE_FREE);
$belegtPic =getBildWithMarker(SYMBOL_TABLE_OCCUPIED);
$width_pic_frei = getBildBreite($freiPic);
$height_pic_frei= getBildHoehe($freiPic); 
$width_pic_occu = getBildBreite($belegtPic);
$height_pic_occu= getBildHoehe($belegtPic); 

?>

<h2><?php echo(getUebersetzung($unterschrift)); ?></h2>
<br/>
<table>
  <form action="./freiBelegtAendern.php" method="post" target="_self" enctype="multipart/form-data">
    <tr>
    	<td></td>
    	<td><?php echo getUebersetzung("Maximale Breite für Symbole") ?>*:</td>
    	<td><input name="breite" type="text" value="<?php echo $breite ?>" /> Pixel</td>
    </tr>
     <tr>
    	<td></td>
    	<td><?php echo getUebersetzung("Maximale Höhe für Symbole") ?>*:</td>
    	<td><input name="hoehe" type="text" value="<?php echo $hoehe ?>"/> Pixel</td>
    </tr>     
    <tr>
    	<td>
    		<img src="<?php echo $root."/templates/picture.php?bilder_id=".$freiPic ?>" 
      			width="<?php echo $width_pic_frei ?>" 
      			height="<?php echo $height_pic_frei ?>"/>
      	</td>
    	<td><?php echo getUebersetzung("Symbol für \"Tisch frei\"") ?>:</td>
    	<td><input name="frei" type="file"/></td>
    </tr>
    <tr>
    	<td>
    		<img src="<?php echo $root."/templates/picture.php?bilder_id=".$belegtPic ?>" 
      			width="<?php echo $width_pic_occu ?>" 
      			height="<?php echo $height_pic_occu ?>"/>
      	</td>
    	<td><?php echo getUebersetzung("Symbol für \"Tisch belegt\"") ?>:</td>
    	<td><input name="belegt" type="file"/></td>
    </tr> 
    <tr>
    	<td colspan="2">
    	<?php 
	 		showSubmitButton(getUebersetzung("speichern"));
		?>
		</td>
    </tr>   
  </form>
</table>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>