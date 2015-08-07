<? $root = "../..";

/*   
	date: 26.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/webinterface/templates/bodyStart.inc.php"); 
include_once($root."/include/cssFunctions.inc.php"); 

?>
<p class="<?= STANDARD_SCHRIFT_BOLD ?>"><?php echo(getUebersetzung("Design auf Standardwerte zurücksetzen")); ?></p>
<table border="0" cellspacing="2" cellpadding="0" class="<?= FREI ?>">         
          <tr>            
            <td><?php 
					setStandardCSS($vermieter_id);
				?>
				<?php echo(getUebersetzung("Das Design wurde erfolgreich auf die Standardwerte zurückgesetzt")); ?>!
			</td>
			</tr>
</table>
<br/>
<table border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td><form action="./index.php" method="post" name="form1" target="_self">
        <input type="submit" name="Submit3" value="<?php echo(getUebersetzung("zurück")); ?>" class="<?= BUTTON ?>" 
			onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?= BUTTON ?>';">
      </form></td>
  </tr>
</table>
<?php 
include_once($root."/webinterface/templates/footer.inc.php");
?>