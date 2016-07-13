<?php 
$root = "../../..";
$ueberschrift = "Tischkarten bearbeiten";
$unterschrift = "Design";
/*   
	date: 26.9.05
	author: christian osterrieder alpstein-austria						
*/

//header einfuegen:
include_once($root."/backoffice/templates/header.inc.php");
include_once($root."/backoffice/templates/breadcrumps.inc.php");
$breadcrumps = erzeugenBC($root, "Tischkarten", "tischkarten/index.php",
							$unterschrift, "tischkarten/design/index.php");	
include_once($root."/backoffice/templates/bodyStart.inc.php"); 
include_once($root."/backoffice/templates/components.inc.php"); 
include_once($root."/include/tischkartenFunctions.inc.php");
include_once($root."/include/bildFunctions.inc.php");

//TODO: gastronomiebetrieb kann mehrere tischkarten haben
$res = getTableCards();
$tableCardId = $res->fields("TISCHKARTE_ID");
if (empty($tableCardId)){
	$tableCardId = constructTableCard();	
}

?>
<script type="text/javascript">

	function showPreview(tableCardId) {
		 
		var posLeft = 100;
		var posTop  = 100;
		var width = 500;
		var height= 500;
		
		var x = document.tableCard.x.value; 
		var y = document.tableCard.y.value;
		var font_heading = document.tableCard.font_heading.value;
		var font_text = document.tableCard.font_text.value;
		var font_heading_style = "";
		<?php foreach($available_font_styles as $key => $value){ ?>
			if(document.tableCard.font_heading_<?php echo $value ?>.checked){
				font_heading_style=font_heading_style+document.tableCard.font_heading_<?php echo $value ?>.value;
			}
	  	<?php } ?>
		var font_text_style = "";
		<?php foreach($available_font_styles as $key => $value){ ?>
		    if(document.tableCard.font_text_<?php echo $value ?>.checked){
				font_text_style=font_text_style+document.tableCard.font_text_<?php echo $value ?>.value;
			}
	  	<?php } ?>
	  	var font_size_text   = document.tableCard.font_size_text.value;
	  	var font_size_heading= document.tableCard.font_size_heading.value;
	  	
	  	var show_name = "false";
	  	if(document.tableCard.show_name.checked){
	  		show_name = "true";
	  	}
	  	var show_time = "false";
	  	if(document.tableCard.show_time.checked){
	  		show_time = "true";
	  	}	  	
	  	
	  	var heading_text = document.tableCard.textHeading.value;
		
		window.open("./preview.php?tableCardId="+tableCardId+"&x="+x+"&y="+y+"&font_text="+font_text+
					"&font_heading="+font_heading+"&font_heading_style="+font_heading_style+
					"&font_text_style="+font_text_style+"&font_size_text="+font_size_text+
					"&font_size_heading="+font_size_heading+"&heading_text="+heading_text+
					"&show_time="+show_time+"&show_name="+show_name,
					"",
					"toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=1,width="+(width)+",height="+(height)+",left="+posLeft+",top="+posTop+"");
		
	}

