<? $root = "../..";

/*   
	date: 22.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");

include_once("../../include/benutzerFunctions.inc.php");

$id = $_POST["id"];

?>
<?php include_once($root."/webinterface/templates/bodyStart.inc.php"); ?>
<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("L�schung best�tigen")); ?></p>
<form action="./benutzerLoeschen.php" method="post" name="benutzerLoeschen" target="_self" id="benutzerLoeschen">
  <table border="0" cellpadding="0" cellspacing="3" class="<?= TABLE_STANDARD ?>">
    <tr>
      <td><?php echo(getUebersetzung("Sind sie sicher, dass sie folgende Benutzer l�schen wollen")); ?>?<br/>
          (<?php echo(getUebersetzung("Nur die hier selektierten Benutzer werden gel�scht")); ?>.)<br/>  
            <?php 
				$anzahl = count($id);				
	  			for($i = 0; $i < $anzahl; $i++){ ?> 
  					<input type="checkbox" name="id[]" value="<?php echo($id[$i]); ?>" checked="checked">
           			<?php echo(getUserName($id[$i])); ?><br/>       
            <?php 
				} //ende for
			?>         
		<input name="loeschen" type="submit" class="<?= BUTTON ?>" id="loeschen" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("l�schen")); ?>">
      </td>
    </tr>
  </table>
</form>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td><form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">
        <input name="zurueck" type="submit" class="<?= BUTTON ?>" id="zurueck" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
	 onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("zur�ck")); ?>">
      </form></td>
  </tr>
</table>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>
