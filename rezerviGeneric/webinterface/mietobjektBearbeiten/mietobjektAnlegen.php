<? $root = "../..";

/*   
	date: 23.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 

//andere funktionen importieren:
include_once($root."/include/mietobjektFunctions.inc.php");
$standardsprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
if ($standardsprache == false || $standardsprache == ""){
	$standardsprache = "en";
}

if (!(isset($fehler) && $fehler == true)){
	$preis = "";
	$linkName = "";
}
?>
<form action="./mietobjektEintragen.php" method="post" name="mietobjektEintragen" target="_self">
  <table border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
    <tr> 
      <td colspan="2"><p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Ein neues Mietobjekt anlegen")); ?><br/>
          <span class="<?= STANDARD_SCHRIFT ?>"><?php echo(getUebersetzung("Bitte füllen Sie die untenstehenden Felder aus.")); ?> 
		  <?php echo(getUebersetzung("Die mit [*] gekennzeichneten Felder müssen ausgefüllt werden")); ?>!
		  </span></p></td>
    </tr>
    <tr> 
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
    <?php
    $res = getActivtedSprachenOfVermieter($vermieter_id);
    while ($d = mysql_fetch_array($res)){
    	$sprache_id = $d["SPRACHE_ID"];
    	$bezeichnung= $d["BEZEICHNUNG"];
    ?>
	<tr> 
	  <td><?php echo(getUebersetzung("Bezeichnung des Mietobjektes")); ?> 
	  	   (<?php echo(getUebersetzung($bezeichnung)); ?>) 
	      <br/>	       
	      <?php if ($standardsprache != $sprache_id){ ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.")); ?>)
	      <?php
	      	}
	      ?>
	      </td>
	   <td><input name="bezeichnung_<?= $sprache_id ?>" type="text" value="" maxlength="255">
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
    $res = getActivtedSprachenOfVermieter($vermieter_id);
    while ($d = mysql_fetch_array($res)){
    	$sprache_id = $d["SPRACHE_ID"];
    	$bezeichnung= $d["BEZEICHNUNG"];
    ?>
	    <tr> 
	      <td><?php echo(getUebersetzung("Beschreibung")); ?> 
	      (<?php echo(getUebersetzung($bezeichnung)); ?>)<br/>	       
	      <?php if ($standardsprache != $sprache_id){ ?>
	      (<?php echo(getUebersetzung("Wird dieses Feld leer gelassen, wird die Standard-Sprache verwendet.")); ?>)
	      <?php
	      	}
	      ?></td>
	      <td><textarea name="beschreibung_<?= $sprache_id ?>"></textarea></td>
	    </tr>
	<?php
    }
	?>
    <tr> 
      <td><?php echo(getUebersetzung("Preis")); ?></td>
      <td><input name="preis" type="text" id="preis"  value="<?php if (isset($preis)) {echo($preis);} ?>" maxlength="20"></td>
    </tr>
	<tr> 
      <td><?php echo(getUebersetzung("URL zu weiteren Informationen (z. B. http://www.rezervi.com/index.php)")); ?></td>
      <td><input name="linkName" type="text" id="linkName"  value="<?php if (isset($linkName)) {echo($linkName);} ?>" maxlength="255"></td>
    </tr>
    <tr> 
      <td height="30" colspan="2">&nbsp;</td>
    </tr>
     <tr> 
      <td colspan="2"><input name="Submit" type="submit" id="Submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("Mietobjekt speichern")); ?>"></td>
    </tr>
  </table>
</form>

<table border="0" cellpadding="0" cellspacing="0" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td><form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">

	<input name="retour" type="submit" class="<?= BUTTON ?>" id="retour" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
	 onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>">
  </form></td>
  </tr>
</table>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>