</script> 
	<form action="./save.php" method="post" target="_self" name="tableCard" enctype="multipart/form-data"> 
	<input type="hidden" name="tableCardId" value="<?php echo $tableCardId ?>"/>
		<table>
		  <tr>
		  	<td>
		  		<?php echo getUebersetzung("Breite") ?>
		  	</td> 	  	  		  	
		  	<td>
		  		<select name="x">
		  			<?php for ($i=50;$i<=300;$i++){ ?>
		  				<option value="<?php echo $i ?>" <?php 
		  				if ($i == getTableCardProperty(TC_CUSTOM_FORMAT_X,$tableCardId)){
			  				?>
			  				selected="selected"
			  				<?php
		  				}		  				
		  				?>><?php echo $i ?></option>
		  			<?php } ?>
		  		</select>
		  		mm
		  	</td>  	
		  </tr>  
		  <tr>
		  	<td>
		  		<?php echo getUebersetzung("Höhe") ?>
		  	</td> 	  	  		  	
		  	<td>
		  		<select name="y">
		  			<?php for ($i=50;$i<=300;$i++){ ?>
		  				<option value="<?php echo $i ?>" <?php 
		  				if ($i == getTableCardProperty(TC_CUSTOM_FORMAT_Y,$tableCardId)){
			  				?>
			  				selected="selected"
			  				<?php
		  				}		  				
		  				?>><?php echo $i ?></option>
		  			<?php } ?>
		  		</select> mm
		  	</td>  	
		  </tr> 
		  <tr>
		  	<td colspan="2"><hr/></td>
		  </tr>
		  <tr>
		  	<td>
		  		<?php echo getUebersetzung("Text Überschrift") ?>
		  	</td> 	  	  		  	
		  	<td>
		  		<input type="text" name="textHeading" 
		  			value="<?php echo getTableCardProperty(TC_HEADING_TEXT,$tableCardId) ?>"/>
		  	</td>  	
		  </tr> 		  
		  <tr>
		  	<td>
		  		<?php echo getUebersetzung("Schriftart Überschrift") ?>
		  	</td> 	  	  		  	
		  	<td>
		  		<select name="font_heading">
		  			<?php foreach($available_fonts as $fo){ ?>
		  				<option value="<?php echo $fo ?>"  <?php 
		  				if ($fo == getTableCardProperty(TC_FONT_HEADING,$tableCardId)){
			  				?>
			  				selected="selected"
			  				<?php
		  				}		  				
		  				?>><?php echo $fo ?></option>
		  			<?php } ?>
		  		</select>
		  	</td>  	
		  </tr> 
		  <tr>
		  	<td>
		  		<?php echo getUebersetzung("Schriftstil Überschrift") ?>
		  	</td> 	  	  		  	
		  	<td>
		  	<table>
		  		<tr>
	  			<?php 
	  			 $fontHeadingStyle = getTableCardProperty(TC_FONT_HEADING_STYLE,$tableCardId);
	  				foreach($available_font_styles as $key => $value){ ?>
		  			<td><label for="font_heading_<?php echo $value ?>"><?php echo getUebersetzung($key) ?></label></td>
		  			<td><input type="checkbox" name="font_heading_<?php echo $value ?>" value="<?php echo $value ?>"
		  			<?php
		  				if (!(strpos($fontHeadingStyle,$value) === FALSE)){
		  				?>
		  					checked="checked"
		  				<?php
		  				}
		  			?>
		  			/></td>
	  			<?php } ?>
	  			</tr>
	  		</table>
		  	</td>  		  	 	
		  </tr> 
		  <tr>
		  	<td>
		  		<?php echo getUebersetzung("Schriftgröße Überschrift") ?>
		  	</td> 	  	  		  	
		  	<td>
		  		<select name="font_size_heading">
		  			<?php for ($i=6;$i<=36;$i++){ ?>
		  			<option value="<?php echo $i ?>" <?php 
		  				if ($i == getTableCardProperty(TC_FONT_HEADING_SIZE,$tableCardId)){
			  				?>
			  				selected="selected"
			  				<?php
		  				}		  				
		  				?>><?php echo $i ?></option>
		  			<?php } ?>
		  		</select> Punkt
		  	</td>  	
		  </tr> 	
		  <tr>
		  	<td colspan="2"><hr/></td>
		  </tr>
		  <tr>
		  	<td>
		  		<?php echo getUebersetzung("Zeit anzeigen") ?>
		  	</td> 	  	  		  	
		  	<td>
		  		<input type="checkbox" name="show_time" value="true" 
		  		<?php
		  		if (getTableCardProperty(TC_TEXT_SHOW_TIME,$tableCardId) == "true"){
		  		?>
		  		checked="checked"
		  		<?php
		  		}
		  		?>
		  		/>
		  	</td>  	
		  </tr>
		  <tr>
		  	<td>
		  		<?php echo getUebersetzung("Name anzeigen") ?>
		  	</td> 	  	  		  	
		  	<td>
		  		<input type="checkbox" name="show_name" value="true" 
		  		<?php
		  		if (getTableCardProperty(TC_TEXT_SHOW_NAME,$tableCardId) == "true"){
		  		?>
		  		checked="checked"
		  		<?php
		  		}
		  		?>
		  		/>
		  	</td>  	
		  </tr> 			   		  		  	  		  
		  <tr>
		  	<td>
		  		<?php echo getUebersetzung("Schriftart Text") ?>
		  	</td> 	  	  		  	
		  	<td>
		  		<select name="font_text">
		  			<?php foreach($available_fonts as $fo){ ?>
		  				<option value="<?php echo $fo ?>" <?php 
		  				if ($fo == getTableCardProperty(TC_FONT_TEXT,$tableCardId)){
			  				?>
			  				selected="selected"
			  				<?php
		  				}		  				
		  				?>><?php echo $fo ?></option>
		  			<?php } ?>
		  		</select>
		  	</td>  	
		  </tr> 	
		  <tr>
		  	<td>
		  		<?php echo getUebersetzung("Schriftstil Text") ?>
		  	</td> 	  	  		  	
		  	<td>
		  	<table>
		  		<tr>
	  			<?php 
	  			 $fontTextStyle = getTableCardProperty(TC_FONT_TEXT_STYLE,$tableCardId);
	  				foreach($available_font_styles as $key => $value){ ?>
		  			<td><label for="font_text_<?php echo $value ?>"><?php echo getUebersetzung($key) ?></label></td>  	
		  			<td><input type="checkbox" name="font_text_<?php echo $value ?>" value="<?php echo $value ?>"
		  			<?php
		  				if (!(strpos($fontTextStyle,$value) === FALSE)){
		  				?>
		  					checked="checked"
		  				<?php
		  				}
		  			?>
		  			/></td>  	
	  			<?php } ?>
	  			</tr>
		  	</table>
		  	</td> 	
		  </tr> 
		  <tr>
		  	<td>
		  		<?php echo getUebersetzung("Schriftgröße Text") ?>
		  	</td> 	  	  		  	
		  	<td>
		  		<select name="font_size_text">
		  			<?php for ($i=6;$i<=36;$i++){ ?>
		  			<option value="<?php echo $i ?>" <?php 
		  				if ($i == getTableCardProperty(TC_FONT_TEXT_SIZE,$tableCardId)){
			  				?>
			  				selected="selected"
			  				<?php
		  				}		  				
		  				?>><?php echo $i ?></option>
		  			<?php } ?>
		  		</select> Punkt
		  	</td>  	
		  </tr> 	
		  <tr>
		  	<td colspan="2"><hr/></td>
		  </tr>
		  <tr>
	    	<td colspan="2">
		    	<table border="0" cellpadding="0" cellspacing="3" width="100%">
		    		<tr>
		    			<?php 
				      		$r = getTableCard($tableCardId);
				      		$bilder_id = $r->fields("BILDER_ID");
				      		if (!empty($bilder_id)){ 
				      			$width_pic = getBildBreite($bilder_id);
				      			$height_pic= getBildHoehe($bilder_id);
				      	?>
				    			<td>		
							      	<img src="<?php echo $root."/templates/picture.php?bilder_id=".$bilder_id ?>" 
							      		width="<?php echo $width_pic ?>" 
							      		height="<?php echo $height_pic ?>"/>
						        </td>
				      <?php
							}
						?>
		    			<td>
		    				<?php echo getUebersetzung("Bild") ?>
		    			</td>
		    			<td>
		    				<input name="bild" type="file"/>
		    			</td>
		    		</tr>
		    	</table>
	    	</td>	
		  </tr> 	
		  <tr>
		  	<td colspan="2"><hr/></td>
		  </tr>			  			  		  		  		  		   		  	
		  <tr>
		  	<td>
		  		<input type="button" class="button" onClick="showPreview(<?php echo $tableCardId ?>)" 
		  			value="<?php echo getUebersetzung("Vorschau") ?>"/>
		  	</td> 	  	  		  	
		  	<td>
		  		<?php echo getUebersetzung("PDF erzeugen und Testdruck starten.") ?>
		  	</td>  	
		  </tr>  
		  <tr>
		  	<td>
		  		<?php showSubmitButton(getUebersetzung("Speichern")); ?>
		  	</td> 	  	  		  	
		  	<td>
		  		<?php echo getUebersetzung("Tischkartendesign speichern.") ?>
		  	</td>  	
		  <tr> 
	</form>	
</table>
<?php
include_once($root."/backoffice/templates/footer.inc.php");
?>