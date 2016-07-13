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
$id = $_POST["id"];
$testuser = $_POST["testuser"];

$fehler = false;
//eingaben pruefen:
if ($name == ""){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte geben sie den Benutzernamen ein!");
	include_once("./benutzerAendern.php");	
	exit;
}
else if($pass == "" || $pass2 == ""){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte geben sie das Passwort ein!");
	include_once("./benutzerAendern.php");	
	exit;
}
else if($pass != $pass2){
	$fehler = true;
	$nachricht = getUebersetzung("Die beiden Passwörter stimmen nicht überein!");
	include_once("./benutzerAendern.php");	
	exit;
}
else if(isBenutzerVorhanden($name,$pass,$vermieter_id) && getSessionWert(BENUTZER_ID) != $id){
	$fehler = true;
	$nachricht = getUebersetzung("Ein Benutzer mit diesen Zugangsdaten ist bereits vorhanden!");
	include_once("./benutzerAendern.php");	
	exit;
}
//wenn im testmodus, dann nicht den test-benutzer ändern:
if(DEMO == true && $testuser == true){
	$fehler = true;
	$nachricht = getUebersetzung("Der Testbenutzer kann im Demo Modus nicht verändert werden!");
	include_once("./benutzerAendern.php");	
	exit;
}	

include_once($root."/webinterface/templates/bodyStart.inc.php");
	
	changeBenutzer($id,$name,$pass,$rechte);
	
	?>
<table border="0" cellspacing="0" cellpadding="0" class="<?php echo FREI ?>">
  <tr>
    <td><?php echo(getUebersetzung("Die Änderung wurde erfolgreich durchgeführt")); ?>.</td>
  </tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="<?php echo TABLE_STANDARD ?>">
  <tr>
    <td><form action="./index.php" method="post" name="zimmer aendern" target="_self" id="zimmer aendern">
        <input name="retour" type="submit" class="<?php echo BUTTON ?>" id="retour" onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
	 onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>">
      </form></td>
  </tr>
</table>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>
