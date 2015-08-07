<?php
$root = "../../..";

/*
 * Created on 10.12.2007
 * Author: LI Haitao
 * Company: Alpstein-Austria
 *  
 */
 
include_once($root."/backoffice/templates/functions.php");
include_once($root."/include/mieterFunctions.inc.php");

$gast_id = $_GET["gast_id"];
if (isset($_GET["name"])){
	if($gast_id == "neuerMieter"){
		echo "neuerMieter";
		exit;
	}
	echo strtoupper(getNachnameOfMieter($gast_id))." ".ucfirst(getMieterVorname($gast_id));
	exit;
}
if($gast_id == "neuerMieter"){
	echo "";
	exit;
}
if (isset($_GET["anrede"])){
	echo getMieterAnrede($gast_id);
	exit;
}
if (isset($_GET["vorname"])){
	echo getMieterVorname($gast_id);
	exit;
}
if (isset($_GET["nachname"])){
	echo getNachnameOfMieter($gast_id);
	exit;
}
if (isset($_GET["firma"])){
	echo getMieterFirma($gast_id);
	exit;
}
if (isset($_GET["ort"])){
	echo getMieterOrt($gast_id);
	exit;
}
if (isset($_GET["tel"])){
	echo getMieterTel($gast_id);
	exit;
}
if (isset($_GET["fax"])){
	echo getMieterFax($gast_id);
	exit;
}
if (isset($_GET["email"])){
	echo getEmailOfMieter($gast_id);
	exit;
}
?>
