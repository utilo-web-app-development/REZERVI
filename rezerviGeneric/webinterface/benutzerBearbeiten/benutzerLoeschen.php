<?php $root = "../..";

/*   
	date: 22.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");

include_once($root."/include/benutzerFunctions.inc.php");

if (isset($_POST["id"])){
	$id = $_POST["id"];
}
else{
	$id = array();	
}

$anzahl = count($id);
if ($anzahl < 1){
	$fehler = true;
	$nachricht = getUebersetzung("Es wurde kein Benutzer zum Löschen ausgewählt.");
	include_once("./index.php");	
	exit;	
}

include_once($root."/webinterface/templates/bodyStart.inc.php"); ?>

<table border="0" cellpadding="0" cellspacing="3" class="<?php echo FREI ?>">
  <tr>
    <td><p> 
	<?php 		
	 	for($i = 0; $i < $anzahl; $i++){			
			deleteBenutzer($id[$i]);      
		} //ende for
	?><?php echo(getUebersetzung("Löschung erfolgreich durchgeführt!",$sprache)); ?></p>
      </td>
  </tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="<?php echo TABLE_STANDARD ?>">
  <tr> 
    <td><form action="./index.php" method="post" name="back" target="_self" id="back">
        <input name="zurueck" type="submit" class="<?php echo BUTTON ?>" id="zurueck" 
        	onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
	 		onMouseOut="this.className='<?php echo BUTTON ?>';" 
	 		value="<?php echo(getUebersetzung("zurück",$sprache)); ?>">
      </form></td>
  </tr>
</table>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>
