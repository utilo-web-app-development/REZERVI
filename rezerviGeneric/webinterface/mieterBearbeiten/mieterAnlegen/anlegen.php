<?php $root = "../../..";

/*   
	date: 14.10.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");

//wurde der nachname eingegeben?
if (!isset($_POST["nachname"]) || trim($_POST["nachname"]) == ""){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte geben sie den Nachnamen ein!");
	include_once("./index.php");
	exit;
}

include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/webinterface/templates/components.inc.php"); 

$anrede = $_POST["anrede"];
$vorname = $_POST["vorname"];
$nachname = $_POST["nachname"];
$strasse = $_POST["strasse"];
$plz = $_POST["plz"];
$ort = $_POST["ort"];
$land = $_POST["land"];
$email = $_POST["email"];
$tel = $_POST["tel"];
$tel2 = $_POST["tel2"];
$fax = $_POST["fax"];
$url = $_POST["url"];
$speech = $_POST["speech"];
$firma  = $_POST["firma"];

include_once($root."/webinterface/templates/bodyStart.inc.php"); 

insertMieter($vermieter_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$speech);	
		
?>
<table border="0" cellspacing="3" cellpadding="0" class="<?php echo FREI ?>">
  <tr>
    <td><?php echo getUebersetzung("Der Mieter wurde erfolgreich angelegt"); ?>.</td>
  </tr>
</table>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="<?php echo TABLE_STANDARD ?>">
  <tr>
    <td><form action="./index.php" method="post" name="form1" target="_self">
        <input name="nochmal" type="submit" class="<?php echo BUTTON ?>" id="nochmal" 
			onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("einen weiteren Mieter anlegen")); ?>">
    </form></td>
  </tr>
</table>
<br/>
<table border="0" cellspacing="3" cellpadding="0" class="<?php echo TABLE_STANDARD ?>">
  <tr>
    <td><form action="../index.php" method="post" name="form1" target="_self">
        <input name="zurueck" type="submit" class="<?php echo BUTTON ?>" id="zurueck" 
			onMouseOver="this.className='<?php echo BUTTON_HOVER ?>';"
       		onMouseOut="this.className='<?php echo BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>">
    </form></td>
  </tr>
</table>
<?php	  
include_once($root."/webinterface/templates/footer.inc.php");
?>
