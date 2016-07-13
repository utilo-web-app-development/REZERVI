<? $root = "../..";

/*   
	date: 3.11.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");

include_once($root."/include/vermieterFunctions.inc.php");
include_once($root."/include/mietobjektFunctions.inc.php");
include_once($root."/include/datumFunctions.inc.php");
include_once($root."/include/mieterFunctions.inc.php");
include_once($root."/include/reservierungFunctions.inc.php");

$ansicht = $_POST["ansicht"];
$status = $_POST["status"];
$vonTag = $_POST["vonTag"];
$bisTag = $_POST["bisTag"];
$vonMonat = $_POST["vonMonat"];
$bisMonat = $_POST["bisMonat"];
$vonJahr = $_POST["vonJahr"];
$bisJahr = $_POST["bisJahr"];
$mietobjekt_id = $_POST["mietobjekt_id"];
$vonMinute=$_POST["vonMinute"];
$vonStunde=$_POST["vonStunde"];
$bisMinute=$_POST["bisMinute"];
$bisStunde=$_POST["bisStunde"];
$mieter_id = $_POST["mieter_id"];
if (isset($_POST["anrede"])){
	$anrede = $_POST["anrede"];
}
else{
	$anrede = "";
}
if (isset($_POST["vorname"])){
	$vorname = $_POST["vorname"];
}
else{
	$vorname = "";
}
if (isset($_POST["nachname"])){
	$nachname = $_POST["nachname"];
}
else{
	$nachname = "";
}
if (isset($_POST["strasse"])){
	$strasse = $_POST["strasse"];
}
else{
	$strasse = "";
}
if (isset($_POST["plz"])){
	$plz = $_POST["plz"];
}
else{
	$plz = "";
}
if (isset($_POST["ort"])){
	$ort = $_POST["ort"];
}
else{
	$ort = "";
}
if (isset($_POST["land"])){
	$land = $_POST["land"];
}
else{
	$land = "";
}
if (isset($_POST["email"])){
	$email = $_POST["email"];
}
else{
	$email = "";
}
if (isset($_POST["tel"])){
	$tel = $_POST["tel"];
}
else{
	$tel = "";
}
if (isset($_POST["tel2"])){
	$tel2 = $_POST["tel2"];
}
else{
	$tel2 = "";
}
if (isset($_POST["fax"])){
	$fax = $_POST["fax"];
}
else{
	$fax = "";
}
if (isset($_POST["url"])){
	$url = $_POST["url"];
}
else{
	$url = "";
}
if (isset($_POST["speech"])){
	$speech = $_POST["speech"];
}
else{
	$speech = "";
}
if (isset($_POST["firma"])){
	$firma = $_POST["firma"];
}
else{
	$firma = "";
}


//pruefen ob daten vollstaendig eingegeben:
if (trim($nachname) == "" && $mieter_id != ANONYMER_MIETER_ID){
	$fehler = true;
	$nachricht = "Bitte geben sie den Nachnamen ein.";
	include_once($root."/webinterface/reservierung/resAendern.php");
	exit;
}
	
include_once($root."/webinterface/templates/bodyStart.inc.php"); 

	//anonymen gast eintragen:
	if ($mieter_id == ANONYMER_MIETER_ID){
		//do nothing
	}		
	//2. gast ist neu:
	else if ($mieter_id == NEUER_MIETER) {		
		$mieter_id = insertMieter($vermieter_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$speech);	

	}
	else{//3. gast ist bereits vorhanden und wurde geändert
		updateMieter($mieter_id,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$tel,$tel2,$fax,$url,$firma,$speech);	
	}	
	
	//reservierung eintragen:
	insertReservation($mietobjekt_id,$mieter_id,$vonMinute,$vonStunde,$vonTag,$vonMonat,$vonJahr,$bisMinute,$bisStunde,$bisTag,$bisMonat,$bisJahr,$status);

?>
<table  border="0" cellpadding="0" cellspacing="3" class="<?= FREI ?>">
  <tr>
    <td>
      <?php echo(getUebersetzung("Die Reservierung wurde erfolgreich geändert")); ?>!
	</td>
  </tr>
</table>
<br/>
<form action="./index.php" method="post" name="form1" target="_self">  
  <table border="0" cellspacing="3" cellpadding="0">
    <tr>
      <td>
        <input type="hidden" name="ansicht" value="<?= $ansicht ?>"/>
        <input name="monat" type="hidden" id="monat" value="<?= $vonMonat ?>"> 
        <input name="jahr" type="hidden" id="jahr" value="<?= $vonJahr ?>">
        <input name="tag" type="hidden" id="tag" value="<?= $vonTag ?>">
		<input name="mietobjekt_id" type="hidden" id="mietobjekt_id" value="<?php echo($mietobjekt_id); ?>">
	    <input name="vonMinute" type="hidden" id="vonMinute" value="<?= $vonMinute ?>">
        <input name="bisMinute" type="hidden" id="bisMinute" value="<?= $bisMinute ?>">
        <input name="bisStunde" type="hidden" id="bisStunde" value="<?= $bisStunde ?>">
        <input name="vonStunde" type="hidden" id="vonStunde" value="<?= $vonStunde ?>"> 
        <input type="submit" name="Submit" class="<?= BUTTON ?>" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
       onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("zurück")); ?>"> </td>
    </tr>
  </table>
  <p>&nbsp; </p>
  </form>
  
<?php
	include_once($root."/webinterface/templates/footer.inc.php");
?>
