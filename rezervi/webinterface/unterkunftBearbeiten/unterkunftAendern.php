<? session_start();
$root = "../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");

/*   
			reservierungsplan
			ein neues zimmer anlegen.
*/

//datenbank öffnen:
include_once("../../conf/rdbmsConfig.php");

//andere funktionen importieren:
include_once("../../include/benutzerFunctions.php");
include_once("../../include/unterkunftFunctions.php");
include_once("../../include/uebersetzer.php");
include_once("../../include/einstellungenFunctions.php");

//variablen:
$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
//sprachunabhängige variablen:
$strasse = $_POST["strasse"];
$plz = $_POST["plz"];
$ort = $_POST["ort"];
$email = $_POST["email"];
$tel = $_POST["tel"];
$tel2 = $_POST["tel2"];
$fax = $_POST["fax"];
$kindesalter = $_POST["kindesalter"];
$waehrung = $_POST["waehrung"];
//variablen sprachabhängig:
if (isset($_POST["name_de"])){
	$name_de = $_POST["name_de"];
}
else{
	$name_de = false;
}
if (isset($_POST["name_en"])){
	$name_en = $_POST["name_en"];
}
else{
	$name_en = false;
}
if (isset($_POST["name_fr"])){
	$name_fr = $_POST["name_fr"];
}
else{
	$name_fr = false;
}
if (isset($_POST["name_it"])){
	$name_it = $_POST["name_it"];
}
else{
	$name_it = false;
}
if (isset($_POST["name_nl"])){
	$name_nl = $_POST["name_nl"];
}
else{
	$name_nl = false;
}
if (isset($_POST["name_es"])){
	$name_es = $_POST["name_es"];
}
else{
	$name_es = false;
}
if (isset($_POST["name_sp"])){
	$name_sp = $_POST["name_sp"];
}
else{
	$name_sp = false;
}

if (isset($_POST["land_de"])){
	$land_de = $_POST["land_de"];
}
else{
	$land_de = false;
}
if (isset($_POST["land_en"])){
	$land_en = $_POST["land_en"];
}
else{
	$land_en = false;
}
if (isset($_POST["land_fr"])){
	$land_fr = $_POST["land_fr"];
}
else{
	$land_fr = false;
}
if (isset($_POST["land_it"])){
	$land_it = $_POST["land_it"];
}
else{
	$land_it = false;
}
if (isset($_POST["land_nl"])){
	$land_nl = $_POST["land_nl"];
}
else{
	$land_nl = false;
}
if (isset($_POST["land_sp"])){
	$land_sp = $_POST["land_sp"];
}
else{
	$land_sp = false;
}
if (isset($_POST["land_es"])){
	$land_es = $_POST["land_es"];
}
else{
	$land_es = false;
}

if (isset($_POST["art_de"])){
	$art_de = $_POST["art_de"];
}
else{
	$art_de = false;
}
if (isset($_POST["art_en"])){
	$art_en = $_POST["art_en"];
}
else{
	$art_en = false;
}
if (isset($_POST["art_fr"])){
	$art_fr = $_POST["art_fr"];
}
else{
	$art_fr = false;
}
if (isset($_POST["art_it"])){
	$art_it = $_POST["art_it"];
}
else{
	$art_it = false;
}
if (isset($_POST["art_nl"])){
	$art_nl = $_POST["art_nl"];
}
else{
	$art_nl = false;
}
if (isset($_POST["art_sp"])){
	$art_sp = $_POST["art_sp"];
}
else{
	$art_sp = false;
}
if (isset($_POST["art_es"])){
	$art_es = $_POST["art_es"];
}
else{
	$art_es = false;
}

if (isset($_POST["zimmerart_de"])){
	$zimmerart_de = $_POST["zimmerart_de"];
}
else{
	$zimmerart_de = false;
}
if (isset($_POST["zimmerart_en"])){
	$zimmerart_en = $_POST["zimmerart_en"];
}
else{
	$zimmerart_en = false;
}
if (isset($_POST["zimmerart_fr"])){
	$zimmerart_fr = $_POST["zimmerart_fr"];
}
else{
	$zimmerart_fr = false;
}
if (isset($_POST["zimmerart_it"])){
	$zimmerart_it = $_POST["zimmerart_it"];
}
else{
	$zimmerart_it = false;
}
if (isset($_POST["zimmerart_nl"])){
	$zimmerart_nl = $_POST["zimmerart_nl"];
}
else{
	$zimmerart_nl = false;
}
if (isset($_POST["zimmerart_es"])){
	$zimmerart_es = $_POST["zimmerart_es"];
}
else{
	$zimmerart_es = false;
}
if (isset($_POST["zimmerart_sp"])){
	$zimmerart_sp = $_POST["zimmerart_sp"];
}
else{
	$zimmerart_sp = false;
}

