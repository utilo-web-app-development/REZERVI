<? $root = "../..";

/*   
	date: 20.9.05
	author: christian osterrieder utilo.net						
*/

//header einfuegen:
include_once($root."/webinterface/templates/header.inc.php");

//andere funktionen importieren:
include_once($root."/include/vermieterFunctions.inc.php");

//sprachunabh�ngige variablen:
$strasse = $_POST["strasse"];
$plz = $_POST["plz"];
$ort = $_POST["ort"];
$email = $_POST["email"];
$tel = $_POST["tel"];
$tel2 = $_POST["tel2"];
$fax = $_POST["fax"];
$url = $_POST["url"];
$land = $_POST["land"];
$vorname =  $_POST["vorname"];
$nachname=  $_POST["nachname"];

$standardsprache = getVermieterEigenschaftenWert(STANDARDSPRACHE,$vermieter_id);
$fehler = false;

//pruefen ob alle pflichtfelder eingegeben wurden:
if($email == ""){
	$fehler = true;
	$nachricht = getUebersetzung("Bitte geben sie ihre E-Mail-Adresse ein!");
	include_once("./index.php");	
	exit;
}

$ueb_fir = array();
$ueb_mo_ez = array();
$ueb_mo_mz = array();

$res = getActivtedSprachenOfVermieter($vermieter_id);
while ($d = mysql_fetch_array($res)){
	$sprache_id = $d["SPRACHE_ID"];
	
	$firma = false;
	$mo_ez = false;
	$mo_mz = false;
	
	if (isset($_POST["firma_".$sprache_id])){
		$firma = $_POST["firma_".$sprache_id];
	}
	if (isset($_POST["mietobjekt_ez_".$sprache_id])){
		$mo_ez = $_POST["mietobjekt_ez_".$sprache_id];
	}
	if (isset($_POST["mietobjekt_mz_".$sprache_id])){
		$mo_mz = $_POST["mietobjekt_mz_".$sprache_id];
	}

	if ($standardsprache == $sprache_id){
		
		if ($firma == false || $firma == ""){
			$fehler = true;
			$nachricht = getUebersetzung("Bitte geben sie ihren Firmennamen ein!");
			include_once("./index.php");	
			exit;
		}
		else if($mo_ez == false || $mo_ez == ""){
			$fehler = true;
			$nachricht = getUebersetzung("Bitte geben sie die Bezeichnung des Mietobjektes (Einzahl) ein!");
			include_once("./index.php");	
			exit;
		}
		else if($mo_mz == false || $mo_mz == ""){
			$fehler = true;
			$nachricht = getUebersetzung("Bitte geben sie die Bezeichnung des Mietobjektes (Mehrzahl) ein!");
			include_once("./index.php");	
			exit;
		}
		
		$defaultFirma = $firma;
		$defaultMoEz  = $mo_ez;
		$defaultMoMz  = $mo_mz;
		
	} //ende if standardsprache
	
	$ueb_fir[$sprache_id] 	= $firma;
	$ueb_mo_ez[$sprache_id] = $mo_ez;
	$ueb_mo_mz[$sprache_id] = $mo_mz;
	  
}	
	
	//unterkunft �nderung durchf�hren:	
	setVermieterStrasse($vermieter_id,$strasse);
	setVermieterPlz($vermieter_id,$plz);
	setVermieterOrt($vermieter_id,$ort);	
	setVermieterEmail($vermieter_id,$email);
	setVermieterTel($vermieter_id,$tel);
	setVermieterTel2($vermieter_id,$tel2);
	setVermieterVorname($vermieter_id,$vorname);
	setVermieterNachname($vermieter_id,$nachname);
	setVermieterUrl($vermieter_id,$url);
	setVermieterFax($vermieter_id,$fax);	
	setVermieterFirmenname($vermieter_id,$defaultFirma);
	setMietobjekt_EZ($vermieter_id,$defaultMoEz);
	setMietobjekt_MZ($vermieter_id,$defaultMoMz);
	setVermieterLand($vermieter_id,$land);
	
	//uebersetzungen durchfuehren:
	foreach ($ueb_fir as $sprache_id => $firma){
		setUebersetzungVermieter($firma,$defaultFirma,$sprache_id,$standardsprache,$vermieter_id);
	}
	foreach ($ueb_mo_ez as $sprache_id => $mo_ez){
		setUebersetzungVermieter($mo_ez,$defaultMoEz,$sprache_id,$standardsprache,$vermieter_id);
	}
	foreach ($ueb_mo_mz as $sprache_id => $mo_mz){
		setUebersetzungVermieter($mo_mz,$defaultMoMz,$sprache_id,$standardsprache,$vermieter_id);
	}	
	
	$nachricht = "Ihre Daten wurden erfolgreich ver�ndert.";
	$info = true;
	
	include_once($root."/webinterface/templates/bodyStart.inc.php"); 

?>
<table  border="0" cellpadding="0" cellspacing="0" class="<?= TABLE_STANDARD ?>">
  <tr>
    <td>
      <form action="./index.php" method="post" name="Vermieter aendern" target="_self" id="Vermieter aendern">
        <input name="retour" type="submit" class="<?= BUTTON ?>" id="retour" onMouseOver="this.className='<?= BUTTON_HOVER ?>';"
			 onMouseOut="this.className='<?= BUTTON ?>';" value="<?php echo(getUebersetzung("zur�ck")); ?>">
      </form>
    </td>
  </tr>
</table>
<?php
include_once($root."/webinterface/templates/footer.inc.php");
?>