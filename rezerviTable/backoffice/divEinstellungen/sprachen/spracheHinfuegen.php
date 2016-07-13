<?php 
$root = "../../..";
$ueberschrift = "Diverse Einstellungen";
$unterschrift = "Sprachen";
$unterschrift1 = "Hinfügen";
/*
 * Created on 17.10.2007
 * Autor: LI Haitao
 * Company: Alpstein-Austria
 * Entfernung einer Sprach
 *  
 */

include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, $ueberschrift, "divEinstellungen/index.php",
							$unterschrift, "divEinstellungen/sprachen/sprachen.php",
							$unterschrift1, "");
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php"); 
include_once($root."/include/uebersetzer.inc.php");
?>
<h2><?php echo(getUebersetzung("Eine neue Sprache hinfügen")); ?>.</h2>
	<form action="./spracheSpeichern.php" method="post" target="_self" name="spracheSpeichern" enctype="multipart/form-data"> 
	<table>
		<tr>
			<td><?php echo getUebersetzung("Sprache ID") ?></td> 	  	  		  	
			<td>
		  		<input type="text" name="spracheID" value=""/>
			</td> 
	  	</tr>  
		<tr>
			<td><?php echo getUebersetzung("Bezeichnung") ?></td> 	  	  		  	
		  	<td>
		  		<input type="text" name="bezeichnung" value=""/>
			</td> 
	  	</tr> 
		<tr>
			<td colspan="2"><hr/></td>
		</tr>
		<tr>
	    	<td><?php echo getUebersetzung("Fahne") ?></td>
		    <td>
		    	<input name="bild" type="file"/>
		    </td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
		  	<td>
		  		<?php showSubmitButton(getUebersetzung("Speichern")); ?>
		  	</td> 
			</form>	   		  		  	
		  	<form action="sprachen.php" method="post" name="sprachen" target="_self">
			<td>
				<?php showSubmitButton(getUebersetzung("Abbrechen")); ?>						
			</td></form>
		</tr> 
	</table>  
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>