if (isset($_POST["zimmerart_mz_de"])){
	$zimmerart_mz_de = $_POST["zimmerart_mz_de"];
}
else{
	$zimmerart_mz_de = false;
}
if (isset($_POST["zimmerart_mz_en"])){
	$zimmerart_mz_en = $_POST["zimmerart_mz_en"];
}
else{
	$zimmerart_mz_en = false;
}
if (isset($_POST["zimmerart_mz_fr"])){
	$zimmerart_mz_fr = $_POST["zimmerart_mz_fr"];
}
else{
	$zimmerart_mz_fr = false;
}
if (isset($_POST["zimmerart_mz_it"])){
	$zimmerart_mz_it = $_POST["zimmerart_mz_it"];
}
else{
	$zimmerart_mz_it = false;
}
if (isset($_POST["zimmerart_mz_nl"])){
	$zimmerart_mz_nl = $_POST["zimmerart_mz_nl"];
}
else{
	$zimmerart_mz_nl = false;
}
if (isset($_POST["zimmerart_mz_sp"])){
	$zimmerart_mz_sp = $_POST["zimmerart_mz_sp"];
}
else{
	$zimmerart_mz_sp = false;
}
if (isset($_POST["zimmerart_mz_es"])){
	$zimmerart_mz_es = $_POST["zimmerart_mz_es"];
}
else{
	$zimmerart_mz_es = false;
}

$sprache = getSessionWert(SPRACHE);
$standardsprache = getStandardSprache($unterkunft_id,$link);
$fehler = false;

