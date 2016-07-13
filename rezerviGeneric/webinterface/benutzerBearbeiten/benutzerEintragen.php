<?php $root = "../..";

/*   
	date: 22.9.05
	author: christian osterrieder utilo.net						
*/
//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");
include_once($root."/include/benutzerFunctions.inc.php");

$pass = $_POST["pass"];
$name = $_POST["name"];
$pass2 = $_POST["pass2"];
$rechte = $_POST["rechte"];

$fehler = false;
//eingaben pruefen:
if ($name == ""){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte geben sie den Benutzernamen ein!");
	include_once("./benutzerAnlegen.php");	
	exit;
}
else if($pass == "" || $pass2 == ""){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte geben sie das Passwort ein!");
	include_once("./benutzerAnlegen.php");	
	exit;
}
else if($pass != $pass2){
	$fehler = true;
	$nachricht = getUebersetzung("Die beiden Passwörter stimmen nicht überein!");
	include_once("./benutzerAnlegen.php");	
	exit;
}
else if(isBenutzerVorhanden($name,$pass,$vermieter_id)){
	$fehler = true;
	$nachricht = getUebersetzung("Ein Benutzer mit diesen Zugangsdaten ist bereits vorhanden!");
	include_once("./benutzerAnlegen.php");	
	exit;
}
	

		
	//eintragen in db
	setBenutzer($name,$pass,$rechte,$vermieter_id);

include_once($root."/webinterface/templates/bodyStart.inc.php"); 
	
?>
<table border="0" cellpadding="0" cellspacing="0" class="<?php echo FREI ?>">
  <tr>
	<td><?php echo(getUebersetzung("Der Benutzer wurde erfolgreich hinzugefügt.")); ?></td>
  </tr>
</table>	
<br/><br/>
<table border="0" cellpadding="0" cellspacing="0" class="<?php echo TABLE_STANDARD ?>">
  <tr> 
    <td><form action="./benutzerAnlegen.php" method="post" name="anlegen" target="_self" id="anlegen">
        <input name="retour" type="submit" class="<?php echo BUTTON ?>" id="retour" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
	 		onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("einen weiteren Benutzer anlegen")); ?>">
      </form></td>
  </tr>
</table>
<br/>
<table border="0" cellpadding="3" cellspacing="0">
  <tr> 
    <td><form action="./index.php" method="post" name="back" target="_self" id="back">
        <input name="retour2" type="submit" class="<?php echo BUTTON ?>" id="retour2" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
	 		onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>">
      </form></td>
  </tr>
</table>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>
