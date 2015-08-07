<?php
/**
 * Created on 05.04.2006
 *
 * author: Christian Osterrieder utilo.net
 * 
 * this page needs the BILDER_ID from the table REZ_GEN_BILDER
 * as an GET Variable (bilder_id)
 */

$root = "..";
$bilder_id = $_GET["bilder_id"];
include_once($root."/conf/rdbmsConfig.inc.php");
include_once($root."/include/bildFunctions.inc.php");
$d = getBild($bilder_id);
$mime = $d["MIME"];

//header erzeugen:
header("Content-type: image/".$mime);

//bild ausgeben:
echo($d["BILD"]);

?>
