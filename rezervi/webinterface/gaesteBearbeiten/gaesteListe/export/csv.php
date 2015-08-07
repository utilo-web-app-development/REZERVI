<? session_start();
$root = "../../../..";
// Set flag that this is a parent file
define( '_JEXEC', 1 );
include_once($root."/include/sessionFunctions.inc.php");
header("Content-Disposition: attachment; filename=rezerviGuestList.csv");

/*   
	reservierungsplan			
	author: christian osterrieder utilo.eu		
	
	dieser seite muss übergeben werden:
	Unterkunft PK_ID ($unterkunft_id)
*/

$unterkunft_id = getSessionWert(UNTERKUNFT_ID);
$passwort = getSessionWert(PASSWORT);
$benutzername = getSessionWert(BENUTZERNAME);
$anrede_val = $_POST["anrede_val"];
$vorname_val = $_POST["vorname_val"];
$nachname_val = $_POST["nachname_val"];
$strasse_val = $_POST["strasse_val"];
$plz_val = $_POST["plz_val"];
$ort_val = $_POST["ort_val"];
$land_val = $_POST["land_val"];
$email_val = $_POST["email_val"];
$tel_val = $_POST["tel_val"];
$fax_val = $_POST["fax_val"];
$sprache_val = $_POST["anmerkung_val"];
$anmerkung_val = $_POST["anmerkung_val"];
$format = $_POST["format"];
$sprache = getSessionWert(SPRACHE);

//datenbank öffnen:
include_once("../../../../conf/rdbmsConfig.php");
include_once("../../../../include/unterkunftFunctions.php");
include_once("../../../../include/benutzerFunctions.php");
include_once("../../../../include/gastFunctions.php");	
//uebersetzer einfuegen:
include_once("../../../../include/uebersetzer.php");
	
	//passwortprüfung:	
	if (checkPass($benutzername,$passwort,$unterkunft_id,$link)){ 


	//gästeliste ausgeben:	
	$res = getGuestList($unterkunft_id,$link);
		
	while ($d = mysql_fetch_array($res)){
	
		$gast_id = $d["PK_ID"];
		$vorname = $d["Vorname"];
		$nachname = $d["Nachname"];
		$strasse = $d["Strasse"];
		$plz = $d["PLZ"];
		$ort = $d["Ort"];
		$land = $d["Land"];
		$email = $d["EMail"];
		$tel = $d["Tel"];
		$fax = $d["Fax"];
		$anmerkung = $d["Anmerkung"];
		$anrede = $d["Anrede"];	
	
		 if ($anrede_val == "true"){ echo("\"".$anrede."\","); } 
		 if ($vorname_val == "true"){ echo("\"".$vorname."\","); }
		 if ($nachname_val == "true"){ echo("\"".$nachname."\",");}
		 if ($strasse_val == "true"){ echo("\"".$strasse."\","); }
		 if ($plz_val == "true"){ echo("\"".$plz."\",");} 
		 if ($ort_val == "true"){ echo("\"".$ort."\",");} 
		 if ($land_val == "true"){ echo("\"".$land."\",");} 
		 if ($email_val == "true"){ echo("\"".$email."\",");} 
		 if ($tel_val == "true"){ echo("\"".$tel."\",");} 
		 if ($fax_val == "true"){ echo("\"".$fax."\",");} 
		 if ($anmerkung_val == "true"){ echo("\"".$anmerkung."\"");} 
		 echo("\n");
	} //ende while

} //ende passwortprüfung 
else{
		echo(getUebersetzung("Bitte Browser schließen und neu anmelden - Passwortprüfung fehlgeschlagen!",$sprache,$link));
	}
?>