//pruefen ob alle pflichtfelder eingegeben wurden:
if (
	 ($standardsprache == "de" && 
		($name_de == false || 
		 $email == "" || 
		 $art_de == false || 
		 $zimmerart_de == false || 
		 $zimmerart_mz_de == false)
      )
      ||
      ($standardsprache == "en" && 
		($name_en == false || 
		 $email == "" || 
		 $art_en == false || 
		 $zimmerart_en == false || 
		 $zimmerart_mz_en == false)
      )
      ||
      ($standardsprache == "fr" && 
		($name_fr == false || 
		 $email == "" || 
		 $art_fr == false || 
		 $zimmerart_fr == false || 
		 $zimmerart_mz_fr == false)
      )
      ||
      ($standardsprache == "it" && 
		($name_it == false || 
		 $email == "" || 
		 $art_it == false || 
		 $zimmerart_it == false || 
		 $zimmerart_mz_it == false)
      ) 
      ||
      ($standardsprache == "nl" && 
		($name_nl == false || 
		 $email == "" || 
		 $art_nl == false || 
		 $zimmerart_nl == false || 
		 $zimmerart_mz_nl == false)
      ) 
      ||      
      ($standardsprache == "sp" && 
		($name_sp == false || 
		 $email == "" || 
		 $art_sp == false || 
		 $zimmerart_sp == false || 
		 $zimmerart_mz_sp == false)
      )  
      ||
      ($standardsprache == "es" && 
		($name_es == false || 
		 $email == "" || 
		 $art_es == false || 
		 $zimmerart_es == false || 
		 $zimmerart_mz_es == false)
      ) 
   ){
	$fehler = true;
	$message = getUebersetzung("Es wurden nicht alle Felder korrekt ausgefüllt!",$sprache,$link);
}
if (empty($waehrung)){
	$fehler = true;
	$message = getUebersetzung("Bitte geben sie die Waehrung ein.",$sprache,$link);
}
if($fehler == true){
	//zurueck zur eingabeseite:
	include_once("./index.php");	
}
else{
			
?>
<?php include_once("../templates/headerA.php"); ?>
<style type="text/css">
<?php include_once($root."/templates/stylesheetsIE9.php"); ?>
</style>
<?php include_once("../templates/headerB.php"); ?>
<?php include_once("../templates/bodyA.php"); ?>
<?php //passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){		
	
	//unterkunft änderung durchführen:	
	setUnterkunftStrasse($unterkunft_id,$strasse,$link);
	setUnterkunftPlz($unterkunft_id,$plz,$link);
	setUnterkunftOrt($unterkunft_id,$ort,$link);	
	setUnterkunftEmail($unterkunft_id,$email,$link);
	setUnterkunftTel($unterkunft_id,$tel,$link);
	setUnterkunftTel2($unterkunft_id,$tel2,$link);
	setUnterkunftFax($unterkunft_id,$fax,$link);	
	setKindesalter($unterkunft_id,$kindesalter,$link);
	setWaehrung($unterkunft_id,$waehrung);
	
		if ($standardsprache == "de"){
			$defaultName = $name_de;	
			$defaultland = $land_de;
			$defaultart  = $art_de;
			$defaultzimmerart = $zimmerart_de;
			$defaultzimmerart_mz = $zimmerart_mz_de;
		}
		else if ($standardsprache == "en"){
			$defaultName = $name_en;
			$defaultland = $land_en;
			$defaultart  = $art_en;
			$defaultzimmerart = $zimmerart_en;
			$defaultzimmerart_mz = $zimmerart_mz_en;
		}
		else if ($standardsprache == "fr"){
			$defaultName = $name_fr;	
			$defaultland = $land_fr;
			$defaultart  = $art_fr;
			$defaultzimmerart = $zimmerart_fr;
			$defaultzimmerart_mz = $zimmerart_mz_fr;
		}
		else if ($standardsprache == "it"){
			$defaultName = $name_it;
			$defaultland = $land_it;	
			$defaultart  = $art_it;
			$defaultzimmerart = $zimmerart_it;
			$defaultzimmerart_mz = $zimmerart_mz_it;
		}
		else if ($standardsprache == "nl"){
			$defaultName = $name_nl;
			$defaultland = $land_nl;	
			$defaultart  = $art_nl;
			$defaultzimmerart = $zimmerart_nl;
			$defaultzimmerart_mz = $zimmerart_mz_nl;
		}		
		else if ($standardsprache == "sp"){
			$defaultName = $name_sp;
			$defaultland = $land_sp;
			$defaultart  = $art_sp;
			$defaultzimmerart = $zimmerart_sp;
			$defaultzimmerart_mz = $zimmerart_mz_sp;
		}
		else if ($standardsprache == "es"){
			$defaultName = $name_es;	
			$defaultland = $land_es;
			$defaultart  = $art_es;
			$defaultzimmerart = $zimmerart_es;
			$defaultzimmerart_mz = $zimmerart_mz_es;
		}
	
	if ($name_de == false) { $name_de = $defaultName; }
	if ($name_en == false) { $name_en = $defaultName; }
	if ($name_fr == false) { $name_fr = $defaultName; }
	if ($name_it == false) { $name_it = $defaultName; }
	if ($name_nl == false) { $name_nl = $defaultName; }
	if ($name_es == false) { $name_es = $defaultName; }
	if ($name_sp == false) { $name_sp = $defaultName; }
	setUnterkunftName($unterkunft_id,$defaultName,$link);	
	setUebersetzungUnterkunft($name_de,$defaultName,"de",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($name_en,$defaultName,"en",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($name_fr,$defaultName,"fr",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($name_it,$defaultName,"it",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($name_nl,$defaultName,"nl",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($name_es,$defaultName,"es",$standardsprache,$unterkunft_id,$link);
	
	if ($land_en == false) { $land_en = $defaultland; }
	if ($land_fr == false) { $land_fr = $defaultland; }
	if ($land_it == false) { $land_it = $defaultland; }
	if ($land_nl == false) { $land_nl = $defaultland; }
	if ($land_es == false) { $land_es = $defaultland; }
	if ($land_sp == false) { $land_sp = $defaultland; }
	if ($land_de == false) { $land_de = $defaultland; }
	setUnterkunftLand($unterkunft_id,$defaultland,$link);
	setUebersetzungUnterkunft($land_de,$defaultland,"de",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($land_en,$defaultland,"en",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($land_fr,$defaultland,"fr",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($land_it,$defaultland,"it",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($land_nl,$defaultland,"nl",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($land_es,$defaultland,"es",$standardsprache,$unterkunft_id,$link);
	
	if ($art_en == false) { $art_en = $defaultart;	}
	if ($art_fr == false) { $art_fr = $defaultart; }
	if ($art_it == false) { $art_it = $defaultart; }
	if ($art_nl == false) { $art_nl = $defaultart; }
	if ($art_es == false) { $art_es = $defaultart; }
	if ($art_sp == false) { $art_sp = $defaultart; }
	if ($art_de == false) { $art_de = $defaultart; }	
	setUnterkunftArt($unterkunft_id,$defaultart,$link);				
	setUebersetzungUnterkunft($art_de,$defaultart,"de",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($art_en,$defaultart,"en",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($art_fr,$defaultart,"fr",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($art_it,$defaultart,"it",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($art_nl,$defaultart,"nl",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($art_es,$defaultart,"es",$standardsprache,$unterkunft_id,$link);
	
	if ($zimmerart_de == false) { $zimmerart_de = $defaultzimmerart; }
	if ($zimmerart_en == false) { $zimmerart_en = $defaultzimmerart; }
	if ($zimmerart_fr == false) { $zimmerart_fr = $defaultzimmerart; }
	if ($zimmerart_it == false) { $zimmerart_it = $defaultzimmerart; }
	if ($zimmerart_nl == false) { $zimmerart_nl = $defaultzimmerart; }
	if ($zimmerart_sp == false) { $zimmerart_sp = $defaultzimmerart; }
	if ($zimmerart_es == false) { $zimmerart_es = $defaultzimmerart; }
	setZimmerArt_EZ($unterkunft_id,$defaultzimmerart,$link);
	setUebersetzungUnterkunft($zimmerart_de,$defaultzimmerart,"de",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($zimmerart_en,$defaultzimmerart,"en",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($zimmerart_fr,$defaultzimmerart,"fr",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($zimmerart_it,$defaultzimmerart,"it",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($zimmerart_nl,$defaultzimmerart,"nl",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($zimmerart_es,$defaultzimmerart,"es",$standardsprache,$unterkunft_id,$link);
	
	if ($zimmerart_mz_de == false) { $zimmerart_mz_de = $defaultzimmerart_mz; }
	if ($zimmerart_mz_en == false) { $zimmerart_mz_en = $defaultzimmerart_mz; }
	if ($zimmerart_mz_fr == false) { $zimmerart_mz_fr = $defaultzimmerart_mz; }
	if ($zimmerart_mz_it == false) { $zimmerart_mz_it = $defaultzimmerart_mz; }
	if ($zimmerart_mz_nl == false) { $zimmerart_mz_nl = $defaultzimmerart_mz; }
	if ($zimmerart_mz_es == false) { $zimmerart_mz_es = $defaultzimmerart_mz; }
	if ($zimmerart_mz_sp == false) { $zimmerart_mz_sp = $defaultzimmerart_mz; }
	setZimmerArt_MZ($unterkunft_id,$defaultzimmerart_mz,$link);
	setUebersetzungUnterkunft($zimmerart_mz_de,$defaultzimmerart_mz,"de",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($zimmerart_mz_en,$defaultzimmerart_mz,"en",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($zimmerart_mz_fr,$defaultzimmerart_mz,"fr",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($zimmerart_mz_it,$defaultzimmerart_mz,"it",$standardsprache,$unterkunft_id,$link);
	setUebersetzungUnterkunft($zimmerart_mz_nl,$defaultzimmerart_mz,"nl",$standardsprache,$unterkunft_id,$link);	
	setUebersetzungUnterkunft($zimmerart_mz_es,$defaultzimmerart_mz,"es",$standardsprache,$unterkunft_id,$link);

?>

<table  border="0" cellpadding="0" cellspacing="0" class="frei">
  <tr>
    <td><?php echo(getUebersetzung("Die Daten zu Ihrer Unterkunft wurden geändert.",$sprache,$link)); ?></td>
  </tr>
</table>
<p class="standardSchriftBold">&nbsp;</p>
<table  border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="./index.php" method="post" name="unterkunft aendern" target="_self" id="unterkunft aendern">

        <input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("zurück",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table>
<br/>
<table border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td><form action="../inhalt.php" method="post" name="hauptmenue" target="_self" id="hauptmenue">

        <input name="retour" type="submit" class="button200pxA" id="retour" onMouseOver="this.className='button200pxB';"
	 onMouseOut="this.className='button200pxA';" value="<?php echo(getUebersetzung("Hauptmenü",$sprache,$link)); ?>">
      </form></td>
  </tr>
</table>
<?php 
	} //ende if passwortprüfung
	else {
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
 ?>
</body>
</html>
<?php
} //ende pruefung formular-pflichtfelder
?>