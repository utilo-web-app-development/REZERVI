<?php $root = "../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 

//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/bildFunctions.inc.php");

$anzahlVorhandMietobjekte = getAnzahlVorhandeneMietobjekte($vermieter_id);
if ($anzahlVorhandMietobjekte > 0){
?>
<form action="./mietobjektAendern.php" method="post" name="mietobjektAendern" target="_self">
  <table border="0" cellpadding="0" cellspacing="3">
    <tr>
      <td><p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Mietobjekt bearbeiten")); ?><br/>
          <span class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Bitte wählen Sie das zu verändernde Mietobjekt aus")); ?>:</span></p></td>
    </tr>
    <tr>
      <td>
      	<select name="mietobjekt_id" size="5" id="mietobjekt_id">
          <?php	
		 	 $res = getMietobjekte($vermieter_id);
		 	 $first = true;
			  while($d = mysql_fetch_array($res)) {
				$ziArt = getUebersetzungVermieter($d["BEZEICHNUNG"],$sprache,$vermieter_id);
				?>
				<option value="<?php echo $d["MIETOBJEKT_ID"] ?>" <?php
					if($first){
						?>
						selected="selected"
						<?php
						$first = false;
					}
					?>
					><?php echo $ziArt ?></option>
				<?php
			  } //ende while
			 ?>
           </select>
      </td>
    </tr>
    <tr>
      <td><input name="Submit" type="submit" id="Submit" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
		   onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("Mietobjekt ändern")); ?>"></td>
    </tr>
  </table>
</form>

<form action="./mietobjektLoeschenBestaetigen.php" method="post" name="mietobjektLoeschenBestaetigen" target="_self">
  <table  border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
    <tr>
      <td><p class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Mietobjekt löschen")); ?><br/>
          <span class="<?php echo STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Bitte wählen Sie die zu löschenden Mietobjekte aus")); ?>. 
          <?php echo(getUebersetzung("Sie können mehrere Mietobjekte zugleich auswählen und löschen indem Sie die [STRG]-Taste gedrückt halten und auf die Bezeichnung klicken")); ?>.</span></p></td>
    </tr>
    <tr>
      <td>      	
      	  <select name="mietobjekt_id[]" size="5" id="mietobjekt_id" multiple="multiple">
          <?php	
		 	 $res = getMietobjekte($vermieter_id);
		 	 $first = true;
			  while($d = mysql_fetch_array($res)) {
				$ziArt = getUebersetzungVermieter($d["BEZEICHNUNG"],$sprache,$vermieter_id);
				?>
				<option value="<?php echo $d["MIETOBJEKT_ID"] ?>" <?php
					if($first){
						?>
						selected="selected"
						<?php
						$first = false;
					}
					?>
					><?php echo $ziArt ?></option>
				<?php
			  } //ende while
			 ?>
           </select>
      </td>
    </tr>
    <tr>
      <td><input name="Submit2" type="submit" id="Submit2" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("Mietobjekt löschen")); ?>"></td>
    </tr>
  </table>
</form>
<?php
}
$anzahlMietobjekte = getAnzahlMietobjekteOfVermieter($vermieter_id);
if ( $anzahlVorhandMietobjekte < $anzahlMietobjekte ){
?>
	<form action="./mietobjektAnlegen.php" method="post" name="mietobjektAnlegen" target="_self">
	  <table  border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
	    <tr>
	      <td><span class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Mietobjekt anlegen")); ?></span><br/>
	        </td>
	    </tr>
	    <tr>
	      <td><input name="zimmerAnlegenButton" type="submit" id="zimmerAnlegenButton" class="<?php echo BUTTON ?>" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
	       onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("Mietobjekt anlegen")); ?>"></td>
	    </tr>
	  </table>
	</form>
<?php }
if ($anzahlVorhandMietobjekte > 0){
?>
	<form action="./bilderHochladen.php" method="post" name="bilder" target="_self" id="bilder">
		<table border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
		    <tr>
	      		<td><span class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Bilder für Mietobjekt hochladen")); ?></span><br/>
	        	</td>
	    	</tr>
		  	<tr>
				<td>	
					<input name="hochladen" type="submit" class="<?php echo BUTTON ?>" id="hochladen" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
				 onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("Bilder hochladen")); ?>">
				</td>
		    </tr>
		</table>
	</form>
	<?php
	$anzahl = getAnzahlBilderOfVermieter($vermieter_id);
	if ($anzahl > 0){
	?>
	<form action="./bilderLoeschen.php" method="post" name="bilder" target="_self" id="bilder">
		<table border="0" cellpadding="0" cellspacing="3" class="<?php echo TABLE_STANDARD ?>">
		  <tr>
	        <td><span class="<?php echo STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Bilder für Mietobjekt löschen")); ?></span><br/>
	        </td>
	      </tr>
		  <tr>
			<td>	
				<input name="hochladen" type="submit" class="<?php echo BUTTON ?>" id="hochladen" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
			 	onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("Bilder löschen")); ?>">
			</td>
		  </tr>
		</table>
	</form>
<?php
	}
} 
include_once($root."/webinterface/templates/footer.inc.php");
?>
